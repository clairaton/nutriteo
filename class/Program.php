<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet Program
*
* @author   Clément CAIRO Alias K.net
*/

class Program{

	private $_id;
	private $_name;

	private $_program_nutriment = array();

	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/**
	* \desc 	  La fonction va récupérer les infos de la table program pour un id_program donné
	*
	* \param      $program_id - un id de forme numérique >0
	*
	* \return     $program - un array associatif d'une seule ligne id => name.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getItem($program_id){
		$program = Utils::getItemById('program',$program_id);
		return $program;
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

	public function setProgramNutriment(){
		$this->_program_nutriment = Nutriment::getProgramList($this->_id)
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

}