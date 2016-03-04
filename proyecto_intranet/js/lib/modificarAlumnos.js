var datos = [];
var gruposNuevos = [];
var idAlumnoRellenado;
$(document).ready(function() {

    //listener para los links de anyadir y borrar grupos
    $('body').on('click', 'a.borrarGrupo', function() {
        $(this).parent().remove();
    });

    $('body').on('click', 'a.anadirGrupo', function() {
        duplicarSelectGrupo();
    });

    $('body').on("click", 'li', function() {
        //le enviamos el id a la funcion para coger todos los datos de los alumnos
        var buscarAlumno = $(this).text().split(' ')[0];
        $('.grupoContainer').not(':first').remove();
        rellenarDatosAlumnos(buscarAlumno);
        $('#box').hide();
    });

    //rellena el combo de los cursos del centro
    peticionGrupos();

    //funcionalidad webcam
    $('#webcam').click(function() {
        useWebcam();//esta funcion asigna la imagen en base64 a la variable imagen
    });

    //por defecto el enter ejecuta el acion del formulario, no queremos eso
    $('#form').keydown(function(evt) {
        if (evt.which === 13) {
            evt.preventDefault();
            checkData();
        }
    });

    $('#submit').click(function(evt) {
        evt.preventDefault();
        checkData(evt);
    });

    //buscamos datos de alumnos por key presionada
    $('#buscaralumno').keyup(function(evt) {
        var aBuscar = evt.target.value;
        peticionParcialAlumno(aBuscar);
    });

    //datepickers ui
    $('#nacimiento, #fechaingresoencentro, #fechamatricula').datepicker();
    datepickerCastellano();

});
/**
 * funcion que valida los datos del formulario
 * @returns {undefined}
 */
