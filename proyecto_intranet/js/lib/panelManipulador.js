
var arrayPDF = [];
$(document).ready(function() {
    cargarCursosManipulador();

    /**
     * listener para la comprobacion de datos 
     */
    $('#form').keydown(function(evt) {
        if (evt.which === 13) {
            evt.preventDefault();
            checkData();
        }
    });

    /**
     * listener para el boton de la hoja de firmas
     */
    $('#hojaFirmas').click(function() {
        var code = $('#filtro').val();
        if (code != "" && code != null) {
            location.assign("./php/pdf/plantillaHojaDeFirmas.php?curso=" + code);
        }
    });

    /**
     * listener para el cambio de curso en select
     */
    $('#filtro').change(function() {
        rellenarTablaDatosByGrupo($(this).val());
    });

    /**
     * listener para la busqueda de alumnos
     */
    $('#buscaralumno').keyup(function(evt) {
        var aBuscar = evt.target.value;
        peticionParcialAlumno(aBuscar);
    });

    /**
     * Listener para la lista de alumnos que se buscan en el servidor 
     */
    $('body').on('click', 'li', function() {
        var idAlumno = $(this).text().split(' ')[0];
        var idGrupo = $('#filtro').val();
        rellenarTablaDatosByGrupoYalumno(idGrupo, idAlumno);
        $('#box').hide();
        $('#buscaralumno').val('');
    });

    /**
     * Listener para los botones de borrar
     */
    $('body').on('click', '.del', function() {
        var id = $(this).parent().parent().find('td:first').text();
        var grupo = $('#filtro').val();
        borrarAlumnoEnCurso(grupo, id);
    });

    /**
     * Listener para los botones de imprimir pdf
     */
    $('body').on('click', '.pdf', function(evt) {

        arrayPDF = [];
        evt.preventDefault();
        arrayPDF.push($(this).parent().parent().find('td:first').text());
        console.log(arrayPDF);
        generarPDF(arrayPDF);
    });

    /**
     * Listener para el submit del formulario (ajax)
     */
    $('#submit').click(function(evt) {
        evt.preventDefault();
        if ($('#filtro').val() != null && $('#filtro').val() != 'Seleccionar') {
            arrayPDF = [];
            $('.lineaAlumno').has('input[type="checkbox"]:checked').each(function() {
                arrayPDF.push($(this).find('td:first').text());
            });
            console.log(arrayPDF);
            generarPDF(arrayPDF);
        }
    });

    /**
     * Listener para el radioButton finalizado
     */
    $('body').on('click', '.checkFinalizado', function() {
        var id = $(this).parent().parent().find('td:first').text();
        var checked;
        var idGrupo = $('#filtro').val();
        if ($(this).is(':checked')) {
            checked = "1";
        } else {
            checked = "0";
        }
        $.post('php/datosServidor.php', {aBuscar: "cambiarFinalizadoManipulador", id: id, checked: checked, codigoGrupo: idGrupo}, function(dataRecived) {
            //console.log(JSON.parse(dataRecived));
        });
    });
});

/**
 * Conexion ajax para cargar los cursos de manipulador de alimentos
 * @returns {undefined}
 */
function cargarCursosManipulador() {
    $.post('php/datosServidor.php', {aBuscar: "cursosManipulador"}, function(dataRecived) {
        console.log(JSON.parse(dataRecived));
        dataRecived = JSON.parse(dataRecived);
        for (i = 0; i < dataRecived.length; i++) {
            if (dataRecived[i].activo.toLowerCase() === 's') {
                $('#filtro').append('<option value="' + dataRecived[i].codigo + '">' + 'Activo: Codigo ' + dataRecived[i].codigo + ' / ' + dataRecived[i].horario + '</option>').val(dataRecived[i].codigo);
                //rellenarTablaDatosByGrupo(dataRecived[i].codigo);
            } else {
                $('#filtro').append('<option value="' + dataRecived[i].codigo + '">' + 'Codigo ' + dataRecived[i].codigo + '</option>');
            }
        }
        $('#filtro').val('seleccionar');
    });
}
/**
 * Funcion que hace la llamada al fichero encargado de generar los pdf
 * @param {type} array los id's de alumnos, los cuales se van a imprimir los pdf
 * @returns {undefined}
 */
