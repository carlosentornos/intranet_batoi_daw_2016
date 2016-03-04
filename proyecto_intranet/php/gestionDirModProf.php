<?php

session_start();
require_once "Classes/Class_DB.php";
$errors;
global $errors;
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "No puedes acceder a la admnistracion de usuarios si no estas previamente identificado";
    header("Location:login.php");
} else {
    if ($_SESSION['userType'] != "direccion") {
        header("Location:controlPanel.php");
        $_SESSION['error'] = "No dispones de suficientes permisos para poder editar los datos de los profesores.";
    }

    //Falta hacer las validaciones (if....). Si el mensaje devuelto por cada funcion es distinto de "ok", 
    //se irá añadiendo el mensaje devuelto a un array de errores. Si el array contiene datos, lo enviaremos a la funcion SendJSON,
    //indicandole el key como "error" y pasandole como segundo parametro el array de errores.
    //Si el array esta vacio, querrá decir que las validaciones han sido correctas y se procederá a realizar lo que estoy haciendo.
    include 'config.php';
    $db = new DB($ip, $user, $pass, $db);
    $db->Connect();
    $conn = $db->GetConn();

    updateData();
    //valData();
}
/**
 * Se validan los campos y devuelve errores en el caso de que existan
 * @global String[] $errors
 * @return String[] devuelve una array de Strings
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
 * Si no hay ningun error se recogen los datos se hace el update y devuelve un Ok en forma de JSON
 * @global type $conn
 */
function updateData() {

    global $conn;
    if (count(valData()) == 0) {
        $departamento = getCodDepartamento($_POST['departamento']);
        $codigo = $_POST['codigo'];
        $codhorario = $_POST['codhorario'];
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
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


        $query = "UPDATE `profesores` SET `cod_horario`=$codhorario,`dni`='$dni',`nombre`='$nombre',`apellido1`='$apellido1',
                `apellido2`='$apellido2',`email`='$email',`email_alumnos`='$emailalumnos',`fecha_baja`=$fechabaja,`foto`=$foto,
                `domicilio_particular`='$domicilioparticular',`domicilio`='$domicilio',`movil1`='$movil1',`movil2`=$movil2,`perfil_acceso`='$perfilacceso',
                `departamentos_DEPARTA`=$departamento,`sexo`='$sexo',`fecha_ingreso`='$fechaingreso',`provincia`='$provincia',`municipio`='$municipio',
                `cod_postal`='$codpostal',`fecha_nac`='$fechanac',`fecha_antiguedad`=$fechaantiguedad,`sustituye_a`=$sustituye WHERE codigo=$codigo;";



        $result = $conn->query($query);
       


        if ($result)
            SendJSON('ok', 'Los cambios se han guardado correctamente.');
        else
            SendJSON('error', 'Ha habido un error con la base de datos, vuelva a intentarlo mas tarde o contacte con el administrador del sistema.');
    }else {
        SendJSON("error", valData());
    }
}
/**
 * Funcion para poder añadir nulls en la bd
 * @param String $prueba
 * @return String
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
 * Devuelve codigo del grupo
 * @global type $conn
 * @param String $nombre nombre del grupo
 * @return String
 */
function getCodGrupo($nombre) {
    global $conn;

    $query = "SELECT grupos.codigo from grupos WHERE grupos.nombre='$nombre';";
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $val = $row['codigo'];
        }
        return $val;
    }
}
/**
 * Devuelve el codigo del departamento
 * @global type $conn
 * @param String $nombre nombre del departmento
 * @return String
 */
function getCodDepartamento($nombre) {
    global $conn;

    $query = "SELECT departamentos.departa from departamentos WHERE departamentos.CLITERAL='$nombre';";
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $val = $row['departa'];
        }
        return $val;
    }
}

//hacemos el json con los mensajes de error o confirmacion. Hacemos el echo para que ajax lo reciba.
/**
 * Devuelve un JSON
 * @param String $key Error y ok
 * @param String $value los errores o info
 */
function SendJSON($key, $value) {
    $arr = array($key => $value);
    echo json_encode($arr);
}
