<?php namespace App\Commands\Student;

use App\Commands\Command;
use App\Infoexam\Exam\ExamConfig;
use App\Infoexam\Test\TestApply;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CancelTestApply extends Command implements SelfHandling {

    /**
     * Account data.
     *
     * @var \App\Infoexam\Account\Account
     */
    protected $account;

    /**
     * Test ssn.
     *
     * @var string
     */
    protected $ssn;

    /**
     * Create a new command instance.
     *
     * @param \App\Infoexam\Account\Account $account
     * @param string $ssn
     */
    public function __construct($account, $ssn)
    {
        $this->account = $account;

        $this->ssn = $ssn;
    }

    /**
     * Execute the command.
     *
     * @return boolean
     */
    public function handle()
    {
        try
        {
            // 目前時間
            $now = Carbon::now();

            // 考試設定檔
            $exam_configs = ExamConfig::firstOrFail();

            // 報名資料
            $test_data = TestApply::where('ssn', '=', $this->ssn)
                ->where('account_id', '=', $this->account->id)
                ->whereNull('test_result_id')
                ->firstOrFail(['id', 'test_list_id']);

            /*
             * 檢查測驗是否啟用
             */
            if ( ! $test_data->test_list->test_type)
            {
                flash()->error(trans('test-applies.error.invalid_apply'));

                return false;
            }

            /*
             * 檢查是否在允許取消的時間範圍內
             */
            if ($test_data->test_list->start_time->startOfDay()->subDays($exam_configs->latest_cancel_apply_day)->timestamp < $now->startOfDay()->timestamp)
            {
                flash()->error(trans('test-applies.error.too_late_to_cancel_apply', ['days' => $exam_configs->latest_cancel_apply_day]));

                return false;
            }

            /*
             * 將該測驗目前人數減 1
             */
            $test_data->test_list->decrement('std_apply_num');

            logging(['level' => 'info', 'action' => 'cancelApply', 'content' => ['ssn' => $this->ssn, 'test_list_id' => $test_data->test_list_id], 'remark' => null]);

            /*
             * 檢測完畢，刪除此預約
             */
            $test_data->delete();

            return true;
        }
        catch (ModelNotFoundException $e)
        {
            flash()->error(trans('test-applies.error.invalid_apply'));

            return false;
        }
    }

}