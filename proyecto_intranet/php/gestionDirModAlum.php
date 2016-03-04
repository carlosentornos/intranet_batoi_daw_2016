<?php

session_start();
require_once "Classes/Class_DB.php";
$errors;
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "No puedes acceder a la admnistracion de usuarios si no estas previamente identificado";
    header("Location:login.php");
} else {
    if ($_SESSION['userType'] != "direccion") {
        header("Location:controlPanel.php");
        $_SESSION['error'] = "No dispones de suficientes permisos para poder editar los datos de los alumnos.";
    }
    include 'config.php';
    $db = new DB($ip, $user, $pass, $db);
    $db->Connect();
    $conn = $db->GetConn();

    updateData();
}
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

    $nia = valNia($_POST['nia'], "Nia");
    if ($nia != 'Ok') {
        $errors[] = $nia;
    }

    $gender = valGender($_POST['sexo'], "Sexo");
    if ($gender != 'Ok') {
        $errors[] = $gender;
    }



    $zipCode = valZipCode($_POST['codpostal'], "Codigo postal");
    if ($zipCode != 'Ok') {
        $errors[] = $zipCode;
    }



    $firstTelephone = valTelephone($_POST['telefono1'], "Telefono1");
    if ($firstTelephone != 'Ok') {
        $errors[] = $firstTelephone;
    }

    $secondTelephone = valTelephone($_POST['telefono2'], "Telefono2");
    if ($secondTelephone != 'Ok') {
        $errors[] = $secondTelephone;
    }

    $observations = valObservations($_POST['observaciones'], "Observaciones");
    if ($observations != 'Ok') {
        $errors[] = $observations;
    }



    $registerState = valRegisterState($_POST['estadomatricula'], "Estado de la matrícula");
    if ($registerState != 'Ok') {
        $errors[] = $registerState;
    }

    $repeat = valRepeat($_POST['repite'], "Repite");
    if ($repeat != 'Ok') {
        $errors[] = $repeat;
    }

    $working = valWorking($_POST['trabaja'], "Trabaja");
    if ($working != 'Ok') {
        $errors[] = $working;
    }

    /* raul: ahora los datos vienen en un array, pueden ser varios grupos, habra que hacer un loop
      $group = valGroupName($_POST['grupo'],"Grupo");
      if($group!='Ok'){
      $errors[] = $group;
      }
     */

    $turn = valTurn($_POST['turno'], "Turno");
    if ($turn != 'Ok') {
        $errors[] = $turn;
    }

    return $errors;
}
/**
 * Esta funcion se utilizará para modificar los datos del alumno.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @global type $errors Esta funcion utilizará la variable global errors.
 */
function updateData() {

    global $conn;
    global $errors;

    if (count(valData()) == 0) {

        $id = $_POST['id'];
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $email = $_POST['email'];
        $nacimiento = $_POST['nacimiento'];
        $nia = $_POST['nia'];
        $sexo = $_POST['sexo'];
        $expediente = $_POST['expediente'];
        $codpostal = $_POST['codpostal'];
        $domicilio = $_POST['domicilio'];
        $provincia = $_POST['provincia'];
        $municipio = $_POST['municipio'];
        $telefono1 = $_POST['telefono1'];
        $telefono2 = $_POST['telefono2'];
        $observaciones = $_POST['observaciones'];
        $fechamatricula = $_POST['fechamatricula'];
        $fechaingresocentro = $_POST['fechaingresocentro'];
        $estadomatricula = $_POST['estadomatricula'];
        $repite = $_POST['repite'];
        $turno = $_POST['turno'];
        $trabaja = $_POST['trabaja'];
        $foto = $_POST['foto'];

        //actualizar grupos
        $gruposnuevos = $_POST['gruposNuevos'];


        deleteGrupos($id);

        for ($x = 0; $x < count($gruposnuevos); $x++) {
            updateGrupo($id, $dni, $nia, getCodGrupo($gruposnuevos[$x]));
        }

        //actualizar alumno
        $query = "UPDATE alumnos 
			SET dni='$dni', nombre='$nombre',apellido1='$apellido1',apellido2='$apellido2',email='$email',fecha_nac='$nacimiento',
			foto='$foto',nia='$nia',sexo='$sexo',expediente='$expediente',cod_postal='$codpostal',domicilio='$domicilio',provincia='$provincia',
			municipio='$municipio',telefono1='$telefono1',telefono2='$telefono2',observaciones='$observaciones',fecha_matricula='$fechamatricula',
			fecha_ingreso_centro='$fechaingresocentro',estado_matricula='$estadomatricula',repite='$repite',turno='$turno',trabaja='$trabaja' 
			WHERE id=$id;";

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
 * Esta funcion se utilizará para saber el codigo de un grupo determinado.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @param type $nombre Este parametro recogera el nombre del grupo.
 * @return type Esta funcion devolverá el codigo del grupo especificado.
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
 * Esta funcion se utilizará para generar el reporte final al cliente
 * @param type $key Esta variable recogerá un "ok" o un "error", dependiendo del tipo de mensaje especificado.
 * @param type $value Esta variable recogerá el mensaje que se le mostrará al cliente.
 */
function SendJSON($key, $value) {
    $arr = array($key => $value);
    echo json_encode($arr);
}
/**
 * Esta funcion se utilizará para actualizar los grupos de un alumno en concreto.
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @param type $id Este parametro recogera el id del alumno.
 * @param type $dni Este parametro recogera el dni del alumno.
 * @param type $nia Este parametro recogera el nia del alumno.
 * @param type $codeGroup Este parametro recogera el codigo del grupo.
 */
function updateGrupo($id, $dni, $nia, $codeGroup) {
    global $conn;

    $query = "INSERT INTO alumnos_has_grupos VALUES('$id','$nia','$dni','$codeGroup')";
    $result = $conn->query($query);
}
/**
 * Esta funcion se utilizara para eliminar todos los grupos asociados a un alumno
 * @global type $conn Esta variable global será necesaria para recoger la informacion de la base de datos.
 * @param type $id Este parametro recogera el identificador del alumno.
 */
function deleteGrupos($id) {
    global $conn;

    $query = "DELETE from alumnos_has_grupos where alumnos_id=$id";
    $result = $conn->query($query);
}

?>
