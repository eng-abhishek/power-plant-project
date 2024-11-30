@extends('backend.errors.layout')
@section('title', 'Unauthorized - '.config('app.name'))

@section('content')
<div class="text-center error-wrap">
	<h1><span>4</span><span>0</span><span>1</span></h1>
	<h2>Unauthorized</h2>
	<p>The page you requested to access is Unauthorized.</p>
	<a href="{{route('backend.dashboard')}}">Go To Home</a>
</div>
@endsection
