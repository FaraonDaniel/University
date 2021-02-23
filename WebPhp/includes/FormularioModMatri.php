<?php
require_once 'includes/config.php';
// TODO ENTERO
class FormularioModMatri extends Form {
 
    private $nombre;
    private $profesor;
    function __construct() {
        parent::__construct("crear_matriculado",array());
    }
    protected function generaCamposFormulario($datosIniciales){

        $rs = Self::listaAlumnos(); 

		$rs_asig = Asignatura::listaAsignaturas();
	
		// Lo primero serĂ¡ escoger un alumno
        $cont =  '<h3> <label for="alum">Escoja el alumno que quiera matricular en una asignatura </label></h3>';
        $cont .= '<select name="alumno" id="alum" required size="5">';	

        
				while($fila = $rs->fetch_assoc()) {
					$cont .= "<option>".$fila['nick']."</option>";
				}
				$cont .= '</select>' ;
		// Lo segundo serĂ¡ escoger una asignatura
        $cont .= '<h3><label for="asign"> Escoja la asignatura </label></h3>';
        $cont .= '<select name="asignatura" id="asign" required size="5" >';
					while($fila_aux = $rs_asig->fetch_assoc()) {
						$cont .= "<option>".$fila_aux['nombre']."</option>";
					}
                    $cont .= '</select>' ; 
		// Envio de formulario
        $cont .= '<p><input type = "submit" value = "asignar"> </p>';
				
                $rs->free(); $rs_asig->free(); 
                
                return $cont ; 
    }
	
    protected function procesaFormulario($datos){
        
        $erroresFormulario = array();
        
        $nombre= isset($datos['alumno']) ? $datos['alumno'] : null;
        $asig = isset($datos['asignatura']) ? $datos['asignatura'] : null;

        if (count($erroresFormulario) === 0) {
            Admin::introducirMatriculado($datos['alumno'],$datos['asignatura'] ); 
			header('Location: menuCliente.php');
                exit();
        }
		
        return NULL; 
    }
      public static function listaAlumnos(){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf(" SELECT * FROM `usuarios` u WHERE u.rol = 2");
        $rs = $conn->query($query) or die("No se ha podido obtener la lista de alumnos");
        return $rs;
    }

 }