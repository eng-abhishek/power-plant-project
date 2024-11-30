<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title', {{config('app.name')}})</title>

	<meta name="description" content="Exchange between BTC, ETH, BCH, XMR, XAI and 30+ other cryptocurrencies. The best exchange rates.">
	<meta name="keywords" content="BTC, ETH, BCH, XMR">
	<meta name="author" content="PDPL">

	<link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/error-page.css') }}">
</head>
<body>
	<noscript>
		<style>
			h1{
				font-family: 'Arial', sans-serif;
			}
			h1 span{
				animation: none;
			}
			h1 span::before{
				display: none;
			}
		</style>
	</noscript>
	<main>
		<section>
			<div class="container-fluid">
				<div class="row d-flex justify-content-center min-vh-100">
					<div class="col-xxl-12 col-12 align-self-center">
						@yield('content')
					</div>
					<div class="col-xxl-12 col-12 align-self-end p-0">
						<footer>
							<div class="text-center">
								<p>&copy; {{config('app.name')}} {{date('Y')}}</p>
							</div>
						</footer>
					</div>
				</div>
			</div>
		</section>		
	</main>	
</body>
</html>