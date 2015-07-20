<?php

namespace App\Http\Controllers\Student;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Website\FrequentlyAskedQuestion;

class FrequentlyAskedQuestionsController extends Controller
{
    public function index()
    {
        $title = trans('faqs.list');

        $faqs = FrequentlyAskedQuestion::paginate();

        $faqs->transform(function($faq)
        {
            $faq->image_ssn = $this->explode_image_ssn($faq->image_ssn);

            return $faq;
        });

        return view('student.faqs.index', compact('title', 'faqs'));
    }
}