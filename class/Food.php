<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet Food
*
* @author   Clément CAIRO Alias K.net
*/

class Food{

	private $_id;
	private $_name;
	private $_picture_id;


	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/* ------------------------ Interaction BDD ------------------------*/

	/**
	* \desc 	  La fonction va récupérer les infos de la table food pour un id_food donné
	*
	* \param      $food_id - un id de forme numérique >0
	*
	* \return     $food - un array associatif d'une seule ligne id => name.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getItem($food_id){
		$food = Utils::getItemById('food',$food_id);
		return $food;
	}

	/**
	* \desc 	  La fonction va créer un array d'objet Food à partir d'un array simple
	*
	* \param      $result - un array associatif de plusieurs allergies
	*
	* \return     $foods - un array d'objet Food.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	private static function _getList($result) {
		$foods = array();
		foreach($result as $food) {
			$foods[] = new Food($food);
		}
		return $foods;
	}

	/**
	* \desc 	  La fonction va récupérer l'ensemble des infos de la table food
	*
	* \return     $foods - un array associatif d'objet Food.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getCompleteList(){
		try{
			$stmt = Db::getInstance() -> query('SELECT * FROM food');
			$result = $stmt->fetchAll();

			$foods = self::_getList($result);

			return $foods;
		}catch (Exception $e){
			echo $e -> getMessage();
		}
	}

	/**
	* \desc 	  La fonction va récupérer un nombre limité d'aliments de la table food
	*
	* \return     $foods - un array associatif d'objet Food.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	* @modif 	  Clément CAIRO aka K.net modification de la rêquete, ajout du jointure avec la table food_category_family
	*/

