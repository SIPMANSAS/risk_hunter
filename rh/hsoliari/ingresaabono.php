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
   $('#abonos').show();
   $('#idres').hide();
   $('#idcust').hide();
   $('#numhab').hide();
   $('#cedula').hide();
   $('#idsale').hide();



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
      var change = -( (parseFloat($('#total').text()) - parseFloat($('#abonos').text()))  - (parseFloat($(this).val() )));
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
if (isset($_GET['metodopago']))
   $metodopago = $_GET['metodopago'];
else
   $metodopago = "0";
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
if (isset($_GET['idres']))
   $idres = $_GET['idres'];
else
   $idres = "";
if (isset($_GET['otcg']))
   $otcg = $_GET['otcg'];
else
   $otcg = "";
if (isset($_GET['abonos']))
   $abono = $_GET['abonos'];
else
   $abono = "";


if ($enviar == "enviar")
{
         $storeid="1";
         $pago = $_GET['pago'];
         $total = $_GET['total'];
         $idsale = $_GET['idsale'];
         $idresp = $_GET['idres'];
         $numhab = $_GET['numhab'];
         $abono = $_GET['abonos'];
         $date = date("Y-m-d");
         $DEPOSITO = (int)trim($pago);
         $grantotal = explode(" ",$total);
         $VALOR = (int)trim($grantotal[0]);
         $creditcardnum = $_GET['creditcardnum'];
         $creditcardhold = $_GET['creditcardhold'];
         $totabono = explode(" ",$abono);
         $TOTABONOS = (int)trim($totabono[0]);
         $idresdesg = explode(" ",$idresp);
         $idres =  $idresdesg[0];


        $TOTDEP = $TOTABONOS + $DEPOSITO;
        $paystatus = $TOTDEP - $VALOR;
        $firstpayement = $paystatus > 0 ? $VALOR : $DEPOSITO;
        if ($paystatus < 0)
           $estatus = 2;
        else
           $estatus = 1;
        $idhab = "";
           if ($metodopago == '1')
              $metodopago = "1~".$creditcardnum."~".$creditcardhold;

        // busco el registro con tienda

         $tablaregister = "zarest_registers";
         $camporegister = "zarest_registers.id";
         $filtro = " zarest_registers.status = '1' and store_id = '1'";
         $idregister =   FncBuscarseq1($tablaregister,$camporegister,$filtro);
         
         // actualizo zares_sale con el pago
          $XACTSALE = $XOBJRES->actualiza_sales($idsale, $TOTDEP, $estatus, $firstpayement);

         // inserto el pago en la tabla payments
         
                 $XINFODETPSALE[0] = $date;
                 $XINFODETPSALE[1] = $DEPOSITO;
                 $XINFODETPSALE[2] = $metodopago;
                 $XINFODETPSALE[3] = "Recepcion";
                 $XINFODETPSALE[4] = $idregister;
                 $XINFODETPSALE[5] = $idsale;
                 $XINFODETPSALE[6] = "0";

                 $XRSDETSALE=$XOBJRES->ingresar_abonossale($XINFODETPSALE);
                  if((!isset($XRSDETSALE)) or ($XRSDETSALE == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación de la venta... ".$XRSDETSALE;
                  }
               //    $campossale = "paid='$TOTABONOS', status='$estatus'";
             //    $XRSACTSALE=$XOBJRES->actualiza_saleshab($campossale, $idsale);
                   $campossale = "valor_deposito='$TOTDEP'";
                 $XRSACTSALE=$XOBJRES->actualiza_checkin($campossale, $idres);


          $encabezado = "Se ha realizado correctamente el Abono por valor de $DEPOSITO";
          $ticket = '
        <div class="col-md-12"><div class="text-center">' . $encabezado .
         '</div> <div class="modal-footer">
        <button type="button" class="btn btn-default"  onclick="window.close()">Cerrar</button>
        </div>
        </div';
        echo $ticket;
     //    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";


         
$flaq = 1;
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

if (!isset($flaq) or ($flaq <> "1"))
{
          $cedula = trim($_GET['cedula']);
          $tablacustom = "zarest_customers";
          $campocust = "zarest_customers.id";
          $filtro = " zarest_customers.numdocu = '".$cedula."'";
          $clientid =   FncBuscarseq1($tablacustom,$campocust,$filtro);
          $numhab = $_GET['numhab'];

          $XSALE=$XOBJRES->buscar_sales($clientid,$numhab);
          $XTOTTAR=$XOBJRES->obtener_fila($XSALE) ;
          $idsale = $XTOTTAR[0];
          $total = $XTOTTAR[1];

       // miro la tienda y el registro abierto
          $tablaregister = "zarest_registers";
          $camporegister = "zarest_registers.id";
          $filtro = " zarest_registers.status = '1' and store_id = '1'";
          $idregister =   FncBuscarseq1($tablaregister,$camporegister,$filtro);

       // busco pagos y abonos
        $XSUBABON=$XOBJRES->buscar_sumpagos($idregister,$idsale);
        $XABONO=$XOBJRES->obtener_fila($XSUBABON) ;
        if (isset($XABONO[0])) {
           $totabonos =  $XABONO[0];
           $totitemabono =  $XABONO[1];
        }
        else
        {
            $totabonos =  0;
            $totitemabono =  0;
        }
        $saldores = $total - $totabonos;


//        <!-- Modal -->
$resp = $resp .' <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="AddSale">Abonos</h4>
      </div>
      <form id="pagoform" method="post" action="ingresaabono.php">
      <div class="modal-body">
            <div class="form-group">
             <h3 id="total">'. $total .' Total a pagar </h3>
          </div>
           <div class="form-group">
             <h3 id="abonos">'. $totabonos .' Total Abonos'.$totitemabono.'Items </h3>
          </div>
           <div class="form-group">
             <h3 id="saldo">'. $saldores .' Saldo a pagar </h3>
          </div>
          <div class="form-group">
             <h3 id="idres">'. $idres .' idcheckin</h3>
          </div>
           <div class="form-group">
             <h3 id="idcust">'. $idcust .' idcust</h3>
          </div>
           <div class="form-group">
             <h3 id="numhab">'. $numhab .' hab</h3>
          </div>
          <div class="form-group">
             <h3 id="cedula">'. $cedula .' cedula</h3>
          </div>
          <div class="form-group">
             <h3 id="idsale">'. $idsale .'</h3>
          </div>


           <div class="form-group">
             <label for="paymentMethod">Metodo de Pago</label>
             <select class="js-select-options form-control" id="metodopago" name="metodopago" onChange="metodopago(this.value)">
               <option value="0">Efectivo</option>
               <option value="1">Tarjeta de credito</option>
             </select>
              </div>   ';

              $resp = $resp . ' <div class="form-group Paid">
             <label for="Paid">Abono</label>
             <input type="text" value="'. $saldores .'" name="pago" class="form-control" id="pago" placeholder="Pago" >
           </div> ';
           $resp = $resp . '<div >
             </div>  ';
             $saldo = $saldores - $pagos;


 $resp =  $resp . '<div class="form-group CreditCardNum">
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
           </div> ';
           $resp = $resp .'        <div class="form-group ReturnChange">

             <h3 id="saldo">Saldo <span>0 </span> COP</h3>
          </div>
          <div class="clearfix"></div>
      </div>';

    $resp = $resp .'  <div class="modal-footer">
        <button type="button" class="btn btn-default"  onclick="window.close()">Cerrar</button>
        <button type="button" class="btn btn-primary" name="enviar" value="enviar" onclick="Prcenviarabono(this.value)"> Enviar   </button>
      </div>
      </form>
    </div>
 </div> ';
 echo '  <div id="resp"> ' . $resp. '</div>';
}

 echo '</body></html>';
?>
<!-- /.Modal -->

