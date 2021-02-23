<?php
require_once __DIR__.'/includes/config.php';
$app = Aplicacion::getSingleton();
$conn = $app->conexionBd();

    $tema = $_GET['tema'];
    $id = $_SESSION['idAsignatura'];
    $res = Tema::buscarNombreTema($tema, $id);
    if ($res){
        echo "true";
    }
    else{
        echo "false";
    }