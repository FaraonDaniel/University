<?php   require_once __DIR__.'/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/png" href="images/icon.png"/>
    <meta charset="utf-8">
    <title>CodRector</title>
    <script src="js/lib/jquery-3.4.1.min.js"></script>
	<script src="js/Validaciones/validateUser.js"></script>
</head>

<body>

    <div id="contenedor">
    <?php require("includes/comun/cabecera.php");?>
        <div id="contenido">
            <?php 
            
                $form = new FormularioRegistro();
                $form->gestiona();

            ?>	
        </div>
   
        <?php require("includes/comun/pie.php");?>
    </div>

</body>

</html>