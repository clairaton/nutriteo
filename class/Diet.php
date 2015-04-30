<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet Diet
*
* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
*/

class Diet{

	/*************************************************************************
	 *																		 *
	 *		 						Properties    					         *
	 *									 									 *
	 ************************************************************************/

	private $_id;
	private $_name;

	private $_foods =array(); // tableau d'objets Food exclus de la diet



	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/**
	* \desc 	  La fonction va récupérer les infos de la table diet pour un id_diet donné
	*
	* \param      $diet_id - un id de forme numérique >0
	*
	* \return     $diet - un array associatif d'une seule ligne id => name.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getItem($diet_id){
		$diet = Utils::getItemById('diet',$diet_id);
		return $diet;
	}

	/**
	* \desc 	  La fonction va créer un array d'objet Diet à partir d'un array simple
	*
	* \param      $result - un array associatif de plusieurs allergies
	*
	* \return     $diets - un array d'objet Diet.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	private static function _getList($result) {
		$diets = array();
		foreach($result as $diet) {
			$diets[] = new Diet($diet);
		}
		return $diets;
	}

	/**
	* \desc 	  La fonction va récupérer les infos de la table diet pour un id_diet donné
	*
	* \return     $allergies - un array associatif d'objet Diet.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getCompleteList(){
		try{
			$stmt = Db::getInstance() -> query('SELECT * FROM diet ORDER BY name ASC');
			$result = $stmt->fetchAll();

			$diets = self::_getList($result);

			return $diets;
		}catch (Exception $e){
			echo $e -> getMessage();
		}
	}


	/****************************************************************
	*                           Construct                           *
	****************************************************************/

	public function __construct($diet=array()){

		// on crée une boucle pour lancer l'ensemble des setters au construct
		foreach($diet as $key => $value){
			$method= 'set'.Utils::camelCase($key);
			if(method_exists($this, $method)){
				$this->$method($value);
			}
		}
		$this -> setFoods();
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
		if(!empty(Food::getListDiet($this->_id))){
			//la fonction getListDiet de Food Va récupérer en BDD les infos de food_diet_exclusion à partir d'un diet_id et crée un objet Food pour chacun des aliments lié à la diet
			$this->_foods = Food::getListDiet($this->_id);
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



