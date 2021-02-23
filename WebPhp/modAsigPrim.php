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
						echo '<div id = "mod_asig_form">'; 
						Admin::modAsignaturaForm();
						echo '</div>'; 
						
  					?>
					
				</div>
			</div>

        <?php require("includes/comun/pie.php"); ?>
    </div>

</body>

</html> 
