<?php
class Enunciado
{
    private $idTema;
    private $nombre;
    private $fechaIni;
    private $fechaFin;
    private $idEnunciado;

    public function __construct($idTema, $nombre,$fechaIni, $fechaFin)
    {   
        $this->idTema=$idTema;
        $this->nombre=$nombre;
        $this->fechaIni=$fechaIni;
        $this->fechaFin=$fechaFin;
    }

    public static function creaEnunciado($idTema,$nombreEnunciado, $fechaIni,$fechaFin){
        $enunciado = self::buscaEnunciado($nombreEnunciado);
        if ($enunciado) {
            return false;
        }
        $enunciado = new Enunciado($idTema,$nombreEnunciado, $fechaIni,$fechaFin);
        return self::guarda($enunciado);

    }
    public static function buscaEnunciado($nombreEnunciado)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        
        $query = sprintf("SELECT * FROM enunciado e,tema t WHERE e.nombre = '%s' AND e.idTema=".$_SESSION['idTema']." AND t.idTema=e.idTema", $conn->real_escape_string($nombreEnunciado));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $enunciado = new Enunciado($fila['idTema'], $fila['nombre'],$fila['FechaInicio'], $fila['FechaFin']);
                $enunciado->id =  $fila['idEnunciado'];
                $result=$enunciado;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
    
    public static function buscaEnunciadoExistente($nombreEnun){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $repl="_";
        $serc=" ";
        $nombreEnunciado = str_replace ($serc,$repl,$nombreEnun);
        $query = sprintf("SELECT * FROM enunciado e,tema t WHERE e.nombre = '%s' AND e.idTema=".$_SESSION['idTema']." AND t.idTema=e.idTema", $conn->real_escape_string($nombreEnunciado));
        $rs = $conn->query($query);
        $result = false;
        if($rs) {
            if($rs->num_rows > 0){
                return true;
            }
            else{
                return false;
            }
        } 
    }

    public static function guarda($enunciado)
    {
        if ($enunciado->idEnunciado !== null) {
            return self::actualiza($enunciado);
        }
        return self::inserta($enunciado);
    }
    
