$(()=>{
    if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent) || $(window).width() < 480) {
        $("div#contenedor").css("min-height",screen.height*2.5);
        $("div#contenidoAsig").css("min-height",screen.height*2.5);
        $("div#contenidoAsig").css("align-items","start");
        $("div#contenido").css("min-height",screen.height*2.5);
        $("div#contenido").css("align-items","start");
    } else{
        $("div#contenedor").css("min-height",screen.height*0.51);
        $("div#contenido").css("min-height",screen.height*0.51);
    }
    
});