<?php

class NutrimentRef{

	private $_id;
	private $_nutriment_id;
	private $_quantity;
	private $_weight;
	private $_sex;
	private $_age_min;
	private $_age_max;


	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/**
	* \desc 	  La fonction va récupérer les infos de la table user pour un sex et un age donné
	*
	* \param      $sex - 0 ou 1 (0= femme , 1=homme)
	* \param 	  $age - un nombre entier compris entre 15 et 160 inclus
	*
	* \return     $objectives - un array associatif réperetoriant les objectifs quotidiens par nutriment.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getObjectives($sex, $age){
		try{
			$stmt = Db::getInstance() -> prepare ('SELECT * FROM nutriment_ref WHERE sex = :sex AND age_min <= :age AND age_max > :age');
			$stmt -> bindValue('sex', $sex, PDO::PARAM_INT);
			$stmt -> bindValue('age', $age, PDO::PARAM_INT);
			$stmt -> execute();
			$result = $stmt -> fetchAll();

			return self::_getList($result);
		}catch(Exception $e) {
    		echo $e->getMessage();
		}
	}

	/**
	* \desc 	  La fonction va créer un array d'objet NutrimentRef à partir d'un array simple
	*
	* \param      $result - un array associatif de plusieurs allergies
	*
	* \return     $objectives - un array d'objet NutrimentRef avec pour clé le nutriment_id.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	private static function _getList($result) {
		$objectives = array();
		foreach($result as $item) {
			$objectives[] = new NutrimentRef($item);
		}
		return $objectives;
	}

	/****************************************************************
	*                           Constructeur                        *
	****************************************************************/

	public function __construct($data=array()){

		// on crée une boucle pour lancer l'ensemble des setters au construct
		foreach($data as $key => $value){
			$method= 'set'.Utils::camelCase($key);
			if(method_exists($this, $method)){
				$this->$method($value);
			}
		}
	}

	/****************************************************************
	*                             Setters                           *
	****************************************************************/
	function setId($id){
		if(is_numeric($id)){
			$this->_id = $id;
			return true;
		}
		throw new Exception('ERROR : l\'id doit être un numérique.');

	}

	function setNutrimentId($nutriment_id){
		if(is_numeric($nutriment_id)){
			$this->_nutriment_id = $nutriment_id;
			return true;
		}
		throw new Exception('ERROR : l\'id doit être un numérique.');

	}

	function setQuantity($quantity){
		if(is_numeric($quantity)){
			$this->_quantity = $quantity;
			return true;
		}
		throw new Exception('ERROR : La quantité doit être un numérique.');

	}

	function setWeight($weight){
		//if(is_numeric($weight)){
			$this->_weight = $weight;
		//}
		//throw new Exception('ERROR : Le poids doit être un numérique.');
	}

	function setSex($sex){
		if(is_numeric($sex) && ($sex == 0 || $sex == 1)){
			$this->_sex = $sex;
			return true;
		}
		throw new Exception('ERROR : Le sex doit avoir la valeur 0 (femme) ou 1(homme)');
	}

	function setAgeMin($age_min){
		if(is_numeric($age_min) && $age_min > 12){
			$this->_age_min = $age_min;
			return true;
		}
		throw new Exception('ERROR : L\'age minimum doit être un entier supérieur à 12.');
	}

	function setAgeMax($age_max){
		if(is_numeric($age_max) && $age_max < 161){
			$this->_age_max = $age_max;
			return true;
		}
		throw new Exception('ERROR : L\'age maximum doit être un entier inférieur à 160.');
	}

	/****************************************************************
	*                             Getters                           *
	****************************************************************/
	function getId(){
		return $this->_id;
	}

	function getNutrimentId(){
		return $this->_nutriment_id;
	}

	function getQuantity(){
		return $this->_quantity;
	}

	function getWeight(){
		return $this->_weight;
	}

	function getSex(){
		return $this->_sex;
	}

	function getAgeMin(){
		return $this->_age_min;
	}

	function getAgeMax(){
		return $this->_age_max;
	}


}