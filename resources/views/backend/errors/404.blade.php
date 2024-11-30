@extends('backend.errors.layout')
@section('title', 'Page Not Found - '.config('app.name'))

@section('content')
<div class="text-center error-wrap">
	<h1><span>4</span><span>0</span><span>4</span></h1>
	<h2>Page Not Found</h2>
	<p>The page you were trying to reach couldn't be found on this server.<br/>Click "Go Back" to access the Home page.</p>
	<a href="{{route('backend.dashboard')}}">Go To Home</a>
</div>
@endsection
