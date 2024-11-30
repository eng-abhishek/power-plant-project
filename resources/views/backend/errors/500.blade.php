@extends('backend.errors.layout')
@section('title', 'Internal Server Error - '.config('app.name'))

@section('content')
<div class="text-center error-wrap">
	<h1><span>5</span><span>0</span><span>0</span></h1>
	<h2>Internal Server Error</h2>
	<p>The server has encountered an unexpected condition to your request.<br/>Please Try Again later!</p>
	<a href="{{route('backend.dashboard')}}">Go To Home</a>
</div>
@endsection

