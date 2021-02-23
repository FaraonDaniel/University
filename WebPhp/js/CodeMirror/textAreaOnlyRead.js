var editableCodeMirror = CodeMirror.fromTextArea(document.getElementById('scope'), {
    lineNumbers: true,
    lineWrapping:true, 
    smartIdent: true,
    tabSize: 5,
    theme:"ambiance",
    readOnly: "nocursor",
    matchBrackets: true,
    autofocus: true
});
if(screen.width > 480){
    editableCodeMirror.setSize(screen.width*0.5, screen.height*0.60);
  }else{
    editableCodeMirror.setSize(screen.width*1, screen.height*0.60);
  }