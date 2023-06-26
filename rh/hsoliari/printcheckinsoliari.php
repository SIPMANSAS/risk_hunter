<?php
include_once 'classes/greservas.class.php';
include_once 'assets/funciones.php';

session_start();
if (isset($_SESSION['username'])) {
        //asignar a variable
        $usernameSesion = $_SESSION['username'];
        //asegurar que no tenga "", <, > o &
        $username = htmlspecialchars($usernameSesion);
}
else
$username="";

if (isset($_GET['setid']))
    $SETID = $_GET['setid'];
else
   $SETID = '001';
if (isset($_GET['idreserva']))
   $XNUMRES = trim($_GET['idreserva']);
else
    $XNUMRES = '00001';
$XOBJRES=new greservas;
	//INFORMACION DE PRE-RESERVAS

$XRSRES=$XOBJRES->buscar_checkin($SETID,$XNUMRES);
$XROWCLI=$XOBJRES->obtener_fila($XRSRES);
if (isset($XROWCLI[0])) {
    $huesped =  $XROWCLI[0];
    $cedula = $XROWCLI[1];
    $email = $XROWCLI[2];
    $celular = $XROWCLI[3];
    $pais = $XROWCLI[4];
    $fecha_reserva = $XROWCLI[22];
    $valor = $XROWCLI[6];
    $adultos = $XROWCLI[7];
    $menores = $XROWCLI[8];
    $checkin = $XROWCLI[9];
    $checkout = $XROWCLI[10];
    $numhab = $XROWCLI[11];
    $fechacheckin =  $XROWCLI[12];
    $anno = date("Y", strtotime($checkin));
    $canal = $XROWCLI[21];
    $noches =  $XROWCLI[20];
    $tipovehiculo = $XROWCLI[17];
    $placa = $XROWCLI[18];
    $horares = date("H:i", strtotime($checkin));

    
}

$XRSPAX=$XOBJRES->buscar_pax($SETID,$XNUMRES);
$XI=0;
while($XROWPAX=$XOBJRES->obtener_fila($XRSPAX)){
	$XNAMEPAX[$XI] = $XROWPAX[0];
	$CEDULAPAX[$XI] =  $XROWPAX[1];
	$XI++;
}

//$XRSAB=$XOBJRES->buscar_abono($SETID,$XNUMRES);
//$XABONOI=0;
//while($XROWAB=$XOBJRES->obtener_fila($XRSAB)){
//	$XABONO[$XABONOI] = $XROWAB[0];
//	$XSALDO[$XABONOI] =  $XROWAB[1];
//	$XABONOI++;
//}

if (!isset($canal))
  $canal = "";

$XRCANAL = $XOBJRES->buscar_canal($SETID,$canal);
$XRROW = $XOBJRES->obtener_fila($XRCANAL);
$nomcanal = $XRROW[1];


?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="assets/css/app.css">
    <link href="assets/css/print.css" rel="stylesheet" media="all">
    <title>|Impresion||Check-in|</title>
    <link rel="stylesheet" href="assets/css/printcheckinsoliari.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