	public static function getLimitListByFamily($category_id, $limit){
		try{
			$stmt = Db::getInstance() -> prepare('SELECT f.id as id, f.name as name, f.picture_id as picture_id, f.food_family_id as food_family_id
													FROM food f, food_category_family fcf
													WHERE f.food_family_id = fcf.food_family_id AND fcf.food_category_id = :category_id ORDER BY priority DESC LIMIT :limit');
			$stmt -> bindValue('category_id',$category_id, PDO::PARAM_INT);
			$stmt -> bindValue('limit',$limit, PDO::PARAM_INT);
			$stmt -> execute();
			$result = $stmt->fetchAll();

			$foods = self::_getList($result);

			return $foods;
		}catch (Exception $e){
			echo $e -> getMessage();
		}
	}

	/**
	* \desc 	  La fonction va récupérer l'ensemble des catégories d'aliments
	*
	* \return     $food_category - un array associatif de categorie_food (id => name).
	*
	* @author     Clément CAIRO aka K.net
	*/

	public static function getCategoryList(){
		// on récupère la liste des categories
		$stmt = Db::getInstance() -> query('SELECT * FROM food_category ORDER BY id ASC');
		$food_categories = $stmt -> fetchAll();

		return $food_categories;
	}

	/**
	* \desc 	  La fonction va récupérer un nombre limité d'aliments de la table food dans laquelle il y a le plus d'un nutriment donné
	*
	* \param 	  $nutriment_id
	* \param      $limit
	*
	* \return     $foods - un array associatif d'objet Food.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*
	*/


	public static function getLimitListByNutriment($nutriment_id, $limit){
		try{
			$stmt = Db::getInstance() -> prepare('SELECT f.id as id, f.name as name, f.picture_id as picture_id
				FROM food_nutriment as fn
				JOIN food as f ON fn.food_id = f.id
				WHERE fn.nutriment_id = :nutriment_id
				ORDER BY fn.nutriment_quantity DESC
				LIMIT :limit');
			$stmt -> bindValue('nutriment_id', $nutriment_id, PDO::PARAM_INT);
			$stmt -> bindValue('limit', $limit, PDO::PARAM_INT);
			$stmt -> execute();
			$result = $stmt->fetchAll();

			$foods = self::_getList($result);

			return $foods;
		}catch (Exception $e){
			echo $e -> getMessage();
		}
	}

	/**
	* \desc 	  La fonction va récupérer un nombre limité d'aliments de la table food dans laquelle il y a le plus d'un nutriment donné
	*
	* \param 	  $nutriment_id
	* \param      $limit
	*
	* \return     $foods - un array associatif d'objet Food.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*
	*/


	public static function getListByNutrimentFamily($family_id, $limit){
		try{
			$stmt = Db::getInstance() -> prepare('SELECT f.id as id, f.name as name, f.picture_id as picture_id
				FROM food_nutriment as fn
				INNER JOIN food as f ON fn.food_id = f.id
				INNER JOIN nutriment as n ON n.id = fn.nutriment_id
				WHERE n.nutriment_family_id = :family_id
				ORDER BY fn.nutriment_quantity DESC
				LIMIT :limit');
			$stmt -> bindValue('family_id', $family_id, PDO::PARAM_INT);
			$stmt -> bindValue('limit', $limit, PDO::PARAM_INT);
			$stmt -> execute();
			$result = $stmt->fetchAll();

			$foods = self::_getList($result);

			return $foods;
		}catch (Exception $e){
			echo $e -> getMessage();
		}
	}

	/**
	* \desc 	  La fonction va récupérer l'ensemble des familles d'aliments
	*
	* \return     $food_families - un array associatif de family_food (id => name).
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getFamilyList(){
		// on récupère les infos des aliments interdits pour l'allergy demandée
		$stmt = Db::getInstance() -> query('SELECT * FROM food_family ORDER BY id ASC');
		$food_families = $stmt -> fetchAll();

		return $food_families;
	}

	/**
	* \desc 	  La fonction va récupérer l'ensemble des aliments faisant partie d'une allergie
	*
	* \param      $id_allergy - une valeur numérique correspondant à l'id d'une allergie
	*
	* \return     $foods - un array associatif d'objet Food.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getListAllergy($id_allergy){
		// on récupère les infos des aliments interdits pour l'allergy demandée
		$stmt = Db::getInstance() -> prepare('SELECT f.id, f.name, f.picture_id, f.food_family_id FROM food_allergy as fa JOIN food as f ON fa.food_id = f.id WHERE fa.allergy_id = :id_allergy');
		$stmt -> bindValue('id_allergy', $id_allergy, PDO::PARAM_INT);
		$stmt -> execute();
		$result = $stmt -> fetchAll();

		$foods = self::_getList($result);

		return $foods;
	}

	/**
	* \desc 	  La fonction va récupérer l'ensemble des aliments faisant partie d'une diet
	*
	* \param      $id_diet - une valeur numérique correspondant à l'id d'une diet
	*
	* \return     $foods - un array associatif d'objet Food.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getListDiet($id_diet){
		// on récupère les infos des aliments interdits pour l'diet demandée
		$stmt = Db::getInstance() -> prepare('SELECT f.id, f.name, f.picture_id, f.food_family_id FROM food_diet_exclusion as fde JOIN food as f ON fde.food_id = f.id WHERE fde.diet_id = :id_diet');
		$stmt -> bindValue('id_diet', $id_diet, PDO::PARAM_INT);
		$stmt -> execute();
		$result = $stmt -> fetchAll();

		$foods = self::_getList($result);

		return $foods;
	}

	/**
	* \desc 	  La fonction va récupérer l'ensemble des aliments de la table user_food pour un id et une date donnée
	*
	* \param      $user_id - une valeur numérique correspondant à l'id d'un user
	* \param      $date - une date au format 'jj-mm-AAAA'
	*
	* \return     $foods - un array de quantité par id food.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getListByUser($user_id, $date_insert){
		// on récupère les infos des aliments interdits pour l'diet demandée
		$stmt = Db::getInstance() -> prepare("SELECT food_id, quantity FROM user_food WHERE user_id = :user_id AND DATE_FORMAT(date_insert, '%d-%m-%Y') = :date_insert");
		$stmt -> bindValue('user_id', $user_id, PDO::PARAM_INT);
		$stmt -> bindValue('date_insert', $date_insert, PDO::PARAM_STR);
		$stmt -> execute();
		$result = $stmt -> fetchAll();

		//return $result;
		$foods =array();
		foreach($result as $item){
			$foods[$item['food_id']] = $item['quantity'];
		}
		return $foods;
	}

	/**
	* \desc 	  La fonction va récupérer l'ensemble des aliments de la table user_food pour un id et une date donnée
	*
	* \param      $food - un array comprenant un user_id, un food_id, une quantity et une date
	*
	* \return     $result - l'id de la dernière ligne insérée.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function insertFoodByUser($user_id, $food_id, $quantity, $date){
		//@TODO: à tester
		$stmt = Db::getInstance() -> prepare('INSERT INTO user_food (user_id, food_id, quantity, date_insert) VALUES (:user_id, :food_id, :quantity, :date_insert)');
		$stmt -> bindvalue('user_id', $user_id,PDO::PARAM_INT);
		$stmt -> bindvalue('food_id',$food_id,PDO::PARAM_INT);
		$stmt -> bindvalue('quantity',$quantity,PDO::PARAM_INT);
		$stmt -> bindvalue('date_insert',$date,PDO::PARAM_INT);
		$stmt -> execute();
		$result = Db::getInstance() ->lastInsertId();

		return $result;
	}






	/****************************************************************
	*                           Constructeur                        *
	****************************************************************/

	public function __construct($food=array()){

		// on crée une boucle pour lancer l'ensemble des setters au construct
		foreach($food as $key => $value){
			$method= 'set'.Utils::camelCase($key);
			if(method_exists($this, $method)){
				$this->$method($value);
			}
		}
	}

	/****************************************************************
	*                             Setters                           *
	****************************************************************/
	public function setId($id){
		if(is_numeric($id)){
			$this->_id = $id;
			return true;
		}
		throw new Exception('ERROR : L\'id doit être un entier');
	}

	public function setName($name){
		if(is_string($name) && strlen($name)<=60){
			$this->_name = $name;
			return true;
		}
		throw new Exception('ERROR: name doit être une chaîne de caractères <= 45');

	}

	public function setPictureId($picture_id){
		if(is_numeric($picture_id)){
			$this->_picture_id = $picture_id;
			return true;
		}
		throw new Exception('ERROR : picture_id doit être un entier');
	}

	/****************************************************************
	*                             Getters                           *
	****************************************************************/
	public function getId(){
		return $this->_id;
	}

	public function getName(){
		return ucfirst($this->_name);
	}

	public function getPictureId(){
		return $this->_picture_id;
	}

}