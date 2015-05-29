<?php namespace App\Commands\Student;

use App\Commands\Command;

use App\Infoexam\Exam\ExamConfig;
use App\Infoexam\Student\TestApply;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CancelTestApply extends Command implements SelfHandling {

    protected $account, $ssn;

    public function __construct($request, $ssn)
    {
        $this->account = $request->user();
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
            /*
             * 初始化資料
             */
            $now = Carbon::now();   // 目前時間
            $exam_configs = ExamConfig::firstOrFail();

            /*
             * 取得申請資料
             */
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
             * 檢查測驗是否已開始
             */
            if ($now >= $test_data->test_list->start_time)
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
             * 檢測完畢，刪除此預約
             */
            $test_data->delete();

            /*
             * 將該測驗目前人數減 1
             */
            $test_data->test_list->decrement('std_apply_num');

            return true;
        }
        catch (ModelNotFoundException $e)
        {
            flash()->error(trans('test-applies.error.invalid_apply'));

            return false;
        }
    }

}
