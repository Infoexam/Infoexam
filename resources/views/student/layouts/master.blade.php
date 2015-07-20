@extends('layout.master')

@section('title')
    <title>{{ $title or trans('general.title') }}</title>
@endsection

@section('header')
    @include('student.partials.header')
@endsection