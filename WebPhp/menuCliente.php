<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/png" href="images/icon.png" />
    <meta charset="utf-8">
    <title>CodRector</title>
</head>

<body>

    <div id="contenedor">
        <?php require("includes/comun/cabecera.php"); ?>
        <div id="contenido">
            <?php
            if (isset($_SESSION['login']) && $_SESSION['login']) {
                if (isset($_SESSION['esProfe']) && $_SESSION['esProfe'])
                    header('Location: menuProfesor.php');
                elseif (isset($_SESSION['esAdmin']) && $_SESSION['esAdmin']) {
                    header('Location: menuAdministrador.php');
                }
				else {
					header('Location: menuAlumno.php');
				}
            }
            else{
                header('Location: index.php');
            }
            ?>
        </div>

        <?php require("includes/comun/pie.php"); ?>
    </div>

</body>

</html> 