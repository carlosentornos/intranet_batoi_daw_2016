<?php

class Class_Alumnos {
    private $dni;
    private $nombre;
    private $apellido1;
    private $apellido2;
    private $password;
    private $email;
    //private $grupo;
    private $fechanac;
    private $foto;
    private $nia;
    private $sexo;
    private $expediente;
    private $cod_postal;
    private $domicilio;
    private $provincia;
    private $municipio;
    private $telefono1;
    private $telefono2;
    private $observaciones;
    private $fecha_matricula;
    private $fecha_ingreso_centro;
    private $estado_matricula;
    private $repite;
    private $turno;
    private $trabaja;
    
    function getDni() {
        return $this->dni;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellido1() {
        return $this->apellido1;
    }

    function getApellido2() {
        return $this->apellido2;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail() {
        return $this->email;
    }

    function getFechanac() {
        return $this->fechanac;
    }

    function getFoto() {
        return $this->foto;
    }

    function getNia() {
        return $this->nia;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getExpediente() {
        return $this->expediente;
    }

    function getCod_postal() {
        return $this->cod_postal;
    }

    function getDomicilio() {
        return $this->domicilio;
    }

    function getProvincia() {
        return $this->provincia;
    }

    function getMunicipio() {
        return $this->municipio;
    }

    function getTelefono1() {
        return $this->telefono1;
    }

    function getTelefono2() {
        return $this->telefono2;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getFecha_matricula() {
        return $this->fecha_matricula;
    }

    function getFecha_ingreso_centro() {
        return $this->fecha_ingreso_centro;
    }

    function getEstado_matricula() {
        return $this->estado_matricula;
    }

    function getRepite() {
        return $this->repite;
    }

    function getTurno() {
        return $this->turno;
    }

    function getTrabaja() {
        return $this->trabaja;
    }

    function setDni($dni) {
        $this->dni = $dni;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido1($apellido1) {
        $this->apellido1 = $apellido1;
    }

    function setApellido2($apellido2) {
        $this->apellido2 = $apellido2;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFechanac($fechanac) {
        $this->fechanac = $fechanac;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    function setNia($nia) {
        $this->nia = $nia;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setExpediente($expediente) {
        $this->expediente = $expediente;
    }

    function setCod_postal($cod_postal) {
        $this->cod_postal = $cod_postal;
    }

    function setDomicilio($domicilio) {
        $this->domicilio = $domicilio;
    }

    function setProvincia($provincia) {
        $this->provincia = $provincia;
    }

    function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }

    function setTelefono1($telefono1) {
        $this->telefono1 = $telefono1;
    }

    function setTelefono2($telefono2) {
        $this->telefono2 = $telefono2;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    function setFecha_matricula($fecha_matricula) {
        $this->fecha_matricula = $fecha_matricula;
    }

    function setFecha_ingreso_centro($fecha_ingreso_centro) {
        $this->fecha_ingreso_centro = $fecha_ingreso_centro;
    }

    function setEstado_matricula($estado_matricula) {
        $this->estado_matricula = $estado_matricula;
    }

    function setRepite($repite) {
        $this->repite = $repite;
    }

    function setTurno($turno) {
        $this->turno = $turno;
    }

    function setTrabaja($trabaja) {
        $this->trabaja = $trabaja;
    }


}
