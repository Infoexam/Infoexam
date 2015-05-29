<div class="form-group">
    {!! Form::label('heading', trans('announcements.title')) !!}
    {!!
        Form::text('heading', null, [
            'class' => 'form-control',
            'required' => 'required'
        ])
    !!}
</div>

<div class="form-group">
    {!! Form::label('link', trans('announcements.link')) !!}
    {!!
        Form::url('link', null, [
            'class' => 'form-control'
        ])
    !!}
</div>

<div class="form-group">
    {!! Form::label('content', trans('announcements.content')) !!}
    {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => 50, 'required' => 'required']) !!}
</div>

<div class="form-group">
    @if(isset($announcement) && null !== $announcement->image_ssn)
        @foreach($announcement->image_ssn as $image_ssn)
            @include('partials.image', ['image_ssn' => $image_ssn])
        @endforeach
    @elseif( ! isset($announcement) || (isset($announcement) && null === $announcement->image_ssn))
        @include('partials.form-image-field', ['name' => 'image[]', 'options' => ['accept' => 'image/*', 'multiple' => 'multiple']])
    @endif
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>

@section('scripts')
    <script>
        $(function()
        {
            load_js('{{ secure_asset('assets/ckeditor/ckeditor.js') }}', function()
            {
                CKEDITOR.replace('content', {
                    height: 300
                });
            });
        });
    </script>
@stop