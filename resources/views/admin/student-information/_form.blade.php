<div class="form-group">
    {!! Form::label('username', trans('student-information.username')).'：' !!}
    {{ $account->username }}
</div>

<div class="form-group">
    <button type="button" data-target="update-password" class="btn btn-primary btn-xs">{{ trans('student-information.update_password') }}</button>

    <div id="update-password">
        <div class="form-group">
            {!! Form::label('new_password', trans('student-information.new_password')) !!}
            {!! Form::password('new_password', ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('new_password_confirmation', trans('student-information.new_password_confirmation')) !!}
            {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('group_list', trans('student-information.groups')) !!}
    {!! Form::select('group_list[]', $groups, null, ['id' => 'group_list', 'class' => 'form-control', 'multiple']) !!}
</div>

<hr>

<div class="form-group">
    {!! Form::label('name', trans('student-information.name')) !!}
    {!! Form::text('name', $account->user_data->name, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('email', trans('student-information.email')) !!}
    {!! Form::email('email', $account->user_data->email, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('gender', trans('student-information.gender')).'：' !!}
    {{ ('M' === $account->user_data->gender) ? '男' : '女' }}
</div>

<div class="form-group">
    {!! Form::label('department', trans('student-information.department')).'：' !!}
    {{ $account->user_data->department->name }}
</div>

<div class="form-group">
    {!! Form::label('grade', trans('student-information.grade')).'：' !!}
    {{ $account->user_data->grade }}
</div>

<div class="form-group">
    {!! Form::label('class', trans('student-information.class')).'：' !!}
    {{ $account->user_data->class }}
</div>

<hr>

<div class="form-group">
    {!! Form::label('free_acad', trans('student-information.free_acad')) !!}
    {!! Form::input('number', 'free_acad', $account->accredited_data->free_acad, ['class' => 'form-control', 'min' => 0, 'max' => '127']) !!}
</div>

<div class="form-group">
    {!! Form::label('free_tech', trans('student-information.free_tech')) !!}
    {!! Form::input('number', 'free_tech', $account->accredited_data->free_tech, ['class' => 'form-control', 'min' => 0, 'max' => '127']) !!}
</div>

<div class="form-group">
    {!! Form::label('test_count', trans('student-information.test_count')).'：' !!}
    {{ $account->accredited_data->test_count }}
</div>

<div class="form-group">
    {!! Form::label('academic_score', trans('student-information.acad_score')).'：' !!}
    {{ (null === $account->accredited_data->acad_score) ? '無資料' : $account->accredited_data->acad_score }}
</div>

<div class="form-group">
    {!! Form::label('technical_score', trans('student-information.tech_score')).'：' !!}
    {{ (null === $account->accredited_data->tech_score) ? '無資料' : $account->accredited_data->tech_score }}
</div>

<div class="form-group">
    {!! Form::label('pass_time', trans('student-information.pass_time')).'：' !!}
    {{ (null === $account->accredited_data->passed_time) ? '無資料' : $account->accredited_data->passed_time }}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>

@section('scripts')
    <script>
        $(function()
        {
            $('#update-password').hide();

            $('button[data-target="update-password"]').click(function()
            {
                $('#update-password').show(250);
                $(this).hide();
            });

            load_css('{{ secure_asset('assets/select2/select2.min.css') }}');
            load_js('{{ secure_asset('assets/select2/select2.min.js') }}', function()
            {
                $('#group_list').select2();
            });
        });
    </script>
@stop