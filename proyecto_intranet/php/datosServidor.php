<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'Classes/Class_DB.php';

require_once 'config.php';
$connection = new DB($ip, $user, $pass, $db);

$connection->Connect();
//conexion realizada, funcion GetConn para usar la conexion

$conn = $connection->GetConn();

//anyadir
$conn->set_charset('utf8');
//esto deberia ser una class o dependiendo de lo que venga por post se ejecuta una funcion
//switch con lo que hay que devolver
if (isset($_POST['aBuscar'])) {
    $aBuscar = $_POST['aBuscar'];
}

if (isset($_SESSION['userId'])) {
    $sessionId = $_SESSION['userId'];
}
//para el caso de cuando el id si que viene por post y no por la session
if (isset($_POST['id'])) {
    $postId = $_POST['id'];
}
if (isset($aBuscar)) {//Con este switch seleccionamos la query que queremos cuando le enviamos un parametro
    switch ($aBuscar) {
        case "grupo":
            $query = "select codigo, nombre from grupos"; // anyadido codigo 24-02-2016
            getGrupos($query);
            break;
        case "gruposAlumno":
            global $postId;
            $query = "select grupos.nombre from grupos
                    INNER JOIN alumnos_has_grupos on alumnos_has_grupos.grupos_codigo = grupos.codigo
                    where alumnos_has_grupos.alumnos_id = '$postId'";
            getGruposAlumnos($query);
            break;
        case "perfilAlumnoDireccion"; //para este caso (direccion modifica alumno) si que nos llega el id del alumno por post, y para usar la misma funcino tambien le pasamos la query
            global $postId;
            $query = "select id,dni,nombre,apellido1,apellido2,email"
                    . ",fecha_nac,foto,nia,sexo,expediente"
                    . ",cod_postal,domicilio,provincia,municipio,telefono1"
                    . ",telefono2,observaciones,fecha_matricula,fecha_ingreso_centro"
                    . ",estado_matricula,repite,turno,trabaja"
                    . " from alumnos where id = '$postId'";

            getAlumno($query);
            break;
        case "perfilProfesorDireccion"; //para este caso (direccion modifica alumno) si que nos llega el id del alumno por post, y para usar la misma funcino tambien le pasamos la query
            global $postId;
            $query = "select cod_horario,codigo,dni,nombre,apellido1,apellido2,email"
                    . ",fecha_nac,fecha_baja,fecha_ingreso,fecha_antiguedad,foto,sexo"
                    . ",cod_postal,domicilio,domicilio_particular,provincia,municipio,movil1"
                    . ",movil2,perfil_acceso,email_alumnos,departamentos_DEPARTA,CLITERAL "
                    . " from profesores "
                    . " INNER JOIN departamentos ON profesores.departamentos_DEPARTA = departamentos.departa "
                    . " where codigo = '$postId'";
            getProfesor($query);
            break;
        case "parcialAlumno";
            global $postId;
            completarListaAlumnos($postId);
            break;
        case "parcialProfesor";
            global $postId;
            completarListaProfesores($postId);
            break;
        case "autoAlumno";
            global $sessionId;
            $query = "select email,foto from alumnos where id = '$sessionId'";
            getAlumno($query);
            break;
        case "autoProfesor";
            global $sessionId;
            $query = "select email,email_alumnos from profesores where codigo = '$sessionId'";
            getProfesor($query);
            break;
// cargar los departamentos
        case "cargarDepartamentos";
            //solo necesitamos la consulta
            $query = "select departa, CLITERAL from departamentos";
            getDepartamentos($query);
            break;
        case "alumnosGrupo":
            global $postId;
            $query = "SELECT alumnos.id, alumnos.apellido1, alumnos.apellido2, alumnos.nombre, alumnos.dni from alumnos INNER JOIN alumnos_has_grupos on alumnos_has_grupos.alumnos_id = alumnos.id INNER JOIN grupos on grupos.codigo = alumnos_has_grupos.grupos_codigo WHERE grupos.nombre = '$postId' ";
            getAlumnosByGrupo($query);
            break;
// cargar los profesores del departament al que pertenece el profesor
        case "cargarProfesoresDepartamento";
            global $postId;
            $query = "SELECT codigo, nombre, apellido1, apellido2 FROM profesores"
                    . " INNER JOIN departamentos ON profesores.departamentos_DEPARTA = departamentos.departa"
                    . " WHERE departamentos_DEPARTA = "
                    . "(SELECT departamentos_DEPARTA FROM profesores"
                    . " INNER JOIN departamentos ON profesores.departamentos_DEPARTA = departamentos.departa"
                    . " WHERE codigo = '$postId');";
            getProfesoresDepartamentos($query);
            break;
        case "cargarProfesoresPorDepartamento":
            $departamento = $_POST['departamento'];
            $query = "SELECT p.nombre, p.apellido1, p.apellido2, p.codigo from profesores as p" .
                    " inner join departamentos as d on d.departa = p.departamentos_DEPARTA" .
                    " where d.CLITERAL = '$departamento'";
            devolverDatos($query);
            break;
        case "cursosManipulador":
            $query = "SELECT codigo,fecha_inicio,fecha_fin,activo,horario from manipulador_alimentos";
            getCursosManipuladorAlimentos($query);
            break;
        case "alumnosByCursoManipulador":
            //tenemos tres casos, buscar alumnos en todos los cursos, alumnos en un curso en concreto, o los alumnos de un grupo
            $codigoGrupo = $_POST['codigoGrupo'];
            $query = "SELECT a.id, a.dni, a.apellido1, a.apellido2, a.nombre, am.finalizado from alumnos as a " .
                    "INNER JOIN alumnos_has_manipulador_alimentos as am on am.alumnos_id = a.id " .
                    "INNER JOIN manipulador_alimentos as m on m.codigo = am.manipulador_alimentos_codigo " .
                    "where m.codigo = '$codigoGrupo' and am.registrado = 's'";
            getAlumnosByManipulador($query);
            break;
        case "alumnosByCursoAlumno":
            //tenemos tres casos, buscar alumnos en todos los cursos, alumnos en un curso en concreto, o los alumnos de un grupo
            $codigoGrupo = $_POST['codigoGrupo'];
            $codigoAlumno = $_POST['codigoAlumno'];
            $query = "SELECT a.id, a.dni, a.apellido1, a.apellido2, a.nombre, am.finalizado from alumnos as a " .
                    "INNER JOIN alumnos_has_manipulador_alimentos as am on am.alumnos_id = a.id " .
                    "INNER JOIN manipulador_alimentos as m on m.codigo = am.manipulador_alimentos_codigo " .
                    "where m.codigo = '$codigoGrupo' and a.id = '$codigoAlumno'";
            getAlumnosByManipulador($query);
            break;
        case "borrarAlumnoCursoManipulador":
            $codigoGrupo = $_POST['codigoGrupo'];
            $idAlumno = $_POST['idAlumno'];
            $query = "DELETE FROM alumnos_has_manipulador_alimentos" .
                    " where manipulador_alimentos_codigo = '$codigoGrupo' AND alumnos_id = '$idAlumno'";
            echo $query;
            borrarAlumnoEnCurso($query);
            break;
        case "borrarAlumnoEnGrupo":
            $codigoGrupo = $_POST['codigoGrupo'];
            $dniAlumno = $_POST['dniAlumno'];
            $query = "DELETE FROM alumnos_has_grupos" .
                    " where grupos_codigo = (SELECT codigo from grupos where nombre = '$codigoGrupo') AND alumnos_id = '$dniAlumno'";
            borrarAlumnoEnCurso($query);
            break;
        case "anyadirAlumnoGrupo":
            $codigoGrupo = $_POST['codigoGrupo'];
            $idAlumno = $_POST['idAlumno'];
            $query = "INSERT INTO alumnos_has_grupos VALUES ('$idAlumno'," .
                    "(select nia from alumnos where id = '$idAlumno')," .
                    "(select dni from alumnos where id = '$idAlumno')," .
                    "(select codigo from grupos where nombre = '$codigoGrupo'))";
            echo $query;
            anyadirAlumnoEnGrupo($query);
            break;
        case "cambiarFinalizadoManipulador":
            global $postId;
            $checked = $_POST['checked'];
            $codigoGrupo = $_POST['codigoGrupo'];
            $query = "UPDATE alumnos_has_manipulador_alimentos set finalizado = '$checked' where alumnos_id = '$postId' and manipulador_alimentos_codigo = '$codigoGrupo'";
            echo $query;
            cambiarFinalizadoManipulador($query);
            break;
        case "actividadesExtraescolares";
            $query = "SELECT * from actividades_extraescolares";
            devolverDatos($query);
            break;
        case "actividadesExtraescolaresEspecifica";
            $codigoActividad = $_POST['codigoActividad'];
            $query = "SELECT * from actividades_extraescolares where codigo = '$codigoActividad'";
            devolverDatos($query);
            break;
        case "actividadExtraescolarEspecificaProfesores":
            //esta consulta seleccionara tambien los profesores y los cursos de la actividad
            $codigoActividad = $_POST['codigoActividad'];
            $query = "SELECT a.nombre, a.descripcion, a.objetivos, a.fecha_realizacion, a.hora_inicio, a.fecha_alta, a.comentarios, p.nombre, p.apellido1, p.apellido2, p.dni, p.codigo, ap.coordinador" .
                    " from actividades_extraescolares as a" .
                    " INNER JOIN actividades_extraescolares_has_profesores as ap on a.codigo = ap.actividades_extraescolares_codigo" .
                    " INNER JOIN profesores as p on ap.profesores_codigo = p.codigo" .
                    " WHERE a.codigo = '$codigoActividad'";

            devolverDatos($query);
            break;
        case "actividadExtraescolarEspecificaGrupos":
            $codigoActividad = $_POST['codigoActividad'];
            $query = "SELECT  g.nombre as grupo_nombre, g.codigo as grupo_codigo" .
                    " from grupos as g" .
                    " INNER JOIN grupos_has_actividades_extraescolares as ga on ga.grupos_codigo = g.codigo" .
                    " WHERE ga.actividades_extraescolares_codigo = '$codigoActividad' ";
            devolverDatos($query);
            break;
    }
}
/**
 * Ejecutamos la query
 * @global String $conn
 * @param String $query Le pasamos la query
 */
