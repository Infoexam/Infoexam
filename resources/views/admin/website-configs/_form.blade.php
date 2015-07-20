<div class="form-group">
    <label>
        {{ trans('website-configs.student_page_maintain_mode').'：' }}
        {!! Form::checkbox('student_page_maintain_mode', true, null, ['data-checkbox-switch']) !!}
    </label>
</div>

<div class="form-group">
    {!! Form::label('student_page_remark', trans('paper-lists.remark')) !!}
    {!! Form::textarea('student_page_remark', null, ['class' => 'form-control', 'rows' => 3]) !!}
</div>

<div class="form-group">
    <label>
        {{ trans('website-configs.exam_page_maintain_mode').'：' }}
        {!! Form::checkbox('exam_page_maintain_mode', true, null, ['data-checkbox-switch']) !!}
    </label>
</div>

<div class="form-group">
    {!! Form::label('exam_page_remark', trans('paper-lists.remark')) !!}
    {!! Form::textarea('exam_page_remark', null, ['class' => 'form-control', 'rows' => 3]) !!}
</div>

<div class="form-group">
    {!! HTML::recaptcha() !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>

@section('scripts')
    <script>
        (function($)
        {
            $(function()
            {
                $('input[data-checkbox-switch]').on('switchChange.bootstrapSwitch', function(event, state) {
                    var page = ('student_page_maintain_mode' === $(this).closest('input').attr('name')) ? 'student_page_remark' : 'exam_page_remark';

                    CKEDITOR.instances[page].setReadOnly( ! state);
                });

                load_or_reset_recaptcha();

                load_js('{{ secure_asset('assets/ckeditor/ckeditor.js') }}', function()
                {
                    CKEDITOR.replace('student_page_remark', {
                        readOnly: ! $('input[name=student_page_maintain_mode]').prop('checked')
                    });
                    CKEDITOR.replace('exam_page_remark', {
                        readOnly: ! $('input[name=exam_page_maintain_mode]').prop('checked')
                    });
                });
            });
        })(jQuery);
    </script>
@endsection