<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet User
*
* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
*/

class User{

	/*************************************************************************
	 *																		 *
	 *		 						Propriétés    					         *
	 *									 									 *
	 ************************************************************************/

	private $_id;
	private $_lastname;
	private $_firstname;
	private $_email;
	protected $_password;
	private $_size;
	private $_weight;
	private $_sex;
	private $_birthdate;
	private $_zipcode;
	private $_creation_date;
	private $_allergy_id;
	private $_diet_id;
	private $_program_id;
	private $_pic_id;


	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/**
	* \desc 	  La fonction va récupérer les infos de la table user pour un id_user donné
	*
	* \param      $user_id - un id de forme numérique >0
	*
	* \return     $user - un array associatif réperetoriant les données de l'utilisateur.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getItem($user_id){
		$user = Utils::getItemById('user',$user_id);
		return $user;
	}


	/**
	* \desc 	  La fonction va modifier les données du user dans la page proil.php
	*
	* \param  	  $user_id
	* \param  	  $data
	* \param  	  $fields
	*
	* \return     $affected_rows - un nombre de lignes affectées
	*
	* @author     Donia AOUALI
	*/

	public static function updateData($user_id, $data) {

		$bindings = array();
		$fields = array();

		foreach($data as $key => $value) {
			$fields[] = $key.' = :'.$key;
			$bindings[$key] = $value;
		}

		$sql = 'UPDATE user SET '.implode(', ', $fields).' WHERE id = :user_id';

		$stmt = Db::getInstance() -> prepare($sql);
		$stmt -> bindValue('user_id', $user_id, PDO::PARAM_INT);

		foreach($bindings as $key => $value) {
			$type = is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
			$stmt -> bindValue($key, $value, $type);
		}

		$stmt -> execute();
		$affected_rows = $stmt->rowCount();
		return $affected_rows;
		if($affected_rows != 1){
			throw new Exception ('ERROR: '.$affected_rows.'lignes affectées par la modif! Il ne devrait y avoir 1 et 1 seule ligne affectée par la modification');
		}
	}

	public static function getPicture($user_infos) {
		$gender = 'woman';
		if ($user_infos['sex'] == 1) {
			$gender = 'man';
		}
		$user_avatar = 'img/avatars/avatar-default-'.$gender.'.png';
		if (!empty($user_infos['picture_id']) && $user_infos['picture_id'] != 3) {
			$db = Db::getInstance();
			$query = $db->prepare("SELECT * FROM picture WHERE id = :id AND type = 2");
			$query->bindValue('id', $user_infos['picture_id'], PDO::PARAM_INT);
			$query->execute();
			$result = $query->fetch();

			print_r($result);

			$user_avatar = $result['source'];
		}
		return $user_avatar;
	}

	/****************************************************************
	*                           Constructeur                        *
	****************************************************************/

