function FncSelecHabDisp(i){
	$(document).ready(function() {
    	//set initial state.
//		alert(i);
   	    if ($('#ChkHabDisp'+i).is(':checked')) {
   	        $('#RowHabDisp'+i).css('background-color','#FF9');
       	}
		else{
   	        $('#RowHabDisp'+i).css('background-color','#fff');
		}
	});
}

function FncSelecHab2(i){
	//$(document).ready(function() {
    	//set initial state.
//		alert(i);
   	    if ($('#ChkHosp'+i).is(':checked')) {
   	        $('#RowHosp'+i).css('background-color','#66FF66');
   	        $('#TxtHab'+i).val('1');
       	}
		else{
   	        $('#RowHosp'+i).css('background-color','#fff');
   	        $('#TxtHab'+i).val('');
		}
	//});
}

function VerDetalleHabDisp(idhab){
	$(document).ready(function() {
	   	var idcli = $('#TxtIdCli').val();
	   	var numres = $('#TxtNumRes').val();
		var opc = 'VerDetalleHabDisp';
//		alert(numres);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtIdCli:idcli, TxtNumRes:numres, TxtIdHab:idhab, opcion:opc},function (data){
			$('#TxtIdCli').val(data.TxtIdCli);
			$('#TxtNumRes').val(data.TxtNumRes);
			$('#TabDetallesHabitacion').html(data.TabDetallesHabitacion);
			return false;
		},'json');
	});
}

function PrcBuscarReservas(){
	$(document).ready(function(){
		if($('#busqueda').css('display')=='none'){
			$('#busqueda').css('display','block');
			$('#buscar').css('display','none');
		}
		else{
			$('#busqueda').css('display','none');
			$('#buscar').css('display','block');
		}
	});
}

function FncBuscarBasCliente(){
	$(document).ready(function(){
		var opc='BuscarBasClientes';
	   	var idcli = $('#TxtBusIdCli').val();
	   	var nomcli = $('#TxtBusNomCli').val();
	   	var idter = $('#TxtBusIdTer').val();
	   	var nomter = $('#TxtbusNomTer').val();
		//alert(opc);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtBusIdCli:idcli, TxtBusNomCli:nomcli, TxtBusIdTer:idter, TxtBusNomTer:nomter, opcion:opc},function (data){
			$('#TxtBusIdCli').val(data.TxtBusIdCli);
			$('#TxtBusNomCli').val(data.TxtBusNomCli);
			$('#TxtBusIdTer').val(data.TxtBusIdTer);
			$('#TxtBusNomTer').val(data.TxtBusNomTer);
			$('#TabBusClientes').html(data.TabBusClientes);
			return false;
		},'json');
	});
}

function FncBuscarAvCliente(){
	$(document).ready(function(){
		var opc='BuscarAvClientes';
	   	var idcli = $('#TxtAvIdCli').val();
	   	var idvip = $('#TxtAvIdVip').val();
	   	var nomcli = $('#TxtAvEmpresa').val();
	   	var apecli = $('#TxtAvApeCli').val();
	   	var tipocli = $('#SlcAvTipoCli :selected').val();
	   	var segmcli = $('#SlcAvSegmCli :selected').val();
	   	var categcli = $('#SlcAvCategCli :selected').val();
	   	var company = $('#TxtAvCompany').val();
		alert(idcli);
	   	var sigidcli = $('#SlcIdCli :selected').val();
	   	var sigidvip = $('#SlcIdVip :selected').val();
	   	var signomcli = $('#SlcAvEmp :selected').val();
	   	var sigapecli = $('#SlcApeCli :selected').val();
	   	var sigtipocli = $('#SlcTipoCli :selected').val();
	   	var sigsegmcli = $('#SlcSegmCli :selected').val();
	   	var sigcategcli = $('#SlcCategCli :selected').val();
	   	var sigcompany = $('#SlcCompany :selected').val();
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtBusIdCli:idcli, TxtBusIdVip:idvip, TxtBusNomCli:nomcli, TxtBusApeCli:apecli, SlcBusTipoCli:tipocli, SlcBusSegmCli:segmcli, SlcBusCategCli:categcli, TxtBusComany:company, SlcSigIdCli:sigidcli, SlcSigIdVip:sigidvip, SlcSigNomCli:signomcli, SlcSigApeCli:sigapecli, SlcSigTipoCli:sigtipocli, SlcSigSegmCli:sigsegmcli, SlcSigCategCli:sigcategcli, SlcSigCompany:sigcompany, opcion:opc},function (data){
			$('#TxtAvIdCli').val(data.TxtBusIdCli);
			$('#TxtAvIdVip').val(data.TxtBusIdVip);
			$('#TxtAvEmpresa').val(data.TxtBusNomCli);
			$('#TxtAvApeCli').val(data.TxtBusApeCli);
			$('#SlcAvTipoCli').val(data.SlcBusTipoCli);
			$('#SlcAvSegmCli').val(data.SlcBusSegmCli);
			$('#SlcAvCategCli').val(data.SlcBusCategCli);
			$('#TxtAvCompany').val(data.TxtBusCompany);
			//SIGNOS
			$('#SlcIdCli').val(data.SlcSigIdCli);
			$('#SlcIdVip').val(data.SlcSigIdVip);
			$('#SlcAvEmp').val(data.SlcSigNomCli);
			$('#SlcApeCli').val(data.SlcSigApeCli);
			$('#SlcTipoCli').val(data.SlcSigTipoCli);
			$('#SlcSegmCli').val(data.SlcSigSegmCli);
			$('#SlcCategCli').val(data.SlcSigCategCli);
			$('#SlcCompany').val(data.SlcSigCompany);
			
			$('#TabBusClientes').html(data.TabBusClientes);
			return false;
		},'json');
	});
}

function FncVerServ(pagina){
	$(document).ready(function(){
		var opc='SiguienteServ';
	   	var idcli = $('#TxtIdCli').val();
	   	var numres = $('#TxtNumRes').val();
	   	var tipohab = $('#SlcTipoHab').val();
	   	var iddetres = $('#TxtIdDetRes').val();
	   	var numhab = $('#SlcNumHab :selected').val();
//		alert(totreg);
		if(idcli!=""){
			if(numreg<(totreg)){
				var toLoad= 'assets/gestion_reservas.php';
				$.post(toLoad,{TxtIdCli:idcli, TxtNumRes:numres, TxtIdDetRes:iddetres, TxtNumRegServ:pagina, SlcTipoHab:tipohab, SlcNumHab:numhab, opcion:opc},function (data){	
					$('#TxtIdCli').val(data.TxtIdCli);
					$('#TxtNumRes').val(data.TxtNumRes);
					$('#TxtIdDetRes').val(data.TxtIdDetRes);
					$('#SlcTipoHab').val(data.SlcTipoHab);
					$('#SlcNumHab').val(data.SlcNumHab);
					//$('#TabResCli').html(data.TabResCli);
					//$('#TabResPre').html(data.TabResPre);
					$('#TabDetServicios').html(data.TabDetServicios);
					return false;
				},'json');
			}
		}
		else{
			alert('Ingrese el ID del Cliente para Completar la Busqueda');
		}
	});
}

