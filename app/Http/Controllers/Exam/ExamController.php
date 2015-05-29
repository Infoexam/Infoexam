<?php namespace App\Http\Controllers\Exam;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Paper\PaperList;
use Illuminate\Http\Request;

class ExamController extends Controller {

    public function panel()
    {

    }

    public function testing()
    {
        $test_data = session('test_ssn');

        if (null === $test_data)
        {
            return redirect()->route('exam.login');
        }

        $questions = PaperList::findOrFail($test_data->paper_list_id)->questions;

        foreach ($questions as &$question)
        {
            $question->setAttribute('options', $question->options);

            $question->options->shuffle();
        }

        $questions->shuffle();

        return view('exam.testing', compact('test_data', 'questions'));
    }

    public function submit()
    {

    }

    public function result()
    {

    }

}
