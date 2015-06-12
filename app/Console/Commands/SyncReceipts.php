<?php

namespace App\Console\Commands;

use App\Infoexam\Account\Account;
use App\Infoexam\Account\AccreditedDatum;
use App\Infoexam\Account\Receipt;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use InvalidArgumentException;

class SyncReceipts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:receipts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the receipts.';

    /**
     * Database connection.
     *
     * @var \Illuminate\Database\Connection|null
     */
    protected $connection;

    /**
     * Table name.
     *
     * @var string|null
     */
    protected $table_mt;

    /**
     * Table name.
     *
     * @var string|null
     */
    protected $table_dt;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->table_mt = env('DB_PG_ACC_TABLE_MT');

        $this->table_dt = env('DB_PG_ACC_TABLE_DT');

        try
        {
            $this->connection = \DB::connection('pgsql_acc');
        }
        catch (InvalidArgumentException $e)
        {
            $this->connection = null;
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (null === $this->table_mt || null === $this->table_dt || null === $this->connection)
        {
            return;
        }

        $yesterday = Carbon::yesterday();

        $time_format = ($yesterday->year - 1911) . $yesterday->format('md');

        $receipts = $this->connection->table($this->table_mt)
            ->where('receipt_date', '=', $time_format)
            ->leftJoin($this->table_dt, $this->table_mt . '.receipt_no', '=', $this->table_dt . '.receipt_no')
            ->where('acc5_cd', '=', '422Y-300')
            ->get();

        array_walk($receipts, function($receipt)
        {
            $receipt->username = substr($receipt->payer_name, (strpos($receipt->payer_name, ':') + 1), -1);
        });

        $accounts = [];

        Account::whereIn('username', array_pluck($receipts, 'username'))->get(['id', 'username'])->each(function($receipt) use(&$accounts)
        {
            $accounts[$receipt->username] = $receipt->id;
        });

        foreach ($receipts as $receipt)
        {
            $data = [
                'receipt_no' => $receipt->receipt_no,
                'receipt_date' => $time_format,
                'account_id' => (isset($accounts[$receipt->username]) ? $accounts[$receipt->username] : null),
                'type' => (str_contains($receipt->note, '學科') ? 1 : 2),
            ];

            $log = [
                'level' => '',
                'action' => 'syncReceipt',
                'content' => [
                    'receipt_no' => $receipt->receipt_no,
                ],
                'remark' => null,
            ];

            try
            {
                if ( ! Receipt::create($data)->exists)
                {
                    $log['level'] = 'warning';
                }
                else if ( ! isset($accounts[$receipt->username]))
                {
                    $log['level'] = 'warning';
                    $log['content']['username'] = $receipt->username;
                }
                else
                {
                    $log['level'] = 'info';

                    AccreditedDatum::where('account_id', '=', $accounts[$receipt->username])
                        ->increment((1 === $data['type']) ? 'free_acad' : 'free_tech');
                }

                logging($log, 1);
            }
            catch (QueryException $e)
            {
                ;   // 該筆紀錄已存在，忽略不做任何事
            }
        }
    }
}