function FncVerPre(pagina){
	$(document).ready(function(){
		var opc='SiguientePre';
	   	var idcli = $('#TxtIdCli').val();
	   	var numres = $('#TxtNumRes').val();
//	   	var numreg = $('#TxtNumRegPre').val();
	//   	var totreg = $('#TxtTotRegPre').val();
	   	var iddetres = $('#TxtIdDetRes').val();
		//alert(pagina);
		if(idcli!=""){
			var toLoad= 'assets/gestion_reservas.php';
			$.post(toLoad,{TxtIdCli:idcli, TxtNumRes:numres, TxtIdDetRes:iddetres, TxtPag:pagina, opcion:opc},function (data){
				$('#TxtIdCli').val(data.TxtIdCli);
				$('#TxtNumRes').val(data.TxtNumRes);
				$('#TxtIdDetRes').val(data.TxtIdDetRes);
//					$('#TxtNumRegPre').val(data.TxtNumRegPre);
	//				$('#TxtTotRegPre').val(data.TxtTotRegPre);
					//$('#TabResCli').html(data.TabResCli);
				$('#TabResPre').html(data.TabResPre);
				$('#TabDetServicios').html(data.TabDetServicios);
	//			$('#TabDetPagos').html(data.TabDetPagos);
				$('#TabDetMenores').html(data.TabDetMenores);
				return false;
			},'json');
		}
		else{
			alert('Ingrese el ID del Cliente para Completar la Busqueda');
		}
	});
}

function FncVerDlgCliente(){
	$("#DlgCliente").dialog("open");
}

function FncBuscarCliente(idcli){
	$(document).ready(function(){
		var opc='BuscarCliente';
//	   	var idcli = $('#TxtIdCli').val();
	   	var numres = $('#TxtNumRes').val();
	   //	var numreg = $('#TxtNumRegPre').val();
	   	var iddetres = $('#TxtIdDetRes').val();
	   	//var totreg = $('#TxtTotRegPre').val();
	   	var tipohab = $('#SlcTipoHab :selected').val();
//alert(idcli);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtIdCli:idcli, TxtNumRes:numres, TxtIdDetRes:iddetres, SlcTipoHab:tipohab, opcion:opc},function (data){
			//alert(data.TxtIdCli);
			$('#TxtIdCli').val(data.TxtIdCli);
			$('#TxtNumRes').val(data.TxtNumRes);
			$('#TxtIdDetRes').val(data.TxtIdDetRes);
			//$('#TxtNumRegPre').val(data.TxtNumRegPre);
			$('#SlcTipoHab').val(data.SlcTipoHab);
			//$('#TxtTotRegPre').val(data.TxtTotRegPre);
			$('#TabResCli').html(data.TabResCli);
			/*$('#TabResPre').html(data.TabResPre);
			$('#TabDetServicios').html(data.TabDetServicios);
			$('#TabDetPagos').html(data.TabDetPagos);
			$('#TabClienteDisp').html(data.TabClienteDisp);
			$('#TabClienteAler').html(data.TabClienteAler);
			$('#TabHabitacionDisp').html(data.TabHabitacionDisp);
			$('#TabClienteConf').html(data.TabClienteConf);
			$('#TabDetMenores').html(data.TabDetMenores);
			$('#TabInfoRes').html(data.tabinfo);
			$('#TabInfoDisp').html(data.tabinfo);
			$('#TabInfoConf').html(data.tabinfo);
			$('#TabInfoAler').html(data.tabinfo);
			$('#TabPagosConf').html(data.TabPagosConf);*/
			$("#DlgCliente").dialog("close");
			return false;
		},'json');

	});
}

function PrcHospedaje(){
	$(document).ready(function(){
		location.href="?sec=modulos/reservas/gestion_reservas";
	});
}

function PrcClientes(){
	$(document).ready(function(){
	   	var numres = $('#TxtNumRes').val();
		location.href="?sec=modulos/ocupacion/gestion_clientes&registro="+numres;
	});
}

function PrcEncontrarReserva(reserva,statusid,numhab){
	location.href="checkin.php?reserva="+reserva+"&statusid="+statusid+"&numhab="+numhab;
}

function PrcEncontrarReservamodifica(reserva,statusid,numhab){
	location.href="checkinmodifica.php?reserva="+reserva+"&statusid="+statusid+"&numhab="+numhab;
}

function Prcmostrarcheckout(reserva,statusid,numhab){
	location.href="mostrar_checkout.php?reserva="+reserva+"&statusid="+statusid+"&numhab="+numhab;
}

function PrcCHECKOUT(nombre,cedula,numhab,idres){
 	window.open("checkout.php?nombre="+nombre+"&cedula="+cedula+"&numhab="+numhab+"&idres="+idres, "",
    "toolbar=0,location=0,status=0,resizable=0,width=600, height=400, scrollbars=YES");
}

function Prcconfirmarcheckout(nombre,idcust,item,total,totabonos,cedula,numhab,idres,idsale){
     var grantotal = $('#total').text();
     var iva = $('#num01').val();
     var descuento = $('#num02').val();
     var subtotal = $('#Subtot').text();
     var ivavalue = $('#taxValue').text();
   	var dtovalue = $('#RemiseValue').text();
   	var otcg = $('#otcg').val();
   	var otroitem =  $('#ItemsNum').text();
   	if (parseInt(item) < parseInt(otroitem) )
       item = otroitem;

    window.open("confirmacheckout.php?nombre="+nombre+"&idcust="+idcust+"&item="+item+"&total="+grantotal+"&totabonos="+totabonos
    +"&iva="+iva+"&descuento="+descuento+"&subtotal="+subtotal+"&ivavalue="+ivavalue+"&dtovalue="+dtovalue+"&idres="+idres
    +"&cedula="+cedula+"&numhab="+numhab+"&otcg="+otcg+"&idsale="+idsale
    ,
      "",
	 "toolbar=0,location=0,status=0,resizable=0,width=500, height=550, top=10, left=300, scrollbars=YES");
}

function printfactura(idres){
  window.open("printfactura.php?idres="+idres, "",
  "toolbar=0,location=0,status=0,resizable=0,width=500, height=550, top=10, left=300, scrollbars=YES");
}


function Prcingresaabono(idcheckin,cedula,numhab,nombre){

    window.open("ingresaabono.php?idres="+idcheckin+"&cedula="+cedula+"&numhab="+numhab+"&nombre="+nombre
    ,
      "",
	 "toolbar=0,location=0,status=0,resizable=0,width=500, height=500, top=300, left=300, scrollbars=YES");
}

function Prcenviar(enviar){
        var grantotal = $('#total').text();
        var iva = $('#iva').text();
        var descuento = $('#dto').text();
         var pago =  $('#pago').val();
         var nombre = $('#cliente').text();
         var metodopago = $('#metodopago').val();
         var subtotal = $('#subtotal').text();
         var abonos = $('#abonos').text();
         var idres = $('#idres').text();
         var idcust = $('#idcust').text();
          var item = $('#ItemsNum2').text();
          var numhab = $('#numhab').text();
           var cedula = $('#cedula').text();
          var creditcardnum = $('#CreditCardNum').val();
           var creditcardhold = $('#CreditCardHold').val();
            var otcg = $('#otcg').text();
           var idsale = $('#idsale').text();




        window.opener.close();
       	location.href="confirmacheckout.php?enviar="+enviar+"&total="+grantotal+"&iva="+iva
       	+"&descuento="+descuento+"&pago="+pago+"&nombre="+nombre+"&metodopago="+metodopago
       	+"&subtotal="+subtotal+"&abonos="+abonos+"&idres="+idres+"&idcust="+idcust+"&item="+item
       	+"&numhab="+numhab+"&cedula="+cedula+"&creditcardnum="+creditcardnum+"&creditcardhold="+creditcardhold
       	+"&otcg="+otcg+"&idsale="+idsale
           ;


}

