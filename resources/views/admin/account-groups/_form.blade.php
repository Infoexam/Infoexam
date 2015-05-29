<div class="form-group">
    {!! Form::label('name', trans('account-groups.name')) !!}
    {!!
        Form::text('name', null, [
            'class' => 'form-control',
            'required' => 'required'
        ])
    !!}
</div>

<div class="form-group">
    {!! Form::label('identify', trans('account-groups.identity')).'：' !!}

    <label class="checkbox-inline">
        {!! Form::checkbox('isStudent', true) !!}
        {{ trans('account-groups.isStudent') }}
    </label>

    <label class="checkbox-inline">
        {!! Form::checkbox('isInvigilator', true) !!}
        {{ trans('account-groups.isInvigilator') }}
    </label>

    <label class="checkbox-inline">
        {!! Form::checkbox('isAdmin', true) !!}
        {{ trans('account-groups.isAdmin') }}
    </label>

    <label class="checkbox-inline">
        {!! Form::checkbox('isNoLogin', true) !!}
        {{ trans('account-groups.isNoLogin') }}
    </label>
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>