<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet Nutriment
*
* @author   Clément CAIRO Alias K.net
*/

class Nutriment{

	private $_id;
	private $_name;
	private $_unity;
	private $_description;

	//@TODO : A quoi correspond cette propriéte? d'où provient-elle? à quoi sert-elle? Mise en comments en attaendant
	//public $nutriWeigth = array();

	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/**
	* \desc 	  La fonction va créer un array d'objet nutriment à partir d'un array simple
	*
	* \param      $result - un array associatif de plusieurs nutriments
	*
	* \return     $nutriments - un array d'objet nutriment.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	private static function _getList($result) {
		$nutriments = array();
		foreach($result as $nutriment) {
			$nutriments[] = new Nutriment($nutriment);
		}
		return $nutriments;
	}

	/* ------------------------ Interaction BDD ------------------------*/


	/**
	* \desc 	  La fonction va récupérer les infos de la table nutriment pour un id_nutriment donné
	*
	* \param      $nutriment_id - un id de forme numérique >0
	*
	* \return     $nutriment - un array associatif d'une seule ligne id => name.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getItem($nutriment_id){
		$nutriment = Utils::getItemById('nutriment',$nutriment_id);
		return $nutriment;
	}

	/**
	* \desc 	  La fonction va récupérer les infos de la table nutriment_family pour un id_family donné
	*
	* \param      $family_id - un id de forme numérique >0
	*
	* \return     $family - un array associatif d'une seule ligne id => name.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getFamilyItem($family_id){
		$family = Utils::getItemById('nutriment_family',$family_id);
		return $family;
	}

	/**
	* \desc 	  La fonction va récupérer l'ensemble des infos de la table nutriment
	*
	* \return     $nutriments - un array associatif d'objet Nutriment.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getCompleteList(){
		try{
			$stmt = Db::getInstance() -> query('SELECT * FROM nutriment');
			$result = $stmt->fetchAll();

			$nutriments = self::_getList($result);

			return $nutriments;
		}catch (Exception $e){
			echo $e -> getMessage();
		}
	}

	/**
	* \desc 	  La fonction va récupérer les données nutriments pour une famille de nutriments
	*
	* \param      $nutriment_family_id
	*
	* \return     $nutriments - un array d'objet nutriment.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getListByFamily($nutriment_family_id){
			$stmt = Db::getInstance()->prepare('SELECT * FROM nutriment WHERE nutriment_family_id = :nutriment_family_id');
			$stmt -> bindValue('nutriment_family_id', $nutriment_family_id, PDO::PARAM_INT);
			$stmt -> execute();
			$result = $stmt -> fetchAll();

			$nutriments = self::_getList($result);
			return $nutriments;
	}

	/**
	* \desc 	  La fonction va récupérer la liste des familles de nutriments
	*
	* \return     $result - un array de familles de nutriments
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getFamilyList(){
			$stmt = Db::getInstance()->query('SELECT * FROM nutriment_family ORDER BY board_order ASC');
			$result = $stmt -> fetchAll();

			return $result;
	}


	/****************************************************************
	*                           Constructeur                        *
	****************************************************************/

	public function __construct($post=array()){

		// on crée une boucle pour lancer l'ensemble des setters au construct
		foreach($post as $key => $value){
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
		if(is_string($name) && strlen($name)<=45){
			$this->_name = $name;
			return true;
		}
		throw new Exception('ERROR: name doit être une chaîne de caractères <= 45');
	}

	public function setUnity($unity){
		if(is_string($unity) && strlen($unity)<=5){
			$this->_unity = $unity;
			return true;
		}
		throw new Exception('ERROR: l\'unity doit être une chaîne de caractères <= 5');
	}

	public function setDescription($description){
		if(is_string($description)){
			$this->_description = $description;
			return true;
		}
		throw new Exception('ERROR: la description doit être une chaîne de caractères');
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

	public function getUnity(){
		return $this->_unity;
	}

	public function getDescription(){
		return nl2br($this->_description);
	}

	//@ TODO: à voir lors d'une version qui utilise les programs
	/*public static function getProgramList($program_id){

	}*/

}