function Prcenviarabono(enviar){
        var grantotal = $('#total').text();
         var pago =  $('#pago').val();
         var metodopago = $('#metodopago').val();
         var numhab = $('#numhab').text();
         var creditcardnum = $('#CreditCardNum').val();
         var creditcardhold = $('#CreditCardHold').val();
         var idsale = $('#idsale').text();
         var abonos = $('#abonos').text();
         var idres = $('#idres').text();


       	location.href="ingresaabono.php?enviar="+enviar+"&total="+grantotal
       	+"&pago="+pago+"&metodopago="+metodopago +"&abonos="+abonos+"&idres="+idres
        +"&numhab="+numhab+"&idsale="+idsale+"&creditcardnum="+creditcardnum+"&creditcardhold="+creditcardhold
           ;


}


function Prcprint(idreserva){
	window.open("printcheckinsoliari.php?idreserva="+idreserva, "",
    "toolbar=0,location=0,status=0,resizable=0,width=600, height=400, scrollbars=YES");

}

function PrcPAGOS(cedula,numhab){
	window.open("pagos/sales/", "toolbar=0,location=0,status=0,resizable=0,width=600, height=400, scrollbars=YES");
}



function calcDias(inicio, fin, dia){
	$(document).ready(function(){
		var f1 = $('#'+inicio).val();
		var f2 = $('#'+fin).val();
		var aFecha1 = f1.split('-'); 
 		var aFecha2 = f2.split('-'); 
 		var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]); 
 		var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]); 
 		var dif = fFecha2 - fFecha1;
 		var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
		$('#'+dia).val(dias);
	});
}

function PrcCalcularFecha(fecini, noches, fecfin){
	$(document).ready(function(){
//		alert(noches);
		var fecha=$('#'+fecini).val();
		var dias=$('#'+noches).val();
		var salida=FncSumarFechas(dias, fecha);
		$('#'+fecfin).val(salida);
	});
}

function FncBuscarHospedaje (){
	$(document).ready(function(){
		var opc='BuscarHospedaje';
		var registro = new Array();

	   	registro[0] = $('#TxtLlegada').val();
   		registro[1] = $('#TxtAdultos').val();
	   	registro[2] = $('#TxtNoches').val();
   		registro[3] = $('#TxtNinos').val();
	   	registro[4] = $('#TxtSalida').val();
   		registro[5] = $('#TxtCantidad').val();
//		alert(opc);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtLlegada:registro[0], TxtAdultos:registro[1], TxtNoches:registro[2], TxtNinos:registro[3], TxtSalida:registro[4], TxtCantidad:registro[5], opcion:opc},function (data){
			//alert(data.TxtLlegada);
			$('#TxtLlegada').val(data.TxtLlegada);
			$('#TxtAdultos').val(data.TxtAdultos);
			$('#TxtNoches').val(data.TxtNoches);
			$('#TxtNinos').val(data.TxtNinos);
			$('#TxtSalida').val(data.TxtSalida);
			$('#TxtCantidad').val(data.TxtCantidad);
			$('#tabhosp').html(data.tabhosp);
			$('#msj').removeClass();
			$('#msj').addClass(data.color);
			$('#msj').html(data.msj);
			return false;
		},'json');
	});
}

function FncAceptarHospedaje2 (){
	//$(document).ready(function(){
		var opc='AceptarHospedaje';
	//	colorearCampos();
//		enviarRegistros(opc);
//		alert(opc);
	var registro = new Array();
	var id_hab = new Array();
	var tipo_hab = new Array();
	var tarifa = new Array();
	var valtar = new Array();
	var numadl = new Array();
	var numnin = new Array();
   	registro[0] = $('#TxtLlegada').val();
   	registro[1] = $('#TxtAdultos').val();
   	registro[2] = $('#TxtNoches').val();
   	registro[3] = $('#TxtNinos').val();
   	registro[4] = $('#TxtSalida').val();
   	registro[5] = $('#TxtCantidad').val();

   	var lim = $('#HddFil').val();
	var k=0; 
	var valor_res=0;
	for(var i=0;i<=lim;i++){
		if($('#ChkHosp'+i).is(':checked')){
			id_hab[k]=$('#Hddhab'+i).val();
			tipo_hab[k]=$('#Hddtip'+i).val();
			tarifa[k]=$('#SlcTarifa'+i+' :selected').val();
			valtar[k]=$('#SlcTarifa'+i+' :selected').text();
		    valtar[k] = valtar[k].replace(/,/g,'');
			var valor_hab = valtar[k].split('$');
			numadl[k]=$('#Hddadl'+i).val();
			numnin[k]=$('#Hddnin'+i).val();
			valor_res+=parseInt(valor_hab[1]);
//			alert(valor_res);
			k++;
		}
	}
	registro[6]= id_hab.toString();
	registro[7]= tipo_hab.toString();
	registro[8]= tarifa.toString();
	registro[9]= numadl.toString();
	registro[11]= numnin.toString();
	registro[10]= valor_res;

	var toLoad= 'assets/gestion_reservas.php';
//	alert(registro[6]);
	$.post(toLoad,{TxtLlegada:registro[0], TxtAdultos:registro[1], TxtNoches:registro[2], TxtNinos:registro[3], TxtSalida:registro[4], TxtCantidad:registro[5], id_hab:registro[6], tipo_hab:registro[7], tarifa:registro[8], numadl:registro[9], numnin:registro[11], valor_res:registro[10], opcion:opc},function (data){
		alert(data.TxtNumRes);
		$('#TxtLlegada').val(data.TxtLlegada);
		$('#TxtAdultos').val(data.TxtAdultos);
		$('#TxtNoches').val(data.TxtNoches);
		$('#TxtNinos').val(data.TxtNinos);
		$('#TxtSalida').val(data.TxtSalida);
		$('#TxtCantidad').val(data.TxtCantidad);
		$('#TxtNumRes').val(data.TxtNumRes);
		$('#TxtNumRes2').val(data.TxtNumRes);
		$('#TxtNumRes3').val(data.TxtNumRes);
		$('#TxtNumRes4').val(data.TxtNumRes);
		$('#TxtNumRes5').val(data.TxtNumRes);
		$('#TxtIdDetRes').val(data.TxtIdDetRes);
		$('#tabhosp').html(data.tabhosp);
		$('#TabInfoRes').html(data.tabinfo);
		$('#TabInfoDisp').html(data.tabinfo);
		$('#TabInfoConf').html(data.tabinfo);
		$('#TabInfoAler').html(data.tabinfo);
		$('#TabResPre').html(data.TabResPre);
		$('#TabDetServicios').html(data.TabDetServicios);
		$('#TabDetPagos').html(data.TabDetPagos);
		$('#TabDetMenores').html(data.TabDetMenores);
		//OTROS
		$('#TabClienteDisp').html(data.TabClienteDisp);
		$('#TabHabitacionDisp').html(data.TabHabitacionDisp);
		$('#TabDatosRes').html(data.TabDatosRes);
		$('#TabClienteConf').html(data.TabClienteConf);
		$('#TabPagosRes').html(data.TabPagosRes);
		$('#TabClienteAler').html(data.TabClienteAler);

		$('#msj').removeClass();
		$('#msj').addClass(data.color);
		$('#msj').html(data.msj);
		$('#tabsHosp').tabs( "option", "active", 1 );
		return false;
	},'json');
	//});
}

