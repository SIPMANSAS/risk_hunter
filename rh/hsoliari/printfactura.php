<?php
include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';

function FncBuscarseq1($XSEQUENCIA,$parametro,$filtro) {
           $XSELECT = "select $parametro from $XSEQUENCIA where $filtro
           order by $parametro desc limit 1";
           $XOBJRES=new greservas;
           $XROWSEQUENCIA = $XOBJRES->FncBuscarSequencia($XSELECT);
           $XNEXTSEQ=$XOBJRES->obtener_fila($XROWSEQUENCIA);
          return $XNEXTSEQ[0];

}

function basico($numero) {
$valor = array ('uno','dos','tres','cuatro','cinco','seis','siete','ocho',
'nueve','diez', 'once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve','veinte',
'veintiuno','veintidos','veintitres', 'veinticuatro','veinticinco',
'veintiséis','veintisiete','veintiocho','veintinueve');
return $valor[$numero - 1];
}

function decenas($n) {
$decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
70=>'setenta',80=>'ochenta',90=>'noventa');
if( $n <= 29) return basico($n);
$x = $n % 10;
if ( $x == 0 ) {
return $decenas[$n];
} else return $decenas[$n - $x].' y '. basico($x);
}

function centenas($n) {
$cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos',
400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
if( $n >= 100) {
if ( $n % 100 == 0 ) {
return $cientos[$n];
} else {
$u = (int) substr($n,0,1);
$d = (int) substr($n,1,2);
return (($u == 1)?'ciento':$cientos[$u*100]).' '.decenas($d);
}
} else return decenas($n);
}

function miles($n) {
if($n > 999) {
if( $n == 1000) {return 'mil';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-3);
$x = (int)substr($n,-3);
if($c == 1) {$cadena = 'mil '.centenas($x);}
else if($x != 0) {$cadena = centenas($c).' mil '.centenas($x);}
else $cadena = centenas($c). ' mil';
return $cadena;
}
} else return centenas($n);
}

function millones($n) {
if($n == 1000000) {return 'un millón';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-6);
$x = (int)substr($n,-6);
if($c == 1) {
$cadena = ' millón ';
} else {
$cadena = ' millones ';
}
return miles($c).$cadena.(($x > 0)?miles($x):'');
}
}

function convertir($n) {
switch (true) {
case ( $n >= 1 && $n <= 29) : return basico($n); break;
case ( $n >= 30 && $n < 100) : return decenas($n); break;
case ( $n >= 100 && $n < 1000) : return centenas($n); break;
case ($n >= 1000 && $n <= 999999): return miles($n); break;
case ($n >= 1000000): return millones($n);
}
}



?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>Factura</title>

<!-- Bootstrap core CSS -->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="assets/css/pagos/Style-Light.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap-horizon.css" rel="stylesheet">
<link href="assets/css/pagos/Style-Light.css" rel="stylesheet">


<script src="http://code.jquery.com/jquery-2.1.1.js"></SCRIPT>
 <script type="text/javascript" src="assets/js/gestion_reservas3.js" ></script>
   <!-- ajax form -->
      <script src="pagos/assets/js/jquery.form.min.js"></script>

 <script>
function metodopago(sel) {
     var valmetpag = sel.value;
     alert ("cambia pago");
     var url = "confirmacheckout.php";
     $.ajax({
           type: "POST",
           url: url,
           data: $("#pagoform").serialize(),
           success: function(data) {
               $('#resp').fadeOut(1000);
                 $('#resp').html(data);
                 if (valmetpag == 1)
                    $('#resp1').html(data);
                $('#metpag').val(valmetpag);

            }
     });
};

