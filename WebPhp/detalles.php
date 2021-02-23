<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <title>Detalles</title>
</head>

<body>

    <div id="contenedor">

        <div id="cabecera">
            <img class="logoCabecera" src="images/codrector.png">
        </div>
        <?php include 'barraNav.html'; ?>

        <div id="contenido">
            <h1>Detalles</h1>
            <div class="splitUp">
                <h2>Índice detallado</h2> <br>
                        <a href="#LoginAlumno" >Login del Alumno </a><br>
                        <a href="#LoginProfesor">Login del Profesor </a><br>
                        <a href="#Interfaz">Interfaz principal</a><br>
                        <a href="#EntregaPracticas">Entrega de practicas</a><br>
                        <a href="#CorreccionPrimerNivel"> Corrección primer nivel </a> <br>
                        <a href="#ListaCorreccion"> Lista entregas (Profesor)</a><br>
                        <a href="#CorreccionSegundoNivel">Correccion segundo nivel</a><br>
                        <a href="#PrácticasNota">Nota final de prácticas</a><br>
                        <a href="#PublicacionPracticas"> Publicación de las prácticas(Profesor)</a><br>
                        
                </p>
            </div>

            <div class="splitDown">
                <section>
                    <h2 id="LoginAlumno"> Login del alumno </h2>
                    <div class="section-content">
                        Al entrar en la aplicación, se mostrarán dos recuadros: "Loggearse", para introducir nombre y contraseña, y "Descripción/Noticias" donde se mostrarán novedades sobre la página.
                        Cada alumno tendrá una cuenta, con un id designado por el profesor. En la pestaña de loggeo, se podrá introducir la información antes mencionada sobre el usuario, además de tener un par de líneas:
                        Contraseña olvidada/Correo olvidado; y Registrarse. La primera funcionará como un formulario para enviar un correo al usuario en caso de haber olvidado sus credenciales. En el segundo apartado aparecerán 
                        una serie de huecos donde el nuevo usuario introducirá los datos de su nueva cuenta.
                    </div>
                </section>


                <section>
                    <h2 id="LoginProfesor"> Login del profesor </h2>
                    <div class="section-content">
                        Se loggeara de forma similar, teniendo presente todos los apartados ya mencionados en los alumnos. Dentro de la aplicación dispondrá de otra interfaz, con apartados como: Cursos, Prácticas para corregir, entregadas, y la asignación a los alumnos para correción de primer nivel.
                    </div>
                </section>

                <section>
                    <h2 id="Interfaz"> Interfaz con las posibles opciones </h2>
                    <div class="section-content">
                        <h3 align="center"> Alumnos </h3>
                        <p>Para ambos usuarios, al entrar en la aplicación aparecerá una interfaz con los cursos de cada uno. En los alumnos, se mostrarán las prácticas
                            que deban entregar, con un color diferente en cada caso: </p>
                        <p>
                            <font color="red">Rojo </font>: faltan tareas por entregar.
                        </p>
                        <p>
                            <font color="DarkOrange">Amarillo </font>: pendiente de corrección.
                        </p>
                        <p>
                            <font color="green">Verde </font>: todo completo.
                        </p>

                        <p>En todo momento podrán hacer selección sobre cualquiera de estos apartados, accediendo a la sección con los detalles de la práctica. Además, en todas las páginas por las que vayamos avanzando 
                        siempre estará presente el botón para cerrar sesión.</p>



                        <h3 align="center"> Profesor </h3>
                        <p>Similar a la disposición de los alumnos, los profesores tendrán varias pestañas, que dividirán las prácticas en: corregidas por alumnos (prácticas que pueden pasar a la correción de segundo nivel que realiza
                        el profesor), prácticas entregadas por alumnos (muestra los alumnos que han entregado la práctica que les correspondia), ver y corregir prácticas, entrega aleatoria de prácticas (para repartir por id´s aleatorios
                        las prácticas ya entregadas y listas para ser corregidas a primer nivel) e introducir nueva entrega (añadir a la aplicación una práctica, con detalles y opciones especificadas dentro de otra página).
                        </p>
                    </div>
                </section>

                <section>
                    <h2 id="EntregaPracticas"> Entrega de practicas</h2>
                    <div class="section-content">
                        <p>Tras haber accedido al curso, y de haber pulsado sobre la pestaña de la práctica deseada, se mostrará al alumno un conjunto de casillas (fecha limite, comentarios sobre la práctica a entregar, Agregar entrega)
                         y un apartado para subir el/los archivos. Dependiendo de lo que el profesor decida, será o no posible corregirlo a primer nivel, ya que si no lo cree conveniente, solamente se entregarán las prácticas, 
                         y serán evaluadas por el profesor directamente. Tras la entrega, el profesor tendrá acceso a ver cuales han realizado la entrega, y cuales no, para poder asignar aquellos que vayan a hacer la primera correción (nivel alumno).</p>
                    </div>
                </section>


                <section>
                    <h2 id="CorreccionPrimerNivel"> Corrección primer nivel</h2>
                    <div class="section-content">
                        <p>Los alumnos que hayan realizado la entrega de su práctica, verán un botón con la opción de correción de prática (seleccionada aleatoriamente). Al pulsarlo les saldrá una pantalla dividida en dos, donde se mostrará el código a la izquierda, y un recuadro donde se harán los comentarios y cambios correspondientes en el código, a la derecha.
                        Además, exisitirá un recuadro más general en la parte inferior donde se podrán escribir más comentarios y observaciones.
                        Finalmente, el alumno podrá salir sin corregir la práctica, enviarla al profesor, y contar los errores totales identificados por el alumno corrector.
                        </p>
                    </div>
                </section>
                    
                <section>
                    <h2 id="ListaCorreccion"> Lista entregas (Profesor)</h2>
                    <div class="section-content">
                        <p>En el caso de que el profesor desee consultar información sobre las entregas de primer nivel, podrá acceder a través de la pestaña "prácticas entregadas por alumnos". Dentro,
                        se le mostrará una lista con los archivos adjuntados en total, ordenados en dos columnas. Cada archivo presentará un nombre: <strong>"práctica de alumno"</strong>, y la <strong>valoración</strong> puesta por el primer nivel.
                        </p>
                    </div>
                </section>

                <section>
                    <h2 id="CorreccionSegundoNivel"> Corrección segundo nivel</h2>
                    <div class="section-content">
                        <p>Después de haber pasado el primer nivel y antes de corregir las prácticas, sobre el segundo nivel, al profesor le aparecerán las listas de los alumnos que han hecho "pareja" en la práctica (una entrega y una correción). Sobre estas, verá los nombres de ambos alumnos, 
                        e información aportada por ambos. Su interfaz será la misma que tiene un alumno, pero podrá modificar cualquier detalle o apunte de este último.
                        Todo esto ocurrirá tras acabar el tiempo límite para hacer las entregas de correcciones de primer nivel. Así pues, realizará una correción de segundo nivel, donde calificará al primer alumno (código, funcionalidad, y detalles secundarios), y las correciones/observaciones del segundo alumno.
                        En el caso de que las correcciones del profesor y el segundo alumno estén muy distantes, se penalizará al este último.
                        </p>
                    </div>
                </section>

                <section>
                    <h2 id="PrácticasNota">Nota final de prácticas</h2>
                    <div class="section-content">
                        <p>Cuando el profesor haya corregido todas las prácticas, publicará los resultados. Esto hará que en el curso del alumno donde está la práctica, se muestre en color verde. A cada alumno se le mostrará
                        el nombre de la práctica, los datos principales (fecha, nombre del alumno original, comentarios de la práctica a primer y segundo nivel, nota primer y segundo nivel, y comentario del profesor).
                    </div>
                </section>


                <section>
                    <h2 id="PublicacionPracticas"> Publicación de las prácticas(Profesor)</h2>
                    <div class="section-content">
                        <p>Dentro de la cuenta del profesor, y en la pestaña <strong> Introducir nueva entrega </strong> aparecerán varios apartados donde se especificarán las características de la entrega (nombre de la práctica, fecha límite, condiciones impuestas por el profesor, y un comentario). Finalmente, tendrá la opción de publicar la práctica a todos los alumnos del curso.
                    </div>
                </section>
            </div>
        </div>


        <div id="pie">
            Pie de página
        </div>

    </div> <!-- Fin del contenedor -->

</body>

</html> 