function FncSeleccionServicio (){
	$(document).ready(function(){
		var opc='SelecServicio';
	   	var txtservicio = $('#SlcServicio :selected').val();
	   	var feclleg = $('#TxtResLleg').val();
	   	var fecsal = $('#TxtResSal').val();
	   	var tipohab = $('#SlcTipoHab :selected').val();
//		alert(fecsal);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{SlcServicio:txtservicio, TxtResLleg:feclleg, TxtResSal:fecsal, SlcTipoHab:tipohab, opcion:opc},function (data){
			$('#SlcServicio').val(data.SlcServicio);
			$('#TxtIdServ').val(data.TxtIdServ);
			$('#TxtTarServ').val(data.TxtTarServ);
			$('#TxtFecIniServ').val(data.TxtFecIniServ);
			$('#TxtFecFinServ').val(data.TxtFecFinServ);
			return false;
		},'json');
	});
}

function FncGuardarReserva (){
	$(document).ready(function(){
		var menores = new Array();
		var seqnum = new Array();
		var opc='GuardarReserva';
	   	var idcli = $('#TxtIdCli').val();
	   	var numres = $('#TxtNumRes').val();
	   	var iddetres = $('#TxtIdDetRes').val();
	   	var numhab = $('#SlcNumHab :selected').val();
	   	var valtar = $('#SlcResValTar :selected').val();
	   	var moneda = $('#SlcResMon :selected').val();

/*	   	var dcto = $('#TxtResDcto').val();
	   	var porcen = $('#TxtResPor').val();
	   	var oferta = $('#TxtResOfer').val();
	   	var dias = $('#TxtResDias').val();
	   	var razon = $('#TxtResRaz').val();
	   	var obs = $('#TxtResObs').val();*/

//MENORES
		var cantmen = $('#TxtResMen').val();
		for(var i=0;i<cantmen;i++){
			seqnum[i]=$('#TxtIdMen'+i).val();
			menores[i]=$('#SlcRanEdad'+i+' :selected').val();
		}
		var nummen= menores.toString();
		var idmen= seqnum.toString();
//		alert(fecsal);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtIdCli:idcli, TxtNumRes:numres, TxtIdDetRes:iddetres, TxtResMen:nummen, TxtIdMen:idmen, SlcNumHab:numhab, SlcResValTar:valtar, SlcResMon:moneda, opcion:opc},function (data){
			$('#TxtIdCli').val(data.TxtIdCli);
			$('#TxtNumRes').val(data.TxtNumRes);
			$('#TxtIdDetRes').val(data.TxtIdDetRes);

			alert('Los Cambios se Han Guardado Correctamente');
			return false;
		},'json');
	});
}

function FncGuardarReservaci (){
	$(document).ready(function(){
		var menores = new Array();
		var seqnum = new Array();
		var opc='GuardarReserva';
	   	var idcli = $('#TxtIdCli').val();
	   	var numres = $('#TxtNumRes').val();
	   	var iddetres = $('#TxtIdDetRes').val();
	   	var numhab = $('#SlcNumHab :selected').val();
	   	var valtar = $('#SlcResValTar :selected').val();
	   	var moneda = $('#SlcResMon :selected').val();

/*	   	var dcto = $('#TxtResDcto').val();
	   	var porcen = $('#TxtResPor').val();
	   	var oferta = $('#TxtResOfer').val();
	   	var dias = $('#TxtResDias').val();
	   	var razon = $('#TxtResRaz').val();
	   	var obs = $('#TxtResObs').val();*/

//MENORES
		var cantmen = $('#TxtResMen').val();
		for(var i=0;i<cantmen;i++){
			seqnum[i]=$('#TxtIdMen'+i).val();
			menores[i]=$('#SlcRanEdad'+i+' :selected').val();
		}
		var nummen= menores.toString();
		var idmen= seqnum.toString();
//		alert(fecsal);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtIdCli:idcli, TxtNumRes:numres, TxtIdDetRes:iddetres, TxtResMen:nummen, TxtIdMen:idmen, SlcNumHab:numhab, SlcResValTar:valtar, SlcResMon:moneda, opcion:opc},function (data){
			$('#TxtIdCli').val(data.TxtIdCli);
			$('#TxtNumRes').val(data.TxtNumRes);
			$('#TxtIdDetRes').val(data.TxtIdDetRes);

			alert('Los Cambios se Han Guardado Correctamente');
			return false;
		},'json');
	});
}

function FncAdicionarServicio (pagina){
	$(document).ready(function(){
		var opc='AdicionarServicio';
	   	var idservicio = $('#TxtIdServ').val();
	   	var txtservicio = $('#SlcServicio :selected').val();
	   	var tarifaserv = $('#TxtTarServ').val();
	   	var cantidad = $('#TxtCanServ').val();
	   	var feclleg = $('#TxtFecIniServ').val();
	   	var fecsal = $('#TxtFecFinServ').val();
	   	var tipohab = $('#SlcTipoHab :selected').val();
	   	var numres = $('#TxtNumRes').val();
	   	var iddetres = $('#TxtIdDetRes').val();
	   	var numhab = $('#SlcNumHab :selected').val();
//		alert(iddetres);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{SlcServicio:txtservicio, TxtFecIniServ:feclleg, TxtFecFinServ:fecsal, SlcTipoHab:tipohab, TxtIdServ:idservicio, TxtTarServ:tarifaserv, TxtCanServ:cantidad, TxtNumRes:numres, TxtIdDetRes:iddetres, TxtNumRegServ:pagina, SlcNumHab:numhab, opcion:opc},function (data){
			$('#TabDetServicios').html(data.TabDetServicios);
			return false;
		},'json');
	});
}

