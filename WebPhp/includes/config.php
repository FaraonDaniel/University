<?php

require_once __DIR__.'/Aplicacion.php';

/**
 * Parámetros de conexión a la BD
 */
//cfg['Servers'][$i]['host'] = 'HostName:port'
define('BD_HOST', 'localhost');
define('BD_NAME', 'bbddpractica2');
define('BD_USER', 'user1');
define('BD_PASS', '@codrector2015');
define('RAIZ_APP', __DIR__);
define('RUTA_APP', '');//---------->/VM-0022
define('RUTA_IMGS', RUTA_APP.'img/');
define('RUTA_CSS', RUTA_APP.'css/');
define('RUTA_JS', RUTA_APP.'js/');
define('INSTALADA', true );

/**
 * Configuración del soporte de UTF-8, localización (idioma y país) y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');

// Inicializa la aplicación
$app = Aplicacion::getSingleton();
$app->init(array('host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS), RUTA_APP, RAIZ_APP);
spl_autoload_register( function( $NombreClase ) {
    $aux='';
    $aux.=$NombreClase;
    $aux.='.php';
    include_once ($aux);
} );

/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */
//register_shutdown_function(array($app, 'shutdown'));