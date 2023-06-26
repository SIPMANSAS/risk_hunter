<?php
//	require_once "mensajes.php";
require_once "funciones.php";
include_once "../clases/greservas.class.php";
include_once "../clases/clientes.class.php";
include_once "../clases/paginas.class.php";
include_once "../clases/habitaciones.class.php";
include_once "../clases/servicios.class.php";
include_once "../clases/pagos.class.php";
include_once "../clases/tarifas.class.php";
include_once "../clases/monedas.class.php";
include_once "../clases/elementos.class.php";
include_once "../clases/alertas.class.php";
include_once "../clases/departamentos.class.php";
include_once "../clases/medios.class.php";
include_once "../clases/franquicias.class.php";

$XOBJPAG=new paginas;
$XPAGINA="'PAG_RES_GESTION'";
$XLENG="'ESP'";
$XCLASS="'001'";
$XRSPAG=$XOBJPAG->FncBuscarPagina($XLENG, $XPAGINA, $XCLASS);
$XI=0;
while($XROWPAG=$XOBJPAG->obtener_fila($XRSPAG)){//CREA EL ARREGLO PARA EL MENU
	$XLABEL[$XI]=utf8_encode($XROWPAG[0]);
	$XI++;
}

$XOBJHAB=new habitaciones;

//DATOS DE LA PAGINA HOSPEDAJE
$opcion=$_POST['opcion'];

$correcto='ui-state-highlight ui-corner-all';
$error='ui-state-error ui-corner-all';
$advertencia='alert alert-warning';
$informacion='alert alert-information';

$XOBJRES = new greservas;
$XOBJCLI = new clientes;
$XOBJMOB = new elementos;
$XOBJPAG = new pagos;
$XOBJALR = new alertas;
$XOBJDEP = new departamentos;

if($opcion=='GuardarReserva'){
	//MENORES
	$XIDCLI=$_POST['TxtIdCli'];
	$XNUMRES=$_POST['TxtNumRes'];
	$XIDDETRES=$_POST['TxtIdDetRes'];
	$XRESMEN=$_POST['TxtResMen'];
	$XIDMEN=$_POST['TxtIdMen'];
	$XSLCNUMHAB=$_POST['SlcNumHab'];
	//MONEDA
	$XSLCRESMON=$_POST['SlcResMon'];
	$XSLCRESVALTAR=$_POST['SlcResValTar'];

	$XRSRES=$XOBJRES->actualizar_reservas($XIDCLI, $XNUMRES);
	//HABITACIONES
	$XRSRES=$XOBJRES->actualizar_reserva_habitacion($XSLCRESVALTAR, $XSLCRESMON, $XNUMRES, $XSLCNUMHAB);
	//MENORES
	$XINFOEDAD=explode(',',$XRESMEN);
	$XINFONUMED=explode(',',$XIDMEN);
	for($XI=0;$XI<count($XINFOEDAD);$XI++){
		$XRSRES=$XOBJRES->actualizar_menores($XINFOEDAD[$XI], $XINFONUMED[$XI]);
	}
	
	$data_row = array('TxtIdCli'=>$XIDCLI, 'TxtNumRes'=>$XNUMRES, 'SlcNumHab'=>$XSLCNUMHAB);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='GuardarDisponibilidad'){
	$XSLCRESMON=$_POST['SlcResMon'];
	$XNUMRES=$_POST['TxtNumRes'];
	$XNUMHABDISP=$_POST['TxtNumHabDisp'];
	$XTIPOHABDISP=$_POST['TxtTipoHabDisp'];
	$XVALTARDISP=$_POST['TxtValTarDisp'];

	$XINFONUMHAB=explode(',',$XNUMHABDISP);
	$XINFOTIPOHAB=explode(',',$XTIPOHABDISP);
	$XINFOVALTAR=explode(',',$XVALTARDISP);

	$XNUMHAB=array();
	$XTIPOHAB=array();
	$XVALTAR=array();
	$XSEQNUM=array();

	$XJ=0;
	$XRSHABRES=$XOBJRES->ver_seleccion_habitaciones($XNUMRES);
	while($XROWHAB=$XOBJRES->obtener_fila($XRSHABRES)){
		$XVALIDA=0;
		for($XI=0;$XI<count($XINFONUMHAB);$XI++){
			if($XROWHAB[0]==$XINFONUMHAB[$XI]){
				$XVALIDA=1;
			}
		}
		if($XVALIDA==0){
			$XNUMHAB[$XJ]=$XINFONUMHAB[$XI];
			$XTIPOHAB[$XJ]=$XINFOTIPOHAB[$XI];
			$XVALTAR[$XJ]=$XINFOVALTAR[$XI];
			$XSEQNUM[$XJ]=$XROWHAB[10];
			$XJ++;
		}
	}
	if(count($XNUMHAB>0)){
		for($XI=0;$XI<count($XNUMHAB);$XI++){
			$XRSHAB=$XOBJRES->ver_prereserva_habitacion($XSEQNUM[$XN]);
			$XROWHAB=$XOBJRES->obtener_fila($XRSHAB);
			$XINFOPRE[0]=$XROWHAB[0];
			$XINFOPRE[1]=$XROWHAB[1];
			$XINFOPRE[2]=$XROWHAB[3];
			$XINFOPRE[3]=$XVALTAR[$XI];
			$XINFOPRE[4]=$XROWHAB[6];
			$XINFOPRE[5]=$XROWHAB[7];
			$XINFOPRE[6]=$XTIPOHAB[$XI];
			$XINFOPRE[7]=$XNUMHAB[$XI];
			$XRSHAB=$XOBJRES->ingresar_detalle_prereserva($XINFOPRE);
			$XRSEST=$XOBJHAB->cambiar_estado_habitaciones($XROWHAB[8],'disponible');
			$XRSELM=$XOBJRES->eliminar_prereserva($XSEQNUM[$XN]);
		}
	}
	$XRES=$XOBJRES->cambiar_estado_reserva($XNUMRES,'confirmada');
	$XTABHABDISP=FncTabHabitacionDisp($XLABEL, $XNUMRES);
	$data_row = array('TxtNumRes'=>$XNUMRES, 'SlcResMon'=>$XSLCRESMON, 'TabHabitacionDisp'=>$XTABHABDISP);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='BuscarHospedaje'){
	$XINFO = array('','','','','','','','','','','','','','','','');
	$XINFO[0]=$_POST['TxtLlegada'];
	$XINFO[1]=$_POST['TxtAdultos'];
	$XINFO[2]=$_POST['TxtNoches'];
	$XINFO[3]=$_POST['TxtNinos'];
	$XINFO[4]=$_POST['TxtSalida'];
	$XINFO[5]=$_POST['TxtCantidad'];
	if($XINFO[3]=="")$XINFO[3]='0';
	if($XINFO[5]=="")$XINFO[5]='0';
	$XTABLA='';
	if(($XINFO[0]!="")&&($XINFO[1]!="")&&($XINFO[2]!="")&&($XINFO[3]!="")&&($XINFO[4]!="")){
		$XARREGLO=FncTabHospedaje($XLABEL, $XINFO);
		$XTABLA=$XARREGLO[0];		
		$XINFO[5]=$XARREGLO[1];		
		echo retornar_msj($XINFO, $XTABLA, '', '');
		//echo retornar_msj($XINFO, $XTABLA, 'Aqui', '');
	}
	else{
		echo retornar_msj($XINFO, $XTABLA, 'Diligencie Todos los Campos', $error);
	}
}

