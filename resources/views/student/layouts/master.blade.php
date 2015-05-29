@extends('layout.master')

@section('title')
    <title>{{ $title or trans('general.title') }}</title>
@stop

@section('header')
    @include('student.partials.header')
@stop