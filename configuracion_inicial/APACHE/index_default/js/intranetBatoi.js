/* acciones al cargar la página */
/* incluso antes de que se cree el árbol DOM */
$(function(){

	$("#btn_intranet").click("click",function(){
		var url = "https://172.16.70.101";
		window.open(url);
		event.preventDefault();
	});

	$("#btn_cipfpbatoi").click("click",function(){
		var url = "http://www.cipfpbatoi.es";
		window.open(url);
		event.preventDefault();
	});

});