function enviarRegistros(opc){
	alert(opc);
	var registro = new Array();
	var id_hab = new Array();
	var tipo_hab = new Array();
	var tarifa = new Array();
	var valtar = new Array();
	var numadl = new Array();
	var numnin = new Array();
   	registro[0] = $('#TxtLlegada').val();
   	registro[1] = $('#TxtAdultos').val();
   	registro[2] = $('#TxtNoches').val();
   	registro[3] = $('#TxtNinos').val();
   	registro[4] = $('#TxtSalida').val();
   	registro[5] = $('#TxtCantidad').val();

   	var lim = $('#HddFil').val();
	var k=0; 
	var valor_res=0;
	for(var i=0;i<=lim;i++){
		if($('#ChkHosp'+i).is(':checked')){
			id_hab[k]=$('#Hddhab'+i).val();
			tipo_hab[k]=$('#Hddtip'+i).val();
			tarifa[k]=$('#SlcTarifa'+i+' :selected').val();
			valtar[k]=$('#SlcTarifa'+i+' :selected').text();
		    valtar[k] = valtar[k].replace(/,/g,'');
			numadl[k]=$('#Hddadl'+i).val();
			numnin[k]=$('#Hddnin'+i).val();
			valor_res+=parseInt(valtar[k]);
			//alert(numnin[k]);
			k++;
		}
	}
	registro[6]= id_hab.toString();
	registro[7]= tipo_hab.toString();
	registro[8]= tarifa.toString();
	registro[9]= numadl.toString();
	registro[11]= numnin.toString();
	registro[10]= valor_res;

	var toLoad= 'assets/gestion_reservas.php';
	//alert(registro[6]);
	$.post(toLoad,{TxtLlegada:registro[0], TxtAdultos:registro[1], TxtNoches:registro[2], TxtNinos:registro[3], TxtSalida:registro[4], TxtCantidad:registro[5], id_hab:registro[6], tipo_hab:registro[7], tarifa:registro[8], numadl:registro[9], numnin:registro[11], valor_res:registro[10], opcion:opc},function (data){
//		alert(data.TxtNumRes);
		$('#TxtLlegada').val(data.TxtLlegada);
		$('#TxtAdultos').val(data.TxtAdultos);
		$('#TxtNoches').val(data.TxtNoches);
		$('#TxtNinos').val(data.TxtNinos);
		$('#TxtSalida').val(data.TxtSalida);
		$('#TxtCantidad').val(data.TxtCantidad);
		$('#TxtNumRes').val(data.TxtNumRes);
		$('#TxtNumRes2').val(data.TxtNumRes);
		$('#TxtNumRes3').val(data.TxtNumRes);
		$('#TxtNumRes4').val(data.TxtNumRes);
		$('#TxtNumRes5').val(data.TxtNumRes);
		$('#TxtIdDetRes').val(data.TxtIdDetRes);
		$('#tabhosp').html(data.tabhosp);
		$('#TabInfoRes').html(data.tabinfo);
		$('#TabInfoDisp').html(data.tabinfo);
		$('#TabInfoConf').html(data.tabinfo);
		$('#TabInfoAler').html(data.tabinfo);
		$('#TabResPre').html(data.TabResPre);
		$('#TabDetServicios').html(data.TabDetServicios);
		$('#TabDetPagos').html(data.TabDetPagos);
		$('#TabDetMenores').html(data.TabDetMenores);
		$('#msj').removeClass();
		$('#msj').addClass(data.color);
		$('#msj').html(data.msj);
		return false;
	},'json');
}

function FncEliminarServicio(id, pagina){
	$(document).ready(function(){
	if(confirm('Esta Seguro de Eliminar este Servicio')){
		var opc='EliminarServ';
	   	var idcli = $('#TxtIdCli').val();
	   	var numres = $('#TxtNumRes').val();
	   	var tipohab = $('#SlcTipoHab').val();
	   	var iddetres = $('#TxtIdDetRes').val();
	   	var numhab = $('#SlcNumHab :selected').val();
		//alert(id);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtIdCli:idcli, TxtNumRes:numres, TxtIdDetRes:iddetres, TxtNumRegServ:pagina, SlcTipoHab:tipohab, opcion:opc, codserv:id, SlcNumHab:numhab},function (data){	
			$('#TxtIdCli').val(data.TxtIdCli);
			$('#TxtNumRes').val(data.TxtNumRes);
			$('#TxtIdDetRes').val(data.TxtIdDetRes);
			$('#SlcTipoHab').val(data.SlcTipoHab);
			$('#SlcNumHab').val(data.SlcNumHab);
			//$('#TabResCli').html(data.TabResCli);
			//$('#TabResPre').html(data.TabResPre);
			$('#TabDetServicios').html(data.TabDetServicios);
			return false;
		},'json');
	}
	});
}

function FncAdicionarAbono (){
	$(document).ready(function(){
		var opc='AdicionarAbono';
	   	var tipohab = $('#SlcTipoHab :selected').val();
	   	var idpago = $('#SlcPago :selected').val();
	   	var numtc = $('#TxtNumTc').val();
	   	var digito = $('#TxtDigito').val();
	   	var cv = $('#TxtCv').val();
	   	var mmexpira = $('#TxtmmExpira').val();
	   	var aaexpira = $('#TxtaaExpira').val();
	   	var nombre = $('#TxtNombre').val();
	   	var apellido = $('#TxtApellido').val();
	   	var servpago = $('#SlcServPago :selected').val();
	   	var numres = $('#TxtNumRes').val();
	   	var valpago = $('#TxtValPago').val();
	   	var numregabo = $('#TxtNumRegAbo').val();
	   	var totregabo = $('#TxtTotRegAbo').val();
	   	var idcli = $('#TxtIdCli').val();
	   	var iddetres = $('#TxtIdDetRes').val();
	   	var idmon = $('#SlcResMon :selected').val();
	   	var numhab = $('#SlcNumHab :selected').val();
//		alert(opc);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{SlcPago:idpago, TxtNumTc:numtc, TxtDigito:digito, SlcTipoHab:tipohab, TxtCv:cv, TxtmmExpira:mmexpira, TxtaaExpira:aaexpira, TxtNumRes:numres, TxtIdDetRes:iddetres, TxtNumRegAbo:numregabo, TxtTotRegAbo:totregabo, TxtValPago:valpago, TxtNombre:nombre, TxtApellido:apellido, SlcServPago:servpago, TxtIdCli:idcli, SlcResMon:idmon, SlcNumHab:numhab, opcion:opc},function (data){
			$('#TabDetPagos').html(data.TabDetPagos);
			return false;
		},'json');
	});
}

function FncEliminarAbono(id){
	$(document).ready(function(){
	if(confirm('Esta Seguro de Eliminar este Pago')){
		var opc='EliminarAbono';
	   	var idcli = $('#TxtIdCli').val();
	   	var numres = $('#TxtNumRes').val();
	   	var numreg = $('#TxtNumRegAbo').val();
	   	var totreg = $('#TxtTotRegAbo').val();
	   	var tipohab = $('#SlcTipoHab').val();
	   	var idserv = $('#TxtIdServ'+id).val();
	   	var idabono = $('#TxtIdAbono'+id).val();
	   	var idpagocli = $('#TxtIdPagoCli'+id).val();
	   	var iddetres = $('#TxtIdDetRes').val();
		//alert(id);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtIdCli:idcli, TxtNumRes:numres, TxtIdDetRes:iddetres, TxtNumRegAbo:numreg, TxtTotRegAbo:totreg, SlcTipoHab:tipohab, TxtIdServ:idserv, TxtIdAbono:idabono, TxtIdPagoCli:idpagocli, opcion:opc, codserv:id},function (data){	
			$('#TxtIdCli').val(data.TxtIdCli);
			$('#TxtNumRes').val(data.TxtNumRes);
			$('#TxtIdDetRes').val(data.TxtIdDetRes);
			$('#TxtNumRegAbo').val(data.TxtNumRegAbo);
			$('#TxtTotRegAbo').val(data.TxtTotRegAbo);
			$('#SlcTipoHab').val(data.SlcTipoHab);
			$('#SlcNumHab').val(data.SlcNumHab);
			//$('#TabResCli').html(data.TabResCli);
			//$('#TabResPre').html(data.TabResPre);
			$('#TabDetPagos').html(data.TabDetPagos);
			return false;
		},'json');
	}
	});
}

