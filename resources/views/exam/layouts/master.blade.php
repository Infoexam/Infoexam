@extends('layout.master')

@section('title')
    <title>{{ $title or trans('general.title') }}</title>
@stop

@section('header')
    @include('exam.partials.header')
@stop