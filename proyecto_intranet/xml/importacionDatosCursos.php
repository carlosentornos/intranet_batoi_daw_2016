<?php

require_once '../php/Classes/Class_DB.php';
require_once 'functions.php';
require_once 'datosConexion.php';
$conn->set_charset('utf8');
$xmlPath = "Grups-dat.xml";
$xml = simplexml_load_file($xmlPath);
$grupos = $xml->grupos;

foreach ($grupos->children() as $curso) {
    $arrayDatosCursos = [];
    $arrayDatosCursos['codigo'] = $curso['codigo'];
    $arrayDatosCursos['nombre'] = $curso['nombre'];
    $arrayDatosCursos['turno'] = $curso['turno'];
    $arrayDatosCursos['tutor'] = $curso['tutor_ppal'];
    $arrayDatosCursos['departamento'] = '1'; //departamento por defecto, dado que este dato no viene en el xml
    
    generarQuery($arrayDatosCursos);
}

function generarQuery($cursos) {
    global $conn;
    
    $codigo = $cursos['codigo'];
    $nombre = $cursos['nombre'];
    $turno = $cursos['turno'];
    $tutor = getIdProfesorFromCodigo($cursos['tutor']);
    $departamento = $cursos['departamento'];
    
    $query = "INSERT INTO grupos VALUES('$codigo','$nombre','$turno','$tutor','$departamento')";
    $conn->query($query);
    
}


