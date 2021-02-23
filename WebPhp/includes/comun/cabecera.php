<link rel="stylesheet" type="text/css" href="js/lib/bootstrap.min.css" >
<link rel="stylesheet" type="text/css" href="styles/estilo.css" >
<div id="cabecera">
    <div class="logoCabecera">
        <a href="menuCliente.php">
            <img src="images/codrector.png" alt="CodRector logo">
        </a>
    </div>
</div> 

<nav class="navbar navbar-default">

  <div class="container-fluid">
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
   
      <ul class="nav navbar-nav navbar-left">
       
        <?php  
                     echo ' <li><a href="index.php">Inicio</a></li> '; 
                    if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) {
                        // Si esta iniciada la sesión
                            echo ' <li><a href="menuCliente.php">Mis asignaturas</a></li> '; 
                    }
                   
                ?>
      </ul>              
      <ul class="nav navbar-nav navbar-right">
       
        <?php  
                    if (isset($_SESSION["login"]) && ($_SESSION["login"] === true)) {
                        // Si esta iniciada la sesión
                            echo ' <li><a href ="menuCliente.php" class ="nick"><icon class="fas fa-user"></icon> '. $_SESSION["nick"] .'</a> </li>';  
                            echo ' <li><a href="logout.php">Log out</a></li> '; 
                    }
                    else {
                            echo ' <li><a href="login.php">Login</a></li> ';
                            echo ' <li><a href="registro.php">Registro</a></li> '; 
                    }
                ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>