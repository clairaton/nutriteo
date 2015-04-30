<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet Allergy
*
* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
*/

class Allergy {

	/*************************************************************************
	 *																		 *
	 *		 						Properties    					         *
	 *									 									 *
	 ************************************************************************/

	private $_id;
	private $_name;
	private $_foods=array(); // tableau incluant les id_food correspondants de la table food_allergy



	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/**
	* \desc 	  La fonction va récupérer les infos de la table allergy pour un id_allergy donné
	*
	* \param      $allergy_id - un id de forme numérique >0
	*
	* \return     $allergy - un array associatif d'une seule ligne id => name.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getItem($allergy_id){
		$allergy = Utils::getItemById('allergy',$allergy_id);
		return $allergy;
	}

	/**
	* \desc 	  La fonction va créer un array d'objet Allergy à partir d'un array simple
	*
	* \param      $result - un array associatif de plusieurs allergies
	*
	* \return     $allergies - un array d'objet Allergy.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	private static function _getList($result) {
		$allergies = array();
		foreach($result as $allergy) {
			$allergies[] = new Allergy($allergy);
		}
		return $allergies;
	}

	/**
	* \desc 	  La fonction va récupérer les infos de la table allergy pour un id_allergy donné
	*
	* \return     $allergies - un array associatif d'objet Allergy.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getCompleteList(){
		try{
			$stmt = Db::getInstance() -> query('SELECT * FROM allergy ORDER BY name ASC');
			$result = $stmt->fetchAll();
			$allergies = self::_getList($result);

			return $allergies;

		}catch (Exception $e){
			echo $e -> getMessage();
		}
	}

	/****************************************************************
	*                           Construct                           *
	****************************************************************/

	public function __construct($allergy=array()){

		// on crée une boucle pour lancer l'ensemble des setters au construct
		foreach($allergy as $key => $value){
			$method= 'set'.Utils::camelCase($key);
			if(method_exists($this, $method)){
				$this->$method($value);
			}
		}
		$this->setFoods();
	}

	/****************************************************************
	*                             Setters                           *
	****************************************************************/

	public function setId($id){
		if(is_numeric($id) && $id>0){
			$this->_id=$id;
			return true;
		}
		throw new Exception ('ERROR: l\'id doit être un chiffre > 0');
	}

	public function setName($name){
		if(is_string($name) && strlen($name)<=100){
			$this->_name=$name;
			return true;
		}
		throw new Exception ('ERROR: le name doit être une chaîne de caractères de longueur inférieure à 100');
	}

	public function setFoods(){
		if(!empty(Food::getListAllergy($this->_id))){
			//la fonction getListAllergy de Food va récupérer en BDD les infos de food_allergy à partir d'un allergy_id et crée un objet Food pour chacun des aliments lié à l'allergy
			$this->_foods = Food::getListAllergy($this->_id);
		}
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

	public function getFoods(){
		return $this->_foods;
	}


}

