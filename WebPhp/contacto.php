<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/png" href="images/icon.png" />
    <meta charset="utf-8">

    <title>Detalles</title>
</head>

<body>

    <div id="contenedor">
        <?php require("includes/comun/cabecera.php"); ?>
        <div id="contenido">
            <div id="contacto">
                <div class="formContacto">
                    <form action="mailto: marios08@ucm.es" method="post" enctype="text/plain">
                        <fieldset id="personales">
                            <legend>Datos personales</legend>
                            Nombre:<br> <input type="text" name="nom"><br>
                            E-mail:<br> <input type="text" name="mail"><br>
                        </fieldset>
                        <fieldset id="personales">
                            <legend>Motivos de consulta</legend>
                            <input type="radio" name="option" value="Evaluación"> Evaluación<br>
                            <input type="radio" name="option" value="Sugerencias">Sugerencias<br>
                            <input type="radio" name="option" value="Críticas"> Críticas <br>
                        </fieldset>
                        Observaciones:<br> <textarea name="obs"></textarea> <br>
                        <input type="checkbox" name="condi" value="ok">Marque esta casilla para verificar
                        que ha leído nuestros términos y condiciones del servicio.<br><br><br>
                        <input type="submit" name="aceptar">
                     </form>
                </div>
            </div>
        </div>
        <?php require("includes/comun/pie.php"); ?>
    </div> <!-- Fin del contenedor -->

</body>

</html> 