</head>
<body>   
   <div class="datos">
   <a class="float-right printbutton" href="javascript:window.print();"><span class="glyphicon glyphicon-print"></span>
   </a>
   </div>
   <hr>
    <header>
       <div class="encabezado">
           <div class="logo">
               <img src="assets/images/logo-soliari.png" alt="">
               <div><h1>hotel soliari</h1> <h2>70682</h2></div>
           </div>
           <div class="registro">
               <h1>tarjeta de registro hotelero</h1>
               <div><span>No Registro | Registry Num#</span><input type="text" value="<?php echo $anno."-". $XNUMRES ?>"></div>
           </div>
       </div>
       <div class="datos">
           <div class="nombres"><span>Nombres y Apellidos | Name</span><input type="text" value="<?php echo $huesped; ?>"></div>
           <div class="ciudad"><span>Procedencia | City</span><input type="text" value="<?php echo $pais; ?>"><span> Empresa | Work </span><input type="text"></div>
           <div class="docs"><span>Tipo y N° de Doc. | Passport#</span><input type="text" value="<?php echo $cedula; ?>"><span>Desay | Breakfast</span><input type="text"></div>
           <div class="canal"><span>Canal</span><input type="text" value="<?php echo $nomcanal; ?>"><span>Celular | CellPho</span><input type="text" value=<?php echo $celular; ?>"></div>
           <div class="vehiculo"><span>Tipo Vehiculo | Type Brand</span><input type="text" value="<?php echo $tipovehiculo ?>"><span>Color | Color</span><input type="text"><span>Placa | License</span><input type="text" value="<?php echo $placa; ?>"></div>
           <div class="nota"><span>El horario Check-In según disponibilidad del hotel| Horario Check-Out es hasta las 2:00 PM -VER CONTRATO HOTELERO (abajo)</span></div>
       </div>
       <div class="horario">
           <div class="check-in">
               <span>Check-IN</span>
               <input type="text" value="<?php echo $checkin; ?>"><span>TarifaXN</span><input type="text" value="<?php echo $valor; ?>"><span>Hora Entrada</span><input type="text" value="<?php echo $horares; ?>">
            </div>
           <div class="check-out">
               <span>Check-OUT</span>
               <input type="text" value="<?php echo $checkout;?>">
               <div class="noches">
                   <span># Noches</span>
               <input type="text" width="20px" value="<?php echo $noches; ?>">
               <span>Hab</span>
               <input type="text" value="<?php echo $numhab; ?>">
               </div>
                <span>Personas HAB</span>
                <input type="text" value="<?php echo $adultos; ?> Adultos <?php echo $menores; ?> Menores ">
           </div>
       </div>
         <?php
      $YX = 0;
      WHILE ($YX < $XI)
      {
          echo '     <div class="compa"><span>ACC | Nombre y Apellidos</span>
          <input type="text" class="a-nombre" value="'. $XNAMEPAX[$YX].'" ><span>DNI</span><input type="text"  class="nacimiento"
          value="'. $CEDULAPAX[$YX].'"><span>F Nacimiento | Date of Bird</span><input type="text" class="dni">
          </div>';
          $YX++;
      }
      ?>
      </div>
   </header>
   <div class="contenedor">
        <p>CONTRATO DE SERVICIOS DE ALOJAMIENTO: A. OBJETO. De acuerdo con las siguientes cláusulas se establece el contrato entre el establecimiento HOTEL SOLIARI, en adelante H quien le prestará alojamiento al
