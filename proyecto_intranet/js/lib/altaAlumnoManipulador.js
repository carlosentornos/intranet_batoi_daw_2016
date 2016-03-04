var gruposNuevos = [];
var profesores = [];

$(document).ready(function() {
    /**
     * Listener para el boton que da de baja o de alta al alumno en el curso de manipulador de alimentos
     */
    $('.boton').click(function() {
        if ($(this).text() === 'Registrarse') {
            altaCurso($('#cursosManipulador').val());
        } else {
            bajaCurso();
        }
    });
});
/**
 * peticion ajax para dar de alta al alumno en el curso seleccionado
 * @param {type} codigoCurso variable que contiene el codigo del curso seleccionado
 * @returns {undefined}
 */
function altaCurso(codigoCurso) {

    $.post('php/gestionAltaAlumnoManipulador.php', {
        dato: $('.boton').text(),
        curso: codigoCurso
    }, function(dataReceived) {
        location.assign(dataReceived);
    });
}

/**
 * peticion ajax para dar de baja al alumno en el curso que este dado de alta
 * @returns {undefined}
 */
function bajaCurso() {
    $.post('php/gestionAltaAlumnoManipulador.php', {
        dato: $('.boton').text()
    }, function(dataReceived) {
        location.assign(dataReceived);
    });
}

