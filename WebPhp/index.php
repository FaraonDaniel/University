<?php   require_once __DIR__.'/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head class="header">
    <link rel="icon" type="image/png" href="images/icon.png" />
    <link rel="stylesheet" type="text/css" href="js/lib/bootstrap.min.css" /> 
    <title>CodRector</title>
</head>

<body>

    <div id="contenedor">
    <?php require("includes/comun/cabecera.php");?>
        <div id="contenido">
            <div class="paginaInicio">
                <div class="eslogan">
                    ¿Buscas una nueva forma de corregir código?
                </div>
                <div class="codigos"><img  src="images/codigo.png" alt="Code image"></div>
            </div>
        </div>
        <?php require("includes/comun/pie.php");?>
    </div>
</body>

</html>