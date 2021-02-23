$(()=>{

	$("#email").change(function(){
        const campoCorreo = $("#email");
		campoCorreo[0].setCustomValidity(""); 
        $("#correoOK").html("");
		correoValidoComplu(campoCorreo);
    }); 
    
    $("#nickUser").change(function(){
        const campoNick = $("#nickUser");
        nickValido(campoNick);
    });

	$("#campoUser").change(function(){
        const campoUser = $("#campoUser");
        $("#userOK").html("");

        if($("#campoUser").val().length >= 5){
            $("#userOK").html("✅");
            campoUser[0].setCustomValidity("");
        }
        else{
            campoUser[0].setCustomValidity("Debe tener un mínimo de 5 caracteres");
            $("#userOK").html("❌");            
        }
    });

    $("#pwd").change(function(){
        const campoPW = $("#pwd");
        var re = /^[a-zA-Z0-9]{5,}$/;

        if(campoPW.val().match(re)){
            $("#pwdOK").html("✅");
            campoPW[0].setCustomValidity("");
        }
        else{
            $("#pwdOK").html("❌");
            $("#pwdOK").show();
            campoPW[0].setCustomValidity("La contraseña debe tener una mayúscula, y un número.");
        }
    });


    $("#pwd2").change(function(){
        const campoPWAux = $("#pwd");
        const campo2 = $("#pwd2");

        var re = /^[a-zA-Z0-9]{5,}$/;
        if(campo2.val() == campoPWAux.val() && campo2.val().match(re)){
            $("#pwd2OK").html("✅");
            campo2[0].setCustomValidity("");
        }
        else{
            campo2[0].setCustomValidity("Las contraseñas no coinciden.");
            $("#pwd2OK").html("❌");
        }
    });


	
});
function nickValido(nick){
    var valNick = nick.val();
    if(valNick.length <= 0){
        $("#nickOK").html("❌");
    }
    else{
        var url="checkUser.php?user=" + valNick;
        $.get(url, nickExiste);
    }
}

function nickExiste(data, status){

    if(data=='false'){
        $("#nickOK").html("❌");
        $("#nickOK").show();
        $("#nickUser")[0].setCustomValidity("El nick ya se ha utilizado");
    }
    else{
        $("#nickOK").html("✅");
        $("#nickOK").show();
        $("#nickUser")[0].setCustomValidity("");
    }
}

function correoValidoComplu(correo) {
    var valCorreo=correo.val();
    var correoEnd = valCorreo.substring(valCorreo.length - 7, valCorreo.length);
    if (correoEnd == '@ucm.es' && valCorreo.length > 7) {
        var url = "checkUser.php?user=" + valCorreo;
        $.get(url, correoExiste);
    } else {
        $("#correoOK").html("❌");
        $("#correoOK").show();
        $("#email")[0].setCustomValidity("El correo debe ser válido y acabar por @ucm.es");
    }
}

function correoExiste(data,status) {
    if(data=='false'){
        $("#correoOK").html("❌");
        $("#correoOK").show();
        $("#email")[0].setCustomValidity("El correo ya se ha utilizado");
    }
    else{
        $("#correoOK").html("✅");
        $("#correoOK").show();
        $("#email")[0].setCustomValidity("");
    }
}

