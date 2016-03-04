<?php 
    session_start();
    require_once "Classes/Class_DB.php";
    $errors;
    if (!isset($_SESSION['user'])) {
        $_SESSION['error']="No puedes acceder a la admnistracion de usuarios si no estas previamente identificado";
        header("Location:login.php");
    }else{
        if($_SESSION['userType'] != 'alumno'){
			$_SESSION['error']="No dispones de permisos suficientes para poder acceder a la administracion de usuarios";
			header("Location:controlPanel.php");
		}
	}
        
	include 'config.php';
	$db = new DB($ip, $user, $pass, $db);
	$db->Connect();
	$conn = $db->GetConn();
	updateUser();
    /**
     * Se validan los campos y devuelve errores en el caso de que existan
     * @global String[] $errors
     * @return String[] devuelve una array de Strings
     */
	function valData(){
	    include 'Utils_Validations/Utils_Validation.php';
		global $errors;

	    $email = valEmail($_POST['email'], "Email");
	    if ($email != "Ok") {
	        $errors[] = $email;
	    }

	    $antiguapass = valPassword($_POST['oldPass'], "Contraseña antigua");
	    if ($antiguapass != "Ok") {
	        $errors[] = $antiguapass;
	    }

	    $pass = valPassword($_POST['newPass'], "Contraseña ");
	    if ($pass != "Ok") {
	        $errors[] = $pass;
	    }


	    return $errors;
	}

    /**
     * Realiza el update al user si no ha habido ningun error
     * @global type $conn
     */    
    function updateUser(){
		
		global $conn;
		if (count(valData()) == 0) {
	        if(isset($_POST['newPass']) || $_POST['newPass']!=""){
				
				$id=$_SESSION['userId'];
				$email=$_POST['email'];
				$oldPass=$_POST['oldPass'];
				$newPass=$_POST['newPass'];
				$photo=$_POST['foto'];
				
				if (checkOldPassword($oldPass)){
					$query="UPDATE alumnos SET email= '$email', password='".EncryptPassword($newPass)."', foto='$photo' where id=$id";
					$result=$conn->query($query);
					//echo $result;
					//var_dump($result);
					checkReport($result);
				}else{
					SendJSON('error','La contraseña vieja no coincide con la ya establecida. Revise y vuelva a intentarlo.');
				}
			}else{
				SendJSON('error','El campo contraseña no puede estar vacio. Revise y vuelva a intentarlo.');
			}
	    }else {
        	SendJSON("error", $errors);
   		}

	}
    
    
    //hacemos el json con los mensajes de error o confirmacion. Hacemos el echo para que ajax lo reciba.
    /**
     * Devuelve codigo del grupo
     * @global type $conn
     * @param String $nombre nombre del grupo
     * @return String
     */
    function SendJSON($key,$value){
        $arr=array($key=>$value);
        echo json_encode($arr);
    }
    /**
     * Checkea si ha habido errores o no
     * @param type $result
     */
    function checkReport($result){
		if($result)
            SendJSON('ok','Los cambios se han guardado correctamente.');
        else
            SendJSON('error','Ha habido un error con la base de datos, vuelva a intentarlo mas tarde o contacte con el administrador del sistema.');
	}
	/**
         * Comprueba la antigua contraseña si es correcta con la que hemos escrito
         * @global type $conn
         * @param String $password contraseña
         * @return boolean
         */
	function checkOldPassword($password){
		global $conn;
		$id=$_SESSION['userId'];
		//echo EncryptPassword($password);
		//echo $id;
		$query="select * from alumnos where id=$id and password='".EncryptPassword($password)."'";
		$result=$conn->query($query);
		if($result->num_rows!=0){
			return true;
		}else{
			return false;
		}
	}
	/**
         * Encripta la contraseña y la devuelve encriptada
         * @param String $password
         * @param String $digito
         * @return String
         */
	function EncryptPassword($password, $digito = 7) {
        $salt = sprintf('$2a$%02d$', $digito);
        $salt .= "1jd4jal9dmna3q941jdlc2";
        return crypt($password, $salt);
    }
    
    



?>
