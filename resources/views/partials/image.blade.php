@if (isset($image_ssn))
    <a href="{{ route('image', [$image_ssn]) }}" {!! isset($use_text) ? 'data-no-lightbox' : 'data-lightbox="' . e($image_ssn) . '"' !!}>
        @if (isset($use_text))
            {{ trans('general.show_image') }}
        @else
            {!! HTML::image(route('image.small', [$image_ssn]), $image_ssn, ['class' => isset($class) ? $class : '']) !!}
        @endif
    </a>
@endif