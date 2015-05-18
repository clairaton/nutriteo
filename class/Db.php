<?php

class Db extends PDO {

	const ENGINE = 'mysql';
	const HOST 	 = '127.0.0.1';
	const USER   = 'root';
	const PASS   = '';
	const DB = 'nutriteo';

	private static $instance;

	public function __construct() {

		$db_options = array(
	            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
	            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
	    );

		try {

			parent::__construct(self::ENGINE.':dbname='.self::DB.";host=".self::HOST, self::USER, self::PASS, $db_options);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
    }

    // Singleton
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new Db();
		}
		return self::$instance;
	}
}