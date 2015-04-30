<?php
	session_name("nutriteo");
	session_start();
	include 'config.php';
	if(!Authent::checkSession()){
		header('Location: index.php');
	}

	$current_page = basename($_SERVER['PHP_SELF']);
	$today=date('d-m-Y',time());
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="img/favicon.ico">

		<title>Nutriteo</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/jquery-ui.min.css">
		<link rel="stylesheet" href="css/jquery-ui.theme.min.css">
		<link href="css/style.css" rel="stylesheet">

	</head>
	<body>
		<header id="header">
			<nav class="nav">
				<a href="index.php" class="logo"><img src="img/logo-blanc.png" height="36" width="130"></a>
				<div id="menu" class="menu-header">
					<a href="carnet.php" alt="tableau de bord" id="carnet" class="btn-nav">Mon tableau de bord</a>
					<a href="nutrition.php" alt="la nutrition" id="nutrition" class="btn-nav">La nutrition</a>
					<a href="faq.php" alt="utiliser nutriteo" id='utilisernu' class="btn-nav">Utiliser nutriteo</a>
					<a href="contact.php" alt="nous contacter" id="contactnu" class="btn-nav">Nous contacter</a>
					<a href="logout.php" class="btn btn-danger" alt="deconnexion">Se deconnecter</a>
				</div>
				<span  id="burger" class="fa fa-list"></span></div>
			</nav><!-- nav-->
		</header>
	<main id="main">
		<div class="container-fluid">
