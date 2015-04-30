<?php
	include_once 'header.php';
	include_once 'sidebar_glossaire.php';

	if(!empty($_GET["id"])){
		$id_nutriement= $_GET["id"];
		$element= Nutriment::getItem($id_nutriement);
		$foods=Food::getLimitListByNutriment($element['id'], 10);
	}elseif(!empty($_GET['family_id'])){
		$id_family= $_GET["family_id"];
		$element= Nutriment::getFamilyItem($id_family);
		$foods=Food::getListByNutrimentFamily($element['id'], 10);
	}
	else{
		$element= Nutriment::getItem(34);
				$foods=Food::getLimitListByNutriment($element['id'], 10);
	}



?>
<div id="glossaire" class="content-general  col-xs-10">
	<div class="row">
		<h2>Le glossaire nutritionnel</h2>
		<form  class="form-inline" action="nutrition.php" method="GET">
			<label for="search-nutri">Chercher un nutriment</label>
		    <div class="input-group" id="glossaire-input">
				<span class="input-group-btn">
					<button class="btn btn-default" type="button">
						<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
					</button>
				</span>
				<input type="text" class="form-control" placeholder="Chercher un nutriment">
		    </div><!-- /input-group -->
		</form>

		<hr>
		<div id="description">
			<h3><?= ucfirst($element['name'])?></h3>
			<?php
			//@TODO faire une maj dynamique en fonction dfe la description (auj pas possible la desc est trop courte :$element['description']
			?>
			<p>Le magnésium, métal possédant de faibles caractéristiques mécaniques, est très léger (un tiers plus léger que l'aluminium) ; d'aspect blanc-argenté, il se ternit légèrement une fois exposé à l'air par formation d'un oxycarbonate.</p>
			<p>En solution, il forme des ions Mg2+. Certains sels de magnésium sont très solubles dans l'eau ; le carbonate précipite (dureté magnésienne) ; l'hydroxyde est pratiquement insoluble.</p>
			<p>Il s'enflamme difficilement sous forme de bloc, mais très facilement s'il est réduit en petits copeaux ou en ruban. En poudre, ce métal s'échauffe et s'enflamme spontanément par oxydation avec le dioxygène de l'air. Il brûle avec une flamme blanche très lumineuse, d'où son utilisation pour les flashs ou lampes-éclairs aux débuts de la photographie et utilisées pendant des décennies sous forme d'ampoules à usage unique.</p>
			<p>Cependant, la production de lumière ultraviolette lors de la combustion du magnésium rend dangereuse son observation directe.
			La première source alimentaire de magnésium est souvent d'origine céréalière : les produits céréaliers étant présents à tous les repas, ce sont eux qui couvrent la majeure partie des besoins. Cependant, les produits à base de céréales intégrales ou de farine complète apportent de 3 à 5 fois plus de magnésium que les produits raffinés (pain blanc, riz blanc poli, ...).</p>
			<p>Il est donc vivement recommandé d'aller vers ce type de produits pour couvrir ses besoins journaliers en magnésium. Une alimentation végétarienne est aussi favorable.</p>
		</div>

		<hr>

		<div class="alient-riche">
			<h3>Aliment riches en <?= $element['name'] ?></h3>
			<div id="img-aliment">
				<?php foreach($foods as $food){
						$picture_id = $food -> getPictureId();
						$picture_url = Picture::getItem($picture_id)['source'];
					?>

						<div id="<?= $food -> getId() ?>" class="caseAddFood">
							<div class="nom-aliment"><?=$food -> getName() ?></div>
							<img src=<?= $picture_url ?> width="98px">
						</div>
					<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php
	include_once 'footer.php';
?>

