@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('website-configs.title')])

    <div>
        {!! Form::model($website_configs, ['route' => 'admin.website-configs.update', 'method' => 'PATCH']) !!}
            @include('admin.website-configs._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@stop