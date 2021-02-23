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
            if (isset($_GET['idEnunciado']) && isset($_GET['idTema'])) {
                $_SESSION['idEnunciado'] = $_GET['idEnunciado'];
                $_SESSION['idTema'] = $_GET['idTema'];
            }
            $form = new FormularioCrearPractica( $_SESSION['idEnunciado'], $_SESSION['idTema']);
            $form->gestiona();
            ?>
        </div>

        <?php require("includes/comun/pie.php"); ?>

    </div>

</body>

</html> 