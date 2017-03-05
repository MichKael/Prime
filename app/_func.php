<?php


function projet_name($name = 'Prime Framework'){
    return $name;
}
/**
 * page_title permet d'avoir le titre de la page sur laquelle on est
 * @return [string] renvoie le titre de la page en cours
 */
function page_title(){

    $titles = [
    "home" => "Accueil",
    "404" => "Page not found",
    ];

    if (isset($_GET['p'])) {
        $page = htmlentities($_GET['p']);

        foreach ($titles as $key => $title) {
            if ($page === $key) {
                return $title;
            }
        }
        if ($page !== $key) {
                return $title = "Page not found";
            }
    }else{
        return $title = "Accueil";
    }

}

/**
 * routage permet de rediriger l'utilisateur en fonction du parametre $p passé
 * @return rien
 */
function routage(){

    if (isset($_GET['p'])) {
        $page = htmlentities($_GET['p']);
    }
    
    if (isset($page)) {

        # tu ouvres le dossier pages/
        $directory = scandir('pages');
        $php_file = $page.'.php';
        # tu check si un fichier $page + '.php' existe
        if (in_array($php_file,$directory)) {
        # tu fais un require "pages/$page + .php"
            require 'pages/'.$page.'.php';
        }else{
            require 'pages/404.php';
        }
        # sinon tu require "pages/404.php"
    }else{
        $page = 'home';
        require 'pages/'.$page.'.php';
    }
}

/**
 * template renvoie le model de page correspondant à la demande de l'utilisateur
 * @return [string] le chemin du template à renvoyer
 */
function template(){

    $forms = ['register','login','forgot','reset','reactive'];
    $account = ['account','settings','admin'];

    if (isset($_GET['p']) && $_GET['p'] != 'home') {
        $page = htmlentities($_GET['p']);

        if (in_array($page, $forms)) {
            return 'pages/templates/[YOUR_TEMPLATE]';
        } elseif ($page === '[YOUR_TEMPLATE]') {
            return 'pages/templates/[YOUR_TEMPLATE]';
        } else {
            return 'pages/templates/default.php';
        }
    } else {
        return 'pages/templates/default.php';
    }
}