<?php

namespace App\Infoexam\Exam;

use App\Infoexam\ExamSet\ExamSetTag;

class ExamPractice extends ExamHandler
{
    /**
     * The exam set tag.
     *
     * @var string
     */
    protected $exam_set_tag;

    /**
     * Set $exam_set_tag.
     *
     * @param string $exam_set_tag
     */
    public function setExamSetTag($exam_set_tag = null)
    {
        $this->exam_set_tag = $exam_set_tag;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuestions()
    {
        if (null !== $this->questions)
        {
            return $this->questions;
        }

        $questions = collect();

        foreach (ExamSetTag::where('name', '=', $this->exam_set_tag)->firstOrFail()->exam_sets as $exam_set)
        {
            $questions = $questions->merge($exam_set->questions()->with('options')->get());
        }

        $questions = $questions->shuffle();

        $this->checkExceedRange($questions);

        $this->setAttributes($questions);

        $this->questions = $questions;

        return $questions;
    }

    /**
     * Remove excess items.
     *
     * @param \Illuminate\Support\Collection $questions
     */
    protected function checkExceedRange(&$questions)
    {
        if (($exceed = $questions->count() - 50) > 0)
        {
            while ($exceed--)
            {
                $questions->pop();
            }
        }

        $this->question_number = $questions->count();
    }
}