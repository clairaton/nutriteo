<?php
include_once 'header.php';

// @TODO mettre à jour la variable $date dynamiquement
$user = $_SESSION['user_id'];
$date = date('d-m-Y'); //@TODO = par défaut date du jour, sinon date envoyée en POST
// On instancie un objet nutriboard
$nutriboard = new Nutriboard($user, $date);

if(!empty($_GET)){
	if($_GET['date_range']=='week'){
		$date_range=Utils::weekDateRange();
		// On récupère le tableau par famille d'élément
		$tab_nutriements = $nutriboard -> getDashboardByRangeFamily($user, $date_range);
		// On récupère le tableau d'objet Nutriment
		$dashboard_by_nutriment = $nutriboard -> getDashboardByRange($user, $date_range);
		// On récupère le nutriscore
	}else if($_GET['date_range']=='month'){
		$date_range=Utils::monthDateRange();
		// On récupère le tableau par famille d'élément
		$tab_nutriements = $nutriboard -> getDashboardByRangeFamily($user, $date_range);
		// On récupère le tableau d'objet Nutriment
		$dashboard_by_nutriment = $nutriboard -> getDashboardByRange($user, $date_range);
		// On récupère le nutriscore
	}
}else{
	// On récupère le tableau par famille d'élément
	$tab_nutriements = $nutriboard -> getDashboardByFamily();
	// On récupère le tableau d'objet Nutriment
	$dashboard_by_nutriment = $nutriboard -> getDashboard();
	// On récupère le nutriscore
}
$nutriscore=$nutriboard -> getNutriscore($tab_nutriements);
// Variable pour afficher les infos d'inscription de user
$user_infos = User::getItem($user);

$user_avatar = User::getPicture($user_infos);

?>
<script type='text/JavaScript'>
	var nutriscore = <?php echo intval($nutriscore) ; ?>;
</script>
<div class="content-general col-xs-12 col-xs-offset col-sm-9">

	<div class="head">
		<div class ="photo-profil">
			<a href="profil.php">
				<img src="<?= $user_avatar ?>" alt="photo de profil"></div>
			</a>
		<div class="donnee-personnel">
			<h2 class ="name">
				<?= $_SESSION['lastname'] ?> <?= $_SESSION['firstname'] ?>
				<span class ="date-inscription">Inscrit depuis <?=date("d-m-Y", strtotime($user_infos['creation_date'])) ?></span>
			</h2>
			<h4 class ="program-choisi">Pas de programme choisi</h4>
		</div>
		<div id="container-speed"></div>
	</div>
	<div class="content">
		<?php include 'carnetSupp.php'; ?>
	</div>
</div>

<?php
	include_once 'sidebar.php';
	include_once 'footer.php';
?>