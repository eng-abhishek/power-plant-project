@extends('backend.errors.layout')
@section('title', 'Forbidden - '.config('app.name'))

@section('content')
<div class="text-center error-wrap">
	<h1><span>4</span><span>0</span><span>3</span></h1>
	<h2>Forbidden</h2>
	<p>The page you requested to access is forbidden.</p>
	<a href="{{route('backend.dashboard')}}">Go To Home</a>
</div>
@endsection