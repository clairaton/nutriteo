<?php
set_time_limit(0);

header('Content-Type: text/html; charset=utf-8');

function cleanNumber($str) {
	$str = str_replace("-", "0", $str);
	$str = str_replace("<", "", $str);
	return str_replace(",", ".", $str);
}

require_once '../class/Db.php';

$db = Db::getInstance();

$cols = array(
	0 => 'food_family_id', // Ignore
	1 => 'food_family', // Food family
	2 => 'food_id', // Ignore
	3 => 'food_name', // Food name
	4 => 39, // Sodium (mg/100g)
	5 => 34, //Magnésium (mg/100g)
	6 => 36, // Phosphore (mg/100g)
	7 => 37, // Potassium (mg/100g)
	8 => 31, // Calcium (mg/100g)
	9 => 35, // Manganèse (mg/100g)
	10 => 33, // Fer (mg/100g)
	11 => 32, // Cuivre (mg/100g)
	12 => 41, // Zinc (mg/100g)
	13 => 38, // Sélénium (µg/100g)
	14 => 46, // Iode (µg/100g)
	15 => 10, // Protéines (g/100g)
	16 => 10, // Protéines brutes, N x 6_25 (g/100g)
	17 => 12, // Glucides (g/100g)
	18 => 12, // Sucres (g/100g)
	19 =>  0, // Energie, Règlement UE N° 1169/2011 (kJ/100g) //***// IGNORER LE NUTRIMENT //***//
	20 => 43, // Energie, Règlement UE N° 1169/2011 (kcal/100g)
	21 => 12, // Amidon (g/100g)
	22 => 0, // Energie, N x facteur Jones, avec fibres (kJ/100g) //***// IGNORER LE NUTRIMENT //***//
	23 => 0, // Energie, N x facteur Jones, avec fibres (kcal/100g) //***// IGNORER LE NUTRIMENT //***//
	24 => 0, // Polyols totaux (g/100g) //***// IGNORER LE NUTRIMENT //***//
	25 => 11, // Fibres (g/100g)
	26 => 19, // Eau (g/100g)
	27 => 44, // Lipides (g/100g)
	28 => 13, // AG saturés (g/100g)
	29 => 14, // AG monoinsaturés (g/100g)
	30 => 17, // AG polyinsaturés (g/100g)
	31 => 0, // AG 4:0, butyrique (g/100g)
	32 => 0, // AG 6:0, caproïque (g/100g)
	33 => 0, // AG 8:0, caprylique (g/100g)
	34 => 0, // AG 10:0, caprique (g/100g
	35 => 0, // AG 12:0, laurique (g/100g)
	36 => 0, // AG 14:0, myristique (g/100g)
	37 => 0, // AG 16:0, palmitique (g/100g)
	38 => 0, // AG 18:0, stéarique (g/100g)
	39 => 14, // AG 18:1 9c (n-9), oléique (g/100g)
	40 => 15, // AG 18:2 9c,12c (n-6), linoléique (g/100g)
	41 => 16, // AG 18:3 c9,c12,c15 (n-3), alpha-linolénique (g/100g)
	42 => 15, // AG 20:4 5c,8c,11c,14c (n-6), arachidonique (g/100g)
	43 => 16, // AG 20:5 5c,8c,11c,14c,17c (n-3) EPA (g/100g)
	44 => 16, // AG 22:6 4c,7c,10c,13c,16c,19c (n-3) DHA (g/100g)
	45 => 20, // Rétinol (µg/100g)
	46 => 20, // Beta-Carotène (µg/100g)
	47 => 28, // Vitamine D (µg/100g)
	48 => 29, // Vitamine E (mg/100g)
	49 => 30, // Vitamine K1 (µg/100g)
	50 => 30, // Vitamine K2 (µg/100g)
	51 => 27, // Vitamine C (mg/100g)
	52 => 21, // Vitamine B1 ou Thiamine (mg/100g)
	53 => 22, // Vitamine B2 ou Riboflavine (mg/100g)
	54 => 45, // Vitamine B3 ou PP ou Niacine (mg/100g) // a ajouter //
	55 => 23, // Vitamine B5 ou Acide pantothénique (mg/100g)
	56 => 24, // Vitamine B6 (mg/100g)
	57 => 26, // Vitamine B12 (µg/100g)
	58 => 25, // Vitamine B9 ou Folates totaux (µg/100g)
	59 => 0, // Alcool (g/100g) //***// IGNORER LE NUTRIMENT //***//
	60 => 0, // Acides organiques (g/100g) //***// IGNORER LE NUTRIMENT //***//
	61 => 18, // Cholestérol (mg/100g)
);

