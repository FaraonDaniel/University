<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/png" href="images/icon.png" />
    <meta charset="utf-8">

    <script src="codemirror/lib/codemirror.js"></script>
    <link rel="stylesheet" type="text/css" href="codemirror/lib/codemirror.css">
    <link rel="stylesheet" type="text/css" href="codemirror/theme/ambiance.css">
    <link rel="stylesheet" type="text/css" href="codemirror/theme/duotone-light.css">
    <link rel="stylesheet" href="codemirror/lib/codemirror.css">
    <script src="codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="codemirror/lib/codemirror.js"></script>
    <script src="codemirror/mode/xml/xml.js"></script>
    <script src="codemirror/mode/javascript/javascript.js"></script>
    <script src="codemirror/mode/css/css.js"></script>
    <script src="codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="codemirror/addon/edit/matchbrackets.js"></script>

    <title>CodRector</title>
</head>

<body>
    <?php require("includes/comun/cabecera.php"); ?>
    <div id="contenido">
        <div id="correccionCodemirror">
            <div id='practicaAlumnoCorrecion'>
                <h3>Código a corregir</h3>
                <?php 
                    Practica::verPractica($_GET['idPractica'], $_GET['nombrePractica']);
                ?>
            </div>
            <div id='correccionAlumno'>
                <h3>Corrección</h3>
                <?php CorreccionAlumno::verCorreccion($_GET['idPractica']); ?>
            </div>
        </div>
    </div>
    <?php require("includes/comun/pie.php"); ?>
    <?php require("includes/comun/modal.php");?>
    <script src="js/Alumno/corregirAlumno.js"></script>
    <script src="js/CodeMirror/textAreaas.js"></script>
    <script src="js/modal.js"></script>
</body>

</html>