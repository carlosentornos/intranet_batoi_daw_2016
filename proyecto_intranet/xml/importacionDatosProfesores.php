<?php

require_once '../php/Classes/Class_DB.php';
require_once 'functions.php';
require_once 'datosConexion.php';
$conn->set_charset('utf8');
$xmlPath = "Professors-dat.xml";
$xml = simplexml_load_file($xmlPath);
$profesores = $xml->docentes;

foreach ($profesores->children() as $profesor) {
    $arrayDatosProfesor = [];

    $arrayDatosProfesor['nombre'] = $profesor['nombre'];
    $arrayDatosProfesor['apellido1'] = $profesor['apellido1'];
    $arrayDatosProfesor['apellido2'] = $profesor['apellido2'];
    //nombre de la provincia
    $arrayDatosProfesor['provincia'] = getNombreProvincia($profesor['provincia']);
    //se necesita el codigo por separado para buscar el municipio
    $codProvincia = $profesor['provincia'];
    $arrayDatosProfesor['municipio'] = getNombreMunicipio($profesor['municipio'], $codProvincia);
    $arrayDatosProfesor['sexo'] = $profesor['sexo'];
    $arrayDatosProfesor['dni'] = $profesor['documento'];
    $arrayDatosProfesor['codigoPostal'] = $profesor['cod_postal'];
    $arrayDatosProfesor['domicilio'] = getStringDomicilio($profesor);
    $arrayDatosProfesor['telefono1'] = $profesor['telefono1'];
    $arrayDatosProfesor['telefono2'] = $profesor['telefono2'];
    $arrayDatosProfesor['email'] = $profesor['email1'];

    $arrayDatosProfesor['sustituyeA'] = $profesor['titular_sustituido'];
    $arrayDatosProfesor['fechaNacimiento'] = getFechaFormatoIngles($profesor['fecha_nac']);
    $arrayDatosProfesor['fechaIngresoCentro'] = getFechaFormatoIngles($profesor['fecha_ingreso']);
    $arrayDatosProfesor['fechaAntiguedad'] = getFechaFormatoIngles($profesor['fecha_antiguedad']);


    generarQuery($arrayDatosProfesor);
}

function generarQuery($profesor) {
    global $conn;

    $nombre = $profesor['nombre'];
    $apellido1 = $profesor['apellido1'];
    $apellido2 = $profesor['apellido2'];
    $fechaNacimiento = $profesor['fechaNacimiento'];
    $provincia = $profesor['provincia'];
    $municipio = $profesor['municipio'];
    $sexo = $profesor['sexo'];
    $dni = $profesor['dni'];
    $fechaAntiguedad = $profesor['fechaAntiguedad'];
    $codigoPostal = $profesor['codigoPostal'];
    $domicilio = $profesor['domicilio'];
    $telefono1 = $profesor['telefono1'];
    $telefono2 = $profesor['telefono2'];
    $email = $profesor['email'];
    $fechaIngreso = $profesor['fechaIngresoCentro'];
    $sustituyeA = $profesor['sustituyeA'];
    $codigo = setCodigoProfesor();
    $passwdDefecto = EncryptPassword($dni);
    $departamentoDefecto = "1"; //por defento departamento desconocido, dado que no viene en el xml

    $query = "INSERT INTO profesores(codigo, cod_horario, dni, nombre, apellido1, apellido2, password, email, email_alumnos, fecha_baja, foto, domicilio_particular, domicilio, movil1, movil2, perfil_acceso, departamentos_DEPARTA, sexo, fecha_ingreso, provincia, municipio, cod_postal, fecha_nac, fecha_antiguedad, sustituye_a) VALUES "
            . "('$codigo','','$dni','$nombre','$apellido1','$apellido2','$passwdDefecto','$email','',NULL,'','$domicilio','$domicilio','$telefono1','$telefono2','profesor','$departamentoDefecto','$sexo','$fechaIngreso','$provincia','$municipio','$codigoPostal','$fechaNacimiento','$fechaAntiguedad','$sustituyeA')";
    $conn->query($query);
}

