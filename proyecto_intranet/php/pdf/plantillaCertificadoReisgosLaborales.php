<?php

header('Content-Type: application/pdf');
require_once "fpdf/fpdf.php";
require_once "../Classes/Class_DB.php";

date_default_timezone_set('Europe/Madrid');

class pdf extends fpdf {

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
        //$this->Image('Imagenes/pajaro.png', 150, 20, 30);
        $this->Image('Imagenes/FSEpos_val.jpg', 170, 5, 30);
        $this->setY(26);
        $this->Cell(140);
        //$this->Cell(20, 10, utf8_decode('Formació en centres de treball'), 0, 1);
        //saltos de linea despues de la cabecera
        $this->Ln(1);
    }

    function p1($nombreGrupoAlumno,$titulo) {
        $this->SetFont('Arial', 'B', 11);
//        $this->Cell(5);
//        $this->Cell(10, 10, utf8_decode('Andrés Puig Navalón'), 0, 1);
        $this->ln(9);
        $this->SetFont('Arial', '', 11);
        $this->Cell(5);
        $this->MultiCell(0, 8, utf8_decode('SRA. MARIA JESÚS ASENSI BERTOMEU, secretària del centre CIP FP BATOI de Alcoy,'
                        . ' que impartix el Cicle Formatiu de Grau Superior '.$nombreGrupoAlumno.' corresponent al '
                        . ' títol de '.$titulo.', segons el Reial Decret 1394/2007'
                        . ' (BOE 24/11/2007) i l\'Ordre de 29 de juliol de 2009 (DOCV de 02/09/2009),'), 0);
    }

 
    function p2($nombre,$apellido1,$apellido2,$dni,$horas) {
 
        $this->ln(5);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(80);
        $this->Cell(10, 10, utf8_decode('ACREDITE:'), 0, 1);
        $this->ln();
        $this->SetFont('Arial', '', 11);
        $this->Cell(5);
        $this->MultiCell(0, 8, utf8_decode('Que l\'alumne/a ' . $nombre . ' ' . $apellido1 . ' ' . $apellido2 . ' amb DNI núm ' . $dni . ' ha cursat amb '
                        . ' aprofitament els continguts mínims que s\'estableixen en el Reial Decret abans mencionat '
                        . ' per al módul de Formació i Orientació Laboral contingut en l\'esmentat títol amb una '
                        . ' duració total de '.$horas.' horas, que el capacita per l\'exercici de les FUNCIONS DE NIVELL '
                        . ' BÀSIC EN PREVENCIÓ DE RISCOS LABORALS, d\'acord amb el que estableix l\'article 35 '
                        . ' del Reial Decret 39/1997, de 17 de gener, pel qual s\'aprova el Reglament dels Servicis de '
                        . ' Prevenció. Així mateix l\'alumne/a ha cursat, amb aprofitamente, els mòduls específics de '
                        . ' seguretat i higiene laboral o altres contingus relacionats amb la prevenció de riscos '
                        . ' laborals, inclosos de mode transversal en la resta de mòduls professional que componen '
                        . ' cada un dels cicles, complementant els continguts impartits en el mòdul, professional '
                        . ' Formació i Orientació Laboral, a fi de satisfer els programes de formació d l\'annex IV del '
                        . ' R.D. 39/1997, de 17 de gener. '), 0);
                        
        $this->ln(5);
    }


    function makeReverse() {

// titulo, caja contenedor principal
        $this->SetFont('Arial', 'B', 14);
        $this->ln(2);
        $this->Cell(190, 260, '', 1, 1);

        $this->setY(30);
        $this->setX(45);
        $this->Cell(40);
        $this->Cell(10, 10, utf8_decode('CONTENIDOS'), 0, 1);

        $this->SetFont('Arial', '', 12);
/* APARTADO 1 */
        $this->setY(50);
        $this->Cell(5);
        $this->Cell(90, 10, utf8_decode('1. LA PREVENCIÓN DE RIESGOS: CONCEPTOS BÁSICOS'), 0, 1);

        $this->setY(56);
        $this->setX(10);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('1) CONCEPTO DE SALUD.'), 0, 1);

        $this->setY(62);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('2) FACTORES DE RIESGO LABORAL.'), 0, 1);

        $this->setY(68);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('3) DAÑOS A LA SALUD DEL TRABAJADOR.'), 0, 1);

        $this->setY(74);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('4) MEDIDAS DE PREVENCIÓN Y PROTECCIÓN DE RIESGOS LABORALES.'), 0, 1);

