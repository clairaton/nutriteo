<?php
include_once 'header.php';

$db = Db::getInstance();

$user_id = $_SESSION['user_id'];

//oninitialise la variable d'error
$error = array();
$avatar = "";
$birthdate="";
$size = "";
$weight = "";
$email = "";


// verification du formulaire
if (!empty($_POST)) {

	// On recupere les donnée dans des variables
	$birthdate = strip_tags($_POST['birthdate']);
	$size = strip_tags($_POST['size']);
	$weight = strip_tags ($_POST['weight']);
	$email = strip_tags($_POST['email']);

	// debut de verification
	// image
	$avatar = !empty($_FILES["avatar"]['name'])? $_FILES["avatar"]['name'] : '';
	//birthdate
	if (empty($_POST["birthdate"])){
		$error["birthdate"] = "Veuillez renseigner votre date de naissance svp.";
	}
	// Size
	if (empty($_POST['size']) || !is_numeric($_POST['size'])) {
		$error["size"] = "Veuillez renseigner votre taille svp.";
	}
	// Weight
	if (empty($_POST['weight']) || !is_numeric($_POST['weight'])) {
		$error["weight"] = "Veuillez renseigner votre poid svp.";
	}
	//email
	if (empty($email)){
		$error["email"] = "Veuillez renseigner votre email svp.";
	}
	//email valide
	elseif ( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error["email"] = "Votre email n'est pas valide !";
	}
	//fin de verification

	if(empty($error)){

		unset($_POST['avatar']);

		User::updateData($user_id, $_POST);

		if (!empty($_FILES) && !empty($avatar)) {

			$file_extensions = array(
				'png',
				'jpg',
				'jpeg',
			);

            $max_size = 2000000;

            if ($_FILES['avatar']['error'] == UPLOAD_ERR_OK && $_FILES['avatar']['size'] < $max_size) {

                $user_file_name = $_FILES['avatar']['name'];
                $user_file_infos = pathinfo($user_file_name);
                $user_file_extension = $user_file_infos['extension'];

                $avatar = 'img/avatars/'.$user_id;

                foreach($file_extensions as $file_extension) {
                	if (file_exists($avatar.'.'.$file_extension)) {
                		unlink($avatar.'.'.$file_extension);
                	}
                }

                move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar.'.'.$user_file_extension);

				if ($db->beginTransaction()) {

	                $query = $db->prepare("UPDATE user SET picture_id = 3 WHERE id = :user_id");
	                $query->bindValue('user_id', $user_id, PDO::PARAM_INT);
	                $query->execute();

					$query = $db->prepare("DELETE FROM picture WHERE source LIKE :source AND type = 2");
	                $query->bindValue('source', $avatar.'.%', PDO::PARAM_STR);
	                $query->execute();

	                $db->commit();

				}


				$query = $db->prepare("INSERT INTO picture SET source = :source, type = 2");
                $query->bindValue('source', $avatar.'.'.$user_file_extension, PDO::PARAM_STR);
                $query->execute();
                $picture_id = $db->lastInsertId();

                $query = $db->prepare("UPDATE user SET picture_id = :picture_id WHERE id = :user_id");
                $query->bindValue('picture_id', $picture_id, PDO::PARAM_INT);
                $query->bindValue('user_id', $user_id, PDO::PARAM_INT);
                $query->execute();
            }
   		}

   		header('Location: profil.php');
	}
}

// Variable pour afficher les infos d'inscription de user
$user_infos = User::getItem($user_id);

$user_avatar = User::getPicture($user_infos);

?>

<form id="form-profil" enctype="multipart/form-data" class="content-general user" method="POST">
	<div class ="profil-image">
		<img src="<?= $user_avatar ?>" alt="photo de profil">
		<input type="file"  name="avatar" id="upload_avatar">
		<input type="button" id="profil-button" onclick="$('#upload_avatar').click()" value="Choisissez votre photo">
	</div>
	<p id="profil-param">
		<a href="javascript:void(0)" class="edit-date"><span class="glyphicon glyphicon-pencil"></span></a>Date de naissance: <?=date("d-m-Y", strtotime($user_infos['birthdate'])) ?>
		<input type="hidden"  class="form-control input-profil" name="birthdate" min="1920-01-02" max="2000-01-02" value="<?=$user_infos['birthdate']?>" placeholder="jj-mm-aaaa">

		<p id="error"><?php if(!empty($error['birthdate']))echo $error['birthdate']; ?></p>

	</p>
	<p id="profil-param">
		<a href="javascript:void(0)" class="edit"><span class="glyphicon glyphicon-pencil"></span></a>Taille: <?=$user_infos['size']?> cm
		<select  id="size-profil"  class="form-control input-profil" name="size">
			<option value="">Je mesure...</option>
			<?php
			for ($i=100; $i <251 ; $i++) {
				if(!empty($user_infos['size']) && $user_infos['size'] == $i){
					echo '<option value="'.$i.'" selected>'.$i.' cm</option>';
				}else{
					echo '<option value="'.$i.'">'.$i.' cm</option>';
				}
			}
			?><?php  ?>
		</select>

		<p id="error"><?php if(!empty($error['size']))echo $error['size']; ?></p>
	</p>
	<p id="profil-param">
		<a href="javascript:void(0)" class="edit"><span class="glyphicon glyphicon-pencil"></span></a>Poid: <?=$user_infos['weight']?> kg
		<select  id="weight-profil" class="form-control input-profil" name="weight">
			<option value="">Je pèse...</option>
			<?php
			for ($i=30; $i <301 ; $i++) {
				if(!empty($user_infos['weight']) && $user_infos['weight'] == $i){
					echo '<option value="'.$i.'" selected>'.$i.' kg</option>';
				}else{
					echo '<option value="'.$i.'">'.$i.' kg</option>';
				}
			}
			?><?php  ?>
		</select>

		<p id="error"><?php if(!empty($error['weight']))echo $error['weight']; ?></p>
	</p>
	<p id="profil-param">
		<a href="javascript:void(0)" class="edit"><span class="glyphicon glyphicon-pencil"></span></a>Adress email: <?=$user_infos['email'] ?>
		<input  type="hidden" class="form-control input-profil" name="email" value="<?=$user_infos['email']?>">

		<p id="error"><?php if(!empty($error['email']))echo $error['email']; ?></p>

	</p>

	<p id="bloc-submit-profil">
	<button id="user-submit" type="submit" class="btn btn-success">Valider</button>
	</p>
</form>

<?php
	include_once 'footer.php';
	include_once 'sidebar.php';
?>
