@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('paper-lists.edit')])

    <div>
        {!! Form::model($paper, ['route' => ['admin.paper-lists.update', $paper->ssn], 'method' => 'PATCH']) !!}
            @include('admin.paper-lists._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@endsection