@extends('layouts.admin')

@section('content')

    <h1 class="h3 mb-2 text-gray-800">Welcome back!</h1>
    <h2 class="h3 mb-2 text-gray-800">{{Auth::user()->name}}</h2>


@endsection

