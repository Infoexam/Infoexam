@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('website-configs.ips.edit')])

    <div>
        {!! Form::model($ip_rule, ['route' => ['admin.website-configs.ips.update', $ip_rule->id], 'method' => 'PATCH']) !!}
            @include('admin.website-configs.ips._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@stop