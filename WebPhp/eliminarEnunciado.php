<?php require_once __DIR__ . '/includes/config.php';

if (isset($_GET['idEnunciado'])) {
    $_SESSION['idEnunciado'] = $_GET['idEnunciado'];
    $_SESSION['idTema'] = $_GET['idTema'];
    $_SESSION['nombreEnunciado'] = $_GET['nombre'];
}
$enunciado = Enunciado::borrar( $_SESSION['idEnunciado'], $_SESSION['idTema'], $_SESSION['nombreEnunciado']);  
header('Location: menuCliente.php');