function checkData() {
    var errores = [];

    //campo nombre
    var nombre = $('#nombre').val();
    if (checkNameLastname(nombre)) {
        datos.nombre = nombre.toUpperCase();
    } else {
        errores.push("el campo nombre no puede estar vacio o no debe ser mas largo de 25 caracteres");
    }
    //apellido1
    var apellido1 = $('#apellido1').val();
    if (checkNameLastname(apellido1)) {
        datos.apellido1 = apellido1.toUpperCase();
    } else {
        errores.push("el campo apellido1 no puede estar vacio o no debe ser mas largo de 25 caracteres");
    }

    //apellido2
    var apellido2 = $('#apellido2').val();
    if (checkNameLastname(apellido2)) {
        datos.apellido2 = apellido2.toUpperCase();
    } else {
        errores.push("el campo apellido2 no puede estar vacio o no debe ser mas largo de 25 caracteres");
    }

    //campo email
    var email = $('#email').val();
    if (checkEmail(email)) {
        datos.email = email;
    } else {
        errores.push("el formato del correco electrónico introducido no es correcto");
    }

    //campo dni
    var dni = $('#dni').val();
    var nacionalidad = $('#nacionalidad').val();
    if (checkDni(dni, nacionalidad)) {
        if (nacionalidad === "española") {
            dni = "0" + dni;
        } else {
            dni = "X0" + dni;
        }
        datos.dni = dni;
    } else {
        errores.push('El formato de DNI introducido no es correcto');
    }

    //campo nia
    var nia = $('#nia').val();
    if (checkNia(nia)) {
        datos.nia = nia;
    } else {
        errores.push('El formato de NIA introducido no es correcto');
    }

    //campo nacimiento, PREGUNTAR A JUAN SOBRE hacer un new date
    var fechaNacimiento = $('#nacimiento').val();
    if (checkFecha(fechaNacimiento)) {
        datos.fechaNacimiento = createEnglishDateFormat(fechaNacimiento);
    } else {
        errores.push('La fecha introducida no es correcta');
    }

    //campo expediente, tenemos que permitir cualquier cosa.... los datos de itaca pueden estar mal
    var expediente = $('#expediente').val();
    datos.expediente = expediente;

    //campo codigo postal, hay cp's con 4 digitos que vienen desde itaca
    var cp = $('#codpostal').val();
    if (checkCp(cp)) {
        datos.cp = cp;
    } else {
        errores.push('el codigo postal no puede estar vacio y deben ser 4 numeros');
    }

    //campo domicilio
    var domicilio = $('#domicilio').val();
    if (checkLenghthHundred(domicilio)) {
        datos.domicilio = domicilio.toUpperCase();
    } else {
        errores.push('el domicilio no puede estar vacio ni superar los 100 caracteres de longitud');
    }

    //campo provincia
    var provincia = $('#provincia').val();
    if (checkLenghthHundred(provincia)) {
        datos.provincia = provincia.toUpperCase();
    } else {
        errores.push('el domicilio no puede estar vacio ni superar los 100 caracteres de longitud');
    }

    //campo municipio
    var municipio = $('#municipio').val();
    if (checkLenghthHundred(municipio)) {
        datos.municipio = municipio.toUpperCase();
    } else {
        errores.push('el municipio no puede estar vacio ni superar los 100 caracteres de longitud');
    }

    //telefono 1
    var telefono1 = $('#telefono').val();
    if (checkTelefono(telefono1)) {
        datos.telefono1 = telefono1;
    } else {
        errores.push('los telefonos deben tener 9 digitos');
    }

    //telefono 2
    var telefono2 = $('#telefono2').val();
    if (checkTelefonoNoObligatorio(telefono2)) {
        if(telefono2!=""){
            datos.telefono2 = telefono2;
        }else{
            datos.telefono2 = null;
        }
    } else {
        errores.push('los telefonos deben tener 9 digitos');
    }

    //fecha matricula
    var fechaMatricula = $('#fechamatricula').val();
    if (checkFecha(fechaMatricula)) {
        datos.fechaMatricula = fechaMatricula;
        datos.fechaMatricula = createEnglishDateFormat(fechaMatricula);
    } else {
        errores.push('la fecha de matricula no tiene un formato correcto (dd-mm-aaaa)');
    }

    //fecha ingresoencentro
    var fechaingresoencentro = $('#fechaingresoencentro').val();
    if (checkFecha(fechaingresoencentro)) {
        datos.fechaingresoencentro = createEnglishDateFormat(fechaingresoencentro);
    } else {
        errores.push('la fecha de ingrso en el centro no tiene un formato correcto (dd-mm-aaaa)');
    }

    //campo estado matricula
    var estadoMatricula = $('#estadomatricula').val();
    if (checkEstadoMatricula(estadoMatricula)) {
        datos.estadoMatricula = estadoMatricula.charAt(0).toUpperCase();
    } else {
        errores.push("El estado de la matricula solo puede ser Matriculado o Baja");
    }

    //campo repite
    var repite = $('#repite').val();
    if (checkRepite(repite)) {
        if (datos.repite === 'si') {
            datos.repite = '0';
        } else {
            datos.repite = '1';
        }
    } else {
        errores.push('El campo Repite curso solo puede ser Si o No');
    }

    //campo turno
    var turno = $('#turno').val();
    if (checkTurno(turno)) {
        datos.turno = turno.toUpperCase();
    } else {
        errores.push('El campo turno solo puede ser Diurno, Nocturno o Semipresencial');
    }

    //campo trabajo
    var trabajo = $('#trabaja').val();
    if (checkTrabaja(trabajo)) {
        datos.trabajo = trabajo.toUpperCase();
    } else {
        errores.push('El campo Trabajo curso solo puede ser Si o No');
    }

    //campo sexo
    var sexo = $('#sexo').val();
    if (checkGender(sexo)) {
        datos.sexo = sexo.toUpperCase();
    } else {
        errores.push('El campo Sexo curso solo puede Hombre o Mujer');
    }

    //campo observaciones
    var observaciones = $('#observaciones').val();
    if (checkObservaciones(observaciones)) {
        datos.observaciones = observaciones.toUpperCase();
    } else {
        errores.push('El campo observaciones no puede exceder XXX caracteres de longitud');
    }

    gruposNuevos = [];
    datos.grupos = gruposNuevos;
    $('.grupo').each(function() {
        gruposNuevos.push($(this).val());
    });
    datos.grupos = gruposNuevos;

    if (errores.length === 0) {
        //enviamos lo datos que hay en la funcion ahora mismo, no los del formulario
        modDatos(datos);
    } else {
        showErrors(errores, 'errores');
    }
   

    console.log(errores.length);
    console.log(errores);

}
/**
 * peticion ajax para enviar los datos del formulario al servidor
 * @param {Array} datos datos del formulario
 * @returns {undefined}
 */
