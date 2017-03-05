<?php

define('DB_HOST', 'localhost');
define('DB_NAME', '[DB_NAME]');
define('DB_USERNAME', '[DB_USERNAME]');
define('DB_PASSWORD', '[DB_PASSWORD]');

function database(){
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
}

/**
 * query execute les requetes qui lui sont passés
 * @param  [mysql] $sql    requete à executé
 * @param  [array]  $params les parametres de la requete(s'il y'en a)          
 */
function query($sql,$params = []){
    $db = database();
    $q = $db->prepare($sql);
    $q->execute($params);
    $q->closeCursor();
}

/**
 * display_datas permet de renvoyer les données d'une base de données en fonction des parametres
 * @param  [array || boolean] $params      tableau de parametres où chercher
 * @param  [string || boolean] $db_field      le champ de la base de donnée où doit être fait la recherche
 * @param  [string] $table      la table où on fait la recherche
 * @param  [boolean] $fetch_type la façon de renvoyer les données
 * @return [array]             tableau de valeurs renvoyer par la bd
 */
function show($params,$db_field,$table,$fetch_type){
   $db = database();

    if($fetch_type === true){

        $sql = "SELECT * FROM $table";
        $q = $db->query($sql);

        $user = $q->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }else{

        $sql = "SELECT * FROM $table WHERE $db_field = ?";
        $q = $db->prepare($sql);
        $q->execute([$params]);

        $user = $q->fetch(PDO::FETCH_OBJ);
        return $user;
    }
}

/**
 * exist cherche l'existance d'une entrée en bdd
 * @param  [string] $db_field le champs de la bdd où chercher
 * @param  [string || array] $params paramètres de la requete à executer
 * @return [boolean]
 */
function exist($db_field,$table,$params){
    $db = database();
    $sql = "SELECT * FROM $table WHERE $db_field = ?";
    $q = $db->prepare($sql);
    $q->execute([$params]);

    $user = $q->fetch();
    if($user){
        return true;
    }else{
        return false;
    }
}