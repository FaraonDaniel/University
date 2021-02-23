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
            <div class="addEnunciado">
                <?php 
                if(isset($_GET['idTema'])&&isset($_GET['idAsignatura'])){
                    $_SESSION['idTema']=$_GET['idTema'];
                    $_SESSION['idAsignatura']=$_GET['idAsignatura'];
                }
                
                $addEnunciado = new FormularioAddEnunciado($_SESSION['idTema'], $_SESSION['idAsignatura']);
                $addEnunciado->gestiona();
                 ?>
                </div>
            </div>
        </div>

        <?php require("includes/comun/pie.php"); ?>
    </div>
    <script src="js/Validaciones/validateEnunciado.js"></script>
</body>

</html> 