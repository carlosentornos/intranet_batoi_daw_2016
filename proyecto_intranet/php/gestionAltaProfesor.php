<?php

session_start();
require_once "Classes/Class_DB.php";
$errors;
include 'config.php';
$db = new DB($ip, $user, $pass, $db);
$db->Connect();
$conn = $db->GetConn();

setAltaProfesor();
/**
 * Esta funcion se utilizará para validar los datos que nos lleguen del cliente.
 * @global type $errors Esta funcion utilizará la variable global errors.
 * @return type Esta funcion devolvera los errores que se encuentren en forma de array.
 */
function valData() {
    include 'Utils_Validations/Utils_Validation.php';
    global $errors;

    $dni = valDni($_POST['dni'], "Dni");

    if ($dni != "Ok") {
        $errors[] = $dni;
    }

    $name = valNameSurname($_POST['nombre'], "Nombre");
    if ($name != 'Ok') {
        $errors[] = $name;
    }

    $firstSurname = valNameSurname($_POST['apellido1'], "Primer apellido");
    if ($firstSurname != 'Ok') {
        $errors[] = $firstSurname;
    }

    $secondSurname = valNameSurname($_POST['apellido2'], "Segundo apellido");
    if ($secondSurname != 'Ok') {
        $errors[] = $secondSurname;
    }

    $email = valEmail($_POST['email'], "Email");
    if ($email != 'Ok') {
        $errors[] = $email;
    }

    $emailAlumn = valEmail($_POST['emailAlumnos'], "Email");
    if ($emailAlumn != 'Ok') {
        $errors[] = $emailAlumn;
    }

    $gender = valGender($_POST['sexo'], "Sexo");
    if ($gender != 'Ok') {
        $errors[] = $gender;
    }


    $zipCode = valZipCode($_POST['cp'], "Codigo postal");
    if ($zipCode != 'Ok') {
        $errors[] = $zipCode;
    }


    $firstTelephone = valTelephone($_POST['movil1'], "Movil1");
    if ($firstTelephone != 'Ok') {
        $errors[] = $firstTelephone;
    }

    $secondTelephone = valTelephone($_POST['movil2'], "Movil2");
    if ($secondTelephone != 'Ok') {
        $errors[] = $secondTelephone;
    }

    $timetableCod = valTimetableCode($_POST['codhorario'], "Horario");
    if ($timetableCod != 'Ok') {
        $errors[] = $timetableCod;
    }

    $dateOut = valDateNotRequired($_POST['fechaBaja'], "Fecha de baja");
    if ($dateOut != 'Ok') {
        $errors[] = $dateOut;
    }

    /* tema de fotos */

    $particularAddress = valAddressNotRequired($_POST['domicilioParticular'], "Domicilio particular");
    if ($particularAddress != 'Ok') {
        $errors[] = $particularAddress;
    }

    $department = valDepartment($_POST['departamento'], "Departamento");
    if ($department != 'Ok') {
        $errors[] = $department;
    }

    $address = valAddress($_POST['domicilio'], "Domicilio");
    if ($address != 'Ok') {
        $errors[] = $address;
    }

    $profileAccess = valProfileAccess($_POST['perfilAcceso'], "Perfil de acceso");
    if ($profileAccess != 'Ok') {
        $errors[] = $profileAccess;
    }

    $dateIn = valDate($_POST['fechaIngreso'], "Fecha de ingreso");
    if ($dateIn != 'Ok') {
        $errors[] = $dateIn;
    }

    $dateBorn = valDate($_POST['fechaNacimiento'], "Fecha de nacimiento");
    if ($dateBorn != 'Ok') {
        $errors[] = $dateBorn;
    }

    $dateService = valDateNotRequired($_POST['fechaAntiguedad'], "Fecha de antigüedad");
    if ($dateService != 'Ok') {
        $errors[] = $dateService;
    }

    $sustitute = valSustitute($_POST['sustituye'], "Sustituye");
    if ($sustitute != 'Ok') {
        $errors[] = $sustitute;
    }

    return $errors;
}
/**
 * Esta funcion se utilizará para dar de alta nuevos profesores.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @global type $errors Esta funcion utilizará la variable global errors.
 */
