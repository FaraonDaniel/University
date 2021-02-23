<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang = "es">

<head>
    <link rel="icon" type="image/png" href="images/icon.png" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <meta charset="utf-8">
    <title>CodRector</title>
</head>

<body>

    <div id="contenedor">
        <?php require("includes/comun/cabecera.php");?>
        <div id="contenidoAsig">
                <?php
                $form = new Profesor();
                $form->generaContenido();
                ?>
        </div>
        <?php require("includes/comun/pie.php");?>
    </div>
    <?php require("includes/comun/modal.php");?>
  
</body>
<script src="js/Profesor/menuProfesor.js"></script>
<script src="js/Validaciones/validateTema.js"></script>
<script src="js/Validaciones/validateEnunciado.js"></script>
<script src="js/modal.js"></script>
</html> 