if($opcion=='SelecServicio'){
	$XSLCSERVICIO=$_POST['SlcServicio'];
	$XTXTRESLLEG=$_POST['TxtResLleg'];
	$XTXTRESSAL=$_POST['TxtResSal'];
	$XSLCTIPOHAB=$_POST['SlcTipoHab'];

	$XOBJSER=new servicios;
	$XRSSER=$XOBJSER->buscar_servicio($XSLCSERVICIO);
	$XROWSER=$XOBJSER->obtener_fila($XRSSER);
	$data_row = array('SlcServicio'=>$XSLCSERVICIO, 'TxtIdServ'=>$XROWSER[0], 'TxtTarServ'=>$XROWSER[1], 'TxtFecIniServ'=>$XTXTRESLLEG, 'TxtFecFinServ'=>$XTXTRESSAL);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='AdicionarServicio'){
	$XTXTIDSERV=$_POST['TxtIdServ'];
	$XTXTTARSERV=$_POST['TxtTarServ'];
	$XTXTNUMREGSERV=$_POST['TxtNumRegServ'];
	$XSLCSERVICIO=$_POST['SlcServicio'];
	$XTXTFECINISERV=$_POST['TxtFecIniServ'];
	$XTXTFECFINSERV=$_POST['TxtFecFinServ'];
	$XTXTCANSERV=$_POST['TxtCanServ'];
	$XSLCTIPOHAB=$_POST['SlcTipoHab'];
	$XSLCNUMHAB=$_POST['SlcNumHab'];
	$XNUMRES=$_POST['TxtNumRes'];
	$XIDDETRES=$_POST['TxtIdDetRes'];

	$XINFOSER[0]=$XTXTIDSERV;
	$XINFOSER[1]=$XTXTTARSERV;
	$XINFOSER[2]=$XTXTCANSERV;
	$XINFOSER[3]=cambiar_fecha($XTXTFECINISERV);
	$XINFOSER[4]=cambiar_fecha($XTXTFECFINSERV);
	$XINFOSER[5]=$XNUMRES;
	$XINFOSER[6]=$XSLCNUMHAB;
	$XINFOSER[7]='';
	$XOBJSER=new servicios;
	$XRSSER=$XOBJSER->ingresar_servicio_reserva($XINFOSER);

	if(($XTXTNUMREGSERV=="")||($XTXTNUMREGSERV<=0)) 
		$XOFFSET=0;
	else
		$XOFFSET=$XTXTNUMREGSERV-1;		
		
	$XRSTOT=$XOBJSER->total_servicios_reserva($XNUMRES, $XSLCNUMHAB);
	$XTOTALREGRES=$XOBJSER->numero_filas($XRSTOT);
	$XPAGSERV=ceil($XTOTALREGRES/4);
	$XTABDETSERV=FncTabDetalleServ($XLABEL, $XNUMRES, $XSLCNUMHAB, $XOFFSET, $XPAGSERV);
	$data_row = array('TabDetServicios'=>$XTABDETSERV);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='AceptarHospedaje'){
	$XINFO=array('','','','','','','','','','','','','','','','','','','','','');
	$XINFODET=array('','','','','','','','','','','','','','','','','','','','','');
	$XINFOMOB=array('','','','','','','','','','','','','','','','','','','','','');
	$XINFOPRE=array('','','','','','','','','','','','','','','','','','','','','');
	$XINFO[0]=$_POST['TxtLlegada'];
	$XINFO[1]=$_POST['TxtAdultos'];
	$XINFO[2]=$_POST['TxtNoches'];
	$XINFO[3]=$_POST['TxtNinos'];
	$XINFO[4]=$_POST['TxtSalida'];
	$XINFO[5]=$_POST['TxtCantidad'];
	$XINFO[6]=$_POST['id_hab'];
	$XINFO[7]=$_POST['tipo_hab'];
	$XINFO[8]=$_POST['tarifa'];
	$XINFO[9]=$_POST['numadl'];
	$XINFO[13]=$_POST['numnin'];
	$XINFO[10]=str_replace(',','',$_POST['valor_res']);
	if(($XINFO[0]!="")&&($XINFO[1]!="")&&($XINFO[2]!="")&&($XINFO[3]!="")&&($XINFO[4]!="")){
		$XARREGLO=FncTabHospedaje($XLABEL, $XINFO);
		$XTABLA=$XARREGLO[0];		
		$XINFO[5]=$XARREGLO[1];

		$XINFOHAB=explode(',',$XINFO[6]);
		$XINFOTIP=explode(',',$XINFO[7]);
		$XINFOTAR=explode(',',$XINFO[8]);
		$XINFOADL=explode(',',$XINFO[9]);
		$XINFONIN=explode(',',$XINFO[13]);

		$XCODIGO = $XOBJRES->codigo_prereserva();
		$XINFOPRE[0]=$XOBJRES->obtener_codigo($XCODIGO);
		$XINFOPRE[0]=retornar_codigo(10,$XINFOPRE[0]);
		$XINFOPRE[1]=$XINFO[2];
		$XINFOPRE[2]=$XINFO[1];
		$XINFOPRE[3]=$XINFO[3];
		$XINFOPRE[4]=$XINFO[5];
		$XINFOPRE[5]=$XINFO[10];
		$XINFOPRE[6]='reservada';
		$XINFOPRE[7]=date('Y-m-d');
		$XINFOPRE[8]='ERP';
		$XRSPRE=$XOBJRES->ingresar_prereserva($XINFOPRE);
		for($XI=0;$XI<count($XINFOHAB);$XI++){
			if($XINFOADL[$XI]=="")$XINFOADL[$XI]=0;
			if($XINFONIN[$XI]=="")$XINFONIN[$XI]=0;
			$XINFODET[0]=$XINFOPRE[0];
			$XINFODET[1]=cambiar_fecha($XINFO[0]);
			$XINFODET[2]=cambiar_fecha($XINFO[4]);
			$XINFODET[3]=$XINFOTAR[$XI];
			$XINFODET[4]=$XINFOADL[$XI];
			$XINFODET[5]=$XINFONIN[$XI];
			$XINFODET[6]=$XINFOTIP[$XI];
			$XINFODET[7]=$XINFOHAB[$XI];
			$XRSDET=$XOBJRES->ingresar_detalle_prereserva($XINFODET);
			for($XS=0;$XS<$XINFONIN[$XI];$XS++){
				$XRSMEN=$XOBJRES->ingresar_menores($XINFODET);
			}
//			$XRSESTHAB=$XOBJHAB->cambiar_estado_habitaciones($XINFODET[7],'bloqueada');
			$XRSMOB=$XOBJMOB->ver_mobiliario_habitacion($XINFODET[7]);
			while($XROWMOB=$XOBJMOB->obtener_fila($XRSMOB)){
				$XINFOMOB[0]=$XROWMOB[0];
				$XINFOMOB[1]=$XINFODET[7];
				$XINFOMOB[2]=$XINFODET[0];
				$XINFOMOB[3]=$XROWMOB[3];
				$XINFOMOB[4]=$XROWMOB[2];
				$XINFOMOB[5]=$XROWMOB[2];
				$XINFOMOB[6]='disponible';
				$XRSMOBRES=$XOBJMOB->ingresar_mobiliario_reserva($XINFOMOB);
			}
		}
		$XINFO[11]=FncTabInfoRes($XLABEL, $XINFOPRE[0]);				
		//$XINFO[11]='';				
		$XINFO[12]=$XINFOPRE[0];				

		//INFORMACION DE PRE-RESERVAS
		$XNUMREGPRE=0;
		$XRSRES=$XOBJRES->total_prereservas($XINFOPRE[0]);
		$XTOTREGPRE=$XOBJRES->numero_filas($XRSRES);
		$XRSRES=$XOBJRES->buscar_prereservas($XINFOPRE[0],$XNUMREGPRE,1);
		if($XOBJRES->numero_filas($XRSRES)!=0)
			$XROWRES=$XOBJRES->obtener_fila($XRSRES);
		else
			$XROWRES=array('','','','','','','','','','','','','','','','','','','');
		$XTABRES=FncTabReservaPre($XLABEL, $XROWRES, $XNUMREGPRE, $XTOTREGPRE);
		//INFORMACION DE SERVICIOS POR HABITACION
		$XOBJSER=new servicios;
		$XTXTNUMREGSERV=1;
		$XRSTOT=$XOBJSER->total_servicios_reserva($XROWRES[10], $XROWRES[3]);
		$XTOTALREGRES=$XOBJSER->numero_filas($XRSTOT);
		$XPAGSERV=ceil($XTOTALREGRES/4);
		$XTABDETSERV=FncTabDetalleServ($XLABEL, $XROWRES[10], $XROWRES[3], $XTXTNUMREGSERV, $XPAGSERV);
		//INFORMACION DE ABONOS POR HABITACION
/*		$XOBJPAG=new pagos;
		$XTXTNUMREGABO=1;
		$XRSTOT=$XOBJPAG->total_abonos_reserva($XROWRES[10], $XROWRES[3]);
		$XTOTALREGRES=$XOBJPAG->numero_filas($XRSTOT);
		$XPAGSERV=ceil($XTOTALREGRES/4);
		$XTABDETPAGOS=FncTabDetallePagos($XLABEL, $XROWRES[10], $XROWRES[3], $XTXTNUMREGABO, $XPAGSERV);*/
		//INFORMACION DE EDADES DE MENORES
		$XTABMEN=FncTabDetalleMenores($XLABEL, $XROWRES[10], $XROWRES[3], $XROWRES[5]);

		//INFORMACION DE DISPONIBILIDAD
		$XROWCLI=array('','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','');
		$XRSRES=$XOBJRES->total_prereservas($XROWRES[10]);
		$XROWDIS=$XOBJRES->obtener_fila($XRSRES);
		$XTABDISP=FncTabClienteDisp($XLABEL, $XROWCLI, $XROWDIS);
		//TABLA DE HABITACIONES
		$XTABHABDISP=FncTabHabitacionDisp($XLABEL, $XROWRES[10]);
		//TABLA DE INFORMACION DE LA RESERVA
		$XTABDATOSRES=FncTabDetallePagosRes($XLABEL, $XROWRES[10], $XROWDIS[9]);
		//INFORMACION DE CONFIRMAR
		$XTABCONF=FncTabClienteConf($XLABEL, $XROWCLI, $XROWDIS);
	
		$XOBJPAG=new pagos;
		//	$XTABPAGOSHAB=FncTabPagosConf($XLABEL, $XNUMRES, '0');
		$XTABPAGOSRES=FncTabMetodoRes($XLABEL, '1', $XROWRES[10], '1');
		//INFORMACION DE ALERTAS
		$XTABALER=FncTabClienteAler($XLABEL, $XROWCLI, $XROWDIS);

		//IMPRIMIR VENTANA
		$data_row = array('TxtLlegada'=>$XINFO[0], 'TxtAdultos'=>$XINFO[1], 'TxtNoches'=>$XINFO[2], 'TxtNinos'=>$XINFO[3], 'TxtSalida'=>$XINFO[4], 'TxtCantidad'=>$XINFO[5], 'tabinfo'=>$XINFO[11], 'TxtNumRes'=>$XINFO[12], 'TxtIdDetRes'=>$XROWRES[11], 'tabhosp'=>$XTABLA, 'TxtNumRegPre'=>$XNUMREGPRE, 'TxtTotRegPre'=>$XTOTREGPRE, 'TabResPre'=>$XTABRES, 'TabDetServicios'=>$XTABDETSERV, 'TabDetMenores'=>$XTABMEN, 'TabClienteDisp'=>$XTABDISP, 'TabHabitacionDisp'=>$XTABHABDISP, 'TabDatosRes'=>$XTABDATOSRES, 'TabClienteConf'=>$XTABCONF, 'TabPagosRes'=>$XTABPAGOSRES, 'TabClienteAler'=>$XTABALER);
//		$data_row = array('TxtNumRes'=>$XINFO[12]);
		echo json_encode($data_row);
//		echo retornar_msj($XINFO, $XTABLA, 'Ha Registrado una Pre-Reserva Correctamente', $correcto);
	}
	else{
//		echo retornar_msj($XINFO, $XTABLA, 'Diligencie Todos los Campos', $error);
		$data_row = array('TabPagosRes'=>'');
		header('Content-Type: application/json');
		echo json_encode($data_row);
	}

}

