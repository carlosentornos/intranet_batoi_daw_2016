<?php

header('Content-Type: application/pdf');
require_once "fpdf/fpdf.php";
require_once "../Classes/Class_DB.php";

date_default_timezone_set('Europe/Madrid');

class pdf extends fpdf {
    /**
     * Aqui se genera el header
     */
    function header1() {

        utf8_decode('Formació en centres de treball');
        // Logo
        $this->SetFont('Arial', 'B', 6);
        $this->Image('Imagenes/Conselleria-B_CON.jpg', 8, 8, 60);
        //posicionamiento de la siguiente celda debajo de el logo
        $this->setY(22);
        $this->Cell(1);
        $this->Cell(20, 10, 'Tel - 966 52 76 60 - Fax: 966 52 76 61', 0, 1);
        //siguiente linea
        $this->setY(24);
        $this->Cell(1);
        $this->Cell(20, 10, 'e-mail: 03012165.secret@edu.gva.es', 0, 1);
        //siguiente linea
        $this->setY(26);
        $this->Cell(1);
        $this->Cell(20, 10, 'http://cipfpbatoi.edu.gva.es/', 0, 1);

        //siguiente logo, batoi
        $this->Image('Imagenes/cipfpbatoi.jpg', 97, 8, 20);
        $this->setY(26);
        $this->Cell(85);
        $this->Cell(20, 10, 'C/ Serreta, 5 - 03802', 0, 1);

        //logo pajaro
        $this->Image('Imagenes/FSEpos_val.jpg', 160, 8, 30);
        $this->setY(26);
        $this->Cell(140);
        //$this->Cell(20, 10, utf8_decode('Formació en centres de treball'), 0, 1);
        //saltos de linea despues de la cabecera
        $this->Ln(20);	
    }
    /**
     * Se genera aqui el primer parrrafo
     * @param String $nombre
     * @param String $apellido1
     * @param String $apellido2
     * @param String $dni
     * @param String $fecha
     * @param String $nombreAct
     * @param String $horaIni
     * @param String $horaFin
     */
    function p1($nombre, $apellido1, $apellido2, $dni, $fecha, $nombreAct, $horaIni, $horaFin) {
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(5);
        $this->Cell(10, 10, utf8_decode('Asistencia a actividad extraescolar.'), 0, 1);
        $this->ln();
        $this->SetFont('Arial', '', 13);
        $this->Cell(5);
        $this->MultiCell(0, 8, utf8_decode('D/Dña __________________________________________________ padre/madre o tutor/tutora de '.$nombre.', '.$apellido1.' '.$apellido2.' con dni '.$dni.' autorizo a que asista a la actividad extraescolar: '.$nombreAct.' que se realizará en la fecha: '.$fecha.'. Tendrá como hora de inicio las '.$horaIni.' y hora de vuelta las '.$horaFin.'.'), 0);
    }
    /**
     * Se genera aqui el segundo parrrafo
     * @param type $descripcion
     */
    function p2($descripcion){
        $this->ln();
        $this->SetFont('Arial', '', 13);
        $this->Cell(5);
        $this->MultiCell(0, 8, utf8_decode('La siguiente actividad consiste en: '.$descripcion.'.'), 0);
    }
    /**
     * Se genera aqui el footer
     */
    function footer1() {
        $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        $this->ln(75);
        $this->SetFont('Arial', '', 13);
        $this->Cell(60);
        $this->MultiCell(0, 8, utf8_decode('En Alcoi, a ' . date("j") . ' de ' . $meses[date("n") - 1] . ' de ' . date("o")), 0);
        $this->Cell(5);
        $this->MultiCell(0, 50, utf8_decode('Firma padre/madre o tutor/tutora:________________________'), 0);
    }

}


    $id= $_REQUEST['id'];

    include '../config.php';
    $db = new DB($ip, $user, $pass, $db);
    $db->Connect();
    $conn = $db->GetConn();
    $conn->set_charset('utf8');

    $query = "SELECT alumnos.dni, alumnos.nombre, alumnos.apellido1, alumnos.apellido2, fecha_realizacion, fecha_nac, actividades_extraescolares.nombre AS nomAct, actividades_extraescolares.descripcion, hora_inicio, hora_fin FROM alumnos INNER JOIN alumnos_has_grupos ON alumnos.id = alumnos_has_grupos.alumnos_id INNER JOIN grupos ON alumnos_has_grupos.grupos_codigo = grupos.codigo INNER JOIN grupos_has_actividades_extraescolares ON grupos.codigo = grupos_has_actividades_extraescolares.grupos_codigo INNER JOIN actividades_extraescolares ON grupos_has_actividades_extraescolares.actividades_extraescolares_codigo = actividades_extraescolares.codigo WHERE actividades_extraescolares.codigo =$id GROUP BY alumnos.dni ";
    $pdf = new pdf();

    $result = $conn->query($query);
     $rowcount=mysqli_num_rows($result);
     if($rowcount>0){
         while($row = $result->fetch_assoc()) {
           if(calculaedad($row['fecha_nac'])<18){
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->header1();
                $pdf->p1($row['nombre'],$row['apellido1'],$row['apellido2'],getDni($row['dni']),$row['fecha_realizacion'],$row['nomAct'],$row['hora_inicio'],$row['hora_fin']);
                $pdf->p2($row['descripcion']);
                $pdf->footer1();
            }
        }
    }

echo base64_encode($pdf->Output('documento.pdf', 'I', true));

/**
 * Calcula la edad
 * @param String $fechanacimiento
 * @return String
 */
function calculaedad($fechanacimiento){
    list($ano,$mes,$dia) = explode("-",$fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
    return $ano_diferencia;
}
/**
 * Formatea el dni
 * @param String $dni
 * @return String
 */
function getDni($dni){
    $aux= substr($dni, 0,1);
    if($aux=="0"){
        return substr($dni, 1,strlen($dni));
    }else{
        return substr($dni, 2, strlen($dni));
    }
}
/**
 * Obtienes el dia
 * @param String $val
 * @return date
 */
function getDay($val) {
    $timestamp = strtotime($val);
    return date('d', $timestamp);
}
/**
 * Obtienes el año
 * @param String $val
 * @return date
 */
function getYear($val) {
    $timestamp = strtotime($val);
    return date('Y', $timestamp);
}
/**
 * Obtienes el mes
 * @param String $val
 * @return date
 */
function getMonth($val) {
    $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    $timestamp = strtotime($val);
    return $meses[date('n', $timestamp) - 1];
}


