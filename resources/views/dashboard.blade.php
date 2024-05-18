@extends('layout.app')

@section('breadcrumbs')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('header') Dashboard @endsection

@section('content')
    <p>
        Hello! It's a dashboard of Swagger Petstore API client. If you want to check out petstore client
        <a href="{{ route('pets.index') }}" title="Petstore client index">click here</a> or use navigation
        at the top of the page.
    </p>
@endsection
