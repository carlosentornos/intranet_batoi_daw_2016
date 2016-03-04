<?php

function getFechaFormatoIngles($fecha) {

    $fecha = str_replace('/', '-', $fecha);
    $fecha2 = date_create_from_format('j-m-Y', $fecha);
    var_dump($fecha2);
    if (!$fecha2) {
        return "";
    } else {
        return $fecha2->format('Y-m-d');
    }
}

function getNombreMunicipio($codigoMunicipio, $codigoProvincia) {
    $codigoProvincia = str_pad($codigoProvincia, 2, "0", STR_PAD_LEFT);
    $codigoMunicipio = str_pad($codigoMunicipio, 4, "0", STR_PAD_LEFT);

    global $conn;
    $query = "SELECT municipio from municipios where cod_municipio = '$codigoMunicipio' AND provincias_id = '$codigoProvincia'";
    $result = $conn->query($query);
    $row = mysqli_fetch_array($result);
    return $row['municipio'];
}

function getNombreProvincia($codigoProvincia) {
    $codigoProvincia < 10 ? $codigoProvincia = '0' . $codigoProvincia : $codigoProvincia;
    global $conn;
    $query = "SELECT nombre from provincias where id = '$codigoProvincia'";
    $result = $conn->query($query);
    $row = mysqli_fetch_array($result);
    return $row['nombre'];
}

function getStringDomicilio($curso) {
    $tipoVia = ($curso['tipo_via'] == '' ? 'Vacio' : $curso['tipo_via']);
    $domicilio = ($curso['domicilio'] == '' ? 'Vacio' : $curso['domicilio']);
    $numero = ($curso['numero'] == '' ? 'Vacio' : $curso['numero']);
    $puerta = ($curso['puerta'] == '' ? 'Vacio' : $curso['puerta']);
    $escalera = ($curso['escalera'] == '' ? 'Vacio' : $curso['escalera']);
    $piso = ($curso['piso'] == '' ? 'Vacio' : $curso['piso']);
    $letra = ($curso['letra'] == '' ? 'Vacio' : $curso['letra']);

    $direccionFinal = "Tipo de via: $tipoVia Dirección: $domicilio Nº: $numero "
            . "Puerta: $puerta Escalera: $escalera Piso: $piso Letra: $letra";

    return $direccionFinal;
}

function getIdProfesorActual($dni) {
    global $conn;
    $query = "SELECT id from profesores where dni = '$dni'";
    $result = $conn->query($query);
    $row = mysqli_fetch_array($result);
    return $row['id'];
}

function setCodigoProfesor() {
    $codigos = getCodigos();
    //$integerIDs = array_map('intval', explode(',', $codigos));
    do {
        $code = rand(1000, 9999);
        $disponible = in_array($code, $codigos);
    } while ($disponible == true);
    return $code;
}

function getCodigos() {
    global $conn;
    $query = "SELECT codigo from profesores";
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $val[] = $row['codigo'];
        }
        return $val;
    } else {
        $codigo = [];
        $codigo[] = '1000';
        return $codigo;
    }
}

function getIdAlumnoActual($dni) {
    global $conn;
    $query = "SELECT id from alumnos where dni = '$dni'";
    $result = $conn->query($query);
    $row = mysqli_fetch_array($result);
    return $row['id'];
}

function getIdProfesorFromCodigo($dniProfesor) {
    global $conn;
    $query = "SELECT codigo from profesores where dni = '$dniProfesor'";
    $result = $conn->query($query);
    $row = mysqli_fetch_array($result);
    return $row['codigo'];
}

function EncryptPassword($password, $digito = 7) {
    $salt = sprintf('$2a$%02d$', $digito);
    $salt .= "1jd4jal9dmna3q941jdlc2";
    return crypt($password, $salt);
}
