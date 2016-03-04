<?php

require_once '../php/Classes/Class_DB.php';
require_once 'functions.php';
require_once 'datosConexion.php';
$conn->set_charset('utf8');
$xmlPath = "alumnes-dat.xml";
$xml = simplexml_load_file($xmlPath);
$alumnos = $xml->alumnos;

foreach ($alumnos->children() as $alumno) {
    $arrayDatosAlumno = [];
    $arrayDatosAlumno['nia'] = $alumno['NIA'];
    $arrayDatosAlumno['nombre'] = $alumno['nombre'];
    $arrayDatosAlumno['apellido1'] = $alumno['apellido1'];
    $arrayDatosAlumno['apellido2'] = $alumno['apellido2'];
    $arrayDatosAlumno['fechaNacimiento'] = getFechaFormatoIngles($alumno['fecha_nac']);
    //nombre de la provincia
    $arrayDatosAlumno['provincia'] = getNombreProvincia($alumno['provincia']);
    //se necesita el codigo por separado para buscar el municipio
    $codProvincia = $alumno['provincia'];
    $arrayDatosAlumno['municipio'] = getNombreMunicipio($alumno['municipio'], $codProvincia);
    $arrayDatosAlumno['sexo'] = $alumno['sexo'];
    $arrayDatosAlumno['dni'] = $alumno['documento'];
    $arrayDatosAlumno['expediente'] = $alumno['expediente'];
    $arrayDatosAlumno['codigoPostal'] = $alumno['cod_postal'];
    $arrayDatosAlumno['domicilio'] = getStringDomicilio($alumno);
    $arrayDatosAlumno['telefono1'] = $alumno['telefono1'];
    $arrayDatosAlumno['telefono2'] = $alumno['telefono2'];
    $arrayDatosAlumno['email'] = $alumno['email'];
    $arrayDatosAlumno['observaciones'] = $alumno['observaciones'];
    $arrayDatosAlumno['fechaMatricula'] = getFechaFormatoIngles($alumno['fecha_matricula']);
    $arrayDatosAlumno['fechaIngresoCentro'] = getFechaFormatoIngles($alumno['fecha_ingreso_centro']);
    $arrayDatosAlumno['estadoMatricula'] = $alumno['estado_matricula'];
    $arrayDatosAlumno['repite'] = $alumno['num_repeticion'];
    $arrayDatosAlumno['grupo'] = $alumno['grupo'];
    $arrayDatosAlumno['turno'] = $alumno['turno'];
    $arrayDatosAlumno['trabaja'] = $alumno['trabaja'];

    //array_push($arrayDatosAlumno, $nia, $nombre, $apellido1, $apellido2, $fechaNacimiento, $municipio, $provincia, $sexo, $dni, $expediente, $codigoPostal, $domicilio, $telefono1, $telefono2, $email, $observacinoes, $fechaMatricula, $fechaIngresoCentro, $estadoMatricula, $repite, $grupo, $turno, $trabaja);
    //var_dump($arrayDatosAlumno);
    generarQuery($arrayDatosAlumno);
}

function generarQuery($alumno) {
    global $conn;

    $nia = $alumno['nia'];
    $nombre = $alumno['nombre'];
    $apellido1 = $alumno['apellido1'];
    $apellido2 = $alumno['apellido2'];
    $fechaNacimiento = $alumno['fechaNacimiento'];
    $provincia = $alumno['provincia'];
    $municipio = $alumno['municipio'];
    $sexo = $alumno['sexo'];
    $dni = $alumno['dni'];
    $expediente = $alumno['expediente'];
    $codigoPostal = $alumno['codigoPostal'];
    $domicilio = $alumno['domicilio'];
    $telefono1 = $alumno['telefono1'];
    $telefono2 = $alumno['telefono2'];
    $email = $alumno['email'];
    $observaciones = $alumno['observaciones'];
    $fechaMatricula = $alumno['fechaMatricula'];
    $fechaIngreso = $alumno['fechaIngresoCentro'];
    $estadoMatricula = $alumno['estadoMatricula'];
    $repite = $alumno['repite'];
    $grupo = $alumno['grupo'];
    $turno = $alumno['turno'];
    $trabaja = $alumno['trabaja'];
    $passwdDefecto = EncryptPassword($dni);

    $query = "INSERT INTO alumnos(id, dni, nombre, apellido1, apellido2, password, email, fecha_nac, foto, nia, sexo, expediente, cod_postal, domicilio, provincia, municipio, telefono1, telefono2, observaciones, fecha_matricula, fecha_ingreso_centro, estado_matricula, repite, turno, trabaja) VALUES " .
            "('','$dni','$nombre','$apellido1','$apellido2','$passwdDefecto','$email','$fechaNacimiento','','$nia','$sexo','$expediente','$codigoPostal','$domicilio','$provincia','$municipio','$telefono1','$telefono2','$observaciones','$fechaMatricula','$fechaIngreso','$estadoMatricula','$repite','$turno','$trabaja')";

    $conn->query($query);
    //despues del insert de la query del alumno, hacemos el insert de la relacion con grupos, pero necesitamos el id del alumno que se acaba de introducir
    $currentId = getIdAlumnoActual($dni);

    $query = "INSERT INTO alumnos_has_grupos VALUES ('$currentId','$nia','$dni','$grupo')";
    echo $query;
    $conn->query($query);
}