function generarPDF(array) {
    var curso = $('#filtro').val();
    window.open('php/pdf/plantillaManipuladorAlimentos.php?id=' + array + '&curso=' + curso);
}
/**
 * Funcion para rellenar la tabla con datos de los grupos que existen para dicho curso de manipulador
 * @param {type} codigoGrupo codigo del grupo para rellenar la tabla con los datos
 * @returns {undefined}
 */
function rellenarTablaDatosByGrupo(codigoGrupo) {
    //tableContainer
    $.post('php/datosServidor.php', {aBuscar: "alumnosByCursoManipulador", codigoGrupo: codigoGrupo},
    function(dataRecived) {
        console.log(dataRecived);
        dataRecived = JSON.parse(dataRecived);
        //generamos una tabla con los datos de los alumnos
        if (dataRecived.length !== 0) {
            $('.mensaje').remove();
            generateTable(dataRecived);
        } else {
            $('.mensaje').remove();
            $('table').remove();
            $('#tableContainer').before('<p class="mensaje rojo centrado">No hay ningun resultado para mostrar en el curso</p>');
        }
    });
}
/**
 * funcion ajax para buscar un alumno en el curso seleccionado
 * @param {type} codigoGrupo codigo del curso de manipulador de alimentos 
 * @param {type} codigoAlumno codigo del alumno para buscarlo en dicho curso
 * @returns {undefined}
 */
function rellenarTablaDatosByGrupoYalumno(codigoGrupo, codigoAlumno) {
    //tableContainer
    $.post('php/datosServidor.php', {aBuscar: "alumnosByCursoAlumno", codigoGrupo: codigoGrupo, codigoAlumno: codigoAlumno},
    function(dataRecived) {
        console.log(dataRecived);
        dataRecived = JSON.parse(dataRecived);
        //generamos una tabla con los datos de los alumnos
        generateTable(dataRecived);
    });
}
/**
 * funcion ajax para borrar el alumno seleccionado
 * @param {type} codigoGrupo codigo del curso de manipulador de alimentos 
 * @param {type} codigoAlumno codigo del alumno para buscarlo en dicho curso
 * @returns {undefined}
 */
function borrarAlumnoEnCurso(codigoGrupo, codigoAlumno) {
    $.post('php/datosServidor.php', {aBuscar: "borrarAlumnoCursoManipulador", codigoGrupo: codigoGrupo, idAlumno: codigoAlumno},
    function(dataRecived) {
        console.log(dataRecived);
        rellenarTablaDatosByGrupo(codigoGrupo);
    });
}
/**
 * funcion para generar la tabla a partir de los datos que reciban las otras funciones
 * @param {type} dataRecived Datos recibidos en las diferentes peticiones ajax
 * @returns {undefined}
 */
function generateTable(dataRecived) {
    $('table').remove();
    //cabecera de la tabla
    $('#tableContainer').append('<table class="tabla datosAlumnos">' +
            '<tr>' +
            '<th style="display:none">id</th>' +
            '<th>DNI</th>' +
            '<th>Primer apellido</th>' +
            '<th>Segundo apellido</th>' +
            '<th>Nombre</th>' +
            '<th>Finalizado</th>' +
            '<th>Borrar</th>' +
            '<th>PDF</th>' +
            '</tr>' +
            '</table>');
    for (i = 0; i < dataRecived.length; i++) {
        var checkboxLine;
        if (dataRecived[i].finalizado === '1') {
            checkboxLine = '<td>' + '<input type="checkbox" checked class="reducirCheckbox checkFinalizado" >' + '</td>';
        } else {
            checkboxLine = '<td>' + '<input type="checkbox" class="reducirCheckbox checkFinalizado" >' + '</td>';
        }
        $('.datosAlumnos').append('<tr class="lineaAlumno">' +
                '<td style="display:none;">' + dataRecived[i].id + '</td>' +
                '<td>' + dataRecived[i].dni + '</td>' +
                '<td>' + dataRecived[i].apellido1 + '</td>' +
                '<td>' + dataRecived[i].apellido2 + '</td>' +
                '<td>' + dataRecived[i].nombre + '</td>' +
                checkboxLine +
                '<td>' + '<a href="#" class="del"><img class="iconopequeno" src="imagenes/borrar.png"></a>' + '</td>' +
                '<td>' + '<a href="#" class="pdf"><img class="iconopequeno" src="imagenes/pdf.png"></a>' + '</td>' +
                '</tr>');
    }
}


