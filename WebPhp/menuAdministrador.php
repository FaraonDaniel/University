<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang = "es">

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
					<?php $admin= new Admin(); ?>		
						
						<div id = "but_asig">	
							<button type="button"> Gestionar asignaturas </button>
						</div>	
						<div id = "but_mat">	
							<button type="button"> Gestionar matriculados </button>
						</div>	
						<div id ="asig" >
							<?php 	$admin->generaCont();?>
						</div>	
				</div>
					
			</div>
        <?php require("includes/comun/pie.php"); ?>
    </div>
	<script type="text/javascript" src="js/Admin/menAdmin.js"></script>
</body>

</html> 
