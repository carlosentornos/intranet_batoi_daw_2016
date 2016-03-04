
$(document).ready(function() {
    cargarActividadesExtraescolares();
    peticionGrupos();
    datepickerCastellano();
    $('#fecha, #fechaAlta').datepicker();

    $('#buscarprofesor').keyup(function(evt) {
        var aBuscar = evt.target.value;
        peticionParcialProfesor(aBuscar);
    });

    $('body').on('click', 'li', function() {
        //añadimos profesor de la lista a la tabla solo si se ha insertado el profesor en la tabla
        anadirProfesorActividad($(this).text().split(' ')[0], $('#filtro').val());
        $('#box').hide();
        $('#buscarProfesor').val('');
    });

    $('.nuevaAlta').click(function() {
        window.location.assign("nuevaActividad.php");
    });

    $('#form').keydown(function(evt) {
        if (evt.which === 13) {
            evt.preventDefault();
            checkData();
        }
    });

    $('#filtro').change(function() {
        cargarActividadEspecifica($(this).val());
    });

    //evento para los botones borrar
    $('body').on('click', '.delProfesor', function() {
        borrarProfesorActividad($(this).parent().parent().find('td:first').text(), $('#filtro').val());
    });

    //evento para los botones borrar
    $('body').on('click', '.delGrupo', function() {
        borrarGrupoActividad($(this).parent().parent().find('td:first').text(), $('#filtro').val());
    });

    $('#grupo').change(function() {
        anadirGrupoActividad($(this).val(), $('#filtro').val());
    });

    $('#submit').click(function(evt) {
        evt.preventDefault();
        checkData();
    });

    $('body').on('click', '.checkCoordinador', function() {
        marcarComoCoordinador($(this).parent().parent().find('td:first').text(), $('#filtro').val());
    });

    $('#generarPermiso').click(generarPDFAutorizacionMenores);

});

/**
 * Peticion ajax para cambiar el coordinador de la actividad
 * @param {String} codigoProfesor codigo del profesor que se marcara como coordinador de la actividad
 * @param {String} codigoActividad codigo de la actividad extraescolar implicada
 * @returns {undefined}
 */
function marcarComoCoordinador(codigoProfesor, codigoActividad) {
    $.post('php/gestionModActividad.php', {accion: "cambiarCoordinador", codigoProfesor: codigoProfesor, codigoActividad: codigoActividad},
    function(dataRecived) {
        dataRecived = JSON.parse(dataRecived);
        errors(dataRecived);
    });
}
/**
 * funcion encargada de validar los campos del formulario
 * @returns {undefined}
 */
function checkData() {
    var datos = [];
    var errores = [];
    var nombreActividad = $('#nombre').val();

    if (checkNombreActividad(nombreActividad)) {
        datos.nombreActividad = nombreActividad;
    } else {
        errores.push('El campo Nombre de la actividad no puede estar vacío o superar los 50 carácteres');
    }

    var fechaActividad = $('#fecha').val();
    if (checkFecha(fechaActividad)) {
        datos.fechaActividad = createEnglishDateFormat(fechaActividad);
    } else {
        errores.push('El campo Fecha de la actividad no puede estar vacío o no cumple con el formato correcto');
    }

    var horaInicio = $('#horaInicio').val();
    if (checkTimeFormat(horaInicio)) {
        datos.horaInicio = horaInicio;
    } else {
        errores.push('El campo Hora de inicio no puede estar vacío o no cumple con el formato correcto');
    }

    var horaFin = $('#horaFin').val();
    if (checkTimeFormat(horaFin)) {
        datos.horaFin = horaFin;
    } else {
        errores.push('El campo Hora de finalización no puede estar vacío o no cumple con el formato correcto');
    }

    var fechaAlta = $('#fechaAlta').val();
    if (checkFecha(fechaAlta)) {
        datos.fechaAlta = createEnglishDateFormat(fechaAlta);
    } else {
        errores.push('El campo Fecha de alta de la actividad no puede estar vacío o no cumple con el formato correcto');
    }

    datos.comentarios = $('#comentarios').val();
    datos.objetivos = $('#objetivos').val();
    datos.descripcion = $('#descripcion').val();

    if (errores.length === 0) {
        modificarDatosActividad(datos,$('#filtro').val());
    } else {
        showErrors(errores, 'errores');
    }
}

/**
 * funcion para mostrar los errores cliente/servidor
 * @param {JSON Array} dataRecived array en formato JSON con los errores/confirmaciones de las distintas peticiones ajax
 * @returns {undefined}
 */
