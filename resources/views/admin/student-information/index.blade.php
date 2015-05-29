@extends(env('IS_PJAX') ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('student-information.search')])

    <div>
        {!! Form::open(['route' => 'admin.student-information.search', 'method' => 'GET']) !!}
            <div class="form-group">
                {!!
                    Form::text('username', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('student-information.username')
                    ])
                !!}
            </div>

            <div class="form-group">
                {!!
                    Form::text('name', null, [
                        'class' => 'form-control',
                        'placeholder' => trans('student-information.name')
                    ])
                !!}
            </div>

            <div class="form-group">
                {!! Form::label('department', trans('student-information.specific_dept')) !!}
                {!! Form::select('department', $department_lists, null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <label>
                    {{ trans('student-information.passed').'：' }}
                    {!! Form::checkbox('passed', true) !!}
                </label>
            </div>

            <div class="form-group">
                <label>
                    {{ trans('student-information.non_passed').'：' }}
                    {!! Form::checkbox('non_passed', true) !!}
                </label>
            </div>

            <div class="form-group">
                {!! Form::submit(trans('general.search'), ['class' => 'btn btn-primary form-control']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@stop