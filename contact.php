<?php
	include_once 'header.php';

	$tab_onglet_faq = [['nom' => 'Question nutrition',
					'id'=> 's1'],
				   ['nom' => 'Question technique',
					'id'=> 's2'],
				   ['nom' => 'Recrutement',
					'id'=> 's3'],
				   ['nom' => 'Investir',
					'id'=> 's4'],
					['nom' => 'Partenariat',
					'id'=> 's5'],
					['nom' => 'Autre',
					'id'=> 's6']];
?>
<div class="content-general addfood">
	<h2>Contactez-nous</h2>

	<form id="tableau-contacts" method="POST">
		<select id="tab-sujet" name="select-sujet">
			<?php foreach ($tab_onglet_faq as $key) { ?>
  				<option value="sujet1"><?php echo $key['nom'] ?></option>
			<?php } ?>
		</select><!--End of SELECT Sujet-->

		<textarea></textarea>

		<button class="btn btn-success" type="submit">Envoyez !</button>

	</form><!--End of FORM-->
</div>

<?php
	include_once 'footer.php';
?>