function cambiarFinalizadoManipulador($query) {
    global $conn;
    $conn->query($query);
}
/**
 * Ejecutamos la query
 * @global String $conn
 * @param String $query Le pasamos la query
 */
function borrarAlumnoEnCurso($query) {
    global $conn;
    $conn->query($query);
}
/**
 * Ejecutamos la query
 * @global String $conn
 * @param String $query Le pasamos la query
 */
function anyadirAlumnoEnGrupo($query) {
    global $conn;
    $conn->query($query);
}

//alumnos pertenecientes a un curso, por codigo de curso
/**
 * Llama a devolverDatos
 * @param String $query query que queremos hacer para que nos devuelvan datos
 */
function getAlumnosByManipulador($query) {
    devolverDatos($query);
}
/**
 * Llama a devolverDatos
 * @param String $query query que queremos hacer para que nos devuelvan datos
 */
function getCursosManipuladorAlimentos($query) {
    devolverDatos($query);
}

/**
 * las funciones estan creadas aqui abajo por si en algun momento necsitamos anyadir algo, no ensuciar el switch
 */
/**
 * Llama a devolverDatos
 * @param String $query query que queremos hacer para que nos devuelvan datos
 */
function getGrupos($query) {
    devolverDatos($query);
}
/**
 * Llama a devolverDatos
 * @param String $query query que queremos hacer para que nos devuelvan datos
 */
