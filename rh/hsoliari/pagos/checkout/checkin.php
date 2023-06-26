<?php


include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';

function FncBuscarseq($XSEQUENCIA,$parametro,$filtro) {
           $XSELECT = "select lpad(($parametro + 1),5,'0') from $XSEQUENCIA where $filtro order by $parametro desc limit 1";
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

	if(!empty($_POST["guardar"])) {

       $correcto = "";
       $setid = "001";


   if (($setid != "" ) && ( $_POST["entrada"] != "") && ($_POST['salida1'] != "") && $_POST["cedula1"] != "" && $_POST["cedula1"] != "0")
    {
        $flaq = 1;
       $secuencia="";
       $mens = "";
       $correcto = "true";
       $XOBJRES=new greservas;

       // si no hay reserva debo crear todo
       $idtercero1 = $_POST['idtercero1'];
        if (!isset($_POST['numres']) or ($_POST['numres'] == ""))
             $idtercero1 = "";
       // busco si selecciono un tercero
       $tercero = "";
       if (isset($_POST['tercero']))
          $tercero = trim($_POST['tercero']);
       if ( ($tercero != "") && ($tercero != "00001") && (!empty($tercero)) )
       {
          // busco el cliente
            $idtercero = $tercero;
          	$XRCLI=$XOBJRES->buscar_cliente($idtercero,$setid);
	        $XROWCLI=$XOBJRES->obtener_fila($XRCLI);
            if (isset($XROWCLI[0]))
	           $idcliente =  $XROWCLI[0];
            else
               $idcliente = "";
       }
       else
       {

       // ingresa datos del tercero en la tabla tbl_tercero
       $tablater = "tbl_terceros";
       $campoter = "tbl_terceros.id_tercero";
       $filtro = " tbl_terceros.setid = '".$setid."'";
       $idtercero =   FncBuscarseq($tablater,$campoter,$filtro);

       $XINFOTER[0] =  $setid;
       $XINFOTER[1] = $idtercero;
       $XINFOTER[2] = $_POST['cedula1'];
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

            $XINFOCLI[0] =  $setid;
            $XINFOCLI[1] = $idcliente;
            $XINFOCLI[2] = $idtercero;
            $XINFOCLI[3] = $_POST['asesorcom'];
            $XINFOCLI[4] = $_POST['referidopor'] ;
            $XINFOCLI[5] = $_POST['cedula1'] ;
            $XINFOCLI[6] =  $_POST['guestname'] ;
            $XINFOCLI[7] = $_POST['guestemail'] ;
            $XINFOCLI[8] = $_POST['guestphone'] ;
            $XINFOCLI[9] =  $_POST['guestcountry'] ;

            $XRSCLI=$XOBJRES->ingresar_cliente($XINFOCLI);
            if((!isset($XRSCLI)) or ($XRSCLI == FALSE)) {
              $correcto = "false";
              $mensaje = "Se ha presento error en la creación del Cliente... ".$XRSCLI;
            }
         }
        }

        if ($correcto == "true")
        {

              // INSERTA RESERVA
             $tablareserva = "tbl_reservas";
            $camporeserva = "tbl_reservas.id_reserva";
            $filtro = " tbl_reservas.setid = '".$setid."'";
            $idreserva =   FncBuscarseq($tablareserva,$camporeserva,$filtro);

            $numnoches = restar_fechas($_POST['entrada'] , $_POST['salida1']);
            if ($numnoches == 0)
               $numnoches = 1;
            $origen = "ERP";

            $XINFOPRE[0] = $setid;
            $XINFOPRE[1] = $idreserva;
            $XINFOPRE[2] = $idtercero;
            $XINFOPRE[3] = $_POST['fechareserva'];
            $XINFOPRE[4] = $numnoches;
	        $XINFOPRE[5] = $_POST['guestadult'];
	        $XINFOPRE[6] = $_POST['guestchild'];
	        $XINFOPRE[7] = "1";
	        $XINFOPRE[8] = $_POST['amount'];
            $XINFOPRE[9] = $_POST['estadores'];
	        $XINFOPRE[10] = $origen;
	        $XINFOPRE[11] = $_POST['deposit'];
            $XINFOPRE[12] = $idcliente;
            $XRSPRE=$XOBJRES->ingresar_prereserva($XINFOPRE);
	       if((!isset($XRSPRE)) or ($XRSPRE == FALSE)) {
              $correcto = "false";
              $mensaje = "Se ha presento error en la creación de la reserva... ".$XRSPRE;
            }
            else {
                 if (!isset($_POST['tipotarifa']))
                    $tipotarifa = "";
                 else
                    $tipotarifa = $_POST['tipotarifa'];
                 if (!isset($_POST['habit']))
                    $_POST['habit'] = "";

                // inserto el detalle de la reserva  en tbl_det_reserva
                 $XINFODETR[0] = $setid;
                 $XINFODETR[1] = $idreserva;
                 $XINFODETR[2] = $_POST['entrada'];
                 $XINFODETR[3] = $_POST['salida1'];
                 $XINFODETR[4] = $tipotarifa;
                 $XINFODETR[5] = $_POST['guestadult'];
                 $XINFODETR[6] = $_POST['guestchild'];
                 $XINFODETR[7] = "";
                 $XINFODETR[8] = $_POST['habit'];
                 $XINFODETR[9] = $_POST['estadores'];
                 $cantpers = $_POST['guestadult'] + $_POST['guestchild'];
                 $XINFODETR[10] = $cantpers;
                 $numhab1 = $_POST['habit'] . " " . $_POST['numhab'];

                 $XRSDETPRE=$XOBJRES->ingresar_detalle_prereserva($XINFODETR);
                  if((!isset($XRSDETPRE)) or ($XRSDETPRE == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación del detalle de la reserva... ".$XRSDETPRE;
                  }

                   // inserto el detalle del Abono en tbl_abonos_reservas
                 $XINFODETABONO[0] = $setid;
                 $XINFODETABONO[1] = $idreserva;
                 $tablaabono = "tbl_abonos_reservas";
                 $campoabono = "tbl_abonos_reservas.seq_abono";
                 $filtro = " tbl_abonos_reservas.setid = '".$_POST['setid']."' and tbl_abonos_reservas.id_reserva = '" . $idreserva . "'";
                 $seqabono =   FncBuscarseq($tablaabono,$campoabono,$filtro);

                 $XINFODETABONO[2] = $seqabono;
                 $XINFODETABONO[3] = $_POST['formapago'];
                 $XINFODETABONO[4] = $_POST['amount'];
                 $basepago = $_POST['deposit'] - $_POST['impuestos'];
                 $XINFODETABONO[5] = $basepago;
                 $XINFODETABONO[6] = $_POST['impuestos'];
                 $XINFODETABONO[7] = $idcliente;
                 $XINFODETABONO[8] = $idtercero;
                 $XINFODETABONO[9] = $_POST['balancedue'];
                 $XINFODETABONO[10] = $_POST['deposit'];

                 $XRSDETABONO=$XOBJRES->ingresar_detalle_abonos($XINFODETABONO);
                  if((!isset($XRSDETABONO)) or ($XRSDETABONO == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación del abono... ".$XRSDETABONO;
                  }

                     // inserto el detalle de la forma de pago del cliente
                 $tablaformapago = "tbl_forma_pago_cliente";
                 $campoformapago = "tbl_forma_pago_cliente.id_tipo_pago";
                 $filtro = " tbl_forma_pago_cliente.setid = '".$setid."' and tbl_forma_pago_cliente.id_tercero = '" . $idtercero . "'";
                 $idtipopago =   FncBuscarseq($tablaformapago,$campoformapago,$filtro);
                 if ((!isset($idtipopago)) or ($idtipopago == ""))
                    $idtipopago = "00001";
                 $XINFOFORMAPAGO[0] = $setid;
                 $XINFOFORMAPAGO[1] = $idtercero;
                 $XINFOFORMAPAGO[2] = $idtipopago;
                 $XINFOFORMAPAGO[3] = $idcliente;
                 $XINFOFORMAPAGO[4] = $_POST['numtarjeta'];
                 $XINFOFORMAPAGO[5] = $_POST['titular'];
                 $XINFOFORMAPAGO[6] = $_POST['mes'];
                 $XINFOFORMAPAGO[7] = $_POST['anno'];

                 $XRSFORMAPAGO=$XOBJRES->ingresar_forma_pago($XINFOFORMAPAGO);
                  if((!isset($XRSFORMAPAGO)) or ($XRSFORMAPAGO == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la creación de la forma de pago... ".$XRSFORMAPAGO;
                  }

                 $correcto = "true";
                 $mensaje =  "Se ha registrado el Huesped en la Habitacion(es) Correctamente No.Checkin: $idreserva
                  No. Habitacion: $numhab1 " . $mens ;

                 // Actualizo la reserva con los datos de cedula, abonos y estado de la reserva
                 if (isset($_POST['calendarreserva']))
                 {
                       $cedula = $_POST['cedula1'];
                       $estadores = $_POST['estadores'];
                       $setid = $setid;
                       $idhab = $_POST['habit'];
                       $calendarreserva = $_POST['calendarreserva'];
                       if ($_POST['saldo'] == 0)
                           $estadores="12";
                       else
                          if ($_POST['deposito'] > 0)
                              $estadores = "11";
                          else
                              $estadores = "10";

                      $XACTCALENDAR=$XOBJRES->actualiza_reserva($calendarreserva, $cedula, $estadores, $setid, $idtercero, $idhab);
                      if((!isset($XACTCALENDAR)) or ($XACTCALENDAR == FALSE)) {
	                              $correcto = "false";
                                    $mens = "Se ha presento error en la actualizacion de la reserva... ".$XACTCALENDAR;
                       }

                 }


		 // ingreso el acompañante en la tabla de tercero  y tabla clientes

                    $conn = mysqli_connect("localhost","root","", "hembajada");
                    
                     // inserto cliente en posrestaurante para consumo
                       $queryposres = "INSERT INTO zarest_customers (name, numdocu, email , phone ) VALUES  ";
                      $queryValueposres = "('". $_POST['guestname'] . "', '" . $_POST['cedula1']  . "', '"
                      . $_POST['guestemail'] . "', '". $_POST['guestphone']  ."')";
                      $sqlposres = $queryposres.$queryValueposres;
                       $resultadoposres = mysqli_query($conn, $sqlposres);

                    // ahora si procedo insertar acompañanates y en posrestaaurnte
                    
                  	$contador = count($_POST['pro_docu']);
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
       	            $sqlposres = $queryposres.$queryValueposres;


                    $resultadoconter = mysqli_query($conn, $sqlter);
                    $resultadoconcli = mysqli_query($conn, $sqlcli);
                     $resultadoposres = mysqli_query($conn, $sqlposres);

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
                    
                    
                    $queryValue = "('". $setid."', '".$idreserva. "', '". $idcli ."', '". $idterh."' ".")";
                   	$sql = $query.$queryValue;
                    $resultadocon = mysqli_query($conn, $sql);



			     }
		         }
		$sql = $query.$queryValue;
        $sqlter = $querytercero.$queryValueter;
       	$sqlcli = $querycliente.$queryValuecli;
         if($ProContador!=0) {
			if(!empty($resultadocon)) $mensaje = $mensaje ."
             <br>Registro(s) de Acompañante(s) Agregado Correctamente.";
             
          // ingreso al cliente en posrestaurante para que pueda hacer consumos

		}

       
       }
	
	   }
        }
        else {
           $mensaje = "Fechas de Entrada y Salida y Cedula son obligatorios";
         }
         
          $disp = '
           <div class="row">
          <div class="detalle">
           <br>
              <br>
                 <label > Se realiz&oacute; el Checkin del usuario </label>
                 Resultado: '.$mensaje.'
                 </div></div> ';

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
<link href="assets/css/style.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.1.1.js"></SCRIPT>
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
  $( function() {
    $( "#datepicker1" ).datepicker();
  } );

   $( function() {
    $( "#datepicker2" ).datepicker();
  } );

$.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: $(this).serialize(),
     success: function(data) {
        $('#result').text(data.disp);
      }
});

  </script>

 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="assets/css/stylesautocomplet.css">
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
</script>


