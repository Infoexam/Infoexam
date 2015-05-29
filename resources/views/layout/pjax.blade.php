@yield('title', '<title>' . trans('general.title') . '</title>')

@include('flash::message')

<ul class="form-error-msg alert alert-danger"></ul>

@yield('main')

@yield('scripts')