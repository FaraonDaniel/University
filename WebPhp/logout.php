<?php
require_once __DIR__.'/includes/config.php';

//Doble seguridad: unset + destroy
unset($_SESSION["login"]);
unset($_SESSION["nombre"]);
unset($_SESSION["nick"]);
unset($_SESSION["pwd"]);
unset($_SESSION["id"]);
unset($_SESSION["esAdmin"]);
unset($_SESSION["esProfe"]);
session_destroy();
header('Location: index.php');
?>