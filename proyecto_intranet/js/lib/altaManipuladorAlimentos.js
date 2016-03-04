var datos = [];
$(document).ready(function() {

});

function checkData() {
    var errores = [];

    if (errores.length === 0) {
        //enviamos lo datos que hay en la funcion ahora mismo, no los del formulario
        modDatos(datos);
    }

    console.log(errores.length);
    console.log(errores);

}

//modificacion de datos en el servidor
//funciones ajax
function modDatos(datos) {
    console.log(datos.repite);
    $.post('php/gestionManipuladorAlimentos.php', {
        id: idAlumnoRellenado
    },
    function(dataRecived) {
        console.log(dataRecived);
    });
}
