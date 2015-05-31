<?php namespace App\Commands\Admin;

use App\Commands\Command;
use App\Infoexam\ExamSet\ExamSet;
use App\Infoexam\Paper\PaperList;
use App\Infoexam\Paper\PaperQuestion;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AutoGeneralPaper extends Command implements SelfHandling {

    protected $exam_sets, $level, $number;

    /**
     * Create a new command instance.
     */
    public function __construct(array $exam_sets = [], $level = 2, $number = 50)
    {
        $this->exam_sets = $exam_sets;
        $this->level = $level;
        $this->number = $number;
    }

    /**
     * Execute the command.
     *
     * @return integer|boolean
     */
    public function handle()
    {
        try
        {
            $questions = [];

            foreach ($this->exam_sets as $exam_set)
            {
                $lists = ExamSet::where('ssn', '=', $exam_set)->firstOrFail();

                /*
                 * 判斷是否指定難度
                 */
                if (0 == $this->level)
                {
                    $lists = $lists->questions;
                }
                else
                {
                    $lists = $lists->questions()->where('level', '=', $this->level)->get();
                }

                /*
                 * 將該題庫所有題目新增至 questions 陣列
                 */

                $questions = array_merge($questions, array_column($lists->toArray(), 'ssn'));
            }

            /*
             * 如果題目數小於該測驗題目數則 return false 並新增錯誤訊息
             */
            if (($count = count($questions)) < $this->number)
            {
                flash()->error(trans('test-lists.question_insufficient', ['number' => count($questions)]));

                return false;
            }

            $paper_list = PaperList::create(['name' => 'Auto General Paper - '.(Carbon::now()->toDateTimeString()), 'auto_generate' => true]);

            if ( ! $paper_list->exists)
            {
                flash()->error('Generate paper failed.');

                return false;
            }

            /*
             * 隨機選題
             */
            $selected = [];

            while ($this->number--)
            {
                $rand_num = mt_rand(0, $count-1);

                $selected[] = $questions[$rand_num];

                array_splice($questions, $rand_num, 1);

                --$count;
            }

            /*
             * 將題目新增到試卷中
             */
            PaperQuestion::create(['paper_ssn' => $paper_list->ssn, 'questions' => $selected]);

            return $paper_list->id;
        }
        catch (ModelNotFoundException $e)
        {
            return false;
        }
    }

}