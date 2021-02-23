$(()=>{
    $(".desplegable icon").click(function(evt){
        let asig=$(this).parents(".asignatura");
        //let val=$(asig).attr('id');
        evt.preventDefault();
        $(asig).find(".tema").toggle();
        $(asig).find(".enunciado").toggle();
        $(this).toggleClass("fas fa-caret-right");
        $(this).toggleClass("fas fa-caret-down");
    });

    $(".borrarPractica a").click(function(evt){
            evt.preventDefault();
            let val=$(this).attr('href');
            console.log(val);
            modalOpener("Eliminar ","¿Estas seguro de que quieres eliminar tu practica subida?",true,val,"Eliminar");
    });

    $(".desplegable icon").toggleClass("fas fa-caret-down");
});