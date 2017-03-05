<?php
session_start();

require_once 'app/_func.php';

$title = page_title();

ob_start();
	routage();
$content = ob_get_clean();

require template();