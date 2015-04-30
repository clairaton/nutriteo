<?php

/**
* Cette class permet d'enregistrer un nouvel utilisateur
*
* @author   Clément CAIRO Alias K.net
*/


class Register extends User {


	/*************************************************************************
	 *																		 *
	 *		 						 Methods    					         *
	 *									 									 *
	 ************************************************************************/


	public function passwordCrypt(){
		$this->_password = password_hash($this->_password, PASSWORD_BCRYPT);

	}

	//insertion en base du nouvel utilisateur
	public function signUp(){
		try {
			$query = Db::getInstance()->prepare('INSERT INTO user (lastname, firstname, email, password, size, weight, sex, birthdate)
												VALUES (:lastname, :firstname, :email, :password, :size, :weight, :sex, :birthdate)');
			$query->bindValue('lastname', $this->getLastname(), PDO::PARAM_STR);
			$query->bindValue('firstname', $this->getFirstname(), PDO::PARAM_STR);
			$query->bindValue('email', $this->getEmail(), PDO::PARAM_STR);
			$query->bindValue('password', $this->getPassword(), PDO::PARAM_STR);
			$query->bindValue('size', $this->getSize(), PDO::PARAM_INT);
			$query->bindValue('weight', $this->getWeight(), PDO::PARAM_INT);
			$query->bindValue('sex', $this->getSex(), PDO::PARAM_INT);
			$query->bindValue('birthdate', date('Y-m-d H:i:s', strtotime($this->getBirthdate())), PDO::PARAM_STR);
			$query->execute();
			return Db::getInstance()->lastInsertId();

		} catch (Exception $e) {
			echo $e->getMessage();

		}
	}

	/******************************************************
	* function qui permet de fermer une session nutritmp  *
	******************************************************/
	public static function suppSessionTmp(){

				session_name('nutritmp');
				session_destroy();
	}

}