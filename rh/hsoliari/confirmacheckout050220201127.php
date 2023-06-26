<?php
include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';

function FncBuscarseq1($XSEQUENCIA,$parametro,$filtro) {
           $XSELECT = "select $parametro from $XSEQUENCIA order by $parametro desc limit 1";
           $XOBJRES=new greservas;
           $XROWSEQUENCIA = $XOBJRES->FncBuscarSequencia($XSELECT);
           $XNEXTSEQ=$XOBJRES->obtener_fila($XROWSEQUENCIA);
          return $XNEXTSEQ[0];
}

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>Checkout</title>

<!-- Bootstrap core CSS -->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="assets/css/pagos/Style-Light.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap-horizon.css" rel="stylesheet">

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



function saleBtn(type) {
   var clientID = $('#customerSelect').find('option:selected').val();
   var clientName = $('#customerName span').text();
   var Tax = $('#num01').text();
   var Discount = $('#num02').text();
   var Subtotal = $('#Subtot').text();
   var Total = $('#total').text();
   var createdBy = '';
   var totalItems = $('#ItemsNum span').text();
   var Paid = $('#Paid').val();
   var paidMethod = $('#metodopago').find('option:selected').val();
   var Status = 0;
   var ccnum = $('#CreditCardNum').val();
   var ccmonth = $('#CreditCardMonth').val();
   var ccyear = $('#CreditCardYear').val();
   var ccv = $('#CreditCardCODECV').val();
   var waiter = $('#WaiterName').val();
   switch(paidMethod) {
       case '1':
           paidMethod += '~'+$('#CreditCardNum').val()+'~'+$('#CreditCardHold').val();
           break;
        case '0':
           var change = parseFloat(Total) - parseFloat(Paid);
           if(change==parseFloat(Total)) Status = 1;
           else if(change>0) Status = 2;
           else if(change<=0) Status = 0;
   }
   var taxamount = $('#num01').text().indexOf('%') != -1 ? parseFloat($('#taxValue').text()) : $('#num01').text();
   var discountamount = $('#num02').text().indexOf('%') != -1 ? parseFloat($('#RemiseValue').text()) : $('#num02').text();

   alert ("tax es "+taxamount);
   alert("descuento"+discountamount);
  $.ajax({
      url : "confirmacheckout/AddNewSale?/"+type,
      type: "POST",
      data: {client_id: clientID, clientname: clientName, waiter_id: waiter, discountamount: discountamount, taxamount: taxamount, tax: Tax, discount: Discount, subtotal: Subtotal, total: Total, created_by: createdBy, totalitems: totalItems, paid: Paid, status: Status, paidmethod: paidMethod, ccnum: ccnum, ccmonth: ccmonth, ccyear: ccyear, ccv: ccv},
      success: function(data)
      {
         $('#printSection').html(data);
         $('#productList').load("pagos/pos/load_posales");
         $('#ItemsNum span, #ItemsNum2 span').load("pagos/pos/totiems");
         $('#Subtot').load("pagos/pos/subtot", null, total_change);
         $('#abonos').load("pagos/pos/abonos", null, total_change);
          $('#AddSale').modal('hide');
         $('#ticket').modal('show');
         $('#ReturnChange span').text('0');
         $('#Paid').val('0');
         $('.holdList').load("pagos/pos/holdList/'.$idregister");
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
         alert('error al adicionar nueva venta');
      }
  });

  $('#CreditCardNum').val('');
  $('#CreditCardHold').val('');
  $('#CreditCardYear').val('');
  $('#CreditCardMonth').val('');
  $('#CreditCardCODECV').val('');

}


</script>



</head>








<?php
echo '<div id="resp"> </div>';


$XOBJRES=new greservas;
$XOBJRES1=new greservas;

$abonos="0";
if (isset($_GET['nombre']))
   $nombre = $_GET['nombre'];
else
   $nombre = "";
if (isset($_GET['item']))
   $item = $_GET['item'];
else
   $item = "0";
if (isset($_GET['total']))
   $total = $_GET['total'];
else
   $total = "0";
if (isset($_GET['totabonos']))
   $totabonos = $_GET['totabonos'];
else
   $totabonos = "0";
if (isset($_POST['paid']))
   $pagos = $_POST['paid'];
else
   $pagos = $total;
if (isset($_POST['metodopago']))
   $metpag = $_POST['metodopago'];
else
   $metpag = "0";
if (isset($_GET['iva']))
   $iva = $_GET['iva'];
else
   $iva = "0";
if (isset($_GET['descuento']))
   $descuento = $_GET['descuento'];
else
   $descuento = "0";
if (isset($_POST['enviar']))
   $enviar = $_POST['enviar'];
else
  if (isset($_GET['enviar']))
   $enviar = $_GET['enviar'];
   else
     $enviar = "";
