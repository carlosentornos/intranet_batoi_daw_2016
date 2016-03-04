// variables globales
var datos = [];

// al cargar la página se ejecuta
$(document).ready(function () {

    //mirar la forma mas optima para anyadir los listener, quizas ponerselo a todo cada loop no es lo mas optimo
    $('body').on("click", "li", function () {
        //le enviamos el id a la funcion para coger todos los datos de los alumnos
        profesor = $(this).text();
        if ($('#profesorado').children().length === 0) {
            anyadirProfesorLista(profesor);
        } else {
            var repetido = false;
            //por cada div acompanyante
            $('.listaProfesorado').each(function () {
                if ($(this).val() === profesor) {
                    repetido = true;
                }
            });
            if (!repetido) {
                anyadirProfesorLista(profesor);
            }
        }
    });


    //buscamos datos de profesores por key presionada
    $('#buscarprofesor').keyup(function (evt) {
        var aBuscar = evt.target.value;
        peticionParcialProfesor(aBuscar);
    });

    $('#submit').click(function (evt) {
        evt.preventDefault();
        checkData(evt);
    });

    $('#fecha, #fechaFin').datepicker();
    datepickerCastellano();
});

function checkData() {
    // array para recoger los errores del formulario
    var errores = [];
    datos = [];

    // fecha de inicio
    var fechaInicio = $('#fecha').val();
    if (checkFecha(fechaInicio)) {
        datos.fechaInicio = createEnglishDateFormat(fechaInicio);
    } else {
        errores.push("la fecha de inicio es incorrecta");
    }

    // fecha finalizacion
    var fechaFin = $('#fechaFin').val();
    if (checkFecha(fechaFin)) {
        datos.fechaFin = createEnglishDateFormat(fechaFin);
    } else {
        errores.push("la fecha de finalización es incorrecta");
    }

    // horas duración curso
    var horas = $('#horas').val();
    if (checkHoras(horas)) {
        datos.horas = horas;
    } else {
        errores.push("El campo horas no puede estar vacío o el formato es incorrecto.");
    }

    //horario
    var horario = $('#horario').val();
    datos.horario = horario;

    // si el curso está activo o no, tamaño 1, un cero
    var activo = $('#activo').val();
    if (checkActivo(activo)) {
        if (activo === 'S') {
            datos.activo = 'S';
        } else {
            datos.activo = 'N';
        }

    } else {
        errores.push("Debes seleccionar una opcion en el campo activo");
    }

    // profesorado, campo tipo TEXT
    // mostrará los nombres de los profesores
    var profesorado = '';
    $('.listaProfesorado').each(function () {
        profesorado += $(this).val() + ',';
    });
    if (checkProfesorado(profesorado)) {
        datos.profesorado = profesorado;
    } else {
        errores.push("el campo profesorado no puede estar vacío.");
    }

    // comentarios sobre el curso
    // puede estar vacío o no
    var comentarios = $('#comentarios').val();
    datos.comentarios = comentarios;

    if (errores.length === 0) {
        crearCursoManipuladorAlimentos(datos);
        console.log("todo correcto");
    } else {
        showErrors(errores, "errores");
    }
}



function crearCursoManipuladorAlimentos(datos) {
    // realizar el envío por POST
    $.post('php/gestionAltaCursoManipulador.php', {
        fechaInicio: datos.fechaInicio,
        fechaFin: datos.fechaFin,
        horas: datos.horas,
        horario: datos.horario,
        activo: datos.activo,
        profesorado: datos.profesorado,
        comentarios: datos.comentarios
    },
    function (dataReceived) {
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
    $('#fecha').val('');
    $('#fechaFin').val('');
    $('#buscarprofesor').val('');
    $('#comentarios').val('');
    $('#horas').val('');
    $('#profesorado').empty();
    $('#box').remove();
}

function peticionParcialProfesor(cadena) {
    $.post('php/datosServidor.php', {aBuscar: "parcialProfesor", id: cadena}, function (dataRecived) {
        console.log(JSON.parse(dataRecived));
        var dataRecived = JSON.parse(dataRecived);
        $('#box').show();
        $('#ulProfeContainer').empty();
        for (i = 0; i < dataRecived.length; i++) {
            $('#ulProfeContainer').append('<li>' + dataRecived[i].codigo + " // " + dataRecived[i].dni + ' // ' + dataRecived[i].apellido1 + ', ' + dataRecived[i].apellido2 + ', ' + dataRecived[i].nombre + '</li>');
        }
    });
}

function anyadirProfesorLista(profesor) {
    $("#profesorado").append('<option class="listaProfesorado">' + profesor + '</option>');
    $('#buscarprofesor').val('');
    $('#box').hide(); 
}