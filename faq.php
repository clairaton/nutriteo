<?php
	include_once 'header.php';


	$tab_onglet_faq =
	[
		['nom' => 'Question 1', 'id' => 'q1', 'res' => 'r1'],
		['nom' => 'Question 2', 'id' => 'q2', 'res' => 'r2'],
		['nom' => 'Question 3', 'id' => 'q3', 'res' => 'r3'],
		['nom' => 'Question 4', 'id' => 'q4', 'res' => 'r4'],
		['nom' => 'Question 5', 'id' => 'q5', 'res' => 'r5'],
		['nom' => 'Question 6', 'id' => 'q6', 'res' => 'r6']
	];
?>
<div class="content-general-faq">
	<h2>Questions fréquentes</h2>


	<div id="sujet-1">
		<div class="accordion">
			<h3>A quoi sert Nutriteo ?</h3>
			<div>
				<p>Nutriteo permet de connaître votre apport nutritionel quotidien en fonction des aliments que vous consommez. L'apport nutritionnel est calculé en fontion de votre profil (Age, poids, taille, activité physique mais aussi en fonction de vos allergies et de vos régimes alimentaires).</p>
			</div><!--End of QUESTION 1-->

			<h3>A qui s'adresse Nutriteo ?</h3>
			<div>
				<p>Nutriteo s'adresse à toutes les personnes souhaitant connaitre leurs apports quotidien en nutriments et ameliorer leur alimentation. Vous pouvez choisir un programme en fonction de vos objectifs.<br><a href="program.php">Consulter les programmes disponibles.</a></p>
			</div><!--End of QUESTION 2-->

			<h3>Comment utiliser Nutriteo ?</h3>
			<div>
				<p>L'utilisation est simple et rapide. Voici les différentes étapes :</p>
				<ul>
				<li>Renseignez vos aliments consommés dans la journée</li>
					<p>......</p>
				<li>Précisez votre activité physique de la journée</li>
					<p>......</p>
				<li>Consultez votre carnet nutritionel</li>
					<p>......</p>
				</ul>
			</div><!--End of QUESTION 3-->

			<h3>QUESTION 4</h3>
			<div>
				<p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
			</div><!--End of QUESTION 4-->

			<h3>QUESTION 5</h3>
			<div>
				<p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
			</div><!--End of QUESTION 5-->

		</div><!--End of ACCORDION-->
	</div><!--End of SUJET 1-->
</div>

<?php
	include_once 'footer.php';
?>