function FncAdicionarHabitacion (){
	$(document).ready(function(){
		var opc='AdicionarHabitacion';
		var registro = new Array();
   		registro[0] = $('#TxtLlegada').val();
   		registro[1] = $('#TxtNoches').val();
	   	registro[2] = $('#TxtSalida').val();
	   	registro[3] = $('#TxtNumRes').val();
	   	$('#TxtResAd').val('');
	   	$('#SlcTipoHab').val('');
	   	$('#TxtMaxOcup').val('');
	   	$('#TxtResNin').val('');
	   	$('#TxtResCodTar').val('');
	   	$('#TxtResTar').val('');
	   	$('#TxtResMon').val('');
	   	$('#TxtResDcto').val('');
	   	$('#TxtResPor').val('');
	   	$('#TxtResOfer').val('');
	   	$('#TxtResDias').val('');
	   	$('#TxtResRaz').val('');
	   	$('#TxtResObs').val('');
	   	$('#TxtIdDetRes').val('');
	   	$('#TxtResTipHab').val('');
	   	$('#SlcNumHab').val('');
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtLlegada:registro[0], TxtNoches:registro[1], TxtSalida:registro[2], TxtNumRes:registro[3], opcion:opc},function (data){
			$('#TxtLlegada').val(data.TxtLlegada);
			$('#TxtNoches').val(data.TxtNoches);
			$('#TxtSalida').val(data.TxtSalida);
			$('#TxtNumRes').val(data.TxtNumRes);
			$('#TabResPre').html(data.TabResPre);
			$('#TabDetServicios').html(data.TabDetServicios);
			$('#TabDetPagos').html(data.TabDetPagos);
			$('#TabDetMenores').html(data.TabDetMenores);
			return false;
		},'json');
	});
}

function FncEliminarHabitacion(){
	$(document).ready(function(){
	if(confirm('Esta Seguro de Eliminar esta Habitacion?')){
		var opc='EliminarHabitacion';
	   	var numres = $('#TxtNumRes').val();
	   	var iddetres = $('#TxtIdDetRes').val();
		//alert(id);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtNumRes:numres, TxtIdDetRes:iddetres, opcion:opc},function (data){	
			$('#TxtNumRes').val(data.TxtNumRes);
			$('#TxtIdDetRes').val(data.TxtIdDetRes);
			$('#TabResPre').html(data.TabResPre);
			$('#TabDetServicios').html(data.TabDetServicios);
			$('#TabDetPagos').html(data.TabDetPagos);
			$('#TabDetMenores').html(data.TabDetMenores);
			return false;
		},'json');
	}
	});
}

function FncSelecMoneda(){
	$(document).ready(function() {
		var opc='SeleccionMoneda';
	   	var idmon = $('#SlcResMon :selected').val();
	   	var tipohab = $('#SlcTipoHab :selected').val();
	   	var tarifa = $('#SlcResValTar :selected').val();
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{SlcResMon:idmon, SlcTipoHab:tipohab, SlcResValTar:tarifa, opcion:opc},function (data){	
			$('#SlcResMon').val(data.SlcResMon);
			$('#SlcTipoHab').val(data.SlcTipoHab);
			$('#TxtResTipMon').val(data.TxtResTipMon);
			$('#SlcResValTar').html(data.SlcResValTar);
			return false;
		},'json');
	});
}

function FncSeleccionMoneda(slcmon, resmon){
	$(document).ready(function() {
		var opc='SeleccionMonedas';
	   	var idmon = $('#'+slcmon+' :selected').val();
	   	var tipohab = $('#SlcTipoHab :selected').val();
	   	var tarifa = $('#SlcResValTar :selected').val();
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{SlcResMon:idmon, SlcTipoHab:tipohab, SlcResValTar:tarifa, opcion:opc},function (data){	
			$('#'+slcmon).val(data.SlcResMon);
			$('#SlcTipoHab').val(data.SlcTipoHab);
			$('#'+resmon).val(data.TxtResTipMon);
			$('#SlcResValTar').html(data.SlcResValTar);
			return false;
		},'json');
	});
}

function FncCalcImporte(){
	$(document).ready(function() {
	   	var importe = $('#TxtImpPago').val();
		var base=Math.round(parseInt(importe)/1.16);
		var iva=importe-base;
//		alert(importe);
		$('#TxtBasPago').val(base);
		$('#TxtIvaPago').val(iva);
	});
}

function FncGuardarDisp(){
	$(document).ready(function() {
		var id_hab = new Array();
		var tipo_hab = new Array();
		var tarifa = new Array();
		var opc = 'GuardarDisponibilidad';

	   	var numres = $('#TxtNumRes').val();
   		var moneda = $('#SlcResMon :selected').val();
	   	var lim = $('#TxtLimHabDisp').val();
// alert(numres);
		var k=0; 
		for(var i=0;i<=lim;i++){
			if($('#ChkHabDisp'+i).is(':checked')){
				id_hab[k]=$('#TxtNumHab'+i).val();
				tipo_hab[k]=$('#TxtTipoHab'+i).val();
				tarifa[k]=$('#TxtValTar'+i).val();
			//alert(numnin[k]);
				k++;
			}
		}
		var numhab = id_hab.toString();
		var tipohab = tipo_hab.toString();
		var valtar = tarifa.toString();

		var toLoad= 'assets/gestion_reservas.php';
//	alert(numhab);
		$.post(toLoad,{TxtNumRes:numres, SlcResMon:moneda, TxtNumHabDisp:numhab, TxtTipoHabDisp:tipohab, TxtValTarDisp:valtar, opcion:opc},function (data){
			$('#TxtNumRes').val(data.TxtNumRes);
			$('#SlcResMon').val(data.SlcResMon);
			$('#TabHabitacionDisp').html(data.TabHabitacionDisp);
			$('#tabsHosp').tabs( "option", "active", 2);
			return false;
		},'json');
	});
}

