/**
 * Titulo
 * Pregunta o descripcion
 * Si es danger
 * Enlace de aceptar
 */
function modalOpener(titulo,pregunta, isDanger,enlace,mensajeAceptar){
    $('#myModal').modal({
        show: true,
        backdrop: false
    });
    
    $('.modal-footer #enlace').attr('action', enlace);
    $('.modal-body p').text(pregunta);
    $('h3.modal-title').text(titulo);
    $('.modal-footer #enlace #aceptar').removeClass();
    (isDanger)? $('.modal-footer #enlace #aceptar').addClass("btn btn-danger"):$('.modal-footer #enlace #aceptar').addClass("btn btn-success");
    $('.modal-footer #enlace #aceptar').text(mensajeAceptar);
}