<?php namespace App\Infoexam\Paper;

use App\Infoexam\Core\Entity;
use App\Infoexam\ExamSet\ExamQuestion;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaperQuestion extends Entity {

    use SoftDeletes;

    protected $table = 'papers_questions';

    protected $fillable = ['ssn', 'paper_list_id', 'exam_question_id'];

    protected $dates = ['deleted_at'];

    protected $ssn = true;

    public function paper_list()
    {
        return $this->belongsTo('App\Infoexam\Admin\PaperList');
    }

    public static function create(array $attributes = [])
    {
        if ( ! isset($attributes['paper_ssn']) || ! isset($attributes['questions']) || null === ($paper = PaperList::where('ssn', '=', $attributes['paper_ssn'])->first(['id'])))
        {
            return false;
        }

        $questions = ExamQuestion::whereIn('ssn', $attributes['questions'])->get(['id']);

        foreach ($questions as &$question)
        {
            $check_repeat = PaperQuestion::where('paper_list_id', '=', $paper->id)
                ->where('exam_question_id', '=', $question->id)
                ->first();

            if (null !== $check_repeat)
            {
                continue;
            }

            parent::create(['paper_list_id' => $paper->id, 'exam_question_id' => $question->id]);
        }

        return true;
    }

}