function FncGuardarConfirmar (){
	$(document).ready(function(){
		var opc='GuardarConfirmar';
	   	var idcli = $('#TxtIdCli').val();
	   	var numres = $('#TxtNumRes').val();
	   	var fecpago = $('#TxtFecPago').val();
	   	var importe = $('#TxtImpPago').val();
	   	var moneda = $('#SlcMonPago :selected').val();
	   	var resmon = $('#TxtPagTipMon').val();
	   	var trm = $('#SlcTrmPago :selected').val();
	   	var base = $('#TxtBasPago').val();
	   	var iva = $('#TxtIvaPago').val();
	   	var idpago = $('#TxtIdPago').val();
	   	var deposito = $('#TxtDepPago').val();
	   	var recibo = $('#TxtRecPago').val();
	   	var factura = $('#TxtFacPago').val();
	   	var banco = $('#TxtBanPago').val();
	   	var cuenta = $('#TxtCuenPago').val();
	   	var referencia = $('#TxtRefPago').val();
	   	var dcto = $('#TxtDescPago').val();
	   	var metodo = $('#SlcMetPago :selected').val();
	   	var tc = $('#TxtTcPago').val();
	   	var expmm = $('#TxtExpMMPago').val();
	   	var expaa = $('#TxtExpAAPago').val();
	   	var digito = $('#TxtDigPago').val();
	   	var nombre = $('#TxtNomPago').val();
	   	var apellido = $('#TxtApePago').val();
	   	var codaut = $('#TxtAutPago').val();
	   	var fecaut = $('#TxtFecAut').val();
	   	var numreg = $('#TxtNumRegPag').val();
	   	var totreg = $('#TxtTotRegPag').val();
	   	var estres = $('#SlcEstRes :selected').val();
	   	var numab = $('#TxtNumAbRes').val();

		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtIdCli:idcli, TxtNumRes:numres, TxtFecPago:fecpago, TxtImpPago:importe, SlcMonPago:moneda, TxtPagTipMon:resmon, SlcTrmPago:trm, TxtBasPago:base, TxtIvaPago:iva, TxtIdPago:idpago, TxtDepPago:deposito, TxtRecPago:recibo, TxtFacPago:factura, TxtBanPago:banco, TxtCuenPago:cuenta, TxtRefPago:referencia, TxtDescPago:dcto, SlcMetPago:metodo, TxtTcPago:tc, TxtExpMMPago:expmm, TxtExpAAPago:expaa, TxtDigPago:digito, TxtNomPago:nombre, TxtApePago:apellido, TxtAutPago:codaut, TxtFecAut:fecaut, TxtNumRegPag:numreg, TxtTotRegPag:totreg, SlcEstRes:estres, TxtNumAbRes:numab, opcion:opc},function (data){
			$('#TxtIdCli').val(data.TxtIdCli);
			$('#TxtNumRes').val(data.TxtNumRes);
			$('#TxtFecPago').val(data.TxtFecPago);
			$('#TxtImpPago').val(data.TxtImpPago);
			$('#SlcMonPago').val(data.SlcMonPago);
			$('#TxtPagTipMon').val(data.TxtPagTipMon);
			$('#SlcTrmPago').val(data.SlcTrmPago);
			$('#TxtBasPago').val(data.TxtBasPago);
			$('#TxtIvaPago').val(data.TxtIvaPago);
			$('#TxtIdPago').val(data.TxtIdPago);
			$('#TxtDepPago').val(data.TxtDepPago);
			$('#TxtRecPago').val(data.TxtRecPago);
			$('#TxtFacPago').val(data.TxtFacPago);
			$('#TxtBanPago').val(data.TxtBanPago);
			$('#TxtCuenPago').val(data.TxtCuenPago);
			$('#TxtRefPago').val(data.TxtRefPago);
			$('#TxtDescPago').val(data.TxtDescPago);
			$('#SlcMetPago').val(data.SlcMetPago);
			$('#TxtTcPago').val(data.TxtTcPago);
			$('#TxtExpMMPago').val(data.TxtExpMMPago);
			$('#TxtExpAAPago').val(data.TxtExpAAPago);
			$('#TxtDigPago').val(data.TxtDigPago);
			$('#TxtNomPago').val(data.TxtNomPago);
			$('#TxtApePago').val(data.TxtApePago);
			$('#TxtAutPago').val(data.TxtAutPago);
			$('#TxtFecAut').val(data.TxtFecAut);
			$('#TxtNumAbRes').val(data.TxtNumAbRes);
			$('#TxtNumRegPag').val(data.TxtNumRegPag);
			$('#TxtTotRegPag').val(data.TxtTotRegPag);
			
			$('#TabPagosConf').html(data.TabPagosConf);
			alert('Los Cambios se Han Guardado Correctamente');
			return false;
		},'json');
	});
}

function FncAdicionarAlertas (){
	$(document).ready(function(){
		var opc='AdicionarAlerta';
	   	var numres = $('#TxtNumRes').val();
	   	var numhab = $('#SlcAlrHab :selected').val();
	   	var numdep = $('#SlcAlrDep :selected').val();
	   	var obs = $('#TxtAlrObs').val();
		//alert(opc);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtNumRes:numres, SlcAlrHab:numhab, SlcAlrDep:numdep, TxtAlrObs:obs, opcion:opc},function (data){
			$('#TabDetAlertas').html(data.TabDetAlertas);
			return false;
		},'json');
	});
}

function FncValidarMedio (){
	$(document).ready(function(){
	   	var medio = parseInt($('#SlcMetStay :selected').val());
//		alert(medio);
//PSARA INFO
		var opc='SelecMetPag';
	   	var metodo = $('#SlcMetStay :selected').val();
	   	var idpago = $('#TxtIdPago').val();
	   	var fecha = $('#TxtFecPago').val();
	   	var prc = $('#TxtPorcPago').val();
	   	var valor = $('#TxtValorPago').val();
	   	var base = $('#TxtBasePago').val();
	   	var iva = $('#TxtIvasPago').val();
	   	var tc = $('#TxtTcStay').val();
	   	var titular = $('#TxtTitStay').val();
	   	var expira = $('#TxtExpStay').val();
	   	var digito = $('#TxtDigStay').val();
	   	var codigo = $('#TxtCodStay').val();
	   	var hora = $('#TxtHorStay').val();
	   	var idcta = $('#TxtNumRes3').val();
	   	var franquicia = $('#SlcFranStay :selected').val();
//		alert(numhab);
//MEDIOS
		if(medio==4){
			for(i=1;i<15;i++)
				$('#trtc'+i).css('display','block');
			$('#TxtTcStay').removeAttr('disabled');
			$('#TxtTitStay').removeAttr('disabled');
			$('#TxtExpStay').removeAttr('disabled');
			$('#TxtDigStay').removeAttr('disabled');
			$('#TxtCodStay').removeAttr('disabled');
			$('#TxtHorStay').removeAttr('disabled');
		}
		else{
			if((medio==1)||(medio==3)){
				for(i=1;i<15;i++)
					$('#trtc'+i).css('display','none');
	//			$('#trtc2').css('display','none');
				$('#TxtTcStay').attr('disabled','disabled');
				$('#TxtTitStay').attr('disabled','disabled');
				$('#TxtExpStay').attr('disabled','disabled');
				$('#TxtDigStay').attr('disabled','disabled');
				$('#TxtCodStay').attr('disabled','disabled');
				$('#TxtHorStay').attr('disabled','disabled');
			}
			else{
				if(medio==2){
					for(i=1;i<15;i++)
						$('#trtc'+i).css('display','none');
					$('#TxtTcStay').attr('disabled','disabled');
					$('#TxtTitStay').attr('disabled','disabled');
					$('#TxtExpStay').attr('disabled','disabled');
					$('#TxtDigStay').attr('disabled','disabled');
					$('#TxtCodStay').attr('disabled','disabled');
					$('#TxtHorStay').attr('disabled','disabled');
				}
			}
		}
//FIN MEDIOS
	});
}

function FncCalcPagoPrc(){
	$(document).ready(function(){
	    var prc = parseFloat($('#TxtPorcPago').val());
	    var valor = parseInt($('#TxtValorPago').val());
	    var ivap = $('#TxtIvaStay').val();
		ivap = '1.' + ivap;
	    var gtotal = $('#TxtSalStay').val();
	    gtotal = gtotal.replace(/,/g,'');
	    var siva = Math.round(gtotal/ivap);
		var iva = gtotal-siva;

		var ivas=0;
		var totales=0;
		//alert(iva);
		if(prc!=""){
			if(prc>100){
				alert('El Porcentaje NO puede ser Superior a 100');
				$('#TxtPorcPago').focus();
				return false;
			}
			else{
				totales=Math.round((gtotal*prc)/100);
				ivas=Math.round((iva*prc)/100);
			}
		}
		var base=parseInt(totales)-parseInt(ivas);
		$('#TxtValorPago').val(totales);
		$('#TxtBasePago').val(base);
		$('#TxtIvasPago').val(ivas);
		$('#TxtPorcPago').val(prc);
		
	});
}

