<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet Objectives
*
* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
*/

class Objectives{

	/*************************************************************************
	 *																		 *
	 *		 						Properties    					         *
	 *									 									 *
	 ************************************************************************/

	private $_id;
	private $_user_id;
	private $_nutriment_id;
	private $_quantity;
	private $_date_objectives;

	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/* ------------------------ Interaction BDD ------------------------*/

	/**
	* \desc 	  La fonction va récupérer les données objectifs pour une date donnée
	*
	* \param      $user_id
	* \param      $date_objectives
	* \param      $nutriment_id
	*
	* \return     $objectives - un tableau donnant les objectifs pour un user, un nutriment et une date
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getObjectivesByDate($user_id, $date_objectives, $nutriment_id){
			$stmt = Db::getInstance() -> prepare ("SELECT * FROM user_objectives WHERE DATE_FORMAT(date_objectives, '%d-%m-%Y') = :date_objectives AND user_id = :user_id AND nutriment_id =:nutriment_id");
			$stmt -> bindValue('user_id',$user_id, PDO::PARAM_INT);
			$stmt -> bindValue('nutriment_id',$nutriment_id, PDO::PARAM_INT);
			$stmt -> bindValue('date_objectives',$date_objectives, PDO::PARAM_STR);
			$stmt -> execute();
			$result = $stmt -> fetch();
			return $result;
	}

	/**
	* \desc 	  La fonction va récupérer les données objectifs pour une date donnée de tous les nutriments
	*
	* \param      $user_id
	* \param      $date_objectives
	*
	* \return     $objectives - un tableau donnant les objectifs pour un user, un nutriment et une date
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getAllNutrimentsObjectivesByDate($user_id, $date_objectives){
		$objectives=array();
		$nutriments = Nutriment::getCompleteList();
		foreach($nutriments as $item){
			$i = $item -> getId();
			$objectives[$i]=Objectives::getObjectivesByDate($user_id, $date_objectives, $i);
		}
		return $objectives;
	}


	/**
	* \desc 	  La fonction va insérer en bdd les objectifs nutritionnels quotidiens d'un utilisateur en fonction de son profil
	*
	* \param      $objectives - un array associatif comprenant le user_id, le nutriment_id et la quantity
	* \return     $result - l'id de la ligne qui vient d'être insérer.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function insertObjectives($objectives=array(),$date){
		try{
			$date = date('Y-m-d H:i:s', strtotime($date));
			// on récupère les données user en fonction d'un id_user
			$stmt = Db::getInstance() -> prepare('INSERT INTO user_objectives (user_id, nutriment_id, quantity, date_objectives) VALUES (:user_id, :nutriment_id, :quantity, :date_objectives)');
					$stmt -> bindValue('user_id', $objectives['user_id'], PDO::PARAM_INT);
			$stmt -> bindValue('nutriment_id', $objectives['nutriment_id'], PDO::PARAM_INT);
			$stmt -> bindValue('quantity', $objectives['quantity'], PDO::PARAM_INT);
			$stmt -> bindValue('date_objectives', $date, PDO::PARAM_STR);
			$stmt ->execute();
			$result = Db::getInstance() -> lastInsertId();

			return $result;
		}catch(Exception $e) {
    		echo $e->getMessage();
		}
	}


	/**
	* \desc 	  La fonction va mettre à jour les données objectifs pour une date, un user, et un nutriment
	*
	* \param      $id
	* \param      $quantity
	*
	* \return     $affected_rows - un nombre de lignes affectées
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function updateObjectives($id, $quantity){
			$stmt = Db::getInstance() -> prepare ("UPDATE user_objectives SET quantity = :quantity WHERE id = :id");
			$stmt -> bindValue('id',$id, PDO::PARAM_INT);
			$stmt -> bindValue('quantity',$quantity, PDO::PARAM_INT);
			$stmt -> execute();
			$affected_rows = $stmt->rowCount();
			return $affected_rows;
			if($affected_rows != 1){
				throw new Exception ('ERROR: '.$affected_rows.'lignes affectées par la modif! Il ne devrait y avoir 1 et 1 seule ligne affectée par la modification');
			}
	}


	/****************************************************************************
	*function qui détermine les objectifs quotidiens 'basiques' de l'utilisateur*
	*                  (hors impact de l'activité physique)						*
	****************************************************************************/

