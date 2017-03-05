<?php

#functions for Forms datas validation

/**
 * isAlphanum verifie si la valeur entrée est alphanumerique
 * @param  [string]  $field    champ à verifier
 * @return boolean
 */
function isAlphanum($field){
	if(empty($field) || !preg_match('/^[a-zA-Z0-9]+$/', $field)){
	    return false;
	}
	return true;
}

/**
 * isEmail verifie si la valeur entrée est une adresse email
 * @param  [string]  $field    champ à verifier
 * @return boolean           
 */
function isEmail($field){
	if(empty($field) || !filter_var($field, FILTER_VALIDATE_EMAIL)){
	    return false;
	}
}

/**
 * isNum verifie si la valeur entrée est un nombre
 * @param  [string]  $field    champ à verifier
 * @return boolean
 */
function isNum(){
	if (empty($field) || !is_numeric($field)) {
	    return false;
	}
}

/**
 * checkEgality verifier l'existance et la conformité de deux parametres(champs)
 * @param  [string || int] $field1   premier champ(champ à verifier)
 * @param  [string || int] $field2   deuxieme champ(pour verifier la correspondance de mot de passe)
 * @return [boolean]
 */
function isEgalTo($field1,$field2){
	if(empty($field1) || $field1 != $field2){
	    return false;
	}
}

/**
 * checkLength verifie si la longueur du parametre $field est superieur ou inferieur à $num
 * @param  [string] $field    champ à verifier
 * @param  [int] $num      le nombre de verification
 * @param  [boolean] $opType   le type d'operation à faire
 * @return [boolean]
 */
function checkLength($field,$num,$opType){
	if ($opType === true) {
		if (mb_strlen($field) < $num) {
			return false;
		}
	}else{
		if (mb_strlen($field) > $num) {
			return false;
		}
	}
}