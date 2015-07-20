@extends('layout.master')

@section('title')
    <title>{{ $title or trans('general.admin.title') }}</title>
@endsection

@section('header')
    @include('admin.partials.header')
@endsection