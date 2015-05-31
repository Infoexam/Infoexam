<?php namespace App\Commands\Student;

use App\Commands\Command;
use App\Infoexam\Exam\ExamConfig;
use App\Infoexam\Test\TestList;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransformTestApply extends Command implements SelfHandling {

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
     * @return bool
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
                ->where('allow_apply', '=', true)
                ->where('apply_type', 'like', '2\_%')
                ->firstOrFail();

            // 使用者目前已預約的測驗
            $test_applies = $this->account->applies
                ->filter(function($item) use ($test_data, $now)
                {
                    return (starts_with($item->test_list->apply_type, '2_'))
                    && ($item->test_list->test_type === $test_data->test_type)
                    && ($item->test_list->ssn !== $this->ssn)
                    && ($item->test_list->start_time->startOfDay() > $now);
                });

            if (1 !== $test_applies->count())
            {
                flash()->error(trans('test-applies.transform.failed'));

                return false;
            }

            $apply = $test_applies->shift();

            logging(['level' => 'info', 'action' => 'transformTestApply', 'content' => ['ssn' => $apply->ssn, 'from' => $apply->test_list_id, 'to' => $test_data->id], 'remark' => null]);

            $apply->test_list->decrement('std_apply_num');

            $apply->test_list_id = $test_data->id;

            $apply->save();

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