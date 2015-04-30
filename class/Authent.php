<?php

/**
* Cette class contrôle les habilitations et les sessions
*
* @author   Clément CAIRO Alias K.net
*/


Class Authent{

	const REMEMBER_ME_SECRET_KEY = 'bien manger est le premier des remèdes';
	private static $_expiration = 2419200; // expiration d'un mois (60 * 60 * 24 * 7 * 4)


	/****************************************************************************
	* function qui contrôle le login et mot de passe fournis par l'utilisateur  *
	****************************************************************************/
	public static function checkLogin($login, $pwd){
		try{
			$db = Db::getInstance();
			$query = $db->prepare('SELECT id, lastname, firstname, email, password FROM user WHERE email = :login');
			$query->bindValue('login', $login, PDO::PARAM_STR);
			$query->execute();
			$user = $query->fetch();

			if (!empty($user)) {

				if (password_verify($pwd, $user['password'])){
					//création du session utilisateur
					self::startSession($user['id'], $user['lastname'], $user['firstname'], $user['email']);
					return true;
				}
			}
			return false;

		}catch (Exception $e) {
    		echo $e->getMessage(); // On affiche le message envoyé par "throw new Exception()"
		}
	}

	/*****************************************************
	* function qui permet d'ouvrir une session Nutritéo  *
	*****************************************************/
	public static function startSession($id, $lastname, $firstname, $email){
				session_name('nutriteo');
				session_start();

				$_SESSION['user_id'] = $id;
				$_SESSION['lastname'] = $lastname;
				$_SESSION['firstname'] = $firstname;
				$_SESSION['email'] = $email;
	}

	/******************************************************
	* function qui permet de fermer une session Nutritéo  *
	******************************************************/
	public static function endSession(){

				session_name('nutriteo');
				session_unset();
				session_destroy();
	}

	/**************************************************
	* function qui vérifie si la session est ouverte  *
	**************************************************/
	public static function checkSession(){
		session_name('nutriteo');

		if (empty($_SESSION['user_id'])) {
			return false;
		}
		return true;
	}

	/**************************************************
	* 			function création d'un cookie 		  *
	**************************************************/
	public static function setRememberMe($user_id) {

		$protocol = $_SERVER['REQUEST_SCHEME']; // Contient le protocole en cours http ou https
		$current_time = time(); // On définit le timestamp actuel

		// On définit l'empreinte de l'utilisateur, url en cours et user agent
		$footprints = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].$_SERVER['HTTP_USER_AGENT'];

		// On crée un jeton qui contient la clé secrète concaténée avec l'empreinte de l'utilisateur
		$token = self::REMEMBER_ME_SECRET_KEY.$footprints;

		// On définit une chaîne qui contient nos infos en clair
		$user_data = $current_time.'.'.$user_id;

		// On crypte les informations en clair concaténées avec le jeton
		$crypted_token = hash('sha256', $token.$user_data);

		// On stock les infos en clair et les infos cryptées dans des cookies
		setcookie('rememberme_nutriteo_data', $user_data, $current_time + self::$_expiration);
		setcookie('rememberme_nutriteo_token', $crypted_token, $current_time + self::$_expiration);
	}

	/**************************************************
	*	function récupération d'un cookie si existant *
	**************************************************/
	public static function getRememberMe() {


		if (empty($_COOKIE['rememberme_nutriteo_data']) || empty($_COOKIE['rememberme_nutriteo_token'])) {
			return false;
		}

		$protocol = $_SERVER['REQUEST_SCHEME']; // Contient le protocole en cours http ou https
		$current_time = time(); // On définit le timestamp actuel

		// On définit l'empreinte de l'utilisateur, url en cours et user agent
		$footprints = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].$_SERVER['HTTP_USER_AGENT'];

		// On crée un jeton qui contient la clé secrète concaténée avec l'empreinte de l'utilisateur
		$token = self::REMEMBER_ME_SECRET_KEY.$footprints;

		// On crypt les informations du cookie concaténées avec le jeton
		$crypted_token = hash('sha256', $token.$_COOKIE['rememberme_nutriteo_data']);

		// On vérifie que le jeton du cookie est égal au jeton crypté au dessus
		if(strcmp($_COOKIE['rememberme_nutriteo_token'], $crypted_token) !== 0) {
			return false;
		}

		// On récupère les infos du cookie dans 2 variables, correspondant aux 2 entrées du tableau renvoyé par explode
		list($user_time, $user_id) = explode('.', $_COOKIE['rememberme_nutriteo_data']);

		// On vérifie que le timestamp défini dans le cookie expire dans le futur et qu'il a été défini dans le passé
		if($user_time + self::$_expiration > $current_time && $user_time < $current_time) {
			return $user_id;
		}
		return false;
	}
}