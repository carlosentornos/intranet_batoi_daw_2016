var datos = [];

var idAlumnoRellenado;
$(document).ready(function() {

    $('body').on("click", 'li', function() {
        //le enviamos el id a la funcion para coger todos los datos de los alumnos
        var idAlumno = $(this).text().split(' ')[0];
        var grupoSelecionado = $('#grupo').val();
        $('#box').hide();
        anyadirAlumnoEnGrupo(grupoSelecionado,idAlumno);
    });

    $('body').on('change', '#grupo', function() {
        var grupoSelecionado = $(this).val();
        buscarAlumnos(grupoSelecionado);
    });

    //rellena el combo de los cursos del centro
    peticionGrupos();

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

    $('body').on('click', '.del', function() {
        var dni = $(this).parent().parent().find('td:first').text();
        var grupo = $('#grupo').val();
        borrarAlumnoEnGrupo(grupo, dni);
        $(this).parent().parent().empty();
    });
});

function checkData() {
    var errores = [];

    if (errores.length === 0) {
        //enviamos lo datos que hay en la funcion ahora mismo, no los del formulario
        modDatos(datos);
    }

    console.log(errores.length);
    console.log(errores);

}

//modificacion de datos en el servidor
//funciones ajax
function modDatos(datos) {
    console.log(datos.repite);
    $.post('php/gestionGrupos.php', {
        id: idAlumnoRellenado,
        foto: ''
    },
    function(dataRecived) {
        console.log(dataRecived);
    });
}

function buscarAlumnos(grupo) {
    $.post('php/datosServidor.php', {aBuscar: "alumnosGrupo", id: grupo}, function(dataRecived) {
        console.log(JSON.parse(dataRecived));
        dataRecived = JSON.parse(dataRecived);
        //creamos una tabla con los datos
        $('table').remove();
        $('#grupo').after(
                '<table class="tabla">' +
                "<tr>" +
                '<th style="display:none">id</th>' +
                "<th>DNI</th>" +
                "<th>Primer apellido</th>" +
                "<th>Segundo apellido</th>" +
                "<th>Nombre</th>" +
                "<th>Eliminar del grupo</th>" +
                "</tr>" +
                "</table>");
        for (i = 0; i < dataRecived.length; i++) {
            $('table').append(
                    '<tr class="lineaAlumno">' +
                    '<td style="display:none;">' + dataRecived[i].id + '</td>' +
                    "<td>" + dataRecived[i].dni + "</td>" +
                    "<td>" + dataRecived[i].apellido1 + "</td>" +
                    "<td>" + dataRecived[i].apellido2 + "</td>" +
                    "<td>" + dataRecived[i].nombre + "</td>" +
                    '<td>' + '<a href="#" class="del"><img class="iconopequeno" src="imagenes/borrar.png"></a>' + '</td>' +
                    "</tr>");
        }
    });
}

function borrarAlumnoEnGrupo(codigoGrupo, codigoAlumno) {
    $.post('php/datosServidor.php', {aBuscar: "borrarAlumnoEnGrupo", codigoGrupo: codigoGrupo, dniAlumno: codigoAlumno},
    function(dataRecived) {
        console.log(dataRecived);
    });
}

function anyadirAlumnoEnGrupo(codigoGrupo, idAlumno) {
    $.post('php/datosServidor.php', {aBuscar: "anyadirAlumnoGrupo", codigoGrupo: codigoGrupo, idAlumno: idAlumno},
    function(dataRecived) {
        console.log(dataRecived);
        buscarAlumnos(codigoGrupo);
    });
    $('#buscaralumno').val('');

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
