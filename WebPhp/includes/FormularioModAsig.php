<?php

class FormularioModAsig extends Form {
 
    private $nombre;
    private $profesor;
    function __construct($nombre, $profesor) {
        $this->nombre = $nombre;
        $this->profesor = $profesor;
        parent::__construct("modificar_asignatura",array());
    }
    protected function generaCamposFormulario($datosIniciales){
		
        /*return '<p><div class = "inicioAdmin">
							
									/*Nombre: <br/><br/><input type="text" id="name" name="nombre" value ="'.$this->nombre.'" autofocus  />
									<br/><br/> // 
									Id profesor: <br/><br/><input type="text" name="profesor" value ="'.$this->profesor.'" autofocus />
									<br/><br/>// 
									<input type="hidden" name="original" value="'.$this->nombre.'">
									<br/>
									<button type ="submit" id = "modf" > actualizar </button>
									<button type="button" onclick = "location.href=\'menuCliente.php\'"> volver </button>	
									</div></p>';*/
									
									
		
		$rs = Admin::listaProfesores(); 
		if ($rs->num_rows > 0) {
				
				$cont = '		    <div class = "inicioAdmin"> 
										Nombre: <br/><br/><input type="text" id="name" name="nombre" value ="'.$this->nombre.'" autofocus  /><br/><br/>
									</div>
				
									<div class = "inicioAdmin">
										Id profesor : <br/><br/>	
											<select name="profesor" size="4">  ';
													while($fila = $rs->fetch_assoc()) {
															$cont .="<option>".$fila['nick']."</option>";
													}
										
				$cont .= '		            </select><br/>
									</div>
									<input type="hidden" name="original" value="'.$this->nombre.'"><br/>
									<div class = "inicioAdmin">		
										<button type ="submit" id = "modf" >actualizar </button> 
												<button type="button" onclick = "location.href=\'menuCliente.php\'"> volver </button>
										</div>';
																   
				$rs->free();						
					return $cont ;
		} else {
				echo "No hay ningun profesor declarado";
					exit();
		}
									
    }
	
	public function getNombre(){
		return $this->nombre ; 
	}
	
    protected function procesaFormulario($datos){
		
        $erroresFormulario = array();
        
        $nom= isset($datos['nombre']) ? $datos['nombre'] : null;
        
        if ( empty($nom) || mb_strlen($nom) < 5 ) {
            $erroresFormulario[] = "El nombre de la asignatura no puede tener menos de 5 carácteres";
        }
	
        if (count($erroresFormulario) === 0) {
			
			// los datos de datos['nombre'] contendra el nuevo nombre , pero necesitamos el id antiguo o su antiguo nombre para actualizar
            $admin= new Admin();
			$admin->actualizarAsig($datos['original'], $nom , $datos['profesor']); 
			
			echo "Se ha actualizado correctamente" ; 
			
			header('Location: menuCliente.php');
                exit();
        }
		
        return $erroresFormulario;
    }
    
 }