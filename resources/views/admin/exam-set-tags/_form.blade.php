<div class="form-group">
    {!! Form::label('name', trans('exam-set-tags.name')) !!}
    {!!
        Form::text('name', null, [
            'class' => 'form-control',
            'required' => 'true',
            'autofocus' => 'autofocus'
        ])
    !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>