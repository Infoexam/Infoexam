<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name=viewport content="width=device-width, initial-scale=1">
        @yield('title', '<title>' . trans('general.title') . '</title>')
        <link type="image/x-icon" rel="shortcut icon" href="{{ secure_asset('favicon.ico') }}">
        <noscript><meta http-equiv="refresh" content="0;url={{ route('noscript') }}"></noscript>
        {!! HTML::style(secure_asset('assets/css/main.css')) !!}
        {!! HTML::script(secure_asset('assets/js/main.js')) !!}
        {{-- HTML::script(secure_asset('assets/js/infoexam.js'), ['async']) --}}
    </head>
    <body>
        <div class="main">
        
            @yield('header')

            <div class="substance">
                @include('flash::message')

                <ul class="form-error-msg alert alert-danger ul-li-margin-left"></ul>

                @yield('main')
            </div>

            @include('partials.footer')

            @include('partials.delete-confirm')

        </div>
        @yield('scripts')
    </body>
</html>