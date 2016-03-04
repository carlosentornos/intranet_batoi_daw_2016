<?php

header('Content-Type: application/pdf');
require_once "fpdf/fpdf.php";
require_once "../Classes/Class_DB.php";

date_default_timezone_set('Europe/Madrid');

class pdf extends fpdf {
    /**
     * Esta funcion se utilizará para generar la cabecera del pdf junto con las imagenes.
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
 * Esta funcion se utilizará para generar el primer parrafo del pdf.
 */
    function p1() {
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(5);
        $this->Cell(10, 10, utf8_decode('Andrés Puig Navalón'), 0, 1);
        $this->ln();
        $this->SetFont('Arial', '', 13);
        $this->Cell(5);
        $this->MultiCell(0, 8, utf8_decode('Con DNI número 20823669K, como Director del C.I.P. de F.P.'
                        . ' Batoi, y según el programa de formación de manipuladores de alimentos que se imparte'
                        . ' a los alumnos de este centro,'), 0);
    }
/**
 * Esta funcion se utilizara para generar el parrafo2 del pdf.
 * @param type $name Este parametro recibira el nombre del alumno.
 * @param type $surname1 Este parametro recibira el primer apellido del alumno.
 * @param type $surname2 Este parametro recibira el segundo apellido del alumno.
 * @param type $dni Este parametro recibira el dni del alumno.
 */
    function p2($name, $surname1, $surname2, $dni) {
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(80);
        $this->Cell(10, 10, utf8_decode('CERTIFICA'), 0, 1);
        $this->ln();
        $this->SetFont('Arial', '', 13);
        $this->Cell(5);
        $this->MultiCell(0, 8, utf8_decode('Que D/Dña ' . $name . ' ' . $surname1 . ' ' . $surname2 . ' con DNI número ' . $dni . ' ha recibido la formación '
                        . 'general en prácticas higiénicas de manipulación de alimentos y específica en la actividad de '), 0);
        $this->ln(10);
    }
/**
 * Esta funcion se utilizará para generar el parrafo3 del pdf.
 * @param type $dayStart Este parametro recibira el dia de inicio del curso.
 * @param type $dayEnd Este parametro recibira el dia de fin del curso.
 * @param type $month Este parametro recibira el mes del curso.
 * @param type $year Este parametro recibira el año del curso.
 * @param type $dossier Este parametro recibira el expediente del curso.
 * @param type $hours Este parametro recibira las horas del curso.
 */
    function p3($dayStart, $dayEnd, $month, $year, $dossier, $hours) {
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(60);
        $this->Cell(10, 10, utf8_decode('COMIDAS PREPARADAS'), 0, 1);
        $this->ln();
        $this->SetFont('Arial', '', 13);
        $this->Cell(5);
        $this->MultiCell(0, 8, utf8_decode('realizado en los dias ' . $dayStart . ' al ' . $dayEnd . ' de ' . $month . ' de ' . $year . ' '
                        . '(expediente de curso ' . $dossier . ') con un total de ' . $hours . ' horas.'), 0);
        $this->ln(10);
        $this->Cell(5);
        $this->MultiCell(0, 8, utf8_decode('El presente certificado se emite para que conste y sirva de justificante a los efectos de'
                        . ' acreditación de aprovechamiento de los programas o actividades de formación de manipuladores de alimentos.'), 0);
    }
/**
 * Esta funcion se utilizará para generar la pagina de atrás del pdf.
 */
    function makeReverse() {
        $this->SetFont('Arial', 'B', 14);
        $this->ln(5);
        $this->Cell(190, 260, '', 1, 1);

        $this->Image('Imagenes/cipfpbatoi.jpg', 75, 40, 50);

        $this->setY(50);
        $this->Cell(40);
        $this->Cell(10, 180, utf8_decode('Contenidos'), 0, 1);

        $this->SetFont('Arial', '', 12);

        $this->setY(150);
        $this->Cell(55);
        $this->Cell(90, 10, utf8_decode('1. Normativa en higiene de alimentos y el'), 0, 1);


        $this->setY(156);
        $this->Cell(55);
        $this->Cell(50, 10, utf8_decode('manipulador de alimentos.'), 0, 1);


        $this->setY(162);
        $this->Cell(55);
        $this->Cell(50, 10, utf8_decode('2. Conceptos básicos.'), 0, 1);

        $this->setY(169);
        $this->Cell(55);
        $this->Cell(70, 10, utf8_decode('3. Contaminación alimentaria.'), 0, 1);

        $this->setY(176);
        $this->Cell(55);
        $this->Cell(50, 10, utf8_decode('4. Higiene de alimentos.'), 0, 1);

        $this->setY(183);
        $this->Cell(55);
        $this->Cell(100, 10, utf8_decode('5. Higiene del instrumental y de las superficies.'), 0, 1);

        $this->setY(190);
        $this->Cell(55);
        $this->Cell(30, 10, utf8_decode('Instalaciones.'), 0, 1);

        $this->setY(197);
        $this->Cell(55);
        $this->Cell(70, 10, utf8_decode('6. El sistema APPCC y los prerrequisitos (RPHT).'), 0, 1);


        $this->setY(204);
        $this->Cell(55);
        $this->Cell(60, 10, utf8_decode('7. La manipulación de alimentos en el sector de'), 0, 1);


        $this->setY(210);
        $this->Cell(55);
        $this->Cell(30, 10, utf8_decode('comidas preparadas.'), 0, 1);


        $this->setY(217);
        $this->Cell(55);
        $this->Cell(80, 10, utf8_decode('8. Alérgenos en la restauración colectiva.'), 0, 1);
    }
/**
 * Esta funcion se utilizará para generar el pie del pdf.
 */
    function footer1() {
        $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        $this->ln(30);
        $this->SetFont('Arial', '', 13);
        $this->Cell(60);
        $this->MultiCell(0, 8, utf8_decode('En Alcoi, a ' . date("j") . ' de ' . $meses[date("n") - 1] . ' de ' . date("o")), 0);
    }

}

