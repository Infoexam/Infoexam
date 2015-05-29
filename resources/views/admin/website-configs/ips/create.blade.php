@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('website-configs.ips.create')])

    <div>
        {!! Form::open(['route' => 'admin.website-configs.ips.store', 'method' => 'POST']) !!}
            @include('admin.website-configs.ips._form', ['submitButtonText' => trans('general.create')])
        {!! Form::close() !!}
    </div>
@stop