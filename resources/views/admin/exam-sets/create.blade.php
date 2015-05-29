@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('exam-sets.create')])

    <div>
        {!! Form::open(['route' => 'admin.exam-sets.store', 'method' => 'POST']) !!}
            @include('admin.exam-sets._form', ['submitButtonText' => trans('general.create')])
        {!! Form::close() !!}
    </div>
@stop