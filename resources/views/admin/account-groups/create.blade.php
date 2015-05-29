@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('account-groups.create')])

    <div>
        {!! Form::open(['route' => 'admin.account-groups.store', 'method' => 'POST']) !!}
            @include('admin.account-groups._form', ['submitButtonText' => trans('general.create')])
        {!! Form::close() !!}
    </div>
@stop