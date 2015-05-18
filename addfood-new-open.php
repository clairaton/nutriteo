<?php
include_once 'header.php';
include_once 'sidebar.php';
?>
<div class="content-general addfood" id="food">
	<div id="explaination">
		<h2>Votre journal alimentaire</h2>
		<p>Renseignez les aliments que vous avez consommés aujourd'hui. <br>N'oubliez pas de renseigner les huiles ajoutés en cuisine ainsi que la quantité d'eau</p>
	</div>
	<div id="containeur">

		<div class="repas" id="breakfast">
			<h3>Petit-déjeuner</h3>
		</div>
		
		<div class="add_item">
		<button class="btn-addFood">
			<span class="glyphicon glyphicon-plus"></span> Ajouter un aliment
		</button>
		</div>
	</div>

	<div class="repas" id="lunch">
		<h3>Déjeuner</h3>
	</div>
	<div class="add_item">
		<button class="btn-addFood">
			<span class="glyphicon glyphicon-plus"></span> Ajouter un aliment
		</button>
	</div>

	<div class="repas" id="diner">
		<h3>Dîner</h3>
	</div>
	<div class="add_item">
		<button class="btn-addFood">
			<span class="glyphicon glyphicon-plus"></span> Ajouter un aliment
		</button>
	</div>

	<div class="repas" id="snack">
		<h3>Grignotage</h3>
	</div>
	<div class="add_item">
		<button class="btn-addFood">
			<span class="glyphicon glyphicon-plus"></span> Ajouter un aliment
		</button>
	</div>	

</div>
</div>

<?php
include_once 'footer.php';
$foods = Food::getCompleteList();

$food_list = '';
echo '<script>';

foreach ($foods as $key => $food) {
	$food_list .= '"'.str_replace('"', '', $food->getName()).'"';

	if($key!=sizeof($foods)){
		$food_list .= ',';
	}
}

echo 'addfood.list_food = ['.$food_list.'];';
echo '</script>';
?>