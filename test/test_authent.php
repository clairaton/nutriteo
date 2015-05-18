<?php

function __autoload($class_name) {
    $class_path = '../class/'.$class_name.'.php';
    if (file_exists($class_path)) {
        include $class_path;
        return true;
    }
    throw new Exception("Le fichier $class_path n'existe pas");
}

$testLName = "nutriteo";
$testFName = "nutriteo";
$testemail = "test@nutriteo.fr";
$testpwd = "nutriteo";

//echo password_hash($testpwd, PASSWORD_BCRYPT);

/************************************
*contrôle l'existance d'une session *
************************************/
if(Authent::checkSession()){
	echo "session ouverte";
	echo '<br>';
	echo $_SESSION['user_id'];
	echo '<br>';
	echo $_SESSION['lastname'];
	echo '<br>';
	echo $_SESSION['firstname'];
	echo '<br>';
	echo $_SESSION['email'];
	echo '<br>';
}else{ echo "session fermer";}

/***********************************
*ouverture d'une session *
************************************/
/*if(Authent::checkLogin($testemail, $testpwd)){
	echo "Login OK";
}else{echo "Login KO";}*/


/**********************
*création d'un cookie *
***********************/
//Authent::setRememberMe($_SESSION['user_id']);

/**************************
*récupération d'un cookie *
**************************/
if(Authent::getRememberMe()){
	echo Authent::getRememberMe();
}else{ echo "no cookie";}

/*************************
*fermeture d'une session *
**************************/
//Authent::endSession();