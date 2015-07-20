<div class="form-group">
    {!! Form::label('question', trans('faqs.question')) !!}
    {!!
        Form::text('question', null, [
            'class' => 'form-control',
            'required' => 'required',
        ])
    !!}
</div>

<div class="form-group">
    {!! Form::label('answer', trans('faqs.answer')) !!}
    {!! Form::textarea('answer', null, [
            'class' => 'form-control',
            'rows' => 4,
            'required' => 'required',
    ]) !!}
</div>

<div class="form-group">
    @if (isset($faq->image_ssn))
        @include('partials.image', ['image_ssn' => $faq->image_ssn])
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
                    CKEDITOR.replace('answer', {
                        height: 300
                    });
                });
            });
        })(jQuery);
    </script>
@endsection