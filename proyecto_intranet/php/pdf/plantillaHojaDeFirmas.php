<?php

require_once "fpdf/fpdf.php";
require_once "../Classes/Class_DB.php";

date_default_timezone_set('Europe/Madrid');

class PDF extends FPDF {

    /**
     * Esta funcion se utilizara para generar el titulo principal.
     */
    function SetTitle() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(5);
        $this->Cell(175, 10, utf8_decode('HOJA DE FIRMAS: CURSO MANIPULADOR DE ALIMENTOS'), 0, 1, 'C');
        $this->ln();
    }

    /**
     * Esta funcion se utilizara para mostrar la informacion del curso en el pdf.
     * @param type $curso Este parametro recogerá el codigo del curso.
     * @param type $fecha Este parametro recogerá la fecha de inicio del curso.
     */
    function SetInfo($curso, $fecha) {
        $fechain = getDay($fecha) . " de " . getMonth($fecha) . " de " . getYear($fecha);

        $this->SetFont('Arial', '', 12);
        $this->SetY(25);
        $this->Cell(10);

        $this->Cell(75, 10, utf8_decode('Codigo del curso: ' . $curso), 0, 1);
        $this->SetY(25);
        $this->Cell(90);
        $this->Cell(70, 10, utf8_decode('Fecha del curso: ' . $fechain), 0, 1);
        $this->ln();
    }

    /**
     * Esta funcion se utilizará para generar la tabla junto con los datos de los alumnos.
     * @param type $nombres Este parametro recogerá un array con los nombres de los alumnos.
     */
    function SetDataTable($nombres) {
        $header = array('Alumnos', 'Firma');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(10);
        foreach ($header as $col)
            $this->Cell(80, 10, $col, 1);
        $this->Ln();

        $this->SetFont('Arial', '', 12);
        foreach ($nombres as $row) {
            $this->Cell(10);
            $this->Cell(80, 14, $row, 1);
            $this->Cell(80, 14, '', 1);
            $this->Ln();
        }
    }

}

include '../config.php';
$db = new DB($ip, $user, $pass, $db);
$db->Connect();
$conn = $db->GetConn();
$conn->set_charset('utf-8');

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetTitle();
$curso = $_GET['curso'];
$pdf->SetInfo($curso, getDateCurso($curso));
$pdf->SetDataTable(getAlumnosCurso($curso));
$pdf->Output();

/**
 * Esta funcion se utilizará para recoger todos los alumnos que estan registrados en un curso determinado.
 * @global type $conn
 * @param type $curso Este parametro recogerá el identificador del curso.
 * @return string Esta funcion devolverá el array con los nombres de los alumnos.
 */
function getAlumnosCurso($curso) {
    global $conn;
    $nombres = array();

    $query = "select alumnos.nombre,alumnos.apellido1 from alumnos inner join alumnos_has_manipulador_alimentos as am on am.alumnos_id=alumnos.id where am.manipulador_alimentos_codigo = '$curso' and am.registrado='s'";
    $result = $conn->query($query);
    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $nombre = $row['nombre'] . ' ' . $row['apellido1'];
            $nombres[] = $nombre;
        }
        return $nombres;
    }
}
/**
 * Esta funcion se utilizará para saber las fechas del curso.
 * @global type $conn
 * @param type $curso Este parametro recogera el identificador del curso.
 * @return type Esta funcion devolvera la fecha de inicio del curso.
 */
function getDateCurso($curso) {
    global $conn;

    $query = "SELECT fecha_inicio FROM manipulador_alimentos WHERE codigo='$curso'";
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $fecha = $row['fecha_inicio'];
        }
        return $fecha;
    }
}
/**
 * Esta funcion se utilizara para saber el dia de una fecha determinada.
 * @param type $val Este parametro recogera la fecha de inicio.
 * @return type
 */
function getDay($val) {
    $timestamp = strtotime($val);
    return date('d', $timestamp);
}
/**
 * Esta funcion se utilizara para saber el año de una fecha determinada.
 * @param type $val Este parametro recogera la fecha de inicio.
 * @return type
 */
function getYear($val) {
    $timestamp = strtotime($val);
    return date('Y', $timestamp);
}
/**
 * Esta funcion se utilizara para saber el mes de una fecha determinada.
 * @param type $val Este parametro recogera la fecha de inicio.
 * @return type
 */
function getMonth($val) {
    $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    $timestamp = strtotime($val);
    return $meses[date('n', $timestamp) - 1];
}

?>
