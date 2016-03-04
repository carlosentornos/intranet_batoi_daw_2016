var datos = [];
// para guardarnos la id seleccionada del profesor
// codigo de cuatro cifras
var buscarProfesor;

$(document).ready(function() {

    //rellena el combo de los cursos del centro
    peticionGrupos();

    //rellenar los departamentos
    rellenarDepartamentos();

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

    //buscamos datos de profesores por key presionada
    $('#buscarprofesor').keyup(function(evt) {
        var aBuscar = evt.target.value;
        peticionParcialProfesor(aBuscar);
    });

    //datepickers ui
    $('#fechadebaja, #fechadeingreso, #nacimiento, #fechaantiguedad').datepicker();
    datepickerCastellano();

});
/**
 * funcion encargada de validar los campos de los formularios
 * @returns {undefined}
 */
function checkData() {
    var errores = [];

    var codhorario = $('#codhorario').val();
    if (checkCodHorario(codhorario)) {
        datos.codhorario = codhorario;
    } else {
        errores.push("El campo codhorario no puede estar vacio y tiene que ser de 3 carácteres");
    }

    // nombre del profesor
    var nombre = $('#nombre').val();
    if (checkNameLastname(nombre)) {
        datos.nombre = nombre;
    } else {
        errores.push("el campo nombre no puede estar vacio o no debe ser más largo de 25 caracteres");
    }

    // apellidos del profesor
    // primer apellido
    var apellido1 = $("#apellido1").val();
    if (checkNameLastname(apellido1)) {
        datos.apellido1 = apellido1;
    } else {
        errores.push("el campo apellido1 no puede estar vacío o no debe ser más largo de 50 caracteres");
    }

    // segundo apellido
    var apellido2 = $("#apellido2").val();
    if (checkNameLastname(apellido2)) {
        datos.apellido2 = apellido2;
    } else {
        errores.push("el campo apellido2 no puede estar vacío o no debe ser más largo de 50 caracteres");
    }

    // dni
    var dni = $("#dni").val();
    var nacionalidad = $("#nacionalidad").val();
    if (checkDni(dni, nacionalidad)) {
        datos.dni = dni;
        datos.nacionalidad = nacionalidad;
    } else {
        errores.push("el campo dni no puede estar vacío o no debe ser más largo de 9 dígitos");
    }

    // password
// preguntar

    // email
    var email = $("#email").val();
    if (checkEmail(email)) {
        datos.email = email;
    } else {
        errores.push("el campo email no puede estar vacío o no debe ser más largo de 100 caracteres");
    }



    var fechaNacimiento = $("#nacimiento").val();
    if (checkFecha(fechaNacimiento)) {//cambiar el nombre de la funcion, apuntaba a una que no existía
        datos.fechaNacimiento = createEnglishDateFormat(fechaNacimiento);
    } else {
        errores.push("el campo fechanacimiento no puede estar vacio");
    }

    // fecha_antiguedad
// jQuery UI con datepicker
    var fechaAntiguedad = $("#fechaantiguedad").val();
    if (checkFechaNoObligatoria(fechaAntiguedad)) {//cambiar el nombre de la funcion, apuntaba a una que no existía
        if (fechaAntiguedad != "") {
            datos.fechaAntiguedad = createEnglishDateFormat(fechaAntiguedad);
        } else {
            datos.fechaAntiguedad = null;
        }
    } else {
        errores.push("el campo fecha_antiguedad no puede estar vacío");
    }


    //campo domicilio
    var domicilioParticular = $("#domicilioparticular").val();//cambiar el nombre de la id, apuntaba a una que no existía
    if (checkLenghthHundredNotRequired(domicilioParticular)) {//cambiar el nombre de la funcion, apuntaba a una que no existía
        if (domicilioParticular != "") {
            datos.domicilioParticular = domicilioParticular;
        } else {
            datos.domicilioParticular = null;
        }
    } else {
        errores.push("el campo domicilioParticular no puede estar vacío o no debe ser más largo de 100 caracteres");
    }

    // domicilio
    var domicilio = $("#domicilio").val();
    if (checkLenghthHundred(domicilio)) {//cambiar el nombre de la funcion, apuntaba a una que no existía
        datos.domicilio = domicilio;
    } else {
        errores.push("el campo domicilio no puede estar vacío o no debe ser más largo de 100 caracteres");
    }

    var provincia = $("#provincia").val();
    if (checkProvincia(provincia)) {
        datos.provincia = provincia;
    } else {
        errores.push("el campo provincia no puede estar vacío");
    }

    // municipio
// es un select con options
    var municipio = $("#municipio").val();
    if (checkMunicipio(municipio)) {
        datos.municipio = municipio;
    } else {
        errores.push("el campo municipio no puede estar vacío");
    }

    // codigo postal
    var cp = $("#codpostal").val();
    if (checkCpNoObligatorio(cp)) {//cambiar el nombre de la funcion, apuntaba a una que no existía
        if (cp != "") {
            datos.cp = cp;
        } else {
            datos.cp = null;
        }
    } else {
        errores.push("el campo cp no puede estar vacío o no debe ser más largo de 5 caracteres");
    }

    //telefono 1
    var movil1 = $("#telefono").val();
    if (checkTelefono(movil1)) {//cambiar el nombre de la funcion, apuntaba a una que no existía
        datos.movil1 = movil1;
    } else {
        errores.push("el campo movil1 no puede estar vacío o no debe ser más largo de 9 caracteres");
    }

    // movil2
    var movil2 = $("#telefono2").val();
    if (checkTelefonoNoObligatorio(movil2)) {//cambiar el nombre de la funcion, apuntaba a una que no existía
        if (movil2 != "") {
            datos.movil2 = movil2;
        } else {
            datos.movil2 = null;
        }
    } else {
        errores.push("el campo movil2 no puede estar vacío o no debe ser más largo de 9 caracteres"); // puede ser nulo en la base de datos
    }

    //fecha ingresoencentro
    var fechaIngreso = $("#fechadeingreso").val();
    if (checkFecha(fechaIngreso)) {//cambiar el nombre de la funcion, apuntaba a una que no existía
        datos.fechaIngreso = createEnglishDateFormat(fechaIngreso);
    } else {
        errores.push("el campo fechaIngreso no puede estar vacío");
    }

    // fecha de baja
    var fechaBaja = $("#fechadebaja").val();
    if (checkFechaNoObligatoria(fechaBaja)) {//cambiar el nombre de la funcion, apuntaba a una que no existía
        if (fechaBaja != "") {
            datos.fechaBaja = createEnglishDateFormat(fechaBaja);
        } else {
            datos.fechaBaja = null;
        }

    } else {
        errores.push("el campo fecha_baja tiene formato erroneo");
    }

    // email_alumnos
    var emailAlumnos = $("#emailalumnos").val();
    if (checkEmail(emailAlumnos)) {
        datos.emailAlumnos = emailAlumnos;
    } else {
        errores.push("el campo emailAlumnos no puede estar vacío o no debe ser más largo de 100 caracteres");
    }

    // departamento
    var departamento = $("#departamento").val();
    if (checkDepartamento(departamento)) {
        datos.departamento = departamento;
    } else {
        errores.push("el campo departamento no puede estar vacío o no debe ser más largo de 25 caracteres");
    }

    //campo sexo
    // sexo
    var sexo = $("#sexo").val();
    if (checkGender(sexo)) {
        datos.sexo = sexo.toUpperCase();
    } else {
        errores.push("el campo sexo no puede estar vacío o no debe ser más largo de 1 carácter");
    }


    /* ****** */


    // campo perfil de acceso
    var perfilAcceso = $("#perfilacceso").val();
    if (checkPerfil(perfilAcceso)) {//Añadida la función al formFunctions.js
        datos.perfilAcceso = perfilAcceso;
    } else {
        errores.push("el campo perfilAcceso no puede estar vacío");
    }


    var sustituye = $("#sustituyea").val();
    if (checkSustituye(sustituye)) {
        if (sustituye != "Seleccione un sustituto") {
            datos.sustituye = sustituye;
        } else {
            datos.sustituye = null;
        }
    } else {
        errores.push("Error en el campo sustituye");
    }
    datos.foto = "";


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
 * peticion ajax para modificar los datos del formulario
 * @param {array} datos datos del formulario introducidos por el usuario
 * @returns {undefined}
 */
function modDatos(datos) {
    var nacDni = addNacionalidadDni(datos.dni, datos.nacionalidad);
    console.log(datos.repite);
    $.post('php/gestionDirModProf.php', {//fichero PHP a enviar los datos del formulario
        /* ** CARLOS ** */
        codigo: buscarProfesor,
        codhorario: datos.codhorario,
        nombre: datos.nombre,
        apellido1: datos.apellido1,
        apellido2: datos.apellido2,
        dni: nacDni,
        email: datos.email,
        emailAlumnos: datos.emailAlumnos,
        departamento: datos.departamento,
        fechaBaja: datos.fechaBaja,
        domicilioParticular: datos.domicilioParticular,
        domicilio: datos.domicilio,
        movil1: datos.movil1,
        movil2: datos.movil2,
        perfilAcceso: datos.perfilAcceso,
        sexo: datos.sexo,
        fechaIngreso: datos.fechaIngreso,
        provincia: datos.provincia,
        municipio: datos.municipio,
        cp: datos.cp,
        fechaNacimiento: datos.fechaNacimiento,
        fechaAntiguedad: datos.fechaAntiguedad,
        sustituye: datos.sustituye,
        foto: datos.foto
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
 * funcion encargada de vaciar los campos
 * @returns {undefined}
 */
function emptyFields() {
    $('#fecha').val('');
    $('#fechaFin').val('');
    $('#buscarprofesor').val('');
    $('#comentarios').val('');
    $('#horas').val('');
    $('#profesorado').empty();
    $('#box').remove();
}
/**
 * forma el dni dependiendo de la nacionalidad para su insertacion en la base de datos
 * @param {string} dni dni basico
 * @param {string} nacionalidad nacionalidad seleccionada en el formulario
 * @returns {String} dni formado
 */
function addNacionalidadDni(dni, nacionalidad) {
    if (nacionalidad == "española") {
        return "0" + dni;
    } else {
        return "X0" + dni;
    }
}
/**
 * peticion ajax para recoger los datos de un profesor 
 * @param {type} id codigo del profesor a buscar
 * @returns {undefined}
 */
function rellenarDatosProfesores(id) {
    $.post('php/datosServidor.php', {aBuscar: "perfilProfesorDireccion", id: id}, function(dataRecived) {
        console.log(JSON.parse(dataRecived));
        var object = JSON.parse(dataRecived);
        //rellenamos el formulario con los datos del alumno

        $('#nombre').val(object[0].nombre);
        $('#apellido1').val(object[0].apellido1);
        $('#apellido2').val(object[0].apellido2);
        $('#email').val(object[0].email);
        $('#codhorario').val(object[0].cod_horario);
        if (object[0].dni.charAt(0) === 'X') {
            $('#dni').val(object[0].dni.substr(2, 10));
            $('#nacionalidad').val('extrangera');
        } else {
            $('#dni').val(object[0].dni.substr(1, 10));
            $('#nacionalidad').val('española');
        }

        //las fechas vienen del servidor en formato (aaaa-mm-dd)
        var fecha = new Date(object[0].fecha_nac);
        //$('#nacimiento').val(fecha.getDate() + "/" + parseInt(fecha.getMonth() + 1) + "/" + fecha.getFullYear());
        $('#nacimiento').val(createSpanishDateFormat(fecha));

        var fecha = new Date(object[0].fecha_ingreso);
        //$('#fechadeingreso').val(fecha.getDate() + "/" + parseInt(fecha.getMonth() + 1) + "/" + fecha.getFullYear());
        $('#fechadeingreso').val(createSpanishDateFormat(fecha));

        var fecha = new Date(object[0].fecha_antiguedad);
        //$('#fechaantiguedad').val(fecha.getDate() + "/" + parseInt(fecha.getMonth() + 1) + "/" + fecha.getFullYear());
        $('#fechaantiguedad').val(createSpanishDateFormat(fecha));

        var fecha = new Date(object[0].fecha_baja);
        //$('#fechadebaja').val(fecha.getDate() + "/" + parseInt(fecha.getMonth() + 1) + "/" + fecha.getFullYear());
        $('#fechadebaja').val(createSpanishDateFormat(fecha));

        $('#codpostal').val(object[0].cod_postal);
        $('#domicilio').val(object[0].domicilio);
        $('#telefono').val(object[0].movil1);
        $('#telefono2').val(object[0].movil2);
        $('#provincia').val(object[0].provincia);
        $('#municipio').val(object[0].municipio);

        $('#emailalumnos').val(object[0].email_alumnos);
        $('#perfilacceso').val(object[0].perfil_acceso.toLowerCase());
        $('#domicilioparticular').val(object[0].domicilio_particular);

        if (object[0].sexo === "H") {
            $('#sexo').val("h"); //hombre
        } else {
            $('#sexo').val("m"); //mujer
        }

        // añado el departamento
        $("#departamento").val(object[0].CLITERAL);

    });
}
/**
 * peticion ajax para recibir los datos del profesor a buscar
 * @param {string} cadena cadena de caracteres (apellido1)
 * @returns {undefined}
 */
function peticionParcialProfesor(cadena) {
    $.post('php/datosServidor.php', {aBuscar: "parcialProfesor", id: cadena}, function(dataRecived) {
        console.log(JSON.parse(dataRecived));
        var dataRecived = JSON.parse(dataRecived);
        $('#box').show();
        $('#ulProfeContainer').empty();
        for (i = 0; i < dataRecived.length; i++) {
            $('#ulProfeContainer').append('<li>' + dataRecived[i].codigo + " // " + dataRecived[i].dni + ' // ' + dataRecived[i].apellido1 + ', ' + dataRecived[i].apellido2 + ', ' + dataRecived[i].nombre + '</li>');
            //$('#ulAlumnContainer').append('<li>'+dataRecived+'</li>');
        }
        //mirar la forma mas optima para anyadir los listener, quizas ponerselo a todo cada loop no es lo mas optimo
        $('#ulProfeContainer li').click(function() {
            //le enviamos el id a la funcion para coger todos los datos de los alumnos
            buscarProfesor = $(this).text().split(' ')[0];
            rellenarDatosProfesores(buscarProfesor);
            // otra funcion para cargar los profesores del mismo departamento
            rellenarProfesoresDepartamentos(buscarprofesor);
            $('#box').hide();
        });
    });
}

/**
 * peticion ajax para los datos de los departamentos
 * @returns {undefined}
 */
function rellenarDepartamentos() {
    $.post('php/datosServidor.php', {aBuscar: "cargarDepartamentos"}, function(dataRecived) {
        console.log(JSON.parse(dataRecived));
        var object = JSON.parse(dataRecived);
        //rellenamos el formulario con los datos del alumno
        
        // crear bucle para añadir value y texto al option
        for (var i = 0; i < object.length; i++) {
            $("#departamento").append("<option value='" + object[i].CLITERAL + "'>" + object[i].CLITERAL + "</option>");
        };
    });
}
/**
 * peticion ajax para rellenar los profesores que pertenecen a un departament
 * @returns {undefined}
 */
function rellenarProfesoresDepartamentos() {
    $.post('php/datosServidor.php', {aBuscar: "cargarProfesoresDepartamento", id: buscarProfesor}, function(dataRecived) {
        console.log(JSON.parse(dataRecived));
        var object = JSON.parse(dataRecived);
        //rellenamos el formulario con los datos del alumno
        console.log("entra");
        // limpiamos los options
        $("#sustituyea").empty();
        // primer option lo ponemos vacío
        $("#sustituyea").append("<option>Seleccione un sustituto</option>");
        // crear bucle para añadir value y texto al option
        for (var i = 0; i < object.length; i++) {
            $("#sustituyea").append("<option value='" + object[i].codigo + "'>" + object[i].apellido1 + " " + object[i].apellido2 + ", " + object[i].nombre + "</option>");
        };
    });
}


