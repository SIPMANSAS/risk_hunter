<?php
    require('fpdf/fpdf.php');

    $conn = new mysqli('localhost', 'risk_hunter', 'Kaliman01*', 'sipman_risk_hunter');

    if($conn->connect_error){
        die("Error in DB connection: ".$conn->connect_errno." : ".$conn->connect_error);    
    }
    
    $select = "SELECT * FROM v_detalle_encuestas";
    $currentDateTime = date('Y-m-d H:i:s');
    $result = $conn->query($select);
    
      
    $pdf = new FPDF();
    

    $pdf->AddPage();
    $pdf->SetY(-265);
    $pdf->Image('img/ies.jpg',17,5,30);
    $pdf->setFont('Arial','B',20);
    $pdf->Ln(10);
    $pdf->Cell(200, 5, "Reporte ", 17, 5, 'C');
    $pdf->Ln(15);
    $pdf->SetFillColor(232,232,232);
    $pdf->setFont('Arial','B',10);
    $pdf->Cell(7, 6, utf8_decode("N°"), 1, 0, 'C',1);
    $pdf->Cell(60, 6, "Nombres y Apellidos", 1, 0, 'C',1);
    $pdf->Cell(22, 6, "Fecha Reg.", 1, 0, 'C',1);
    $pdf->Cell(50, 6, "Pregunta", 1, 0, 'C',1);
    $pdf->Cell(50, 6, "Respuesta", 1, 0, 'C',1);
    
    while($row = $result->fetch_assoc($result)){
        $pdf->Cell(7, 6, $row['id_encuesta'], 1, 0, 'C',1);
        $pdf->Cell(60, 6, $row["nombres"].' '.$row["apellidos"], 1, 0, 'C',1);
        $pdf->Cell(22, 6, $row["fecha_registro"], 1, 0, 'C',1);
        $pdf->Cell(50, 6, $row["nom_pregunta"], 1, 0, 'C',1);
        $pdf->Cell(50, 6, $row["respuesta_texto"], 1, 0, 'C',1);
    }
    
    $pdf->Output();

?>