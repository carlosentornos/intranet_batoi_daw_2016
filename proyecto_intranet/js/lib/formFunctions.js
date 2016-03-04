function checkNameLastname(string) {
    if (string.length > 25 || string === "") {
        return false;
    } else {
        return true;
    }
}

function checkEmail(email) {
    // enlace con los emails soportados e informacion https://en.wikipedia.org/wiki/Email_address
    var pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return pattern.test(email);
}

function checkDni(dni, nacionalidad) {
    if (nacionalidad === "española") {
        var patternDni = /^\d{8}[a-zA-Z]$/;
        var check = new RegExp(patternDni);
        return check.test(dni);
    } else {
        var patternDni = /^\d{7}[a-zA-Z]$/;
        var check = new RegExp(patternDni);
        return check.test(dni);
    }
}

function checkNia(nia) {
    var patternNia = /^\d{8}$/;
    var check = new RegExp(patternNia);
    return check.test(nia);
}

function checkPassword(pass1, pass2) {
    if (pass1 === "" || pass2 === "") {
        return false;
    } else if (pass1 !== pass2) {
        return false;
    } else {
        return true;
    }
}

function checkGender(string) {
    string = string.toUpperCase();
    if (string !== 'M' && string !== 'H') {
        return false;
    } else {
        return true;
    }
}

function checkGrupo(string) {//de momento que no este en blanco
    if (string === "") {
        return false;
    } else {
        return true;
    }
}

function checkCp(postalCode) {
    var pattern = /^\d{5}$/;
    var check = new RegExp(pattern);
    return check.test(postalCode);
}

function checkCpNoObligatorio(postalCode) {
    if (postalCode != "") {
        var pattern = /^\d{5}$/;
        var check = new RegExp(pattern);
        return check.test(postalCode);
    } else {
        return true;
    }
}

function checkLenghthHundred(string) {
    if (string.length > 100 || string.length === 0) {//habra que tener en cuenta de que habra calles mas largas, habra que cambiarlo en un futuro
        return false;
    } else {
        return true;
    }
}

