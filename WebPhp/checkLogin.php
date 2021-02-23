<?php
require_once __DIR__.'/includes/config.php';
$app = Aplicacion::getSingleton();
$conn = $app->conexionBd();

    $username = $_GET['user'];
    $pwd = $_GET['pwd'];
    $user = Usuario::login($username, $pwd);
    if($user){
        echo "true";       
    }
    else{
        echo "false";
    }
    
