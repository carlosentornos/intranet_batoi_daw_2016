<?php

session_start();
require_once("Classes/Class_Auth.php");
if(isset($_SESSION['error'])){
    unset($_SESSION['error']);
}

$type;

if ($_POST['usuario'] === "" || $_POST['pass'] === "") {
    $errormsg = "Los campos del login no pueden estar vacios, rellene los campos y vuelva a intentarlo";
    echo $msg;
} else {

    if (getTypeUser($_POST['usuario']) === "ok") {

        $log = new Auth();
        $test = $log->Login($_POST['usuario'], $_POST["pass"], $type);

        if ($test !== "ok"){
            echo $test;
        }else{
            echo "controlPanel.php";
        }     
    }
}
/**
 * Esta funcion se utilizará para saber el tipo de usuario que se va a loguear.
 * @global type $type Esta funcion utilizara la variable global type, donde se recogera el tipo de usuario.
 * @param type $firstVal Este parametro recogerá el codigo de usuario, tanto si es dni como codigo de 4 digitos.
 * @return string Esta funcion devolvera un mensaje en caso de que el codigo no cumpla el formato especificado.
 */
function getTypeUser($firstVal) {
    global $type;
    $msg = "ok";

    if (strlen($firstVal) == 9 && ctype_alpha(substr($firstVal, -1))) {
        $type = "alumno";
    } else {
        if (strlen($firstVal) == 4) {
            $type = "profesor";
        } else {
            $msg = "El campo usuario no cumple con la estructura adecuada, compruebe el campo y vuelva a intentarlo";
            echo $msg;
        }
    }
    return $msg;
}

?>
