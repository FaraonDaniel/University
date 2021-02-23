<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang = "es">

<head>
    <link rel="icon" type="image/png" href="images/icon.png" />
    <link rel="stylesheet" type="text/css" href="js/lib/bootstrap.min.css" >
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <meta charset="utf-8">
    <title>CodRector</title>
</head>

<body>

    <div id="contenedor">
        <?php require("includes/comun/cabecera.php"); ?>
        <div id="contenidoAsig">
                <?php
                if(isset($_SESSION['idEnunciado'])){
                    unset($_SESSION['idEnunciado']);
                }
                if(isset($_SESSION['idPractica'])){
                    unset($_SESSION['idPractica']);
                }
                if(isset($_SESSION['idTema'])){
                    unset($_SESSION['idTema']);
                }

                $alumno = new Alumno();
                $alumno->generaContenido();
                ?>
                <?php require("includes/comun/modal.php");?>
        </div>

        <?php require("includes/comun/pie.php"); ?>
    </div>
    <script src="js/Alumno/menuAlumno.js"></script>
    <script src="js/modal.js"></script>
</body>


</html> 