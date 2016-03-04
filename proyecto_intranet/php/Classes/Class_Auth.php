<?php

require_once 'Classes/Class_DB.php';


class Auth {
    
    
    private $user = null;
    private $apellido1 = null;
    private $apellido2 = null;
    private $conn = null;
    private $errormsg = "ok";
    
    function __construct() {
        
    }

    /**
     * Esta funcion será utilizada para establecer el login del usuario.
     * @param type $code Esta variable recogera el codigo del usuario.
     * @param type $password Esta variable recogera la contraseña del login.
     * @param type $type Esta variable diferenciara si es alumno o profesor.
     * @return type Esta funcion devolverá si ha habido un error en el logeo del usuario.
     */

    public function Login($code, $password, $type) {
        if (!isset($_SESSION))
            session_start();

        include './config.php';
        $db = new DB($ip, $user, $pass, $db);
        $db->Connect();
        $this->conn = $db->GetConn();

        if ($type === 'alumno')
            $this->CheckLoginAlumno($code, $password);
        else
            $this->CheckLoginProfesor($code, $password);

        return $this->errormsg;
    }

    /**
     * Esta funcion será utilizada para encriptar la contraseña.
     * @param type $password Esta variable recogera la contraseña del usuario.
     * @param type $digito Esta variable será utilizada para establecer el salt siempre el mismo.
     * @return type Esta función devolverá la contraseña encriptada.
     */

    private function EncryptPassword($password, $digito = 7) {
        $salt = sprintf('$2a$%02d$', $digito);
        $salt .= "1jd4jal9dmna3q941jdlc2";
        return crypt($password, $salt);
    }

    /**
     * Esta funcion se utilizará para comprobar que el alumno este en la base de datos. En caso de que no lo esté,
     * se le irá indicando un tipo de error determinado. En el caso de que exista, se crearán las variables de sesion
     * correspondientes.
     * 
     * @param type $dni Esta variable recibirá el dni del alumno.
     * @param type $password Esta variable recibirá la contraseña del alumno.
     * @return type Esta funcion devolverá un error o un mensaje de confirmacion.
     */

    private function CheckLoginAlumno($dni, $password) {

        $query = "select * from alumnos where dni like '%$dni'";
        $result = $this->conn->query($query);

        if ($result->num_rows !== 0) {
            $pass = $this->EncryptPassword($password);

            $query = "select * from alumnos where dni like '%$dni' and password='$pass'";
            $result = $this->conn->query($query);

            if ($result->num_rows !== 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $this->user = $row['nombre'];
                    $this->apellido1 = $row['apellido1'];
                    $this->apellido2 = $row['apellido2'];
                    $this->SetSession("alumno",$row['id']);
                   
                }
            } else {
                $this->errormsg = "La contraseña es incorrecta, revise y vuelva a intentarlo";
            }
        } else {
            $this->errormsg = "El nombre de usuario introducido no existe. Revise y vuelva a intentarlo.";
        }
        return $this->errormsg;
    }

    /**
     * Esta funcion se utilizará para comprobar que el profesor este en la base de datos. En caso de que no lo esté,
     * se le irá indicando un tipo de error determinado. En el caso de que exista, se crearán las variables de sesion
     * correspondientes.
     * @param type $codigo Esta variable recibirá el codigo del profesor.
     * @param type $password Esta variable recibirá la contraseña del profesor.
     * @return type Esta funcion devolverá un error o un mensaje de confirmacion.
     */

    private function CheckLoginProfesor($codigo, $password) {

        $query = "select * from profesores where codigo='$codigo'";
        $result = $this->conn->query($query);

        if ($result->num_rows !== 0) {
            $pass = $this->EncryptPassword($password);
            $query = "select * from profesores where codigo ='$codigo' and password='$pass'";
            $result = $this->conn->query($query);

            if ($result->num_rows !== 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $this->user = $row['nombre'];
                    $this->apellido1 = $row['apellido1'];
                    $this->apellido2 = $row['apellido2'];
                    $this->SetSession($row['perfil_acceso'],$row['codigo']);
                }
            } else {
                $this->errormsg = "La contraseña es incorrecta, revise y vuelva a intentarlo";
            }
        } else {
            $this->errormsg = "El nombre de usuario introducido no existe. Revise y vuelva a intentarlo.";
        }
        return $this->errormsg;
    }

    /**
     * Esta funcion se utilizará para desconectar al usuario de la sesion, es decir, cerrar sesion.
     */

    public function Disconnect() {
        if (isset($_SESSION['user'])) {
            session_destroy();
        }
    }

    /**
     * Esta funcion se utilizara para establecer ciertos valores en la sesion del usuario.
     * @param type $type Esta variable recogerá el tipo de usuario (Alumno/Profesor/Direccion)
     * @param type $id Esta variable almacenará el codigo del usuario, tanto si es DNI como codigo de 4 digitos.
     */

    private function SetSession($type,$id) {
        $_SESSION['user'] = $this->user;
        $_SESSION['apellido1'] = $this->apellido1;
        $_SESSION['apellido2'] = $this->apellido2;
        $_SESSION['userType'] = $type;
        $_SESSION['userId']=$id;
    }

}

?>