	/**
	* \desc 	  La fonction va calculer les objectifs nutritionnels quotidiens d'un utilisateur en fonction de son profil
	*
	* \param      $user_id - un id de forme numérique >0
	*
	* \return     $objectives - un array associatif répertoriant les objectifs quotidiens de l'utilisateur (seules les valeurs nutriment_id et quantity sont indiquées).
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function setObjectives($user_id, $date){
		try{
			if(empty($date)){
				$date=date('d-m-Y',time());
			}
			// si les objectifs du jour n'ont pas encore été setté
			if(empty(Objectives::getObjectivesByDate($user_id, $date, 19))){
				// on récupère les données user en fonction d'un id_user
				$user = new User( User::getItem($user_id));
				$sex = $user -> getSex();
				$weight = $user -> getWeight();
				$birthdate = strtotime($user -> getBirthdate());
				$age =floor((strtotime($date) - strtotime($user -> getBirthdate()))/60/60/24/365); // date - birthdate

				// on récupère les objectifs nutritionnels en fonction de l'age, du sex et du poids de l'utilisateur
				$obj = NutrimentRef:: getObjectives($sex,$age);

				// on affecte les objectifs en fonction du poids
				$weight_coeff = $weight/ $obj[0] -> getWeight();

				// on crée un nouveau tableau d'objet NutrimentRef
				foreach($obj as $nutri_ref){
					$objectives = array();
					$objectives['user_id'] = $user_id;
					$objectives['nutriment_id'] = $nutri_ref -> getNutrimentId();
					$objectives['quantity']=$nutri_ref -> getQuantity() * $weight_coeff;

					if(empty(self::insertObjectives($objectives,$date))){
						throw new Exception ('ERROR: aucune ligne n\'a été insérée') ;
					}
				}
			}
		}catch(Exception $e) {
    		echo $e->getMessage();
		}
	}


	/****************************************************************************
	*function qui modifie les objectifs quotidiens 'basiques' de l'utilisateur*
	*                  (en fonction de l'activité physique)						*
	****************************************************************************/

	/**
	* \desc 	  La fonction va modifier les objectifs nutritionnels quotidiens d'un utilisateur en fonction de l'activité physique qu'il a renseigné s'il en a indiqué une.
	*
	* \param      $user_id - un id de forme numérique >0
	*
	* \return     $objectives - un array associatif répertoriant les objectifs quotidiens de l'utilisateur (seules les valeurs nutriment_id et quantity sont indiquées).
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function calculateActivityImpact($user_id, $activity_date){
		try{
		// On récupère l'impact de l'intensité de l'activité physique du jour demandé
		$result = Activity::getActivityByDate($user_id, $activity_date);

		$intensity = Activity::getItem($result['intensity_id']);

		$activity = array('level'=> $result['intensity_id'], 'coeff' => $intensity['coeff'], 'duration' => $result['duration']);

		$add_obj = new Activity($activity);


			// on impacte la durée de l'activité sur l'impact de base de l'activité
			$impact = $add_obj -> getImpactNutriment();


			$impact_by_family = array();
			foreach($impact as $key => $value){
				// on récupère la liste des nutriments de la famille d'élément
				if($value>0){
					$result = Nutriment::getListByFamily($key);
					$family_impact = 0;
					// on calcul un coeff d'impact pour chaque famille de nutriment impactéé par l'activité
					foreach($result as $item){
						$obj=self::getObjectivesByDate($user_id, $activity_date, $item -> getId());
						$family_impact += $obj['quantity'];
					}
					$impact_by_family[$key] = ($family_impact + $value) / $family_impact;
				}

			}

			// on applique le coeff sur chaque nutriment de la famille
			foreach($impact as $key => $value){
				// on récupère la liste des nutriments de la famille d'élément
				if($value>0){
					$result = Nutriment::getListByFamily($key);
					foreach($result as $item){
						// on récupère l'objectif initial de chaque activité
						$obj=self::getObjectivesByDate($user_id, $activity_date, $item -> getId());
						// on calcul le nouvel objectif des lignes à updater
						$objectives['quantity']= $obj['quantity'] * $impact_by_family[$key];
						// on met à jour la ligne d'objectif
						$update = self:: updateObjectives($obj['id'], $objectives['quantity']);
					}
				}
			}
		}catch(Exception $e) {
    		echo $e->getMessage();
		}
	}

	/****************************************************************
	*                           Constructeur                        *
	****************************************************************/

	public function __construct($objectives=array()){

		// on crée une boucle pour lancer l'ensemble des setters au construct
		foreach($objectives as $key => $value){
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
	public function setUserId($user_id){
		//@TODO ajouter un control de l'existence de l'id User
		if(is_numeric($user_id) && $user_id>0){
			$this->_user_id=$user_id;
			return true;
		}
		throw new Exception ('ERROR: l\'id doit être un chiffre > 0');
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
	function setDateObjectives($date_objectives){
			$this->_date_objectives = $date_objectives;
	}

	/****************************************************************
	*                             Getters                           *
	****************************************************************/
	function getId(){
		return $this->_id;
	}
	function getUserId(){
		return $this->_user_id;
	}
	function getNutrimentId(){
		return $this->_nutriment_id;
	}
	function getQuantity(){
		return $this->_quantity;
	}

}