var editorCorrector = CodeMirror.fromTextArea(document.getElementById("codesnippet_editable"), {
    lineWrapping:true, 
    lineNumbers: true,
    smartIdent: true,
    tabSize: 5,
    theme:"erlang-dark",
    readOnly: "nocursor",
    matchBrackets: true,
    autofocus: true
  });
if(screen.width > 480){
    editorCorrector.setSize(screen.width*0.4, screen.height*0.70);
}else{
    editorCorrector.setSize(screen.width*2, screen.height*0.70);
}