if (isset($_GET['ivavalue']))
   $taxvalue = $_GET['ivavalue'];
else
   $taxvalue = "0";
if (isset($_GET['subtotal']))
   $subtotal = $_GET['subtotal'];
else
   $subtotal = "0";
if (isset($_GET['dtovalue']))
   $dtovalue = $_GET['dtovalue'];
else
   $dtovalue = "0";
if (isset($_GET['cedula']))
   $cedula = $_GET['cedula'];
else
   $cedula = "0";
if (isset($_GET['idcust']))
   $idcust = $_GET['idcust'];
else
   $idcust = "";
if (isset($_GET['numhab']))
   $numhab = $_GET['numhab'];
else
   $numhab = "";






if ($enviar == "enviar")
{
         $storeid="1";
         $pago = $_GET['pago'];
         $total = $_GET['total'];
         $iva = $_GET['iva'];
         $descuento = $_GET['descuento'];
         $custnombre = $_GET['nombre'];
         $subtotal =  $_GET['subtotal'];
         date_default_timezone_set("America/Bogota");
        $date = date("Y-m-d H:i:s");
        $paystatus = $pago - $total;
        $firstpayement = $paystatus > 0 ? $total : $pago;
        if ($paystatus < 0)
           $estatus = 2;
        else
           $estatus = 0;
        $idhab = "";

        // busco el registro con tienda
        
         $tablaregister = "zarest_registers";
         $camporegister = "zarest_registers.id";
         $filtro = " zarest_registers.status = '1' and store_id = '1'";
         $idregister =   FncBuscarseq1($tablaregister,$camporegister,$filtro);

         // inserto la venta en zares_sale
                  $ivapor = explode(" ",$iva);
                  $ivaporcentaje = $ivapor[0];
                  $ivavalue = $ivapor[1];
                  $descuentopor =  explode(" ",$descuento);
                  $dtoporcentaje = $descuentopor[0];
                  $dtovalue = $descuentopor[1];
                  $VALOR = (int)trim($total);
                  $DEPOSITO = (int)trim($pago);
                  $XINFODETSALE[0] = $idcust;
                 $XINFODETSALE[1] = $custnombre;
                 $XINFODETSALE[2] = $ivavalue;
                 $XINFODETSALE[3] = $subtotal;
                 $XINFODETSALE[4] = $VALOR;
                 $XINFODETSALE[5] = $estatus;
                 $XINFODETSALE[6] = $item;
                 $XINFODETSALE[7] = $DEPOSITO;
                 $XINFODETSALE[8] = $metodopago;
                 $XINFODETSALE[9] = "Recepcion";
                 $XINFODETSALE[10] = "1";
                 $XINFODETSALE[11] = $cedula;
                 $XINFODETSALE[12] = $numhab;
                 $XINFODETSALE[13] = $idhab;
                 $XINFODETSALE[14] =  date("Y-m-d");
                 $XINFODETSALE[15] = "";
                 $XINFODETSALE[16] =  "";
                 $XINFODETSALE[17] = $descuentoporcentaje;
                 $XINFODETSALE[18] = $dtovalue;
                 $XINFODETSALE[19] = $ivaporcentaje;




                  $XRSDETSALE=$XOBJRES->ingresar_sales($XINFODETSALE);
                  if((!isset($XRSDETSALE)) or ($XRSDETSALE == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación de la venta... ".$XRSDETSALE;
                  }

       // ahora busco los productos en posales para insertarlos en sales_items
           // busco el id sales
         $tablasaleitem = "zarest_sales";
         $campocust = "zarest_sales.id";
         $filtro = " zarest_sales.client_id = '".$idcust."'";
         $idcustsaleid =   FncBuscarseq1($tablasaleitem,$campocust,$filtro);
           // busco los productos en posales

         $XHAB=$XOBJRES->buscar_possales($idregister,"0");
         $i=0;
         while($XHABRES=$XOBJRES->obtener_fila($XHAB))
         {
              $idpossale[$i] = $XHABRES[0];
              $nombre[$i] = $XHABRES[1];
              $precio[$i] = $XHABRES[2];
              $qt[$i] =  $XHABRES[3];
              $productid[$i] = $XHABRES[4];
              $salesid[$i] = $XHABRES[5];
              $saleitem_id[$i] = $XHABRES[6];
              $date[$i] = $XHABRES[7];

           // borro sale item
            $XDELITEM=$XOBJRES1->delete_salesitem($saleitem_id[$i]);
            // borro sale
            $XDELSALE=$XOBJRES1->delete_sales($salesid[$i]);
            // inserto sale item
            $XINFODETSALEITEM[0] = $idcustsaleid;
            $XINFODETSALEITEM[1] = $productid[$i];
            $XINFODETSALEITEM[2] = $nombre[$i];
            $XINFODETSALEITEM[3] = $precio[$i];
            $XINFODETSALEITEM[4] = $qt[$i];
            $XINFODETSALEITEM[5] = (int)$precio[$i] * (int)$qt[$i];
            $XRSDETSALEITEM = $XOBJRES1->ingresar_sale_items($XINFODETSALEITEM);
            $i++;

       }
       $XSETANT=$XOBJRES->buscar_settings();
       $XSET=$XOBJRES->obtener_fila($XSETANT);
       $moneda = $XSET[0];
       $decimales = $XSET[6];
       $encabezado = $XSET[1];
       $pie = $XSET[2];
       $phone = $XSET[3];
        $ticket = '<div class="col-md-12"><div class="text-center">' . $encabezado .
         '</div><div style="clear:both;"><h4 class="text-center">#Venta: ' . sprintf("%05d", $idcustsaleid) .
          '</h4> <div style="clear:both;"></div><span class="float-left">Fecha: ' .
          $date . '</span><br><div style="clear:both;"><span class="float-left">Cliente'
           . $custname . '</span><div style="clear:both;"><table class="table" cellspacing="0" border="0"><thead>
           <tr><th><em>#</em></th><th>Producto </th><th> Cantidad </th><th> Subtotal</th></tr></thead><tbody>';

         for ($j = 0; $j < $i; $j++) {
             $ticket .= '<tr><td style="text-align:center; width:30px;">' . $j . '</td><td style="text-align:left; width:180px;">'
            . $nombre[$j] . '</td><td style="text-align:center; width:50px;">' . $qt[$j] . '</td><td style="text-align:right;
            width:70px; ">' . number_format((float)($qt[$j] * $precio[$j]), $decimales, '.', '') . $moneda . ' </td></tr>';

        }

        $bcs = 'code128';
        $height = 20;
        $width = 3;
        $ticket .= '</tbody></table><table class="table" cellspacing="0" border="0" style="margin-bottom:8px;"><tbody><tr>
        <td style="text-align:left;">Total Items </td><td style="text-align:right; padding-right:1.5%;">' .
        $item . '</td><td style="text-align:left; padding-left:1.5%;">Total </td>
        <td style="text-align:right;font-weight:bold;">' . $subtotal . ' '. $moneda.'</td></tr>';
        if (intval($dtovalue))
            $ticket .= '<tr><td style="text-align:left; padding-left:1.5%;"></td>
            <td style="text-align:right;font-weight:bold;"></td><td style="text-align:left;">Descuento</td>
            <td style="text-align:right; padding-right:1.5%;font-weight:bold;">' . $dtovalue . '</td></tr>';
        if (intval($ivaporcentaje))
            $ticket .= '<tr><td style="text-align:left;"></td><td style="text-align:right; padding-right:1.5%;font-weight:bold;">
            </td><td style="text-align:left; padding-left:1.5%;"> Iva </td>
            <td style="text-align:right;font-weight:bold;">' . $ivaporcentaje .' '. $ivavalue. '</td></tr>';
        $ticket .= '<tr><td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;"> Gran Total</td>
        <td colspan="2" style="border-top:1px dashed #000; padding-top:5px; text-align:right; font-weight:bold;">'
        . number_format((float)$total, $decimales, '.', '') . ' '. $moneda.' </td></tr><tr>';

        $PayMethode = explode('~', $metodopago);

        switch ($PayMethode[0]) {
            case '1': // case Credit Card
                $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;"> Tarjeta de Credito</td>
                <td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">xxxx xxxx xxxx ' .
                substr($PayMethode[1], - 4) . '</td></tr><tr>
                <td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;"> Titular</td>
                <td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . $PayMethode[2] . '</td>
                </tr></tbody></table>';
                break;

            default:
                $ticket .= '<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;"> Pago </td>
                <td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' .
                number_format((float)$pago, $decimales, '.', '') . ' COP</td></tr><tr>
                <td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;"> Saldo</td>
                <td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' .
                number_format((float)(floatval($pago) - floatval($total)), $decimales, '.', '') . ' '.$moneda.'</td></tr></tbody>
                </table>';
        }

        $storename = "Punto de Venta";
        $ticket .= '<div style="border-top:1px solid #000; padding-top:10px;"><span class="float-left">' . $storename .
        '</span><span class="float-right"> Telefono' . ($phone ? $phone : 0) . '</span>
        <div style="clear:both;"><center><img style="margin-top:30px" src="' . site_url('pos/GenerateBarcode/' .
        sprintf("%05d", $idcustsaleid) . '/' . $bcs . '/' . $height . '/' . $width) . '" alt="' . $idcustsaleid . '" /></center>
        <p class="text-center" style="margin:0 auto;margin-top:10px;">' . $pie . '</p>
        <div class="text-center"
        style="background-color:#000;padding:5px;width:85%;color:#fff;margin:0 auto;border-radius:3px;margin-top:20px;">' .
         $pie . '</div></div>';

         // borro posale
         $id = "%";
         $XACTCALENDAR=$XOBJRES->delete_possales($id);

         // imprimo factura
        echo $ticket;

}



