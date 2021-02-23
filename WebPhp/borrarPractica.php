<?php 
require_once __DIR__ . '/includes/config.php';

if (isset($_GET['idPractica'])) {
    $_SESSION['idPractica'] = $_GET['idPractica'];
    $_SESSION['idEnunciado'] = $_GET['idEnunciado'];
}
$practica = Practica::borrar( $_SESSION['idPractica'], $_SESSION['idEnunciado']); 
unset($_SESSION["idPractica"]);
unset($_SESSION["idEnunciado"]);
header('Location: menuCliente.php');