	public function __construct($user=array()){

		// on crée une boucle pour lancer l'ensemble des setters au construct
		foreach($user as $key => $value){
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
		if(is_numeric($id) && $id>0){
			$this->_id=$id;
			return true;
		}
		throw new Exception ('ERROR: l\'id doit être un chiffre > 0');
	}
	public function setLastname($lastname){
		if(is_string($lastname) && strlen($lastname)<=45){
			$this->_lastname=$lastname;
			return true;
		}
		throw new Exception ('ERROR: le lastname doit être une chaîne de caractères <= 45');
	}
	public function setFirstname($firstname){
		if(is_string($firstname) && strlen($firstname)<=45){
			$this->_firstname=$firstname;
			return true;
		}
		throw new Exception ('ERROR: le firstname doit être une chaîne de caractères <= 45');
	}
	public function setEmail($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email)<=45){
			$this->_email=$email;
			return true;
		}
		throw new Exception ('ERROR: l\'email doit être valide et d\'une longueur <= 45');
	}
	public function setPassword($password){
		if(strlen($password)<=60){
			$this->_password=$password;
			return true;
		}
		throw new Exception ('ERROR: le mot de passe crypté est de 60 caractère');
	}
	public function setSize($size){
		if(is_numeric($size) && ($size > 99) && ($size < 251) ){
			$this->_size=$size;
			return true;
		}
		throw new Exception ('ERROR: la taille doit être un chiffre compris entre 100cm et 250cm');
	}
	public function setWeight($weight){
		if(is_numeric($weight) && ($weight > 30) && ($weight < 301)){
			$this->_weight=$weight;
			return true;
		}
		throw new Exception ('ERROR: le poids doit être un chiffre compris entre 30kg et 300kg');
	}
	public function setSex($sex){
		if(is_numeric($sex) && (($sex == 0) || ($sex == 1))){
			$this->_sex=$sex;
			return true;
		}
		throw new Exception ('ERROR: le sex est un booléen, 0 exprimant une femme et 1 exprimant un homme il ne peut être <0 ou >1');
	}
	public function setBirthdate($birthdate){
		if(strtotime($birthdate) !== false){
			$this->_birthdate=$birthdate;
			return true;
		}
		throw new Exception ('ERROR: la birthdate doit être de format date');
	}
	public function setZipcode($zipcode){
		if(!empty($zipcode)){
			if(strlen($zipcode)<=45 ){
				$this->_zipcode=$zipcode;
				return true;
			}
			throw new Exception ('ERROR: le zipcode doit être d\'une longueur inférieure à 45');
		}
	}
	public function setCreationDate($creation_date){
		if(!empty($creation_date)){
				if(is_numeric(strtotime($creation_date)) !== false){
				$this->_creation_date=$creation_date;
				return true;
			}
			throw new Exception ('ERROR: la date de création doit être de format date');
		}
	}
	public function setAllergyId($allergy_id){
		if(!empty($allergy_id)){
				if(is_numeric($allergy_id) && $allergy_id>0 && !empty(Allergy::getItem($allergy_id))){
				//la fonction getItem de Allergy.php va récupérer en BDD les infos à partir d'un id allergy
				$this->_allergy_id=$allergy_id;
				return true;
			}
			throw new Exception ('ERROR: l\'allergy_id doit être un chiffre >0 existant dans la table allergy');
		}
	}
	public function setDietId($diet_id){
		if(!empty($diet_id)){
				if(is_numeric($diet_id) && $diet_id>0 && !empty(Diet::getItem($diet_id))){
				//la fonction getItem de Diet.php va récupérer en BDD les infos à partir d'un id diet
				$this->_diet_id=$diet_id;
				return true;
			}
			throw new Exception ('ERROR: le diet_id doit être un chiffre >0 existant dans la table diet');
		}
	}
	public function setProgramId($program_id){
		if(!empty($program_id)){
				if(is_numeric($program_id) && $program_id>0 && !empty(Program::getItem($program_id))){
				//la fonction getItem de Program.php va récupérer en BDD les infos à partir d'un id program
				$this->_program_id=$program_id;
				return true;
			}
			throw new Exception ('ERROR: le program_id doit être un chiffre >0 existant dans la table program');
		}
	}
	public function setPicId($pic_id){
		if(!empty($pic_id)){
				if(is_numeric($pic_id) && $pic_id>0 && !empty(Picture::getItem($pic_id))){
				//la fonction getItem de Picture.php va récupérer en BDD les infos à partir d'un id picture
				$this->_pic_id=$pic_id;
				return true;
			}
			throw new Exception ('ERROR: le program_id doit être un chiffre >0 existant dans la table pictures');
		}
	}


	/****************************************************************
	*                             Getters                           *
	****************************************************************/

	public function getId(){
		return $this->_id;
	}
	public function getLastname(){
		return strtoupper($this->_lastname);
	}
	public function getFirstname(){
		return ucfirst($this->_firstname);
	}
	public function getEmail(){
		return $this->_email;
	}
	public function getPassword(){
		return $this->_password;
	}
	public function getSize(){
		return $this->_size;
	}
	public function getWeight(){
		return $this->_weight;
	}
	public function getSex(){
		return $this->_sex;
	}
	public function getBirthdate(){
		return $this->_birthdate;
	}
	public function getZipcode(){
		return $this->_zipcode;
	}
	public function getCreationDate(){
		return $this->_creation_date;
	}
	public function getAllergyId(){
		return $this->_allergy_id;
	}
	public function getDietId(){
		return $this->_diet_id;
	}
	public function getProgramId(){
		return $this->_program_id;
	}
	public function getPicId(){
		return $this->_pic_id;
	}
}