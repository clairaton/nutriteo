<?php
	include_once 'header.php';
	include_once 'sidebar.php';

	if(!empty($_GET)){
		// on fixe les données nécessaires à la fonction dailyActivity de l'objet ActivityController
		$datas= $_GET;
		$user=$_SESSION['user_id'];
		$today=date('d-m-Y', time());

		// on lance la fonction
		ActivityController::dailyActivity($user, $datas, $today);
	}

?>
<div class="content-general addfood">
	<h2>Activités physiques</h2>

	<form id="tableau-activites" class="col-xs-12" method="GET">

		<div>
			<label for="amount" >Votre activitée physique est :</label>
			<input type="text" id="amount" name="intensity_name" readonly style="border:0; color:#7A9E7E; font-weight:bold;">

			<div id="slider_activity"></div>
			<ul id='activites-labels'>
				<li >Pas d'activité</li>
				<li >Normale</li>
				<li >Intensive</li>
			</ul>
		</div>

		<div>
			<label for="duration" id="titre">La durée de votre activitée physique est :</label>
			<input type="text" id="duration" name="duration" readonly style="border:0; color:#7A9E7E; font-weight:bold;">

			<div id="slider_duration"></div>
			<ul id='duration-labels'>
				<li>0</li>
				<li>1H</li>
				<li>2H</li>
				<li>3H</li>
				<li>4H</li>
				<li>5H</li>
				<li>6H</li>
			</ul>
		</div>
		<?php if(!empty($errors)){ ?>
		<div class="alert">
			<ul> <?php
			foreach($errors as $key => $value){ ?>
				<li><?= $value ?></li>
			<?php }	?>
			</ul>
		</div>
		<?php } ?>


		<input type="submit" id="val" class="btn btn-success"></button>

	</form><!--End of FORM-->
</div>

<?php

	include_once 'footer.php';
?>