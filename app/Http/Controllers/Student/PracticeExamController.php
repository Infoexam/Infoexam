<?php namespace App\Http\Controllers\Student;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Exam\ExamPractice;
use App\Infoexam\ExamSet\ExamSetTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PracticeExamController extends Controller {

    public function index()
    {
        $title = trans('practice-exam.title');

        $exam_sets = ExamSetTag::orderBy('name')->get();

        session()->forget('exam_practice');

        session()->flash('exam_practice_check', true);

        return view('student.practice-exam.index', compact('title', 'exam_sets'));
    }

    public function testing($exam_set_tag)
    {
        if (null === session('exam_practice_check'))
        {
            return redirect()->route('student.practice-exam.index');
        }

        try
        {
            $exam_practice = new ExamPractice();

            $exam_practice->setExamSetTag($exam_set_tag);

            $questions = $exam_practice->getQuestions();

            session()->flash('exam_practice', $exam_practice);

            logging(['level' => 'info', 'action' => 'startPracticeExam', 'content' => null, 'remark' => null]);

            return view('student.practice-exam.testing', compact('questions'));
        }
        catch (ModelNotFoundException $e)
        {
            return http_404('student.practice-exam.index');
        }
    }

    public function result(Request $request)
    {
        if (null === ($exam_practice = session('exam_practice')))
        {
            return redirect()->route('student.practice-exam.index');
        }

        $exam_practice->checkAnswer($request->except(['_token']));

        $score = $exam_practice->getScore();

        $questions = $exam_practice->getQuestions();

        session()->forget('exam_practice');

        logging(['level' => 'info', 'action' => 'finishPracticeExam', 'content' => ['score' => $score], 'remark' => null]);

        return view('student.practice-exam.result', compact('score', 'questions'));
    }

}