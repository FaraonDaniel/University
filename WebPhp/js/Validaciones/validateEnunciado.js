$(()=>{
    $("#addEnunciado").change(function(){
        $("#enunciadoOK").html("");
        $("#addEnunciado")[0].setCustomValidity("");
        enunciadoValido($("#addEnunciado").val());
    });

    $("#fechaFin").change(function(){
        $("#fechaFinOK").html("");
        if($("#fechaFin").val() < ($("#fechaInicio").val())){
            $("#fechaFinOK").html("❌");
            $("#fechaIniOK").html("❌");
            $("#fechaFin")[0].setCustomValidity("Las fechas no son coherentes");
        }
        else{
            $("#fechaFinOK").html("✅");
            $("#fechaIniOK").html("✅");
            $("#fechaFin")[0].setCustomValidity("");
        }
    });
    $("#extFichero").change(function(){
        $("#extFicheroOK").html("");
       
        var aux = $("#extFichero").prop('files')[0];
        if(aux != ""){
            aux2 = aux.name.split(".");
            if(aux2[1] == "pdf" && aux2.length <= 2){
                $("#extFicheroOK").html("✅");
            }
            else{
                $("#extFicheroOK").html("❌");
                $("#extFichero")[0].setCustomValidity("Extension inválida.");
            }
        }
        else{
            $("#extFichero")[0].setCustomValidity("Introduzca un archivo PDF.");
        }

    });
});

function enunciadoValido(nombreEnunciado){
    var url = "checkEnunciado.php?nombreEnunciado=" + nombreEnunciado;
    $.get(url, enunciadoExiste);
}

function enunciadoExiste(data, status){
    console.log(data);
    if(data == "false"){
        $("#enunciadoOK").html("✅"); 
        $("#addEnunciado")[0].setCustomValidity("");
    }
    else{
        $("#enunciadoOK").html("❌");  
        $("#addEnunciado")[0].setCustomValidity("El nombre ya está en uso.");
    }
}