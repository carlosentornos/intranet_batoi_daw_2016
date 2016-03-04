/* acciones al cargar la página */
/* incluso antes de que se cree el árbol DOM */
$(function(){


	// nos muestra la pagina de error y
	// al pulsar sobre el botón nos envía a la página principal
	// si no estamos logeados, en caso afirmativo nos envía
	// al panel de control
	$("#btn_volver").click("click",function(){
		var url = "login.php";
		window.open(url);
	});

});