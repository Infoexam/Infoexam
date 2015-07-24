<?php

namespace App\Jobs\Admin;

use App\Infoexam\Account\Account;
use App\Infoexam\Account\UserDatum;
use App\Infoexam\Exam\ExamConfig;
use App\Infoexam\Test\TestApply;
use App\Infoexam\Test\TestList;
use App\Jobs\Job;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApplyTest extends Job implements SelfHandling
{
    /**
     * HTTP request
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Test ssn.
     *
     * @var string
     */
    protected $ssn;

    /**
     * Create a new job instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $ssn
     */
    public function __construct($request, $ssn)
    {
        $this->request = $request;

        $this->ssn = $ssn;
    }

    /**
     * Execute the job.
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

            // 測驗資料
            $test_data = TestList::where('ssn', '=', $this->ssn)
                ->where('test_enable', '=', true)
                ->firstOrFail();

            /*
             * 檢查測驗是否結束
             */
            if ($now > $test_data->end_time)
            {
                flash()->error(trans('test-applies.error.too_late_to_apply'));

                return false;
            }

            /*
             * 取得學生資料
             */
            if ($personal = strlen($this->request->input('personal')))
            {
                $students = [
                    Account::where('username', '=', $this->request->input('personal'))->firstOrFail()->userData
                ];
            }
            else
            {
                $students = UserDatum::where('grade', '=', 2)
                    ->where('department_id', '=', $this->request->input('department'))
                    ->where('class', '=', $this->request->input('class'))
                    ->get();
            }

            $test_type = explode('_', $test_data->test_type);

            array_walk($test_type, function(&$value)
            {
                $value = intval($value);
            });

            foreach ($students as $student) {
                /*
                 * 檢查目前學生是否已通過測驗
                 */
                switch ($test_type[1])
                {
                    // 學科
                    case 1:
                        if ($student->account->accreditedData->acad_score >= $exam_configs->acad_passed_score)
                        {
                            continue;
                        }
                        break;

                    // 術科
                    case 2:
                        if ($student->account->accreditedData->tech_score >= $exam_configs->tech_passed_score)
                        {
                            continue;
                        }
                        break;
                }

                /*
                 * 檢查是否為資工系學生，如是，則檢查是否預約電腦軟體能力類型測驗
                 */
                if (('4104' === $student->department->code) && (2 !== $test_type[0]))
                {
                    continue;
                }

                /*
                 * 檢查是否重複預約
                 */
                if (TestApply::where('account_id', '=', $student->account->id)->where('test_list_id', '=', $test_data->id)->count(['id']))
                {
                    continue;
                }

                /*
                 * 檢查當週是否已預約過測驗
                 */
                $check_time_interval_start = $test_data->start_time;

                $check_time_interval_end = $test_data->start_time;

                $already_apply = TestApply::where('account_id', '=', $student->account->id)
                    ->leftJoin('test_lists', 'test_applies.test_list_id', '=', 'test_lists.id')
                    ->where('test_applies.test_list_id', '!=', $test_data->id)
                    ->whereBetween('test_lists.start_time', [$check_time_interval_start->startOfWeek(), $check_time_interval_end->endOfWeek()])
                    ->count();

                if ($already_apply)
                {
                    continue;
                }

                $apply['account_id'] = $student->account->id;
                $apply['test_list_id'] = $test_data->id;
                $apply['apply_time'] = Carbon::now();

                /*
                 * 檢查是否有免費測驗的額度
                 */
                if (0 === $personal)
                {
                    $apply['paid_at'] = $now;
                }
                else if ((1 === $test_type[1]) && ($student->account->accreditedData->free_acad > 0))
                {
                    $apply['paid_at'] = $now;
                }
                else if ((2 === $test_type[1]) && ($student->account->accreditedData->free_tech > 0))
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
            }

            return true;
        }
        catch (ModelNotFoundException $e)
        {
            flash()->error(trans('test-applies.error.test_not_found'));

            return false;
        }
    }
}