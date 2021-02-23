<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="styles/yonce.css">
    <link rel="icon" type="image/png" href="images/icon.png" />
    <meta charset="utf-8">
    <script src="codemirror/lib/codemirror.js"></script>
    <link rel="stylesheet" type="text/css" href="codemirror/lib/codemirror.css">
    <link rel="stylesheet" type="text/css" href="codemirror/theme/ambiance.css">
    <script type="text/javascript" src="codemirror/lib/codemirror.js"></script>
    <script type="text/javascript" src="codemirror/mode/javascript/javascript.js"></script>
    <script type="text/javascript" src="codemirror/mode/xml/xml.js"></script>
    <script src="codemirror/mode/css/css.js"></script>
    <script src="codemirror/mode/xml/xml.js"></script>
    <script src="codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <title>CodRector</title>
</head>

<body>

    <div id="contenedor">
        <?php require("includes/comun/cabecera.php"); ?>
        <div id="contenido">
            <div id="codigo">
                <?php 
                    if (isset($_GET['idPractica']) && isset($_GET['nombrePractica']) ) {
                        $_SESSION['idPractica'] = $_GET['idPractica'];
                        $_SESSION['nombrePractica'] = $_GET['nombrePractica'];
                    }

                    if(Usuario::usuarioYpractica($_SESSION['id'], $_SESSION['idPractica'])){
                        echo "<h3> Práctica: ".$_SESSION['nombrePractica']." </h3>";
                        Practica::verPractica($_SESSION['idPractica'], $_SESSION['nombrePractica']);
                    }
                    else{
                        header('Location: menuCliente.php');
                    }
                    unset($_SESSION["idPractica"]);
                    unset($_SESSION["nombrePractica"]);
                ?>
            </div>
        </div>
        <?php require("includes/comun/pie.php"); ?>
    </div>
    <script src="js/Alumno/practicaAlumno.js"></script>
    
</body>

</html>