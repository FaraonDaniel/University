<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/png" href="images/icon.png" />
    <meta charset="utf-8">

    <script src="codemirror/lib/codemirror.js"></script>
    <link rel="stylesheet" type="text/css" href="codemirror/lib/codemirror.css">
    <link rel="stylesheet" type="text/css" href="codemirror/theme/ambiance.css">
    <link rel="stylesheet" type="text/css" href="codemirror/theme/erlang-dark.css">
    <script type="text/javascript" src="codemirror/lib/codemirror.js"></script>
    <script type="text/javascript" src="codemirror/mode/javascript/javascript.js"></script>
    <script type="text/javascript" src="codemirror/mode/xml/xml.js"></script>
    <script src="codemirror/mode/css/css.js"></script>
    <script src="codemirror/mode/xml/xml.js"></script>
    <script src="codemirror/mode/htmlmixed/htmlmixed.js"></script>
    
    
    <title>CodRector</title>
</head>
<body>

        <?php require("includes/comun/cabecera.php"); ?>
        
        <div id="contenido">
            <div id="correccionProfesordeAlumno">
                <div>
                    <h1> CORRECCION DE ALUMNOS </h1>
                    <?php
                        $nombreQuien = Usuario::getNameFromId($_GET["idCorreccion"]) ; 
                        $yo = Usuario::getNameFromId($_GET["esCorregido"]) ;
                        echo $nombreQuien . " ha corregido a " . $yo ; 
                    ?>
                </div>
                <div id="correccionCodemirror">
                    <div id='practicaAlumnoCorrecion'>
                    <?php 
                        echo "<h3>Código de ". $yo."</h3>"; 
                            Practica::verPractica($_GET['idPractica'], $_GET['nombrePractica']);
                        ?>
                    </div>
                    <div id='correccionAlumno'>
                    <?php 
                        echo '<h3>Corrección de '.$nombreQuien.'</h3>'; 
                        
                            echo '<textarea  id="codesnippet_editable">'.CorreccionAlumno::getComentario($_GET['idPractica']).'</textarea>'; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php require("includes/comun/pie.php"); ?>
        <script src="js/CodeMirror/alumnoCorregido.js"></script>
        <script src="js/CodeMirror/alumnoCorrector.js"></script>

</body>

</html>