function getAlumnosByGrupo($query) {
    devolverDatos($query);
}
/**
 * Llama a devolverDatos
 * @param String $query query que queremos hacer para que nos devuelvan datos
 */
function getGruposAlumnos($query) {
    devolverDatos($query);
}
/**
 * Llama a devolverDatos
 * @param String $query query que queremos hacer para que nos devuelvan datos
 */
function getAlumno($query) {
    devolverDatos($query);
}
/**
 * Llama a devolverDatos
 * @param String $query query que queremos hacer para que nos devuelvan datos
 */
function getProfesor($query) {
    devolverDatos($query);
}
/**
 * Genera la query y llama a devolverDatos
 * @param String $string Parte de la query
 */
function completarListaAlumnos($string) {
    $query = "select id,dni,nombre,apellido1,apellido2 from alumnos where apellido1 like '%$string%' limit 5";
    devolverDatos($query);
}
/**
 * Genera la query y llama a devolverDatos
 * @param String $string Parte de la query
 */
function completarListaProfesores($string) {
    $query = "select codigo,dni,nombre,apellido1,apellido2 from profesores where apellido1 like '%$string%' limit 5";
    devolverDatos($query);
}

// añadimos la funcion para obtener el listado de los departamentos
/**
 * Llama a devolverDatos
 * @param String $query query que queremos hacer para que nos devuelvan datos
 */