function modDatos(datos) {

    console.log(datos.repite);
    $.post('php/gestionDirModAlum.php', {
        id: idAlumnoRellenado,
        nombre: datos.nombre,
        apellido1: datos.apellido1,
        apellido2: datos.apellido2,
        email: datos.email,
        dni: datos.dni,
        nia: datos.nia,
        nacimiento: datos.fechaNacimiento,
        expediente: datos.expediente,
        codpostal: datos.cp,
        domicilio: datos.domicilio,
        municipio: datos.municipio,
        provincia: datos.provincia,
        telefono1: datos.telefono1,
        telefono2: datos.telefono2,
        fechamatricula: datos.fechaMatricula,
        fechaingresocentro: datos.fechaingresoencentro,
        estadomatricula: datos.estadoMatricula,
        repite: datos.repite,
        turno: datos.turno,
        trabaja: datos.trabajo,
        sexo: datos.sexo.toUpperCase(),
        observaciones: datos.observaciones,
        gruposNuevos: datos.grupos,
        foto: ''
    },
    function(dataRecived) {
        dataRecived = JSON.parse(dataRecived);
        var array = $.map(dataRecived, function(array) {
            return array;
        });
        if (dataRecived.hasOwnProperty('error')) {
            showErrors(array, 'error');
        } else {
            showErrors(array, 'ok');
        }
    });
}

/**
 * esta funcion existe en formFunctions.js, ha sido necesario duplicarla con una modificacion para evitar un problema al cargar los grupos de los alumnos si tenian mas de uno
 * @returns {undefined}
 */

function duplicarSelectGrupoAuxiliar() {
    var nextGroupSelect = $('.grupoContainer:last').clone();
    nextGroupSelect.find('select').attr('id', '').addClass('grupo reducir_select');
    nextGroupSelect.find('a').attr('class', 'borrarGrupo');
    nextGroupSelect.find('label').text('.').css('visibility', 'hidden');
    nextGroupSelect.find('img').attr('src', 'imagenes/borrar.png');
    $('.grupoContainer:last').after(nextGroupSelect);
}
/**
 * rellena el formulario con los datos del alumno seleccionado
 * @param {type} id
 * @returns {undefined}
 */
function rellenarDatosAlumnos(id) {
    $.post('php/datosServidor.php', {aBuscar: "perfilAlumnoDireccion", id: id}, function(dataRecived) {
        console.log(JSON.parse(dataRecived));
        var object = JSON.parse(dataRecived);
        idAlumnoRellenado = object[0].id;
        //rellenamos el formulario con los datos del alumno
        $('#nombre').val(object[0].nombre);
        $('#apellido1').val(object[0].apellido1);
        $('#apellido2').val(object[0].apellido2);
        $('#email').val(object[0].email);

        if (object[0].dni.charAt(0) === 'X') {
            $('#dni').val(object[0].dni.substr(2, 10));
            $('#nacionalidad').val('extrangera');
        } else {
            $('#dni').val(object[0].dni.substr(1, 10));
            $('#nacionalidad').val('española');
        }

        $('#nia').val(object[0].nia);
        $('#expediente').val(object[0].expediente);

        //las fechas vienen del servidor en formato (aaaa-mm-dd)
        var fecha = new Date(object[0].fecha_nac);
        $('#nacimiento').val(createSpanishDateFormat(fecha));
        var fecha = new Date(object[0].fecha_matricula);
        $('#fechamatricula').val(createSpanishDateFormat(fecha));
        var fecha = new Date(object[0].fecha_ingreso_centro);
        $('#fechaingresoencentro').val(createSpanishDateFormat(fecha));

        $('#codpostal').val(object[0].cod_postal);
        $('#domicilio').val(object[0].domicilio);
        $('#telefono').val(object[0].telefono1);
        $('#telefono2').val(object[0].telefono2);
        $('#provincia').val(object[0].provincia);
        $('#municipio').val(object[0].municipio);

        if (object[0].estado_matricula === 'B') {
            $('#estadomatricula').val('b');
        } else if (object[0].estado_matricula === 'M') {
            $('#estadomatricula').val('m');
        }

        if (object[0].repite === "1") {
            $('#repite').val("s");
        } else {
            $('#repite').val("n");
        }

        $('#turno').val(object[0].turno.toLowerCase());
        $('#trabaja').val(object[0].trabaja.toLowerCase());

        if (object[0].sexo === "H") {
            $('#sexo').val("h");
        } else {
            $('#sexo').val("m");
        }

        $('#observaciones').val(object[0].observaciones);
        $('.grupo').not(':first').remove();
    }).done(function() {
        $.post('php/datosServidor.php', {aBuscar: "gruposAlumno", id: idAlumnoRellenado}, function(dataRecived) {
            dataRecived = JSON.parse(dataRecived);
            console.log(dataRecived);

            $('#grupo').addClass('reducir_select');
            for (i = 1; i < dataRecived.length; i++) {
                duplicarSelectGrupoAuxiliar();
            }

            if (dataRecived.length !== 0) {
                $('.grupo').each(function(index) {
                    $(this).val(dataRecived[index].nombre);
                });
            }
        });
    });
}


