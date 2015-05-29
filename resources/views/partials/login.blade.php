<div class="login">
    {!! Form::open(['route' => $route, 'method' => 'POST', 'data-no-pjax']) !!}
        <div class="form-group">
            {!!
                Form::text('username', null, [
                    'class' => 'form-control',
                    'placeholder' => trans('general.username'),
                    'maxlength' => '32',
                    'required' => 'required',
                    'autofocus' => 'autofocus',
                    'autocomplete' => 'off'
                ])
            !!}
        </div>
        <div class="form-group">
            {!!
                Form::password('password', [
                    'class' => 'form-control',
                    'placeholder' => trans('general.password'),
                    'required' => 'required'
                ])
            !!}
        </div>

        @if($recaptcha)
            <div class="form-group">
                {!! HTML::recaptcha() !!}
            </div>
        @endif

        <div class="form-group">
            {!! Form::submit(trans('general.login'), ['class' => 'btn btn-primary form-control']) !!}
        </div>
    {!! Form::close() !!}

    @include('errors.form')
</div>

@section('scripts')
    <script>
        $(function()
        {
            load_or_reset_recaptcha();
        });
    </script>
@stop