</head>

<body>
<header> 
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">

   <div class="logo">
       <a href="index2.php"><img src="assets/images/logo.jpg" alt=""></a>
    </div>

      <div class="menu-a">
          <a href="buscar_reservas.php">Retornar</a>
      <a href="index2.php">Menu Principal</a>
      <a href="home.php">Disponibilidad de Habitaciones</a>
      </div>


  </nav>
</header>

<!-- Begin page content -->
<?php
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
	//INFORMACION DE PRE-RESERVAS
$XRSRES=$XOBJRES->buscar_prereservas($XNUMRES);
$XROWRES=$XOBJRES->obtener_fila($XRSRES);
if (!isset( $fechareserva))
{
  if (isset($XROWRES[7]))
    $fechareserva = $XROWRES[7];
  else
    $fechareserva= date("Y-m-d");
}



?>


  <FORM name="frmProduct" method="post" action="checkin.php">
    <div class="contenedor">
     <div id="result" >
<?php
   echo $disp;
?>
  </div>
    
    <div class="mt-5">
   Fecha <?php echo $XROWRES[7]; ?> <h3> Detalles de la Reserva No. <?php echo $XNUMRES; ?> </h3>
  <hr>

  <div class="viaje">
        <div>
           <label for="entrada">Fecha Entrada</label>
           <input name="entrada" type="text" size=10 id="datepicker1" value=' <?php echo $XROWRES[5]; ?> '>
        </div>
        <div>
            <label for="salida">Fecha Salida</label>
            <input type="text" size=10 name="salida1" maxlength="12" id="datepicker2" value=' <?php echo $XROWRES[6]; ?> '>
        </div>
        <div> <label style="width:100%" for="status"> Estado Reserva </label>
