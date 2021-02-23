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
				<div class="inicioAdmin">
					
					<?php 					
					
						$admin= new Admin();
							$aux = isset($_POST["asigs"]) ? $_POST["asigs"] : null ; 
							$datosAsig = $admin->getAsig($aux);
						
						
							$modAsig = new FormularioModAsig($datosAsig['nombre'],$datosAsig['idProfesor']);
							echo $modAsig->getNombre() . "<br/>";
							$modAsig->gestiona();
							
					?>
					
				</div>
			</div>

        <?php require("includes/comun/pie.php"); ?>
    </div>

</body>

</html> 
