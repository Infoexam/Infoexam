@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('announcements.create')])

    <div>
        {!! Form::open(['route' => 'admin.announcements.store', 'method' => 'POST', 'files' => true]) !!}
            @include('admin.announcements._form', ['submitButtonText' => trans('general.create')])
        {!! Form::close() !!}
    </div>
@stop