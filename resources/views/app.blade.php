<!DOCTYPE html>
<html lang="he">
<head>
	<meta charset="utf-8">
	<meta name="_token" id="token-input" content="{!! csrf_token() !!}"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>
	<link href="{{ elixir('css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Exo+2:400,300' rel='stylesheet' type='text/css'>

	@yield('head')
</head>
<body>

<div class="warrper">

@include('nav')


	@yield('content')

	</div>
<footer>&copy; Butcher <?php echo date("Y"); ?></footer>
	<!-- Scripts -->
	<script src="/js/external_libs.js"></script>
	<script src="/js/app.js"></script>
</body>

	@yield('scripts')

</html>
