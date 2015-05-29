<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name=viewport content="width=device-width, initial-scale=1">
        @yield('title', '<title>' . trans('general.title') . '</title>')
        <link type="image/x-icon" rel="shortcut icon" href="{{ secure_asset('favicon.ico') }}">
        {!! HTML::style(secure_asset('assets/css/main.css')) !!}
        {!! HTML::script(secure_asset('assets/js/main.js')) !!}
        {!! HTML::script(secure_asset('assets/js/infoexam.js'), ['async']) !!}
    </head>
    <body>
        <section class="main">
        
            @yield('header')

            <section class="substance">
                @include('flash::message')

                <ul class="form-error-msg alert alert-danger"></ul>

                @yield('main')
            </section>

            @include('partials.footer')

            @include('partials.delete-confirm')

        </section>
        @yield('scripts')
    </body>
</html>