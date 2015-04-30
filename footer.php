			</div><!-- containner-fluid-->
		</main>

		<script type="" src="js/jquery.js"></script>
		<script type="" src="js/jquery-ui.min.js"></script>
		<script type="" src="js/datepicker-fr.js"></script>
		<script src="http://code.highcharts.com/highcharts.js"></script>
		<script src="http://code.highcharts.com/highcharts-more.js"></script>
		<script src="http://code.highcharts.com/modules/solid-gauge.js"></script>
		<script type="" src="js/app.js"></script>
		<script type="" src="js/popup_inscription.js"></script>
		<script type="" src="js/addfood.js"></script>
		<script type="" src="js/activitesphysique.js"></script>
		<?php if ($current_page == 'carnet.php') { ?>
		<script type="" src="js/carnet.js"></script>
		<?php } ?>
		<script type="" src="js/popup_inscription.js"></script>

		<script type="" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

	</body>
	<footer id="footer">
		<div id="menu" class="menu-footer nav">
			<a href="carnet.php" alt="tableau de bord" class="btn-nav">Mon tableau de bord</a>
			<a href="nutrition.php" alt="la nutrition" class="btn-nav">La nutrition</a>
			<a href="faq.php" alt="utiliser nutriteo" class="btn-nav">Utiliser nutriteo</a>
			<a href="contact.php" alt="nous contacter" class="btn-nav">Nous contacter</a>
			<a href="index.php" class="btn btn-danger" alt="deconnexion" id="deconnecter">Se deconnecter</a>
		</div>
	</footer>
</html>