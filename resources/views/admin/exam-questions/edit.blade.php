@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('exam-questions.edit')])

    <div>
        {!! Form::model($question, ['route' => ['admin.exam-questions.update', $question->ssn], 'method' => 'PATCH', 'files' => true]) !!}
            @include('admin.exam-questions._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@stop