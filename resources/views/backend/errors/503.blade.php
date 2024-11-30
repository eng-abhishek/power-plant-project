@extends('backend.errors.layout')
@section('title', 'Service Unavailable - '.config('app.name'))

@section('content')
<div class="text-center error-wrap">
	<h1><span>5</span><span>0</span><span>3</span></h1>
	<h2>Service Unavailable</h2>
	<p>The server cannot handle your request right now.<br/>Please Try Again later!</p>
	<a href="{{route('backend.dashboard')}}">Go To Home</a>
</div>
@endsection



