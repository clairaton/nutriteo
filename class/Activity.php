<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet Activity
*
* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
*/

class Activity{

	/*************************************************************************
	 *																		 *
	 *		 						Propriétés    					         *
	 *									 									 *
	 ************************************************************************/

	private $_id;
	private $_level;
	private $_name;
	private $_coeff;
	private $_impact_nutriment; //tableau incluant les couples nutriment_family_id => impact
	private $_duration;



	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/* ------------------------ Interaction BDD ------------------------*/

	/**
	* \desc 	  La fonction va récupérer les infos de la table intensity pour un id_intensity donné
	*
	* \param      $intensity_id - un id de forme numérique >0
	*
	* \return     $intensity - un array associatif avec les caractères de l'intensité.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getItem($intensity_id){
		$intensity = Utils::getItemById('intensity',$intensity_id);
		return $intensity;
	}

	/**
	* \desc 	  La fonction va récupérer les infos de la table intensity de toutes les intensités
	*
	* \return     $intensity - un array associatif id => name.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getCompleteList($intensity_id){
		try{
			$query= 'SELECT * FROM '.$table.' WHERE id = :id';
			$stmt = Db::getInstance() -> prepare($query);
			$stmt -> bindValue('id',$id,PDO::PARAM_INT);
			$stmt -> execute();
			$intensities = $stmt->fetchAll();

			return $intensities;
		}catch (Exception $e){
			echo $e -> getMessage();
		}
	}


	/**
	* \desc 	  La fonction va récupérer les données activités pour une date donnée
	*
	* \param  	  $user_id
	* \param  	  $activity_date
	*
	* \return     $result - un tableau comprenant les données activité du jour.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getActivityByDate($user_id, $activity_date){
			//on vérifie si l'utilisateur a effectué une activité pour date donnée
			$stmt = Db::getInstance() -> prepare ("SELECT * FROM user_activity WHERE DATE_FORMAT(activity_date, '%d-%m-%Y') = :activity_date AND user_id = :user_id");
			$stmt -> bindValue('user_id',$user_id, PDO::PARAM_INT);
			$stmt -> bindValue('activity_date',$activity_date, PDO::PARAM_STR);
			$stmt -> execute();
			$result = $stmt -> fetch();
			if(!empty($result)){
					return $result;
			}
	}

	/**
	* \desc 	  La fonction va updater les données activités pour une date donnée et un user
	*
	* \param  	  $duration
	* \param  	  $user_id
	* \param  	  $intensity_id
	*
	* \return     $idInsert - l'id de l'activité qui vient d'être inséré.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function insertActivity($duration, $user_id, $intensity_id){
			// on insère les données de l'activité pratiquée

			$stmt = Db::getInstance() -> prepare ("INSERT INTO user_activity (duration, user_id, intensity_id) VALUES (:duration, :user_id, :intensity_id)");
			$stmt -> bindValue('duration',$duration, PDO::PARAM_INT);
			$stmt -> bindValue('user_id',$user_id, PDO::PARAM_INT);
			$stmt -> bindValue('intensity_id',$intensity_id, PDO::PARAM_INT);
			$stmt -> execute();
			$idInsert = Db::getInstance() -> lastInsertId();
			if(!empty($idInsert)){
					return $idInsert;
			}
	}

	/**
	* \desc 	  La fonction va modifier les données activités pour une date donnée et un user
	*
	* \param  	  $id
	* \param  	  $duration
	* \param  	  $intensity_id
	*
	* \return     $affected_rows - un nombre de lignes affectées
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function updateActivity($id, $duration, $intensity_id){
			$stmt = Db::getInstance() -> prepare ("UPDATE user_activity SET duration = :duration, intensity_id = :intensity_id WHERE id = :id");
			$stmt -> bindValue('id',$id, PDO::PARAM_INT);
			$stmt -> bindValue('duration',$duration, PDO::PARAM_INT);
			$stmt -> bindValue('intensity_id',$intensity_id, PDO::PARAM_INT);
			$stmt -> execute();
			$affected_rows = $stmt->rowCount();
			return $affected_rows;
			if($affected_rows != 1){
				throw new Exception ('ERROR: '.$affected_rows.'lignes affectées par la modif! Il ne devrait y avoir 1 et 1 seule ligne affectée par la modification');
			}
	}

	/************************************************************************************
	*				Fonction permettant de définir l'impact d'une activités				*
	************************************************************************************/

	/**
	* \desc 	  La fonction va récupérer l'impact d'une heure d'activité physique normale(id_intensity =1) sur les différentes familles de nutriment
	*
	* \return     $impact - un tableau de 6 entrées indiquant l'impact de base (non affecté par le coeff d'intensité) de l'activité sur physique sur chaque famille de nutriment.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	private static function _getImpact(){
		// on récupère l'impact par famille de nutriment
		$impact = array();
		$stmt = Db::getInstance() -> query('SELECT nutriment_family_id, impact FROM activity');
		$results = $stmt -> fetchAll();
		// on crée un tableau d'impact par famille de nutriment
		foreach($results as $result){
			$impact[$result['nutriment_family_id']] = $result['impact'];
		}
		return $impact;
	}

	/****************************************************************
	*                           Constructeur                        *
	****************************************************************/

	public function __construct($activity=array()){

		// on crée une boucle pour lancer l'ensemble des setters au construct
		foreach($activity as $key => $value){
			$method= 'set'.Utils::camelCase($key);
			if(method_exists($this, $method)){
				$this->$method($value);
			}
			if(empty($activity['duration'])){
				$this->setDuration();
			}
			$this->setImpactNutriment();
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
	public function setLevel($level){
		if(is_numeric($level) && $level>0){
			$this->_level=$level;
			return true;
		}
		throw new Exception ('ERROR: le niveau intensité doit être un chiffre > 0');
	}
	public function setName($name){
		if(is_string($name)){
			$this->_name=$name;
			return true;
		}
		throw new Exception ('ERROR: le nom doit être une chaîne de caractères');
	}
	public function setCoeff($coeff){
		if(is_numeric($coeff) && $coeff>0){
			$this->_coeff=$coeff;
			return true;
		}
		throw new Exception ('ERROR: le coeff d\'impact doit être un chiffre > 0');
	}
	public function setImpactNutriment(){
		if(!empty(self::_getImpact()) && count(self::_getImpact()) == 7){
			// on récupère l'impact nutriment en tenant compte du coeff d'intensité
			$array=self::_getImpact();
			$impact=array();
			foreach($array as $key => $value){
				$impact[$key]=$value* $this ->_coeff * $this -> _duration / 60;
			}
			$this -> _impact_nutriment = $impact ;
			return true;
		}
		throw new Exception ('ERROR: l\'impact par nutriment doit être un tableau de 6 couples clés valeur');
	}
	public function setDuration($duration=60){
		if(is_numeric($duration) && $duration>0){
			$this->_duration=$duration;
			return true;
		}
		throw new Exception ('ERROR: la durée doit-être exprimée en numérique (min)');
	}


	/****************************************************************
	*                             Getters                           *
	****************************************************************/

	public function getId(){
		return $this -> _id;
	}
	public function getLevel(){
		return $this -> _level;
	}
	public function getName(){
		return $this -> _name;
	}
	public function getCoeff(){
		return $this -> _coeff;
	}
	public function getImpactNutriment(){
		return $this -> _impact_nutriment;
	}
	public function getDuration(){
		return $this -> _duration;
	}

}