<?php
session_start();

require 'App/_func.php';

$form_pages = ['register','login','forgot','reset','reactive'];

if (isset($_GET['p'])) {
	$p = htmlentities($_GET['p']);
} else {
	$p = 'home';
}
/**
$dir    = 'pages';
$files = scandir($dir);
$i = $p.".php";
if (in_array($i,$files)) {
	echo "Je suis la page ".$p;
}
*/
$titre = page_title();



ob_start();
if ($p === 'home') {
	require 'pages/home.php';
} elseif ($p === 'login') {
	require 'pages/login.php';
} elseif ($p === 'register') {
	require 'pages/register.php';
} elseif ($p === 'config') {
	require 'pages/config.php';
} elseif ($p === 'forgot') {
	require 'pages/forgot.php';
} elseif ($p === 'reset') {
	require 'pages/reset.php';
}elseif ($p === 'active') {
	require 'pages/active.php';
}elseif ($p === 'reactive') {
	require 'pages/reactive.php';
} elseif ($p === 'info') {
	require 'pages/info.php';
} elseif ($p === 'account') {
	require 'pages/account.php';
} elseif ($p === 'settings') {
	require 'pages/settings.php';
} elseif ($p === 'logout') {
	require 'pages/logout.php';
} else {
	require 'pages/404.php';
}
$content = ob_get_clean();

if (in_array($p, $form_pages)) {
	require 'pages/templates/fullscreen.php';
} elseif ($p === 'account') {
	require 'pages/templates/connected.php';
} else {
	require 'pages/templates/default.php';
}
