<?php

define('DB_HOST', 'localhost');
define('DB_NAME', '[DB_NAME]');
define('DB_USERNAME', '[DB_USERNAME]');
define('DB_PASSWORD', '[DB_PASSWORD]');

try {
    
    $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);

    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

    return $db;

} catch (PDOException $e) {
	
    if ($_SERVER['REMOTE_ADDR'] != '::1') {
    	die('Erreur: connexion à la base de données interrompu');
    }else{
    	die('Erreur: '.$e->getMessage());
    }

}