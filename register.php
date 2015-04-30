<!DOCTYPE html>
<?php
include_once 'config.php';

session_name('nutritmp');
session_start();

$lastname = '';
$firstname = '';
$email = '';

if(!empty($_POST)){

	$error_label = array(
		'lastname' => 'Vous n\'avez pas renseigné votre Nom',
		'firstname' => 'Vous n\'avez pas renseigné votre Prénom',
		'email' => 'Vous n\'avez pas renseigné votre adresse e-mail',
		'pass' => 'Vous n\'avez pas renseigné de mot de passe',
		'confirm_pass' => 'Vous n\'avez pas confirmé le mot de passe '
	);

	//contrôle les valeurs du _POST
	foreach ($_POST as $key => $value) {
		//Si la valeur de la clé (élément du formulaire) est vide
		if($value =='' ){
				$error[$key] = $error_label[$key];
		}else{
			$$key = $value;
		}
	}

	if(empty($error)){
		if($_POST["pass"] == $_POST["confirm_pass"]){
			$data = array(
					'lastname' => $_POST['lastname'],
					'firstname' => $_POST['firstname'],
					'email' => $_POST['email'],
					'password' => $_POST['pass'],
					'sex' => $_SESSION['sex'],
					'birthdate' => $_SESSION['birthdate'],
					'size' => $_SESSION['size'],
					'weight' => $_SESSION['weight']
				);

			$register = new Register($data);
			$register->passwordCrypt();
			$id = $register->signUp();
			$register->suppSessionTmp();

			if($id){
				echo $id;

				session_name('nutriteo');
				session_start();

				$_SESSION['user_id'] = $id;
				$_SESSION['lastname'] = $data['lastname'];
				$_SESSION['firstname'] = $data['firstname'];
				$_SESSION['email'] = $data['email'];
			}

			echo '<p class="validOK">Vous êtes maintenant enregistré dans nutritéo.</p> <br><br> Un email de confirmation a été envoyé à l\'adresse '.$register->getEmail().'. Vous avez 3 jours pour valider la création de votre compte.';
			exit();
		}else{
			$error['confirm_pass'] = 'Votre mot de passe et la confirmation du mot de passe sont différent';
		}

	}

}

?>

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
		<link href="css/style.css" rel="stylesheet">
	</head>
	<body>
			<div id="register-content" >
				<h2>Finalisez votre inscription :</h2>
					<form class="form-horizontal" action="register.php" method="POST" id="valid-signup" novalidate>
						<div class="form-group">
							<label for="lastname" class="col-sm-3 col-xs-3 control-label  media">Nom</label>
							<div class="col-sm-9 col-xs-9">
								<input type="text" class="form-control  media" name="lastname" id="lastname" placeholder="Nom" value= "<?= $lastname ?>">
								<p class="error"><?php if(!empty($error['lastname']))echo $error['lastname']; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-3 col-xs-3 control-label media">Prénom</label>
							<div class="col-sm-9 col-xs-9">
								<input type="text" class="form-control media" name="firstname" id="firstname" placeholder="Prénom" value= "<?= $firstname ?>">
								<p class="error"><?php if(!empty($error['firstname']))echo $error['firstname']; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-3 col-xs-3 control-label media">Email</label>
							<div class="col-sm-9 col-xs-9">
								<input type="email" class="form-control media" name="email" id="email" placeholder="Email" value= "<?= $email ?>">
								<p class="error"><?php if(!empty($error['email']))echo $error['email']; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label for="pass" class="col-sm-3 col-xs-3  control-label media">Mot de passe</label>
							<div class="col-sm-9 col-xs-9">
								<input type="password" class="form-control media" name="pass" id="pass" placeholder="Mot de passe">
								<p class="error"><?php if(!empty($error['pass']))echo $error['pass']; ?></p>
							</div>
						</div>
						<div class="form-group">
							<label for="confirm_pass" class="col-sm-3 col-xs-3 control-label media">Confirmation</label>
							<div class="col-sm-9 col-xs-9">
								<input type="password" class="form-control media" name="confirm_pass" id="confirm_pass" placeholder="Mot de passe">
								<p class="error"><?php if(!empty($error['confirm_pass']))echo $error['confirm_pass']; ?></p>
							</div>
						</div>
						<div id="reseaux">
						  	<button class="loginBtn loginBtn--facebook">Login with Facebook</button>

							<button class="loginBtn loginBtn--google">Login with Google</button>
						</div>
						<div class="form-group">
							<div class="submit-register">
								<button type="submit" id="submit-signup" class="btn btn-success media insc">Validez</button>
							</div>
						</div>
				</form>
			</div>

	</body>
</html>