include '../config.php';
$db = new DB($ip, $user, $pass, $db);
$db->Connect();
$conn = $db->GetConn();
$conn->set_charset('utf8');
//Recoger datos por post
$arrayId = $_GET['id'];
$codigo = $_GET['curso'];
$nombre;
$apellido1;
$apellido2;
$dni;
$diain;
$diafin;
$mes;
$añofin;
$horas;

$ids = explode(',', $arrayId);

getDataCurso($codigo);

$pdf = new pdf();

for ($x = 0; $x < count($ids); $x++) {

    getDataAlumno($ids[$x]);
	getDniRight();
	
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->header1();
    $pdf->p1();
    $pdf->p2($nombre, $apellido1, $apellido2, $dni);
    $pdf->p3($diain, $diafin, $mes, $añofin, $codigo, $horas);
    $pdf->footer1();

    $pdf->AddPage();
    $pdf->makeReverse();
}

echo base64_encode($pdf->Output('documento.pdf', 'I', true));
/**
 * Esta funcion se utilizará para formatear correctamente el dni (quitar el 0 o X0 de delante).
 * @global type $dni
 */
function getDniRight(){
	global $dni;
	
	switch(substr($dni, 0, 1)){
		case '0':
			$dni=substr($dni,1,strlen($dni));
			break;
		case 'X':
			$dni=substr($dni,2,strlen($dni));
			break;	
	}
}

/**
 * Esta funcion se utilizará para recoger los datos de los alumnos.
 * @global type $conn
 * @global type $nombre
 * @global type $apellido1
 * @global type $apellido2
 * @global type $dni
 * @param type $val Este parametro recogerá el identificador del alumno.
 */
function getDataAlumno($val) {
    global $conn;
    global $nombre;
    global $apellido1;
    global $apellido2;
    global $dni;

    $query = "SELECT nombre,dni,apellido1,apellido2 FROM alumnos WHERE id=$val";
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $nombre = $row['nombre'];
            $apellido1 = $row['apellido1'];
            $apellido2 = $row['apellido2'];
            $dni = $row['dni'];
        }
        
    }
}
/**
 * Esta funcion se utilizará para recoger los datos del curso.
 * @global type $conn
 * @global type $horas
 * @global type $diain
 * @global type $diafin
 * @global type $mes
 * @global type $añofin
 * @param type $codigo Este parametro recogera el identificador del curso.
 */
function getDataCurso($codigo) {
    global $conn;
    global $horas;
    global $diain;
    global $diafin;
    global $mes;
    global $añofin;

    $query = "SELECT fecha_inicio,fecha_fin,horas FROM manipulador_alimentos WHERE codigo='$codigo'";
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $horas = $row['horas'];
            $diain = getDay($row['fecha_inicio']);
            $diafin = getDay($row['fecha_fin']);
            $mes = getMonth($row['fecha_fin']);
            $añofin = getYear($row['fecha_fin']);
        }
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


