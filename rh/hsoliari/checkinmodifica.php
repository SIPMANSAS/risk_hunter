<?php


include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';
date_default_timezone_set("America/Bogota");

echo '<div id="resp"> </div>';


function FncBuscarseq($XSEQUENCIA,$parametro,$filtro) {
           $XSELECT = "select lpad(($parametro + 1),5,'0') from $XSEQUENCIA where $filtro order by $parametro desc limit 1";
           $XOBJRES=new greservas;
           $XROWSEQUENCIA = $XOBJRES->FncBuscarSequencia($XSELECT);
           $XNEXTSEQ=$XOBJRES->obtener_fila($XROWSEQUENCIA);
           return $XNEXTSEQ[0];
}

function FncBuscarseq1($XSEQUENCIA,$parametro,$filtro) {
           $XSELECT = "select $parametro from $XSEQUENCIA where $filtro
           order by $parametro desc limit 1";
           $XOBJRES=new greservas;
           $XROWSEQUENCIA = $XOBJRES->FncBuscarSequencia($XSELECT);
           $XNEXTSEQ=$XOBJRES->obtener_fila($XROWSEQUENCIA);
          return $XNEXTSEQ[0];
}


function restar_fechas($fechaini, $fechafin) {
         if (isset($fechaini) and isset($fechafin)) {
            $segundos=strtotime($fechafin) - strtotime($fechaini);
            $diferencia_dias=intval($segundos/86400);
         }
         else
              $diferencia_dias = 0;
         return  $diferencia_dias;
}

?>

<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>Registro de Usuarios en el Hotel</title>

<!-- Bootstrap core CSS -->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="assets/css/sticky-footer-navbar.css" rel="stylesheet">
<link href="assets/css/styledynam.css" rel="stylesheet">

<script src="http://code.jquery.com/jquery-2.1.1.js"></SCRIPT>
<script type="text/javascript" src="assets/js/gestion_reservas3.js" ></script>
<script>
function AgregarMas() {
    var id = $(".lista-producto").length + 1;
	$("<div>").load("InputDinamico.php", function() {
            var html = $(this).html();
            html = html.replace('documento-1', 'documento-' + id);
            html = html.replace('nombre-1', 'nombre-' + id);
            html = html.replace('email-1', 'email-' + id);
            html = html.replace('idtercero-1', 'idtercero-' + id);
            $("#listhuesped").append(html);
         	buscarInfoTerceros();
	});
}
function BorrarRegistro() {
	$('div.lista-producto').each(function(index, item){
		jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
				$(item).remove();
            }
        });
	});
}


</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>


$.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: $(this).serialize(),
     success: function(data) {
        $('#result').text(data.disp);
      }
});

$(document).ready(function () {
        $("#adult").keyup(function () {
            var value = $(this).val();
            $("#pax").val(value);
        });
});

$(document).ready(function () {
        $("#ninno").keyup(function () {
            var value = parseInt($(this).val()) + parseInt($("#adult").val());
            $("#pax").val(value);
         });

});

$(document).ready(function () {
        $("#tipotarifa").change(function () {
            var cadena = $(this).val() ;
            var noches =  $("#noches").val();
            var tarifa1 = cadena.split('-');
            var tarifa = parseInt(tarifa1[1]);
            var idtarifa = tarifa1[0];
            var totalreserva = tarifa * noches;
            $("#amount").val(tarifa);
            $("#saldo").val(tarifa);
            $("#idtarifa").val(idtarifa);
            $("#totalreserva").val(totalreserva);
         });

});

$(document).ready(function () {
        $("#datepicker2").change(function () {
           var d1 = $('#datepicker1').val();
            var d2 = $('#datepicker2').datepicker('getDate');
            var diff = 0;
            if (d1 && d2) {
                diff = Math.floor((d2.getTime() - d1.getTime()) / 86400000); //ms per day
            }
            $('#noches').val(diff);

         });

});

$(function() {
      var dates = $('#datepicker1, #datepicker2').datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: '+2d',
            changeMonth: false,
            numberOfMonths: 1,
            showOn: 'both',
            buttonImage: 'assets/images/calendar2.png',
            buttonImageOnly: true,
            onSelect: function(selectedDate) {
                   var d1 = $('#datepicker1').datepicker('getDate');;
                    var d2 = $('#datepicker2').datepicker('getDate');
                    var idhab = $('#idhab').text

                    var min =   d1.getHours()*60;
                    var seg =   d1.getSeconds()/60;
                    var min2 = min + d1.getMinutes() + seg;
                    d2.setMinutes(d2.getMinutes() + min2);
                    d2.setSeconds(d1.getSeconds());

                    if (d1 && d2) {
                        diff = Math.round((d2.getTime() - d1.getTime()) / 86400000); //ms per day
                      }
                      $('#noches').val(diff);
                      $('#noches').val(diff);

                      $("#key").focus();

              }
      });
});


  </script>

 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="assets/css/stylesautocomplet.css">

<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

function buscarInfoTerceros(){
    $('[id^=documento-').on('keyup', function() {
        var key = $(this).val();
        var dataString = 'key='+key;
        var rowId = $(this).attr('id').split('-')[1];

	$.ajax({
            type: "POST",
            url: "ajaxtercero.php",
            data: dataString,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions2').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.suggest-element').on('click', function(){

                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#documento-'+rowId).val($('#'+id).attr('cedula'));
                        $('#nombre-'+rowId).val($('#'+id).attr('nombre'));
                        $('#email-'+rowId).val($('#'+id).attr('email'));
                        $('#idtercero-'+rowId).val($('#'+id).attr('id'));
                        $('#eps-'+rowId).val($('#'+id).attr('eps'));

                        //Hacemos desaparecer el resto de sugerencias
                        $('#suggestions2').fadeOut(1000);
                        alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        return false;
                });
            }
        });
    });
    }

$(document).ready(function() {
    $('#key').on('keyup', function() {
        var key = $(this).val();
        var dataString = 'key='+key;
	$.ajax({
            type: "POST",
            url: "ajaxtercero.php",
            data: dataString,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#suggestions').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#key').val($('#'+id).attr('cedula'));
                        $('#nombre').val($('#'+id).attr('nombre'));
                        $('#email').val($('#'+id).attr('email'));
                        $('#telefono').val($('#'+id).attr('telefono'));
                        $('#pais').val($('#'+id).attr('pais'));
                        $('#idtercero').val($('#'+id).attr('id'));
                        $('#eps').val($('#'+id).attr('eps'));

                        //Hacemos desaparecer el resto de sugerencias
                        $('#suggestions').fadeOut(1000);
                        alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        return false;
                });
            }
        });
    });

    buscarInfoTerceros();
});

