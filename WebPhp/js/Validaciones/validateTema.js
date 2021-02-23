$(()=>{
    $("#addTema").change(function(){
        const campoTema = $("#addTema");
        $("#addTemaOK").html("");
        temaValido(campoTema.val());
    });
});

function temaValido(nombreTema){
    var url = "checkTema.php?tema=" + nombreTema;
    $.get(url, temaExiste);
}

function temaExiste(data, status){
    if(data == 'false'){
        $("#addTemaOK").html("✅");
        $("#addTema")[0].setCustomValidity("");
    }
    else{
        $("#addTemaOK").html("❌");
        $("#addTema")[0].setCustomValidity("El tema ya existe.");
    }
}