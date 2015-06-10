<div class="form-group">
    {!! Form::label('heading', trans('announcements.title')) !!}
    {!!
        Form::text('heading', null, [
            'class' => 'form-control',
            'required' => 'required',
            'maxlength' => 255
        ])
    !!}
</div>

<div class="form-group">
    {!! Form::label('link', trans('announcements.link')) !!}
    {!!
        Form::url('link', null, [
            'class' => 'form-control',
            'maxlength' => 255
        ])
    !!}
</div>

<div class="form-group">
    {!! Form::label('content', trans('announcements.content')) !!}
    {!! Form::textarea('content', null, ['class' => 'form-control', 'required' => 'required', 'rows' => 50]) !!}
</div>

<div class="form-group">
    @if (isset($announcement->image_ssn))
        @include('partials.image', ['image_ssn' => $announcement->image_ssn])
    @else
        @include('partials.form-image-field', ['name' => 'image[]', 'options' => ['accept' => 'image/*', 'multiple' => 'multiple']])
    @endif
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
                load_js('{{ secure_asset('assets/ckeditor/ckeditor.js') }}', function()
                {
                    CKEDITOR.replace('content', {
                        height: 300
                    });
                });
            });
        })(jQuery);
    </script>
@stop