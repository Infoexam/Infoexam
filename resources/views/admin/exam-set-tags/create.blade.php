@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('exam-set-tags.create')])

    <div>
        {!! Form::open(['route' => 'admin.exam-set-tags.store', 'method' => 'POST']) !!}
            @include('admin.exam-set-tags._form', ['submitButtonText' => trans('general.create')])
        {!! Form::close() !!}
    </div>
@endsection