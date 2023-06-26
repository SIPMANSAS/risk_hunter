<?php
include 'conexion/conexion.php';

require('fpdf/fpdf.php');

$idencuesta = $_POST['idencuesta'];
$sql = "SELECT * FROM v_detalle_encuestas WHERE id_encuesta='$idencuesta'";

$resulset = $mysqli->query($sql);

class PDF extends FPDF{    
    function Header() {        
        $ancho = 20;
        $this->SetFont('Arial', 'B', 6);
         
        if($this->pagina == 1){
            $horizontal = 70;
            $this->SetY(100);
            $this->Cell($ancho + $horizontal, 15,'Fecha: '.date('d/m/Y'), 0, 0, 'R');
            $this->SetY(100);
            $this->Cell($ancho + $horizontal, 10,'Hora: '.date('H:i:s'), 0, 0, 'R');            
        } else {
            $this->SetX(180);
            $this->SetY(5);
            $this->Cell($ancho, 11,date('d/m/Y'), 0, 0, 'R');
            $this->SetY(5);
            $this->SetX(174);
            date_default_timezone_set('America/Bogota');
            $this->Cell($ancho, 10,'Hora Generacion: '.date('H:i:s'), 0, 0, 'R'); 
            $this->SetY(5);
            $this->SetX(120);
            $this->Image('imagenes/ies.jpg',15,12,30);
        }        
    }
     
    function Body() {
        $yy = 40;
        $y = $this->GetY(); 
        $x = 12;
        $this->AddPage($this->CurOrientation);
         
        $this->SetFont('helvetica', 'B', 20);
        $this->SetXY(0, $y + $yy);
        $this->Cell(220, 10, "Reporte ", 0, 1, 'C');
         
        $this->SetFont('courier', 'U', 15);
        $y = $this->GetY(); 
        $this->SetXY(0, $y);
        $this->Cell(220, 10, "Detalle de encuesta", 0, 1, 'C');
         
        $this->SetFont('arial', '', 8);
        $y = $this->GetY() + 8;
        $this->SetXY(10, $y);
        $this->MultiCell(10, 4, utf8_decode("Nº"), 1, 'C'); 
        $this->SetXY(20, $y);
        $this->MultiCell(49, 4, utf8_decode("Apellidos y Nombres"), 1, 'C');
        $this->SetXY(69, $y);
        $this->MultiCell(22, 4, utf8_decode("Fecha Registro"), 1, 'C');
        $this->SetXY(91, $y);
        $this->MultiCell(23, 4, utf8_decode("Fecha Creación"), 1, 'C');
        $this->SetXY(114, $y);
        $this->MultiCell(29, 4, utf8_decode("Pregunta"), 1, 'C');
        $this->SetXY(143, $y);
        $this->MultiCell(29, 4, utf8_decode("Fecha Respuesta"), 1, 'C');
        $this->SetXY(172, $y);
        $this->MultiCell(29, 4, utf8_decode("Fecha Respuesta"), 1, 'C');

    }
     
    function Footer() {        
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'C');
        if($this->CurOrientation == 'L') { 
            $this->SetX(0);
            $this->Cell(292, 10, utf8_decode('Creado por  '), 0, 0, 'R');            
        } else {       
            $this->SetX(0);
            $this->Cell(205, 10, utf8_decode('Creado por '), 0, 0, 'R');
             
        }        
    }
}
 
$pdf = new PDF();
$pdf->pagina = 0;
$pdf->AliasNbPages(); 
$pdf->Body();
$pdf->Output('Reporte Encuestas'.date("d_m_Y_H_i_s"), 'I'); 
?>
?>