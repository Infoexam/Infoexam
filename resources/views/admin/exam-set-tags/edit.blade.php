@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('exam-set-tags.edit')])

    <div>
        {!! Form::model($tag, ['route' => ['admin.exam-set-tags.update', $tag->name], 'method' => 'PATCH']) !!}
            @include('admin.exam-set-tags._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@stop