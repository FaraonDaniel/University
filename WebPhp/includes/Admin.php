<?php 
	
class Admin extends Usuario{


	public function __construct()
	{
		if (isset($_SESSION['nick']) && isset($_SESSION['nombre'])) {
			parent::__construct($_SESSION['nick'], $_SESSION['nombre'], '', '', '');
		}
	}
   
	
	public function generaCont(){
		
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$idAdmin = $_SESSION['id'];
		
		$this->estructuraAsignaturas($idAdmin,$conn);
		$this->estructuraMatriculados($idAdmin,$conn); 
    }
	
	
	// *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
	//                ESTRUTURA DE LA PAGINA									
	// *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
	
	private function estructuraAsignaturas($idAdmin,$conn) {
		echo '<ul>';	
		echo '<li> <form action="borrAsigPrim.php"> <button id ="borr_asig" type="submit"> Borrar asignatura </button> </form> </li>';
		echo '<li> <form action="modAsigPrim.php"> <button id ="mod_asig" type="submit"> Modificar asignatura </button> </form> </li>';
		echo '<li> <form action="crearAsig.php"> <button id ="crear_asig" type="submit"> Crear asignatura </button> </form> </li>';
		echo '<li> <form action="menuCliente.php"> <button id ="volver" type="submit" > Volver </button></form></li>';			
		echo '</ul>';
	}
	
	private function estructuraMatriculados($idAdmin,$conn) {
		echo '<ul>';
		echo '<li> <form action="matricular.php"> <button id ="asignar" type="submit"> Matricular alumno a asignatura </button> </form> </li>';
		echo '<li> <form action="menuCliente.php"> <button id ="volver_mat" type="submit" > Volver </button></form></li>';	
		echo '</ul>';
		
	}
	
	// *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
	//                MODIFICAR / BORRAR Y CREAR ASIGNATURAS
	// *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
	
	// FUNCIONES GENERALES SOBRE ASIGNATURAS Y PROFESORES : 
	
	
	public static function listaAsignaturas($idAdmin,$conn){ // TODO a.idAsignatura
		
        $query = sprintf("  SELECT  * FROM asignatura a ");
        $rs = $conn->query($query);
        return $rs;
    }
	
	public static function listaProfesores(){
		
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $idAdmin = $_SESSION['id'];
		
		$query = sprintf("  SELECT * FROM profesor p ,usuarios u WHERE u.idUsuario = p.idProfesor");
        $rs = $conn->query($query);
		
        return $rs;
		
	}
	
	private function getIdFromAsig($asig,$idAdmin,$conn){
			
			
			$rs = Self::listaAsignaturas($idAdmin,$conn);
		
			while($fila = $rs->fetch_assoc()) {
					if ( $fila['nombre'] == $asig ){
						return $fila['idAsignatura'];
					}
			}
			return -1; 
	}
	
	private function getIdFromProf($prof,$idAdmin,$conn){
			
			
			$rs = $this->listaprofesores();
		
			while($fila = $rs->fetch_assoc()) {
					if ( $fila['nick'] == $prof){
						return $fila['idUsuario'];
					}
			}
			return -1; 
	}
	
	public function getAsig($asig){
		
			$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
			$idAdmin = $_SESSION['id'];
			
			$rs = $this->listaAsignaturas($idAdmin,$conn);
			// 2- Buscamos el id de la lista
			while($fila = $rs->fetch_assoc()) {
					if ( $fila['nombre'] == $asig ){
						return $fila;
					}
			}
			return -1; 
		
	}
	
	// FORMULARIOS GENERALES
	
	public static function modAsignaturaForm() {
		
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $idAdmin = $_SESSION['id'];
		
		// 1- Obtenemos la lista de asignaturas
			$rs = Admin::listaAsignaturas($idAdmin,$conn);
		// 2- Mostramos las asignaturas en un select 
			if ($rs->num_rows > 0) {
				
				// Formulario modificar asignatura
					echo '<h1> Modificar asignatura: </h1>'; 
					echo '<p><form method = "POST" id = "modAsig" action ="modificarAsig.php" >';
					echo '<div class = "inicioAdmin"><select name="asigs" id="selecc" size="5" >';
					while($fila = $rs->fetch_assoc()) {
						echo "<option>".$fila['nombre']."</option>";
					}
					echo '</select></div></p>' ; 
					echo '<div class="inicioAdmin">';
						echo '<button type = "submit"> modificar </button></form> ';
						echo '<button type="button" onclick = "location.href=\'menuCliente.php\'"> volver </button>'; 
					echo '</div>';
				$rs->free();
			} else {
				echo "No hay ninguna asignatura subida";
				exit();
			}

	}
	
	public static function borrarAsigForm () {
		
		$app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $idAdmin = $_SESSION['id'];
		
		// 1- Obtenemos la lista de asignaturas
			$rs = Admin::listaAsignaturas($idAdmin,$conn);
		// 2- Mostramos las asignaturas en un select 
			if ($rs->num_rows > 0) {		
						 			          
					echo '<p><form method = "POST" id = "modAsig" action ="borrarAsig.php" >';
					echo "<h1>Borrar asignatura: </h1>"; 
					echo '<select name="asigs" id="selecc" size="5" >';
					while($fila = $rs->fetch_assoc()) {
						echo "<option>".$fila['nombre']."</option>";
					}
					echo '</select></p>' ; 
					echo '<div class="inicioAdmin">';
						echo '<button type = "submit"> borrar </button> </form>';     
						echo '<button type="button" onclick = "location.href=\'menuCliente.php\'"> volver </button>'; 
					echo '</div>';
					 
				$rs->free();
			} else {
				echo "No hay ninguna asignatura subida";
				exit();
			}
		
	}
	
	// BORRAR ASIGNATURA
	