function setAltaProfesor() {

    global $conn;
    global $errors;

    if (count(valData()) == 0) {
        $departamento = getCodDepartamento($_POST['departamento']);
        $codigo = setCodigoProfesor();
        $codhorario = $_POST['codhorario'];
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $password = EncryptPassword($_POST['password']);
        $email = $_POST['email'];
        $emailalumnos = $_POST['emailAlumnos'];
        $fechabaja = setNull($_POST['fechaBaja']);
        $foto = setNull($_POST['foto']);
        $sexo = $_POST['sexo'];
        $domicilioparticular = $_POST['domicilioParticular'];
        $domicilio = $_POST['domicilio'];
        $movil1 = $_POST['movil1'];
        $movil2 = setNull($_POST['movil2']);
        $perfilacceso = $_POST['perfilAcceso'];
        $fechaingreso = $_POST['fechaIngreso'];
        $provincia = $_POST['provincia'];
        $municipio = $_POST['municipio'];
        $codpostal = $_POST['cp'];
        $fechanac = $_POST['fechaNacimiento'];
        $fechaantiguedad = setNull($_POST['fechaAntiguedad']);
        $sustituye = setNull($_POST['sustituye']);
        
        $query = "INSERT INTO profesores
			VALUES($codigo,$codhorario,'$dni','$nombre','$apellido1','$apellido2','$password','$email','$emailalumnos',$fechabaja,$foto,
			'$domicilioparticular','$domicilio','$movil1',$movil2,'$perfilacceso',$departamento,'$sexo','$fechaingreso','$provincia',
			'$municipio','$codpostal','$fechanac',$fechaantiguedad,$sustituye)";

        $result = $conn->query($query);
        
        if ($result)
            SendJSON('ok', 'Los cambios se han guardado correctamente.');
        else
            SendJSON('error', 'Ha habido un error con la base de datos, vuelva a intentarlo mas tarde o contacte con el administrador del sistema.');
    }else {
        SendJSON("error", $errors);
    }
}

/**
 * Esta funcion se utilizara para establecer valores nulos en la base de datos en caso de que esten vacios.
 * @param type $prueba Esta variable recogera una cadena de texto determinada.
 * @return type Esta funcion devolvera la cadena de texto.
 */
function setNull($prueba){
     if ($prueba === "") {
            $prueba = "NULL";
        } else {
            $prueba = "'$prueba'";
        }
    return $prueba;
}

/**
 * Esta funcion se utilizará para generar el reporte final al cliente
 * @param type $key Esta variable recogerá un "ok" o un "error", dependiendo del tipo de mensaje especificado.
 * @param type $value Esta variable recogerá el mensaje que se le mostrará al cliente.
 */
function SendJSON($key, $value) {
    $arr = array($key => $value);
    echo json_encode($arr);
}
/**
 * Esta funcion generará un codigo aleatorio de 4 digitos que no exista en la base de datos.
 * @return type Esta funcion devolvera un codigo de 4 digitos.
 */
function setCodigoProfesor() {
    $codigos = getCodigos();

    //$integerIDs = array_map('intval', explode(',', $codigos));
    do {
        $code = rand(1000, 1020);
        $disponible = in_array($code, $codigos);
    } while ($disponible == true);
    return $code;
}
/**
 * Esta funcion se utilizará para recoger todos los codigos de los profesores.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @return type Esta funcion devolverá un array con los codigos.
 */
function getCodigos() {
    global $conn;
    $query = "SELECT codigo from profesores";
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $val[] = $row['codigo'];
        }
        return $val;
    }
}
/**
     * Esta funcion será utilizada para encriptar la contraseña.
     * @param type $password Esta variable recogera la contraseña del usuario.
     * @param type $digito Esta variable será utilizada para establecer el salt siempre el mismo.
     * @return type Esta función devolverá la contraseña encriptada.
     */
function EncryptPassword($password, $digito = 7) {
    $salt = sprintf('$2a$%02d$', $digito);
    $salt .= "1jd4jal9dmna3q941jdlc2";
    return crypt($password, $salt);
}
/**
 * Esta funcion se utilizará para saber el codigo de un departamento determinado.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @param type $departamento Este parametro recogera el nombre del departamento.
 * @return type Esta funcion devolverá el codigo de departamento especificado.
 */
function getCodDepartamento($departamento) {
    global $conn;
    $query = "SELECT departa from departamentos where CLITERAL='$departamento'";
    $result = $conn->query($query);
    if ($result->num_rows != 0) {
        while ($row = mysqli_fetch_array($result)) {
            $val = $row['departa'];
        }
        return $val;
    }
}

?>
