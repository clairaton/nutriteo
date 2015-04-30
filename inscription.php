<?php
session_name('nutritmp');
session_start();
include_once "config.php";

if(!empty($_POST)){

	/****************************************************************************
	* $error_label stock les libellé des errors dans le cas de valeur null 		*
	* pour certains élément obligatoire du formulaire							*
	*																			*
	* $val stockera les valeurs qui auront été renseigné par l'utilisateur 		*
	* afin de les réafficher en cas d'erreur									*
	*																			*
	* @author Clément CAIRO alias K.net 										*
	*****************************************************************************/

	$error_label = array(
		"sex" => "Vous n'avez pas de genre?",
		"birthdate" => "Votre de date de naissance est nécessaire",
		"weight" => "Votre poids est primordial",
		"size" => "Votre taille a son importance",
		"level" => "Votre activité physique à de l'importance",
		"food" => "Vous n'avez pas choisis de type d'alimentation"
	);

	//contrôle les valeurs du _POST
	foreach ($_POST as $key => $value) {
		//Si la valeur de la clé (élément du formulaire) est vide
		//sauf pour allergy et diet qui ne sont pas obligatoire
		if($value =='' ){
				$error[$key] = $error_label[$key];
		}else{
			if($key == 'sex' && $value == 2){
				$val['sexF'] = 'selected';
			}elseif($key == 'sex' && $value == 1){
				$val['sexH'] = 'selected';
			}elseif($key == 'sex' && $value == 2){
				$val['sexA'] = 'selected';
			}else{
				$val[$key] = $value;
			}
		}
	}

	if(empty($error)){

		$_SESSION['sex'] = $_POST['sex'];
		$_SESSION['birthdate'] = $_POST['birthdate'];
		$_SESSION['size'] = $_POST['size'];
		$_SESSION['weight'] = $_POST['weight'];
		$_SESSION['level'] = $_POST['level'];

		header('Location: register.php');
		exit();
	}

}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/inscription.css">
	<link rel="stylesheet" href="css/jquery-ui.min.css">
	<link rel="stylesheet" href="css/jquery-ui.theme.min.css">
</head>
<body>
	<h2>Votre profil alimentaire en quelque question</h2>

	<div class="container" id="form">

		<form method="post" action="inscription.php" id="form-signup">
			<div class="row row-centered">
				<div id="genre"  class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<p>Quelle est votre genre ?</p>
					<select class="form-control" name="sex">
						<option value="">Je suis...</option>
						<option value="0" <?php if(!empty($val['sexF']))echo $val['sexF']; ?>>Femme</option>
						<option value="1" <?php if(!empty($val['sexH']))echo $val['sexH']; ?>>Homme</option>
					</select>

					<p class="error"><?php if(!empty($error['sex']))echo $error['sex']; ?></p>
				</div>

				<div id="birthday"  class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<p>Votre date de naissance ?</p>
					<input type="text" id="datepicker" name="birthdate" min="1920-01-02" max="2000-01-02" value="<?php if(!empty($val['birthdate']))echo $val['birthdate']; ?>" placeholder="jj-mm-aaaa">
					<p class="error"><?php if(!empty($error['birthdate']))echo $error['birthdate']; ?></p>
				</div>
			</div>
			<div class="row">
				<div id="size"  class="col-sm-6">
					<p>Votre taille ?</p>
					<select class="form-control" name="size">
						<option value="">Je mesure...</option>
						<?php
						for ($i=100; $i <251 ; $i++) {
							if(!empty($val['size']) && $val['size'] == $i){
								echo '<option value="'.$i.'" selected>'.$i.' cm</option>';
							}else{
								echo '<option value="'.$i.'">'.$i.' cm</option>';
							}
						}
						?><?php  ?>
					</select>
					<p class="error"><?php if(!empty($error['size']))echo $error['size']; ?></p>
				</div>
				<div id="weight"  class="col-sm-6">
					<p>Votre poids ?</p>
					<select class="form-control" name="weight">
						<option value="">Je pèse...</option>
						<?php
						for ($i=30; $i <301 ; $i++) {
							if(!empty($val['weight']) && $val['weight'] == $i){
								echo '<option value="'.$i.'" selected>'.$i.' kg</option>';
							}else{
								echo '<option value="'.$i.'">'.$i.' kg</option>';
							}
						}
						?><?php  ?>
					</select>
					<p class="error"><?php if(!empty($error['weight']))echo $error['weight']; ?></p>
				</div>
			</div>
			<div class="row row-centered">
				<div id="sport" class="">
					<p>Comment jugez-vous votre activité sportive ?</p>
					<input type="hidden" name="level" value="1">
					<div class="choice" id="sport0"><h3>Sportif du canapé</h3> <p>Peu ou pas de sport</p></div>
					<div class="choice" id="sport1"><h3>Sportif du dimanche</h3> <p>1 à 2 fois par mois</p></div>
					<div class="choice" id="sport2"><h3>Sportif amateur</h3> <p>1 fois par semaine</p></div>
					<div class="choice" id="sport3"><h3>Sportif regulier</h3> <p>Plusieurs fois par semaine</p></div>
					<p class="error"><?php if(!empty($error['level']))echo $error['level']; ?></p>
				</div>
			</div>
			<div id="submit"><input type="submit" class="btn btn-success" value="Continuer !"></div>
		</form><!--End of form-->

	</div>

</body>
</html>