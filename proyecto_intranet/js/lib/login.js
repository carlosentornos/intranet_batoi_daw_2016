//login

$(document).ready(function() {

    $("#btnLogin").click(function(evt) {
        evt.preventDefault();
        CheckData();
    });

});
/**
 * funcion encargada de validar los datos del formulario
 * @returns {undefined}
 */
function CheckData() {
    var usuario = $("#loginUser").val();
    var passwd = $("#passUser").val();

    if (usuario !== "" && passwd !== "") {
        //datos rellenados, se envian al servidor
        //console.log("datos rellenados");
        SendDataToServer(usuario, passwd);
    } else {
        getError("Los campos no pueden estar vacios. Revise y vuelva a intentarlo.");
    }
}
/**
 * manda los datos del login al servidor y carga la url necesaria
 * @param {string} usuario usuario introducido
 * @param {string} passwd password introducido
 * @returns {undefined}
 */
function SendDataToServer(usuario, passwd) {
    console.log('ready to send data');
    $.post("php/gestionLogin.php", {usuario: usuario, pass: passwd}).done(function(data) {

        var test = data.substr(data.length - 4);
        if (test === ".php") {
            window.location.assign(data);
        } else {
            getError(data);
        }

    });
}

function getError(data) {
    $("#errors").empty();
    $("#errors").append("<p>" + data + "</p>").show();
}
