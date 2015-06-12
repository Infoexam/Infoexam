@if (isset($image_ssn))
    @if ( ! is_array($image_ssn))
        <?php $image_ssn = [$image_ssn]; ?>
    @endif

    @foreach ($image_ssn as $ssn)
        <a href="{{ route('image', [$ssn]) }}" {!! isset($use_text) ? 'data-no-lightbox' : 'data-lightbox="' . e($ssn) . '"' !!}>
            @if (isset($use_text))
                {{ trans('general.show_image') }}
            @else
                {!! HTML::image(route('image.small', [$ssn]), $ssn, ['class' => isset($class) ? $class : '']) !!}
            @endif
        </a>
    @endforeach
@endif