<?php
   $XRSRES1=$XOBJRES->buscar_estadoreserva();
	$XESTADORES=$XOBJRES->numero_filas($XRSRES1);
	echo '<SELECT name="estadores">';
	while($XROWRES1=$XOBJRES->obtener_fila($XRSRES1)){
       		  if($XROWRES1[0] == $statusid)
             {
                       echo '<option selected="selected" value="'.$XROWRES1[0].'">'.$XROWRES1[1].'"</option>';
             }
             else
             {
                       echo '<option value="'.$XROWRES1[0].'">'.$XROWRES1[1].'</option>';
            }
    }
    echo '</select>';
?>
       </div>
       <div>
          <label for="guestadult"> Adultos &nbsp;&nbsp; </label>
          <input type="number" name="guestadult"  placeholder=" <?php echo $XROWRES[15]; ?> " >
       </div>
       <div>
          <label for="guestchild"> Menores &nbsp;&nbsp;</label>
          <input type="number" name="guestchild" placeholder" <?php echo $XROWRES[16]; ?> " >
       </div>
  </div>
  <div class="viaje">
<?php
         // busco en la base de datos si hay esta cedula con autocompletar
?>
       <div >
          <label for="cedula"> Documento </label>
          <input class="search_query form-control" type="text" name="cedula1" id="key" value="<?php echo $XROWRES[22]; ?> ">
       </div>
       <div >
          <label for="guestname"> Huesped </label>
          <input type="text" name="guestname" id="nombre" value=" <?php echo $XROWRES[11]; ?> ">
       </div>
       <div>
          <label for="guestemail"> Email </label>
          <input type="text" name="guestemail" id="email" value=" <?php echo $XROWRES[12]; ?> ">
       </div>
       <div>
          <label for="guestphone"> Telefono </label>
          <input type="text" name="guestphone" id="telefono" value=" <?php echo $XROWRES[13]; ?>">
       </div>
       <div>
          <label for="guestcountry"> Pais </label>
          <input type="text" name="guestcountry" id="pais" value=" <?php echo $XROWRES[14]; ?> ">
       </div>
  </div>
  <div id="suggestions"> </div>
