<?php
class FormularioAddEnunciado extends Form {
    private $tema;
    private $idAsignatura;
    function __construct($tema,$idAsignatura) {
        $this->tema=$tema;
        $this->idAsignatura=$idAsignatura;
        parent::__construct("pAddEnunciado",array('enctype'=>'multipart/form-data'));
    }
    protected function generaCamposFormulario($datosIniciales){
        return ' <h3> Añadir enunciado</h3>
                <fieldset class="form-group">
                    <div class="grupo-control">
                        <label>Nombre enunciado:</label><input type="text" name="nombreEnunciado" id="addEnunciado" placeholder="Nombre enunciado" required /><span id="enunciadoOK"></span>
                    </div>
                    <div class="grupo-control">
                          <label>Fecha inicio:</label> <input type="date" name="fechaInicio" id="fechaInicio" required/><span id="fechaIniOK"></span>
                    </div>
                    <div class="grupo-control">
                        <label>Fecha fin:</label> <input type="date" name="fechaFin" id="fechaFin" required/><span id="fechaFinOK"></span>
                    </div>
                    <div class="grupo-control">
                        <label>Selecciona enunciado: (pdf)</label> <input class="form-control-file" type="file" name="ruta" id="extFichero" required/><span id="extFicheroOK"> </span>
                    </div>
                    <div class="grupo-control">
                        <button type="submit" name="addEnunciado" ">Crear</button>
                    </div>
                </fieldset>
         ';
         
    }
    protected function procesaFormulario($datos){
        if (! isset($_POST['addEnunciado']) ) {
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
                'pdf'=>'application/pdf'
            ),
            true
        )) {
            $erroresFormulario[]="Formato invalido";
        }

        $repl="_";
        $serc=" ";
        $nombreEnun = isset($_POST['nombreEnunciado']) ? $_POST['nombreEnunciado'] : null;
        $nombreEnunciado= str_replace ($serc,$repl,$nombreEnun);
        
        if ( empty($nombreEnunciado) || mb_strlen($nombreEnunciado) < 5  || mb_strlen($nombreEnunciado) > 20) {
            $erroresFormulario[] = "El nombre de enunciado tiene que tener una longitud entre 5 y 12.";
        }
        
        $fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : null;
        $dateIni=$fechaInicio;
        $fechaInicio=explode("-", $fechaInicio);
        $fechaFin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : null;
        $dateFin=$fechaFin;
        $fechaFin = explode("-", $fechaFin);

        if ( empty($fechaInicio) || empty($fechaFin) || checkdate($fechaInicio[0],$fechaInicio[1],$fechaInicio[2])|| checkdate($fechaFin[0],$fechaFin[1],$fechaFin[2])) {
            $erroresFormulario[] = "Introduce la fecha bien";
        }

        if ( $dateIni>$dateFin) {
            $erroresFormulario[] = "Fecha inicio tiene que ser menor que fecha fin";
        }

        $dirAct=getcwd();
        $dirAct.='/uploads/enunciados';
        if(!file_exists($dirAct)){
            
            if(!mkdir($dirAct,0777,true)) {
               
                $erroresFormulario[] = "Error al crear dir";

            }
        }

        if (count($erroresFormulario) === 0) {
            $enunciado=Enunciado::creaEnunciado($this->tema,$nombreEnunciado, $dateIni,$dateFin);
            
            if (!$enunciado ) {
                $erroresFormulario[] = "Ya hay un enunciado con ese nombre, cambialo.";
            } else {
                mkdir($dirAct.'/'.$enunciado->getId(),0777,true);
                if (!move_uploaded_file($_FILES['ruta']['tmp_name'], sprintf('%s/%s/%s.%s',$dirAct, $enunciado->getId(),$enunciado->getNombre(),$ext ) )) 
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