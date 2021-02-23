$(()=>{
    $("#but_asig").click(function(evt){
        //let val=$(asig).attr('id');
		evt.preventDefault();
		$(this).toggle();
		$("#borr_asig").toggle();
		$("#mod_asig").toggle();
		$("#crear_asig").toggle();
		$("#volver").toggle();
		$("#but_mat").toggle();
	});

	$("#but_mat").click(function(evt){
        //let val=$(asig).attr('id');
		evt.preventDefault();
		$(this).toggle();
		$("#asignar").toggle();
		$("#volver_mat").toggle();
		$("#but_asig").toggle();
	});

	$("#volver").toggle();
	$("#borr_asig").toggle();
	$("#mod_asig").toggle();
	$("#crear_asig").toggle();

	$("#asignar").toggle();
	$("#volver_mat").toggle();
});


