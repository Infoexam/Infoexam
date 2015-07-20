@extends('layout.master')

@section('title')
    <title>{{ $title or trans('general.title') }}</title>
@endsection

@section('header')
    @include('exam.partials.header')
@endsection