<?php   require_once __DIR__.'/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head class="header">
    <link rel="icon" type="image/png" href="images/icon.png"/>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
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
        <?php require("includes/comun/cabecera.php");?>
        <div id="contenido">
            <div class="tablaPracticas">
                <div class="tablaPracticasTitulo">
                    <div>
                    <h3>Practicas subidas</h3>
                    </div>
                    <div>
                        <a id="botonExcel"><icon class="fas fa-file-csv"></icon> Exportar a Excel </a>
                        <form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
                        <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                        </form>
                    </div>
                </div>
                <?php 

                    $idEnunciado = $_GET["idEnunciado"]; 

                    echo '<table class="table table-striped" id="Exportar_a_Excel">';
                    echo '<thead>
                                <tr>
                                <th id ="num" header="rank" scope="col">#</th>
                                <th id ="nombre" header="nameAl" scope="col">Nombre completo</th>
                                <th id ="verPractica" header="practicaVer" scope="col">Ver practica subida</th>
                                <th id ="AlumnoCorrector" header="alumnocorrector" scope="col">Corregido por alumno</th>
                                <th id ="Correccion" header="correccion" scope="col">Correccion</th>
                                <th id ="NotaAlumno" header="notaAsignada" scope="col">Nota</th>
                                </tr>
                        </thead><tbody>'; 
                
                

                    // Conseguimos el id de la asignatura a la que pertenece el enunciado
                    $idAsig = Enunciado::getIdAsigFromIdEnunciado($idEnunciado); 
                    // Conseguimos la lista de alumnos matriculados en dicha asignatura
                    $lista_alumnos = Usuario::getAlumnosFromAsig($idAsig); 
                    // Mostramos los datos
                    $cont = 1; $cont_nota = 0 ; 
                    while ( $data = $lista_alumnos->fetch_assoc()){
                        // Datos asociados a cada alumno
                        $rs = Enunciado::getElementsByIdEnunciadoAndUser($idEnunciado,$data["idAlumno"]); $aux=$rs->fetch_assoc(); 

                        //print_r($rs); echo "<br/>"; 
                            echo '<tr>';
                            echo '  <th scope="row">'.$cont.'</th>';                                              // Contador
                            echo '  <td>'.Usuario::getNameFromId($data["idAlumno"]).'</td>';                      // Nombre del alumno
                            if ($rs->num_rows == 0){
                                echo '  <td>No ha subido practica</td>';
                                echo '  <td></td>'; 
                                echo '  <td></td>'; 
                                echo '  <td>0.00</td>'; 
                            } 
                            else {
                                
                                echo '  <td>'."<a  href = 'verPractica.php?idPractica=".$aux["idPractica"]."&nombrePractica=".Practica::getNombreFromID($aux["idPractica"])."'>".Practica::getNombreFromID($aux["idPractica"])." </a></td>"; 
                                
                                $idQuienMeCorrige = CorreccionAlumno::dameAlumnoQueCorrige($aux["idPractica"]); 
                                    if ($idQuienMeCorrige){
                                        $nombreQuien = Usuario::getNameFromId($idQuienMeCorrige) ; 
                                        $nombre = Practica::getNombreFromID($aux["idPractica"]);
                                        echo '<td>'.$nombreQuien.'</td>'; 
                                        echo "<td>
                                                    <a href = 'correccionFinal.php?idCorreccion=$idQuienMeCorrige&idPractica=".$aux["idPractica"]."&nombrePractica=$nombre&idEnunciado=$idEnunciado&esCorregido=".$data["idAlumno"]."'>
                                                                    Ver correccion de ".$nombreQuien."
                                                    </a>
                                                </td>";
                                        echo '<form action = "subirNota.php" method="POST" >'; 
                                        echo '  <td><input type="number" min="0" max="10" step="0.01" value ='.$aux["Nota"].' name = "nota" id='.$aux["idPractica"].'><label for='.$aux["idPractica"].'</td>'; 
                                        echo '  <td><button type="submit"><icon class="far fa-edit"></icon></button></td>'; 
                                        echo '      <input type="hidden" name="idPractica" value='.$aux["idPractica"].'>'; 
                                        echo '      <input type="hidden" name="idEnunciado" value='.$idEnunciado.'>'; 
                                        echo '</form>'; 
                                        $cont_nota++; 
                                    }
                                    else {
                                        
                                        echo '<td></td>'; 
                                        echo "<td></td>";
                                        echo '<td>'.$aux["Nota"].'</td>';
                                    }

                                
                                
                            }  
                            echo '</tr>';
                            
                        $cont++;
                    }

                    echo "</tbody>"; 
                    echo "</table>";
                ?>
        </div>
        </div>
        <?php require("includes/comun/pie.php");?>
        <script src="js/Profesor/nota.js"></script>
        <script src="js/Excel/excel.js"></script>
    </div>
</body>

</html>