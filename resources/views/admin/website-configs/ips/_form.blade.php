<div class="form-group">
    {!! Form::label('ip', trans('website-configs.ips.ip')) !!}
    {!! Form::text('ip', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label>
        {{ trans('website-configs.ips.student_page').'：' }}
        {!! Form::checkbox('student_page', true, null, ['data-checkbox-switch', 'data-on-text' => 'Allow', 'data-off-text' => 'Deny']) !!}
    </label>
</div>

<div class="form-group">
    <label>
        {{ trans('website-configs.ips.exam_page').'：' }}
        {!! Form::checkbox('exam_page', true, null, ['data-checkbox-switch', 'data-on-text' => 'Allow', 'data-off-text' => 'Deny']) !!}
    </label>
</div>

<div class="form-group">
    <label>
        {{ trans('website-configs.ips.admin_page').'：' }}
        {!! Form::checkbox('admin_page', true, null, ['data-checkbox-switch', 'data-on-text' => 'Allow', 'data-off-text' => 'Deny']) !!}
    </label>
</div>

<div class="form-group">
    {!! HTML::recaptcha() !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>

@section('scripts')
    <script>
        $(function()
        {
            load_or_reset_recaptcha();
        });
    </script>
@stop