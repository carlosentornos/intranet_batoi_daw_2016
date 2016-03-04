<?php

class DB {
    
    private $server;
    private $bd_name;
    private $password;
    private $user;
    private $conn;
    /**
     * Constructor de la DB
     * @param String $server Servidor
     * @param String $user Ususario
     * @param String $password Constraseña
     * @param Stirng $bd_name Nombre de la base de datos
     */
    public function __construct($server, $user, $password, $bd_name) {
        $this->server = $server;
        $this->bd_name = $bd_name;
        $this->password = $password;
        $this->user = $user;
    }
    /**
     * Devuelve el server
     * @return String
     */
    public function GetServer() {
        return $this->server;
    }
    /**
     * Devuelve el nombre de la base de datos
     * @return String
     */
    public function GetBd_Name() {
        return $this->bd_name;
    }
    /**
     * Devuelve la pass
     * @return String
     */
    public function GetPassword() {
        return $this->password;
    }
    /**
     * Devuelve el usuario
     * @return String
     */
    public function GetUser() {
        return $this->user;
    }
    /**
     * Devuelve la conexion
     * @return String
     */
    public function GetConn() {
        return $this->conn;
    }
    /**
     * Set del Servever
     * @param String $var Metes el server
     */
    public function SetServer($var) {
        $this->server = $var;
    }
    /**
     * Set del nombre de la base de datos
     * @param String $var Metes el nombre de la base de datos
     */
    public function SetBd_Name($var) {
        $this->bd_name = $var;
    }
    /**
     * Set de la contraseña
     * @param String $var Metes la contraseña
     */
    public function SetPassword($var) {
        $this->password = $var;
    }
    /**
     * Set del ususario
     * @param String $var Metes el usuario
     */
    public function SetUser($var) {
        $this->user = $var;
    }
    /**
     * Aqui se realiza la conexion
     */
    public function Connect() {

        $this->conn = new mysqli($this->server, $this->user, $this->password, $this->bd_name);

        //echo "Failed to connect to MySQL database: " . mysqli_connect_error();
    }
    /**
     * Cierra la conexion
     */
    public function __destruct() {
        $this->conn->close();
    }

}


