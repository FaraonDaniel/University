<?php   require_once __DIR__.'/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/png" href="images/icon.png"/>
    <meta charset="utf-8">
    <title>CodRector</title>

</head>

<body>

    <div id="contenedor">
    <?php require("includes/comun/cabecera.php");?>
        <div id="contenido">
            <?php 
                if(isset($_GET['idAsignatura'])){
                    $_SESSION['idAsignatura']=$_GET['idAsignatura'];
                }
                $addTema = new FormularioCrearTema($_SESSION['idAsignatura']);
                $addTema->gestiona();
                 ?>
        </div>
   
        <?php require("includes/comun/pie.php");?>
    </div>
    <script src="js/Validaciones/validateTema.js"></script>
</body>


</html>