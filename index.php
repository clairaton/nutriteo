<!doctype html>
<?php
	session_name("nutriteo");
	session_start();

	require_once 'config.php';

	if(Authent::checkSession()){
		header('Location: carnet.php');
	}
?>
<html>
	<head>
		<meta charset="utf8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/base.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>

		<!--HEADER-->
		<header id="header">
			<div id="block1-cover"></div><!--Image de Background-->
			<div class="container">
				<div class="row">
					<nav>
						<a href="" id="logo"><img src="img/logo-landing.png" height="57" width="200"></a>
						<div>
							<a class="button" id="inscription">S'inscrire</a>
							<a class="button" id="login">Se connecter</a>
					</nav><!--End of nav-->

					<div id="block1-principal">

						<h1>Améliorez la qualité de votre alimentation</h1>
						<h3>Surveillez vos apports nutritionnels, et retrouvez une alimentation saine et équilibré en fonction de vos besoins et de vos envies.</h3>
						<a>
							<div id="action-button-header">
								<span>Commencez maintenant</span><br>
							</div>
						</a><!--End of button-->
					</div><!--End of block1-principal-->

				</div><!--End of row-->
			</div><!--End of container-->

		</header><!--End of HEADER-->

		<!--MAIN-->
		<main id="main">
			<div id="block2" class="block-main">
				<div class="img img-left"></div>
				<div class="txt-right">
					<h3>Mesurez vos apports nutritifs</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ante est, iaculis sit amet ante vitae, porta pellentesque enim. Duis vitae posuere est. Donec imperdiet ligula risus, sed porta massa convallis quis. Vivamus a laoreet ipsum, et vulputate metus. Etiam ac pulvinar nisi. </p>
				</div><!--End of txt-->
			</div><!--End of block 2-->

			<div id="block3" class="block-main">
				<div class="img img-right"></div>
				<div class="txt-left">
					<h3>Analysez les efforts réalisez</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ante est, iaculis sit amet ante vitae, porta pellentesque enim. Duis vitae posuere est. Donec imperdiet ligula risus, sed porta massa convallis quis. Vivamus a laoreet ipsum, et vulputate metus. Etiam ac pulvinar nisi. </p>
				</div>
			</div><!--End of block 3-->

			<div id="block4" class="block-main">
				<div class="img img-left"></div>
				<div class="txt-right">
					<h3>Choississez un programme adapté à vos besoins</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ante est, iaculis sit amet ante vitae, porta pellentesque enim. Duis vitae posuere est. Donec imperdiet ligula risus, sed porta massa convallis quis. Vivamus a laoreet ipsum, et vulputate metus. Etiam ac pulvinar nisi. </p>
				</div>
			</div><!--End of block 4-->
			<div>

			</div>
		</main><!--End of MAIN-->

		<!--FOOTER-->
		<footer id="footer">
		<div class="container-fluid">
				<div class="row">
					<form method="POST" id="form-newsletter" class="form-inline">
						<label for="email">Recevez les informations nutritives correspondant à vos besoins</label>
						<div class="input-group col-md-3 col-offset-md-6">
							<input type="text" id="email" class="form-control" placeholder="Exemple: abc@mail.com" aria-describedby="basic-addon2">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit">
									<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
								</button>
							</span>
						</div>
					</form><!--End of form-newsletter-->

					<nav>
						<a href="">About</a>
						<a href="">Conseil</a>
						<a href="">Mentions légales</a>
						<a href="">Contact</a>
					</nav><!--End of nav-->

				</div><!--End of row-->
			</div><!--End of container-->
		</footer><!--End of FOOTER-->

		<script src="js/jquery.js"></script>
		<script type="" src="js/jquery-ui.min.js"></script>
		<script type="" src="js/datepicker-fr.js"></script>
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/highcharts-more.js"></script>
		<script src="http://code.highcharts.com/modules/solid-gauge.js"></script>
		<script src="js/app.js"></script>
		<script type="" src="js/app.js"></script>
		<script type="" src="js/addfood.js"></script>
		<script type="" src="js/popup_inscription.js"></script>
		<script type="" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</body>
</html>
