<?php
class Tema{

    private $nombreTema;
    private $idTema;
    private $idAsignatura;

    private function __construct($nombreTema, $idAsignatura){
        $this->nombreTema= $nombreTema;
        $this->idAsignatura = $idAsignatura;
    }


    public static function crea($nombreTema, $idAsignatura){
        $nombreTema = $_POST['nombreTema'];
        $user = self::buscarTema($nombreTema, $idAsignatura);
        if ($user) {
            return false;
        }
       else{
            $tema = new Tema($nombreTema, $idAsignatura);
            return self::guarda($tema);
        }
        return false;
    }

    public static function guarda($tema){
        if ($tema->idTema !== null) {
            return self::actualiza($tema);
        }
        return self::inserta($tema);
    }

    public static function buscarTema($nombreTema, $idAsignatura){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $id = $_SESSION['id'];
        $query = sprintf("SELECT t.idTema, t.nombre, t.idAsignatura FROM tema t, asignatura a WHERE t.idAsignatura=$idAsignatura AND a.idProfesor= $id");
        $rs = $conn->query($query);
        $result = false;
        if($rs){    
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $tema = new Tema($fila['nombre'], $fila['idAsignatura']);
                $tema->id = $fila['idTema'];
                $result = $tema;
            }
            $rs->free();
        } 
        else {
            echo "1.Error al consultar el tema en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
   
    public function buscarNombreTema($nombreTema, $idAsignatura){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT nombre FROM tema WHERE idAsignatura = $idAsignatura AND nombre= '%s'", $conn->real_escape_string($nombreTema));
        $rs = $conn->query($query);
        if($rs) {
            if($rs->num_rows > 0){
                return true;
            }
            else{
                return false;
            }
        }        
    }


    private static function inserta($tema)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO tema(nombre, idAsignatura) VALUES('%s', '%s')"
            , $conn->real_escape_string($tema->nombreTema)
            , $conn->real_escape_string($tema->idAsignatura));
        echo "$conn->query($query)";
        
        if ( $conn->query($query) ) {
            $tema->id = $conn->insert_id;
        } else {
        
            echo "2.Error al insertar tema en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $tema;
    }
    

    private static function actualiza($tema)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE tema t SET nombre = '%s', idAsignatura='%s' WHERE t.idTema=%i"
            , $conn->real_escape_string($tema->nombre)
            , $conn->real_escape_string($tema->idAsignatura)
            , $tema->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el tema: " . $tema->id;
                exit();
            }
        } else {
            echo "3.Error al insertar el tema en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $tema;
    } 

    public static function borrar($idTema, $idAsignatura){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $id = $_SESSION['id'];
        echo "$idTema";
        echo "$idAsignatura";
        $query=sprintf("DELETE FROM tema WHERE idTema = $idTema AND idAsignatura = $idAsignatura");
        if ( $conn->query($query) ) {
            return true;
        } 
        else {
            echo "2.Error al borrar practica en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return false;
    }
	
	public static function borrarTemasUnaAsignatura($idAsignatura){
		$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
			$idAdmin = $_SESSION['id'];
			
		$query = sprintf("  SELECT * FROM tema t WHERE t.idAsignatura = %d", $idAsignatura );
        if ($rs = $conn->query($query)){
			
			while($fila = $rs->fetch_assoc()) {
					// borra los temas de una asignatura
					$this->borrar($fila['idtema'], $idAsignatura); 
					// borra las practicas de cada tema
					Practica::borrarPracticasUnTema($fila['idtema']) ; 
					// Borra los enunciados de cada tema
					Enunciado::borrarEnunciadosUnTema($fila['idtema']);
			}
		}
		else {
			echo "Error al realizar la consulta del borrado de asignatura"; 
			exit(); 
		}
		
		
        
	}
	
    public function generaContenido()
    {
        return '';
    }

  
    public function id()
    {
        return $this->idTema;
    }

    public function nombrePractica()
    {
        return $this->nombreTema;
    }

    public function idAsignatura(){
        return $this->idAsignatura;
    }





}



