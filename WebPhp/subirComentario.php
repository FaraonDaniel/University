<?php require_once __DIR__ . '/includes/config.php'; ?>

<?php
    $idPractica = $_POST["idPractica"]; 
    //  echo "La id practica es : " . $idPractica ."<br/>"; 
    //echo "<pre>" . $_POST["codesnippet_editable"] . "</pre>"; 
    $comentario = $_POST["comentario"] ; 
    CorreccionAlumno::subirComentario($idPractica,$comentario); 
    // Mensaje de exito o de fallo ;)
?>