if($opcion=='BuscarCliente'){
	$XIDCLI=$_POST['TxtIdCli'];
	$XNUMRES=$_POST['TxtNumRes'];
	//$XNUMREGPRE=$_POST['TxtNumRegPre'];
	//$XTOTREGPRE=$_POST['TxtTotRegPre'];
	$XIDDETRES=$_POST['TxtIdDetRes'];
	$XSLCTIPOHAB=$_POST['SlcTipoHab'];

	$XOBJCLI=new clientes;
	$XNUMREGPRE=0;
	$XRSCLI=$XOBJCLI->buscar_clientes($XIDCLI);
	if($XOBJCLI->numero_filas($XRSCLI)!=0){
		$XENCONTRO=1;
		$XROWCLI=$XOBJCLI->obtener_fila($XRSCLI);
		$XTABLA=FncTabReservaCli($XLABEL, $XROWCLI);
		//INFORMACION DE PRE-RESERVAS
/*		if($XNUMRES!=""){
			$XRSRES=$XOBJRES->total_prereservas($XNUMRES);
			$XTOTREGPRE=$XOBJRES->numero_filas($XRSRES);
			$XRSRES=$XOBJRES->buscar_prereservas($XNUMRES,$XNUMREGPRE,1);
			$XROWRES=$XOBJRES->obtener_fila($XRSRES);
			$XTABRES=FncTabReservaPre($XLABEL, $XROWRES, $XNUMREGPRE, $XTOTREGPRE);
			//INFORMACION DE SERVICIOS POR HABITACION
			$XOBJSER=new servicios;
			$XTXTNUMREGSERV=1;
			$XRSTOT=$XOBJSER->total_servicios_reserva($XROWRES[10], $XROWRES[3]);
			$XTOTALREGRES=$XOBJSER->numero_filas($XRSTOT);
			$XPAGSERV=ceil($XTOTALREGRES/4);
			$XTABDETSERV=FncTabDetalleServ($XLABEL, $XROWRES[10], $XROWRES[3], $XTXTNUMREGSERV, $XPAGSERV);
			//INFORMACION DE ABONOS POR HABITACION
/*			$XOBJPAG=new pagos;
			$XTXTNUMREGABO=1;
			$XRSTOT=$XOBJPAG->total_abonos_reserva($XROWRES[10], $XROWRES[3]);
			$XTOTALREGRES=$XOBJPAG->numero_filas($XRSTOT);
			$XPAGSERV=ceil($XTOTALREGRES/4);
			$XTABDETPAGOS=FncTabDetallePagos($XLABEL, $XROWRES[10], $XROWRES[3], $XTXTNUMREGABO, $XPAGSERV);
			//INFORMACION DE EDADES DE MENORES
			$XTABMEN=FncTabDetalleMenores($XLABEL, $XROWRES[10], $XROWRES[3], $XROWRES[5]);
			//INFORMACION DE PAGOS
			$XNUMREGPAG=0;
			/*$XRSTOT=$XOBJPAG->total_abonos_xreserva($XNUMRES);
			$XTOTREGPAG=$XOBJPAG->numero_filas($XRSTOT);
			$XRSPAG=$XOBJPAG->buscar_abonos_xreserva($XNUMRES,$XNUMREGPAG,1);
			$XROWPAG=$XOBJPAG->obtener_fila($XRSPAG);

			$XTABPAGOSCONF=FncTabPagosConf($XLABEL, $XROWPAG, $XNUMREGPAG, $XTOTREGPAG);
		}
		else{
			$XTABRES=FncTabReservaPre($XLABEL, '', '0','0');
			$XTABDETSERV=FncTabDetalleServ($XLABEL, '0', '0','0', '0');
			//$XTABDETPAGOS=FncTabDetallePagos($XLABEL, '', '', '0','0');
			$XTABMEN=FncTabDetalleMenores($XLABEL, '', '', '');
		}

	
		$XTABINFO=FncTabInfoRes($XLABEL, $XNUMRES);				
		//INFORMACION DE DISPONIBILIDAD
		$XRSRES=$XOBJRES->total_prereservas($XNUMRES);
		$XROWRES=$XOBJRES->obtener_fila($XRSRES);
		$XTABDISP=FncTabClienteDisp($XLABEL, $XROWCLI, $XROWRES);
		//TABLA DE HABITACIONES
		$XTABHABDISP=FncTabHabitacionDisp($XLABEL, $XNUMRES);
		//INFORMACION DE CONFIRMAR
		$XTABCONF=FncTabClienteConf($XLABEL, $XROWCLI, $XROWRES);
		//INFORMACION DE ALERTAS
		$XTABALER=FncTabClienteAler($XLABEL, $XROWCLI, $XROWRES);*/
		
		$data_row = array('TxtIdCli'=>$XIDCLI, 'TxtNumRes'=>$XNUMRES, 'TxtIdDetRes'=>$XIDDETRES, 'Encontro'=>$XENCONTRO, 'TabResCli'=>$XTABLA);
//		$data_row = array('TxtIdCli'=>$XIDCLI, 'TxtNumRes'=>$XNUMRES, 'TxtIdDetRes'=>$XROWRES[11], 'TxtNumRegPre'=>$XNUMREGPRE, 'TxtTotRegPre'=>$XTOTREGPRE, 'Encontro'=>$XENCONTRO, 'TabResCli'=>$XTABLA, 'TabResPre'=>$XTABRES, 'TabClienteDisp'=>$XTABDISP, 'TabDetServicios'=>$XTABDETSERV, 'TabDetMenores'=>$XTABMEN, 'TabHabitacionDisp'=>$XTABHABDISP, 'TabClienteConf'=>$XTABCONF, 'TabClienteAler'=>$XTABALER, 'tabinfo'=>$XTABINFO, 'TabPagosConf'=>$XTABPAGOSCONF);
		header('Content-Type: application/json');
		echo json_encode($data_row);
	}
	else{
		$XENCONTRO=0;
		$XINFO=array('','','','','','','','','','','','','','','','','','','','','');
		$XTABLA=FncTabReservaCli($XLABEL, $XINFO);
		//$XTABRES=FncTabReservaPre($XLABEL, '', '0','0');
		$data_row = array('TxtIdCli'=>$XIDCLI, 'TxtNumRes'=>$XNUMRES, 'TxtIdDetRes'=>$XIDDETRES, 'Encontro'=>$XENCONTRO, 'TabResCli'=>$XTABLA, 'SlcNumHab'=>$XSLCNUMHAB);
		header('Content-Type: application/json');
		echo json_encode($data_row);
	}
}