    private static function inserta($enunciado)
    {   
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO enunciado(idTema,nombre,FechaInicio,FechaFin,entregaFinalizada) VALUES($enunciado->idTema, '%s','%s','%s',false)"
        ,$conn->real_escape_string($enunciado->nombre)
        ,$enunciado->fechaIni
        ,$enunciado->fechaFin
        );
        if ( $conn->query($query) ) {
            $enunciado->idEnunciado = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $enunciado;
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
	
	public static function borrarEnunciadosUnTema($idTema){
		
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        // Borra los enunciados asociados a un tema 
			$query=sprintf("DELETE FROM enunciado WHERE idTema = $idTema");
			if ( $conn->query($query) ) {
				 echo "Se han borrado correctamente los enunciados asociados a un tema "; 
			} 
			else {
				echo "2.Error al borrar practica en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
				exit();
			}
    }

    public static function borrar($idEnunciado, $idTema, $nombreEnunciado){

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $id = $_SESSION['id'];

        $query=sprintf("DELETE FROM enunciado WHERE idEnunciado = $idEnunciado AND idTema = $idTema");
        if ( $conn->query($query) ) {
            $dirPath='./uploads/enunciados/'.$_GET["idEnunciado"].'/';
            self::deleteDir($dirPath);
            return true;
        } 
        else {
            echo "2.Error al borrar practica en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return false;
    }




    public function getId(){
        return $this->idEnunciado;
    }
    public function getNombre(){
        return $this->nombre;
    }

    public static function getElementsByIdEnunciado($idEnunciado){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $upd = sprintf("SELECT * FROM `practicas` p 
                    LEFT JOIN `enunciado` e ON p.idEnunciado = e.idEnunciado 
                    WHERE p.idEnunciado = '%d' ", $idEnunciado); 

        $resultado=$conn->query($upd) or die("No se ha podido realizar la consulta de los alumnos a una practica");
        return $resultado ; 
    }

    public static function getElementsByIdEnunciadoAndUser($idEnunciado,$idAlumno){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $upd = sprintf("SELECT * FROM `practicas` p 
                    LEFT JOIN `enunciado` e ON p.idEnunciado = e.idEnunciado 
                    WHERE p.idEnunciado = $idEnunciado and p.idAlumno = $idAlumno "); 

        $resultado=$conn->query($upd) or die("No se ha podido realizar la consulta de los alumnos a una practica");
        return $resultado ; 
    }
			
			
    public static function rotarAlumnosPractica($idEnunciado){
        
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $upd = sprintf("SELECT idAlumno FROM `practicas` p LEFT JOIN `enunciado` e ON p.idEnunciado = e.idEnunciado WHERE p.idEnunciado = '%d' ", $idEnunciado); 
        if(!$upd){
            echo "no encuentra practicas";
        }
        // He seleccionado todos los alumnos que han subido una practica a un enunciado
        $resultado=$conn->query($upd) or die("No se ha podido realizar la consulta de los alumnos a una practica");
        $i=0; $lista = NULL; 
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
        //print_r($lista);
        if ($lista != NULL){
            
        // En $lista tenemos la lista de alumnos que han subido una practica a un enunciado, la barajamos:
    
            shuffle($lista);
            
            //print_r($lista);
            // mostramos las parejas ... e introducimos en correcionAlumno tabla
            
            if ( count($lista) == 1) {
                // Aqui falta algo de javascript
            }
            else {
                for ( $j = 0; $j < count($lista); $j++){
                    $aux = Self::buscaPracticaFromId($lista[($j + 1) % count($lista)], $idEnunciado); 
                    $query = sprintf("INSERT INTO `correccionalumno`(`idCorreccionAlumno`, `idPractica`, `idAlumnoCorrector`, `Comentario`, `Nota`,`idEnunciado`) VALUES ('%d','%d','%d','%s','%d','%d')",
                        NULL,$aux["idPractica"],$lista[$j],NULL,NULL,$idEnunciado ); //TODO idPractica // si idPractica no existe, da fallo 
                        
                    $conn->query($query) or die("No se ha podido barajar"); 
                           
                }
            }
        
        }
        else { 
                echo "<div class='crearPracticas'>";
                                echo "<icon class='fas fa-exclamation' style = 'color: #FF0000;'>No se ha añadido entrega</icon>";
                echo "</div>";
        }
        
        

    }

    public static function rotarProfesorPractica($idEnunciado){
        
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $upd = sprintf("SELECT idAlumno FROM `practicas` p LEFT JOIN `enunciado` e ON p.idEnunciado = e.idEnunciado WHERE p.idEnunciado = '%d' ", $idEnunciado); 
        if(!$upd){
            echo "no encuentra practicas";
        }
        // He seleccionado todos los alumnos que han subido una practica a un enunciado
        $resultado=$conn->query($upd) or die("No se ha podido realizar la consulta de los alumnos a una practica");
        $i=0; $lista = NULL; 
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
        //print_r($lista);
        if ($lista != NULL){
            
        // En $lista tenemos la lista de alumnos que han subido una practica a un enunciado, la barajamos:
    
            shuffle($lista);
            
            //print_r($lista);
            // mostramos las parejas ... e introducimos en correcionAlumno tabla
            
            if ( count($lista) == 1) {
                // Aqui falta algo de javascript
            }
            else {
                for ( $j = 0; $j < count($lista); $j++){
                    $aux = Self::buscaPracticaFromId($lista[($j + 1) % count($lista)], $idEnunciado); 
                    $query = sprintf("INSERT INTO `correccionalumno`(`idCorreccionAlumno`, `idPractica`, `idAlumnoCorrector`, `Comentario`, `Nota`,`idEnunciado`) VALUES ('%d','%d','%d','%s','%d','%d')",
                        NULL,$aux["idPractica"],$lista[$j],NULL,NULL,$idEnunciado ); //TODO idPractica // si idPractica no existe, da fallo 
                        
                    $conn->query($query) or die("No se ha podido barajar"); 
                           
                }
            }
        
        }
    }
            
    public static function buscaPracticaFromId($idAlumno, $idEnunciado){

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $upd = sprintf("SELECT idPractica FROM `practicas` p LEFT JOIN `enunciado` e ON p.idEnunciado = e.idEnunciado WHERE p.idEnunciado = '%d' and p.idAlumno = '%d' ",
                $idEnunciado, $idAlumno);
        
        $resultado=$conn->query($upd) or die("No se ha podido realizar la consulta "); 
        return $resultado->fetch_assoc(); 

    }

    public static function getIdAsigFromIdEnunciado($idEnunciado){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();


        $upd = sprintf("SELECT idAsignatura FROM `tema` t LEFT JOIN `enunciado` e ON t.idTema = e.idTema WHERE e.idEnunciado = $idEnunciado ");
        
        $resultado=$conn->query($upd) or die("No se ha podido realizar la consulta "); 
        $data =  $resultado->fetch_assoc(); 
        return $data["idAsignatura"]; 
    }

    public function enunciadoProfesor($idTema, $idEnunciado){
        
    }
		
 }
