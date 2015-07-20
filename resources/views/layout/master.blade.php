<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name=viewport content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('title', '<title>' . trans('general.title') . '</title>')
        <link type="image/x-icon" rel="shortcut icon" href="{{ secure_asset('favicon.ico') }}">
        <noscript><meta http-equiv="refresh" content="0;url={{ route('noscript') }}"></noscript>
        <link rel="stylesheet" href="{{ secure_asset('assets/css/main.css') }}">
        <script src="{{ secure_asset('assets/js/main.js') }}"></script>
    </head>
    <body>
        <div class="main">
            @yield('header')

            <div class="substance">
                @if (session()->has('flash_notification.message'))
                    @include('flash::message')
                @endif

                <ul class="form-error-msg alert alert-danger ul-li-margin-left"></ul>

                @yield('main')
            </div>

            @include('partials.footer')

            @include('partials.delete-confirm')
        </div>
        @yield('scripts')
    </body>
</html>