<?php
	class CorreccionAlumno {
		
    public static function buscaCorrecionAlumno($idEnunciado,$idAlumno){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM correccionalumno P WHERE P.idAlumnoCorrector = $idAlumno AND P.idEnunciado = $idEnunciado");
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
				$fila = $rs->fetch_assoc();
                $pract = new CorreccionAlumno($fila['Nota'], $fila['idAlumnoCorrector'],$fila['Comentario'], $fila['idPractica'], $fila['idEnunciado']);
                $pract->idCorreccionAlumno = $fila['idCorreccionAlumno'];
                $result = $pract;
            }
            $rs->free();
        } 
        else {
            echo "1.Error al consultar la correcion de alumno en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function crea($nota, $idAlumnoCorrector, $comentario, $idPractica, $idEnunciado)
    {
        $user = self::buscaCorrecionAlumno($idEnunciado, $idAlumnoCorrector);
        if ($user) {
            return false;
        }
        if($idAlumnoCorrector==$_SESSION['id']){
            $correcion = new CorreccionAlumno($nota, $idAlumnoCorrector, $comentario, $idPractica, $idEnunciado);
            return self::guarda($correcion);
        }
        return false;
    }
    
    public static function guarda($correccion)
    {
        if ($correccion->idCorrecionAlumno !== null) {
            return self::actualiza($correccion);
        }
        return self::inserta($correccion);
    }
    
    private static function inserta($correccion)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO correccionalumno(idPractica, idAlumnoCorrector, Comentario, Nota, idEnunciado) VALUES($correccion->idPractica, $correccion->idAlumnoCorreccion, '%s', $correccion->nota, $correccion->idEnunciado)"
            , $conn->real_escape_string($correccion->comentario));
	   
		if ( $conn->query($query) ) {
            $correccion->idPractica = $conn->insert_id;
        } else {
            echo "2.Error al insertar practica en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $correccion;
    }
    
    private static function actualiza($correccion)
    {
        $app = Aplicacion::getSingleton();
		$conn = $app->conexionBd();
        $query=sprintf("UPDATE correccionalumno U SET idPractica = $correccion->idPractica, idAlumnoCorreccion=$correccion->idAlumnoCorrector, Comentario='%s', Nota=$correccion->nota, $correccion->idEnunciado WHERE U.id=%idCorrecionAlumno"
        , $conn->real_escape_string($correccion->comentario)
        , $correccion->idCorreccionAlumno);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la correccion: " . $correccion->idCorreccionAlumno;
                exit();
            }
        } else {
            echo "3.Error al insertar la practica en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $correccion;
    } 
    public static function borrar($idCorreccionAlumno, $idPractica)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $idAlumno = $_SESSION['id'];
        $query=sprintf("DELETE FROM correccionalumno WHERE idPractica = $idPractica AND idCorreccionAlumno = $idCorreccionAlumno");
        if ( $conn->query($query) ) {
            $dirPath='./uploads/practicasCorreccion/'.$_GET["idCorrecionAlumno"].'/';
            self::deleteDir($dirPath);
            return true;
        } 
        else {
            echo "2.Error al borrar practica en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return false;
    }
	
    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        /*if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }*/
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    public static function buscaNombrePractica($idCorreccionAlumno)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $id = $_SESSION['id'];
        $query = sprintf("SELECT P.nombre FROM correccionalumno C, practicas P WHERE C.idAlumnoCorrector = $id AND C.idCorreccionAlumno = $idCorreccionAlumno AND C.idPractica = P.idPractica");
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
				$fila = $rs->fetch_assoc();
                $pract = $fila['nombre'];
                $result = $pract;
            }
            $rs->free();
        } 
        else {
            echo "10.Error al consultar el nombre de la practica en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
  
  
    public function generaContenido(){
        return '';
    }
    
    private $nota;
    private $idAlumnoCorrector;
    private $comentario;
    private $idPractica;
	private $idCorreccionAlumno;
	
	private $idEnunciado;
    private function __construct($nota, $idAlumnoCorrector, $comentario, $idPractica, $idEnunciado)
    {
        $this->nota= $nota;
        $this->idAlumnoCorrector = $idAlumnoCorrector;
        $this->comentario=$comentario;
		$this->idPractica = $idPractica;
		$this->idEnunciado=$idEnunciado;
    }
    public function nota()
    {
        return $this->nota;
    }
    public function idAlumnoCorrector()
    {
        return $this->idAlumnoCorrector;
    }
    public function comentario()
    {
        return $this->comentario;
    }
    public function idPractica(){
        return $this->idPractica;
    }
    public function idCorreccionAlumno(){
        return $this->idCorreccionAlumno;
	}
	public function idEnunciado(){
        return $this->idEnunciado;
    }
	
    
    // LA BUENA
    public static function rotarAlumnosPractica($idEnunciado, $conn){
        
        $app = Aplicacion::getSingleton();
        //$conn = $app->conexionBd();

        $upd = sprintf("SELECT idAlumno FROM `practicas` p LEFT JOIN `enunciado` e ON p.idEnunciado = e.idEnunciado WHERE p.idEnunciado = '%d' ", $idEnunciado); 
        
        // He seleccionado todos los alumnos que han subido una practica a un enunciado
        $resultado=$conn->query($upd) or die("No se ha podido realizar la consulta de los alumnos a una practica");
        $i=0;
            // TODO COMPROBAR CUANDO LA TABLA ESTA VACIA
        while ($array=$resultado->fetch_array()){
            //Obtengo las claves del arreglo que en tu caso son los atributos de la tabla (id, nombre, etc)
            $claves = array_keys($array);
            //Recorro el arreglo de las claves para ir asignando los datos al arreglo con los nombres de los atributos
            foreach($claves as $clave){
                $lista[$i] = $array[$clave];
            }           
            $i++;
        }
        
        // En $lista tenemos la lista de alumnos que han subido una practica a un enunciado, la barajamos:
    
        shuffle($lista);
        
        // mostramos las parejas ... e introducimos en correcionAlumno tabla
        
        if ( count($lista) == 1) {
            
        }
        else {
            // Hay que conseguir la practica 
            for ( $j = 0; $j < count($lista); $j++){
                echo $lista[$j] . " con " . $lista[($j + 1) % count($lista)] . "<br/>"; 
                //"INSERT INTO tema(nombre, idAsignatura) VALUES('%s', '%s')"
                $query = sprintf("INSERT INTO `correccionalumno`(`idCorreccionAlumno`, `idPractica`, `idAlumnoCorrector`, `Comentario`, `Nota`, `idEnunciado`) VALUES ('%d','%d','%d','%s','%i', $idEnunciado)",
                    NULL,7,$lista[$j],NULL,00.00 ); //TODO idPractica // si idPractica no existe, da fallo 
                    if($conn->query($query)){
                        echo "barajados";
                    }
                    $listaPractica::buscaPractica($idTema, $idEnunciado);
                    // ese 7 sera la practica de $lista[($j + 1) % count($lista)]
                    // A partir de idEnunciado -> idPractica del usuario de arriba mod 
                    // El idCorrector soy yo, y al que voy a corregir es el idCorreccionAlumno
                
            }
        }
        
        
    }
    public static function dameAlumnoQueCorrige($idPractica){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $upd = sprintf("SELECT idAlumnoCorrector FROM `correccionalumno` c  WHERE c.idPractica = $idPractica"); 
        
        // He seleccionado todos los alumnos que han subido una practica a un enunciado
        $resultado=$conn->query($upd) or die("No se ha podido realizar la consulta de los alumnos a una practica");
        $resultado = $resultado->fetch_assoc(); 
        return $resultado["idAlumnoCorrector"]; 
        }

        public static function subirComentario($idPractica,$cont){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        
        $query = sprintf(" UPDATE `correccionalumno` c
                                SET `Comentario`= '%s'
                                WHERE c.idPractica = $idPractica",$cont);
        $rs = $conn->query($query) or die (" No se ha podido introducir el comentario de correccion ....") ; 
        }

        public static function getComentario($idPractica){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT  `Comentario` FROM `correccionalumno` c WHERE c.idPractica = $idPractica"); 
        $rs = $conn->query($query) or die (" No se ha podido introducir el comentario de correccion ....") ; 
        $rs = $rs->fetch_assoc(); 
        return $rs["Comentario"]; 
        }

        public static function verCorreccion($idPractica){
        $html='';
        $text=CorreccionAlumno::getComentario($idPractica);
        $html.= '
                    <textarea name="codesnippet_editable" id="codesnippet_editable">
                        '.$text.'
                    </textarea>    
                    <div class = "botonesCorregir">
                        <div> 
                            <button id="submitCorreccion" value= '.$idPractica.' href="subirComentario.php" class="btn btn-success">Guardar corrección</button>
                        </div>
                    </div>';
        echo $html;
        }

	}