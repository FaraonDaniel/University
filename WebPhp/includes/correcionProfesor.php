<?php

	class CorreccionProfesor {
		
		// LA DE PRUEBA
			public static function corregirPractica($comentario, $idProfesor, $idPractica){
				
				$app = Aplicacion::getSingleton();
				$conn = $app->conexionBd();
		
				$upd = sprintf("INSERT INTO `correccionprofesor`(`idCorreccionProfesor`, `idPractica`, `idProfesor`, `Comentario`) VALUES ('%d','%d','%d','%s')",
					NULL, $idPractica,$idProfesor, $comentario);
				$resultado=$conn->query($upd) or die(" No se ha podido hacer la consulta");
				
				
			}
			
			
			public static function modificarCorreccionPractica($comentario, $idProfesor, $idPractica){
				
				$app = Aplicacion::getSingleton();
				$conn = $app->conexionBd();
				//UPDATE `correccionprofesor` SET `idCorreccionProfesor`='%d',`idPractica`='%d',`idProfesor`='%d',`Comentario`='%d' WHERE 1
				$upd = sprintf("UPDATE `correccionprofesor` SET `idCorreccionProfesor`='%d',`idPractica`='%d',`idProfesor`='%d',`Comentario`='%d'",
					NULL, $idPractica,$idProfesor, $comentario);
				$resultado=$conn->query($upd) or die(" No se ha podido hacer la consulta");		
			}
			
			public static function borrarCorreccionPractica($comentario, $idProfesor, $idPractica){
				
				$app = Aplicacion::getSingleton();
				$conn = $app->conexionBd();
		
				$upd = sprintf("DELETE FROM `correccionprofesor` c WHERE c.idProfesor = '%d' and c.idPractica = '%d'",$idProfesor,$idPractica);
				$resultado=$conn->query($upd) or die(" No se ha podido hacer la consulta");
				
				
			}
			
		
	}

	