@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('paper-lists.create')])

    <div>
        {!! Form::open(['route' => 'admin.paper-lists.store', 'method' => 'POST']) !!}
            @include('admin.paper-lists._form', ['submitButtonText' => trans('general.create')])
        {!! Form::close() !!}
    </div>
@stop