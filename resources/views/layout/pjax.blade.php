<noscript><meta http-equiv="refresh" content="0;url={{ route('noscript') }}"></noscript>

@yield('title', '<title>' . trans('general.title') . '</title>')

@if (session()->has('flash_notification.message'))
    @include('flash::message')
@endif

<ul class="form-error-msg alert alert-danger ul-li-margin-left"></ul>

@yield('main')

@yield('scripts')