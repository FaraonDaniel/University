<?php
 
 $val=$_POST["texto"];
  $enun=$_POST["enun"];
  $corr=$_POST["corr"];

  $dirAct='../uploads/practicasCorregidas/'.$enun.'/'.$corr.'/'.$corr.'.txt';

  $correccion = CorreccionAlumno::buscaCorrecionAlumno($enun, $_SESSION['id']);
  echo $correccion;
/*
  $correccion->deleteDir($dirAct);
  if(!file_exists($dirAct)){
      if(!mkdir($dirAct,0777,true)) {
          console.log("Error al crear dir");
          return false;
      }
    }
  $archivo = fopen($dirAct,"w+b");
  if (!fwrite($archivo,$val)) return false;
  fclose($archivo);
  echo $val;
  */
  fclose($archivo);
  echo $val;
  */
  
