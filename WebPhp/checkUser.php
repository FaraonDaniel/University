<?php
require_once __DIR__.'/includes/config.php';
$app = Aplicacion::getSingleton();
$conn = $app->conexionBd();

    $username = $_GET['user'];
    $user = Usuario::buscaUsuarioLogin($username);
    if ($user){
        echo "false";
    }
    else{
        echo "true";
    } 