$(document).ready(function () {
   $('#pago').show();
   $('#saldo').show();
   $('.CreditCardNum').hide();
   $('.CreditCardHold').hide();
   $('#subtotal').hide();
   $('#iva').hide();
   $('#dto').hide();
   $('#abonos').hide();
   $('#idres').hide();
   $('#idcust').hide();
   $('#numhab').hide();
   $('#cedula').hide();
   $('#otcg').hide();



 $("#metodopago").change(function(){

      var p_met = $(this).find('option:selected').val();

      if (p_met === '0') {
         $('#pago').show();
         $('#saldo').show();
         $('.CreditCardNum').hide();
         $('.CreditCardHold').hide();
         $('.CreditCardMonth').hide();
         $('.CreditCardYear').hide();
         $('.CreditCardCODECV').hide();
         $('#CreditCardNum').val('');
         $('#CreditCardHold').val('');
         $('#CreditCardYear').val('');
         $('#CreditCardMonth').val('');
         $('#CreditCardCODECV').val('');
         $('.stripe-btn').hide();
         $('.ChequeNum').hide();
      } else if (p_met === '1') {
         $('#pago').show();
         $('#saldo').hide();
         $('.CreditCardNum').show();
         $('.CreditCardHold').show();
         $('.CreditCardMonth').show();
         $('.CreditCardYear').show();
         $('.CreditCardCODECV').show();
         $('.stripe-btn').show();
       }

   });
   
});

$(document).ready(function () {

  $('#pago').on('keyup',function() {
      var change = -(parseFloat($('#total').text()) - parseFloat($(this).val()));
      if(change < 0 ){
         $('#saldo span').text(change.toFixed(2));
         $('#saldo span').addClass( "red" );
         $('#saldo span').removeClass( "light-blue" );
      }else{
         $('#saldo span').text(change.toFixed(2));
         $('#saldo span').removeClass( "red" );
         $('#saldo span').addClass( "light-blue" );
      }
    });
});





function PrintTicket() {

   $('.modal-body').removeAttr('id');
   window.print();
   $('.modal-body').attr('id', 'modal-body');

}

function pdfreceipt(){

   var content = $('#printSection').html();
 	location.href="pagos/pos/pdfreceipt/?content="+content;

}

</script>



</head>


<?php
echo '<div id="resp"> </div>';

echo "<body><html>";
$XOBJRES=new greservas;
$XOBJRES1=new greservas;


if (isset($_GET['idres']))
   $idres = $_GET['idres'];
