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

//Doit être repensé
/**
function template(){

    $forms = ['register','login','forgot','reset','reactive'];
    $account = ['account','settings','admin'];

    if (in_array($p, $form_pages)) {
        require 'pages/templates/fullscreen.php';
    } elseif ($p === 'account') {
        require 'pages/templates/connected.php';
    } else {
        require 'pages/templates/default.php';
    }
}
*/