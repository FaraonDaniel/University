<?php
class Usuario
{
    public static function login($nombreUsuario, $password)
    {
        $user = self::buscaUsuarioLogin($nombreUsuario);
        if ($user && $user->compruebaPassword($password)) {
            return $user;
        }
        return false;
    }

    public static function buscaUsuario($nombreUsuario, $correoUser)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.nick = '%s' OR U.correo= '%s'", $conn->real_escape_string($nombreUsuario), $conn->real_escape_string($correoUser));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['nick'], $fila['nombre'], $fila['pwd'], $fila['rol'], $fila['correo']);
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

    public static function buscaUsuarioLogin($nombreUsuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.nick = '%s' OR U.correo = '%s' ", $conn->real_escape_string($nombreUsuario), $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['nick'], $fila['nombre'], $fila['pwd'], $fila['rol'], $fila['correo']);
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
    
    public static function crea($nombreUsuario, $nombre, $password, $rol, $correoUser)
    {
        $user = self::buscaUsuario($nombreUsuario, $correoUser);
        if ($user) {
            return false;
        }
        $user = new Usuario($nombreUsuario, $nombre, self::hashPassword($password), $rol, $correoUser);
        return self::guarda($user);
    }
    
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
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
        $query=sprintf("INSERT INTO usuarios(nick, nombre, pwd, rol, correo) VALUES('%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->nick)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->pwd)
            , $conn->real_escape_string($usuario->rol)
            , $conn->real_escape_string($usuario->correoUser));
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
    
    private static function actualiza($usuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE usuarios U SET nick = '%s', nombre='%s', pwd='%s', rol='%s', correo='%s' WHERE U.idUsuario=%i"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->rol)
            , $conn->real_escape_string($usuario->correoUser)
            , $usuario->id);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->id;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $usuario;
    } 

    public static function usuarioYpractica($idUser, $idPractica){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("SELECT * FROM practicas WHERE idPractica=$idPractica AND idAlumno=$idUser");
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        if($rs->num_rows > 0 || $fila['rol'] != "alumno"){
            return true;
        }
        else
            return false;
    }

    public function enunciadoDelUsuario(){
        
    }

    public function generaContenido()
    {
        return '';
    }

    private $id;

    private $nick;

    private $nombre;

    private $pwd;

    private $rol;

    private $correoUser;

    public function __construct($nombreUsuario, $nombre, $password, $rol, $correo)
    {
        $this->nick= $nombreUsuario;
        $this->nombre = $nombre;
        $this->pwd = $password;
        $this->rol = $rol;
        $this->correoUser = $correo;
    }

    public function id()
    {
        return $this->id;
    }

    public function rol()
    {
        return $this->rol;
    }

    public function nombreUsuario()
    {
        return $this->nick;
    }

    public function correoUsuario(){
        return $this->correoUser;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->pwd);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->pwd = self::hashPassword($nuevoPassword);
    }

    public static function getNameFromId($id){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.idUsuario =  $id"); 
        $rs = $conn->query($query) or die ("No se ha podido realizar la consulta");
        $data = $rs->fetch_assoc(); 
        return $data["nombre"]; 
    }

    public static function getIdFromName($name){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM `usuarios` u WHERE u.nick = '%s'", $name);
        $rs = $conn->query($query) or die ("No se ha podido realizar la consulta");
        $data = $rs->fetch_assoc(); 
        return $data["idUsuario"]; 
    }

    public static function getAlumnosFromAsig($idAsig){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT idAlumno FROM `alumnos_matriculados` am LEFT JOIN `matriculados` m ON am.idMatriculados = m.idMatriculados WHERE m.idAsignatura = $idAsig"); 
        $rs = $conn->query($query) or die ("No se ha podido realizar la consulta");
        return $rs; 
    }

    protected function pasarACorreccion($fechaComp){

        // Ahora hay que comprobar por cada enunciado
        $fecha_actual = date("Y-m-d",time());
       // echo "FECHA ACTUAL : " .$fecha_actual . " FECHA FIN PR : " .  $fechaComp; 
        //echo "ACTUAL : " .  date("Y-m-d",time()) . " La del enunciado " . $fechaComp ; 
        if($fecha_actual > $fechaComp){
            // CUANDO AL FECHA HA EXPIRADO Y SE CIERRA LA PRACTICA
            return false; 
        }
        else{
            return true; 
        }
    
    }

    protected function isRotada($idEnunciado){
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf(" SELECT * FROM `correccionalumno` c WHERE c.idEnunciado = $idEnunciado ");
        $rs = $conn->query($query) or die("No se ha podido ver si esta rotada o no...");

        // Esta rotada
        if ( $rs->num_rows > 0 ){
            return true; 
        } 
        return false; 
    }
}
