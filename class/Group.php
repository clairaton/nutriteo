<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet Group
*
* @author   Clément CAIRO Alias K.net
*/

class Group{

	private $_id;
	private $_name;
	private $_program_id;

	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

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
		throw new Exception('ERROR: le name doit être une chaîne de caractères <= 45');

	}

	public function setProgramId($program_id){
		if(is_numeric($program_id)){
			$this->_program_id = $program_id;
			return true;
		}
		throw new Exception('ERROR : Le program_id doit être un entier');
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

	public function getProgramId(){
		return $this->_program_id;
	}

}