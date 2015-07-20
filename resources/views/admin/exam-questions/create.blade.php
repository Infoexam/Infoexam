@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('exam-questions.create')])

    <div>
        {!! Form::open(['route' => 'admin.exam-questions.store', 'method' => 'POST', 'files' => true]) !!}
            @include('admin.exam-questions._form', ['submitButtonText' => trans('general.create')])
        {!! Form::close() !!}
    </div>
@endsection