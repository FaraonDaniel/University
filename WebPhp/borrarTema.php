<?php 
require_once __DIR__ . '/includes/config.php';

if (isset($_GET['idTema'])) {
    $_SESSION['idTema'] = $_GET['idTema'];
    $_SESSION['idAsignatura'] = $_GET['idAsignatura'];
}
$practica = tema::borrar( $_SESSION['idTema'], $_SESSION['idAsignatura']);  
header('Location: menuCliente.php');
