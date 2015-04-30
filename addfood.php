<?php
	include_once 'header.php';
	include_once 'sidebar.php';

	if (!empty($_POST)) {

		//conversion du tableau javascript en tableau PHP
		$list_consom = json_decode($_POST['list_consom'], true);

		foreach ($list_consom as $key => $value) {
			$name = str_replace("#", "", $value['nom']);
			//echo $_SESSION['user_id'].', '.$name.', '. $value['quantite'].', '. date('Y-m-d H:i:s');
			Food::insertFoodByUser($_SESSION['user_id'], $name, $value['quantite'], date('Y-m-d H:i:s'));
		}

		exit();
	}



	$tab_categories = Food::getCategoryList();
	$tab_onglet = Food::getFamilyList();


?>
<div class="content-general addfood">
	<h2>Renseignez ce que vous consommé aujourd'hui</h2>

	<!-- form de recherche produit -->
	<form  id="addfood-search" class="form-inline" action="nutrition.php" method="GET">
	    <div class="input-group">
			<span class="input-group-btn">
				<button class="btn btn-default" type="button">
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
				</button>
			</span>
			<input type="text" class="form-control" placeholder="Chercher un nutriment">
	    </div><!-- /input-group -->
	</form>


	<form id="tableau-aliments" action="addfood.php"  method="POST">

		<?php foreach ($tab_categories as $tab_categorie) { ?>
			<div id="<?php echo $tab_categorie['id']; ?>" class="element-tab element-tab-addfood">

				<div class="block-nav">
					<h3><?php echo $tab_categorie['name']; ?></h3>
					<span class="glyphicon glyphicon-chevron-down"></span>
				</div><!--End of Block Nav-->

				<button id="btnSubmit" class="btn btn-success" type="submit">
					<span class="glyphicon glyphicon-ok"></span>
				</button><!--End of BUTTON-->


				<div class="tab-choix">
					<?php
					$limit_food_by_family = Food::getLimitListByFamily($tab_categorie['id'], 50);
					foreach($limit_food_by_family as $food){
						$picture_id = $food -> getPictureId();
						$picture_url = Picture::getItem($picture_id)['source'];
						//@TODO: a maj dynamiquement avec la table food
					?>

						<div id="<?= $food -> getId() ?>" class="caseAddFood">
							<div class="nom-aliment"><?=$food -> getName() ?></div>
							<div class="btnPlusAli">+</div>
							<div class="btnMoinsAli">-</div>
							<img src=<?= $picture_url ?> width="98px">
							<div class="notiAli">0</div>
						</div>
					<?php } ?> <!--  -->

					<div class="caseAddFood caseAddFoodPlus">+</div>
				</div>
			</div>
		<?php } ?>

		<button type="submit" id="subm">
			<p>Validez</p>
			<p>Les aliments consommés</p>
		</button>

	</form><!--End of FORM-->

	<!--<div>
	<a href="activites.php" id="btn-sport">
		<span class="fa fa-heartbeat" id="heart-sport" aria-hidden="true"></span>
		Renseignez votre activité physique du jour
	</a>

	</div> -->
	<!--End of footerAddFood-->

</div>

<?php

	include_once 'footer.php';
?>