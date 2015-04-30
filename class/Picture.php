<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet Picture
*
* @author   Clément CAIRO Alias K.net
*/

class Picture{

	private $_id;
	private $_source;
	private $_type; // 0 = photo utilisateur 1 = photo aliments

	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/* ------------------------ Interaction BDD ------------------------*/

	/**
	* \desc 	  La fonction va récupérer les infos de la table picture pour un id_picture donné
	*
	* \param      $picture_id - un id de forme numérique >0
	*
	* \return     $picture - un array associatif d'une seule ligne id => name.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getItem($picture_id){
		$picture = Utils::getItemById('picture',$picture_id);
		return $picture;
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

	public function setSource($source){
		if(is_string($name) && strlen($name)<=45){
			$this->_source = $source;
			return true;
		}
		throw new Exception('ERROR: La source doit être une chaîne de caractère');

	}

	public function setType($type){
		if(is_numeric($type)){
			$this->_type = $type;
			return true;
		}
		throw new Exception('ERROR : Le type doit être un entier');
	}

	/****************************************************************
	*                             Getters                           *
	****************************************************************/
	public function getId(){
		return $this->_id;
	}

	public function getSource(){
		return ucfirst($this->_source);
	}

	public function getType(){
		return $this->_type;
	}

}