<?php

/**
* Ce fichier intègre un ensemble de fonction qui pourront être utiliser sur l'ensemble du site
*
* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
*/

class Utils{

	/************************************************************************************
	*					Fonction permettant de renvoyer un extrait de text				*
	************************************************************************************/

	public static function cutString($content, $length = 0, $end=' [...]'){
		if($length>0 && strlen($content)>$length){
			$content= wordwrap($content, $length, '|',true); // on inclut une '|' tous les 50 caractères
			$array_text=explode('|',$content); // on construit una tableau avec les bouts de chaîne situé entre les '|'
			$content = $array_text[0].$end; // on récupère la première entrée du tableau
		}
		return $content; // on renvoit le contenu
	}

	/************************************************************************************
	*		Fonction permettant de transformer un nom de variable en camelCase			*
	************************************************************************************/

	public static function camelCase($str){
		$str=str_replace('_',' ',$str);
		$str=ucwords($str);
		$str=str_replace(' ','',$str);

		return $str;
	}

	/************************************************************************************
	*		Fonction permettant de sortir les infos	d'une table à partir d'un id		*
	************************************************************************************/

	/**
	* \desc 	  La fonction va récupérer les infos d'une table en fonction d'un id donné
	*
	* \param      $id - un id de forme numérique >0
	* \param      $table - le nom de la tablea dans laquelle on cherche notre info
	*
	* \return     $result - un array associatif avec toute les colonnes de la table pour l'id sélectionné.
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function getItemById($table,$id){
		try{
			$query= 'SELECT * FROM '.$table.' WHERE id = :id';
			$stmt = Db::getInstance() -> prepare($query);
			$stmt -> bindValue('id',$id,PDO::PARAM_INT);
			$stmt -> execute();
			$result = $stmt->fetch();

			return $result;
		}catch (Exception $e){
			echo $e -> getMessage();
		}

	}


	/************************************************************************************
	*		Fonction de créer un tableau du début de la semaine à aujourd'hui	 		*
	************************************************************************************/

	/**
	* \desc 	  La fonction va créer un tableau de jour au format 'dd-mm-YYYY' du Lundi à aujourd'hui
	*
	*
	* \return     $date_range - un array associatif avec toutes les date de la semaine jusqu'à aujourd'hui
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function weekDateRange(){
		try{
			$day = date('l', strtotime(time()));
			switch($day) {
				case 'Monday':
					$days = 0;
				break;
				case 'Tuesday':
					$days = 1;
				break;
				case 'Wednesday':
					$days = 2;
				break;
				case 'Thursday':
					$days = 3;
				break;
				case 'Friday':
					$days = 4;
				break;
				case 'Saturday':
					$days = 5;
				break;
				case 'Sunday':
					$days = 6;
				break;
			}
			$date_range=array();
			// on insère chaque jour dans un tableau
			for($i= $days; $i>=0 ; $i--){
				$calculate= '-'.$i.' day';
				$date = date('d-m-Y', strtotime($calculate));
				$date_range[]= $date;
			}
			return $date_range;
		}catch (Exception $e){
			echo $e -> getMessage();
		}

	}

	/************************************************************************************
	*			Fonction de créer un tableau du début du mois à aujourd'hui	 			*
	************************************************************************************/

	/**
	* \desc 	  La fonction va créer un tableau de jour au format 'dd-mm-YYYY' du Lundi à aujourd'hui
	*
	*
	* \return     $date_range - un array associatif avec toutes les date de la semaine jusqu'à aujourd'hui
	*
	* @author     Claire ANSART Alias Raton <clairaton@gmail.com>
	*/

	public static function monthDateRange(){
		try{
			$today=time();
			$month=date('m-Y', $today);
			$first_day='01-'.$month;
			$first_day_unix=strtotime($first_day);
			$days=floor(($today - $first_day_unix) /86400);
			$date_range=array();
			for($i= $days; $i>=0 ; $i--){
				$calculate= '-'.$i.' day';
				$date = date('d-m-Y', strtotime($calculate));
				$date_range[]= $date;
			}
			return $date_range;
		}catch (Exception $e){
			echo $e -> getMessage();
		}

	}


}