	public function borrarAsig( $asig ){
		
		$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
			$idAdmin = $_SESSION['id'];

		$id = $this->getIdFromAsig($asig, $idAdmin , $conn ) ; 
		echo "Asignatura : ". $asig . "id : " . $id . "<br/> " ; 
		
		
	
		Tema::borrarTemasUnaAsignatura($asig) ; 

		// BORRA LA ASIGNATURA 
		$upd = sprintf("DELETE FROM `asignatura` WHERE `asignatura`.`idAsignatura` = %d", $id);

		if ($conn->query($upd)){
				// Si todo va bien
				echo "Todo ha ido correctamente ..." ; 
		}
		else {
			echo "Error " . $conn->errno ;
			exit();
		}
	}
	
	// MODIFICAR ASIGNATURAS
 
	public function actualizarAsig($original, $nuevo, $profesor){
		
		$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
			$idAdmin = $_SESSION['id'];
		echo $original . ' pasa a ' . $nuevo . "< br />" ; 
		$id = $this->getIdFromAsig($original, $idAdmin , $conn ) ; 
		echo "El id de asignatura es : " . $id . "< br />  y el profesor es : " . $profesor ;
		$id_prof = $this->getIdFromProf($profesor,$idAdmin,$conn); 
		
		$upd = sprintf("UPDATE `asignatura` SET `asignatura`.`nombre`='%s', `asignatura`.`idProfesor` = '%d' WHERE `asignatura`.`idAsignatura`='%d' ", 
			$conn	->real_escape_string($nuevo), 
			$id_prof, 
			$id);
			
		echo $upd ; 

		if ($conn->query($upd)){
				// Si todo va bien
				echo "Todo ha ido correctamente ..." ; 
		}
		else {
			echo "Error " . $conn->errno ;
			exit();
		}
	}
	
	// CREAR ASIGNATURAS
	
	public function crearAsig($nombre,$profesor){
		
		$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
			$idAdmin = $_SESSION['id'];
		
		$id = $this->getIdFromAsig($nombre, $idAdmin , $conn ) ; 
		if ( $id != -1 ) {
			echo "La asignatura ya existe "; 
			header('Location: menuCliente.php');
			exit();
		}
		
		$id_prof = $this->getIdFromProf($profesor,$idAdmin,$conn); 
		
		echo "Profesor : " . $profesor ; //. "ID : " . $id_prof ; 
		if ( $id_prof ==  -1 ) {
			echo "No se encuentra el profesor "; 
			header('Location: menuCliente.php');
			exit();
		}
		$upd = sprintf("INSERT INTO `asignatura` (`idAsignatura`, `nombre`, `idProfesor`) VALUES (NULL, '%s', '%d') ",			
			$nombre, 
			$id_prof);
			
		echo "Profesor es : " . $profesor . $upd ; 

		if ($conn->query($upd)){
				// Si todo va bien
				echo "Todo ha ido correctamente ..." ; 
		}
		else {
			echo "Error " . $conn->errno ;
			exit();
		}
	}
	
	
	// *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
	//                MODIFICAR / BORRAR Y CREAR MATRICULADOS
	// *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-
	
	private function alumnosMatriculados($idAdmin,$conn){ 
        $query = sprintf("  SELECT  * FROM alumnos_matriculados a, usuarios u
							WHERE a.idAlumno =u.idUsuario");
        $rs = $conn->query($query);
        return $rs;
    }
	
	private function modMatriculadosForm($idAdmin ,$conn) {
		
	
		// 1- Obtenemos la lista de asignaturas
			$rs = $this->alumnosMatriculados($idAdmin,$conn);
		// 2- Mostramos las asignaturas en un select 
			if ($rs->num_rows > 0) {
				
				echo '<p><form method = "POST" id = "modAsig" action ="modificarMatriculado.php?" >';
				echo '<select name="mats" size="5">';
				while($fila = $rs->fetch_assoc()) {
					echo "<option>".$fila['nick']."</option>";
				}
				echo '</select></p>' ;
				echo '<p><input type = "submit" value = "modificar"> </form> </p>';
				
				
				
				//TODO echo '<p><input type = "submit" value = "borrar"> </form> </p>';
				$rs->free();
			} else {
				echo "No hay ninguna asignatura subida";
				exit();
			}

	}

	public static function asignarMatriculado(){

			$form = new FormularioModMatri();
			$form->gestiona(); 
	}

	public static function introducirMatriculado($alumno,$asignatura){
		$app = Aplicacion::getSingleton();
			$conn = $app->conexionBd();
			$idAsig = Self::getIdFromAsig($asignatura,NULL,$conn); 
			$idAlumno = Usuario::getIdFromName($alumno) ;

		// Insertamos en la tabla matriculados
		$query = sprintf("INSERT INTO matriculados(idAsignatura, cantidadAlumnos) VALUES ($idAsig, 0)");
				if($rs = $conn->query($query)){
				$query = sprintf(" SELECT idMatriculados FROM matriculados m WHERE m.idAsignatura = $idAsig ");
				if($rs = $conn->query($query)){
					$rs = $rs->fetch_assoc(); 
					$idMatri = $rs["idMatriculados"]; 

					// Insertamos en la tabla alumnos_matriculados
					$query = sprintf("INSERT INTO alumnos_matriculados(idAlumno, idMatriculados) VALUES ($idAlumno,$idMatri)");
					if($rs = $conn->query($query)){
						echo "Todo ha ido correctamente";
					}
					else {
						header("Location: MenuCliente.php"); 
					}
				}
				return $rs;
			}
			return -1 ; 

		// Una vez instartado en la tabla matriculados, conseguimos el idMatriculado para introducirlo en la tabla alumnos matriculados:

	} 
	
	
	
}

