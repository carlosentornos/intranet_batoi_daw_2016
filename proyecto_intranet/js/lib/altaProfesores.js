// al cargar la página se ejecuta
$(document).ready(function () {
    rellenarDepartamentos();
    // uso de la webcam
    $('#webcam').click(function () {
        useWebcam();
    });

    $('#submit').click(function (evt) {
        evt.preventDefault();
        checkData(evt);
    });

    $('#departamento').change(function (evt) {
        evt.preventDefault();
        var depart = evt.target.value;
        fillSustitute(depart);
    });

    $('#fechadebaja, #fechadeingreso, #nacimiento, #fechaantiguedad').datepicker();//He cambiado los nombres
});

function checkData() {
    // array para recoger los errores del formulario
    var errores = [];
    var datos = [];

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

    // fecha_baja
// usar jQuery UI
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

    // domicilio particular
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

    // movil1
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

    // perfil acceso
    var perfilAcceso = $("#perfilacceso").val();
    if (checkPerfil(perfilAcceso)) {//Añadida la función al formFunctions.js
        datos.perfilAcceso = perfilAcceso;
    } else {
        errores.push("el campo perfilAcceso no puede estar vacío");
    }

    // sexo
    var sexo = $("#sexo").val();
    if (checkGender(sexo)) {
        datos.sexo = sexo.toUpperCase();
    } else {
        errores.push("el campo sexo no puede estar vacío o no debe ser más largo de 1 carácter");
    }

    // fecha_ingreso
// usar jQuery UI con datapicker
    var fechaIngreso = $("#fechadeingreso").val();
    if (checkFecha(fechaIngreso)) {//cambiar el nombre de la funcion, apuntaba a una que no existía
        datos.fechaIngreso = createEnglishDateFormat(fechaIngreso);
    } else {
        errores.push("el campo fechaIngreso no puede estar vacío");
    }

    // provincia
// es un select con options
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

    // fecha_nacimiento
// jQuery UI con datepicker
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

    var pass1 = $("#pass").val();
    var pass2 = $("#confirmacion").val();
    if (checkPassword(pass1, pass2)) {
        datos.password = pass1;
    } else {
        $("#confirmacion").focus();
        errores.push("Las contraseñas no coinciden");
    }

    datos.foto = "";

// si no hay errores entonces enviamos los datos
// comprobamos la longitud del array errores
    console.log(errores);
    if (errores.length === 0) {
        //enviamos lo datos que hay en la funcion ahora mismo, no los del formulario
        altaProf(datos);
    } else {
        console.log(errores.length);
        showErrors(errores,'errores');
    }
}

// enviamos los datos del array "datos" a la función que dará de alta estos
// a un fichero PHP
function altaProf(datos) {
    // realizar el envío por POST
    var nacDni = addNacionalidadDni(datos.dni, datos.nacionalidad);
    console.log(datos.fechaBaja);
    $.post('php/gestionAltaProfesor.php', {
        codhorario: datos.codhorario,
        nombre: datos.nombre,
        password: datos.password,
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
    function (dataReceived) {
        console.log(dataReceived);
        dataReceived = JSON.parse(dataReceived);
        var array = $.map(dataReceived, function(array) {
            return array; 
        });
        if(dataReceived.hasOwnProperty('error')){
            showErrors(array,'error');
        } else {
            showErrors(array,'ok');
            emptyFields();
        }
    });
}

function emptyFields(){
    $('#nombre').val('');
    $('#apellido1').val('');
    $('#apellido2').val('');
    $('#nacimiento').val('');
    $('#codhorario').val('');
    $('#email').val('');

    $('#dni').val('');
    
    $('#pass').val('');
    $('#confirmacion').val('');
    $('#codpostal').val('');
    $('#domicilio').val('');
    $('#domicilioparticular').val('');
    $('#provincia').val('');
    $('#municipio').val('');
    $('#telefono').val('');
    $('#telefono2').val('');
    $('#fechadeingreso').val('');
    $('#fechaantiguedad').val('');
    $('#fechadebaja').val('');
    $('#emailalumnos').val('');
    $('#sustituyea').empty();

}

function addNacionalidadDni(dni, nacionalidad) {
    if (nacionalidad == "española") {
        return "0" + dni;
    } else {
        return "X0" + dni;
    }
}

// rellenar departamentos
function rellenarDepartamentos() {
    $.post('php/datosServidor.php', {aBuscar: "cargarDepartamentos"}, function (dataRecived) {
        console.log(JSON.parse(dataRecived));
        var object = JSON.parse(dataRecived);
        //rellenamos el formulario con los datos del alumno
        console.log("entra");

        // crear bucle para añadir value y texto al option
        for (var i = 0; i < object.length; i++) {
            //$("#departamento").append("<option value='"+object[i].departa+"'>"+object[i].CLITERAL+"</option>");
            $("#departamento").append("<option value='" + object[i].CLITERAL + "'>" + object[i].CLITERAL + "</option>");
        };
    });
}

function fillSustitute(depart) {
    $.post('php/datosServidor.php', {aBuscar: "cargarProfesoresPorDepartamento", departamento: depart}, function (dataRecived) {
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
        }
        ;

    });
}




/**
 * hara visible los elementos necesarios en caso de que se use la webcam
 * @returns none
 */
function showCameraElements() {
    $("#video").show();
    $("#snap").show();
    $("#canvas").show();
    $('#divWebcam').show();
}