function getDepartamentos($query) {
    devolverDatos($query);
}

// funcion para obtener los profesores del mismo departamento al que pertenece
// el profesor seleccionado
/**
 * Llama a devolverDatos
 * @param String $query query que queremos hacer para que nos devuelvan datos
 */
function getProfesoresDepartamentos($query) {
    devolverDatos($query);
}
/**
 * Devuelve los datos de la query
 * @global String $conn
 * @param String $query Query que queremos ejecutar
 */
function devolverDatos($query) {
    global $conn;

    $result = $conn->query($query);

    $rows = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    //return json($rows);
    echo json_encode($rows);
}
/**
 * Devuelve si es sel ultimo que tiene curso
 * @global String $conn
 * @global String $sessionId
 * @return boolean
 */
function alumnoTieneCurso() {
    global $conn;
    global $sessionId;
    $query = "SELECT alumnos_id FROM alumnos_has_manipulador_alimentos WHERE alumnos_id = '$sessionId'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
/**
 * 
 * @global String $conn
 * @global String $sessionId
 * @return type
 */
function checkRegistradoAlumnosManipulador() {
    global $conn;
    global $sessionId;
    $query = "SELECT registrado from alumnos_has_manipulador_alimentos as ah INNER JOIN manipulador_alimentos as ma" .
            " on ah.manipulador_alimentos_codigo = ma.codigo where ma.activo = 's' and ah.alumnos_id = '$sessionId'";
    $result = $conn->query($query);
    $row = mysqli_fetch_array($result);
    return $row['registrado'];
}
/**
 * Devuelve los cursos activos
 * @global String $conn
 * @return type
 */
function getCursosActivos() {
    global $conn;
    $query = "SELECT codigo,horario from manipulador_alimentos where activo = 's'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
/**
 * Devuelve el curso activo del alumno
 * @global String $conn
 * @global String $sessionId
 * @return type
 */
function getCursoActivoAlumno() {
    global $conn;
    global $sessionId;
    $query = "SELECT ah.manipulador_alimentos_codigo FROM alumnos_has_manipulador_alimentos as ah inner join manipulador_alimentos as ma on ah.manipulador_alimentos_codigo=ma.codigo WHERE ah.alumnos_id=$sessionId and ma.activo='s'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $val = $row['manipulador_alimentos_codigo'];
        }
        return $val;
    }
}
/**
 * Devuelve el  Horario del curso
 * @global String $conn
 * @param type $curso
 * @return type
 */
function getHorarioCurso($curso) {
    global $conn;

    $query = "SELECT horario FROM manipulador_alimentos WHERE codigo=$curso";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $val = $row['codigo'];
        }
        return $val;
    }
}
