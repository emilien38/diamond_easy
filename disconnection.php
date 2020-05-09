<?php 
session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('login', '');
setcookie('pass_hache', '');

while (ob_get_status()) {
    ob_end_clean();
}

// no redirect
header("Location: /diamond.php");

?>