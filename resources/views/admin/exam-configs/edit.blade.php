@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('exam-configs.title')])

    <div>
        {!! Form::model($exam_configs, ['route' => 'admin.exam-configs.update', 'method' => 'PATCH']) !!}
            @include('admin.exam-configs._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@endsection