function checkLenghthHundredNotRequired(string) {
    if (string != "") {
        if (string.length > 100 || string.length === 0) {//habra que tener en cuenta de que habra calles mas largas, habra que cambiarlo en un futuro
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkProvincia(provincia) {
    if (provincia.length > 100 || provincia.length === 0) {// lo mismo, habra que mirar si hay que poner mas length
        return false;
    } else {
        return true;
    }
}

function checkProvinciaNoObligatorio(provincia) {
    if (provincia != "") {
        if (provincia.length > 100 || provincia.length === 0) {// lo mismo, habra que mirar si hay que poner mas length
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkMunicipio(municipio) {
    if (municipio.length > 100 || municipio.length === 0) {
        return false;
    } else {
        return true;
    }
}

function checkMunicipioNoObligatorio(municipio) {
    if (municipio != "") {
        if (municipio.length > 100 || municipio.length === 0) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkFecha(fecha) {
    //console.log(fecha);
    var test = new Date(createEnglishDateFormat(fecha));
    //console.log(test);
//    if (!test || fecha.length === 0) {
    if (isNaN(test.getTime())) {
        return false;
    } else {
        return true;
    }
}

function checkFechaNoObligatoria(fecha) {
    //console.log(fecha);
    var test = new Date(createEnglishDateFormat(fecha));
    //console.log(test);
//    if (!test || fecha.length === 0) {
    if (fecha.length != 0) {
        if (isNaN(test.getTime())) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkTelefono(telefono) {
    var pattern = /^\d{9}$/;
    var check = new RegExp(pattern);
    return check.test(telefono);
}

function checkTelefonoNoObligatorio(telefono) {
    if (telefono != "") {
        var pattern = /^\d{9}$/;
        var check = new RegExp(pattern);
        return check.test(telefono);
    } else {
        return true;
    }
}

function checkEstadoMatricula(string) {
    if (string !== "m" && string !== "b") {
        return false;
    } else {
        return true;
    }
}

function checkRepite(string) {
    if (string !== "s" && string !== "n") {
        return false;
    } else {
        return true;
    }
}

function checkTurno(string) {
    if (string !== "n" && string !== "d" && string !== "s") {
        return false;
    } else {
        return true;
    }
}

function checkTrabaja(string) {
    if (string !== "s" && string !== "n") {
        return false;
    } else {
        return true;
    }
}

function checkObservaciones(string) {
    if (string.length !== 100) {//hay que mirar el length
        return true;
    } else {
        return false;
    }
}

function checkDepartamento(string) {
    if (string !== "") {
        return true;
    } else {
        return false;
    }
}

function checkNombreActividad(string) {
    if (string === "" || string.length > 50) {
        return false;
    } else {
        return true;
    }
}

function checkTimeFormat(string) {
    var pattern = /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/;
    return pattern.test(string);
}

function createEnglishDateFormat(date) {
    //hacer un split a mano para formar el date ingles
    var date = new Date(date);
    var anyo = date.getFullYear();
    var mes = parseInt(date.getMonth() + 1);
    if (mes < 10) {
        mes = "0" + mes;
    }
    var dia = date.getDate();
    if (dia < 10) {
        dia = "0" + dia;
    }
    var fecha = (anyo + "-" + mes + "-" + dia);
    return fecha;
}

function createSpanishDateFormat(date) {
    var date = new Date(date);
    var anyo = date.getFullYear();
    var mes = parseInt(date.getMonth() + 1);
    if (mes < 10) {
        mes = "0" + mes;
    }
    var dia = date.getDate();
    if (dia < 10) {
        dia = "0" + dia;
    }
    var fecha = (dia + "/" + mes + "/" + anyo);
    return fecha;
}

function checkHoras(horas) {
    if (horas > 0) {
        return true;
    } else {
        return false;
    }
}

function checkActivo(string) {
    if (string !== "S" && string !== "N") {
        return false;
    } else {
        return true;
    }
}

function checkProfesorado(string) {
    if (string !== "") {
        return true;
    } else {
        return false;
    }
}

function checkPerfil(string) {
    if (string != "" && (string == "profesor" || string == "direccion")) {
        return true;
    } else {
        return false;
    }
}

function checkCodHorario(string) {
    if (string != "" && (parseInt(string) >= 100 && parseInt(string) <= 999)) {
        return true;
    } else {
        return false;
    }
}

function checkSustituye(string) {
    if (string != "") {
        return true;
    } else {
        return false;
    }
}

function showErrors(array, msgType) {
    //quitamos el div de errores si ya hay uno
    $('#submit').next('.errores').remove();
    //ponemos uno nuevo
    $('#submit').after('<div class="errores"></div>');

    for (i = 0; i < array.length; i++) {
        if (msgType === 'ok') {
            $('.errores').append('<p class="verde">' + array[i] + '</p>');
        } else {
            $('.errores').append('<p class="rojo">' + array[i] + '</p>');
        }
    }
}

function duplicarSelectGrupo() {
    if ($('.grupoContainer:last').find('select').val() !== '-- Seleciona --') {
        var nextGroupSelect = $('.grupoContainer:last').clone();
        nextGroupSelect.find('select').attr('id', '').addClass('grupo reducir_select');
        nextGroupSelect.find('a').attr('class', 'borrarGrupo');
        nextGroupSelect.find('label').text('.').css('visibility', 'hidden');
        nextGroupSelect.find('img').attr('src', 'imagenes/borrar.png');
        $('.grupoContainer:last').after(nextGroupSelect);
    } else {

    }
}

function peticionParcialAlumno(cadena) {
    $.post('php/datosServidor.php', {aBuscar: "parcialAlumno", id: cadena}, function(dataRecived) {
        console.log(JSON.parse(dataRecived));
        var dataRecived = JSON.parse(dataRecived);
        $('#box').show();
        $('#ulAlumnContainer').empty();
        for (i = 0; i < dataRecived.length; i++) {
            $('#ulAlumnContainer').append('<li>' + dataRecived[i].id + " // " + dataRecived[i].dni + ' // ' + dataRecived[i].apellido1 + ', ' + dataRecived[i].apellido2 + ', ' + dataRecived[i].nombre + '</li>');
            //$('#ulAlumnContainer').append('<li>'+dataRecived+'</li>');
        }
    });
}

function peticionParcialProfesor(cadena) {

    $.post('php/datosServidor.php', {aBuscar: "parcialProfesor", id: cadena}, function(dataRecived) {
        console.log(JSON.parse(dataRecived));
        var dataRecived = JSON.parse(dataRecived);
        $('#box').show();
        $('#ulProfContainer').empty();
        for (i = 0; i < dataRecived.length; i++) {
            $('#ulProfContainer').append('<li>' + dataRecived[i].codigo + " // " + dataRecived[i].dni + ' // ' + dataRecived[i].apellido1 + ', ' + dataRecived[i].apellido2 + ', ' + dataRecived[i].nombre + '</li>');
        }
    });
}

function peticionGrupos() {
    $().ready(function() {
        $.post('php/datosServidor.php', {aBuscar: "grupo"}, function(dataRecived) {
            console.log(JSON.parse(dataRecived));
            var grupos = JSON.parse(dataRecived);
            var appendedTo = $('#grupo');
            appendedTo.addClass('grupo');
            appendedTo.append("<option>" + "-- Seleciona --" + "</option>");
            for (i = 0; i < grupos.length; i++) {
                appendedTo.append("<option>" + grupos[i].nombre + "</option>"); // modificado 24-02-2016
            }
        });
    });
}

function datepickerCastellano() {
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: 'Anterior',
        nextText: 'Siguiente',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };

    $.datepicker.setDefaults($.datepicker.regional['es']);
}

// LIMITAR LONGITUDES PARA FORMULARIO COMISION DE SERVICIO
function checkServicios(servicios){
    var longitud = servicios.length;
    if((longitud > 200)||(servicio=="")){
        return false;
    }else{
        return true;
    }
}
// LIMITAR LONGITUDES PARA FORMULARIO COMISION DE SERVICIO
// alojamiento, comida, otros gastos
function checkDietas(dieta){
    var longitud = dieta.length;
    if(longitud > 40){
        return false;
    }else{
        return true;
    }   
}

function checkMedioLocomocion(medio){
    var longitud = medio.length;
    if((longitud > 40)||(medio=="")){
        return false;
    }else{
        return true;
    }   
}
// LIMITAR LONGITUDES PARA FORMULARIO COMISION DE SERVICIO
function checkMarcaVehiculo(vehiculo){
    var longitud = vehiculo.length;
    if((longitud > 18)||(vehiculo=="")){
        return false;
    }else{
        return true;
    }   
}
// LIMITAR LONGITUDES PARA FORMULARIO COMISION DE SERVICIO
function checkMatriculaVehiculo(matricula){
    var longitud = matricula.length;
    if((longitud > 10)||(matricula=="")){
        return false;
    }else{
        return true;
    }   
}
// COMPROBAR SI PONEN UN NUMERO O NO
// EN CERTIFICADO DE RIESGOS LABORALES
function checkHorasRiesgos(horas){
    if((isNaN(horas))||(horas=="")){
        return false;
    }else{
        return true;
    }
}
function checkTituloRiesgos(titulo){
    if(titulo!==""){
        return true;
    }else{
        return false;
    }
}