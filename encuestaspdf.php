<?php 

error_reporting(0);

require('fpdf/fpdf.php');

/*********************** PORTADA INFORME *******************************/
$id_encuseta  = $_POST['identificador'];
$inspeccion = $_POST['inspeccion'];

$pdf = new FPDF($orientation='P',$unit='mm');
$pdf->AddPage();
$pdf->setY(12);
$pdf->setX(10);

$pdf->SetFont('Courier','B',20);    
$pdf->setY(180);
$pdf->setX(70);
$pdf->Image('img/ies.jpg' , 160 ,8, 30 , 30,'JPG', 'http://www.desarrolloweb.com');

$fechaActual = date('d-m-Y');
$pdf->Image('img/bars.png' , 10, -9, 36 , 315,'PNG');
$pdf->Cell(14,$textypos,utf8_decode("REPORTE DE INSPECCIÓN ".$inspeccion));
$año = date('Y');
$pdf->Cell(5,10,$textypos);
$pdf->setY(200);
$pdf->setX(70);
$pdf->Cell(30,$textypos,$año);
$pdf->Cell(40,$textypos,("ID ENCUESTA -->".$id_encuseta));


/*********************** END PORTADA ***********************************************/


/************************ INTRODUCCION ********************************************/
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);    
$textypos = 5;
$pdf->setY(30);
$pdf->setX(40);
// Agregamos los datos de la empresa
$pdf->Image('img/ies.jpg' , 160 ,8, 30 , 30,'JPG', 'http://www.desarrolloweb.com');

// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',15);    
$pdf->setY(35);
$pdf->setX(90);
$pdf->Cell(5,$textypos,utf8_decode("INTRODUCCIÓN"));
$pdf->setY(60);
$pdf->setX(10);
$pdf->SetFont('Arial','',12); 
$pdf->Cell(5,$textypos,utf8_decode("Las inspecciones planeadas, continúan siendo la mejor forma de detectar y controlar los accidentes"));
$pdf->setY(65);
$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("potenciales antes de que ocurran las pérdidas que pueden involucrar gente, equipo, material y medio"));
$pdf->setY(70);
$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("ambiente.Es indispensable el conocimiento que se tiene con respecto a los procesos que se realizan"));
$pdf->setY(75);
$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("por cada una  de  las  áreas de trabajo y saber lo  que esta ocurriendo o puede suceder en determinada"));
$pdf->setY(80);
$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("situación con el fin de que el trabajo se ejecute correctamente. La observación de cómo sé esta"));
$pdf->setY(85);
$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("ejecutando una labor se puede llegar al análisis si el trabajo sé esta realizando bien o se puede"));
$pdf->setY(90);
$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("cambiar o añadir para que los resultados.Se debe evaluar el trabajo de las personas para poder"));
$pdf->setY(95);
$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("detectar los errores, el no hacerlo puede causar un alto porcentaje de accidentes."));
$pdf->setY(100);
$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("La clave esta en asegurarse de que el cambio  sea advertido y evaluado,a fin de determinar todo lo"));
$pdf->setY(105);
$pdf->setX(10);
$pdf->Cell(5,$textypos,utf8_decode("potencial para beneficio o perjuicio."));

/************************ END INTRODUCCION ****************************************/

$pdf->AddPage();
$pdf->SetFont('Arial','B',20);    
$textypos = 5;
$pdf->setY(30);
$pdf->setX(40);
// Agregamos los datos de la empresa
$pdf->Image('img/ies.jpg' , 160 ,8, 30 , 30,'JPG', 'http://www.desarrolloweb.com');


// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);    
$pdf->setY(37);$pdf->setX(45);
$pdf->Cell(5,$textypos,"PARA:");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(75);
$pdf->Cell(5,$textypos,"Nombre del cliente");
$pdf->setY(40);$pdf->setX(75);
$pdf->Cell(5,$textypos,"Direccion del cliente");
$pdf->setY(45);$pdf->setX(75);
$pdf->Cell(5,$textypos,"Telefono del cliente");
$pdf->setY(50);$pdf->setX(75);
$pdf->Cell(5,$textypos,"Email del cliente");



$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(135);
$pdf->SetFont('Arial','',10);    
$pdf->setY(10);$pdf->setX(160);

$pdf->setY(60);$pdf->setX(135);
    $pdf->Ln();

$header = array("Cod.", "Descripcion","Cant.","Precio","Total");

$products = array(
	array("0010", "Producto 1",2,120,0),
	array("0024", "Producto 2",5,80,0),
	array("0001", "Producto 3",1,40,0),
	array("0001", "Producto 3",5,80,0),
	array("0001", "Producto 3",4,30,0),
	array("0001", "Producto 3",7,80,0),
);
    // Column widths
    $w = array(20, 95, 20, 25, 25);
    // Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C');
    $pdf->Ln();
    // Data
    $total = 0;
    foreach($products as $row)
    {
        $pdf->Cell($w[0],6,$row[0],1);
        $pdf->Cell($w[1],6,$row[1],1);
        $pdf->Cell($w[2],6,number_format($row[2]),'1',0,'R');
        $pdf->Cell($w[3],6,"$ ".number_format($row[3],2,".",","),'1',0,'R');
        $pdf->Cell($w[4],6,"$ ".number_format($row[3]*$row[2],2,".",","),'1',0,'R');

        $pdf->Ln();
        $total+=$row[3]*$row[2];

    }
/////////////////////////////
//// Apartir de aqui esta la tabla con los subtotales y totales
$yposdinamic = 60 + (count($products)*10);

$pdf->setY($yposdinamic);
$pdf->setX(235);
    $pdf->Ln();
/////////////////////////////
$header = array("", "");
$data2 = array(
	array("Subtotal",$total),
	array("Descuento", 0),
	array("Impuesto", 0),
	array("Total", $total),
);
    // Column widths
    $w2 = array(40, 40);
    // Header

    $pdf->Ln();
    // Data
    foreach($data2 as $row)
    {
$pdf->setX(115);
        $pdf->Cell($w2[0],6,$row[0],1);
        $pdf->Cell($w2[1],6,"$ ".number_format($row[1], 2, ".",","),'1',0,'R');

        $pdf->Ln();
    }
/////////////////////////////

$yposdinamic += (count($data2)*10);
$pdf->SetFont('Arial','B',10);    

$pdf->setY($yposdinamic);
$pdf->setX(10);
$pdf->Cell(5,$textypos,"TERMINOS Y CONDICIONES");
$pdf->SetFont('Arial','',10);    

$pdf->setY($yposdinamic+10);
$pdf->setX(10);
$pdf->Cell(5,$textypos,"El cliente se compromete a pagar la factura.");
$pdf->setY($yposdinamic+20);
$pdf->setX(10);
$pdf->Cell(5,$textypos,"Powered by Evilnapsis");
$pdf->output();

?>