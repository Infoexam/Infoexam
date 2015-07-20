@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('exam-sets.edit')])

    <div>
        {!! Form::model($exam_set, ['route' => ['admin.exam-sets.update', $exam_set->ssn], 'method' => 'PATCH']) !!}
            @include('admin.exam-sets._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@endsection