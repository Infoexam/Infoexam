<?php

namespace App\Infoexam\Exam;

use App\Infoexam\Paper\PaperList;
use App\Infoexam\Test\TestList;

class ExamTest extends ExamHandler
{
    /**
     * @var \App\Infoexam\Test\TestList $testList
     */
    protected $testList;

    /**
     * Create a new ExamTest instance.
     *
     * @param \App\Infoexam\Test\TestList $testList
     */
    public function __construct(TestList $testList)
    {
        $this->testList = $testList;
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

        $questions = PaperList::with(['questions', 'questions.options'])
            ->findOrFail($this->testList->paper_list_id)
            ->questions;

        foreach ($questions as &$question)
        {
            $question->options = $question->options->shuffle();
        }

        $questions = $questions->shuffle();

        $this->setAttributes($questions);

        $this->questions = $questions;

        $this->question_number = $questions->count();

        return $questions;
    }
}