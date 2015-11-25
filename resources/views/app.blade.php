<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Сайт недвижимости</title>

	<link href="/css/app.css" rel="stylesheet">
	<script type="text/javascript" src="/script.js"></script> 

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Сайт недвижимости</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="/">Главная</a></li>

				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="/auth/login">Войти</a></li>
						<li><a href="/auth/register">Зарегистрироваться</a></li>
						<li><a href="/contacts">Наши контакты</a></li>
						
						@elseif (Auth::user()->id_role==1)
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><strong>{{ Auth::user()->name }} {{ Auth::user()->surname }}</strong> <!--<span class="caret"></span>--></a>
							<!--<ul class="dropdown-menu" role="menu">
								<li><a href="/auth/logout">Выйти</a></li>
							</ul>-->
						</li>
							
						
						<li><a href="/admin">Личный кабинет</a></li>
						<li><a href="/contacts">Наши контакты</a></li>
						<li><a href="/auth/logout">Выйти</a></li>
						
						@elseif (Auth::user()->id_role==2)
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><strong>{{ Auth::user()->name }} {{ Auth::user()->surname }}</strong> <!--<span class="caret"></span>--></a>
							<!--<ul class="dropdown-menu" role="menu">
								<li><a href="/auth/logout">Выйти</a></li>
							</ul>-->
						</li>
							
						
						<li><a href="/private_cabinet">Личный кабинет</a></li>
						<li><a href="/contacts">Наши контакты</a></li>
						<li><a href="/auth/logout">Выйти</a></li>
					@elseif (Auth::user()->id_role == 3)

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><strong>{{ Auth::user()->name }} {{ Auth::user()->surname }}</strong> <!--<span class="caret"></span>--></a>
							<!--<ul class="dropdown-menu" role="menu">
								<li><a href="/auth/logout">Выйти</a></li>
							</ul>-->
						</li>
						<li><a href="/create_advert">Создать объявление</a></li>
						<li><a href="/private_cabinet">Личный кабинет</a></li>
						<li><a href="/contacts">Наши контакты</a></li>
						<li><a href="/auth/logout">Выйти</a></li>
					@endif

				</ul>
			</div>
		</div>
	</nav>

	@yield('content')
	

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
