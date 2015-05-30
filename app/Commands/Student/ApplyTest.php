<?php namespace App\Commands\Student;

use App\Commands\Command;
use App\Infoexam\Exam\ExamConfig;
use App\Infoexam\Test\TestList;
use App\Infoexam\Test\TestApply;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApplyTest extends Command implements SelfHandling {
    
    protected $account, $ssn, $error_code;
    
    public function __construct($request, $ssn)
    {
        $this->account = $request->user();
        $this->ssn = $ssn;
        $this->error_code = 0;
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
             * 取得測驗資料
             */
            $test_data = TestList::where('ssn', '=', $this->ssn)
                ->where('test_enable', '=', true)
                ->where('allow_apply', '=', true)
                ->where('apply_type', 'like', '1_%')
                ->firstOrFail();

            /*
             * 檢查使用者是否已通過測驗
             */
            if (ends_with($test_data->test_type, '1'))
            {
                if ($this->account->accreditedData->acad_score >= $exam_configs->acad_passed_score)
                {
                    flash()->error(trans('test-applies.error.already_passed_acad'));

                    return false;
                }
            }
            else if (ends_with($test_data->test_type, '2'))
            {
                if ($this->account->accreditedData->tech_score >= $exam_configs->tech_passed_score)
                {
                    flash()->error(trans('test-applies.error.already_passed_tech'));

                    return false;
                }
            }

            /*
             * 檢查是否在允許預約的時間範圍內
             */
            if ((1 * 86400) > ($test_data->start_time->timestamp - Carbon::now()->startOfDay()->timestamp))
            {
                flash()->error(trans('test-applies.error.too_late_to_apply'));

                return false;
            }
            /*
             * 檢查該測驗是否還有名額
             */
            else if (0 >= $test_data->std_num_limit - $test_data->std_apply_num)
            {
                flash()->error(trans('test-applies.error.test_is_full'));

                return false;
            }

            /*
             * 檢查是否為資工系學生，如是，則檢查是否預約電腦軟體能力類型測驗
             */
            if ('4104' === $this->account->userData->department->code)
            {
                if ( ! starts_with($test_data->test_type, '2'))
                {
                    flash()->error(trans('test-applies.error.is_csie'));

                    return false;
                }
            }

            /*
             * 檢查該測驗是否為特定年級專屬預約
             */
            $specific_grade = explode('_', $test_data->apply_type);

            switch ($specific_grade[1])
            {
                // 大四
                case 2:
                    if ($this->account->userData->grade != 4)
                    {
                        flash()->error(trans('test-applies.error.specific_grade.4'));

                        return false;
                    }
                    break;

                // 大二
                case 3:
                    if ($this->account->userData->grade != 2)
                    {
                        flash()->error(trans('test-applies.error.specific_grade.2'));

                        return false;
                    }
                    break;
            }

            /*
             * 檢查是否重複預約
             */
            if ( ! is_null(TestApply::where('account_id', '=', $this->account->id)->where('test_list_id', '=', $test_data->id)->first(['id'])))
            {
                flash()->error(trans('test-applies.error.apply_the_same_test'));

                return false;
            }

            /*
             * 檢查當週是否已預約過測驗
             */
            $check_time_interval_start = $test_data->start_time;
            $check_time_interval_end = $test_data->start_time;

            $already_apply = TestApply::where('account_id', '=', $this->account->id)
                ->where('test_list_id', '!=', $test_data->id)
                ->leftJoin('test_lists', 'test_applies.test_list_id', '=', 'test_lists.id')
                ->whereBetween('test_lists.start_time', [$check_time_interval_start->startOfWeek(), $check_time_interval_end->endOfWeek()])
                ->count();

            if ($already_apply)
            {
                flash()->error(trans('test-applies.error.already_apply_test_in_same_week'));

                return false;
            }

            /*
             * 檢查是否有缺考紀錄，如有，則一週內禁止預約
             */
            $not_test_apply = TestApply::where('account_id', '=', $this->account->id)
                ->whereNull('test_result_id')
                ->leftJoin('test_lists', 'test_applies.test_list_id', '=', 'test_lists.id')
                ->whereBetween('test_lists.start_time', [Carbon::now()->subWeeks(1)->startOfWeek(), Carbon::now()->endOfWeek()])
                ->count();

            if ($not_test_apply)
            {
                flash()->error(trans('test-applies.error.absent_test'));

                return false;
            }

            $apply['account_id'] = $this->account->id;
            $apply['test_list_id'] = $test_data->id;
            $apply['apply_time'] = Carbon::now();

            /*
             * 檢查是否有免費測驗的額度
             */
            if (ends_with($test_data->test_type, '1') && ($this->account->accreditedData->free_acad > 0))
            {
                $apply['paid_at'] = $now;
            }
            else if (ends_with($test_data->test_type, '2') && ($this->account->accreditedData->free_tech > 0))
            {
                $apply['paid_at'] = $now;
            }
            else
            {
                $apply['paid_at'] = null;
            }

            /*
             * 檢測完畢，新增此預約
             */
            TestApply::create($apply);

            /*
             * 將該測驗目前人數加 1
             */
            $test_data->increment('std_apply_num');

            return true;
        }
        catch (ModelNotFoundException $e)
        {
            flash()->error(trans('test-applies.error.test_not_found'));

            return false;
        }
    }

}
