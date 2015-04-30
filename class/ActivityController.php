<?php

/**
* Ce fichier décrit l'ensemble des caractéristiques de l'objet ActivityController permettant de controller les données activités qui sont envoyées en bdd
*
* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
*/

class ActivityController{


	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/

	/**
	* \desc 	  La fonction va controller les infos reçues, les insérer en bdd et impacter l'objectif nutritionnel
	*
	* \param      $datas - les données du formulaires activité envoyées par la barre d'adresse
	* \param      $user - l'id de l'utilisateur
	* \param      $date -la date de l'activité
	*
	* \return	  $activity - un array associatifs comprenant 'user_id', 'duartion' et 'intensity_id'
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function dailyActivity($user, $datas, $date){
		// on lance la fonction de control des données OK
		$activity=ActivityController::controlDatas($user, $datas);
		if(!empty($activity)){
			// on vérifie qu'il n'y a pas déjà une activité de renseignée pour la date donnée ok
			$ckeck_activity=Activity::getActivityByDate($user, $date);
			if(empty($ckeck_activity)){
				// si non on lance la requête d'insertion OK
				Activity::insertActivity($activity['duration'], $user, $activity['intensity_id']);
			}else{
				// si oui on lance la requête d'update
				$id=$ckeck_activity['id'];
				Activity::updateActivity($id, $activity['duration'], $activity['intensity_id']);
			}
			// on lance la requête de modification des objs en fonction de l'activité physique
			$ojectives=Objectives::calculateActivityImpact($user, $date);

			// on renvoi l'utilisateur sur la page d'acceuil
			header ('location:carnet.php');
		}
	}

	/**
	* \desc 	  La fonction va controller les infos reçues en GET
	*
	* \param      $datas - les données du formulaires activité envoyées par la barre d'adresse
	* \param      $user - l'id de l'utilisateur
	*
	* \return	  $activity - un array associatifs comprenant 'user_id', 'duartion' et 'intensity_id'
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function controlDatas($user, $datas){
		// on initialise un tableau d'erreurs
		$errors=array();
		// on définit les tableaux de données à vérifier (cf activites.js)
		$intensity = array("Pas d'activité" => 0, "Normale" => 1, "Intensive" => 2);
		$duration = array("0" => 0, "30min" => 30, "1heure" => 60, "1heure et 30min" => 90, "2heures" => 120, "2heures et 30min" => 150, "3heures" => 180, "3heures et 30min" => 210, "4heures" => 240, "4heures et 30min" => 270, "5heures" => 300, "5heures et 30min" => 330, "6heures" => 360);
		// on innitialise un tableau activity
		$activity=array();
		// on teste les données reçues
		if(!empty($datas)){
			if(!empty($datas['intensity_name'])){
				$intensity_send = $datas['intensity_name'];
				if(!empty($intensity[$intensity_send])){
					$intensity_id = $intensity[$intensity_send];
					$activity['intensity_id'] = $intensity_id;
				}else{
					// si ce n'est pas ok on entre une erreur deans $errors
					$errors['intensity_id']='cette intensité n\'existe pas!';
				}
			}else{
				// si ce n'est pas ok on entre une erreur deans $errors
				$errors['intensity_id']='il n\'y a pas d\'intensité de renseigner!';
			}
			if(!empty($datas['duration'])){
				$duration_send = $datas['duration'];
				if(!empty($duration[$duration_send])){
					$time = $duration[$duration_send];
					$activity['duration'] = $time;
				}else{
					// si ce n'est pas ok on entre une erreur deans $errors
					$errors['duration']='cette durée n\'existe pas!';
				}
			}else{
				// si ce n'est pas ok on entre une erreur deans $errors
				$errors['duration']='il n\'y a pas de durée de renseignée!';
			}
		}
		if(empty($errors)){
			$activity['user_id']=$user;
			return $activity;
		}

	}




}