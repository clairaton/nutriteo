<?php
	include_once 'header.php';
?>
<div id="suggestion" class="content-general col-xs-12">
	<h2>Vous souhaitez ajouter un aliment</h2>
	<p>Afin de conserver la précision d'analyse, nous integrons nous meme les aliments dans la base de donnée. Vous pouvez suggeré un aliment en renseignant le formulaire ci dessous, nous completerons le profil nutritionnelle dans les plus brefs delais.</p>

	<hr>

	<form action="suggestion.php" method="GET">
		<div class="form-group">
			<label for="food">Nom de L'aliment</label>
			<input type="text" id="food" name="food" class="form-control col-x" placeholder="Pomme" value="">
		</div>
		<div class="form-group">
			<label for="categorie">Catégorie</label>
			<input type="text" id="categorie" name="categorie" class="form-control" placeholder="Fruits" value="">
		</div>
	</form>

	<hr>

</div>
<?php include_once 'sidebar.php';
 include_once 'footer.php';?>