function errors(dataRecived) {
    var array = $.map(dataRecived, function(array) {
        return array;
    });
    if (dataRecived.hasOwnProperty('error')) {
        showErrors(array, 'error');
    } else {
        cargarActividadEspecifica($('#filtro').val());
        showErrors(array, 'ok');
    }
}
/**
 * peticion al fichero encargado de generar los pdf para las autorizaciones de menores
 * @returns {undefined}
 */
function generarPDFAutorizacionMenores(){
   var idAct = $('#filtro').val();
   location.assign('php/pdf/plantillaAutorizacionMenores.php?id='+idAct);
}
/**
 * Peticion ajax para modificar los datos de la actividad (sin grupos y profesores)
 * @param {array} datos Contiene los datos del formulario
 * @param {type} codigoActividad Codigo de la actividad implicada
 * @returns {undefined}
 */
function modificarDatosActividad(datos,codigoActividad) {
    $.post('php/gestionModActividad.php', {
        accion: "modificarDatosActividadExtraescolar", 
        codigoActividad: codigoActividad,
        nombreActividad: datos.nombreActividad, 
        fechaActividad: datos.fechaActividad,
        fechaAlta: datos.fechaAlta,
        horaInicio: datos.horaInicio,
        horaFin: datos.horaFin,
        comentarios: datos.comentarios,
        descripcion: datos.descripcion,
        objetivos: datos.objetivos
    },
    function(dataRecived) {
        dataRecived = JSON.parse(dataRecived);
        errors(dataRecived);
    });
}
/**
 * Peticion ajax para añadir los datos profesores implicados
 * @param {string} codigoProfesor codigo del profesor seleccionado
 * @param {type} codigoActividad codigo de la actividad implicada
 * @returns {undefined}
 */
function anadirProfesorActividad(codigoProfesor, codigoActividad) {
    $.post('php/gestionModActividad.php', {accion: "anadirProfesorActividad", codigoProfesor: codigoProfesor, codigoActividad: codigoActividad},
    function(dataRecived) {
        dataRecived = JSON.parse(dataRecived);
        errors(dataRecived);
    });
}
/**
 * peticion ajax para añadir el grupo a la actividad
 * @param {string} nombreGrupo nombre del grupo implicado
 * @param {type} codigoActividad codigo de la actividad implicada
 * @returns {undefined}
 */
function anadirGrupoActividad(nombreGrupo, codigoActividad) {
    $.post('php/gestionModActividad.php', {accion: "anadirGrupoActividad", nombreGrupo: nombreGrupo, codigoActividad: codigoActividad},
    function(dataRecived) {
        dataRecived = JSON.parse(dataRecived);
        errors(dataRecived);
    });
}
/**
 * peticion ajax para borrar el grupo seleccionado en la actividad implicada
 * @param {type} codigoGrupo codigo del grupo implicado
 * @param {type} codigoActividad codigo de la actividad extraescolar implicada
 * @returns {undefined}
 */
function borrarGrupoActividad(codigoGrupo, codigoActividad) {
    $.post('php/gestionModActividad.php', {accion: "borrarGrupoActividad", codigoGrupo: codigoGrupo, codigoActividad: codigoActividad},
    function(dataRecived) {
        //console.log(dataRecived);
        dataRecived = JSON.parse(dataRecived);
        errors(dataRecived);
    });
}
/**
 * peticion ajax encargada de borrar un profesor en la actividad
 * @param {string} codigoProfesor codigo del profesor a borrar
 * @param {string} codigoActividad codigo de la actividad implicada
 * @returns {undefined}
 */
function borrarProfesorActividad(codigoProfesor, codigoActividad) {
    $.post('php/gestionModActividad.php', {accion: "borrarProfesorActividad", codigoProfesor: codigoProfesor, codigoActividad: codigoActividad},
    function(dataRecived) {
        //console.log(dataRecived);
        dataRecived = JSON.parse(dataRecived);
        errors(dataRecived);
    });
}
/**
 * peticion ajax para cargar las actividades extraescolares
 * @returns {undefined}
 */
function cargarActividadesExtraescolares() {
    $.post('php/datosServidor.php', {aBuscar: "actividadesExtraescolares"},
    function(dataRecived) {
        dataRecived = JSON.parse(dataRecived);
        $('#filtro').children().remove();
        //rellenamos el select #filtro con los nombres de las asctividades
        for (var i = 0; i < dataRecived.length; i++) {
            if (i === 0) {
                cargarActividadEspecifica(dataRecived[i].codigo);
            }
            $('#filtro').append('<option value="' + dataRecived[i].codigo + '">' + dataRecived[i].nombre + '</option>');
        }
    });
}
/**
 * peticion ajax para cargar los datos de una actividad espeficica (todo, profesores y grupos incluidos)
 * @param {string} codigo codigo de la actividad extraescolar
 * @returns {undefined}
 */
