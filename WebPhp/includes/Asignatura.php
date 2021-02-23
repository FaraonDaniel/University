<?php
class Asignatura
{
    private $asignatura;
    private $tema;

    public function __construct($asignatura,$tema)
    {
        $this->$asignatura=$asignatura;
        $this->$tema=$tema;
    }

    public function creaEnunciado($nombreEnunciado){
        $user = self::buscaEnunciado($nombreEnunciado);
        if ($user) {
            return false;
        }
        $user = new Usuario($nombreUsuario, $nombre, self::hashPassword($password), $rol);
        return self::guarda($user);
       /* $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        echo "<script>console.log('lo enchufo');</script>";
        $query=sprintf("INSERT INTO enunciado(idTema,nombre,FechaInicio,FechaFin) VALUES($this->$tema, '%s','%s','%s')"
        , $conn->real_escape_string($this->$tema)
        , $conn->real_escape_string($datos['nombreEnunciado'])
        , $conn->real_escape_string($datos['fechaInicio'])
        , $conn->real_escape_string($datos['fechaFin'])
        );
        if ( $conn->query($query) ) {
            echo "<script>console.log('lo enchufo');</script>";
            return  $conn->insert_id;
        }
        return false;*/

    }
    public static function buscaEnunciado($nombreEnunciado)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM enunciado e,tema t WHERE e.nombre = '%s' AND e.idTema=".$_SESSION['idTema']."AND t.idTema=e.idTema", $conn->real_escape_string($nombreEnunciado));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $asignatura = new Asignatura($fila['idAsignatura'], $fila['idTema']);
                $asignatura = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $asignatura;
    }
    public static function login($nombreUsuario, $password)
    {
        $user = self::buscaUsuario($nombreUsuario);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.nick = '%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['nick'], $fila['nombre'], $fila['pwd'], $fila['rol']);
                $user->id = $fila['idUsuario'];
                $result = $user;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
    
    public static function crea($nombreUsuario, $nombre, $password, $rol)
    {
        $user = self::buscaUsuario($nombreUsuario);
        if ($user) {
            return false;
        }
        $user = new Usuario($nombreUsuario, $nombre, self::hashPassword($password), $rol);
        return self::guarda($user);
    }
    
    public static function guarda($usuario)
    {
        if ($usuario->id !== null) {
            return self::actualiza($usuario);
        }
        return self::inserta($usuario);
    }
    
    private static function inserta($usuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $tablaAdmin=0;
        $tablaAlumno=0;
        $tablaProfesor=0;
        if($usuario->rol()=='alumno'){
            $tablaAlumno=1;
        }else if($usuario->rol()=='profesor'){
            $tablaProfesor=1;
        }else if($usuario->rol()=='admin'){
            $tablaAdmin=1;
        }
        $query=sprintf("INSERT INTO Usuarios(nick, nombre, pwd, rol,tablaAdmin,tablaAlumno,tablaProfesor) VALUES('%s', '%s', '%s', '%s',$tablaAdmin,$tablaAlumno,$tablaProfesor)"
            , $conn->real_escape_string($usuario->nick)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->pwd)
            , $conn->real_escape_string($usuario->rol));
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        if($usuario->rol()=='alumno'){
            $query=sprintf("INSERT INTO alumnos(idAlumno) VALUES($usuario->id)");
            $conn->query($query);
        }else if($usuario->rol()=='profesor'){
            $query=sprintf("INSERT INTO profesor(idProfesor) VALUES($usuario->id)");
            $conn->query($query);
        }else if($usuario->rol()=='admin'){
            $query=sprintf("INSERT INTO admin(idAdmin) VALUES($usuario->id)");
            $conn->query($query);
        }

        return $usuario;
    }

    public static function listaAsignaturas(){ // TODO a.idAsignatura
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("  SELECT  * FROM asignatura a ");
        $rs = $conn->query($query);
        return $rs;
    }
     
}
