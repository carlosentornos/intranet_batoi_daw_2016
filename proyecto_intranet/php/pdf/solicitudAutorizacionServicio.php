<?php

require './fpdf/fpdf.php';

class pdf extends fpdf {

    function header() {
        utf8_decode('Formació en centres de treball');
        // Logo
        $this->SetFont('Arial', 'B', 6);
        $this->Image('generalitat-valenciana.jpg', 10, 8, 40);
        //posicionamiento de la siguiente celda debajo de el logo
        $this->setY(26);
        $this->Cell(1);
        $this->Cell(20,10,'Tel - 888 88 88 88 / Fax - 888 88 88 88',0,1);
        //siguiente linea
        $this->setY(28);
        $this->Cell(1);
        $this->Cell(20,10,'Email: email@example.com',0,1);
        //siguiente linea
        $this->setY(30);
        $this->Cell(1);
        $this->Cell(20,10,'http://cipfpbatoi.edu.gva.es',0,1);
        
        //siguiente logo, batoi
        $this->Image('cipfpbatoi.jpg', 90, 8, 20);
        $this->setY(26);
        $this->Cell(78);
        $this->Cell(20,10,'C/ Serreta, 5 - 03802',0,1);
        
        //logo pajaro
        $this->Image('pajaro.png', 140, 8, 55);
        $this->setY(26);
        $this->Cell(140);
        $this->Cell(20,10,utf8_decode('Formació en centres de treball'),0,1);
        //saltos de linea despues de la cabecera
        $this->Ln(10);
    }

    function footer() {
        
    }

}

//variable para mover todo el bloque
$bajarBloque = 0;


$pdf = new pdf();

//var_dump($pdf);

$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell('','',utf8_decode('Solicitud de autorizacion de comision de servicios'),0,1,"C");

//pimera celda, que contendra otras celdas, nombre y nif
$pdf->setY($bajarBloque + 60);
$pdf->Cell('',6,'',1,1,"C");



//label nombre y apellidos
$pdf->setY($bajarBloque + 63.250);
$pdf->Cell('','','Nombre y apellidos:',0,1);
//celda para el nombre y apellidos
$pdf->setY($bajarBloque + 61.250);
$pdf->Cell(40);
$pdf->Cell(100,3.5,'',1,1);

//label nif
$pdf->setY($bajarBloque + 63.250);
$pdf->Cell(145);
$pdf->Cell('','','NIF:',0,1);
//celda para el nombre y apellidos
$pdf->setY($bajarBloque + 61.250);
$pdf->Cell(155);
$pdf->Cell(33,3.5,'',1,1);

$pdf->Output();


function manageCells($alto,$ancho,$text,$posY,$posX,$border,$aligment) {
    global $bajarBloque;
    global $pdf;
    $pdf->setY($bajarBloque + $posY);
    $pdf->Cell($alto,$ancho,$text,$border,1,$aligment);
}