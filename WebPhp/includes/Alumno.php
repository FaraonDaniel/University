<?php 

class Alumno extends Usuario{
    
  
    public function __construct(){
        if (isset($_SESSION['nick']) && isset($_SESSION['nombre'])) {
            parent::__construct($_SESSION['nick'], $_SESSION['nombre'], '', '', '');
        }
    }

    public function generaContenido(){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $idAlumno = $_SESSION['id'];
        $rs = $this->asignaturasAlumno($idAlumno,$conn);
        $result = false;
        if ($rs->num_rows > 0) {
            echo '<div class="contenidoProfesor">';
           
            while ($fila = $rs->fetch_assoc()) {
                $idAsignatura=$fila['idAsignatura'];

                echo "<div class='asignatura' id='".$idAsignatura."'>";
                echo "<div class='asignaturaTitulo'>";
                echo "<div class='asignaturaNombre'>
                        <div class ='desplegable' ><icon></icon></div>
                        <div><span>".$fila['nombre']."</span></div>
                    </div>";
                
                echo "</div>";
                
                $rs_temas = $this->temasPorAsignatura($idAsignatura,$conn);
                while($temas = $rs_temas->fetch_assoc()){
                    echo "<div class='tema'><span class='temaTitulo'>".$temas['nombre']."</span></div>";
                    $idTema = $temas['idTema'];                    
                    $enunciados = $this->enunciadosPorTema($idTema, $conn);

                    while($enunciadosAlumnos = $enunciados->fetch_assoc()){ // Por cada enunciado...
                        // 
                        $idEnunciado = $enunciadosAlumnos['idEnunciado'];  
                        // Lo cual para sacar el nombre sera : 
                        $nombreEnunciado = $enunciadosAlumnos['nombre'];  
                        $practicas=$this->practicasPorEnunciados($idEnunciado, $idAlumno, $conn);
                                echo "<div class='enunciado'> ";
                                echo "<span>".$enunciadosAlumnos['nombre']. "</span>";
                                echo "<div class='enlacesEnunciadoProfesor'>";
                                echo "<div class='optionAlumnos'>
                                        <a href='verEnunciado.php?idEnunciado=".$idEnunciado."&nombre=".$nombreEnunciado."'> <icon class='fas fa-eye'></icon> Ver enunciado </a>
                                    </div>";
                           
                            // COMPROBAMOS QUE LA PRACTICA ESTA CERRADA O NO
                            $practicaAbierta =$this->pasarACorreccion($enunciadosAlumnos['FechaFin']);
                            $isRotada = Self::isRotada($idEnunciado); 
                                if(!$practicaAbierta and !$isRotada ){
                                            Enunciado::rotarAlumnosPractica($idEnunciado); 
                                }
                            
                            if($practicas->num_rows == 0){
                                if(!$practicaAbierta){
                                    // Como no ha subido el alumno una practica, no puede corregir la práctica de otro
                                        echo "<div class='eliminarEnunciado'>Practica cerrada </div>";
                                }
                                else{
                                    echo "<div class='optionAlumnos'>";
                                        echo "<a href = 'crearPractica.php?idEnunciado=$idEnunciado&idTema=$idTema'><icon class='fas fa-plus'></icon> AÑADIR PRÁCTICA </a>";
                                    echo "</div>";
                                    
                                    echo "<div class='optionAlumnos'>";
                                        echo "Entrega: ".$enunciadosAlumnos['FechaFin'];
                                    echo "</div>";
                                }
                            }
                            else{
                                
                                while($practicasAlumnos = $practicas->fetch_assoc()){
                                    $idPractica = $practicasAlumnos['idPractica'];
                                    $nombrePractica=$practicasAlumnos['nombre'];
        
                                    echo "<div class='optionAlumnos'>
                                            <a  href = 'verPractica.php?idPractica=$idPractica&nombrePractica=$nombrePractica'> <icon class='fas fa-eye'></icon> Ver práctica subida </a>
                                        </div>";

                                    if(!$practicaAbierta){ 
                                        echo "<div class='optionAlumnos'>";
                                        $correccion = CorreccionAlumno::buscaCorrecionAlumno($idEnunciado, $_SESSION['id']);           
                                        if($correccion){
                                            $idCorreccion = $correccion->idCorreccionAlumno();
                                            $nombre = $correccion->buscaNombrePractica($idCorreccion);
                                            $idPracticaACorregir=$correccion->idPractica();
                                            echo "<a href = 'corregirPracticaCompaniero.php?idCorreccion=$idCorreccion&idPractica=$idPracticaACorregir&nombrePractica=$nombre&idEnunciado=$idEnunciado'>Corregir a compañero</a>";  // LLamar para hacer la consulta---
                                     
                                        }
                                        echo "</div>";
                                        }
                                    else {

                                        echo "<div class='optionAlumnos'>";
                                             echo "<div class='borrarPractica'><a href = 'borrarPractica.php?idPractica=$idPractica&idEnunciado=$idEnunciado'><icon class='fas fa-trash-alt'></icon> Borrar práctica  </a></div>";
                                        echo "</div>"; 
                                    }
                                }
                            }
                            echo "</div>";
                            echo "</div>";

                           
                    }

                }
            
                echo "</div>";
            }
            echo "</div>";
            $rs->free();

        } else {
            echo "No tiene asignadas asignaturas";
        }
        return $result;
    }

    private function asignaturasAlumno($idAlumno,$conn){
        $query = sprintf("  SELECT a.nombre, a.idAsignatura 
                            FROM alumnos_matriculados am, matriculados m,asignatura a 
                            WHERE $idAlumno=am.idAlumno AND  am.idMatriculados=m.idMatriculados AND a.idAsignatura=m.idAsignatura");
        $rs = $conn->query($query);
        return $rs;
    }
 

    private function temasPorAsignatura($idAsignatura,$conn){
        $query_temas=sprintf("  SELECT t.nombre,t.idTema 
                                FROM tema t 
                                WHERE t.idAsignatura =  $idAsignatura   ");
                    
        $rs_temas = $conn->query($query_temas);
        return $rs_temas;
    }


    private function practicasPorTema($idTema,$conn){
        $query_practicas = sprintf("    SELECT pr.nombre, pr.idPractica
                                        FROM practicas pr
                                        WHERE pr.idTema=$idTema");
        $practicas = $conn->query($query_practicas);
        return $practicas;
    }

    private function practicasPorEnunciados($idEnunciado, $idAlumno, $conn){
        $query_practicas = sprintf("    SELECT pr.nombre, pr.idPractica, pr.idTema
                                        FROM practicas pr
                                        WHERE pr.idEnunciado=$idEnunciado AND pr.idAlumno = $idAlumno");
        $practicas = $conn->query($query_practicas);
        return $practicas;
    }
    private function enunciadosPorTema($idTema,$conn){
        $query_enunciados = sprintf("   SELECT *
                                        FROM enunciado e 
                                        WHERE e.idTema =  $idTema");
        $rs_enunciados = $conn->query($query_enunciados);
        return $rs_enunciados;
    }

    private function faseDeCorreccion($idAlumno, $conn){
        $query_practicasExternas = sprintf("    SELECT *
                                                FROM correccionalumno ca
                                                WHERE ca.idAlumnoCorrector=$idAlumno");
        $correccionExternaAlumno = $conn->query($query_practicasExternas);
        return $correccionExternaAlumno;
    }

    public static function listaAlumnos(){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuarios u, alumnos a WHERE a.idAlumno = u.idUsuario");
        $rs = $conn->query($query);

        return $rs;
    }



   
}