HUESPED en la habitación y sus accesorios, a cambio de un precio, por el número de días indicados en la Tarjeta de Registro Hotelero. En ningún caso el término podrá ser superior a 15 días consecutivos. B. La
habitación será la que se indique en la Tarjeta de Registro Hotelero. El H podrá efectuar un cambio de habitación si el huésped acepta y se trata de una habitación de iguales o mejores condiciones, o ante una situación
de caso fortuito o fuerza mayor. C. La hora de ingreso o check in es partir de las 3:00 pm del día de llegada y la hora de salida o check Out es hasta las 2:00 pm del día de salida. El periodo de tiempo comprendido entre
una y otra hora corresponde al dia a hotelero. El ingreso anticipado o la salida con posterioridad a la hora indicada estará sujeta a disponibilidad y el HUESPED deberá pagar el valor correspondiente. La mera tolerancia
del H en la entrega de una habitación no genera cargos adicionales, el Late Check Out a solicitud del cliente tendrá el costo pertinente. C. El alojamiento se prestará independientemente del tiempo que permanezca el
HUESPED en la habitación. El uso parcial causa el pago de la tarifa plena. D. La prestación de los servicios objeto del contrato y de aquellos complementarios que ofrezca el H estará sujeta a disponibilidad y a los
horarios, turnos o existencias físicas de los insumos, bienes, facilidades o espacios para ella. La habitación y el precio o tarifa por noche será la que se indique en la Tarjeta de Registro Hotelero y que corresponde a la
reserva. E. El precio del presente contrato corresponde al canon por noche que el HUESPED se obliga a pagar y que asciende a la suma que se indica en la Tarjeta de Registro Hotelero y corresponde a la reserva
efectuada, todo lo cual se describirá en la factura correspondiente a solicitud del cliente, salvo que la reserva se haya realizado y pagado a través de una agencia de viajes, en cuyo caso la tarifa será la que se haya
acordado directamente con la agencia. F. El HUESPED deberá pagar también todos los cargos por concepto de bar, alimentos, bebidas y en general por todos aquellos que se generen durante su estadía y que decida
cargar a su cuenta. G. El HUESPED declara que ha sido informado de las tarifas, cánones y en general precios de las habitaciones por noche. H. El incumplimiento del pago acordado generará a cargo del HUESPED
intereses de mora a la tasa máxima permitida. I. Los objetos de valor como joyas, cámaras, dinero, computadores, celulares, equipos o utensilios que permanezcan en la habitación o áreas de servicios, estarán bajo el
único riesgo del HUESPED ya que en este caso el H no asume responsabilidad alguna, en caso de pérdida o deterioro. OBLIGACIONES DEL HOTEL. a. Prestar el servicio objeto del contrato. b. Atender, recibir, tramitar
y responder las sugerencias, quejas o reclamos presentados por el huésped. c. Las demás establecidas a su cargo en la Ley. OBLIGACIONES DEL HUESPED: a. Identificarse para registrarse en el H con documento de
identidad idóneo, presentando su cédula de ciudadanía en caso de ser colombiano o su pasaporte o documento aplicable tratándose de extranjeros. Para menores de edad, deberá presentarse documento de
identificación válido. b. Pagar el valor del hospedaje más los impuestos correspondientes. c. Pagar el valor de todos los consumos y cargos que haya hecho a su cuenta. d. Observar una conducta decorosa y vestir de
manera apropiada. d. Responder hasta la culpa leve de sus obligaciones y las de sus acompañantes o invitados. e. Registrar enla recepción del H a todos los acompañantes o invitados del HUESPED que se dirijan a su
habitación y pagar el canon o valor correspondiente por cada uno de ellos. f. Respetar el número de personas por habitación. g. Utilizar los muebles, enseres, equipos y en general las facilidades tanto de la habitación
como del H, de manera adecuada conservándolas en el estado en que se encuentren y por tanto responderá por cualquier daño o pérdida de los elementos y bienes del H, hasta por la culpa leve. En caso de pérdida o
daño total o parcial de los bienes del H por causa atribuible al HUÉSPED o a sus acompañantes, el HUÉSPED deberá pagar el precio correspondiente a su reparación o reposición, según el caso. h. Respetar la autoridad
del Gerente del H. i. Permitir el derecho de inspección y/o vigilancia a la habitación por parte de funcionarios del H. Este derecho se ejercerá de manera razonable e incluye la facultad de penetrar o registrar la habitación
cuando a juicio del Gerente del H cuando sea preciso. j. Permitir a los empleados y funcionarios del H el acceso para labores de rutina y limpieza de la habitación. k. TERMINACIÓN DEL CONTRATO. El contrato de
hospedaje terminará en los siguientes eventos: i. por vencimiento del plazo pactado. ii. Por incumplimiento de cualquiera de las obligaciones a cargo de las partes y puntualmente por el incumplimiento del pago del precio
o canon a cargo del HUÉSPED o por del pago de los alimentos y bebidas o demás servicios complementarlos que el HUESPED cargado a la habitación o a su cuenta personal. iii. En los eventos en que, a juicio exclusivo
del H o la indumentaria del HUESPEO atente contra la tranquilidad y/o salubridad de los demás huéspedes o de los visitantes del H. iv. Por fumar en la habitación o en cualquier otro espacio libre de humo del H, cuando
se afecten otros huéspedes, visitantes o usuarios y sin perjuicio del pago deberá hacer en los términos que se establecen más adelante. PARÁGRAFO: la terminación del contrato no exonera ni libera al HUESPED del
pago de los saldos pendientes. EFECTOS DE TERMINACION. i. A la terminación del contrato el H podrá disponer libremente de la habitación. ii. A la terminación del contrato y con independencia de la causa de
terminación, el H queda facultado para ingresar a la habitación, elaborar y suscribir un inventario de los efectos y equipaje del huésped y retirarlos de la habitación para dejarlos en depósito seguro y adecuado, sin
responsabilidad del H y por cuenta y riesgo del HUESPED. iii. Si el HUESPED no pagara la cuenta o parte de ella, el H puede disponer y vender el equipaje y objetos del HUESPED en los términos del artículo 1199 del
Código de Comercio, para cubrir con su producto las obligaciones pendientes. El excedente si lo hubiere, será puesto a disposición del HUESPED. En caso de déficit, el H podrá iniciar las acciones correspondientes para
conseguir el pago total de la suma adeudada. VARIAS DISPOSICIONES. i. Naturaleza jurídica del contrato. De conformidad con el artículo 9 de la ley 300 de 1.996, el contrato de hospedaje es un contrato de
arrendamiento de carácter comercial y de adhesión. ii. El contrato de hospedaje se prueba mediante la tarjeta de registro hotelero que el H expide, aceptada por la firma del HUESPED, la cual hace constar que éste se
adhiere a estipulaciones aquí contempladas. EL HUESPED acepta expresamente que la suma líquida de dinero que conste en la Tarjeta de Registro, prestará mérito ejecutivo. iii. El H rechaza y no permite la explotación
sexual ni cualquier forma de abuso sexual. El H rechaza y no permite el turismo sexual ni permite la explotación ni el abuso sexual de niñas, niños ni adolecentes. El no podrá ingresar a su habitación menores de
dieciocho (18) años de edad para el turismo sexual y quien lo haga incurrirá en pena de prisión conforme la ley. iv. Cargos por fumar en las habitaciones. Siendo consecuentes con el cuidado del medio ambiente y la
salud, todas las habitaciones y en general todas las áreas del H son libres de humo. Fumar en la habitación o en cualquier otro espacio del H constituye un incumplimiento grave del contrato de hospedaje que da lugar a
su terminación y podrá ser retirado del H si ha afectado a otros huéspedes, visitantes o usuarios. Si el HUESPED fuma en la habitación, por cada día que lo haga deberá pagar (i) el costo en el que debe incurrir el H para
desodorizar y limpiar la habitación, que se estima en una suma equivalente a USD 100, liquidados a la tasa representativa del mercado del día del pago, y (ii) el valor de (2) noches a la tarifa correspondiente a su
alojamiento, cono quiera que el proceso de limpieza y desodorización implica que el H no pueda utilizar la habitación durante las siguientes dos (2) noches. Si fuma en cualquier área del H distinta de la habitación, deberá
pagar el costo en que debe incurrir el H para desodorizar y 1 implar el área en la que haya fumado, que equivale a US 100, liquidados a la tasa representativa del mercado del día del pago. | | AUTORIZACIÓN USO DE
DATOS E INFORMACIÓN. Al suscribir el presente contrato el HUÉSPED autoriza expresamente a HOTEL SOLIARI con NIT 7314241-2, para recolectar y utilizar la información y los datos personales suministrados por el
HUÉSPED en la Tarjeta de Registro Hotelero tales como nombre, dirección, identificación, nacionalidad, fecha de nacimiento, dirección de correo electrónico, número de teléfono fijo y o celular, de conformidad con, las
políticas de tratamiento seguro de la información establecidas por el propio H y por las leyes vigentes con el propósito de realizar actividades de fidelización y contactar al titular de la información para enviarle encuestas
de servicios luego de cada estadía que permitan la calificación del servicio prestado, y comunicarle las invitaciones, ofertas, promociones, portafolio de servicios o información general que este dirigida a que siga haciendo
uso del H y a ofrecerle los servicios correspondientes. El HUÉSPED autoriza que la información sea transferida, transmitida, compartida y suministrada exclusivamente para los propósitos descritos previamente. EI
HUESPED en su condición de titular de los datos personales, gozará de todos los derechos de ley, de los expresamente descritos en el artículo 80 de la Ley 1581 de 2012 y en particular tendrá derecho en todo momento
a conocer, acceder, actualizar y rectifica sus datos personales, revocar la autorización concedida o solicitar la supresión de información cuando esto sea procedente. HOTEL SOLIARI como responsables del tratamiento
puede ser contactado para todo lo pertinente al teléfono 3112801286 o a la dirección de correo electrónico hotelsoliari@gmail.com | User:<?php echo $username; ?></p>
    </div>
    <div class="firma">
        <span >Firma(s) Huesped(es) ACEPTO CONDICIONES DEL CONTRATO DE ALOJAMIENTO</span>

    </div>
    
</body>
</html>
