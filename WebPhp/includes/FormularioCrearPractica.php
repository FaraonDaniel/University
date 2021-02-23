<?php
class FormularioCrearPractica extends Form {
    private $idEnunciado;
    private $idTema;
    function __construct($enunciado, $tema) {
        $this->idEnunciado = $enunciado;
        $this->idTema = $tema;
        parent::__construct("pcrearPractica",array('enctype'=>'multipart/form-data'));
    }
    protected function generaCamposFormulario($datosIniciales){
        return '<fieldset>
        <legend>Entrega practica</legend>
        <div class="grupo-control">
            <label>Nombre:</label> <input type="text" name="nombrePractica" />
        </div>
        <div class="grupo-control">
            <label>Selecciona archivo: </label> <input type="file" name="ruta" />
        </div>
        <div class="grupo-control"><button type="submit" name="crearPractica">Entregar</button></div>
    </fieldset>';
    }
    protected function procesaFormulario($datos){
        if (! isset($datos['crearPractica']) ) {
            header('Location: menuCliente.php');
            exit();
        }
        $erroresFormulario = array();

        if (!isset($_FILES['ruta']['error']) || is_array($_FILES['ruta']['error'])) {
            $erroresFormulario[] = "Error en la ruta.";
        }

        switch ($_FILES['ruta']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                $erroresFormulario[]="Archivo vacío.";
                break;
            case UPLOAD_ERR_INI_SIZE:
                $erroresFormulario[]="Archivo de ini erroneo";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $erroresFormulario[]="Tamaño de archivo erroneo";
                break;
            default:
                $erroresFormulario[]="ERROR RARUNO";
                break;
        }

        if ($_FILES['ruta']['size'] > 100000000) {
            $erroresFormulario[]="ERROR ARCHIVO DEMASIADO GRANDE";
        }
        // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
        // Check MIME Type by yourself.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
            $finfo->file($_FILES['ruta']['tmp_name']),
            array(
                'c'=>'text/x-c',
                'cpp'=>'text/x-c',
                'java'=>'text/x-java-source',
                'css'=>'text/css',
                'html'=> 'text/html',
                'js' => 'application/javascript',
                'pdf'=>'application/pdf'
            ),
            true
        )) {
            $erroresFormulario[]="Formato invalido";
        }

        $repl="_";
        $serc=" ";
        $nombrePrac = isset($datos['nombrePractica']) ? $datos['nombrePractica'] : null;
        $nombrePractica= str_replace ($serc,$repl,$nombrePrac);

        $dirAct=getcwd();
        $dirAct.='/uploads/practicas';

        if ( empty($nombrePractica) || mb_strlen($nombrePractica) < 5 ) {
            $erroresFormulario[] = "El nombre de la practica no puede ser menor de 5 caracteres";
        }
        else{   
            if(!file_exists($dirAct)){
                
                if(!mkdir($dirAct,0777,true)) {
                    
                    $erroresFormulario[] = "Error al crear dir";

                }
            }
        }
        if (count($erroresFormulario) === 0) {
            $nombre = $nombrePractica;
            
            $nombre .= "." .$ext;
            $practica = Practica::crea($nombre, $_SESSION['id'], $this->idTema, $this->idEnunciado);
            if (!$practica) {
                $erroresFormulario[] = "";
            }
            else {
                if(!mkdir($dirAct.'/'.$practica->idPractica(),0777, true)){
                     echo "error al crear directorio \n";
                     echo sprintf($dirAct.'/'.$practica->idPractica());
                }
                if (!move_uploaded_file($_FILES['ruta']['tmp_name'], sprintf('%s/%s/%s',$dirAct, $practica->idPractica(),$practica->nombrePractica()) )) 
                {
                   throw new RuntimeException('Failed to move uploaded file.');
                }
                header('Location: menuCliente.php');
                exit();
            }   
        }
        return $erroresFormulario;
    }
    
 }