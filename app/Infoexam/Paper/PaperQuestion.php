<?php

namespace App\Infoexam\Paper;

use App\Infoexam\Core\Entity;
use App\Infoexam\ExamSet\ExamQuestion;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaperQuestion extends Entity
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'papers_questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ssn', 'paper_list_id', 'exam_question_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $ssn = true;

    public function paper_list()
    {
        return $this->belongsTo('App\Infoexam\Paper\PaperList')
            ->select(['id', 'ssn', 'name', 'remark', 'auto_generate']);
    }

    public static function create(array $attributes = [])
    {
        if ( ! isset($attributes['paper_ssn']) || ! isset($attributes['questions']) || null === ($paper = PaperList::ssn($attributes['paper_ssn'])->first(['id'])))
        {
            return false;
        }

        $questions = ExamQuestion::whereIn('ssn', $attributes['questions'])->get(['id'])->pluck('id')->all();

        $already_exist_questions = PaperQuestion::where('paper_list_id', '=', $paper->id)->get(['exam_question_id'])->pluck('exam_question_id')->all();

        foreach (array_diff($questions, $already_exist_questions) as $question)
        {
            parent::create(['paper_list_id' => $paper->id, 'exam_question_id' => $question]);
        }

        return true;
    }
}