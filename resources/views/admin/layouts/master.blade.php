@extends('layout.master')

@section('title')
    <title>{{ $title or trans('general.admin.title') }}</title>
@stop

@section('header')
    @include('admin.partials.header')
@stop