?>

<link href="assets/css/pagos/Style-Light.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/pagos/bootstrap-horizon.css" rel="stylesheet">

<?php

echo '<body>';
if (!isset($resp))
  $resp="";

//        <!-- Modal -->
$resp = $resp .' <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="AddSale">Procesar Pago Checkout</h4>
      </div>
      <form id="pagoform" method="post" action="confirmacheckout.php">
      <div class="modal-body">
            <div class="form-group">
               <h2 id="cliente"> Cliente <span>'. $nombre . '
               </span></h2>
           </div>
           <div class="form-group">
             <h3 id="ItemsNum2"><span>'. $item .'</span> Item</h3>
          </div>
           <div class="form-group">
             <h2 id="total">'. $total .' Total a pagar </h2>
          </div>
          <div class="form-group">
             <h3 id="subtotal">'. $subtotal .' Subtotal </h3>
          </div>
          <div class="form-group">
             <h3 id="iva">'. $iva .' '.$taxvalue.' Iva </h3>
          </div>
          <div class="form-group">
             <h3 id="dto">'. $descuento .' '.$dtovalue.' Descuento </h3>
          </div>
          <div class="form-group">
             <h3 id="abonos">'. $totabonos .' Abonos </h3>
          </div>
           <div class="form-group">
             <label for="paymentMethod">Metodo de Pago</label>
             <select class="js-select-options form-control" id="metodopago" name="metodopago" onChange="metodopago(this.value)">
               <option value="0">Efectivo</option>
               <option value="1">Tarjeta de credito</option>
             </select>
              </div>   ';