/* APARTADO 2 */
        $this->setY(90);
        $this->Cell(5);
        $this->Cell(90, 10, utf8_decode('2. LA PREVENCIÓN DE RIESGOS: LEGISLACIÓN Y ORGANIZACIÓN.'), 0, 1);

        $this->setY(96);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('1) LA LEGISLACIÓN SOBRE PREVENCIÓN DE RIESGOS LABORALES.'), 0, 1);

        $this->setY(102);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('2) LA ORGANIZACIÓN DE LA PREVENCIÓN EN LA EMPRESA.'), 0, 1);

        $this->setY(108);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('3) PARTICIPACIÓN DE LOS TRABAJADORES EN LA PREVENCIÓN DE RIESGOS.'), 0, 1);

        $this->setY(114);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('4) LA GESTIÓN DE LA PREVENCIÓN EN LA EMPRESA.'), 0, 1);
/* APARTADO 3 */
        $this->setY(130);
        $this->Cell(5);
        $this->Cell(90, 10, utf8_decode('3. FACTORES DE RIESGO Y SU PREVENCIÓN. LOS FACTORES DE RIESGO LABORAL.'), 0, 1);

        $this->setY(136);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('1) FACTORES DE RIESGO DERIVADOS DE LAS CONDICIONES DE SEGURIDAD.'), 0, 1);

        $this->setY(142);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('2) FACTORES DE RIESGO DERIVADOS DE LAS CONDICIONES MEDIOAMBIENTALES.'), 0, 1);

        $this->setY(148);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('3) FACTORES DE RIESGO DERIVADOS DE LA CARGA DE TRABAJO.'), 0, 1);

        $this->setY(154);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('4) FACTORES DE RIESGO DERIVADOS DE LA ORGANIZACIÓN DEL TRABAJO.'), 0, 1);
/* APARTADO 4 */
        $this->setY(174);
        $this->Cell(5);
        $this->Cell(90, 10, utf8_decode('4. EMERGENCIAS Y PRIMEROS AUXILIOS.'), 0, 1);

        $this->setY(180);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('1) EL PLAN DE AUTOPROTECCIÓN.'), 0, 1);

        $this->setY(186);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('2) PRIMEROS AUXILIOS.'), 0, 1);

        $this->setY(192);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('3) SOPORTE VITAL BÁSICO.'), 0, 1);

        $this->setY(198);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('4) ACTUACIÓN FRENTE A OTRAS EMERGENCIAS.'), 0, 1);

        $this->setY(204);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('5) TRASLADO DE ACCIDENTADOS.'), 0, 1);

        $this->setY(210);
        $this->Cell(15);
        $this->Cell(50, 10, utf8_decode('6) BOTIQUÍN DE PRIMEROS AUXILIOS.'), 0, 1);



    }

    function footer1() {
        $meses = array("Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Septembre", "Octubre", "Novembre", "Decembre");
        $this->ln(8);
        $this->SetFont('Arial', '', 11);
        $this->Cell(5);
        $this->MultiCell(0, 8, utf8_decode('Alcoi, a ' . date("j") . ' de ' . $meses[date("n") - 1] . ' de ' . date("o")), 0);
        $this->ln(10);
        $this->Cell(5);
        $this->Cell(50,10, utf8_decode('Vist i plau'),0,1);
        $this->ln(4);
        $this->SetY(230);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(50,10, utf8_decode('EL DIRECTOR'),0,1);
        $this->SetY(230);
        $this->SetX(120);
        $this->Cell(50,10, utf8_decode('LA SECRETÀRIA'),0,1);
        $this->SetFont('Arial','',11);
        $this->SetY(250);
        $this->SetX(15);
        $this->Cell(50,10, utf8_decode('Firma: Andrés Puig Navalón'),0,1);
        $this->SetY(250);
        $this->SetX(120);
        $this->Cell(50,10, utf8_decode('Firma: María Jesús Asensi Bertomeu'),0,1);
    }

}

