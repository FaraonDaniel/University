<?php   require_once __DIR__.'/includes/config.php'; ?>
<?php

    $idPractica = $_POST["idPractica"]; 
    $nota = $_POST["nota"]; 
    $idEnunciado = $_POST["idEnunciado"]; 

    Practica::modificarNota($idPractica, $nota); 

    header("Location:verPracticasdeEnunciado.php?idEnunciado=$idEnunciado"); 