function FncCalcPagoVal(){
	$(document).ready(function(){
	    var prc = parseFloat($('#TxtPorcPago').val());
	    var valor = parseInt($('#TxtValorPago').val());
	    var ivap = $('#TxtIvaStay').val();
		ivap = '1.' + ivap;
	    var gtotal = $('#TxtSalStay').val();
	    gtotal = gtotal.replace(/,/g,'');
	    var siva = Math.round(gtotal/ivap);
		var iva = gtotal-siva;
		
	    var gtotal = $('#TxtSalStay').val();
	    gtotal = gtotal.replace(/,/g,'');
		var ivas=0;
		var totales=0;
		if(valor!=""){		
			if(valor>gtotal){
				alert('El Valor a Pagar NO puede ser Superior al Total de Consumo');
				$('#TxtValorPago').focus();
				return false;
			}
			else{
				totales=valor;
				prc= Math.round((valor*100)/gtotal);
				ivas=Math.round((iva*prc)/100);
			}
		}
		var base=parseInt(totales)-parseInt(ivas);
		$('#TxtValorPago').val(totales);
		$('#TxtBasePago').val(base);
		$('#TxtIvasPago').val(ivas);
		$('#TxtPorcPago').val(prc);
		
	});
}

function FncPaginaPagos (pagina){
	$(document).ready(function(){
		var opc='Paginacion';
	   	var ambiente = $('#TxtNumRes3').val();
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtAmbiente:ambiente, TxtPagina:pagina, opcion:opc},function (data){
			$('#TabDetalleCons').html(data.TabDetalleCons);
			return false;
		},'json');
	});
}

function FncAdicionarPagos (){
	$(document).ready(function(){
		var opc='AdicionarPago';
	   	var metodo = $('#SlcMetStay :selected').val();
	   	var moneda = $('#SlcMonStay :selected').val();
	   	var idpago = $('#TxtIdPago').val();
	   	var fecha = $('#TxtFecPago').val();
	   	var prc = $('#TxtPorcPago').val();
	   	var valor = $('#TxtValorPago').val();
		valor = valor.replace(/,/g,'');
		valor = parseInt(valor);
	   	var base = $('#TxtBasePago').val();
	   	var iva = $('#TxtIvasPago').val();
	   	var tc = $('#TxtTcStay').val();
	   	var titular = $('#TxtTitStay').val();
	   	var expira = $('#TxtExpStay').val();
	   	var digito = $('#TxtDigStay').val();
	   	var codigo = $('#TxtCodStay').val();
	   	var hora = $('#TxtHorStay').val();
	   	var abono = $('#TxtAbStay').val();
	   	var traslado = $('#TxtTrasStay').val();
	   	var saldo = $('#TxtSalStay').val();
		saldo = saldo.replace(/,/g,'');
		saldo = parseInt(saldo);
	   	var idcta = $('#TxtNumRes3').val();
	   	var cliente = $('#TxtIdCli').val();
	   	var importe = $('#TxtImpStay').val();
	   	var franquicia = $('#SlcFranStay :selected').val();
//		alert(saldo);
		if(idcta!=""){
		if(idpago==""){
			if(saldo>0){
				if(valor>0){
					if(valor<=saldo){
						var toLoad= 'assets/gestion_reservas.php';
						$.post(toLoad,{SlcMetStay:metodo, TxtIdPago:idpago, TxtFecPago:fecha, TxtPorcPago:prc, TxtValorPago:valor, TxtBasePago:base, TxtIvaPago:iva, TxtTcStay:tc, TxtTitStay:titular, TxtExpStay:expira, TxtDigStay:digito, TxtCodStay:codigo, TxtHorStay:hora, SlcFranStay:franquicia, TxtAbStay:abono, TxtSalStay:saldo, TxtIdCta:idcta, TxtIdCli:cliente, TxtMoneda:moneda, TxtImporte:importe, opcion:opc},function (data){
//							alert(data.SlcHabStay);
							$('#TabPagosRes').html(data.TabPagosRes);
							$('#TxtIdPago').val(data.TxtIdPago);
							$('#TxtFecPago').val(data.TxtFecPago);
							$('#TxtAbStay').val(data.TxtAbStay);
							$('#TxtSalStay').val(data.TxtSalStay);
							window.open("assets/imp_ingreso.php?idpago=" + data.TxtIdPago, "","toolbar=0,location=0,status=0,resizable=0,width=400, 	height=800, scrollbars=YES");	
							return false;
						},'json');
					}
					else{
						alert('El Valor a Pagar NO puede ser Superior al Saldo Pendiente');
					}
				}
				else{
					alert('El Valor a Pagar Debe Ser Superior a Cero');
				}
			}
			else{
				alert('No Puede Registrar Mas Pagos a Esta Cuenta');
			}
		}
		else{
			window.open("assets/imp_ingreso.php?idpago=" + idpago, "","toolbar=0,location=0,status=0,resizable=0,width=400, 	height=800, scrollbars=YES");
		}
		}
		else{
			alert('Registre Primero la Reserva para Procesar un Pago');
		}
	});
}

function FncVerPago (pagina){
	$(document).ready(function(){
		var opc='VerPago';
	   	var idcta = $('#TxtNumRes3').val();
//		alert(pagina);
		var toLoad= 'assets/gestion_reservas.php';
		$.post(toLoad,{TxtIdCta:idcta, TxtPag:pagina, opcion:opc},function (data){
	//		alert(data.SlcMetStay);
			$('#TabPagosRes').html(data.TabPagosRes);
			$('#SlcMetStay').val(data.SlcMetStay);
			$('#TxtIdPago').val(data.TxtIdPago);
			$('#TxtFecPago').val(data.TxtFecPago);
			$('#TxtPorcPago').val(data.TxtPorcPago);
			$('#TxtValorPago').val(data.TxtValorPago);
			$('#TxtBasePago').val(data.TxtBasePago);
			$('#TxtIvasPago').val(data.TxtIvasPago);
			$('#SlcFranStay').val(data.SlcFranStay);
			$('#TxtTcStay').val(data.TxtTcStay);
			$('#TxtTitStay').val(data.TxtTitStay);
			$('#TxtExpStay').val(data.TxtExpStay);
			$('#TxtDigStay').val(data.TxtDigStay);
			$('#TxtCodStay').val(data.TxtCodStay);
			$('#TxtHorStay').val(data.TxtHorStay);
			return false;
		},'json');
	});
}

function FncAdicionarStayPago (){
	$(document).ready(function(){
		$('#TxtIdPago').val('');
		$('#TxtFecPago').val('');
		$('#TxtPorcPago').val('');
		$('#TxtValorPago').val('');
		$('#TxtBasePago').val('');
		$('#TxtIvasPago').val('');
		$('#TxtTcStay').val('');
		$('#TxtTitStay').val('');
		$('#TxtExpStay').val('');
		$('#TxtDigStay').val('');
		$('#TxtCodStay').val('');
		$('#TxtHorStay').val('');
//		submit();
		return false;
	});
}