$resp = $resp . ' <div class="form-group Paid">
             <label for="Paid">Pago</label>
             <input type="text" value="'. $total .'" name="pago" class="form-control" id="pago" placeholder="Pago" >
           </div> ';
           $resp = $resp . '<div >
             <input type="text" value="" name="subtotal" value="'.$subtotal.'" id="subtotal" >
             <input type="text" value="" name="taxvalue" value="'.$taxvalue.'" id="subtotal" >
             <input type="text" value="" name="dtovalue" value="'.$dtovalue.'" id="subtotal" >
             <input type="text" value="" name="cedula" value="'.$cedula.'" id="cedula" >
             <input type="text" value="" name="idcust" value="'.$idcust.'" id="idcust" >
             <input type="text" value="" name="numhab" value="'.$numhab.'" id="numhab" >

           </div>  ';
  $saldo = $total - $pagos;


 $resp =  $resp . '          <div class="form-group CreditCardNum">
             <i class="fa fa-cc-visa fa-2x" id="visa" aria-hidden="true"></i>
             <i class="fa fa-cc-mastercard fa-2x" id="mastercard" aria-hidden="true"></i>
             <i class="fa fa-cc-amex fa-2x" id="amex" aria-hidden="true"></i>
             <i class="fa fa-cc-discover fa-2x" id="discover" aria-hidden="true"></i>
             <label for="CreditCardNum">Numero Tarjeta de Credito</label>
             <input type="text" class="form-control cc-num" id="CreditCardNum" placeholder="Numero Tarjeta">
           </div>
           <div class="clearfix"></div>
           <div class="form-group CreditCardHold col-md-4 padding-s">
             <input type="text" class="form-control" id="CreditCardHold" placeholder="Titular">
           </div>
           <div class="form-group CreditCardHold col-md-2 padding-s">
             <input type="text" class="form-control" id="CreditCardMonth" placeholder="Mes">
           </div>
           <div class="form-group CreditCardHold col-md-2 padding-s">
             <input type="text" class="form-control" id="CreditCardYear" placeholder="Año">
           </div>
           <div class="form-group CreditCardHold col-md-4 padding-s">
             <input type="text" class="form-control" id="CreditCardCODECV" placeholder="CCV">
           </div>  ';
           $resp = $resp .'        <div class="form-group ReturnChange">

             <h3 id="saldo">Saldo <span>0 </span> COP</h3>
          </div>
          <div class="clearfix"></div>
      </div>';

    $resp = $resp .'  <div class="modal-footer">
        <button type="button" class="btn btn-default"  onclick="window.close()">Cerrar</button>
        <button type="button" class="btn btn-primary" name="enviar" value="enviar" onclick="Prcenviar(this.value)"> Enviar   </button>
      </div>
      </form>
    </div>
 </div> ';
 echo '  <div id="resp"> ' . $resp. '</div>';

 echo '</body></html>';
?>
<!-- /.Modal -->

