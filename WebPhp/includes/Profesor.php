<?php

class Profesor extends Usuario {
    public function __construct() {
        if(isset($_SESSION['nick'])&&isset($_SESSION['nombre'])){
            parent::__construct( $_SESSION['nick'], $_SESSION['nombre'], '', '', '');
        }
    }
    public function generaContenido() {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $idProfesor=$_SESSION['id'];

        $rs = $this->asignaturasProfesor($idProfesor,$conn);
        if ($rs->num_rows>0) {
                echo '<div class="contenidoProfesor">';

                while($fila = $rs->fetch_assoc()) {
                    echo "<div class='asignatura' id='".$fila['idAsignatura']."' >";
                    echo "<div class='asignaturaTitulo'>";
                    echo "<div class='asignaturaNombre'>
                            <div class ='desplegable' ><icon></icon></div>
                            <div><span>".$fila['nombre']."</span></div>
                        </div>";
                    echo "<div class='añadirTema'><a href='addTema.php?idAsignatura=".$fila['idAsignatura']."'> <icon class='fas fa-plus'></icon> Añadir tema</a></div>";
                   
                    echo "</div>";
                    $idAsignatura=$fila['idAsignatura'];
                    
                    $rs_temas =$this->temasPorAsignatura($idAsignatura,$conn);
                    if ($rs_temas->num_rows>0){
                        while($fila_tema = $rs_temas->fetch_assoc()) {

                            echo "<div class='tema'>";
                            echo "<div class='temaTitulo'>".$fila_tema['nombre']."</div>";
                            echo "<div class='añadirEnunciado'><a href='addEnunciado.php?idTema=".$fila_tema['idTema']."&idAsignatura=".$idAsignatura."'><icon class='fas fa-plus'></icon> Añadir enunciado</a></div>";
                            echo "<div class='eliminarEnunciado'><a href='borrarTema.php?idTema=".$fila_tema['idTema']."&idAsignatura=".$idAsignatura."'> <icon class='fas fa-minus-circle'></icon> Eliminar tema</a></div>";
                            echo "</div>";
                            $idTema=$fila_tema['idTema'];
                            
                            $rs_enunciados = $this->enunciadosPorTema($idTema,$conn);

                            if ($rs_enunciados->num_rows>0){
                                while($fila_enunciado = $rs_enunciados->fetch_assoc()) {

                                    $practicaAbierta =$this->pasarACorreccion($fila_enunciado['FechaFin']);
                                    $isRotada = $this->isRotada($fila_enunciado['idEnunciado']); 
                                    if(!$practicaAbierta and !$isRotada ){
                                                Enunciado::rotarProfesorPractica($fila_enunciado['idEnunciado']); 
                                    }

                                    echo "<div class='enunciado'>";
                                    echo "<span>".$fila_enunciado['nombre']. "</span>";
                                    echo "<div class='enlacesEnunciadoProfesor'>";
                                    echo "<div class='botonVerEnunciado' ><a href='verEnunciado.php?idEnunciado=".$fila_enunciado['idEnunciado']."&nombre=".$fila_enunciado['nombre']."'> <icon class='fas fa-eye'></icon> VER </a></div>";
                                    echo "<div class='botonEliminarEnunciado' ><a href='eliminarEnunciado.php?idEnunciado=".$fila_enunciado['idEnunciado']."&idTema=".$fila_tema['idTema']."&nombre=".$fila_enunciado['nombre']."'> <icon class='fas fa-minus-circle'></icon> Eliminar</a></div>";
                                    echo "<div class='practicasAlumnos'><a href='verPracticasdeEnunciado.php?idEnunciado=".$fila_enunciado['idEnunciado']."'> <icon class='fas fa-clipboard-list'></icon> Prácticas Subidas </a></div>";
                                    echo "</div>";
                                    echo "</div>";
                                }

                            }
                        }
                    }
                    echo "</div>";
                    
                }
                echo '</div>';
            $rs->free();
        } else {
            echo "<div>Sin asignaturas</div>" ;
        }
        return '';
    }


    private function asignaturasProfesor($idProfesor,$conn){
        $query = sprintf("  SELECT a.nombre, a.idAsignatura 
                             FROM asignatura a 
                             WHERE a.idProfesor = $idProfesor ");
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


    private function enunciadosPorTema($idTema,$conn){
        $query_enunciados = sprintf("   SELECT *
                                        FROM enunciado e 
                                        WHERE e.idTema =  $idTema");
        $rs_enunciados = $conn->query($query_enunciados);
        return $rs_enunciados;
    }


}