<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Infoexam\Image;
use App\Infoexam\Website\FrequentlyAskedQuestion;
use Illuminate\Http\Request;

class FrequentlyAskedQuestionsController extends Controller
{
    public function index()
    {
        $title = trans('faqs.list');

        $faqs = FrequentlyAskedQuestion::paginate(10);

        $faqs->transform(function($faq)
        {
            $faq->image_ssn = $this->explode_image_ssn($faq->image_ssn);

            return $faq;
        });

        return view('admin.faqs.index', compact('title', 'faqs'));
    }

    public function create()
    {
        $title = trans('faqs.create');

        return view('admin.faqs.create', compact('title'));
    }

    public function store(Requests\Admin\FrequentlyAskedQuestionsRequest $request)
    {
        if ( ! FrequentlyAskedQuestion::create($request->all())->exists)
        {
            return back()->withInput();
        }

        return redirect()->route('admin.faqs.index');
    }

    public function edit($id)
    {
        if (null === ($faq = FrequentlyAskedQuestion::find($id)))
        {
            return http_404('admin.faqs.index');
        }

        $title = trans('faqs.edit');

        $faq->image_ssn = $this->explode_image_ssn($faq->image_ssn);

        return view('admin.faqs.edit', compact('title', 'faq'));
    }

    public function update(Requests\Admin\FrequentlyAskedQuestionsRequest $request, $id)
    {
        if (null === ($faq = FrequentlyAskedQuestion::find($id)))
        {
            return http_404();
        }
        else if ( ! $faq->update($request->all()))
        {
            return back()->withInput();
        }

        return redirect()->route('admin.faqs.index');
    }

    public function destroy($id)
    {
        if (null === ($faq = FrequentlyAskedQuestion::find($id)))
        {
            http_404();
        }
        else
        {
            $faq->delete();
        }

        return redirect()->route('admin.faqs.index');
    }

    public function destroy_images($id)
    {
        if (null === ($faq = FrequentlyAskedQuestion::find($id)))
        {
            http_404();
        }
        else if (null !== $faq->image_ssn)
        {
            Image::whereIn('ssn', $this->explode_image_ssn($faq->image_ssn))->delete();

            $faq->update(['image_ssn' => null]);
        }

        return redirect()->route('admin.faqs.index');
    }
}