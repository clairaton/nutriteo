<?php

include_once 'config.php';

$error = "";
if(!empty($_POST)){
	if(!empty($_POST['email']) && !empty($_POST['pass'])){
		if(Authent::checkLogin($_POST['email'], $_POST['pass'])){
			echo '<p class="validOK">Connexion OK</p>';
			//header('Location: /nutriteo/carnet.php');
			exit();
		}else{
			$error = '<p class="error">Login ou mot de passe incorrect</p>';
		}
	}else{
		$error = '<p class="error">Login ou mot de passe incorrect</p>';
	}
}
?>

	<main id="login-content">
		<h2>Connectez-vous</h2>
		<?=$error?>
			<form class="form-horizontal" action="login.php" method="POST" id="form-login">
				<div class="form-group">
				    <label class="col-sm-3 col-xs-12 control-label" for="exampleInputEmail2">Email</label>
				    <div class="col-sm-9 col-xs-12">
				    	<input type="email" class="form-control" name="email" id="email" placeholder="jane.doe@example.com">
				    </div>
			 	 </div>
			  	 <div class="form-group">
				   	<label class="col-sm-3 col-xs-12 control-label" for="exampleInputEmail2">Mot de passe</label>
				   	<div class="col-sm-9 col-xs-12">
				    	<input type="password" class="form-control" name="pass" id="password" placeholder="Password">
				    </div>
			  	</div>

				<div id="reseaux">
				  	<button class="loginBtn loginBtn--facebook">Login with Facebook</button>

					<button class="loginBtn loginBtn--google">Login with Google</button>
				</div>
				<div class="form-group">
					<div class="submit-register">
			  			<button type="submit" id="submit" class="btn btn-success">Validez</button>
			  		</div>
			  	</div>
			</form>
	</main>

<link href="css/register.css" rel="stylesheet">