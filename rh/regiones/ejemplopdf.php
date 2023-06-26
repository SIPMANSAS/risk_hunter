<?php
    require('fpdf/fpdf.php');
    include 'conexion/conexion.php';
    
    $idencuesta = $_POST['idencuesta'];

    ///////////CONSULTA DATOS FECHA
    $sql3 = "SELECT fecha_registro FROM v_detalle_encuestas WHERE id_encuesta='$idencuesta' GROUP BY id_usuario";
    $resultset3 = mysqli_query($mysqli, $sql3) or die("database error:" . mysqli_error($conexion2));
    
    ////////////CONSULTA DATOS USUARIO 
    $sql2 = "SELECT nombre,apellidos FROM v_detalle_encuestas WHERE id_encuesta='$idencuesta' GROUP BY id_usuario"; 
    $resultset2 = mysqli_query($mysqli, $sql2) or die("database error:" . mysqli_error($conexion2));
    
    ///////////CONSULTA DATOS PREGUNTAS
    $sql = "SELECT nom_pregunta AS 'Pregunta',respuesta_texto AS 'Respuesta',dsp_respuesta AS 'Tipo Respuesta' FROM v_detalle_encuestas WHERE id_encuesta='$idencuesta'";
    $resultset = mysqli_query($mysqli, $sql) or die("database error:" . mysqli_error($conexion2));

    ///////////TAMA���O PAGINA Y ADICION DE IMAGEN PDF (CABECERA)
    $pdf = new FPDF('P','mm',array(400,250));
    $pdf->AddPage();
    $pdf->Image('imagenes/ies.jpg',17,5,30);
    $pdf->setFont('helvetica','B',18);
    
    /******************************************************** TITULO  ******************************************************/
    $pdf->Cell(220, 50, "Reporte ", 19, 5, 'C');
    $pdf->setFont('helvetica','B',12);
    $pdf->Ln(20);
    $pdf->SetFont('helvetica', 'U', 14);
    $pdf->Cell(220, -65, "Detalle de encuesta", 0, 1, 'C');
    $pdf->Ln(20);
    $pdf->SetY(-390);
    $pdf->SetX(45);
    date_default_timezone_set('America/Bogota');
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->Cell($ancho + $horizontal, 10,'Hora: '.date('H:i:s'), 0, 0, 'R');
    $pdf->Cell($ancho + $horizontal,20,'Fecha Generacion: '.date('d/m/Y'), 0, 0, 'R'); 
    
    /****************************************************** CUERPO **********************************************************/
    
    $pdf->SetY(-364);
    $pdf->SetX(24);
    $pdf->SetFont('Arial', 'B','10','C');
    $pdf->Cell(12, 50, "Fecha encuesta: ", 0, 1, 'C');
    $pdf->SetY(-348.5);
    $pdf->SetX(47);
    $pdf->SetFont('Arial', '','10','C');
    while($rows = mysqli_fetch_assoc($resultset3)){
        foreach ($rows as $column3) {
            $pdf->Cell(25, 19, $column3);
        }   
    }
    
    $pdf->SetY(-355);
    $pdf->SetX(25);
    $pdf->SetFont('Arial', 'B','10','C');
    $pdf->Cell(12, 50, "Usuario encuesta: ", 0, 1, 'C');
    $pdf->SetY(-339.5);
    $pdf->SetX(47);
    $pdf->SetFont('Arial', '','10','C');
    while($rows = mysqli_fetch_assoc($resultset2)){
        foreach ($rows as $column2) {
            $pdf->Cell(25, 19, $column2);
        }   
    }
    
    $pdf->SetY(-330);
    $pdf->SetX(32);
    $pdf->SetFont('Arial', 'B','10','C');
    while ($field_info = mysqli_fetch_field($resultset)) {
        $pdf->Cell(70, 19, $field_info->name);
    };
    
    $pdf->SetFont('Arial', '','9','C');
    while ($rows = mysqli_fetch_assoc($resultset)){
        $pdf->Ln(5);
        $pdf->SetX(15);
        foreach ($rows as $column) {
            $tamaño = strlen($column);
            $pdf->Cell(80, 29, $column,'C');
        }
    }
    ($pdf->Output() == true);

?>    
    