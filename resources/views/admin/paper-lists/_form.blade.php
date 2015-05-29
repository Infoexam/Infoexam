<div class="form-group">
    {!! Form::label('name', trans('paper-lists.name')) !!}
    {!!
        Form::text('name', null, [
            'class' => 'form-control',
            'placeholder' => trans('paper-lists.name.title', ['min' => '3', 'max' => '32']),
            'pattern' => '.{3,32}',
            'title' => trans('paper-lists.name.title', ['min' => '3', 'max' => '32']),
            'required' => 'required',
            'autofocus' => 'autofocus'
        ])
    !!}
</div>

<div class="form-group">
    {!! Form::label('remark', trans('paper-lists.remark')) !!}
    {!! Form::textarea('remark', null, [
            'class' => 'form-control',
            'rows' => 4
    ]) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>