function cargarActividadEspecifica(codigo) {
    var dataRecived1;
    var dataRecived2;
    $.post('php/datosServidor.php', {aBuscar: "actividadesExtraescolaresEspecifica", codigoActividad: codigo},
    function(dataRecived) {
        dataRecived1 = JSON.parse(dataRecived);
    }).done(function() {
        $.post('php/datosServidor.php', {aBuscar: "actividadExtraescolarEspecificaProfesores", codigoActividad: codigo},
        function(dataRecived) {
            dataRecived2 = JSON.parse(dataRecived);
        }).done(function() {
            $.post('php/datosServidor.php', {aBuscar: "actividadExtraescolarEspecificaGrupos", codigoActividad: codigo},
            function(dataRecived) {
                dataRecived = JSON.parse(dataRecived);
                rellenarDatosActividad(dataRecived1);
                generateProfesoresTable(dataRecived2);
                generateGruposTable(dataRecived);
            });
        });
    });
}
/**
 * funcion que a partir de los datos devueltos por el serviro rellena los campos del formulario
 * @param {JSON Array} dataRecived datos recibidos del servidor
 * @returns {undefined}
 */
function rellenarDatosActividad(dataRecived) {
    $('#nombre').val(dataRecived[0].nombre);
    $('#fecha').val(dataRecived[0].fecha_realizacion);
    $('#horaInicio').val(dataRecived[0].hora_inicio.substring(0, 5));
    $('#horaFin').val(dataRecived[0].hora_fin.substring(0, 5));
    $('#fechaAlta').val(dataRecived[0].fecha_alta);
    $('#comentarios').val(dataRecived[0].comentarios);
    $('#descripcion').val(dataRecived[0].descripcion);
    $('#objetivos').val(dataRecived[0].objetivos);
}
/**
 * generacion de la tabla de los profesores a partir de los datos devueltos por el servidor
 * @param {JSON Array} dataRecived datos recibidos del servidor
 * @returns {undefined}
 */
function generateProfesoresTable(dataRecived) {
    $('table').remove();
    //cabecera de la tabla
    $('.profesoresContainer').append('<table class="tabla datosProfesores">' +
            '<tr>' +
            '<th style="display:none">id</th>' +
            '<th>DNI</th>' +
            '<th>Primer apellido</th>' +
            '<th>Segundo apellido</th>' +
            '<th>Nombre</th>' +
            '<th>Coordinador</th>' +
            '<th>Borrar</th>' +
            '</tr>' +
            '</table>');
    for (i = 0; i < dataRecived.length; i++) {
        var checkboxLine;
        if (dataRecived[i].coordinador === '1') {
            checkboxLine = '<td>' + '<input type="radio" name="checkProfesores" checked="true" class="reducirCheckbox checkCoordinador" >' + '</td>';
        } else {
            checkboxLine = '<td>' + '<input type="radio" name="checkProfesores" class="reducirCheckbox checkCoordinador" >' + '</td>';
        }
        $('.datosProfesores').append('<tr class="lineaPorfesor">' +
                '<td style="display:none;">' + dataRecived[i].codigo + '</td>' +
                '<td>' + dataRecived[i].dni + '</td>' +
                '<td>' + dataRecived[i].apellido1 + '</td>' +
                '<td>' + dataRecived[i].apellido2 + '</td>' +
                '<td>' + dataRecived[i].nombre + '</td>' +
                checkboxLine +
                '<td>' + '<a href="#profesoresContainer" class="delProfesor"><img class="iconopequeno" src="imagenes/borrar.png"></a>' + '</td>' +
                '</tr>');
    }
}
/**
 * generacion de la tabla de los grupos a partir de los datos devueltos por el servidor
 * @param {JSON Array} dataRecived datos recibidos del servidor
 * @returns {undefined}
 */
function generateGruposTable(dataRecived) {

    //cabecera de la tabla
    $('.gruposContainer').append('<table class="tabla datosGrupos">' +
            '<tr>' +
            '<th>Codigo</th>' +
            '<th>Nombre del grupo</th>' +
            '<th>Borrar</th>' +
            '</tr>' +
            '</table>');
    for (i = 0; i < dataRecived.length; i++) {

        $('.datosGrupos').append('<tr class="lineaGrupo">' +
                '<td>' + dataRecived[i].grupo_codigo + '</td>' +
                '<td>' + dataRecived[i].grupo_nombre + '</td>' +
                '<td>' + '<a href="#gruposContainer" class="delGrupo"><img class="iconopequeno" src="imagenes/borrar.png"></a>' + '</td>' +
                '</tr>');
    }
}
