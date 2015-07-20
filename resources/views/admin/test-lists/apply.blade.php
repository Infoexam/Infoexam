@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.heading', ['heading' => trans('test-applies.apply')])

    <div>
        {!! Form::open(['route' => ['admin.test-lists.apply.store', $ssn], 'method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('personal', trans('test-lists.personal_apply')) !!}
                {!! Form::text('personal', null, ['class' => 'form-control', 'placeholder' => trans('user.id')]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('department', trans('test-lists.department_apply')) !!}
                {!! Form::select('department', $department_lists, null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('class', trans('test-lists.department_apply_class')) !!}
                {!! Form::select('class', ['A' => 'A', 'B' => 'B'], null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::submit(trans('general.create'), ['class' => 'btn btn-primary form-control']) !!}
            </div>
        {!! Form::close() !!}

        @include('errors.form')
    </div>
@endsection