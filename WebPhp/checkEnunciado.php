<?php
require_once __DIR__.'/includes/config.php';
$app = Aplicacion::getSingleton();
$conn = $app->conexionBd();
$enunciado = $_GET['nombreEnunciado'];
$res = Enunciado::buscaEnunciadoExistente($enunciado);
if ($res){
    echo "true";
}
else{
    echo "false";
}