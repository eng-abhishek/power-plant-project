@extends('backend.errors.layout')
@section('title', 'Page Expired - '.config('app.name'))

@section('content')
<div class="text-center error-wrap">
	<h1><span>4</span><span>1</span><span>9</span></h1>
	<h2>Page Expired</h2>
	<p>Your request has been expired. Please Try Again!</p>
	<a href="{{route('backend.dashboard')}}">Go To Home</a>
</div>
@endsection