else
   $idres = "";
   

    $XSETANT=$XOBJRES->buscar_salesid($idres);
    $sale=$XOBJRES->obtener_fila($XSETANT);
    $idsale = $sale[0];
    $clientid = $sale[1];
    $cliente = $sale[2];
    $subtotal = $sale[3];
    $dtoamount = $sale[4];
    $ivaamount = $sale[5];
    $total = $sale[6];
    $totitems = $sale[7];
    $pago = $sale[8];
    $status = $sale[9];
    $metpago = $sale[10];
    $cedula = $sale[11];
    $numhab = $sale[12];
    $ivapor = $sale[13];
    $dtopor = $sale[14];
    $date = $sale[15];
    

       $XSETANT=$XOBJRES->buscar_settings();
       $XSET=$XOBJRES->obtener_fila($XSETANT);
       if (isset($XSET[0]))
          $moneda = $XSET[0];
       else
          $moneda = "COP";
       $decimales = $XSET[6];
       $encabezado = $XSET[1];
       $pie = $XSET[2];
       $phone = $XSET[7];
       $company = $XSET[8];
       
     $XCLIANT=$XOBJRES->buscar_datoscliente($clientid);
     $XCLI=$XOBJRES->obtener_fila($XCLIANT);
     $tel = $XCLI[1];
     $email = $XCLI[2];
     $pais = $XCLI[3];
     $dir = $XCLI[4];
     
      // busco el registro con tienda

         $tablaregister = "zarest_registers";
         $camporegister = "zarest_registers.id";
         $filtro = " zarest_registers.status = '1' and store_id = '1'";
         $idregister =   FncBuscarseq1($tablaregister,$camporegister,$filtro);

     
     $XABONO=$XOBJRES->buscar_sumpagos($idregister, $idsale);
     $XSUMPAGO=$XOBJRES->obtener_fila($XABONO);
     $abonos = $XSUMPAGO[0];
     
     

     
        $ticket = '
        <div class="logo">
               <img src="assets/images/logosoliari.png" alt="">
              </div>
         <div class="col-md-12">
         <h4 div class="text-center">' . $encabezado .
         '</div><div style="clear:both;"></h4>
         <h2 class="text-center">Factura de Venta #: HS-' . sprintf("%05d", $idsale) .
          '</h2> <div style="clear:both;"></div><h4><span class="float-left">Fecha: ' .
          $date . '</span></h4><br>
          <br>
          <div style="clear:both;"><h2><span class="text-bold">Cliente:'
           . $cliente . '</span> <span class="float-left"> &nbsp;&nbsp; </span><span class="text-bold"># Documento:'
           . $cedula . '</span></h2>

           <br>
          <div style="clear:both;"><h4><span class="float-left">Direccion:'
           . $dir . '</span><span class="float-left"> &nbsp;&nbsp; </span><span class="float-left">Pais/Ciudad:'
           . $pais . '</span></h4>
            <br>
          <div style="clear:both;"><h4><span class="float-left">Email:'
           . $email . '</span> <span class="float-left"> &nbsp;&nbsp; </span><span class="float-left">Telefono:'
           . $tel . '</span></h4><br> <br>

           <h2 div class="text-bold">
           <span class="col-md-1">#</span><span class="col-md-4">Producto </span><span>&nbsp;&nbsp;</span><span class="col-md-2"> Cantidad </span>
           <span>&nbsp;&nbsp;</span><span class="col-md-3"> Subtotal
           </span></div></h2>';

           setlocale(LC_MONETARY, 'en_US');
         $l = 0;
         $XITEM=$XOBJRES->buscar_salesitem($idsale);
         $i=0;
         while($XITEMRES=$XOBJRES->obtener_fila($XITEM))
         {
           $l++;
               $number =  number_format((float)($XITEMRES[4] * $XITEMRES[3]), $decimales, '.', '');
         //    $ticket .= '<tr><td style="text-align:center; width:30px;">' . $l . '</td><td style="text-align:left; width:180px;">'
          //  . $custname[$j] . '</td><td style="text-align:center; width:50px;">' . $qt[$j] . '</td><td style="text-align:right;
          //  width:70px; ">' . money_format('%n', $number) .' '. $moneda . ' </td></tr>';
             $ticket .= '<h2 div><p><span class="col-md-1">' . $l . '&nbsp;&nbsp;&nbsp; </span><span class="col-md-4">'. $XITEMRES[2] . '
             &nbsp;&nbsp;&nbsp; </span><span class="col-md-2">' . $XITEMRES[4] .
             '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span class="col-md-3">' .  $number .' '. $moneda . ' </span></p></div></h2><br>';

        }
        $l++;
       // $otcg = number_format((float)$otcg, $decimales, '.', '');
        $subtotal = number_format((float)$subtotal, $decimales, '.', '');
        $dtovalue = number_format((float)$dtoamount, $decimales, '.', '');
        $ivavalue = number_format((float)$ivaamount, $decimales, '.', '');

     //   $ticket .= '<br><br><br><h2 div><p><span class="col-md-1">
      //  ' . $l . '&nbsp;&nbsp;&nbsp; </span><span class="col-md-4">
      //  OTROS CARGOS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span class="col-md-2" >  &nbsp;&nbsp;&nbsp;
      //   1 </span><span class="col-md-3">'
//. money_format('%n', $otcg) . ' ' . $moneda . ' </td></tr>';
         /*<td style="text-align:right;idth:70px;">'  */
        // . money_format('%n',$otcg) . ' ' . $moneda . '</span></p></div></h2><br>';


        $bcs = 'code128';
        $height = 20;
        $width = 3;
        $gtot = number_format((float)$total, $decimales, '.', '');

        $ticket .= '<hr><br><br><h2>
        <div class="float-right"> <span> Total Items </span><span >' .
        $totitems . '</span><span> Total </span>
        <span>' .
      //  money_format('%n',$subtotal) . ' '. $moneda.'</td></tr>';
        $subtotal . ' '. $moneda.'</span></h2>';

        if (intval($dtovalue))
            $ticket .= '<br><h2><div class="float-right"> <span> Descuento % </span><span>' .
        $dtopor . '</span><span>Descuento </span> <span>' .
         //   money_format('%n',$dtovalue) . '</td></tr>';
               $dtovalue .  ' '. $moneda.'</span></h2>';
        if (intval($ivapor))
            $ticket .= '<br><h2><div class="float-right"> <span>
        Iva </span><span>' . $ivapor . '</span><span>IVA </span>
         <span>'.
