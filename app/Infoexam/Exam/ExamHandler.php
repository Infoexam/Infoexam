<?php

namespace App\Infoexam\Exam;

abstract class ExamHandler
{
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
     * This practice questions.
     *
     * @var string|null
     */
    protected $questions = null;

    /**
     * Set each question's attributes.
     *
     * @param \Illuminate\Support\Collection|\App\Infoexam\ExamSet\ExamQuestion $questions
     * @return void
     */
    protected function setAttributes(&$questions)
    {
        $questions->transform(function($question)
        {
            $question->setAttribute('answer', unserialize($question->answer));

            $answer = [];

            foreach ($question->answer as $value)
            {
                $answer[] = $question->options[$value-1]->ssn;
            }

            $question->setAttribute('answer_ssn', $answer);

            $question->options->transform(function($option)
            {
                if (null !== $option->image_ssn)
                {
                    $option->setAttribute('image_ssn', explode(',', $option->image_ssn));
                }

                return $option;
            });

            $question->setAttribute('options', $question->options->shuffle());

            return $question;
        });
    }

    /**
     * Check the answers.
     *
     * @param array $answers
     * @return void
     */
    public function checkAnswer(array $answers = [])
    {
        if (null !== $this->questions && $this->question_number > 0)
        {
            foreach ($this->questions as $question)
            {
                if (isset($answers[$question->ssn]))
                {
                    if ($question->multiple)
                    {
                        $correct = count(array_diff($question->answer_ssn, $answers[$question->ssn]));

                        $wrong = count(array_diff($answers[$question->ssn], $question->answer_ssn));

                        $this->correct += 1 - 0.5 * ($correct + $wrong);

                        $question->setAttribute('correct', (0 === ($correct + $wrong)));
                    }
                    else
                    {
                        foreach ($question->answer_ssn as $answer)
                        {
                            if ($answer === $answers[$question->ssn])
                            {
                                ++$this->correct;

                                $question->setAttribute('correct', true);
                            }
                        }
                    }
                }
            }

            $this->score = max(100 * $this->correct / $this->question_number, 0);
        }
    }

    /**
     * Get score.
     *
     * @return float
     */
    public function getScore()
    {
        return round($this->score, 3);
    }

    /**
     * Get exam questions.
     *
     * @return \Illuminate\Support\Collection|\App\Infoexam\ExamSet\ExamQuestion
     */
    abstract public function getQuestions();
}