function numpax() {
     var adult = $("#adult").val();
     if($("#adult").val() == ""){
        alert("El campo Adult no puede estar vacio.");
        $("#adult").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
        return false;
    }
};

function cambianinno() {
     var pax = $("#pax").val();
     var ninno = $("#ninno").val();
     var url = "checkin.php";
     $.ajax({
           type: "POST",
           url: url,
           data: $("#checkin").serialize(),
           success: function(data) {
              $('#resp1').fadeOut(1000);
               $('#resp').html(data);
                 $("#eps").focus();
      }
         });
     
};

function tipotarifa(sel) {
     var idtarifa = sel.value;
     var url = "archivoenviarDato.php";
     $.ajax({
           type: "POST",
           url: url,
           data: idtarifa,
           success: function(data) {
                 $("#amount").val(data);
                 $("#saldo").val(data);

      }
         });

};

$(document).ready(function () {
        $("#amount").keyup(function () {
            var tarifa = $(this).val() ;
            var noches =  $("#noches").val();
            var totalreserva = tarifa * noches;
            $("#deposit").val(tarifa);
             $("#saldo").val(0);
            $("#totalreserva").val(totalreserva);
            if (totalreserva < 0)
               alert("Tarifa no puede ser negativa");
         });

});

</script>


</head>

<body>

<?php

if (!isset($tiha))
  $tiha = "";


echo '<div id="resp1"> ';
?>
  <header>
   <nav>
    <div class="logo">
       <a href="index2.php"><img src="assets/images/logo-horos-transparente.fw.png" alt=""></a>
    </div>
      <div class="menu-a">
          <a href="buscar_reservas.php">Retornar</a>
      <a href="index2.php">Menu Principal</a>
      <a href="home.php">Disponibilidad de Habitaciones</a>
      </div>

    </nav>
    </header>

     <div class="contenedor">

<?php
if (empty($disp))
   $disp = "";


// inicia a grabar checkin  cuando se ha pulsado guardar

