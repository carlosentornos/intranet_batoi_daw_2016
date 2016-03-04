var datos = [];
$(document).ready(function() {
    // limpiar inputs
    $("#horas").val("");
    $("#titulo").val("");

    // rellenar combobox con los values y los grupos
    peticionGruposPropio();
    
    // crear las cabeceras de las tablas de alumnos
    cabeceraAlumnos();

    // crear la cabecera de la tabla de grupos
    cabeceraGrupos();

    //buscamos datos de alumnos por key presionada
    $('#buscaralumno').keyup(function(evt) {
        var aBuscar = evt.target.value;
        peticionParcialAlumno(aBuscar);
    });

    $('body').on("click", 'li', function() {
        //le enviamos el id a la funcion para coger todos los datos de los alumnos
        var id = $(this).text().split(' ')[0].replace(',',""); // id
        var dni = $(this).text().split(' ')[2].replace(',',""); // dni
        var nombre = $(this).text().split(' ')[4].replace(',',""); // apellido1
        var apellido1 = $(this).text().split(' ')[5].replace(',',""); // apellido2
        var apellido2 = $(this).text().split(' ')[6].replace(',',""); // apellido1

        $('.grupoContainer').not(':first').remove();
        generateTable(id, dni, nombre, apellido1, apellido2);
        $('#box').hide();
        // limpiar el texto para buscar alumno
        $('#buscaralumno').val("");
    });

    // clicar sobre el grupo
    $("#grupo").on("change",ponerGrupoTabla);

    // borrar el alumno o el grupo de las tablas
    $('body').on('click', '.del', function() {
        //var id = $(this).parent().parent().find('td:first').text();
        //var grupo = $('#filtro').val();
        //borrarAlumnoEnCurso(grupo, id);
        $(this).parent().parent().remove();
    });

    // generar PDF tanto del alumno
    $('body').on('click', '.pdfalumno', function(evt) {
        evt.preventDefault();
        // nos guardamos el codigo del alumno
        var codigo = $(this).parent().parent().find('td:first').text();
        console.log("entra");
        
        //verificamos los valores
        checkData("alumno",codigo);
    });

    // generar PDF del grupo
    $('body').on('click', '.pdfgrupo', function(evt) {
        evt.preventDefault();
        // nos guardamos el codigo del grupo
        var codigo = $(this).parent().parent().find('td:first').text();
        console.log("entra");
        //verificamos los datos
        checkData("grupo",codigo);
    });

});

// comprobar los datos del formulario antes de enviarlo
function checkData(tipo,codigo) {
    // array para recoger los errores del formulario
    var errores = [];
    
    // comprobar las horas del curso
    var horas = $('#horas').val();
    if (checkHorasRiesgos(horas)) {
        datos.horas = horas;
    } else {
        errores.push("El campo horas no puede estar vacío o contener letras.");
    }

    // comprobar el nombre del curso
    var titulo = $('#titulo').val();
    if(checkTituloRiesgos(titulo)){
        datos.titulo = titulo;
    }else{
        errores.push("El titulo no puede estar vacío.");
    }

    

// si no hay errores entonces enviamos los datos
// comprobamos la longitud del array errores
    console.log(errores);
    if (errores.length === 0) {
        //enviamos lo datos que hay en la funcion ahora mismo, no los del formulario
        generarPDF(datos,tipo,codigo);
        $('.errores').empty();
        $('.errores').append('<p>Petición realizada con éxito</p>').css("color","green");
    } else {
        console.log(errores.length);
        showErrors(errores,'errores');
    }
}

// enviar los datos al PDF
function generarPDF(datos,tipo,codigo) {
    
    window.open('php/pdf/plantillaCertificadoReisgosLaborales.php?horas='
        +datos.horas
        +'&titulo='+datos.titulo.toUpperCase()
        +'&tipo='+tipo
        +'&codigo='+codigo);
}


function cabeceraAlumnos(){
    $('#tableContainer').append('<table class="tabla datosAlumnos">' +
            '<tr>' +
            '<th style="display:none">id</th>' +
            '<th>DNI</th>' +
            '<th>Primer apellido</th>' +
            '<th>Segundo apellido</th>' +
            '<th>Nombre</th>' +
            '<th>Borrar</th>' +
            '<th>PDF</th>' +
            '</tr>' +
    '</table>');
}

// funcion para añadir el alumno a la tabla y que muestre sus datos
function generateTable(id, dni, apellido1, apellido2, nombre) {
    //$('table .datosAlumnos').remove();
    //cabecera de la tabla
    $('.datosAlumnos').append('<tr class="lineaAlumno">' +
        '<td style="display:none;">' + id + '</td>' +
        '<td>' + dni + '</td>' +
        '<td>' + apellido1 + '</td>' +
        '<td>' + apellido2 + '</td>' +
        '<td>' + nombre + '</td>' +
        '<td>' + '<a href="#" class="del"><img class="iconopequeno" src="imagenes/borrar.png"></a>' + '</td>' +
        '<td>' + '<a href="#" class="pdfalumno"><img class="iconopequeno" src="imagenes/pdf.png"></a>' + '</td>' +
    '</tr>');
    
}

function cabeceraGrupos(){
    $('#tableContainer2').append('<table class="tabla datosGrupos">' +
            '<tr>' +
            '<th>CODIGO</th>' +
            '<th>NOMBRE</th>' +
            '<th>Borrar</th>' +
            '<th>PDF</th>' +
            '</tr>' +
            '</table>'); 
}


function ponerGrupoTabla(){
    $('.datosGrupos').append('<tr class="lineaGrupo"><td>'+$(this).val()+'</td><td>'+$('#grupo option:selected').text()+
        '<td>' + '<a href="#" class="del"><img class="iconopequeno" src="imagenes/borrar.png"></a>' + '</td>' +
        '<td>' + '<a href="#" class="pdfgrupo"><img class="iconopequeno" src="imagenes/pdf.png"></a>' + '</td>' +
        '</tr>');
    // borrar la seleccion del usuario
    $('#grupo').val("");
}

function peticionGruposPropio() {
    $().ready(function() {
        $.post('php/datosServidor.php', {aBuscar: "grupo"}, function(dataRecived) {
            console.log(JSON.parse(dataRecived));
            var grupos = JSON.parse(dataRecived);
            var appendedTo = $('#grupo');
            appendedTo.addClass('grupo');
            appendedTo.append("<option>" + "-- Seleciona --" + "</option>");
            for (i = 0; i < grupos.length; i++) {
                appendedTo.append("<option value="+ grupos[i].codigo +">" + grupos[i].nombre + "</option>"); // modificado 24-02-2016
            }
        });
    });
}