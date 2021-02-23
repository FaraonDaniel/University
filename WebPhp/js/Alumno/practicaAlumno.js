var editor = CodeMirror.fromTextArea(document.getElementById("scope"), {
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
  editor.setSize(screen.width*0.75, screen.height*0.70);
}else{
  editor.setSize(screen.width*2, screen.height*0.70);
}

