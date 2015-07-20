@extends($pjax ? 'admin.layouts.pjax' : 'admin.layouts.master')

@section('main')
    @include('partials.login', ['route' => 'admin.auth'])
@endsection