$results = array();


$row = 1;
if (($handle = fopen("ciqual.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 4096, ";")) !== FALSE) {

        if ($row > 1) {

    		$food_family = $data[1];

    		// INSERT INTO food_family SET name = 'poisson' ON DUPLICATE KEY UPDATE id = id

    		$food_name = $data[3];

    		foreach($data as $key => $val) {

	    		if ($key > 3) {

	    			if ($cols[$key] == 0) {
	    				continue;
	    			}

	    			$val = floatval(cleanNumber($val));

	    			if (!isset($food_nutriments[$food_name][$cols[$key]])) {
	    				$food_nutriments[$food_name][$cols[$key]] = 0.0;
	    			}

	    			$food_nutriments[$food_name][$cols[$key]] += $val;
	    		}
    		}

    		ksort($food_nutriments[$food_name]);

        	$results[] = array(
        		'food_family' => $food_family,
        		'food_name' => $food_name,
        		'food_nutriments' => $food_nutriments[$food_name]
        	);
        }

        $row++;


        //echo print_r($data, true).'<br>';
    }
    fclose($handle);
}

/*
echo '<pre>';
print_r($results);
echo '</pre>';
*/

$food_families = array();

foreach ($results as $key => $value) {

	//echo $label.' '.$val.'<br>';

	$food_family = $value['food_family'];
	$food_name = $value['food_name'];
	$food_nutriments = $value['food_nutriments'];

	echo '<hr>';

	echo 'INSERT INTO food_family (name) VALUES ("'.$food_family.'") ON DUPLICATE KEY UPDATE id=id';
	$query = $db->prepare('INSERT INTO food_family (name) VALUES (:name) ON DUPLICATE KEY UPDATE id=id');
	$query->bindValue('name', $food_family, PDO::PARAM_STR);
	$query->execute();
	$food_family_id = $db->lastInsertId();
	//$food_family_id = 1; //test

	if (!isset($food_families[$food_family])) {
		$food_families[$food_family] = $food_family_id;
	}

	echo '<hr>';

	echo 'INSERT INTO food (name, food_family_id) VALUES ("'.$food_name.'", '.$food_families[$food_family].') ON DUPLICATE KEY UPDATE id=id';
	$query = $db->prepare('INSERT INTO food (name, food_family_id) VALUES (:name, :food_family_id) ON DUPLICATE KEY UPDATE id=id');
	$query->bindValue('name', $food_name, PDO::PARAM_STR);
	$query->bindValue('food_family_id', $food_families[$food_family], PDO::PARAM_INT);
	$query->execute();
	$food_id = $db->lastInsertId();
	//$food_id = 2; //test

	echo '<hr>';

	foreach ($food_nutriments as $nutriment_id => $nutriment_quantity) {

		if (empty($nutriment_id)) {
			continue;
		}

		echo '<b>INSERT INTO food_nutriment (food_id, nutriment_id, nutriment_quantity) VALUES ('.$food_id.', '.$nutriment_id.', '.$nutriment_quantity.')</b>';
		echo '<br>';
		$query = $db->prepare('INSERT INTO food_nutriment (food_id, nutriment_id, nutriment_quantity) VALUES (:food_id, :nutriment_id, :nutriment_quantity)');
		$query->bindValue('food_id', $food_id, PDO::PARAM_INT);
		$query->bindValue('nutriment_id', $nutriment_id, PDO::PARAM_INT);
		$query->bindValue('nutriment_quantity', $nutriment_quantity, PDO::PARAM_INT);
		$query->execute();
		//$nutriment_id = $db->lastInsertId();
		//$food_id = 3;
	}

}

?>