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
           $XSELECT = "select $parametro from $XSEQUENCIA order by $parametro desc limit 1";
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
                   var d1 = new Date();
                    var d2 = $('#datepicker2').datepicker('getDate');

                    var min =   d1.getHours()*60;
                    var seg =   d1.getSeconds()/60;
                    var min2 = min + d1.getMinutes() + seg;
                    d2.setMinutes(d2.getMinutes() + min2);
                    d2.setSeconds(d1.getSeconds());

                    if (d1 && d2) {
                        diff = Math.round((d2.getTime() - d1.getTime()) / 86400000); //ms per day
                      }
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
$entrada = $XROWRES[9];
$salida1 = $XROWRES[10];
//$numnoches = restar_fechas($entrada , $salida1);
if (isset($_POST["totalreserva"]))
      $valorreserva =  $_POST["totalreserva"];
else
      $valorreserva = (int)$XROWRES[6];
$tarifa = $valorreserva / $noches;
$abono =  '0';
$saldo = $tarifa;
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

  <FORM name="frmProduct" method="post" action="mostrar_checkout.php" id="mcheck">

    <div class="mt-5">
    Fecha <?php $fechareserva ?> <h3> Detalles de la Reserva No. <?php echo $XNUMRES; ?> </h3>
    <label style="width:100%" for="status"> Estado Reserva </label>

<?php

  $estadores = "13"; // estado checkin
  $nomestado = "CHECKOUT";
  echo $nomestado;

?>
        <div>
           <label for="entrada">Checkin</label>
           <?php echo $entrada; ?>
             <label for="salida">Checkout</label>
            <input type="text" size=10 name="salida1" maxlength="12" id="datepicker2" value=" <?php echo $salida1;  ?>" disabled>
        </div>

  <hr>

  <div class="viaje">
    <div >
           <label for="cedula"> Documento </label>
          <input class="search_query form-control" type="text" name="cedula1" id="key" value="<?php echo $cedula; ?>" autofocus /
          autocomplete="off" disabled>
       </div>
       <div >
          <label for="guestname"> Huesped </label>
          <input type="text" name="guestname" id="nombre" value="<?php echo $nombre; ?> " disabled>
       </div>
        <div>
          <label for="guestemail"> Email </label>
          <input type="text" name="guestemail" id="email" value="<?php echo $email; ?> " disabled />
       </div>
       <div>
          <label for="guestphone"> Telefono </label>
          <input type="text" name="guestphone" id="telefono" value="<?php echo $telefono; ?>" disabled>
       </div>
       <div>
          <label for="guestcountry"> Pais </label>
          <input type="text" name="guestcountry" id="pais" value="<?php echo $pais; ?> " disabled>
       </div>


  </div>
  <div class="viaje">
<?php
         // busco en la base de datos si hay esta cedula con autocompletar
?>

        <div>
          <label for="guestadult"> Adultos &nbsp;&nbsp; </label>
          <input type="text" name="guestadult"  id="adult" value="<?php echo $adult; ?>" onkeyup="numpax()" disabled>
       </div>
       <div>
          <label for="guestchild"> Menores &nbsp;&nbsp;</label>
          <input type="text" name="guestchild" id="ninno" value="<?php echo $ninno; ?>" onblur="cambianinno()" disabled>
       </div>
        <div>
                        <label for="eps">EPS:</label>
                        <input type="text" name="eps" id="eps" value=<?php $eps ?>  disabled>
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
                          echo '<input type="checkbox" name="desayuno" value="1" checked disabled> Desayuno';
                        else
                           echo ' <input type="checkbox" name="desayuno" value="1" checked disabled> Desayuno';
                        if ($parqueadero == '1')
                           echo '<input type="checkbox" name="parqueadero" value="1" checked disabled> Parqueadero';
                        else
                           echo '<input type="checkbox" name="parqueadero" value="1"  disabled> Parqueadero';
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
                    <input type="text" name="placa" value="<?php echo $placa; ?> " placeholder="Placa" disabled>
                    </div>

                </div>
                 <div>
                        <label for="company"> Notas </label>
                        <textarea name="note_en"  class="form-control" type="text" disabled>
                        <?php echo $XROWRES[14] ?>
                        </textarea>
                    </div>
                       <div>
                           <label for="adjuntar archivos">Anexos:</label>
                        <input type="file" name="archivo1" id="archivo1" placeholder="Anexos" disabled>
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
      <h3 class="det-2" >Habitacion Asignada No. <?php echo $numhab; ?> </h3>
<?php

    echo ' <div class="viaje">

    <div class="op-b">
       <label for="amount"> Tarifa </label>
       <span class="input-group-text"> $
       <input type="text" id="amount" name="amount" value=" '. $tarifa. '" maxlength="12" disabled>   </span>
    </div>
    <div class="op-b">
        <label for="deposit"> Abono </label>
		<span class="input-group-text"> $
        <input type="text" name="deposit" id="deposit" value="0" maxlength="12" disabled>  </span>
    </div>
    <div class="op-b">
        <label for="balancedue"> Saldo </label>
	    <span class="input-group-text"> $
        <input type="text" name="balancedue" id="saldo" value=" '. $tarifa .'" maxlength="12" disabled>  </span>
    </div>
    <div class="op-b">
        <label for="total"> Total Reserva </label>
	    <span class="input-group-text"> $
        <input type="text" name="totalreserva" id="totalreserva" value=" '. $valorreserva .'" maxlength="12" disabled>  </span>
    </div>
    <div class="op-b">
        <label for="impuestos"> Id Tarifa </label>
	    <span class="input-group-text">
        <input type="text" name="idtarifa1" id="idtarifa" value=" '. $idtipotarifa .'" maxlength="12" disabled> </span>
    </div> ';

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
       require_once("InputDinamicomuestra.php");
 ?>
</div>
<div id="suggestions2"> </div>


<div class="btn-action float-clear">
<span class="success"><?php if(isset($resultado)) { echo $resultado; }?></span>
</div>

<div style="position: relative;">
</div>

</div>
</div>
</div>
<div class="mt-5">
  <div class="row">
    <div class="col-12 col-md-12">
      <!-- Contenido -->
   <h3>Detalle de los Cargos Facturados y Abonos </h3>


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
 //  echo '<input type="hidden" name="idhab" value=" '. $idhab .' ">';
     echo '<input type="hidden" name="entrada" value=" '. $entrada .' ">';
     echo '<input type="hidden" name="idreserva" value=" '. $XNUMRES .' ">';


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
