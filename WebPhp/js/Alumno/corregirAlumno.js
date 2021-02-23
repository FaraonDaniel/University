
var editorPractica = CodeMirror.fromTextArea(document.getElementById("scope"), {
  lineNumbers: true,
  smartIdent: true,
  lineWrapping:true,
  theme:"ambiance",
  readOnly: "nocursor",
  matchBrackets: true,
  autofocus: true,
});

if(screen.width > 480){
  editorPractica.setSize(screen.width*0.45, screen.height*0.70);
}else{
  editorPractica.setSize(screen.width*1.3, screen.height*0.70);
}

$(() => {
  $(".botonesCorregir #submitCorreccion").click(function (e) {
    console.log($(this).attr('href'));
    var id=$(this).attr('value');
    var coment = editableCodeMirror.getValue("\n");
    $.post( "subirComentario.php", { idPractica: id, comentario: coment} );
    editado=false;
    e.preventDefault();
    modalOpener("Guardado con éxito","",false,"","Ok");
    //modalOpener()
  });
});