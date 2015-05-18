<?php

include_once 'password.php';

function __autoload($class_name) {
    $class_path = 'class/'.$class_name.'.php';
    if (file_exists($class_path)) {
        include $class_path;
        return true;
    }
    throw new Exception("Le fichier $class_path n'existe pas");
}
