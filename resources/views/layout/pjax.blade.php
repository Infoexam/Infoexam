<noscript><meta http-equiv="refresh" content="0;url={{ route('noscript') }}"></noscript>

@yield('title', '<title>' . trans('general.title') . '</title>')

@include('flash::message')

<ul class="form-error-msg alert alert-danger ul-li-margin-left"></ul>

@yield('main')

@yield('scripts')