@if (isset($image_ssn))
    @if ( ! is_array($image_ssn))
        <?php $image_ssn = [$image_ssn]; ?>
    @endif

    @foreach ($image_ssn as $ssn)
        @if (isset($use_text))
            <a href="{{ route('image', [$ssn]) }}" data-no-lightbox>
        @else
            <a href="{{ route('image', [$ssn]) }}" data-lightbox="{{ $ssn }}">
        @endif
            @if (isset($use_text))
                {{ trans('general.show_image') }}
            @else
                {!! HTML::image(route('image.small', [$ssn]), $ssn, ['class' => isset($class) ? $class : '']) !!}
            @endif
        </a>
    @endforeach
@endif