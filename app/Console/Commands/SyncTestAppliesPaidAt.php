<?php

namespace App\Console\Commands;

use App\Infoexam\Test\TestList;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncTestAppliesPaidAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:test-applies-paid-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync user\'s applies paid at filed.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now();

        $test_lists = TestList::with(['applies', 'applies.account.accreditedData'])
            ->where('start_time', '>', $now)
            ->where('apply_type', '!=', '2\_%')
            ->get();

        foreach ($test_lists as $test)
        {
            switch (intval(explode('_', $test->test_type)[1]))
            {
                case 1:
                    $free_type = 'free_acad';
                    break;
                case 2:
                    $free_type = 'free_tech';
                    break;
                default:
                    continue 2;
            }

            foreach ($test->applies as $apply)
            {
                $log = false;

                $free = $apply->account->accreditedData->$free_type;

                if ($free > 0 && null === $apply->paid_at)
                {
                    $apply->paid_at = $now;

                    $log = true;
                }
                else if (0 === $free && null !== $apply->paid_at)
                {
                    $apply->paid_at = null;

                    $log = true;
                }

                $apply->save();

                if ($log)
                {
                    logging([
                        'level' => 'info',
                        'action' => 'syncTestApplyPaidAt',
                        'content' => [
                            'ssn' => $apply->ssn
                        ],
                        'remark' => null
                    ], 1);
                }
            }
        }
    }
}