</div>

<div class="op-b">
   <div >
   <hr>
       <div class="referido">
         <div>
           <div>
                 <label for="referidopor"> Referido Por </label>
<?php
            if ($XNUMRES != "") {
                 $setid=$XROWRES[27];
                 $idtercero = $XROWRES[28];
                 $XREFRESP=$XOBJRES->buscar_referidoreserva($setid,$idtercero);
                 $referidoasesor = $XOBJRES->obtener_fila($XREFRESP);
                 $referidopor = $referidoasesor[0];
                 $asesor = $referidoasesor[1];
            }
                 if (!isset($referidopor) or empty($referidopor))  {
                    $referidopor = "";
                    $asesor = "";
                 }
           	        echo '<SELECT name="referidopor">';

              $XREFP=$XOBJRES->buscar_referidopor($XNUMRES);
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

         <div>
         <span class="input-group-text">
                <label for="tercero"> Tercero </label>
                <input type="text" name="tercero" id="idtercero" value = "<?php echo $idtercero1; ?> " readonly >
         </span>
         </div>
          </div>
          <div>
                <label for="adjuntar archivos">Anexos:</label>
                <input type="file" name="archivo1" id="archivo1" placeholder="Anexos" >
         </div>
          <div>
          <label for="company"> Notas </label>
             <textarea name="note_en" rows="4" class="form-control" type="text" style="height:60px;resize:none; width:70%">
             <?php echo $XROWRES[17] ?> </textarea>
          </div>
     </div>
     <hr>

     <div>
      <h3 >Detalle de la Habitacion No. <?php echo $numhab; ?> </h3>

      <div class="input-group-text">
      <div class="radio">
<?php
     $XHAB=$XOBJRES->buscar_habcalendar();
     while($XHABRES=$XOBJRES->obtener_fila($XHAB))
     {
       if($XHABRES[1] == $numhab)
         echo '<input type="radio" name="habit" value="'.$XHABRES[0].'" checked>'. $numhab;
       else
         echo '<input type="radio" name="habit" value="'. $XHABRES[0] . '">'. $XHABRES[1];
     }
?>
     </div>
    </div>
    <div class="viaje">
       <div>
         <label for="tipotarifa"> Tipo Tarifa </label>