if(!empty($_POST["guardar"])) {

  if (!isset($_POST['noches']) or ($_POST['noches'] <1))
      $mensaje = "Verifique el numero de noches, vuelva a Seleccionar fecha de Entrada y Salida.";
 else
 {
   $fent = $_POST['entrada'];
   if ( $_POST['salida1'] ==  $fent)
   {
        $mensaje = "Siempre debe seleccionar una fecha de salida!.";
   }
   else
   {
    if (!isset($_POST['tipotarifa']) or ($_POST['tipotarifa'] == ""))
      $mensaje = "Siempre debe seleccionar un tipo de tarifa";
   else
   {

   if (!isset($_POST['idtarifa1']) or (!isset($_POST['habit'])) or (!isset($_POST['idhab'])))

                    $mensaje = "Verifique el numero que la asignacion de una habitacion y escoger una tarifa.";
   else
   {
         if (!isset($_POST['guestadult']))
                $mensaje = "Siempre se debe digitar el numero de Adultos.";
         else
         {


       $correcto = "";
       $setid = "001";
   $cedula1 = trim($_POST["cedula1"]);
   if ($_POST['idhab'])
      $idhab = trim($_POST['idhab']);
   else
      $idhab = "";
   if ($_POST['numres'])
      $numres = trim($_POST['numres']);
   else
      $numres = "";


   if (($setid != "" ) && ( $_POST["entrada"] != "") && ($_POST['salida1'] != "") && $cedula1 != "" && $cedula1 != "0" && $idhab != "")
    {

        $flaq = 1;
       $secuencia="";
       $mens = "";
       $correcto = "true";
       $XOBJRES=new greservas;

       // si no hay reserva debo crear todo
       $idtercero1 = $_POST['idtercero1'];
        if (!isset($_POST['numres']) or ($_POST['numres'] == ""))
        {
             $idtercero1 = "";
             $numres = "";
        }
        else
           $numres = $_POST['numres'];
       // busco si selecciono un tercero
       $tercero = "";
       $flq = "0";
       if (isset($_POST['tercero']))
          $tercero = trim($_POST['tercero']);
       if ( ($tercero != "") && ($tercero != "00001") && (!empty($tercero)) )
       {
          // busco el cliente
            $idtercero = $tercero;
            $flq = "1";
          	$XRCLI=$XOBJRES->buscar_cliente($idtercero,$setid);
	        $XROWCLI=$XOBJRES->obtener_fila($XRCLI);
            if (isset($XROWCLI[0]))
	           $idcliente =  $XROWCLI[0];
            else
               $idcliente = "";
       }
       else
       {
            // busco cedula que no exista
           $numcedula = trim($_POST['cedula1']);
            $xrowced = $XOBJRES->buscar_cedulater($numcedula);
           $ROWcedula = $XOBJRES->obtener_fila($xrowced);
           if ((isset($ROWcedula[0])) && ($ROWcedula[0] == $numcedula) )
           {
                $mensaje = "Tercero Ok.";
                $disp = $disp . $mensaje;
                $correcto = "true";
                // busco el cliente
                $idtercero = $ROWcedula[1];
            $flq = "1";
          	$XRCLI=$XOBJRES->buscar_cliente($idtercero,$setid);
	        $XROWCLI=$XOBJRES->obtener_fila($XRCLI);
            if (isset($XROWCLI[0]))
	           $idcliente =  $XROWCLI[0];
            else
               $idcliente = "";
           }
           else {


       // ingresa datos del tercero en la tabla tbl_tercero
       $tablater = "tbl_terceros";
       $campoter = "tbl_terceros.id_tercero";
       $filtro = " tbl_terceros.setid = '".$setid."'";
       $idtercero =   FncBuscarseq($tablater,$campoter,$filtro);

        $numcedula = trim($_POST['cedula1']);
       $XINFOTER[0] =  $setid;
       $XINFOTER[1] = $idtercero;
       $XINFOTER[2] = $numcedula;
       $XINFOTER[3] = $_POST['guestname'];
       $XINFOTER[4] = $_POST['guestemail'] ;
       $XINFOTER[5] = $_POST['guestphone'] ;
       $XINFOTER[6] =  $_POST['guestcountry'] ;


       $XRSTER=$XOBJRES->ingresar_tercero($XINFOTER);
	    if((!isset($XRSTER)) or ($XRSTER == FALSE)) {
              $correcto = "false";
              $mensaje = "Se ha presento error en la creación del tercero... ".$XRSTER;


       }
       else {
          // ingresa datos del cliente en la tabla tbl_cliente
            $tablacliente = "tbl_clientes";
            $campocli = "tbl_clientes.id_cliente";
            $filtro = " tbl_clientes.setid = '".$setid."'";
            $idcliente =   FncBuscarseq($tablacliente,$campocli,$filtro);
            if (!isset($idcliente))
              $idcliente = "00001";

             $numcedula = trim($_POST['cedula1']);
            $XINFOCLI[0] =  $setid;
            $XINFOCLI[1] = $idcliente;
            $XINFOCLI[2] = $idtercero;
            $XINFOCLI[3] = $_POST['asesorcom'];
            $XINFOCLI[4] = $_POST['referidopor'] ;
            $XINFOCLI[5] = $numcedula ;
            $XINFOCLI[6] =  $_POST['guestname'] ;
            $XINFOCLI[7] = $_POST['guestemail'] ;
            $XINFOCLI[8] = $_POST['guestphone'] ;
            $XINFOCLI[9] =  $_POST['guestcountry'] ;

            $XRSCLI=$XOBJRES->ingresar_cliente($XINFOCLI);
            if((!isset($XRSCLI)) or ($XRSCLI == FALSE)) {
              $correcto = "false";
              $mensaje = "Se ha presento error en la creación del Cliente... ".$XRSCLI;
            }
            
             // inserto cliente en posrestaurante para consumo
            $XINFOCUST[0] = $_POST['guestname'];
            $XINFOCUST[1] = $numcedula;
            $XINFOCUST[2] = $_POST['guestemail'];
            $XINFOCUST[3] = $_POST['guestphone'];
            $XRSCUSTOMER=$XOBJRES->ingresar_customerzarest($XINFOCUST);



         }
        }
        }

        if ($correcto == "true")
        {
                $numcedula = trim($_POST['cedula1']);
                $tablacustom = "zarest_customers";
                $campocust = "zarest_customers.id";
                $filtro = " zarest_customers.numdocu = '".$numcedula."'";
                $idcust =   FncBuscarseq1($tablacustom,$campocust,$filtro);

                // ACTUALIZA RESERVA
           //   $numnoches = restar_fechas($_POST['entrada'] , $_POST['salida1']);
            if (isset($_POST['noches']))
               $numnoches = $_POST['noches'];
             else
               $numnoches = 1;
              $adult = (int)trim($_POST['guestadult']);
            if (!isset($_POST['guestchild']))
               $nino = 0;
            else
               $nino = (int)trim($_POST['guestchild']);

            $valorreserva = (int)trim($_POST['totalreserva']);
            $abono = (int)trim($_POST['deposit']);
            $numres = trim($numres);
              // miro la tienda y el registro abierto
          $tablaregister = "zarest_registers";
          $camporegister = "zarest_registers.id";
          $filtro = " zarest_registers.status = '1' and store_id = '1'";
          $idregister =   FncBuscarseq1($tablaregister,$camporegister,$filtro);


            $datosupdate = "id_tercero = '$idtercero', cant_noches = '$numnoches', cant_adultos = '$adult', cant_menores = '$nino',
               valor_reserva = '$valorreserva', estado = '10', id_cliente = '$idcliente', valor_deposito = '$abono'";

                $XRSPRE=$XOBJRES->actualiza_checkin($datosupdate, $numres);


                  if (!isset($_POST['idtarifa1']))
                    $tipotarifa = "";
                 else
                    $tipotarifa = trim($_POST['idtarifa1']);
                 if (!isset($_POST['habit']))
                    $_POST['habit'] = "";
                // actualizo el detalle de la reserva  en tbl_det_reserva
                
                 $cantpers = $adult + $nino;
                 if ((isset($_POST["parqueadero"])) && ($_POST["parqueadero"] == "1"))
                     $parqueadero = $_POST["parqueadero"];
                 else
                     $parqueadero ='0';
                 if ((isset($_POST["desayuno"])) && ($_POST["desayuno"] == "1"))
                          $desayuno = $_POST["desayuno"];
                 else
                          $desayuno = '0';
                   $tipovehiculo = $_POST["tipovehiculo"];
                  $placa = $_POST["placa"];
                  //$referidopor = $_POST["referidopor"];
                  $asesorcom = $_POST["asesorcom"];
                  $note_en = $_POST["note_en"];
                  if (isset($_POST["referidopor"]))
                     $canal = $_POST["referidopor"];
                  else
                     $canal = "";


                   $idhab = $_POST['habit'];
                 $xrowhab = $XOBJRES->buscar_numhab($idhab);
                 $XROWHAB1 = $XOBJRES->obtener_fila($xrowhab);
                 if (isset($XROWHAB1[0]))
                     $numhab1 =  $XROWHAB1[0];
                 else
                     $numhab1 = $_POST['numhab'];

                     $salida = date("Y-m-d", strtotime($_POST['salida1']));
                     $entrada =  date("Y-m-d", strtotime($_POST['entrada']));
                 $camposdetres = "fecha_fin='$salida', idtipotarifa = '$tipotarifa' , cant_adultos = '$adult', cant_menores = '$nino',
                   id_habitacion = '$idhab', cantidad = '$cantpers', parqueadero = '$parqueadero', desayuno='$desayuno', tipovehiculo = '$tipovehiculo',
                   placa = '$placa', asesor='$asesorcom', canal='$canal', note='$note_en', fecha_ini='$entrada'";

                 $XRSDETPRE=$XOBJRES->actualiza_detreserva($camposdetres, $numres);
                 $correcto = "true";
                 $mensaje =  "Se ha actualizado el Huesped en la Habitacion(es) Correctamente No.Checkin: $numres
                  No. Habitacion: $numhab1 " . $mens ;


                 // busco el numero de reserva que tiene ese checkin
                   $xrowres = $XOBJRES->buscar_numrescal($numres);
                 $XROWres1 = $XOBJRES->obtener_fila($xrowres);
                 if (isset($XROWres1[0]))
                 {
                     $bookingid =  $XROWres1[0];
                     $XRSDELCALDATA=$XOBJRES->borrar_calendardata($bookingid);
                     $XRSDELCALDETAIL=$XOBJRES->borrar_calendardetail($bookingid);
                 }
                 else
                     $bookingid = "";

                     // estados
                       if ((int)trim($_POST['balancedue']) == 0)
                       {
                           $estadores="10";
                           $status=0;
                       }
                       else
                          if ((int)trim($_POST['deposit']) > 0)
                          {
                              $estadores = "10";
                              $status=2;
                          }
                          else
                          {
                              $estadores = "10";
                              $status=1;
                          }

                 // actualizo en la tabla sale el numero de habitacion
                $tablacustom = "zarest_sales";
                $campocust = "zarest_sales.id";
                $filtro = " zarest_sales.checkinid = '".$numres."'";
                $idsale =   FncBuscarseq1($tablacustom,$campocust,$filtro);

                 
                 $name=$_POST['guestname'];
                 $amount = (int)trim($_POST['amount']);
                 $abonoanterior =  (int)trim($_POST['abonoanterior']);
                 $totalabonos =   (int)trim($_POST['totalabonos']) + $abono - $abonoanterior;
                 $campossale = "paidmethod='2~".$numhab1."' , numhab='$numhab1', idhab='$idhab', paid='$totalabonos', firstpayement='$abono',
                                client_id='$idcust', numdoc='$numcedula', clientname='$name', subtotal = '$amount',
                                total = '$valorreserva', status='$status'";
                 $XRSACTSALE=$XOBJRES->actualiza_saleshab($campossale, $numres);
                 

                 
                 $campossale = "price='$amount', qt='$numnoches', subtotal='$valorreserva'";
                 $XRSACTSALE=$XOBJRES->actualiza_salesitemhab($campossale, $idsale);

                 // actualizo primer abono
                 
                 if (isset($_POST['metpago']))
                     $metodopago = $_POST['metpago'];
                  else
                     $metodopago = "0";
                 $campossale = "paid = '$abono', paidmethod='$metodopago'";
                 $XRSACTSALE=$XOBJRES->actualiza_abonosale($campossale, $idsale);
                  if((!isset($XRSACTSALE)) or ($XRSACTSALE == FALSE)) {
                                    // ingresar en zarest_payments el abono
                                    $XINFODETPSALE[0] = date("Y-m-d");
                                    $XINFODETPSALE[1] = $abono;
                                    $XINFODETPSALE[2] = $metodopago;
                                    $XINFODETPSALE[3] = $username;
                                    $XINFODETPSALE[4] = $idregister;
                                    $XINFODETPSALE[5] = $idsale;
                                    $XINFODETPSALE[6] = "0";

                                    $XRSDETSALE=$XOBJRES->ingresar_abonossale($XINFODETPSALE);
                  }



                  // TOCA MIRAR COMO SE ACTUALIZA EL CALENDARIO CUANDO CAMBIA NUMERO DE NOCHES Y FECHA DE SALIDA
                 // Actualizo la reserva con los datos de cedula, abonos y estado de la reserva
               /*  $numerores = trim($_POST['numres']);

                 if (isset($numerores) && $numerores <> "")
                 {
                       $cedula = trim($_POST['cedula1']);
                       $estadores = $_POST['estadores'];
                       $setid = $setid;
                       $calendarreserva = $_POST['numres'];
                       if ((int)trim($_POST['balancedue']) == 0)
                           $estadores="12";
                       else
                          if ((int)trim($_POST['deposit']) > 0)
                              $estadores = "11";
                          else
                              $estadores = "10";

                      $XACTCALENDAR=$XOBJRES->actualiza_reserva($calendarreserva, $cedula, $estadores, $setid, $idtercero, $idhab);
                      if((!isset($XACTCALENDAR)) or ($XACTCALENDAR == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la actualizacion de la reserva... ".$XACTCALENDAR;
                       }

                 }
                 else
                 {
                          */
                        // ingreso el checkin en la tabla del calendario para bloquear habitaciones ocupadas
                          // ingreso el checkin en la tabla del calendario para bloquear habitaciones ocupadas
                           $tablacalendar = "calendar_details";
                           $filtro = "calendar_details.id like '%'";
                           $campobooking = "calendar_details.id";
                           $bookingid =   FncBuscarseq1($tablacalendar,$campobooking,$filtro);
                           if (!isset($bookingid))
                               $bookingid = "1";
                           else
                            $bookingid = $bookingid + 1;
                            // voy a insertar calendar_details

                             $XINFOCALDET[0] = $bookingid;
                             $XINFOCALDET[1] = "23";
                             $XINFOCALDET[2] = $idhab;
                             $XINFOCALDET[3] = $_POST['entrada'];
                             $XINFOCALDET[4] = date("Y-m-d", strtotime($_POST['salida1']));
                             $XINFOCALDET[5] = $estadores;
                             $XINFOCALDET[6] = $_POST['guestname'];
                             $XINFOCALDET[7] = $_POST['guestemail'];
                             $XINFOCALDET[8] = $_POST['guestphone'];
                             $XINFOCALDET[9] = $_POST['guestcountry'];
                             $XINFOCALDET[10] = $_POST['guestadult'];
                             $XINFOCALDET[11] = $_POST['guestchild'];
                             $XINFOCALDET[12] = $_POST['note_en'];
                             $XINFOCALDET[13] = (int)trim($_POST['totalreserva']);
                             $XINFOCALDET[14] = (int)trim($_POST['deposit']);
                             $XINFOCALDET[15] = (int)trim($_POST['balancedue']);
                             $XINFOCALDET[16] = "0";
                             $XINFOCALDET[17] = $_POST['cedula1'];
                             $XINFOCALDET[18] = $_POST['setid'];
                             $XINFOCALDET[19] = $idtercero;
                             $XINFOCALDET[20] = $numres;

                             $XRSCALENDAR=$XOBJRES->ingresar_calendardetails($XINFOCALDET);


                            $xi = 0;
                           $bookingdate =  date("Y-m-d", strtotime($_POST['entrada']));
                           $daypart = 2;
                           while ($xi < $numnoches)
                           {
                                  $XINFOCAL[0] = $bookingid;
                                  $XINFOCAL[1] = $daypart;
                                  $XINFOCAL[2] = $bookingdate;
                                  $XINFOCAL[3] = $estadores;
                                  $XRSCALENDAR=$XOBJRES->ingresar_calendardata($XINFOCAL);
                                  if ($daypart == 2)
                                  {
                                       $daypart = 1;
                                       $bookingdate = date("Y-m-d",strtotime($bookingdate."+ 1 days"));
                                       $xi++;
                                  }
                                  else
                                    $daypart = 2;

                           }
                           if ($xi == $numnoches)
                           {
                                  $XINFOCAL[0] = $bookingid;
                                  $XINFOCAL[1] = $daypart;
                                  $XINFOCAL[2] = $bookingdate;
                                  $XINFOCAL[3] = $estadores;
                                  $XRSCALENDAR=$XOBJRES->ingresar_calendardata($XINFOCAL);
                           }


                        
                 //}



                 }
                    // ahora si procedo insertar acompañanates y en posrestaaurnte
                    
                    if (isset($_POST['pro_docu']))
                  	   $contador = count($_POST['pro_docu']);
                    else
                       $contador = 0;
		            $ProContador=0;
		            $query = "INSERT INTO tbl_registro_huesped (setid, id_reserva, id_cliente, id_tercero) VALUES ";
        	        $querytercero = "INSERT INTO tbl_terceros (setid,id_tercero,nombres, numdoc, email,celular) VALUES ";
        	        $querycliente = "INSERT INTO tbl_clientes (setid, id_cliente, id_tercero,nombrecliente, numero_documento,
                    email, telefono, id_asesor, id_referidopor ) VALUES  ";


		            $queryValue = "";
	                $queryValueter = "";
                    $queryValuecli = "";
                    $queryValueposres = "";

		         for($i=0;$i<$contador;$i++) {

                   	if(!empty($_POST["pro_nom"][$i]) || !empty($_POST["pro_docu"][$i]) || !empty($_POST["pro_email"][$i])) {
                      $ProContador++;
                    // valida si ya selecciono un tercero sino se inserta
                        if (empty($_POST["pro_tercero"][$i]))   {
				    // busca secuencia para ingresar datos del tercero en la tabla tbl_tercero
                     $tablater = "tbl_terceros";
                     $campoter = "tbl_terceros.id_tercero";
                     $filtro = " tbl_terceros.setid = '".$setid."'";
                     $idterh =   FncBuscarseq($tablater,$campoter,$filtro);

                      // busca secuencia para ingresar datos del cliente en la tabla tbl_cliente
                      $tablacliente = "tbl_clientes";
                      $campocli = "tbl_clientes.id_cliente";
                      $filtro = " tbl_clientes.setid = '".$setid."'";
                      $idcli =   FncBuscarseq($tablacliente,$campocli,$filtro);

				    $queryValueter = "('". $setid."', '". $idterh."', '". $_POST["pro_nom"][$i] . "', '" .
                    $_POST["pro_docu"][$i] . "', '" . $_POST["pro_email"][$i] . "', '". $_POST['guestphone'] ."')";
                    $queryValuecli = "('". $setid."', '". $idcli ."', '". $idterh."', '". $_POST["pro_nom"][$i] . "', '" .
                    $_POST["pro_docu"][$i] . "', '" . $_POST["pro_email"][$i] . "', '". $_POST['guestphone'] . "', '". $_POST['asesorcom'] . "', '".
                    $_POST['referidopor'] ."')";
                    $queryValueposres = "('". $_POST["pro_nom"][$i] . "', '" . $_POST["pro_docu"][$i] . "', '" . $_POST["pro_email"][$i] . "', '". $_POST['guestphone']  ."')";


                    $sqlter = $querytercero.$queryValueter;
       	            $sqlcli = $querycliente.$queryValuecli;

                     // solo si se habilita punto de venta
                    //   $sqlposres = $queryposres.$queryValueposres;


                   // $resultadoconter = mysqli_query($conn, $sqlter);
                    //$resultadoconcli = mysqli_query($conn, $sqlcli);

                      $XRSTERSALE=$XOBJRES->ingresar_tercerosale($sqlter);
                     if((!isset($XRSTERSALE)) or ($XRSTERSALE == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación de la venta... ".$XRSTERSALE;
                      }

                        $XRSTERSALE=$XOBJRES->ingresar_tercerosale($sqlcli);
                     if((!isset($XRSTERSALE)) or ($XRSTERSALE == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación de la venta... ".$XRSTERSALE;
                      }

                    // solo si se habilita punto de venta
                   //  $resultadoposres = mysqli_query($conn, $sqlposres);

                    }
                      else
                      {
                       // busco el cliente
                            $idterh = $_POST["pro_tercero"][$i];
                             $setid = $setid;
          	                 $XRCLI=$XOBJRES->buscar_cliente($idterh,$setid);
	                          $XROWCLI=$XOBJRES->obtener_fila($XRCLI);
                              if (isset($XROWCLI[0]))
	                             $idcli =  $XROWCLI[0];
                              else
                                  $idcli = "";
                      }
                    
                    
                    // busco en registro acompanante
                     $XRregt=$XOBJRES->buscar_paxter($setid,$numres,$idterh);
                     $XROWregt=$XOBJRES->obtener_fila($XRregt);
                     if (!isset($XROWregt))
                     {
                          $queryValue = "('". $setid."', '".$numres. "', '". $idcli ."', '". $idterh."' ".")";
                   	      $sql = $query.$queryValue;
                    //$resultadocon = mysqli_query($conn, $sql);
                           $XRSTERSALE=$XOBJRES->ingresar_tercerosale($sql);
                             if((!isset($XRSTERSALE)) or ($XRSTERSALE == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación de la venta... ".$XRSTERSALE;
                                     }
                      }



			     }

		$sql = $query.$queryValue;
        $sqlter = $querytercero.$queryValueter;
       	$sqlcli = $querycliente.$queryValuecli;
         if($ProContador!=0) {
			if(!empty($resultadocon)) $mensaje = $mensaje ."
             <br>Registro(s) de Acompañante(s) Agregado Correctamente.";
  		}

       
       }
	
	   }

        else {
           $mensaje = "Fechas de Entrada y Salida, Cedula y Numero de Habitacion son obligatorios";
         }
}}}
}
}
         
          $disp = $disp . '
           <div class="row">
          <div class="detalle">
           <br>
              <br>
                 <label > Resultados de la actualizacion del Checkin </label>
                 Resultado: '.$mensaje.'
                 </div></div> ';
         /*  $disp = $disp . ' <li class="nav-item"><a class="nav-link" href="printcheckin.php?setid='.$setid.'&idreserva='.$idreserva.'
           ">  ';
           $flaqinsert = "1";
           $disp = $disp . 'IMPRIMIR CHECKIN </a></li>


           </div>      nav-link

         '; */
         if (!isset($idreserva))
           $idreserva="";
           if (isset($_POST['idreserva']))
           {
             $idreserva =  $_POST['idreserva'];
             $idreserva = "'".str_pad($idreserva, 5, "0", STR_PAD_LEFT)."'";
           }
          $disp = $disp . ' <center> <div class="detalle">
          <li class="btn-action"><a class="btn btn-primary" onclick="Prcprint('.$idreserva.')"> IMPRIMIR CHECKIN </a> </li> ';
           $flaqinsert = "1";
           $disp = $disp . '
           </div>  </center>';

        echo '     <div class="contenedor">
     <div id="result" > ';
        echo $disp;
     echo '    </div>';


} // finaliza grabar checkin al pulsar boton guardar
else // inicia todo el formulario para llenar datos del checkin
{

if (isset($_POST["pax"]))
  $pax1 =  $_POST["pax"];
else
      $pax1 = 0;


if (isset($_GET["reserva"]))
   $XNUMRES = $_GET["reserva"];
else
   if (isset($_POST["numres"]))
   $XNUMRES = $_POST["numres"];
   else
     $XNUMRES = "";
$numhab = "";
if (isset($_GET["numhab"]))
   $numhab = $_GET["numhab"];
$setid="001";
$asesor = "";
$idtercero1 = "";


$XROWRES = array("","","","","","","","","","","","","","","","","","","","");
if (empty($disp))
   $disp = "";

$XOBJRES=new greservas;
$XOBJRES1=new greservas;

	//INFORMACION DE PRE-RESERVAS
$XRSRES=$XOBJRES->buscar_checkin($setid,$XNUMRES);
$XROWRES=$XOBJRES->obtener_fila($XRSRES);
if (!isset( $fechareserva))
{
  if (isset($XROWRES[5]))
    $fechareserva = $XROWRES[5];
  else
    $fechareserva= date("yy-m-d");
}

$hoy = date("Y-m-d");

if ((isset($_POST["guestadult"])) && (isset($_POST["guestchild"])) )
{
   $adult = $_POST["guestadult"];
   $ninno = $_POST["guestchild"];
   $adult = (int)$adult;
   $ninno = (int)$ninno;
}
else
{
 $adult = (int)$XROWRES[7];
 $ninno = (int)$XROWRES[8];
 $pax1 = $adult + $ninno;
}

if (isset($_POST["entrada"]))
    $entrada = $_POST["entrada"];
else
   $entrada =  $XROWRES[9];


if (isset($_POST["salida1"]))
    $salida1 = $_POST["salida1"];
else
   $salida1 =  $XROWRES[10];
   
if (isset($_POST["cedula1"]) )
    $cedula =   $_POST["cedula1"];
  else
    $cedula = $XROWRES[1];

if (isset($_POST["guestname"]))
   $nombre =  $_POST["guestname"];
else
   $nombre =  trim($XROWRES[0]);
   
if (isset($_POST["guestemail"]))
   $email =  $_POST["guestemail"];
else
   $email =  trim($XROWRES[2]);
if (isset($_POST["guestphone"]))
   $telefono =  $_POST["guestphone"];
else
   $telefono =  trim($XROWRES[3]);
if (isset($_POST["guestcountry"]))
   $pais =  $_POST["guestcountry"];
else
   $pais =  trim($XROWRES[4]);
if (isset($_POST["noches"]))
   $noches =  $_POST["noches"];
else
   $noches =  $XROWRES[20];


if (isset($_POST["deposit"]) && ($_POST["deposit"] > 0) )
   $abono =  $_POST["deposit"];
else
   $abono =  $XROWRES[23];

$entrada = $XROWRES[9];
$salida1 = $XROWRES[10];
//$numnoches = restar_fechas($entrada , $salida1);
if (isset($_POST["totalreserva"]))
      $valorreserva =  $_POST["totalreserva"];
else
      $valorreserva = (int)$XROWRES[6];
if (isset($_POST["amount"]) && ($_POST["amount"] > 0) )
   $tarifa =  $_POST["amount"];
else
   $tarifa =  $valorreserva / $noches;


$impuesto = '0';


if (isset($_POST["note"]))
   $note =  $_POST["note"];
else
   $note =  trim($XROWRES[14]);
if (isset($_POST["desayuno"]))
   $desayuno =  $_POST["desayuno"];
else
   $desayuno =  trim($XROWRES[15]);
if (isset($_POST["parqueadero"]))
   $parqueadero =  $_POST["parqueadero"];
else
   $parqueadero =  trim($XROWRES[16]);
if (isset($_POST["tipovehiculo"]))
   $tipovehiculo =  $_POST["tipovehiculo"];
else
   $tipovehiculo =  trim($XROWRES[17]);
if (isset($_POST["placa"]))
   $placa =  $_POST["placa"];
else
   $placa =  trim($XROWRES[18]);
if (isset($_POST["idtipotarifa"]))
   $idtipotarifa =  $_POST["idtipotarifa"];
else
   $idtipotarifa =  trim($XROWRES[19]);
if (isset($_POST["referidopor"]))
   $referidopor =  trim($_POST["referidopor"]);
else
   $referidopor =  trim($XROWRES[21]);



   
?>

  <FORM name="frmProduct" method="post" action="checkinmodifica.php" id="checkin">

    <div class="mt-5">
    Fecha <?php $fechareserva ?> <h3> Detalles de la Reserva No. <?php echo $XNUMRES; ?> </h3>
    <label style="width:100%" for="status"> Estado Reserva </label>

<?php

  $estadores = "10"; // estado checkin
  $nomestado = "CHECKIN";
  echo $nomestado;

?>
        <div>
           <label for="entrada">Checkin</label>
           <input type="text" size=10 name="entrada" maxlength="12" id="datepicker1" value=" <?php echo $entrada;  ?>" >
             <label for="salida">Checkout</label>
            <input type="text" size=10 name="salida1" maxlength="12" id="datepicker2" value=" <?php echo $salida1;  ?>" >
        </div>

  <hr>

  <div class="viaje">
    <div >
           <label for="cedula"> Documento </label>
          <input class="search_query form-control" type="text" name="cedula1" id="key" value="<?php echo $cedula; ?>" autofocus /
          autocomplete="off" requerid>
       </div>
       <div >
          <label for="guestname"> Huesped </label>
          <input type="text" name="guestname" id="nombre" value="<?php echo $nombre; ?> " requerid>
       </div>
        <div>
          <label for="guestemail"> Email </label>
          <input type="text" name="guestemail" id="email" value="<?php echo $email; ?> " autofocus />
       </div>
       <div>
          <label for="guestphone"> Telefono </label>
          <input type="text" name="guestphone" id="telefono" value="<?php echo $telefono; ?>">
       </div>
       <div>
          <label for="guestcountry"> Pais </label>
          <input type="text" name="guestcountry" id="pais" value="<?php echo $pais; ?> ">
       </div>


  </div>
  <div class="viaje">
<?php
         // busco en la base de datos si hay esta cedula con autocompletar
?>

        <div>
          <label for="guestadult"> Adultos &nbsp;&nbsp; </label>
          <input type="text" name="guestadult"  id="adult" value="<?php echo $adult; ?>" onkeyup="numpax()" requerid>
       </div>
       <div>
          <label for="guestchild"> Menores &nbsp;&nbsp;</label>
          <input type="text" name="guestchild" id="ninno" value="<?php echo $ninno; ?>" onblur="cambianinno()" requerid>
       </div>
        <div>
                        <label for="eps">EPS:</label>
                        <input type="text" name="eps" id="eps" value=<?php $eps ?>  >
                    </div>
       <div>
                        <label for="referidopor">Canal</label>
                        <?php
                       /*     if ($XNUMRES != "") {
                                 $idasesor = $XROWRES[13];
                                 $XREFRESP=$XOBJRES->buscar_canal($setid,$idasesor);
                                 $referidoasesor = $XOBJRES->obtener_fila($XREFRESP);
                                 $referidopor = $referidoasesor[0];
                                 $asesor = $referidoasesor[1];
                            }
                            if (!isset($referidopor) or empty($referidopor))  {
                                    $referidopor = "";
                                    $asesor = "";
                            } */
                           echo '<SELECT name="referidopor">';

                              $XREFP=$XOBJRES->buscar_canal($setid,'');
                              while($XREFRES=$XOBJRES->obtener_fila($XREFP)){
                                   if($XREFRES[0] == $referidopor)
                                        echo '<option selected="selected" value="'.$XREFRES[0].'">'.$XREFRES[1].'"</option>';
                                   else
                                       echo  '<option value="'.$XREFRES[0].'">'.$XREFRES[1].'</option>';
                              }
                              echo '</select>';
                        ?>
                    </div>
                  <div>
                        <label for="asesor"> Asesor Comercial </label>
                            <?php
                                if (!isset($asesor) or ($asesor == ""))   {
                                    $asesor = "";
                                    echo '<SELECT name="asesorcom">';
                                    $XASESC=$XOBJRES->buscar_asesor("","");
                                    while($XASESRES=$XOBJRES->obtener_fila($XASESC)){
                                           if($XASESRES[3] == $asesor)
                                                echo '<option selected="selected" value="'.$XASESRES[3].'">'.$XASESRES[2].'"</option>';
                                           else
                                               echo '<option value="'.$XASESRES[3].'">'.$XASESRES[2].'</option>';
                                    }
                                     echo '</select>';
                                }
                                else {
                                     $XASESC=$XOBJRES->buscar_asesor($setid,$asesor);
                                     $XASESRES=$XOBJRES->obtener_fila($XASESC);
                                     echo ' <input type="text" readonly name="asesorcom" value="'. $XASESRES[3] .'">';
                                     echo '<span class="input-group-text">';
                                     echo $XASESRES[2];
                                     echo '</span>';
                                }
                            ?>
                    </div>

                </div>
                <div>

  </div>
       <div id="suggestions"> </div>
 </div>
 <div class="op-b">
            <div>
                <hr>
            <div class="referido">
                <div>

                   <div>
                       <div id="check_auto">
                       <?php
                       if ($desayuno == '1')
                          echo '<input type="checkbox" name="desayuno" value="1" checked> Desayuno';
                        else
                           echo ' <input type="checkbox" name="desayuno" value="1" checked> Desayuno';
                        if ($parqueadero == '1')
                           echo '<input type="checkbox" name="parqueadero" value="1" checked > Parqueadero';
                        else
                           echo '<input type="checkbox" name="parqueadero" value="1"  > Parqueadero';
                        ?>
                       </div>
                    <select name="tipovehiculo" id="">
                    <?php
                       switch($tipovehiculo) {
                         case "motocicleta";
                          echo '
                        <option value="">No asignado</option>
                        <option value="motocicleta" selected>Motocicleta</option>
                        <option value="automovil">Automovil</option>
                        <option value="Camioneta">Camioneta</option>
                        ';
                        break;
                          case "automovil";
                           echo '
                        <option value="">No asignado</option>
                        <option value="motocicleta">Motocicleta</option>
                        <option value="automovil" selected>Automovil</option>
                        <option value="Camioneta">Camioneta</option>
                        ';
                        break;
                          case "Camioneta";
                      echo '
                        <option value="">No asignado</option>
                        <option value="motocicleta">Motocicleta</option>
                        <option value="automovil">Automovil</option>
                        <option value="Camioneta" selected>Camioneta</option>
                        ';
                        break;
                        case "";
                             echo '
                        <option value="" selected>No asignado</option>
                        <option value="motocicleta">Motocicleta</option>
                        <option value="automovil">Automovil</option>
                        <option value="Camioneta">Camioneta</option>
                        ';
                      }
                      ?>

                    </select><br>
                    <input type="text" name="placa" value="<?php echo $placa; ?> " placeholder="Placa">
                    </div>

                </div>
                 <div>
                        <label for="company"> Notas </label>
                        <textarea name="note_en"  class="form-control" type="text" >
                        <?php echo $XROWRES[14] ?>
                        </textarea>
                    </div>
                       <div>
                           <label for="adjuntar archivos">Anexos:</label>
                        <input type="file" name="archivo1" id="archivo1" placeholder="Anexos" >
                       </div>
                <div>
                   <div>

                        <div id="tercero" class="tercero">
                        <label for="tercero"> Tercero / PAX / Noches </label>
                        <div><input type="text" name="tercero" id="idtercero" value = "<?php echo $idtercero1; ?> " maxlength="3" readonly >
                         <input type="text" name="pax" id="pax" value = "<?php echo $pax1; ?> " maxlength="3" readonly >
                         <input type="text" size=10 name="noches" maxlength="3" id="noches" value= "<?php echo $noches; ?>" readonly>
                           <input type="text" size=10 name="entrada2" maxlength="3" id="datepicker3" readonly>
                        </div>
                        <div>
                  </div>
                       </div>
                </div>
                    </div>

                </div>
            </div>

     <hr>
      <div class="mt-6">
      <h3 class="det-2" >Detalle de la Habitacion No. <?php echo $numhab; ?> </h3>

<?php
if (!isset($tiha))
 $tiha="";

   $tiha = $tiha . '
      <div class="input-group-text">
      <div class="radio">    ';
if ((isset($_POST["pax1"])) or (isset($pax1)))
{
      if (!isset($pax2))
       $pax2 = $pax1;
     $XHAB=$XOBJRES->buscar_habcalendar($pax2);
     while($XHABRES=$XOBJRES->obtener_fila($XHAB))
     {
        $idhab = $XHABRES[0];
          $countocupada = 0;
        $entrada1 = date("Y-m-d");
        $salida2 = strtotime ( '+'. $noches.' day' , strtotime ( $entrada1 ) ) ;
        $salida2 = date ( 'Y-m-d' , $salida2 );

         if($XHABRES[1] <> $numhab)
       {
           $rowocup =  $XOBJRES1->buscar_habocupada($idhab,$entrada1,$salida2);
           $countocupada = $XOBJRES1->obtener_fila($rowocup);
       }
        if (isset($countocupada[0]))
           $contador = $countocupada[0];
        else
           $contador = 0;
         if (!isset($contador) or ($contador == 0))
        {

       if($XHABRES[1] == $numhab)
       {
             $tiha= $tiha . ' <div><img src="'.$XHABRES[4].'">
         <div><input type="radio" name="habit" value="'.$XHABRES[0].'" checked requerid>'. $numhab .'</div>
         <br>
          <div class="tipo-h">Max Pax ' . $XHABRES[2] . '</div></div>';
       }
       else
       {
          $tiha = $tiha. '<div><img src="'. $XHABRES[4].'">
         <div><input type="radio" name="habit" value="'. $XHABRES[0] . '" requerid>'. $XHABRES[1] . '</div><br>
         <div class="tipo-h">Max Pax ' . $XHABRES[2] . '</div></div>';
       }
     }
     }
$tiha = $tiha .'
     </div>
    </div>
    <div class="viaje">
       <div>
         <label for="tipotarifa"> Tipo Tarifa </label>  ';

    $tipotarifa = "";
    $idtipotarifa =  $XROWRES[19];
    if (!isset($pax2))
       $pax2 = $pax1;
    $tiha = $tiha . '<SELECT name="tipotarifa" id="tipotarifa" onChange="tipotarifa(this.value)" >';
    $XTAR=$XOBJRES->buscar_tipotarifa($pax2,$hoy);
    while($XTARRES=$XOBJRES->obtener_fila($XTAR)){
       if ( $XTARRES[0] == $idtipotarifa)
            $tiha = $tiha . '<option value="'.$XTARRES[0].'-'.$XTARRES[2].'" selected>'.$XTARRES[1].'</option>';
       else
           $tiha = $tiha . '<option value="'.$XTARRES[0].'-'.$XTARRES[2].'">'.$XTARRES[1].'</option>';
    }
        $tiha = $tiha . '<option value=""> No asignado</option>';

    $tiha = $tiha . '</select>';
     // busco pagos y abonos

         $tablaregister = "zarest_registers";
          $camporegister = "zarest_registers.id";
          $filtro = " zarest_registers.status = '1' and store_id = '1'";
          $idregister =   FncBuscarseq1($tablaregister,$camporegister,$filtro);


           $tablacustom = "zarest_sales";
                $campocust = "zarest_sales.id";
                $filtro = " zarest_sales.checkinid = '".$XNUMRES."'";
                $idsale =   FncBuscarseq1($tablacustom,$campocust,$filtro);

        $XSUBABON=$XOBJRES1->buscar_sumpagos($idregister,$idsale);
        $XABONO=$XOBJRES1->obtener_fila($XSUBABON) ;
        if (isset($XABONO[0])) {
           $totabonos =  $XABONO[0];
           $totitemabono =  $XABONO[1];
        }
        else
        {
            $totabonos =  0;
            $totitemabono =  0;
        }
    $saldo = ($tarifa * $noches) - ($abono + $totabonos);
    if ($saldo < 0)
      $saldo = 0;

    $tiha = $tiha . '  </div>
    <div class="op-b">
       <label for="amount"> Tarifa </label>
       <span class="input-group-text"> $
       <input type="text" id="amount" name="amount" value=" '. $tarifa. '" maxlength="12" >   </span>
    </div>
    <div class="op-b">
        <label for="deposit"> Abono </label>
		<span class="input-group-text"> $
        <input type="text" name="deposit" id="deposit" value=" '. $abono . '" maxlength="12" >  </span>
    </div>
    <div class="op-b">
        <label for="balancedue"> Saldo </label>
	    <span class="input-group-text"> $
        <input type="text" name="balancedue" id="saldo" value=" '. $saldo .'" maxlength="12" >  </span>
    </div>
    <div class="op-b">
        <label for="total"> Total Reserva </label>
	    <span class="input-group-text"> $
        <input type="text" name="totalreserva" id="totalreserva" value=" '. $valorreserva .'" maxlength="12" >  </span>
    </div>
    <div class="op-b">
        <label for="impuestos"> Id Tarifa </label>
	    <span class="input-group-text">
        <input type="text" name="idtarifa1" id="idtarifa" value=" '. $idtipotarifa .'" maxlength="12" > </span>
    </div> ';

         $tiha = $tiha . ' <div class="op-b">
        <label for="abonos"> Total Abonos </label>
	    <span class="input-group-text">
        <input type="text" name="totabonos" id="totabonos" value=" '. $totabonos .'" maxlength="12" readonly> </span>
    </div> ';


    echo '  <div id="resp"> ' . $tiha. '</div>';
}
else
{
   echo "Por favor seleccionar minimo un adulto para identificar las habitaciones disponibles y las tarifas";
}

$setid="001";
$XRSPAX=$XOBJRES->buscar_pax($setid,$XNUMRES);
$XI=0;
while($XROWPAX=$XOBJRES->obtener_fila($XRSPAX)){
	$XNAMEPAX[$XI] = $XROWPAX[0];
	$CEDULAPAX[$XI] =  $XROWPAX[1];
	$EMAILPAX[$XI] = $XROWPAX[2];
    $IDTERCERO[$XI] = $XROWPAX[3];

	$XI++;
}

?>
 </div>
</div>
<div class="mt-5">
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
   <h3>Detalle de los Acompa&ntilde;antes </h3>

<div id="outer">
<div id="header">
<div class="float-left">&nbsp; Nro.</div>
<div class="float-left col-heading2"> Documento</div>
<div class="float-left col-heading"> Nombre</div>
<div class="float-left col-heading2"> Email</div>
<div class="float-left col-heading2"> EPS</div>
</div>
<div id="listhuesped">
<?php
       require_once("InputDinamicomodifica.php");
 ?>
</div>
<div id="suggestions2"> </div>


<div class="btn-action float-clear">
<input class="btn btn-success" type="button" name="agregar_registros" value="Agregar Mas" onClick="AgregarMas();" />
<input class="btn btn-danger" type="button" name="borrar_registros" value="Borrar Campos" onClick="BorrarRegistro();" />
<span class="success"><?php if(isset($resultado)) { echo $resultado; }?></span>
</div>

<div style="position: relative;">
<input class="btn btn-primary" type="submit" name="guardar" value="Guardar Ahora" />
</div>

</div>
</div>
<?php
 echo '<input type="hidden" name="setid" value="'.$setid.'">
       <input type="hidden" name="fechareserva" value=" '. $fechareserva.'">
       <input type="hidden" name="numhab" value=" '. $numhab .' ">
       <input type="hidden" name="numres" value=" '. $XNUMRES .' ">';
  echo '<input type="hidden" name="idtercero1" value=" '. $idtercero1 .' ">';
 echo '<input type="hidden" name="estadores" value=" '. $estadores .' ">';
  echo '<input type="hidden" name="pax1" value=" '. $pax1 .' ">';
   echo '<input type="hidden" name="idhab" value=" '. $idhab .' ">';
  //   echo '<input type="hidden" name="entrada" value=" '. $entrada .' ">';
     echo '<input type="hidden" name="idreserva" value=" '. $XNUMRES .' ">';
      echo '<input type="hidden" name="totalabonos" value=" '. $totabonos .' ">';
        echo '<input type="hidden" name="abonoanterior" value=" '. $abono .' ">';


?>

</form>

</div>
</div>
      <!-- Fin Contenido -->
    </div>
  </div>
  <!-- Fin row --> 

  
</div>

<?php
}
if (!isset($resp))
  $resp = "1";
?>

<?php
   echo "</div>";

?>

<!-- Fin container -->
<footer>
  
    <p>Deshida SAS <a href="https://deshida.com.co" target="_blank">Deshida SAS</a></p>
    
</footer>

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>
