<?php
class FormularioCrearTema extends Form {

    private $idAsignatura;
    function __construct($asignatura) {
        $this->idAsignatura = $asignatura;
        parent::__construct("crearTema",array());
    }

    protected function generaCamposFormulario($datosIniciales){
        return '<fieldset>
        <legend>Datos del tema</legend>
        <div class="grupo-control">
            <label>Nombre:</label> <input type="text" name="nombreTema" id="addTema" required/><span id="addTemaOK"> </span>
        </div>
        <div class="grupo-control"><button type="submit" name="crearTema">Crear Tema</button></div>
    </fieldset>';
    }
    protected function procesaFormulario($datos){
        if (! isset($datos['crearTema']) ) {
            header('Location: menuCliente.php');
            exit();
        }
        $erroresFormulario = array();
        $nombreTema = isset($datos['nombreTema']) ? $datos['nombreTema'] : null;
        
        if ( empty($nombreTema) || mb_strlen($nombreTema) < 5 ) {
            $erroresFormulario[] = "El nombre de la practica no puede ser menor de 5 caracteres";
        }

        if (count($erroresFormulario) === 0) {
            $tema = tema::crea($nombreTema, $this->idAsignatura);
            if (!$tema) {
                $erroresFormulario[] = "";
            } 
            else {
                header('Location: menuCliente.php');
                exit();
            }   
        }
        return $erroresFormulario;
    }
    
 }