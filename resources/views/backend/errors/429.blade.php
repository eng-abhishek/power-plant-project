@extends('backend.errors.layout')
@section('title', 'Too Many Requests - '.config('app.name'))

@section('content')
<div class="text-center error-wrap">
	<h1><span>4</span><span>2</span><span>9</span></h1>
	<h2>Too Many Requests</h2>
	<p>The Server has received too many requests to handle.<br/>Please Try Again!</p>
	<a href="{{route('backend.dashboard')}}">Go To Home</a>
</div>
@endsection


