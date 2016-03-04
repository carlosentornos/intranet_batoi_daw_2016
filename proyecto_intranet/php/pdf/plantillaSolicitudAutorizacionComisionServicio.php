<?php
/* CARLOS */
require_once ("fpdf/fpdf.php");
require_once ("fpdi_161/fpdi.php");
require_once("fpdi_161/fpdf_tpl.php");

//Recoger datos por post
// que viene del formulario
$nombre = $_REQUEST['nombre'];
$apellido1 = $_REQUEST['apellido1'];
$apellido2 = $_REQUEST['apellido2'];
$nif = $_REQUEST['nif'];
$servicio = $_REQUEST['servicio'];
$fechaSalida = $_REQUEST['fechasalida'];
$horaSalida = $_REQUEST['horasalida'];
$fechaLlegada = $_REQUEST['fechallegada'];
$horaLlegada = $_REQUEST['horallegada'];
$dietasAlojamiento = $_REQUEST['dietaalojamiento'];
$dietasComida = $_REQUEST['dietacomida'];
$dietasOtras = $_REQUEST['otrosgastos'];
$medioLocomocion = $_REQUEST['mediolocomocion'];
$km = $_REQUEST['km'];
$marcaVehiculo = $_REQUEST['marcavehiculo'];
$matriculaVehiculo = $_REQUEST['matricula'];
$otrosMedios = $_REQUEST['otrosmedios'];

// concatenamos el nombre y los apellidos
//$nombreapellidos = $nombre +" "+$apellido1+" "+$apellido2;
$nombreapellidos =  $_REQUEST['nombre']." ".$_REQUEST['apellido1']." ".$_REQUEST['apellido2'];



// creamos la clase
$pdf = new FPDI('L');


$pdf->addPage();
/* ****** CARGAR EL PDF Y MOSTRARLO ******* */
$pageCount = $pdf->setSourceFile("Plantilla solicitud  autoritzacio de comissio de servei.pdf");
$tplIdx = $pdf->importPage(1, '/MediaBox');

$pdf->useTemplate($tplIdx, 0, 0, 290);
/* **************************************** */

// FUENTE PARA TODO EL TEXTO
$pdf->setFont('Arial','B','11');

//$pdf->setXY(50,50);
$pdf->Image('Imagenes/blanco.png', 210, 20, 30);
$pdf->Image('Imagenes/blanco.png', 220, 20, 30);
$pdf->Image('Imagenes/blanco.png', 240, 5, 30);
$pdf->Image('Imagenes/FSEpos_val.jpg', 245, 20, 30);

/*************NOMBRE,APELLIDOS, NIF PROFESOR******************/

// PONER NOMBRE Y APELLIDOS
$pdf->Text(75,64.5,utf8_decode($nombreapellidos));
// PONER NIF DEL PROFESOR
$pdf->Text(235,64.5,utf8_decode($nif));

/******************** ITINERARIO *****************************/

// OBJETO-ITINERARIO
$pdf->setFont('Arial','','9'); // cambiamos tipo de letra
//$pdf->SetXY(22, 90);
//$pdf->Write(0, utf8_decode($servicio));

//$pdf->Text(22,90,utf8_decode($servicio));

//$pdf->Cell(3, 9, utf8_decode($servicio),0);
$pdf->SetXY(20, 85);
$pdf->MultiCell(80,4,utf8_decode($servicio),'C', 1);





// ITINERARIO-FECHA/HORA SALIDA
$pdf->Text(108,88,$fechaSalida);
$pdf->Text(108,92,$horaSalida);

// ITINERARIO-FECHA/HORA LLEGADA
$pdf->Text(129.5,88,$fechaLlegada);
$pdf->Text(129.5,92,$horaLlegada);

// ALOJAMIENTO
//$pdf->Text(150,90,$dietasAlojamiento);
$pdf->SetXY(150, 85);
$pdf->MultiCell(20,4,utf8_decode($dietasAlojamiento),'C', 1);

//COMIDA
//$pdf->Text(175,90,$dietasComida);
$pdf->SetXY(176, 85);
$pdf->MultiCell(20,4,utf8_decode($dietasComida),'C', 1);

// OTROS GASTOS
//$pdf->Text(198.5,90,$dietasOtras);
$pdf->SetXY(199, 85);
$pdf->MultiCell(20,4,utf8_decode($dietasOtras),'C', 1);

// MEDIO
//$pdf->Text(224,88,utf8_decode($medioLocomocion));
$pdf->SetXY(224, 85);
$pdf->MultiCell(20,4,utf8_decode($medioLocomocion),'C', 1);


// KM
$pdf->Text(250,88,$km." km");


$pdf->setFont('Arial','','11');
// MEDIO LOCOMOCION, MATRICULA, KILOMETRAJE
// MARCA VEHICULO
$pdf->Text(54,127,utf8_decode($marcaVehiculo));

// MATRICULA
$pdf->Text(128,127,utf8_decode($matriculaVehiculo));

// MEDIOS UTILIZADOS avion, tren, taxi, autobus, altres

switch($otrosMedios){
	case 'avion':
		$pdf->Text(151.5,126,'X'); //avion
		break;
	case 'tren':
		$pdf->Text(174,126,'X');	// tren
		break;
	case 'taxi':
		$pdf->Text(197.5,126,'X');	//taxi
		break;
	case 'autobus':
		$pdf->Text(220.5,126,'X');	// autobus
		break;
	case 'otros':
		$pdf->Text(251.5,126,'X');	// altres
		break;
}
// PONER FECHA
$meses = array("Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Septembre", "Octubre", "Novembre", "Decembre");

// PRIMERA FECHA
$pdf->Text(197,138,date("d")); // poner el día, en número
$pdf->Text(225,138,($meses[date("m")-1])); // poner el mes, en letra
//$pdf->Text(260,139,date("Y")); // poner el anyo, en número

// hacer un split del año para que muestre 3 cifras
$fecha1 = date("Y");
$long_fecha1 = strlen($fecha1);
$resul_fecha1 = substr($fecha1,1,$long_fecha1);
$pdf->Text(260,139,$resul_fecha1);

// PONER FECHA FINAL DOCUMENTO
$pdf->setFont('Arial','B','11');
$pdf->Text(197,178,date("d")); // poner el día, en número
$pdf->Text(225,178,($meses[date("m")-1])); // poner el mes, en letra
//$pdf->Text(260,178,date("y")); // poner el anyo, en número

// hacer un split del año para que muestre la ultima cifra
$fecha2 = date("y");
$long_fecha2 = strlen($fecha2);
$resul_fecha2 = substr($fecha2,1,$long_fecha2);
$pdf->Text(261,178,$resul_fecha2);


echo base64_encode($pdf->Output('solAutoComServicio.pdf', 'I', true));  


?>