if($opcion=='SiguientePre'){
	$XIDCLI=$_POST['TxtIdCli'];
	$XNUMRES=$_POST['TxtNumRes'];
	$XPAG=$_POST['TxtPag'];
//	$XTOTREGPRE=$_POST['TxtTotRegPre'];
	$XIDDETRES=$_POST['TxtIdDetRes'];

	$XOFFSET=(int) $XPAG;
	$XOFFSET--;
	if($XOFFSET>=0){
		$XRSRES=$XOBJRES->total_prereservas($XNUMRES);
		$XTOTREGPRE=$XOBJRES->numero_filas($XRSRES);

		$XRSRES=$XOBJRES->buscar_prereservas($XNUMRES,$XOFFSET,1);
		$XROWRES=$XOBJRES->obtener_fila($XRSRES);
		$XTABRES=FncTabReservaPre($XLABEL, $XROWRES, $XPAG, $XTOTREGPRE);
		//INFORMACION DE SERVICIOS POR HABITACION
		$XOBJSER=new servicios;
		$XTXTNUMREGSERV=1;
		$XRSTOT=$XOBJSER->total_servicios_reserva($XROWRES[10], $XROWRES[3]);
		$XTOTALREGRES=$XOBJSER->numero_filas($XRSTOT);
		$XPAGSERV=ceil($XTOTALREGRES/4);
		$XTABDETSERV=FncTabDetalleServ($XLABEL, $XROWRES[10], $XROWRES[3], $XTXTNUMREGSERV, $XPAGSERV);
		//INFORMACION DE ABONOS POR HABITACION
		/*$XOBJPAG=new pagos;
		$XTXTNUMREGABO=1;
		$XRSTOT=$XOBJPAG->total_abonos_reserva($XROWRES[10], $XROWRES[3]);
		$XTOTALREGRES=$XOBJPAG->numero_filas($XRSTOT);
		$XPAGSERV=ceil($XTOTALREGRES/4);
		$XTABDETPAGOS=FncTabDetallePagos($XLABEL, $XROWRES[10], $XROWRES[3], $XTXTNUMREGABO, $XPAGSERV);*/
		//INFORMACION DE EDADES DE MENORES
		$XTABMEN=FncTabDetalleMenores($XLABEL, $XROWRES[10], $XROWRES[3], $XROWRES[5]);

		$data_row = array('TxtIdCli'=>$XIDCLI, 'TxtNumRes'=>$XNUMRES, 'TxtIdDetRes'=>$XROWRES[11], 'TabResPre'=>$XTABRES, 'TabDetServicios'=>$XTABDETSERV, 'TabDetMenores'=>$XTABMEN);
		header('Content-Type: application/json');
		echo json_encode($data_row);
	}
}


if($opcion=='SiguienteServ'){
	$XIDCLI=$_POST['TxtIdCli'];
	$XNUMRES=$_POST['TxtNumRes'];
	$XIDDETRES=$_POST['TxtIdDetRes'];
	$XTXTNUMREGSERV=$_POST['TxtNumRegServ'];
	$XSLCTIPOHAB=$_POST['SlcTipoHab'];
	$XSLCNUMHAB=$_POST['SlcNumHab'];
	//INFORMACION DE SERVICIOS POR HABITACION
	$XOFFSET=(int) $XTXTNUMREGSERV;
	$XOFFSET--;
	if($XOFFSET>=0){
		$XOBJSER=new servicios;
		$XRSTOT=$XOBJSER->total_servicios_reserva($XNUMRES, $XSLCNUMHAB);
		$XTOTALREGRES=$XOBJSER->numero_filas($XRSTOT);
		$XPAGSERV=ceil($XTOTALREGRES/4);
		$XTABDETSERV=FncTabDetalleServ($XLABEL, $XNUMRES, $XSLCNUMHAB, $XTXTNUMREGSERV, $XPAGSERV);
		$data_row = array('TxtIdCli'=>$XIDCLI, 'TxtNumRes'=>$XNUMRES, 'TxtIdDetRes'=>$XIDDETRES, 'SlcTipoHab'=>$XSLCTIPOHAB, 'SlcNumHab'=>$XSLCNUMHAB, 'TabDetServicios'=>$XTABDETSERV, 'SlcNumHab'=>$XSLCNUMHAB);
		header('Content-Type: application/json');
		echo json_encode($data_row);
	}
}

