<?php

class FormularioCreaAsignatura extends Form {
 
    function __construct() {
        parent::__construct("crear_asignatura",array());
    }
    protected function generaCamposFormulario($datosIniciales){
		
		$rs = Admin::listaProfesores(); 
		if ($rs->num_rows > 0) {
			
				$cont = '		  
										<h3><label for="name">Nombre de la asignatura : </label></h3>
										 <input type="text" id="name" name="nombre" autofocus />
								  
										<h3><label for="profe">Id profesor : </label></h3>
											<select name="profesor" id="profe" size="4">  ';
											while($fila = $rs->fetch_assoc()) {
													$cont .="<option>".$fila['nick']."</option>";
											}
		
				$cont .= '					</select><br/>
								  
								  <div class = "inicioAdmin">		
											<button type ="submit" id = "modf" >crear </button> 
											<button type="button" onclick = "location.href=\'menuCliente.php\'"> volver </button>
								  </div>';
								   
				$rs->free();						
				return $cont ;
			} else {
				echo "No hay ningun profesor declarado";
				exit();
			}
									
									
    }
	
    protected function procesaFormulario($datos){
		
        $erroresFormulario = array();
        
        $nom= isset($datos['nombre']) ? $datos['nombre'] : null;
        $prof= isset($datos['profesor']) ? $datos['profesor'] : null;
		
		// TODO controlar errores profesor y sacar la lista de ellos 
        if ( empty($nom) || mb_strlen($nom) < 5 ) {
            $erroresFormulario[] = "El nombre de la asignatura no puede tener menos de 5 carácteres";
        }
	
        if (count($erroresFormulario) === 0) {
			
            $admin= new Admin();
			$admin->crearAsig($nom,$prof); 
			
			echo "Se ha creado correctamente la asignatura" ; 
			
			header('Location: menuCliente.php');
                exit();
        }
		
        return $erroresFormulario;
    }
    
 }