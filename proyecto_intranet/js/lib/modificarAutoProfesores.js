
$(document).ready(function() {

    rellenarDatosProfesores();

    //funcionalidad webcam
    $('#webcam').click(function() {
        useWebcam();
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

});
/**
 * funcion encargada de validar los datos del formulario
 * @returns {undefined}
 */
function checkData() {
    var errores = [];
    var datos = [];

    //campo email
    var email = $('#email').val();
    if (checkEmail(email)) {
        datos.email = email;
    } else {
        errores.push("el formato del correco electrónico introducido no es correcto");
    }
    
    var emailForAlumnos = $('#emailalumnos').val();
    if (checkEmail(emailForAlumnos)) {
        datos.emailForAlumnos = emailForAlumnos;
    } else {
        errores.push('El correo electronico para los alumnos no tiene el formato correcto');
    }

    //no hay que comprobar nada respecto
    var oldPassword = $('#antiguapass').val();
    datos.oldPass = oldPassword;
    
    var newPass = $('#pass').val();
    var confirmacion = $('#confirmacion').val();
    
    console.log(newPass,confirmacion);
    if (checkPassword(newPass,confirmacion)) {
        datos.newPass = newPass;
    } else {
        errores.push('Las contraseñas no coinciden');
    }
    
    if (errores.length === 0) {
        //enviamos lo datos que hay en la funcion ahora mismo, no los del formulario
        modDatos(datos);
    } else {
        showErrors(errores,'error');
    }

    console.log(errores.length);
    console.log(errores);
}

/**
 * peticion ajax para modificar los datos del formulario
 * @param {Array} datos datos del formulario a enviar
 * @returns {undefined}
 */
function modDatos(datos) {

    $.post('php/gestionPerfilProfesor.php', {
        email: datos.email,
        emailForAlumnos: datos.emailForAlumnos,
        foto: '',
        oldPass: datos.oldPass,
        newPass: datos.newPass
    },
    function(dataRecived) {
        dataRecived = JSON.parse(dataRecived);
        var array = $.map(dataRecived, function(array) {
            return array; 
        });
        if(dataRecived.hasOwnProperty('error')){
            showErrors(array,'error');
        } else {
            showErrors(array,'ok');
        }
        
    });
}
/**
 * peticion ajax para pedir los datos del profesor logueado
 * @returns {undefined}
 */
function rellenarDatosProfesores() {
    $.post('php/datosServidor.php', {aBuscar: "autoProfesor"}, function(dataRecived) {
        console.log(JSON.parse(dataRecived));
        var object = JSON.parse(dataRecived);
        $('#email').val(object[0].email);
        $('#emailalumnos').val(object[0].email_alumnos);
    });
}




