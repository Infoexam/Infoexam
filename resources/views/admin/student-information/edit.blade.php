@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('student-information.edit')])

    <div>
        {!! Form::model($account, ['route' => ['admin.student-information.update', $account->username], 'method' => 'PATCH']) !!}
            @include('admin.student-information._form', ['submitButtonText' => trans('general.update')])
        {!! Form::close() !!}
    </div>
@stop