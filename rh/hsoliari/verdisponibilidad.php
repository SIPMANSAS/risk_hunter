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
           $XSELECT = "select $parametro from $XSEQUENCIA where $filtro order by $parametro desc limit 1";
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
                      $('#datepicker3').val(d2);
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
     var dt2 = $('#datepicker2').val();
     var url = "verdisponibilidad.php";
     $.ajax({
           type: "POST",
           url: url,
           data: $("#checkin").serialize(),
           success: function(data) {
               $('#resp1').fadeOut(1000);
               $('#resp').html(data);
                $("#eps").focus();
                 $('#datepicker3').val(dt2);

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
     <?php
  // busco numero de habitaciones ocupadas
               $hoy = date('Y-m-d');
     	       $XOBJRES=new greservas;
               $XNUMOCU=$XOBJRES->buscar_ocupadas($hoy);
               $XOCUP = $XOBJRES->obtener_fila($XNUMOCU);
               $OCUPADA = $XOCUP[0];
               echo '
                 <div class="ocupado">
                 <span>habitaciones ocupadas</span> <br>
                 <span>'. $OCUPADA. ' de 42</span>
                 </div>';
?>

     <div class="contenedor">

<?php
if (empty($disp))
   $disp = "";


// inicia a grabar checkin  cuando se ha pulsado guardar


if (isset($_POST["pax"]))
  $pax1 =  $_POST["pax"];
else
      $pax1 = 0;


$XNUMRES="";
if (isset($_GET["reserva"]))
   $XNUMRES = $_GET["reserva"];
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
$XRSRES=$XOBJRES->buscar_prereservas($XNUMRES);
$XROWRES=$XOBJRES->obtener_fila($XRSRES);
if (!isset( $fechareserva))
{
  if (isset($XROWRES[7]))
    $fechareserva = $XROWRES[7];
  else
    $fechareserva= date("yy-m-d");
}

$tarifa = (int)$XROWRES[18];
$abono = (int)$XROWRES[19];
$saldo = (int)$XROWRES[20];
$impuesto = (int)$XROWRES[21];
date_default_timezone_set('America/Bogota');

$hoy = date("Y-m-d H:i:s");

if ((isset($_POST["guestadult"])) && (isset($_POST["guestchild"])) )
{
   $adult = $_POST["guestadult"];
   $ninno = $_POST["guestchild"];
   $adult = (int)$adult;
   $ninno = (int)$ninno;
}
else
{
 $adult = (int)$XROWRES[15];
 $ninno = (int)$XROWRES[16];
 $pax1 = $adult + $ninno;
}

if (isset($_POST["entrada"]))
    $entrada = $_POST["entrada"];
else
   $entrada =  $hoy;
if (isset($_POST["salida1"]))
    $hoydia = $_POST["salida1"];
else
  if (isset($XROWRES[6]))
   $hoydia =  $XROWRES[6];
  else
    $hoydia = date("Y-m-d");
   
if (isset($_POST["cedula1"]) )
    $cedula =   $_POST["cedula1"];
  else
    $cedula = "";

if (isset($_POST["guestname"]))
   $nombre =  $_POST["guestname"];
else
   $nombre =  trim($XROWRES[11]);
   
if (isset($_POST["guestemail"]))
   $email =  $_POST["guestemail"];
else
   $email =  trim($XROWRES[12]);
if (isset($_POST["guestphone"]))
   $telefono =  $_POST["guestphone"];
else
   $telefono =  trim($XROWRES[13]);
if (isset($_POST["guestcountry"]))
   $pais =  $_POST["guestcountry"];
else
   $pais =  trim($XROWRES[14]);
if (isset($_POST["noches"]))
   $noches =  $_POST["noches"];
else
   $noches =  "1";
if (isset($_POST["referidopor"]))
   $referidopor =  $_POST["referidopor"];
else
   $referidopor =  "";
if (isset($_POST["eps"]))
   $eps =  $_POST["eps"];
else
   $eps =  "";
if (isset($_POST["placa"]))
   $placa =  $_POST["placa"];
else
   $placa =  "";


   
?>

  <FORM name="frmProduct" method="post" action="verdisponibilidad.php" id="checkin">

    <div class="mt-5">
    <h3> Detalles de la Reserva No. <?php  $XNUMRES ?> </h3>
    <label style="width:100%" for="status"> Estado Reserva
<?php

  $estadores = "10"; // estado checkin
  $nomestado = "CHECKIN";
  echo $nomestado;

?>
  </label>
  <div>
           <label for="entrada">Checkin</label>
            <?php echo $hoy; ?>
           <label for="entrada">Checkout</label>
           <input name="salida1" type="text" size=10 id="datepicker2" value="<?php echo $hoydia; ?>"

 </div>
  <div class="viaje">
<?php
         // busco en la base de datos si hay esta cedula con autocompletar
?>
     <div>
          <label for="guestadult"> Adultos &nbsp;&nbsp; </label>
          <input type="text" name="guestadult"  id="adult" value="<?php echo $adult; ?>" onkeyup="numpax()" required>
       </div>
       <div>
          <label for="guestchild"> Menores &nbsp;&nbsp;</label>
          <input type="text" name="guestchild" id="ninno" value="<?php echo $ninno; ?>" onblur="cambianinno()" required >
       </div>
  </div>
  </div>
 </div>
 <div class="op-b">
            <div>

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
     $XHAB=$XOBJRES->buscar_habcalendar1($pax2);
     while($XHABRES=$XOBJRES->obtener_fila($XHAB))
     {
        $idhab = $XHABRES[0];
        $countocupada = 0;
        $entrada1 = date("Y-m-d");
        $salida2 = strtotime ( '+'. $noches.' day' , strtotime ( $entrada1 ) ) ;
        $salida2 = date ( 'Y-m-d' , $salida2 );

        $rowocup =  $XOBJRES1->buscar_habocupada($idhab,$entrada1,$salida2);
        $countocupada = $XOBJRES1->obtener_fila($rowocup);
        if (isset($countocupada[0]))
           $contador = $countocupada[0];
        else
           $contador = 0;
         if (!isset($contador) or ($contador == 0))
        {
           if($XHABRES[1] == $numhab)
           {
             $tiha= $tiha . ' <div><img src="'.$XHABRES[4].'">
         <div><input type="radio"  id="habit" name="habit" value="'.$XHABRES[0].'" checked required>'. $numhab .'</div>
          <div class="tipo-h">Max Pax ' . $XHABRES[2] . $disponibilidad. '</div>
           </div>';
           }
           else
           {
               $tiha = $tiha. '<div><img src="'. $XHABRES[4].'">
               <div><input type="radio" id="habit" name="habit" value="'. $XHABRES[0] . '" required>'. $XHABRES[1] . '</div>
               <div class="tipo-h">Max Pax ' . $XHABRES[2] .'</div></div>';
           }
         }
      }
$tiha = $tiha .'
     </div>
    </div>
   ';
   echo '  <div id="resp"> ' . $tiha. '</div>';
?>
       <hr>
            <div class="referido">
                  <div>
                     <div id="tercero" class="tercero">
                        <label for="tercero"> Tercero / PAX / Noches </label>
                        <div><input type="text" name="tercero" id="idtercero" value = "<?php echo $idtercero1; ?> " maxlength="3" readonly >
                         <input type="text" name="pax" id="pax" value = "<?php echo $pax1; ?> " maxlength="3" readonly >
                         <input type="text" size=10 name="noches" maxlength="3" id="noches" value= "<?php echo $noches; ?>" readonly>
                           <input type="text" size=10 name="entrada2" maxlength="3" id="datepicker3" readonly>
                        </div>
                       </div>

                </div>
            </div>
<?php
}
else
{
   echo "Por favor seleccionar minimo un adulto para identificar las habitaciones disponibles y las tarifas";
}
?>
 </div>
</div>

<?php
if (!isset($idhab))
  $idhab="";
 echo '<input type="hidden" name="setid" value="'.$setid.'">
       <input type="hidden" name="fechareserva" value=" '. $fechareserva.'">
       <input type="hidden" name="numhab" value=" '. $numhab .' ">
       <input type="hidden" name="numres" value=" '. $XNUMRES .' ">';
  echo '<input type="hidden" name="idtercero1" value=" '. $idtercero1 .' ">';
 echo '<input type="hidden" name="estadores" value=" '. $estadores .' ">';
  echo '<input type="hidden" name="pax1" value=" '. $pax1 .' ">';
   echo '<input type="hidden" name="idhab" value=" '. $idhab .' ">';
   echo '<input type="hidden" name="fechacheckin" value=" '. $hoy .' ">';
   echo '<input type="hidden" name="entrada" value=" '. $hoy .' ">';


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
