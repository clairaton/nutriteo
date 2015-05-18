<?php
session_name('nutritmp');
session_start();

if(empty($_SESSION)){
	header('Location: /');
}

?>
<html lang="fr">
<head>
	<link rel="stylesheet" href="css/inscription.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
</head>
<body>
		<form action="register.php" method="POST" id="form-testAlim">
			<!-- Zone à refaire -->
			Avec les éléments suivants :
			 <p>- <?= $_SESSION['sex'] ?></p>
			 <p>- <?= $_SESSION['birthdate'] ?></p>
			 <p>- <?= $_SESSION['size'] ?></p>
			 <p>- <?= $_SESSION['weight'] ?></p>
			 <p>- <?= $_SESSION['level'] ?></p>


			 Nutritéo vous propose le profil : <b>Armoire à glace</b>
			 <!-- Fin zone à refaire -->
			 <input type="submit" id="register" class="btn btn-success col-xs-8 col-xs-offset-2" value="Continuer l'inscription!">
		 </form>
</body>
</html>