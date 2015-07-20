@extends($pjax ? 'student.layouts.pjax' : 'student.layouts.master')

@section('main')
    @include('partials.login', ['route' => 'student.auth'])
@endsection