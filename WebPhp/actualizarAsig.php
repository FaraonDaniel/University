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
				<div class="alumno">
					
					<?php 					
						//echo $_POST["asigs"];
						$admin= new Admin();
								
						echo "nombre nuevo : " . $_POST["nombre"] . ", id profesor nuevo : " . $_POST["profesor"] ;
						//$datosAsig = $admin->actualizarAsig($_POST["name"] ,$_POST["profesor"]);
						//echo $datosAsig['idAsignatura'];
						
						/*echo '  <form onsubmit = "return actualizar()" action = "actualizarAsig.php" method ="POST">
									<p>
									Nombre: <input type="text" id="name" name="nombre" placeholder ="'.$datosAsig['nombre'].'" autofocus  />
									<br />
									Id profesor: <input type="text" name="profesor" placeholder ="'.$datosAsig['idProfesor'].'" autofocus />
									<br />
									
									<input type ="submit" id = "modf" value = "actualizar"> 
								</form>
						';*/
					?>
					
				</div>
			</div>

        <?php require("includes/comun/pie.php"); ?>
    </div>

</body>

</html> 
