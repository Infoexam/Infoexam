<div class="form-group">
    {!! Form::label('name', trans('exam-sets.name')) !!}
    {!!
        Form::text('name', null, [
            'class' => 'form-control',
            'placeholder' => trans('exam-sets.name.title', ['min' => '3', 'max' => '32']),
            'pattern' => '.{3,32}',
            'title' => trans('exam-sets.name.title', ['min' => '3', 'max' => '32']),
            'required' => 'true'
        ])
    !!}
</div>

<div class="form-group">
    {!! Form::label('category', trans('exam-sets.category')) !!}
    {!! Form::select('category', ['A' => trans('exam-sets.application'), 'S' => trans('exam-sets.software')], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label>
        {{ trans('exam-sets.set_enable').'：' }}
        {!! Form::checkbox('set_enable', true, null, ['data-checkbox-switch']) !!}
    </label>
</div>

<div class="form-group">
    <label>
        {{ trans('exam-sets.open_practice').'：' }}
        {!! Form::checkbox('open_practice', true, null, ['data-checkbox-switch']) !!}
    </label>
</div>

<div class="form-group">
    {!! Form::label('exam_set_tag_list', 'Tags') !!}
    {!! Form::select('exam_set_tag_list[]', $exam_set_tags, null, ['id' => 'exam_set_tag_list', 'class' => 'form-control', 'multiple']) !!}
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
                load_css('{{ secure_asset('assets/select2/select2.min.css') }}');
                load_js('{{ secure_asset('assets/select2/select2.min.js') }}', function()
                {
                    $('#exam_set_tag_list').select2();
                });
            });
        })(jQuery);
    </script>
@endsection