<?php
 require_once 'config.php';

  $val=$_POST["texto"];
  $enun=$_POST["enun"];
  $corr=$_POST["corr"];

  $dirAct = 'uploads/practicasCorregidas/'.$enun.'/'.$corr.'/'.$corr.'.txt';

  $correccion = CorreccionAlumno::buscaCorrecionAlumno($enun, $_SESSION['id']);


  /*
  if(!file_exists($filename)){
            if(!mkdir($filename,0777,true)) {
                return false;
            }
        }
        $file = fopen( $filename, "r+w" );
        if( $file == false ) {
            echo ( "Error in opening file" );
            exit();
        }
        $filesize = filesize($filename);
        $filetext="";
        if($filesize>0){
            $filetext = fread( $file, $filesize );
        }
  */
  if($correccion){

      if(!file_exists($dirAct)){
        if(!mkdir($dirAct,0777,true)) {
          echo 'console.log("Error al crear dir")';
          return false;
        }
      }
      else{
        rmdir($dirAct);
        //unlink($dirAct);
      }
      echo $dirAct;
      if($archivo = fopen($dirAct,"r+w")){
          if (!fwrite($archivo,$val)) return false;
          fclose($archivo);
      }
      else{
        echo "no se ha abierto";
      }
  }
  else{
    echo "no se ha encontrado practica";
  }
