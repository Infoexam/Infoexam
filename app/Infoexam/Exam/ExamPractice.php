<?php namespace App\Infoexam\Exam;

use App\Infoexam\ExamSet\ExamSetTag;

class ExamPractice {

    /**
     * The exam set tag.
     *
     * @var string
     */
    protected $exam_set_tag;

    /**
     * This practice questions.
     *
     * @var string|null
     */
    protected $questions = null;

    /**
     * Total question number.
     *
     * @var integer
     */
    protected $question_number = 0;

    /**
     * Number of correct answers.
     *
     * @var integer
     */

    protected $correct = 0;

    /**
     * This practice score.
     *
     * @var float
     */
    protected $score = 0.0;

    /**
     * Set $exam_set_tag.
     *
     * @param  string  $exam_set_tag
     */
    public function setExamSetTag($exam_set_tag = null)
    {
        $this->exam_set_tag = $exam_set_tag;
    }

    /**
     * Get all exam sets' questions.
     *
     * @return \Illuminate\Support\Collection $questions
     */
    public function getQuestions()
    {
        if (null !== $this->questions)
        {
            return $this->questions;
        }

        $questions = collect();

        foreach (ExamSetTag::where('name', '=', $this->exam_set_tag)->firstOrFail()->exam_sets as &$exam_set)
        {
            $questions = $questions->merge($exam_set->questions()->with('options')->get());
        }

        $questions->shuffle();

        $this->checkExceedRange($questions);

        $this->setOptionsImageSsnAttribute($questions);

        $this->questions = $questions;

        return $questions;

    }

    /**
     * Remove item if it exceed the limit.
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

    /**
     * Set each question's options.
     *
     * @param \Illuminate\Support\Collection $questions
     */
    protected function setOptionsImageSsnAttribute(&$questions)
    {
        $questions->transform(function($question)
        {
            $answer = [];

            foreach (unserialize($question->answer) as &$value)
            {
                $answer[] = $question->options[$value-1]->ssn;
            }

            $question->setAttribute('answer', $answer);

            $question->options->transform(function($option)
            {
                if (null !== $option->image_ssn)
                {
                    $option->image_ssn = explode(',', $option->image_ssn);
                }

                return $option;
            });

            $question->options->shuffle();

            return $question;
        });
    }

    public function checkAnswer(array $answers = [])
    {
        if (null !== $this->questions && $this->question_number > 0)
        {
            foreach ($this->questions as &$question)
            {
                foreach ($question->answer as $answer)
                {
                    if ($answer === $answers[$question->ssn])
                    {
                        ++$this->correct;
                    }
                }
            }

            $this->score = 100 * $this->correct / $this->question_number;
        }
    }

    public function getScore()
    {
        return round($this->score, 3);
    }
}