var editableCodeMirror = CodeMirror.fromTextArea(document.getElementById('codesnippet_editable'), {
  lineNumbers: true,
  lineWrapping:true,
  theme:"duotone-light",
  matchBrackets: true,
  autofocus: true,
  tabSize:0
});
if(screen.width > 480){
  editableCodeMirror.setSize(screen.width*0.4, screen.height*0.60);
}else{
  editableCodeMirror.setSize(screen.width*1, screen.height*0.6);
}