if($opcion=='EliminarServ'){
	$XIDCLI=$_POST['TxtIdCli'];
	$XNUMRES=$_POST['TxtNumRes'];
	$XIDDETRES=$_POST['TxtIdDetRes'];
	$XTXTNUMREGSERV=$_POST['TxtNumRegServ'];
	$XSLCTIPOHAB=$_POST['SlcTipoHab'];
	$XSLCNUMHAB=$_POST['SlcNumHab'];
	$XCODSERV=$_POST['codserv'];
	//INFORMACION DE SERVICIOS POR HABITACION
	if(($XTXTNUMREGSERV=="")||($XTXTNUMREGSERV<=0)) 
		$XOFFSET=0;
	else
		$XOFFSET=$XTXTNUMREGSERV-1;		

	if($XOFFSET<0) $XOFFSET=0;
	$XOBJSER=new servicios;
	$XRSELM=$XOBJSER->eliminar_servicios_reserva($XCODSERV);
	$XRSTOT=$XOBJSER->total_servicios_reserva($XNUMRES, $XSLCNUMHAB);
	$XTOTALREGRES=$XOBJSER->numero_filas($XRSTOT);
	$XPAGSERV=ceil($XTOTALREGRES/4);
	$XTABDETSERV=FncTabDetalleServ($XLABEL, $XNUMRES, $XSLCNUMHAB, $XOFFSET, $XPAGSERV);
	$data_row = array('TxtIdCli'=>$XIDCLI, 'TxtNumRes'=>$XNUMRES, 'TxtIdDetRes'=>$XIDDETRES, 'SlcTipoHab'=>$XSLCTIPOHAB, 'SlcNumHab'=>$XSLCNUMHAB, 'TabDetServicios'=>$XTABDETSERV);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='AdicionarAbono'){
	$XOBJPAG=new pagos;
	$XRSCODIGO = $XOBJPAG->codigo_forma_pago();
	$XINFOSER[0]=$XOBJPAG->obtener_codigo($XRSCODIGO);
	$XINFOSER[1]=$XSLCPAGO;
	$XINFOSER[2]=$XTXTNUMTC;
	$XINFOSER[3]=$XTXTDIGITO;
	$XINFOSER[4]=$XTXTCV;
	$XINFOSER[5]=$XTXTMMEXPIRA;
	$XINFOSER[6]=$XTXTAAEXPIRA;
	$XINFOSER[7]=$XTXTNOMBRE;
	$XINFOSER[8]=$XTXTAPELLIDO;
	$XINFOSER[9]=$XIDCLI;
	$XINFOSER[10]='';
	$XRSPAG=$XOBJPAG->ingresar_forma_pago($XINFOSER);

	$XRSCODIGO = $XOBJPAG->codigo_abono_reserva();
	$XINFOABO[0]=$XOBJPAG->obtener_codigo($XRSCODIGO);
	$XINFOABO[1]=$XINFOSER[0];
	$XINFOABO[2]=$XNUMRES;
	$XINFOABO[3]=$XSLCPAGO;
	$XINFOABO[4]=$XTXTVALPAGO;
	$XINFOABO[5]=$XIDCLI;
	$XINFOABO[6]='';
	$XINFOABO[7]=$XSLCRESMON;
	$XINFOABO[8]='';
	$XINFOABO[9]='';
	$XINFOABO[10]='';
	$XINFOABO[11]='';
	$XINFOABO[12]='';
	$XINFOABO[13]='';
	$XINFOABO[14]='';
	$VALORAB=(int) $XTXTVALPAGO;
	$VALORBAS=ceil($VALORAB/1.16);
	$VALORIVA=$VALORAB-$VALORBAS;
	$XINFOABO[15]=$VALORBAS;
	$XINFOABO[16]=$VALORIVA;
	$XINFOABO[17]='0';
	$XRSPAG=$XOBJPAG->ingresar_abono_reserva($XINFOABO);

	$XINFODIS[0]=$XNUMRES;
	$XINFODIS[1]=$XINFOABO[0];
	$XINFODIS[2]=$XSLCNUMHAB;
	$XINFODIS[3]=$XSLCSERVPAGO;
	$XINFODIS[4]=$XSLCTIPOHAB;
	$XINFODIS[5]=$XSLCPAGO;
	$XINFODIS[6]=$XIDCLI;
	$XINFODIS[7]='';
	$XINFODIS[8]=$VALORBAS;
	$XINFODIS[9]=$VALORIVA;
	$XRSPAG=$XOBJPAG->ingresar_distribucion_abonos($XINFODIS);


	$XTXTNUMREGABO=1;
	$XRSTOT=$XOBJPAG->total_abonos_reserva($XNUMRES, $XSLCNUMOHAB);
	$XTOTALREGRES=$XOBJPAG->numero_filas($XRSTOT);
	$XPAGSERV=ceil($XTOTALREGRES/4);
	
	$XTABDETPAGOS=FncTabDetallePagos($XLABEL, $XNUMRES, $XSLCNUMHAB, $XTXTNUMREGABO, $XPAGSERV);
	$data_row = array('TabDetPagos'=>$XTABDETPAGOS);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='EliminarAbono'){
	//INFORMACION DE ABONOS POR HABITACION
	$XOBJPAG=new pagos;
	$XTXTNUMREGABO=1;
	$XRSELM=$XOBJPAG->eliminar_distribucion_abonos($XTXTIDABONO, $XTXTIDPAGOCLI);
	$XRSELM=$XOBJPAG->eliminar_abono_reserva($XTXTIDABONO);
	$XRSTOT=$XOBJPAG->total_abonos_reserva($XNUMRES, $XSLCNUMOHAB);
	$XTOTALREGRES=$XOBJPAG->numero_filas($XRSTOT);
	$XPAGSERV=ceil($XTOTALREGRES/4);
	$XTABDETPAGOS=FncTabDetallePagos($XLABEL, $XNUMRES, $XSLCNUMHAB, $XTXTNUMREGABO, $XPAGSERV);
	$data_row = array('TxtIdCli'=>$XIDCLI, 'TxtNumRes'=>$XNUMRES, 'TxtIdDetRes'=>$XIDDETRES, 'TxtNumRegServ'=>$XTXTNUMREGSERV, 'TxtTotRegServ'=>$XPAGSERV, 'SlcTipoHab'=>$XSLCTIPOHAB, 'SlcNumHab'=>$XSLCNUMHAB, 'TabDetPagos'=>$XTABDETPAGOS, 'SlcNumHab'=>$XSLCNUMHAB);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='VerDetalleHabDisp'){
	$XTXTIDHAB=$_POST['TxtIdHab'];
	$XIDCLI=$_POST['TxtIdCli'];
	$XNUMRES=$_POST['TxtNumRes'];
	$XTABDETALLESHABITACION=FncTabDetallesHabitacion($XLABEL, $XNUMRES, $XTXTIDHAB);
	$data_row = array('TxtIdCli'=>$XIDCLI, 'TxtNumRes'=>$XNUMRES, 'TabDetallesHabitacion'=>$XTABDETALLESHABITACION);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='BuscarBasClientes'){
	$XBUSCAR='1';
	$XBUSIDCLI=$_POST['TxtBusIdCli'];
	$XBUSNOMCLI=$_POST['TxtBusNomCli'];
	$XBUSIDTER=$_POST['TxtBusIdTer'];
	$XBUSNOMTER=$_POST['TxtBusNomTer'];
	$XINFO[0]=$XBUSIDCLI;
	$XINFO[1]=$XBUSNOMCLI;
	$XINFO[2]=$XBUSIDTER;
	$XINFO[3]=$XBUSNOMTER;
	$XTABBUSCLIENTES=FncTabBuscarClientes($XLABEL, $XINFO, '', $XBUSCAR);
	$data_row = array('TxtBusIdCli'=>$XBUSIDCLI, 'TxtBusNomCli'=>$XBUSNOMCLI, 'TxtBusIdTer'=>$XBUSIDTER, 'TxtBusNomTer'=>$XBUSNOMTER, 'TabBusClientes'=>$XTABBUSCLIENTES);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='BuscarAvClientes'){
	$XBUSCAR='2';
	//BUSQUEDA DE CLIENTES
	$XBUSIDCLI=$_POST['TxtBusIdCli'];
	$XBUSNOMCLI=$_POST['TxtBusNomCli'];
	$XBUSIDTER=$_POST['TxtBusIdTer'];
	$XBUSNOMTER=$_POST['TxtBusNomTer'];
	$XBUSIDVIP=$_POST['TxtBusIdVip'];
	$XBUSAPECLI=$_POST['TxtBusApeCli'];
	$XBUSTIPOCLI=$_POST['SlcBusTipoCli'];
	$XBUSSEGMCLI=$_POST['SlcBusSegmCli'];
	$XBUSCATEGCLI=$_POST['SlcBusCategCli'];
	$XBUSCOMPANY=$_POST['TxtBusCompany'];
	//SIGNOS
	$XSIGIDCLI=$_POST['SlcSigIdCli'];
	$XSIGNOMCLI=$_POST['SlSicNomCli'];
	$XSIGIDVIP=$_POST['SlcSigIdVip'];
	$XSIGAPECLI=$_POST['SlcSigApeCli'];
	$XSIGTIPOCLI=$_POST['SlcSigTipoCli'];
	$XSIGSEGMCLI=$_POST['SlcSigSegmCli'];
	$XSIGCATEGCLI=$_POST['SlcSigCategCli'];
	$XSIGCOMPANY=$_POST['SlcSigCompany'];

	$XINFO[0]=$XBUSIDCLI;
	$XINFO[1]=$XBUSIDVIP;
	$XINFO[2]=$XBUSNOMCLI;
	$XINFO[3]=$XBUSAPECLI;
	$XINFO[4]=$XBUSTIPOCLI;
	$XINFO[5]=$XBUSSEGMCLI;
	$XINFO[6]=$XBUSCATEGCLI;
	$XINFO[7]=$XBUSCOMPANY;
	//SIGNOS
	$XSIGNOS[0]=$XSIGIDCLI;
	$XSIGNOS[1]=$XSIGIDVIP;
	$XSIGNOS[2]=$XSIGNOMCLI;
	$XSIGNOS[3]=$XSIGAPECLI;
	$XSIGNOS[4]=$XSIGTIPOCLI;
	$XSIGNOS[5]=$XSIGSEGMCLI;
	$XSIGNOS[6]=$XSIGCATEGCLI;
	$XSIGNOS[7]=$XSIGCOMPANY;
	$XTABBUSCLIENTES=FncTabBuscarClientes($XLABEL, $XINFO, $XSIGNOS, $XBUSCAR);
	$data_row = array('TxtBusIdCli'=>$XBUSIDCLI, 'TxtBusIdVip'=>$XBUSIDVIP, 'TxtBusNomCli'=>$XBUSNOMCLI, 'TxtBusApeCli'=>$XBUSAPECLI, 'SlcBusTipoCli'=>$XBUSTIPOCLI, 'SlcBusSegmCli'=>$XBUSSEGMCLI, 'SlcBusCategCli'=>$XBUSCATEGCLI, 'TxtBusCompany'=>$XBUSCOMPANY, 'SlcSigIdCli'=>$XSIGIDCLI, 'SlcSigIdVip'=>$XSIGIDVIP, 'SlcSigNomCli'=>$XSIGNOMCLI, 'SlcSigApeCli'=>$XSIGAPECLI, 'SlcSigTipoCli'=>$XSIGTIPOCLI, 'SlcSigSegmCli'=>$XSIGSEGMCLI, 'SlcSigCategCli'=>$XSIGCATEGCLI, 'SlcSigCompany'=>$XSIGCOMPANY, 'TabBusClientes'=>$XTABBUSCLIENTES);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

function retornar_msj($XINFO, $XTABLA, $msj, $color){
	$data_row = array('TxtLlegada'=>$XINFO[0], 'TxtAdultos'=>$XINFO[1], 'TxtNoches'=>$XINFO[2], 'TxtNinos'=>$XINFO[3], 'TxtSalida'=>$XINFO[4], 'TxtCantidad'=>$XINFO[5], 'tabinfo'=>$XINFO[11], 'TxtNumRes'=>$XINFO[12], 'tabhosp'=>$XTABLA, 'msj'=>$msj, 'color'=>$color);
	header('Content-Type: application/json');
	return json_encode($data_row);
}

if($opcion=='AdicionarHabitacion'){
	$XINFO = array('','','','','','');
	$XINFO[0]=$_POST['TxtLlegada'];
	$XINFO[2]=$_POST['TxtNoches'];
	$XINFO[4]=$_POST['TxtSalida'];
	$XNUMRES=$_POST['TxtNumRes'];

	$XNUMREGPRE=0;
	$XRSRES=$XOBJRES->total_prereservas($XINFOPRE[0]);
	$XTOTREGPRE=$XOBJRES->numero_filas($XRSRES);
	$XRSRES=$XOBJRES->buscar_prereservas($XINFOPRE[0],$XNUMREGPRE,1);
	$XROWRES=$XOBJRES->obtener_fila($XRSRES);
	$XTABRES=FncTabReservaPre($XLABEL, '', $XNUMREGPRE, $XTOTREGPRE);

	$XTABDETSERV=FncTabDetalleServ($XLABEL, '0', '0','0', '0');
	$XTABDETPAGOS=FncTabDetallePagos($XLABEL, '', '', '0','0');
	$XTABMEN=FncTabDetalleMenores($XLABEL, '', '', '');
		
	$data_row = array('TxtNumRes'=>$XNUMRES, 'TxtLlegada'=>$XINFO[0], 'TxtNoches'=>$XINFO[2], 'TxtSalida'=>$XINFO[4], 'TabDetServicios'=>$XTABDETSERV, 'TabDetPagos'=>$XTABDETPAGOS, 'TabDetMenores'=>$XTABMEN, 'TabResPre'=>$XTABRES);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='SeleccionMoneda'){
	$XSLCRESMON=$_POST['SlcResMon'];
	$XSLCRESVALTAR=$_POST['SlcResValTar'];
	$XSLCTIPOHAB=$_POST['SlcTipoHab'];
	$XOBJMON=new monedas;
	$XRSMON=$XOBJMON->buscar_monedas($XSLCRESMON);
	$XROWMON=$XOBJMON->obtener_fila($XRSMON);
	$XSELECT='<option value="'.$XSLCRESVALTAR.'">'.$XROWMON[2].' '.number_format($XSLCRESVALTAR).'</option>';
	$XOBJTAR=new tarifas;
	$XRSTAR=$XOBJTAR->ver_tarifas($XSLCTIPOHAB);
	$XROWTAR=$XOBJTAR->obtener_fila($XRSTAR);
	$XSELECT.='<option value="'.$XROWTAR[0].'">'.$XROWMON[2].' '.number_format($XROWTAR[0]).'</option>
	<option value="'.$XROWTAR[1].'">'.$XROWMON[2].' '.number_format($XROWTAR[1]).'</option>
	<option value="'.$XROWTAR[2].'">'.$XROWMON[2].' '.number_format($XROWTAR[2]).'</option>';
	
	$data_row = array('SlcResMon'=>$XSLCRESMON, 'SlcTipoHab'=>$XSLCTIPOHAB, 'SlcResValTar'=>$XSELECT, 'TxtResTipMon'=>$XROWMON[1]);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='SeleccionMonedas'){
	$XSLCRESMON=$_POST['SlcResMon'];
	$XSLCRESVALTAR=$_POST['SlcResValTar'];
	$XSLCTIPOHAB=$_POST['SlcTipoHab'];
	$XOBJMON=new monedas;
	$XRSMON=$XOBJMON->buscar_monedas($XSLCRESMON);
	$XROWMON=$XOBJMON->obtener_fila($XRSMON);
	$data_row = array('SlcResMon'=>$XSLCRESMON, 'TxtResTipMon'=>$XROWMON[1]);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

if($opcion=='GuardarConfirmar'){
	//CONFIRMAR RESERVA
	$XIDCLI=$_POST['TxtIdCli'];
	$XNUMRES=$_POST['TxtNumRes'];
	$XFECPAGO=$_POST['TxtFecPago'];
	$XIMPPAGO=$_POST['TxtImpPago'];
	$XMONPAGO=$_POST['SlcMonPago'];
	$XPAGTIPMON=$_POST['TxtPagTipMon'];
	$XTRMPAGO=$_POST['SlcTrmPago'];
	$XBASPAGO=$_POST['TxtBasPago'];
	$XIVAPAGO=$_POST['TxtIvaPago'];
	$XIDPAGO=$_POST['TxtIdPago'];
	$XDEPPAGO=$_POST['TxtDepPago'];
	$XRECPAGO=$_POST['TxtRecPago'];
	$XFACPAGO=$_POST['TxtFacPago'];
	$XBANPAGO=$_POST['TxtBanPago'];
	$XCUENPAGO=$_POST['TxtCuenPago'];
	$XREFPAGO=$_POST['TxtRefPago'];
	$XDESCPAGO=$_POST['TxtDescPago'];
	$XMETPAGO=$_POST['SlcMetPago'];
	$XTCPAGO=$_POST['TxtTcPago'];
	$XEXPMMPAGO=$_POST['TxtExpMMPago'];
	$XEXPAAPAGO=$_POST['TxtExpAAPago'];
	$XDIGPAGO=$_POST['TxtDigPago'];
	$XNOMPAGO=$_POST['TxtNomPago'];
	$XAPEPAGO=$_POST['TxtApePago'];
	$XAUTPAGO=$_POST['TxtAutPago'];
	$XFECAUT=$_POST['TxtFecAut'];
	$XNUMREGPAG=$_POST['TxtNumRegPag'];
	$XTOTREGPAG=$_POST['TxtTotRegPag'];
	$XESTRES=$_POST['SlcEstRes'];
	$XNUMABRES=$_POST['TxtNumAbRes'];

	if($XNUMABRES==""){
		$XRSCODIGO = $XOBJPAG->codigo_forma_pago();
		$XINFOSER[0]=$XOBJPAG->obtener_codigo($XRSCODIGO);
		$XINFOSER[1]=$XMETPAGO;
		$XINFOSER[2]=$XTCPAGO;
		$XINFOSER[3]=$XDIGPAGO;
		$XINFOSER[4]=$XCVPAGO;
		$XINFOSER[5]=$XEXPMMPAGO;
		$XINFOSER[6]=$XEXPAAPAGO;
		$XINFOSER[7]=$XNOMPAGO;
		$XINFOSER[8]=$XAPEPAGO;
		$XINFOSER[9]=$XIDCLI;
		$XINFOSER[10]='';
		$XRSPAG=$XOBJPAG->ingresar_forma_pago($XINFOSER);

		$XRSCODIGO = $XOBJPAG->codigo_abono_reserva();
		$XINFOABO[0]=$XOBJPAG->obtener_codigo($XRSCODIGO);
		$XINFOABO[1]=$XINFOSER[0];
		$XINFOABO[2]=$XNUMRES;
		$XINFOABO[3]=$XMETPAGO;
		$XINFOABO[4]=$XIMPPAGO;
		$XINFOABO[5]=$XIDCLI;
		$XINFOABO[6]='';
		$XINFOABO[7]=$XMONPAGO;
		$XINFOABO[8]=$XDEPPAGO;
		$XINFOABO[9]=$XIDPAGO;
		$XINFOABO[10]=$XRECPAGO;
		$XINFOABO[11]=$XFACPAGO;
		$XINFOABO[12]=$XBANPAGO;
		$XINFOABO[13]=$XCUENPAGO;
		$XINFOABO[14]=$XREFPAGO;
		$XINFOABO[15]=$XBASPAGO;
		$XINFOABO[16]=$XIVAPAGO;
		$XINFOABO[17]=$XDESCPAGO;

		$XRSPAG=$XOBJPAG->ingresar_abono_reserva($XINFOABO);
		$XNUMABRES=$XINFOABO[0];

		$XRSRES=$XOBJRES->total_prereservas($XNUMRES);
		$XTOTREG=$XOBJRES->numero_filas($XRSRES);
		$VALORAB=$XIMPPAGO/$XTOTREG;
		$VALORBAS=ceil($VALORAB/1.16);
		$VALORIVA=$VALORAB-$VALORBAS;
	
		while($XROWRES=$XOBJRES->obtener_fila($XRSRES)){
			$XINFODIS[0]=$XNUMRES;
			$XINFODIS[1]=$XINFOABO[0];
			$XINFODIS[2]=$XROWRES[12];
			$XINFODIS[3]='';
			$XINFODIS[4]=$XROWRES[6];
			$XINFODIS[5]=$XMETPAGO;
			$XINFODIS[6]=$XIDCLI;
			$XINFODIS[7]='';
			$XINFODIS[8]=$VALORBAS;
			$XINFODIS[9]=$VALORIVA;
			$XRSPAG=$XOBJPAG->ingresar_distribucion_abonos($XINFODIS);
		}
		//INFORMACION DE PAGOS
		$XNUMREGPAG=0;
		$XRSTOT=$XOBJPAG->total_abonos_xreserva($XNUMRES);
		$XTOTREGPAG=$XOBJPAG->numero_filas($XRSTOT);
		$XRSPAG=$XOBJPAG->buscar_abonos_xreserva($XNUMRES,$XNUMREGPAG,1);
		$XROWPAG=$XOBJPAG->obtener_fila($XRSPAG);

		$XTABPAGOSCONF=FncTabPagosConf($XLABEL, $XROWPAG, $XNUMREGPAG, $XTOTREGPAG);
		$XRSRES=$XOBJRES->cambiar_estado_reserva($XNUMRES, $XESTRES);

		$data_row = array('TxtIdCli'=>$XIDCLI, 'TxtNumRes'=>$XNUMRES, 'TxtFecPago'=>$XFECPAGO, 'TxtImpPago'=>$XIMPPAGO, 'SlcMonPago'=>$XMONPAGO, 'TxtPagTipMon'=>$XPAGTIPMON, 'SlcTrmPago'=>$XTRMPAGO, 'TxtBasPago'=>$XBASPAGO, 'TxtIvaPago'=>$XIVAPAGO, 'TxtIdPago'=>$XIDPAGO, 'TxtDepPago'=>$XDEPPAGO, 'TxtRecPago'=>$XRECPAGO, 'TxtFacPago'=>$XFACPAGO, 'TxtBanPago'=>$XBANPAGO, 'TxtCuenPago'=>$XCUENPAGO, 'TxtRefPago'=>$XREFPAGO, 'TxtDescPago'=>$XDESCPAGO, 'SlcMetPago'=>$XMETPAGO, 'TxtTcPago'=>$XTCPAGO, 'TxtExpMMPago'=>$XEXPMMPAGO, 'TxtExpAAPago'=>$XEXPAAPAGO, 'TxtDigPago'=>$XDIGPAGO, 'TxtNomPago'=>$XNOMPAGO, 'TxtApePago'=>$XAPEPAGO, 'TxtAutPago'=>$XAUTPAGO, 'TxtFecAut'=>$XFECAUT, 'TxtNumRegPag'=>$XNUMREGPAG, 'TxtNumAbRes'=>$XNUMABRES, 'TxtTotRegPag'=>$XTOTREGPAG, 'TabPagosConf'=>$XTABPAGOSCONF);
		header('Content-Type: application/json');
		echo json_encode($data_row);
	}
	else{
		$XRSRES=$XOBJRES->cambiar_estado_reserva($XNUMRES, $XESTRES);
	}
}

if($opcion=='AdicionarAlerta'){
	$XNUMRES=$_POST['TxtNumRes'];
	$XALRHAB=$_POST['SlcAlrHab'];
	$XALRDEP=$_POST['SlcAlrDep'];
	$XALROBS=$_POST['TxtAlrObs'];
	
	$XINFOALR=array('','','','');
	$XINFOALR[0]=$XNUMRES;
	$XINFOALR[1]=$XALRHAB;
	$XINFOALR[2]=$XALRDEP;
	$XINFOALR[3]=$XALROBS;
	if($XALRDEP!="")
		$XINFOALR[4]='1';
	else
		$XINFOALR[4]='0';
	$XINFOALR[5]='';
	$XOBJALR=new alertas;
	$XRSALR=$XOBJALR->ingresar_alertas($XINFOALR);
	$XTABDETALER=FncTabDetalleAlertas($XLABEL, $XNUMRES);
	$data_row = array('TabDetAlertas'=>$XTABDETALER);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}

//PAGOS

if($opcion=='AdicionarPago'){
	$XMET=$_POST['SlcMetStay'];
	$XIDPAGO=$_POST['TxtIdPago'];
	$XFECHA=$_POST['TxtFecPago'];
	$XPORC=$_POST['TxtPorcPago'];
	$XVALOR=$_POST['TxtValorPago'];
	$XBASE=$_POST['TxtBasePago'];
	$XIVA=$_POST['TxtIvaPago'];
	$XTC=$_POST['TxtTcStay'];
	$XTIT=$_POST['TxtTitStay'];
	$XEXP=$_POST['TxtExpStay'];
	$XDIG=$_POST['TxtDigStay'];
	$XCOD=$_POST['TxtCodStay'];
	$XHOR=$_POST['TxtHorStay'];
	$XABONO=str_replace(',','',$_POST['TxtAbStay']);
	$XSALDO=str_replace(',','',$_POST['TxtSalStay']);
	$XIDCTA=$_POST['TxtIdCta'];
	$XCLIENTE=$_POST['TxtIdCli'];
	$XMON=$_POST['TxtMoneda'];
	$XFRAN=$_POST['SlcFranStay'];
	$XIMPORTE=str_replace(',','',$_POST['TxtImporte']);

	if($XABONO=="")$XABONO=0;
	if($XSALDO=="")$XSALDO=0;

	if($XIDPAGO==""){
		$XRSCOD = $XOBJPAG->codigo_abono_reserva();
		$XIDPAGO=$XOBJPAG->obtener_codigo($XRSCOD);
		$XFECHA=date('d-m-Y');
		$XRECIBO=retornar_codigo(10,$XIDPAGO);
		
		$XABONO+=$XVALOR;
			
		$XSALDO=$XIMPORTE-$XABONO;

		$XINFO=array($XIDPAGO, $XIDCTA, $XMET, $XVALOR, $XBASE, $XIVA, '0', $XCLIENTE,'', $XMON,'','', $XRECIBO,'','','','', $XSALDO, $XABONO, $XPORC);
		$XRSPAG=$XOBJPAG->ingresar_abono_reserva($XINFO);

		if($XMET=='4'){
			$XRSCOD = $XOBJPAG->codigo_forma_pago_reserva();
			$XIDFOR=$XOBJPAG->obtener_codigo($XRSCOD);
			$XINFOR=array($XIDFOR, $XMET, $XTC, $XDIG, $XCOD, $XEXP, '', $XTIT,'', $XCLIENTE,'', $XIDPAGO, $XFRAN);
			$XRSPAG=$XOBJPAG->ingresar_forma_pago_reserva($XINFOR);
		}

	}

	$XTABPAGOS=FncTabMetodoRes($XLABEL, $XMET, $XIDCTA, '1');
	$data_row = array('TabPagosRes'=>$XTABPAGOS, 'TxtIdPago'=>$XIDPAGO, 'TxtFecPago'=>$XFECHA, 'TxtAbStay'=>$XABONO, 'TxtSalStay'=>$XSALDO, 'SlcMetStay'=>$XMET);
//	$data_row = array('SlcHabStay'=>$XHAB);
	header('Content-Type: application/json');
	echo json_encode($data_row);
}


if($opcion=='VerPago'){
	$XIDCTA=$_POST['TxtIdCta'];
	$XPAGINA=$_POST['TxtPag'];

	$XOFFSET=(int) $XPAGINA;
	$XOFFSET--;
	if($XOFFSET>=0){

	$XOBJPAG=new pagos;
	$XRSPAG=$XOBJPAG->ver_pagos_xreserva($XIDCTA, $XOFFSET, 1);
	if($XOBJPAG->numero_filas($XRSPAG)!=0){
		$XROWPAG=$XOBJPAG->obtener_fila($XRSPAG);
		$XMET=$XROWPAG[2];		
		$XIDPAGO=$XROWPAG[0];		
		$XFECHA=cambiar_fecha($XROWPAG[3]);		
		$XVALOR=$XROWPAG[4];		
		$XBASE=$XROWPAG[5];		
		$XIVA=$XROWPAG[6];		
		$XCLIENTE=$XROWPAG[8];		
		$XPORC=$XROWPAG[22];		
		
		if($XMET=='00004'){
			$XRSCRE=$XOBJPAG->buscar_forma_pago_reserva($XIDPAGO);
			if($XOBJPAG->numero_filas($XRSCRE)!=0){
				$XROWCRE=$XOBJPAG->obtener_fila($XRSCRE);
				$XFRANQUICIA=$XROWCRE[14];
				$XTC=$XROWCRE[2];
				$XTITULAR=$XROWCRE[7];
				$XEXPIRA=$XROWCRE[5];
				$XDIGITO=$XROWCRE[3];
				$XCODAUT=$XROWCRE[15];
				$XHORA=cambiar_fecha($XROWCRE[16]);
			}
			else{
				$XFRANQUICIA='';
				$XTC='';
				$XTITULAR='';
				$XEXPIRA='';
				$XDIGITO='';
				$XCODAUT='';
				$XHORA='';
			}
		}
		else{
			$XFRANQUICIA='';
			$XTC='';
			$XTITULAR='';
			$XEXPIRA='';
			$XDIGITO='';
			$XCODAUT='';
			$XHORA='';
		}

		$XTABPAGOS=FncTabMetodoRes($XLABEL, $XMET, $XIDCTA, $XPAGINA);
		$data_row = array('TabPagosRes'=>$XTABPAGOS, 'SlcMetStay'=>$XMET, 'TxtIdPago'=>$XIDPAGO, 'TxtFecPago'=>$XFECHA, 'TxtPorcPago'=>$XPORC, 'TxtValorPago'=>$XVALOR, 'TxtBasePago'=>$XBASE, 'TxtIvasPago'=>$XIVA, 'SlcFranStay'=>$XFRANQUICIA, 'TxtTcStay'=>$XTC, 'TxtTcStay'=>$XTITULAR, 'TxtExpStay'=>$XEXPIRA, 'TxtDigStay'=>$XDIGITO, 'TxtCodStay'=>$XCODAUT, 'TxtHorStay'=>$XHORA);
		header('Content-Type: application/json');
		echo json_encode($data_row);
	
	}
	}
}


?>