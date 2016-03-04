
$(document).ready(function () {

    $('body').on('click', 'a.borrarGrupo', function () {
        $(this).parent().remove();
    });

    $('body').on('click', 'a.anadirGrupo', function () {
        duplicarSelectGrupo();
    });

    $('ul').on("click", "li", function () {
        //le enviamos el id a la funcion para coger todos los datos de los profesores
        var profesor = $(this).text();
        //comprobamos que el profesor seleccionado no este ya en la lista
        if ($('#listaProfesores').children().length === 0) {
            anyadirProfesorLista(profesor);
        } else {
            var repetido = false;
            //por cada div acompanyante
            $('.acompanyantes').each(function () {
                if ($(this).val() === profesor) {
                    repetido = true;
                }
            });
            if (!repetido) {
                anyadirProfesorLista(profesor);
            }
        }
    });

    peticionGrupos();
    //buscamos datos de alumnos por key presionada
    $('#buscarprofesor').keyup(function (evt) {
        var aBuscar = evt.target.value;
        peticionParcialProfesor(aBuscar);
    });

    //por defecto el enter ejecuta el acion del formulario, no queremos eso
    $('#form').keydown(function (evt) {
        if (evt.which === 13) {
            evt.preventDefault();
            checkData();
        }
    });

    $('#submit').click(function (evt) {
        evt.preventDefault();
        checkData(evt);
    });

    $('#fecha, #fechaAlta').datepicker();
    datepickerCastellano();



});
/**
 * funcion encargada de validar los campos del formulario
 * @returns {undefined}
 */
function checkData() {
    var errores = [];
    var datos = [];
    var gruposNuevos = [];
    var profesores = [];

    //campo nomrbe
    var nombreActividad = $('#nombre').val();
    if (checkNombreActividad(nombreActividad)) {
        datos.nombreActividad = nombreActividad.toUpperCase();
    } else {
        errores.push("El nombre de la actividad no puede superar los 50 caracteres ni puede estar vacio.");
    }

    //campo fecha de la actividad
    var fechaActividad = $('#fecha').val();
    if (checkFecha(fechaActividad)) {
        datos.fechaActividad = createEnglishDateFormat(fechaActividad);
    } else {
        errores.push("La fecha de la Activdad no puede estar en blanco o no cumple con el formato correcto (dd-mm-aaaa)");
    }

    //campo hora inicio, no he encontrado un time picker en la libreria de jquery UI
    var horaInicio = $('#horaInicio').val();
    if (checkTimeFormat(horaInicio)) {
        datos.horaInicio = horaInicio;
    } else {
        errores.push("La hora de inicio de la actividad debe cunplir con el formato correcto (hh:mm)");
    }

    var horaFin = $('#horaFin').val();
    if (checkTimeFormat(horaFin)) {
        datos.horaFin = horaFin;
    } else {
        errores.push("La hora de finalizacion de la activdad debe cumplir con el formato correcto (hh:mm:ss)");
    }

    var fechaAlta = $('#fechaAlta').val();
    if (checkFecha(fechaAlta)) {
        datos.fechaAlta = createEnglishDateFormat(fechaAlta);
    } else {
        errores.push("La fecha de alta de la actividad no cumple con el formato adecuado (dd:mm:aaaa)");
    }

    //campo del coordinador
    if ($('#coordinacion').val() === null) {
        errores.push('Debe de seleccionar a un profesor como coordinador de la actividad');
    } else {
        datos.coordinador = $('#coordinacion').val().split(' ')[0];
    }

    //array con todos los profesores (codigos)
    $('.acompanyantes').each(function () {
        profesores.push($(this).val().split(' ')[0]);
    });
    if (profesores.length !== 0) {
        datos.profesores = profesores;
    } else {
        errores.push('Debe haber almenos un profesor para la actividad');
    }

    $('.grupo').each(function () {
        if ($(this).val() !== "-- Seleciona --") {
            gruposNuevos.push($(this).val());
        }
    });

    if (gruposNuevos.length !== 0) {
        datos.grupos = gruposNuevos;
    } else {
        errores.push('Debe haber almenos un grupo para la actividad');
    }

    // profesor seleccionado como cordinador
    //comentarios, descripcion y objetivos (length?)
    datos.comentarios = $('#comentarios').val().toUpperCase();
    datos.descripcion = $('#descripcion').val().toUpperCase();
    datos.objetivos = $('#objetivos').val().toUpperCase();

    //comprobamos que en los arrays no haya nada repetido

    if (errores.length === 0) {
        //enviamos lo datos que hay en la funcion ahora mismo, no los del formulario
        console.log(datos);
        modDatos(datos);
    } else {
        showErrors(errores, "errores");
    }
}

/**
 * peticion ajax para el envio de los datos modificados del formulario
 * @param {array} datos array con los datos rellenados en el formulario
 * @returns {undefined}
 */
function modDatos(datos) {

    $.post('php/gestionAltaActividad.php', {
        nombreActividad: datos.nombreActividad,
        fechaActividad: datos.fechaActividad,
        fechaAlta: datos.fechaAlta,
        horaInicio: datos.horaInicio,
        horaFin: datos.horaFin,
        profesores: datos.profesores,
        grupos: datos.grupos,
        coordinador: datos.coordinador,
        comentarios: datos.comentarios,
        descripcion: datos.descripcion,
        objetivos: datos.objetivos

    },
    function (dataRecived) {
        dataRecived = JSON.parse(dataRecived);
        var array = $.map(dataRecived, function(array) {
            return array;
        });
        if (dataRecived.hasOwnProperty('error')) {
            showErrors(array, 'error');
        } else {
            showErrors(array, 'ok');
            emptyFields();
        }
    });
}
/**
 * vacia los campos de los formulario
 * @returns {undefined}
 */
function emptyFields(){
    $('#nombre').val('');
    $('#fecha').val('');
    $('#horaInicio').val('');
    $('#horaFin').val('');
    $('#fechaAlta').val('');
    $('#coordinacion').empty();
    $('#box').remove();
    $('#buscarprofesor').val('');
    $('#listaProfesores').empty();
    $('#grupo').empty();
    $('#comentarios').val('');
    $('#descripcion').val('');
    $('#objetivos').val('');
}
/**
 * peticion ajax para recibir los datos de los profesores que se buscan 
 * @param {String} cadena cadena de caracteres a buscar como apellido1 en la base de datos
 * @returns {undefined}
 */
function peticionParcialProfesor(cadena) {

    $.post('php/datosServidor.php', {aBuscar: "parcialProfesor", id: cadena}, function (dataRecived) {
        console.log(JSON.parse(dataRecived));
        var dataRecived = JSON.parse(dataRecived);
        $('#box').show();
        $('#ulProfContainer').empty();
        for (i = 0; i < dataRecived.length; i++) {
            $('#ulProfContainer').append('<li>' + dataRecived[i].codigo + " // " + dataRecived[i].dni + ' // ' + dataRecived[i].apellido1 + ', ' + dataRecived[i].apellido2 + ', ' + dataRecived[i].nombre + '</li>');
            //$('#ulAlumnContainer').append('<li>'+dataRecived+'</li>');
        }
    });
}

function anyadirProfesorLista(profesor) {
    $('#listaProfesores').append('<option class="acompanyantes">' + profesor + '</option></br></br>');
    $('#coordinacion').append('<option>' + profesor + '</option></br></br>');
    $('#listaProfesores').css('border', '3px solid darkgreen');
    setTimeout(function () {
        $('#listaProfesores').css('border', '1px solid black').css('border-radius', '5px')
    }, 1000);
    $("#box").hide();
}



