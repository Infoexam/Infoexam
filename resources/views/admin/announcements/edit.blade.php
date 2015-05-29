@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('announcements.edit')])

    <div>
        {!! Form::model($announcement, ['route' => ['admin.announcements.update', $announcement->id], 'method' => 'PATCH', 'files' => true]) !!}
            @include('admin.announcements._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@stop