<?php
    $tipotarifa = "";
    echo '<SELECT name="tipotarifa">';
    $XTAR=$XOBJRES->buscar_tipotarifa($numhab);
    while($XTARRES=$XOBJRES->obtener_fila($XTAR)){
      if($XTARRES[0] == $tipotarifa)
         echo '<option selected="selected" value="'.$XTARRES[0].'">'.$XTARRES[1].'"</option>';
      else
         echo '<option value="'.$XTARRES[0].'">'.$XTARRES[1].'</option>';
    }
    echo '</select>';
?>
    </div>
    <div class="op-b">
       <label for="amount"> Tarifa </label>
       <span class="input-group-text"> $
       <input type="text" name="amount" value=" <?php echo $XROWRES[18]; ?> " maxlength="12">   </span>
    </div>
    <div class="op-b">
        <label for="deposit"> Abono </label>
		<span class="input-group-text"> $
        <input type="text" name="deposit" value=" <?php echo $XROWRES[19]; ?>" maxlength="12">  </span>
    </div>
    <div class="op-b">
        <label for="balancedue"> Saldo </label>
	    <span class="input-group-text"> $
        <input type="text" name="balancedue" value=" <?php echo $XROWRES[20]; ?> " maxlength="12">  </span>
    </div>
    <div class="op-b">
        <label for="impuestos"> Impuestos </label>
	    <span class="input-group-text"> $
        <input type="text" name="impuestos" value=" <?php echo $XROWRES[21]; ?>" maxlength="12"> </span>
    </div>
  </div>
<div class="viaje">
   <div>
      <label for="tipopago"> Tipo de Pago </label>
<?php
   echo '<SELECT name="formapago">';
   $XRSRES2=$XOBJRES->buscar_formapago();
   while($XROWRES2=$XOBJRES->obtener_fila($XRSRES2))
   {
    if($XROWRES2[0] == $formapago)
     echo '<option selected="selected" value="'.$XROWRES2[0].'">'.$XROWRES2[1].'"</option>';
    else
     echo '<option value="'.$XROWRES2[0].'">'.$XROWRES2[1].'</option>';
   }
   echo '</select>';
?>
   </div>
   <div>
      <label for="numerotarjeta"> No. Tarjeta/Doc </label>
      <input type="text" name="numtarjeta" value=" <?php echo $XROWRES[23]; ?> ">
    </div>
    <div>
      <label for="titulartarjeta"> Titular </label>
      <input type="text" name="titular" value=" <?php echo $XROWRES[24]; ?> " >
    </div>
    <div>
      <label for="mestarjeta"> Mes Tarj </label>
      <input type="text" name="mes" value=" <?php echo $XROWRES[25]; ?> " >
    </div>
    <div>
       <label for="annotarjeta"> A&#241;o- </label>
       <input type="text" name="anno" value=" <?php echo $XROWRES[26]; ?> ">
    </div>
</div>
</div>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->

  <hr>
   <h3>Detalle de los Acompa&ntilde;antes </h3>
  <hr>

<div id="outer">
<div id="header">
<div class="float-left">&nbsp; Nro.</div>
<div class="float-left col-heading"> Documento</div>
<div class="float-left col-heading2"> Nombre</div>
<div class="float-left col-heading2"> Email</div>
</div>
<div id="suggestions2"> </div>
<div id="listhuesped">
<?php require_once("InputDinamico.php") ?>
</div>
<div class="btn-action float-clear">
<input class="btn btn-success" type="button" name="agregar_registros" value="Agregar Mas" onClick="AgregarMas();" />
<input class="btn btn-danger" type="button" name="borrar_registros" value="Borrar Campos" onClick="BorrarRegistro();" />
<span class="success"><?php if(isset($resultado)) { echo $resultado; }?></span>
</div>
<div style="position: relative;">
<input class="btn btn-primary" type="submit" name="guardar" value="Guardar Ahora" />
</div>

</div>
<?php
 echo '<input type="hidden" name="setid" value="'.$setid.'">
       <input type="hidden" name="fechareserva" value=" '. $fechareserva.'">
       <input type="hidden" name="numhab" value=" '. $numhab .' ">
       <input type="hidden" name="numres" value=" '. $XNUMRES .' ">';
  echo '<input type="hidden" name="idtercero1" value=" '. $idtercero1 .' ">';
?>

</form>

</div>
</div>
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 

  
</div>


<!-- Fin container -->
<footer class="footer">
  <div class="container"> <span class="text-muted">
    <p>Deshida SAS <a href="https://deshida.com.co" target="_blank">Deshida SAS</a></p>
    </span> </div>
</footer>

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>
