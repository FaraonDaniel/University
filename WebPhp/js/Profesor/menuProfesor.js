$(()=>{
    $(".desplegable icon").click(function(evt){
        let asig=$(this).parents(".asignatura");
        let val=$(asig).attr('id');
        evt.preventDefault();
        $(asig).find(".tema").toggle();
        $(asig).find(".enunciado").toggle();
        $(this).toggleClass("fas fa-caret-down");
        $(this).toggleClass("fas fa-caret-right");
    });

    $(".botonEliminarEnunciado a").click(function(evt){
            evt.preventDefault();
            let val=$(this).attr('href');
            modalOpener("Eliminar enunciado","¿Estas seguro de que quieres eliminar este enunciado?",true,val,"Eliminar");
    });
    $(".eliminarEnunciado a").click(function(evt){
        evt.preventDefault();
        let val=$(this).attr('href');
        modalOpener("Eliminar tema","¿Estas seguro de que quieres eliminar este tema y todos los enunciados enlazados?",true,val,"Eliminar");
});
    $(".desplegable icon").toggleClass("fas fa-caret-down");
});