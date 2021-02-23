<?php

class FormularioLogin extends Form {
    function __construct() {
        parent::__construct("plogin",array());
    }
    protected function generaCamposFormulario($datosIniciales){
       return '<fieldset class="form-group">
        <legend>Usuario y contraseña</legend>
        <div class="grupo-control">
            <input type="text" name="nick" id="userMail" placeholder="Email/Usuario"/>
        </div>
        <div class="grupo-control">
            <input type="password" name="password" id="pwdLogin" placeholder="Password" required/>
        </div>
        <div class="grupo-control"><button type="submit" name="login">Entrar</button></div>
    </fieldset>';
    
    }
    protected function procesaFormulario($datos){
        if (! isset($datos['login']) ) {
            header('Location: login.php');
            exit();
        }
        $erroresFormulario = array();
        
        if(isset($datos['nick']) ? $datos['nick'] : null){
            $nombreUsuario =  htmlspecialchars($datos['nick']);
        }
        if ( empty($nombreUsuario) ) {
            $erroresFormulario[] = "El nombre de usuario no puede estar vacío";
        }
        
        $password = isset($datos['password']) ? $datos['password'] : null;
        if ( empty($password) ) {
            $erroresFormulario[] = "El password no puede estar vacío.";
        }
        
        if (count($erroresFormulario) === 0) {
            $usuario = Usuario::buscaUsuarioLogin($nombreUsuario);
        
            if (!$usuario) {
                $erroresFormulario[] = "El usuario o el password no coinciden";
            } else {
                if ( $usuario->compruebaPassword($password) ) {
                    $_SESSION['login'] = true;
                    $_SESSION['nick'] = $nombreUsuario;
                    $_SESSION['pwd']=$password;
                    $_SESSION['nombre']=$usuario->nombreUsuario();
                    $_SESSION['id']=$usuario->id();
                    $_SESSION['esAdmin'] = strcmp($usuario->rol() , 'admin') == 0 ? true : false;
                    $_SESSION['esProfe'] = strcmp($usuario->rol(), 'profesor') == 0 ? true : false;
                    header('Location: menuCliente.php');
                    exit();
                } else {
                    $erroresFormulario[] = "El usuario o el password no coinciden";
                }
            }
        }
        return $erroresFormulario;
    }
    
 }