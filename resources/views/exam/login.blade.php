@extends(env('IS_PJAX') ? 'exam.layouts.pjax' : 'exam.layouts.master')

@section('main')
    @include('partials.login', ['route' => 'exam.auth'])
@stop