//            money_format('%n',$ivavalue). '</td></tr>';
            $ivavalue. ' '. $moneda. '</span></h2>';


        $ticket .= '<br><h2><div class="float-right"> <span>
        Items </span><span></span><span>Abonos </span>
         <span>'
        .
//        money_format('%n',$abonos)  . ' '. $moneda.' </td></tr><tr>';
          $abonos  . ' '. $moneda.' </span></div></h2><br>';


        $ticket .= '<hr><hr><h2><div class="float-right"><br><span> Gran Total</span><span>'
        .
//        money_format('%n',$gtot)  . ' '. $moneda.' </td></tr><tr>';
        $gtot  . ' '. $moneda.' </span></h2></div><br>';

        $PayMethode = explode('~', $metpago);

        switch ($PayMethode[0]) {
            case '1': // case Credit Card
                $ticket .= '<h2><br><div class="float-right"><span> Tarjeta de Credito</span>
                <span>xxxx xxxx xxxx ' . substr($PayMethode[1], - 4) . '</span><br>
                <span> Titular</span>
                <span >' . $PayMethode[2] . '</span>
                <br></h2></div></h2></div>';
                break;

            default:
                $ticket .= '<h2><br><div class="float-right"><span> Pago (Efectivo) </span>
                <span>' .
               // money_format('%n',number_format((float)$pago, $decimales, '.', '')).' '.$moneda . ' </td></tr><tr>
                number_format((float)$pago, $decimales, '.', '').' '.$moneda . ' </span></h2></div><br>
                 <h2><div class="float-right">
                <span> Saldo</span>
                <span>' .
               //money_format('%n',number_format((float)(floatval($pago) - floatval($total)), $decimales, '.', '')) . ' '.$moneda.'</td></tr></tbody>
                number_format((float)(floatval($pago) - floatval($total)), $decimales, '.', '') . ' '.$moneda.'</span>
                </div></h2><br><hr><hr>';
        }

        if ($gtot == 0)
            $ticket .= '<br><h2 div class="text-center"> <span>
        Son: ' .
        ucfirst(convertir((int)($subtotal)))  . '&nbsp;&nbsp; Acepta: _________________</h2></span></div>
         <div class="float-right"><br><span># Hab.'. $numhab.'</span></div>';
        else
         $ticket .= '<br><h2 div class="text-center"> <span>
        Son: ' .
        ucfirst(convertir((int)($gtot)))  . '&nbsp;&nbsp; Acepta: _________________</h2></span></div>
         <div class="float-right"><br><h2><span># Hab.'. $numhab.'</span></div></h2>';


        $storename = "<br><div>Punto de Venta ".$company;
        $ticket .= '<h4 div><span class="float-left">' . $storename .
        ' </span><span>&nbsp;&nbsp;</span> <span class="float-right"> Telefono' . $phone . '</span></div><br>
        <div class="text-center">
        <span ><p> Factura impresa por computador por hotel Soliari.  <br>
           La presente factura de venta se asimila en todos sus efectos legales a una letra de cambio segun Art. 774.
          <br>No somos grandes contribuyentes, ni retenedores de iva. </p></span></div>
        </h4>
        </div></div> <div style="border-top:1px solid #000; padding-top:10px;"> </div> </div>
          <h4 div class="text-center">
        ' .
         $pie . '</h4></div>';

         // imprimo factura
 ?>

         <div id="printSection">
          <?php echo $ticket; ?>
            <!-- Ticket goes here -->
         </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-default hiddenpr" data-dismiss="modal" onclick="window.close()">Cerrar</button>
         <button type="button" class="btn btn-add hiddenpr" onclick="PrintTicket()">Imprimir</button>
      </div>

</body></html>
<!-- /.Modal -->

