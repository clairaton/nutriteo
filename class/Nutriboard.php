<?php


/**
* Cette class contrôle détermine les éléments du tableau de bord nutritionnel
*
* @author   Claire ANSART Alias Raton <clairaton@gmail.com>
*/

Class Nutriboard{

	/*************************************************************************
	 *																		 *
	 *		 						Properties    					         *
	 *									 									 *
	 ************************************************************************/

	private $_objectives; //représente un tableau de données nutriment_id/quantity
	private $_results; //représente un tableau de données nutriment_id/quantity
	private $_nutriboard_date; //indique la date des données de l'objet au format 'jj-mm-YYYY'

	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/****************************************************************************
	*	    				function qui calcul le nutriscore					*
	****************************************************************************/

	/**
	* \desc 	  La fonction va calculer le nutriscore de l'utilisateur
	*
	* \param      $nutriboard - un tableau de R/O par famille de nutriments (cf dashboardByFamily() )
 	*
	* \return     $nutriscore
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/


	public function getNutriscore($nutriboard){
		$realisation = '';
		$i = 0 ;
		foreach($nutriboard as $item){
			$realisation += $item['realisation'];
			$i++;
		}

		return $realisation/$i*100;
	}

	/****************************************************************************
	*  		function qui crée un tableau avec les résultats par nutriments 		*
	* 					sur une plage de plusieurs jours						*
	****************************************************************************/

	/**
	* \desc 	  La fonction va créer un tableau de R/O par nutriment
	*
	* \param      $date_range - un tableau de dates au format 'jj-mm-AAA'
	*
	* \return      $nutriboard
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public function getDashboardByRangeFamily($user, $date_range){
		//@TODO à tester avec notion de date dans le setter des objectives
		$dashboard=array();
		// on initiialise le tableau
		$List = Nutriment::getFamilyList();
		// pour chaque famille de nutriments
		foreach($List as $family){
			$id = $family['id'];
			$array=array();
			$array['id']= $id;
			$array['name']=$family['name'];
			// on détermine l'unité
			$array['unity']=$family['unity_ref'];
			$array['description']=$family['description'];
			// on initialise les champs real et obj
			$array['real_quantity']='';
			$array['obj_quantity']='';
			$array['realisation']='';

			$dashboard[$id] = $array;
		}
		// pour chaque jour de la plage de temps
		foreach($date_range as $date){
			$nutriboard_dated=new Nutriboard($user, $date);
			$board = $nutriboard_dated -> getDashboardByFamily();
			// pour chaque élément du family nutriboard
			foreach($board as $item){
				$id = $item['id'];
				// on ajoute le réalisé
				$dashboard[$id]['real_quantity'] += $item['real_quantity'];
				// on ajoute l'objectif
				$dashboard[$id]['obj_quantity'] += $item['obj_quantity'];
				if($dashboard[$id]['obj_quantity'] != 0){
					$dashboard[$id]['realisation'] = $dashboard[$id]['real_quantity'] / $dashboard[$id]['obj_quantity'];
				}
			}

		}
		return $dashboard;
	}


	/****************************************************************************
	*  function qui crée un tableau avec les résultats par famille de nutriment *
	* 					sur une plage de plusieurs jours						*
	****************************************************************************/

	/**
	* \desc 	  La fonction va créer un tableau de R/O par nutriment
	*
	* \param      $date_range - un tableau de dates au format 'jj-mm-AAA'
	*
	* \return      $nutriboard
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public function getDashboardByRange($user, $date_range){
		//@TODO à tester avec notion de date dans le setter des objectives
		$dashboard=array();
		// on initiialise le tableau
		$list = Nutriment::getCompleteList();
		// pour chaque famille de nutriments
		foreach($list as $nutriments){
			$id = $nutriments -> getId();
			$array=array();
			$array['id']= $id;
			$array['name']=$nutriments -> getName();
			// on détermine l'unité
			$array['unity']=$nutriments -> getUnity();
			// on initialise les champs real et obj
			$array['real_quantity']='';
			$array['obj_quantity']='';
			$array['realisation']='';

			$dashboard[$id] = $array;
		}

		// pour chaque jour de la plage de temps
		foreach($date_range as $date){
			$nutriboard_dated=new Nutriboard($user, $date);
			$board = $nutriboard_dated -> getDashboard();
			// pour chaque élément du family nutriboard
			foreach($board as $item){
				$id = $item['id'];
				// on ajoute le réalisé
				$dashboard[$id]['real_quantity'] += $item['real_quantity'];
				// on ajoute l'objectif
				$dashboard[$id]['obj_quantity'] += $item['obj_quantity'];
				if($dashboard[$id]['obj_quantity'] != 0){
					$dashboard[$id]['realisation'] = $dashboard[$id]['real_quantity'] / $dashboard[$id]['obj_quantity'];
				}
			}
		}
		return $dashboard;
	}


	/****************************************************************************
	*	    function qui crée un tableau avec les résultats par nutriment		*
	****************************************************************************/

	/**
	* \desc 	  La fonction va créer un tableau de R/O par nutriment
	*
	* \return      $nutriboard
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public function getDashboard(){
		$nutriboard=array();
		$nutriments = Nutriment::getCompleteList();
		$results = $this->getResults();
		$objectives = $this->getObjectives();
		foreach($nutriments as $nutriment){
			$id = $nutriment->getId();
			if($objectives[$id] == 0){
				$array=array();
				$array['id']= $id;
				$array['name']=$nutriment->getName();
				$array['unity']=$nutriment->getUnity();
				$array['real_quantity']=$results[$id];
				$array['obj_quantity']=$objectives[$id];
				$array['realisation']=0;

				$nutriboard[$id]=$array;
			}else{
				$array=array();
				$array['id']= $id;
				$array['name']=$nutriment->getName();
				$array['unity']=$nutriment->getUnity();
				$array['real_quantity']=$results[$id];
				$array['obj_quantity']=$objectives[$id];
				$array['realisation']=$array['real_quantity']/$array['obj_quantity'];

				$nutriboard[$id]=$array;
			}

		}
		return $nutriboard;
	}


	/****************************************************************************
	* function qui crée un tableau avec les résultats par famille de nutriments *
	****************************************************************************/

	/**
	* \desc 	  La fonction va créer un tableau de R/O par famille de nutriments
	*
	* \return      $nutriboard
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public function getDashboardByFamily(){
		$nutriboardByFamily=array();
		$results = $this->getResults();
		$objectives = $this->getObjectives();
		// on récupère la liste des familles de nutriments
		$familyList = Nutriment::getFamilyList();
		// pour chaque famille de nutriments
		foreach($familyList as $family){
			$id = $family['id'];
			$array=array();
			$array['id']= $id;
			$array['name']=$family['name'];
			// on détermine l'unité
			$array['unity']=$family['unity_ref'];
			$array['description']=$family['description'];
			// on initialise les champs real et obj
			$array['real_quantity']='';
			$array['obj_quantity']='';
			// on récupère la liste des nutriments associés
			$nutriments = Nutriment::getListByFamily($id);
			// pour chaque nutriment
			foreach($nutriments as $nutriment){
				$nutri_id = $nutriment -> getId();
				if($objectives[$id] == 0){
					// si l'unité du nutriment est la même que l'unité de référence de la famille
					if($nutriment -> getUnity() == $family['unity_ref']){
						$array['real_quantity']+=$results[$nutri_id];
						$array['obj_quantity']+=$objectives[$nutri_id];
						$array['realisation']=0;
					}
					else if(($nutriment -> getUnity() == 'mg' && $family['unity_ref'] == 'g') || ($nutriment -> getUnity() == 'ug' && $family['unity_ref'] == 'ug')){
						$array['real_quantity']+=$results[$nutri_id]/1000;
						$array['obj_quantity']+=$objectives[$nutri_id]/1000;
						$array['realisation']=0;
					}
					else{
						$array['real_quantity']+=$results[$nutri_id]/1000000;
						$array['obj_quantity']+=$objectives[$nutri_id]/1000000;
						$array['realisation']=0;
					}
				}else{
					// si l'unité du nutr iment est la même que l'unité de référence de la famille
					if($nutriment -> getUnity() == $family['unity_ref']){
						$array['real_quantity']+=$results[$nutri_id];
						$array['obj_quantity']+=$objectives[$nutri_id];
						$array['realisation']=$array['real_quantity']/$array['obj_quantity'];
					}
					else if(($nutriment -> getUnity() == 'mg' && $family['unity_ref'] == 'g') || ($nutriment -> getUnity() == 'ug' && $family['unity_ref'] == 'ug')){
						$array['real_quantity']+=$results[$nutri_id]/1000;
						$array['obj_quantity']+=$objectives[$nutri_id]/1000;
						$array['realisation']=$array['real_quantity']/$array['obj_quantity'];
					}
					else{
						$array['real_quantity']+=$results[$nutri_id]/1000000;
						$array['obj_quantity']+=$objectives[$nutri_id]/1000000;
						$array['realisation']=$array['real_quantity']/$array['obj_quantity'];
					}
				}
			}
			$nutriboard[$id]=$array;
		}
		return $nutriboard;
	}


	/****************************************************************
	*                           Constructeur                        *
	****************************************************************/

	public function __construct($user_id, $nutriboard_date){

		// on crée une boucle pour lancer l'ensemble des setters au construct
		$this->setNutriboardDate($nutriboard_date);
		$this->setObjectives($user_id, $nutriboard_date);
		$this->setResults($user_id, $nutriboard_date);
	}

	/****************************************************************
	*                             Setters                           *
	****************************************************************/

	public function setNutriboardDate($nutriboard_date){
		$this->_nutriboard_date = $nutriboard_date;
	}


	/****************************************************************************
	*	    function qui récupère les objectifs quotidiens de l'utilisateur		*
	****************************************************************************/

	/**
	* \desc 	  La fonction va récupérer les objectifs nutritionnelles quotidiennes d'un utilisateur à une date donnée
	*
	* \param      $user_id - un id de forme numérique >0
	* \param      $nutriboard_date - une date au format 'jj-mm-AAAA'
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public function setObjectives($user_id, $nutriboard_date){
		//On va récupérér les infos de user_objectives à une date donnée
		try{
			// on test si les objectifs du jour ont été setté
			if(empty(Objectives::getObjectivesByDate($user_id, $nutriboard_date, 19))){
				Objectives::setObjectives($user_id, $nutriboard_date);
			}
			$objectives=array();
			$datas = Objectives::getAllNutrimentsObjectivesByDate($user_id, $nutriboard_date);
			foreach ($datas as $array) {
				$objectives[$array['nutriment_id']] =$array['quantity'];
			}
			$this->_objectives = $objectives;
		}catch(Exception $e) {
    		echo $e->getMessage();
		}
	}

	/****************************************************************************
	*	    function qui détermine les résultats quotidiens de l'utilisateur	*
	****************************************************************************/

	/**
	* \desc 	  La fonction va calculer les données nutritionnelles quotidiennes d'un utilisateur à une date donnée
	*
	* \param      $user_id - un id de forme numérique >0
	* \param      $nutriboard_date - une date au format 'jj-mm-AAAA'
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public function setResults($user_id, $nutriboard_date){
		try{
			// on initialise le tableau de résultat
			$results=array();
			$nutriments= Nutriment::getCompleteList();
			foreach($nutriments as $obj){
				$results[$obj->getId()]='';
			}
			// pour chaque entrée user_food
			$foods =Food::getListByUser($user_id, $nutriboard_date);
			foreach($foods as $key => $value){
				// on récupère la liste des nutriments de l'aliment
				$stmt = Db::getInstance() -> prepare('SELECT * FROM food_nutriment WHERE food_id =:food_id ');
				$stmt -> bindValue('food_id', $key ,PDO::PARAM_INT);
				$stmt ->execute();
				$food_infos = $stmt -> fetchAll();
				//pour chacun des nutriments
				foreach($food_infos as $array){
					// on ajoute la quantité dans le tableau des résultats
					$results[$array['nutriment_id']] += ($array['nutriment_quantity'] * $value);
				}
			}
			$this->_results = $results;
		}catch(Exception $e) {
    		echo $e->getMessage();
		}
	}


	/****************************************************************
	*                             Getters                           *
	****************************************************************/
	function getObjectives(){
		return $this->_objectives;
	}
	function getResults(){
		return $this->_results;
	}
	function getNutriboardDate(){
		return $this->_nutriboard_date;
	}

}