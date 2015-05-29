@if(isset($image_ssn))
    <a href="{{ route('image', [$image_ssn], true) }}" data-lightbox="{{ $image_ssn }}">
        @if (isset($use_text))
            顯示圖片
        @else
            {!! HTML::image(route('image.small', [$image_ssn]), $image_ssn, ['class' => (isset($class)) ? $class : '']) !!}
        @endif
    </a>
@endif