include '../config.php';
$db = new DB($ip, $user, $pass, $db);
$db->Connect();
$conn = $db->GetConn();
$conn->set_charset('utf8');
//Recoger datos por post

$codigo = $_GET['codigo']; // codigo del grupo o del alumno (el ID)
$horas = $_GET['horas']; // horas que ha durado el curso prevencion
$titulo = $_GET['titulo']; // titulo de grado superior en
$tipo = $_GET['tipo']; // alumno o grupo

// variables
$nombre;
$apellido1;
$apellido2;
$dni;

$nombreGrupoAlumno;

// nos guardamos el numero de alumnos del curso seleccionado
$totalAlumnosGrupo;
$nombreGrupo;
$ids; // array de id alumnos

$pdf = new pdf();

// si el tipo es alumno
if($tipo=="alumno"){
    getCursoNombre($codigo); //le enviamos el codigo del POST
    getDataAlumno($codigo);
    getDniRight();

    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->header1();

    
    $pdf->p1($nombreGrupoAlumno,$titulo);
    
    
    $pdf->p2($nombre,$apellido1,$apellido2,$dni,$horas);

    $pdf->footer1();

    $pdf->AddPage();
    $pdf->makeReverse();
    echo base64_encode($pdf->Output('certfRiesgosLaborAlumn.pdf', 'I', true));   
}


/****** CODIGO DE PARA ALUMNO ******/
function getDataAlumno($val) {
    global $conn;
    global $nombre;
    global $apellido1;
    global $apellido2;
    global $dni;

    $query = "SELECT nombre,dni,apellido1,apellido2 FROM alumnos WHERE id='$val';";
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

function getCursoNombre($val){
    global $conn;
    global $nombreGrupoAlumno;
    $query = "SELECT nombre FROM alumnos_has_grupos INNER JOIN grupos ON grupos.codigo = alumnos_has_grupos.grupos_codigo where alumnos_id = $val";
    
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $nombreGrupoAlumno = $row['nombre'];
        }        
    }
}

// si el tipo es grupo
if($tipo=="grupo"){

    getCursoNombreGrupo($codigo); //le enviamos el codigo del POST

    getNumeroAlumnosCurso($codigo); //obtener total de alumnos
    


    for ($i=0; $i < count($ids) ; $i++) { 
    //for ($i=0; $i < 20 ; $i++) { 
        
        getDataAlumno($ids[$i]);
        getDniRight();

        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->header1();

        $pdf->p1($nombreGrupo,$titulo);
        
        
        $pdf->p2($nombre,$apellido1,$apellido2,$dni,$horas);

        $pdf->footer1();

        $pdf->AddPage();
        $pdf->makeReverse();
        
    }

    echo base64_encode($pdf->Output('certfRiesgosLaborGrupo.pdf', 'I', true));
}

function getNumeroAlumnosCurso($val){
    global $conn;
    global $totalAlumnosGrupo;
    global $ids;
    $query = "SELECT alumnos_id FROM alumnos_has_grupos INNER JOIN grupos ON grupos.codigo = alumnos_has_grupos.grupos_codigo where grupos_codigo = '$val'";
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $ids[] = $row['alumnos_id'];
            
            
        }        
    }    
}

function getCursoNombreGrupo($val){
    global $conn;
    global $nombreGrupo;
    $query = "SELECT nombre FROM grupos where codigo = '$val';";
    
    $result = $conn->query($query);

    if ($result->num_rows !== 0) {
        while ($row = mysqli_fetch_array($result)) {
            $nombreGrupo = $row['nombre'];
        }        
    }
}

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