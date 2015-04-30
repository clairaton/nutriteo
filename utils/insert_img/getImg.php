<?php
require_once 'google_img.php';
require_once '../class/Db.php';

set_time_limit(0);

header('Content-Type: text/html; charset=utf-8');

function getContent($url){
	$fh = fopen($url, 'r');
	$data = fread($fh, 2048);
	fclose($fh);
	return $data;
}
function translate($text_trad,$langfrom='en',$langTo='fr') {
	$apiKey = "trnsl.1.1.20150416T154400Z.bbb2004e4c1e2d68.97dcb2e22e410ab4b416b172dc9fd9ecf495a5ac";
	$text_trad =  urlencode($text_trad);
 	$url = 'https://translate.yandex.net/api/v1.5/tr.json/translate?key='.$apiKey.'&lang='.$langfrom.'-'.$langTo.'&text='.$text_trad;
	//var_dump( $url);
		//$src = getContent($url);

			// Construct the Google Image API query


		// Get the result from query, returns a JSON object
		$json = file_get_contents($url);

		$results = json_decode($json, true);

		return cleanString($results['text'][0], array(), ' ');
 }

$db = Db::getInstance();

//$query =$db->query("SELECT * FROM food WHERE food_family_id IN (SELECT food_family_id FROM food_category_family WHERE food_category_id = 1) ORDER BY id ASC LIMIT 10");
//$query =$db->query("SELECT * FROM food WHERE food_family_id IN (661, 872, 964) AND picture_id = 1 ORDER BY id ASC"); // Fruits et légumes
$query =$db->query("SELECT * FROM food WHERE food_family_id IN (146, 210, 238, 361, 364, 434, 816, 974, 1211, 1462) AND picture_id = 1 AND priority = 1 ORDER BY id ASC"); // Boissons

//$query =$db->query("SELECT * FROM food WHERE id = 663");
$query->execute();
$foods=$query->fetchAll();

/*echo '<pre>';
print_r($foods);
echo '</pre>';*/

//site:delices-gourmandises.fr OR academ

$images_nok = array();

foreach ($foods as $key => $food) {

	$name_fr = strtok($food['name'], ' ');

	//$name_fr = explode(' ', $food['name']);


	//$name = $name_fr[0].' '.$name_fr[1];
	//$name = translate($name_fr, "fr", "en"); // 1er mot de name food en anglais
	$name = $name_fr; // 1er mot de name food en français
	//$name = $food['name']; // name food en entier

	$image_src = getGoogleImg($name);

	if (!empty($image_src)) {
		$image_params = pathinfo($image_src);
		$image_ext = $image_params['extension'];

		$image_dest = 'img/food/'.$food['id'].'.'.$image_ext;

		file_put_contents($image_dest, file_get_contents($image_src));

		echo $name.' : '.$image_dest.'<br>';
		$insert =$db->prepare('INSERT INTO picture (source, type) VALUES (:source, 1)
							   ON DUPLICATE KEY UPDATE id = id');
		$insert->bindValue('source', $image_dest, PDO::PARAM_STR);
		$insert->execute();
		$picture_id = $db->lastInsertId();

		$update = $db->prepare('UPDATE food SET picture_id = :picture_id WHERE id = :food_id');
		$update->bindValue('picture_id', $picture_id, PDO::PARAM_STR);
		$update->bindValue('food_id', $food['id'], PDO::PARAM_STR);
		$update->execute();


	} else {
		$images_nok[$food['id']] = array($name_fr, $name);
	}
}

echo '<br><br>';

echo json_encode($images_nok);