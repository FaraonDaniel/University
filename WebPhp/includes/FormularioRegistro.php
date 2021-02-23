<?php
class FormularioRegistro extends Form {
    function __construct() {
        parent::__construct("pregistro",array());
    }
    protected function generaCamposFormulario($datosIniciales){
        return '<fieldset class="form-group">
        <legend>Registro</legend>
        
        <div class="grupo-control">
            <input class="control" type="text" name="nombre" id="campoUser" placeholder="Nombre completo"required/><span id="userOK"></span>
        </div>
        <div class="grupo-control">
           <input class="control" type="text" name="nick" id="nickUser" placeholder="Nick"required/><span id="nickOK"></span>
        </div>
        <div class="grupo-control">
            <input class="control" type="text" name="correo" id="email" placeholder="Email" required/><span id="correoOK"></span>
        </div>

        <div>
        <div class="grupo-control">
        <label>Rol:</label>
         <select class ="control" name="rol" id="rol" required>
            <option value="">Elige un rol </option>
            <option value ="alumno">Alumno</option>
            <option value ="profesor">Profesor</option>
            <option value ="admin">Admin</option>
        </select>
        </div>
       
           
        </select>


        <div class="grupo-control"><input class="control" type="password" name ="pwd" id="pwd" placeholder="Password"required/><span id="pwdOK"></span></div>
        <div class="grupo-control"><input class="control" type="password" name="password2" placeholder="Vuelva a introducirla" id="pwd2" required/> <span id="pwd2OK"></span></div>
        <div class="grupo-control"><button class="btn btn-default" type="submit" name="registro">Registrar</button></div>
    </fieldset>';
    }
    protected function procesaFormulario($datos){
        if (! isset($_POST['registro']) ) {
            header('Location: registro.php');
            exit();
        }
        $erroresFormulario = array();
        
        if(isset($_POST['nick']) ? $_POST['nick'] : null){
            $nombreUsuario = htmlspecialchars($_POST['nick']);
        }
        if ( empty($nombreUsuario) || mb_strlen($nombreUsuario) < 5 ) {
            $erroresFormulario[] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        if(isset($_POST['nombre']) ? $_POST['nombre'] : null){
            $nombre =  htmlspecialchars($_POST['nombre']);
        }
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
            $erroresFormulario[] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }

       if(isset($_POST['correo']) ? $_POST['correo'] : null){
            $correoUser = $_POST['correo'];
       }
        if( empty($correoUser) || mb_strlen($correoUser) < 7){
            $erroresFormulario[] = "El correo debe ser más largo.";
        }

        $rol = isset($_POST['rol']) ? $_POST['rol'] : null;

        if ( empty($rol) ||(strcmp($rol, 'profesor') != 0) && (strcmp($rol, 'alumno' ) != 0) && (strcmp($rol, 'admin' ) != 0) ) {
            $erroresFormulario[] = "No se ha introducido ningun rol.";
        }
        
        $password = isset($_POST['pwd']) ? $_POST['pwd'] : null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $erroresFormulario[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $erroresFormulario[] = "Los passwords deben coincidir";
        }
        
        if (count($erroresFormulario) === 0) {
            $usuario = Usuario::crea($nombreUsuario, $nombre, $password, $rol, $correoUser);
            
            if (! $usuario ) {
                $erroresFormulario[] = "El usuario ya existe";
            } else {
                $_SESSION['login'] = true;
                $_SESSION['nick'] = $nombreUsuario;
                $_SESSION['correo'] = $correoUser;
                $_SESSION['pwd']=$password;
                $_SESSION['nombre']=$usuario->nombreUsuario();
                $_SESSION['id']=$usuario->id();
                $_SESSION['esAdmin'] = strcmp($usuario->rol(), 'admin') == 0 ? true : false;
                $_SESSION['esProfe'] = strcmp($usuario->rol(), 'profesor') == 0 ? true : false;
                header('Location: menuCliente.php');
                exit();
        
            }
        }
        return $erroresFormulario;
    }
 }