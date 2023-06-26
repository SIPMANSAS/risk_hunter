<?php 
include_once("conexion.php"); 
include_once("utidatos.class.php"); 
class greservas extends utidatos{
//constructor    
	function greservas(){
		$this-> iniciarVariables()  ;               
	}  

	function ingresar_prereserva ($info){                
		if($this->con){ 
			$consulta="INSERT INTO tbl_reservas (setid, id_reserva, id_tercero, fecha_reserva, cant_noches, cant_adultos, cant_menores,
            cant_hab, valor_reserva, estado, ajapues, origen , valor_deposito, id_cliente, ultimo_oprid) VALUES
             ('$info[0]', '$info[1]', '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '$info[8]', '$info[9]', '0',
             '$info[10]', '$info[11]', '$info[12]', '$info[13]')";
      			return  $this->con->consulta($consulta);
		}        
	}

    	function buscar_checkout ($filtro){
		if($this->con){
			$consulta="select tbl_reservas.id_reserva, tbl_habitaciones.numero_hab, tbl_reservas.id_cliente,
            tbl_clientes.numero_documento, tbl_clientes.nombrecliente,
            tbl_det_reservas.id_habitacion, tbl_det_reservas.fecha_ini, tbl_det_reservas.fecha_fin ,
            tbl_det_reservas.placa , tbl_det_reservas.parqueadero,
            tbl_det_reservas.tipovehiculo ,
            tbl_det_reservas.cantidad, tbl_det_reservas.cant_adultos,
            tbl_det_reservas.cant_menores, tbl_reservas.cant_noches  , tbl_reservas.ultimo_oprid
             from tbl_reservas
            INNER JOIN tbl_det_reservas ON tbl_det_reservas.setid= tbl_reservas.setid and tbl_det_reservas.id_reserva = tbl_reservas.id_reserva
	        INNER JOIN tbl_clientes ON tbl_clientes.setid = tbl_reservas.setid and tbl_clientes.id_cliente = tbl_reservas.id_cliente
	        INNER JOIN tbl_habitaciones ON tbl_habitaciones.setid = tbl_det_reservas.setid and tbl_habitaciones.id_habitacion = tbl_det_reservas.id_habitacion
	        where $filtro
            order by tbl_det_reservas.fecha_fin asc
            ";

             return  $this->con->consulta($consulta);
		}
	}

    function ingresar_reserva_ajapues ($info){
		if($this->con){ 
			$consulta="INSERT INTO tbl_reservas (id_reserva, fecha_reserva, cant_noches, cant_adultos, cant_menores, cant_hab, valor_reserva, estado, adiciona_fecha, ultima_actualizacion, ajapues, origen, id_cliente, reserva_portal) VALUES ('$info[0]', '$info[1]', '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', now(), now(), '1', '$info[8]', '$info[9]', '$info[10]')";
			return  $this->con->consulta($consulta);  		
		}        
	}  

	function eliminar_reserva_ajapues (){                
		if($this->con){ 
			$consulta="DELETE FROM tbl_reservas WHERE ajapues='1'";
			return  $this->con->consulta($consulta);  		
		}        
	}  

	function eliminar_detalle_ajapues (){                
		if($this->con){ 
			$consulta="DELETE FROM tbl_det_reservas WHERE ajapues='1'";
			return  $this->con->consulta($consulta);  		
		}        
	}  

	function ingresar_detalle_prereserva ($info){                
		if($this->con){ 
			$consulta="INSERT INTO tbl_det_reservas (setid, id_reserva, fecha_ini, fecha_fin,
             idtipotarifa, cant_adultos, cant_menores, id_tipo_hab, id_habitacion, estado,
             cantidad, ajapues, parqueadero, tipovehiculo, placa, canal, asesor, note , desayuno, fecha_checkin) VALUES ('$info[0]', '$info[1]','$info[2]',
             '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '$info[8]', '$info[9]',
             '$info[10]', '0', '$info[11]','$info[12]','$info[13]','$info[14]','$info[15]', '$info[16]' , '$info[17]', '$info[18]')";
        		return  $this->con->consulta($consulta);
//			return $consulta;
		}        
	}  

    	function ingresar_detalle_abonos ($info){
		if($this->con){
			$consulta="INSERT INTO tbl_abonos_reservas (setid, id_reserva, seq_abono, id_tipo_pago, fecha_pago,
             valor_pago, moneda_cd, base_pago, impto_pago, id_cliente, id_tercero, saldo, valor_abono)
             VALUES ('$info[0]', '$info[1]','$info[2]', '$info[3]', now(), '$info[4]', 'COP', '$info[5]', '$info[6]', '$info[7]', '$info[8]', '$info[9]', '$info[10]')";

			return  $this->con->consulta($consulta);
//			return $consulta;
		}
	}

    function ingresar_sales ($info){
		if($this->con){
			$consulta="INSERT INTO zarest_sales (client_id, clientname, taxamount, subtotal, total, status, totalitems, paid,
            paidmethod, created_by, flaq, numdoc, numhab, idhab, created_at, bookingid, checkinid, discount, discountamount, tax, register_id, firstpayement, id)
             VALUES ('$info[0]', '$info[1]','$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '$info[8]', '$info[9]', '$info[10]', '$info[11]', '$info[12]', '$info[13]', '$info[14]' , '$info[15]','$info[16]', '$info[17]','$info[18]'
             ,'$info[19]','$info[20]', '$info[21]', '$info[22]')";

              $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);


           	return  $this->con->consulta($consulta);
//			return $consulta;
		}
	}
	
	function ingresar_sale_items ($info){
		if($this->con){
			$consulta="INSERT INTO zarest_sale_items (sale_id, product_id, name, price, qt, subtotal, date)
             VALUES ('$info[0]', '$info[1]','$info[2]', '$info[3]', '$info[4]', '$info[5]', now() )";

                 $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);


     	return  $this->con->consulta($consulta);
//			return $consulta;
		}
	}
	
	  function ingresar_posales ($info, $XI){
		if($this->con){
			$consulta="INSERT INTO zarest_posales (product_id, name, price, qt, status, register_id, number, table_id, time , sales_id, saleitem_id)
             VALUES ('$info[0]', '$info[1]','$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '$info[8]', '$info[9]','$info[10]')";

            return  $this->con->consulta($consulta);
//			return $consulta;
		}
	}
	
	 function ingresar_tercerosale($query){
		if($this->con){
			$consulta= $query;

           return  $this->con->consulta($consulta);
//			return $consulta;
		}
	}


	function ingresar_detalle_ajapues ($info){                
		if($this->con){ 
			$consulta="INSERT INTO tbl_det_reservas (id_reserva, fecha_ini, hora_ini, fecha_fin,
             hora_fin, idtipotarifa, cant_adultos, cant_menores, id_tipo_hab, id_habitacion, estado,
             adiciona_fecha, ultima_actualizacion, cantidad, ajapues) VALUES ('$info[0]', '$info[1]', now(), '$info[2]',
             now(), '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', 'bloqueada', now(), now(), '$info[8]', '1')";
			return  $this->con->consulta($consulta);  		
//			return $consulta;
		}        
	}  

	function buscar_prereservas ($numres){
		if($this->con){ 
			$consulta = "SELECT dt.* FROM calendar_details as dt WHERE dt.id='$numres' ";
			return  $this->con->consulta($consulta);  		
		}
	}

	function total_prereservas ($numres){
		if($this->con){ 
			$consulta = "SELECT tbl_det_reservas.fecha_ini, tbl_reservas.cant_noches, tbl_det_reservas.fecha_fin,
            tbl_reservas.cant_hab, tbl_reservas.cant_adultos, tbl_reservas.cant_menores, tbl_det_reservas.id_tipo_hab,
            tbl_tipo_hab.descripc, tbl_tipo_hab.max_ocupacion, tbl_reservas.valor_reserva, tbl_reservas.fecha_reserva,
            tbl_reservas.id_reserva, tbl_det_reservas.id_habitacion FROM tbl_reservas INNER JOIN (tbl_det_reservas INNER JOIN tbl_tipo_hab ON tbl_det_reservas.id_tipo_hab=tbl_tipo_hab.id_tipo_hab) ON tbl_reservas.id_reserva=tbl_det_reservas.id_reserva WHERE tbl_det_reservas.id_reserva='$numres' AND tbl_det_reservas.estado='bloqueada'";

    		//$consulta = "SELECT tbl_det_reservas.fecha_ini, tbl_reservas.cant_noches, tbl_det_reservas.fecha_fin, tbl_reservas.cant_hab, tbl_reservas.cant_adultos, tbl_reservas.cant_menores, tbl_det_reservas.id_tipo_hab, tbl_tipo_hab.descripc, tbl_tipo_hab.max_ocupacion, tbl_reservas.valor_reserva, tbl_reservas.fecha_reserva, tbl_reservas.id_reserva, tbl_det_reservas.id_habitacion FROM tbl_reservas INNER JOIN (tbl_det_reservas INNER JOIN (tbl_habitaciones INNER JOIN tbl_tipo_hab ON tbl_habitaciones.id_tipo_hab=tbl_tipo_hab.id_tipo_hab) ON tbl_det_reservas.id_tipo_hab=tbl_habitaciones.id_habitacion) ON tbl_reservas.id_reserva=tbl_det_reservas.id_reserva WHERE tbl_det_reservas.id_reserva='$numres' AND tbl_det_reservas.estado='bloqueada'";
			return  $this->con->consulta($consulta);  		
		}
	}

	function codigo_prereserva (){
		if($this->con){ 
			$consulta = "SELECT id_reserva, fecha_reserva FROM tbl_reservas ORDER BY id_reserva DESC";
			return  $this->con->consulta($consulta);  		
		}
	}

	function ver_prereserva_habitacion ($numero){                
		if($this->con){ 
			$consulta="SELECT id_reserva, fecha_ini, hora_ini, fecha_fin, hora_fin, tarifa, cant_adultos, cant_menores, id_habitacion FROM tbl_det_reservas WHERE seq_numero='$numero'";
			return  $this->con->consulta($consulta);  		
		}        
	}  

	function eliminar_prereserva ($numero){
		if($this->con){ 
			$consulta = "DELETE FROM tbl_det_reservas WHERE seq_numero='$numero'";
			return  $this->con->consulta($consulta);  		
		}
	}
       
	function buscar_hospedaje (){
		if($this->con){ 
			$consulta = "SELECT DISTINCT(tbl_habitaciones.id_habitacion), tbl_tipo_hab.descripc, tbl_tipo_hab.max_ocupacion, tbl_habitaciones.condiciones, tbl_tipo_hab.id_tipo_hab, tbl_habitaciones.descripc FROM (tbl_tipo_hab INNER JOIN tbl_habitaciones ON tbl_tipo_hab.id_tipo_hab=tbl_habitaciones.id_tipo_hab) WHERE tbl_habitaciones.estado='disponible' ORDER BY tbl_habitaciones.id_habitacion";
			return  $this->con->consulta($consulta);  		
		}
	}
	
		function buscar_hospedaje1 (){
		if($this->con){
			$consulta = "SELECT id,name FROM property_types";
			return  $this->con->consulta($consulta);
		}
	}
	
		function buscar_estadoreserva ($filtro){
		if($this->con){
			$consulta = "SELECT id, title_es , colorhex FROM property_blockstatuses $filtro";
			return  $this->con->consulta($consulta);
		}
	}
	
		function buscar_formapago (){
		if($this->con){
			$consulta = "SELECT * FROM tbl_tipo_pagos";
			return  $this->con->consulta($consulta);
		}
	}

	function ver_seleccion_habitaciones ($numres){
		if($this->con){ 
			$consulta = "SELECT DISTINCT(tbl_habitaciones.id_habitacion), tbl_det_reservas.id_tipo_hab,
            tbl_habitaciones.descripc, tbl_tipo_hab.max_ocupacion, tbl_tarifas.descripcion, tbl_tarifas.tarifa,
            tbl_det_reservas.fecha_ini, tbl_det_reservas.fecha_fin, tbl_det_reservas.cant_adultos, tbl_det_reservas.cant_menores,
            tbl_det_reservas.seq_numero, tbl_tipo_hab.descripc FROM tbl_reservas
            INNER JOIN ((tbl_det_reservas INNER JOIN
             (tbl_tipo_hab INNER JOIN tbl_habitaciones ON tbl_tipo_hab.id_tipo_hab=tbl_habitaciones.id_tipo_hab)
              ON tbl_det_reservas.id_tipo_hab=tbl_tipo_hab.id_tipo_hab) INNER JOIN tbl_tarifas
              ON tbl_det_reservas.idtipotarifa=tbl_tarifas.idtipotarifa)
               ON tbl_reservas.id_reserva=tbl_det_reservas.id_reserva
                WHERE tbl_det_reservas.id_reserva='$numres' AND tbl_det_reservas.estado='bloqueada'
                ORDER BY tbl_habitaciones.id_habitacion";
			return  $this->con->consulta($consulta);  		
		}
	}

	function ver_habitaciones_libres (){
		if($this->con){ 
			$consulta = "SELECT DISTINCT(tbl_habitaciones.id_habitacion), tbl_habitaciones.id_tipo_hab, tbl_habitaciones.descripc, tbl_tipo_hab.max_ocupacion, tbl_tarifas.descripcion, tbl_tarifas.tarifa, tbl_tipo_hab.descripc FROM ((tbl_tipo_hab INNER JOIN tbl_habitaciones ON tbl_tipo_hab.id_tipo_hab=tbl_habitaciones.id_tipo_hab) INNER JOIN tbl_tarifas ON tbl_tipo_hab.id_tipo_hab=tbl_tarifas.idtipohab)  WHERE tbl_habitaciones.estado='disponible' AND (tbl_tarifas.fechaini <= now() AND tbl_tarifas.fechafin >= now()) ORDER BY tbl_habitaciones.id_habitacion";
			return  $this->con->consulta($consulta);  		
		}
	}

	function buscar_reservas (){
		if($this->con){ 
			$consulta = "SELECT DISTINCT tbl_reservas.id_reserva, tbl_terceros.nombres, tbl_terceros.apellidos, tbl_terceros.id_segm_ter, tbl_det_reservas.id_tipo_pago, tbl_reservas.fecha_reserva, tbl_reservas.estado, prestilo.color_background FROM ((tbl_reservas INNER JOIN tbl_det_reservas ON tbl_reservas.id_reserva=tbl_det_reservas.id_reserva) INNER JOIN (tbl_clientes INNER JOIN tbl_terceros ON tbl_clientes.id_tercero=tbl_terceros.id_tercero) ON tbl_reservas.id_cliente=tbl_clientes.id_cliente) INNER JOIN prestilo ON tbl_reservas.estado=prestilo.estilo_nombre
            ORDER BY tbl_reservas.id_reserva desc";
			return  $this->con->consulta($consulta);  		
		}
	}
	
	function buscar_sales ($clientid,$numhab){
		if($this->con){
			$consulta = "SELECT zarest_sales.id, zarest_sales.total from zarest_sales where client_id = '$clientid' and paidmethod like '2~".$numhab."'";

        	return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_salescheckout ($clientid,$metpag){
		if($this->con){
			$consulta = " SELECT zarest_sale_items.sale_id, zarest_sale_items.product_id, zarest_sale_items.name, zarest_sale_items.price, zarest_sale_items.qt, zarest_sale_items.subtotal, zarest_sale_items.id from zarest_sales INNER JOIN zarest_sale_items ON zarest_sale_items.sale_id = zarest_sales.id
                          where client_id = '$clientid' and paidmethod = '$metpag' and flaq > 0";

         	return  $this->con->consulta($consulta);

        }
	}
	
	function buscar_salesitem ($id){
		if($this->con){
			$consulta = "SELECT id, product_id, name, price , qt, subtotal from zarest_sale_items where sale_id = '$id'";
        	return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_reservas_calendar ($filtros){
		if($this->con){
			$consulta = "SELECT cd.id, cd.ppttypeid, thab.name, cd.guestname, cd.status, cd.checkin, cd.checkout, cd.created,
			st.title_es, st.colorhex  from calendar_details cd INNER JOIN property_blockstatuses st ON st.id = cd.status
            INNER JOIN property_types thab ON thab.id = cd.ppttypeid
            where $filtros order by cd.created asc";
			return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_habcalendar ($pax){
		if($this->con){
			$consulta = "SELECT distinct(thab.id) , thab.name, tipohab.max_ocupacion, tipohab.id_tipo_hab , tipohab.rutaimg
            from property_types thab
            INNER JOIN tbl_habitaciones hab ON thab.id = hab.id_habitacion
            INNER JOIN tbl_tipo_hab tipohab ON tipohab.id_tipo_hab = hab.id_tipo_hab and tipohab.max_ocupacion >= '$pax'
             order by thab.name asc";

           	return  $this->con->consulta($consulta);
		}
	}
	
		function buscar_productos (){
		if($this->con){
			$consulta = "SELECT name, photo
            from zarest_products
             where category in ('Verduras','Frutas')";

           	return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_habcalendar1 ($pax){
		if($this->con){
			$consulta = "SELECT distinct(thab.id) , thab.name, tipohab.max_ocupacion, tipohab.id_tipo_hab , tipohab.rutaimg
            from property_types thab
            INNER JOIN tbl_habitaciones hab ON thab.id = hab.id_habitacion
            INNER JOIN tbl_tipo_hab tipohab ON tipohab.id_tipo_hab = hab.id_tipo_hab and tipohab.max_ocupacion = '$pax'
             order by thab.name asc";

           	return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_habocupada ($idhab,$entrada,$salida){
		if($this->con){
			$consulta = " SELECT  count(DISTINCT(calendar_data.id)) from calendar_details
            INNER JOIN calendar_data ON calendar_data.bookingid = calendar_details.id  and
            calendar_data.bookingdate >= '$entrada' and calendar_data.bookingdate <= '$salida'
            where calendar_details.status = '10' and calendar_details.ppttypeid = '$idhab'";
      //      $ddf = fopen('error.log','a');
       // fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
      // fclose($ddf);
           	return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_idhab ($numhab){
		if($this->con){
			$consulta = "SELECT thab.id
            from property_types thab
             INNER JOIN tbl_habitaciones hab ON thab.id = hab.id_habitacion
            where thab.name = '$numhab'";

     		return  $this->con->consulta($consulta);
		}
	}
	
		function buscar_numhab ($idhab){
		if($this->con){
			$consulta = "SELECT thab.name
            from property_types thab
             INNER JOIN tbl_habitaciones hab ON thab.id = hab.id_habitacion
            where thab.id = '$idhab'";
            
                  $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);


      		return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_tipotarifa ($pax, $fechaini){
		if($this->con){
			$consulta = "SELECT distinct(tarf.idtipotarifa), tarf.descripcion, tarf.tarifa, tarf.idtiposerv
            from property_types thab
            INNER JOIN tbl_habitaciones hab ON thab.id = hab.id_habitacion
            INNER JOIN tbl_tipo_hab tipohab ON tipohab.id_tipo_hab = hab.id_tipo_hab
            INNER JOIN tbl_tarifas tarf ON tarf.idtipohab = tipohab.id_tipo_hab
            where tipohab.max_ocupacion >= '$pax' and tarf.fechaini <= '$fechaini' and tarf.fechafin >= '$fechaini'
            ";

           	return  $this->con->consulta($consulta);
		}
	}
	
		function buscar_idtarifa ($idtarifa){
		if($this->con){
			$consulta = "SELECT idproducto, descripcion
            from tbl_tarifas
            where setid= '001' and idtipotarifa = '$idtarifa'";
           	return  $this->con->consulta($consulta);
		}
	}

    function buscar_referidopor (){
		if($this->con){
			$consulta = "SELECT id_tercero, nombres
            from tbl_terceros
            order by id_tercero asc
            ";
			return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_cedulater ($numced){
		if($this->con){
			$consulta = "SELECT numdoc, id_tercero
            from tbl_terceros  where numdoc = '$numced'  ";
     		return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_canal ($setid, $idcanal){
		if($this->con){
			$consulta = "SELECT idcanal, nombre
            from tbl_canales where setid like '%$setid%'
            and idcanal like '%$idcanal%'
             order by sort asc
            ";
			return  $this->con->consulta($consulta);
		}
	}
	
	 function buscar_asesor ($setid,$asesor){
		if($this->con){
			$consulta = "SELECT *
            from tbl_asesores where setid like '%$setid%' and idasesor like '%$asesor%'
            order by idasesor asc
            ";
			return  $this->con->consulta($consulta);
		}
	}

     function buscar_referidoreserva ($setid,$idtercero){
		if($this->con){
			$consulta = "SELECT tbl_clientes.id_referidopor, tbl_clientes.id_asesor from calendar_details
            INNER JOIN tbl_clientes ON calendar_details.id_tercero = tbl_clientes.id_tercero and
            calendar_details.setid = tbl_clientes.setid
            where calendar_details.setid = '$setid' and calendar_details.id_tercero = '$idtercero'

            ";
			return  $this->con->consulta($consulta);
		}
	}



	function actualizar_reservas ($idcli, $numres){
		if($this->con){ 
			$consulta = "UPDATE tbl_reservas SET id_cliente='$idcli' WHERE tbl_reservas.id_reserva='$numres'";
			return  $this->con->consulta($consulta);  		
		}
	}

	function actualizar_reserva_habitacion ($tarifa, $moneda, $numres, $idhab){
		if($this->con){ 
			$consulta = "UPDATE tbl_det_reservas SET idtipotarifa='$tarifa', moneda_cd='$moneda' WHERE id_reserva='$numres' AND id_habitacion='$idhab'";
			return  $this->con->consulta($consulta);  		
		}
	}
	
	function actualiza_reserva ($idreserva, $cedula, $estadores, $setid, $idtercero, $idhab){
		if($this->con){
			$consulta = "UPDATE calendar_details SET cedula ='$cedula', status='$estadores', setid='$setid' ,
            id_tercero= '$idtercero', ppttypeid='$idhab' WHERE id='$idreserva' ";
           return  $this->con->consulta($consulta);
		}
	}
	
		function actualiza_reservadata ($idreserva, $estadores){
		if($this->con){
			$consulta = "UPDATE calendar_data SET status='$estadores' WHERE bookingid='$idreserva' ";
             return  $this->con->consulta($consulta);
		}
	}
	
		function actualiza_reservasale ($idreserva, $estadores){
		if($this->con){
			$consulta = "UPDATE calendar_data SET status='$estadores'
             WHERE bookingid='$idreserva' ";
     return  $this->con->consulta($consulta);
		}
	}
	
		function actualiza_calendardetsale ($idreserva, $estadores){
		if($this->con){
			$consulta = "UPDATE calendar_details SET status='$estadores'
             WHERE id='$idreserva' ";

             return  $this->con->consulta($consulta);
		}
	}
	
		function actualiza_checkinsale($idreserva, $estadores){
		if($this->con){
			$consulta = "UPDATE tbl_reservas SET estado='$estadores'
             WHERE setid = '001' and id_reserva = '$idreserva' ";

              return  $this->con->consulta($consulta);
		}
	}
	
		function actualiza_hold ($idhold,$parametros){
		if($this->con){
			$consulta = "UPDATE zarest_holds SET $parametros where id = '$idhold' ";
            return  $this->con->consulta($consulta);
		}
	}
	
		function actualiza_checkin($campos, $idreserva){
		if($this->con){
			$consulta = "UPDATE tbl_reservas SET $campos
             WHERE setid = '001' and id_reserva = '$idreserva' ";
                                          $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);



            return  $this->con->consulta($consulta);
		}
	}
	
		function actualiza_detreserva($campos, $idreserva){
		if($this->con){
			$consulta = "UPDATE tbl_det_reservas SET $campos
             WHERE setid = '001' and id_reserva = '$idreserva' ";

            return  $this->con->consulta($consulta);
		}
	}


//CAMBIAR DE ESTADOS

	function cambiar_estado_detalle ($numres, $idhab, $estado){
		if($this->con){ 
			$consulta = "UPDATE tbl_det_reservas SET estado='$estado' WHERE id_reserva='$numres' AND id_habitacion='$idhab'";
			return  $this->con->consulta($consulta);
		}
	}

	function cambiar_estado_reserva ($numres, $estado){
		if($this->con){ 
			$consulta = "UPDATE tbl_reservas SET estado='$estado' WHERE id_reserva='$numres'";
			return  $this->con->consulta($consulta);  		
		}
	}

//REGISTRO DE MENORES DE EDAD
	function ingresar_menores ($info){                
		if($this->con){ 
			$consulta="INSERT INTO tbl_edad_menores (id_reserva, id_habitacion, adiciona_fecha, ultima_actualizacion) VALUES ('$info[0]', '$info[7]', now(), now())";
			return  $this->con->consulta($consulta);  		
		}        
	}  

	function actualizar_menores ($edad, $numero){
		if($this->con){ 
			$consulta = "UPDATE tbl_edad_menores SET rango_edad='$edad' WHERE seq_numero='$numero'";
			return  $this->con->consulta($consulta);  		
		}
	}

	function ver_menores ($numres, $idhab){
		if($this->con){ 
			$consulta = "SELECT rango_edad, seq_numero FROM tbl_edad_menores WHERE id_reserva='$numres' AND id_habitacion='$idhab' ORDER BY seq_numero";
			return  $this->con->consulta($consulta);  		
		}
	}

    	 function FncBuscarSequencia ($XSELECT){
		if($this->con){
            $consulta = $XSELECT;

        	return  $this->con->consulta($consulta);
		}
	}
	
 	function ingresar_tercero ($info){
		if($this->con){
			$consulta="INSERT INTO tbl_terceros (setid,id_tercero,numdoc,nombres,email,celular,pais_res) VALUES ('$info[0]','$info[1]','$info[2]', '$info[3]' , '$info[4]', '$info[5]', '$info[6]')";

          return  $this->con->consulta($consulta);

    	}
	}

    function ingresar_persona ($info){
		if($this->con){
			$consulta="INSERT INTO tbl_person (idperson, idtercero, lenguaje, setid ) VALUES ('$info[0]', '$info[1]','$info[2]', '$info[3]')";
           	return  $this->con->consulta($consulta);
		}
	}

	 function ingresar_cliente ($info){
		if($this->con){
			$consulta="INSERT INTO tbl_clientes (setid, id_cliente, id_tercero, id_asesor, id_referidopor, numero_documento, nombrecliente, email, telefono, pais ) VALUES ('$info[0]', '$info[1]','$info[2]', '$info[3]' , '$info[4]' , '$info[5]' , '$info[6]' , '$info[7]', '$info[8]', '$info[9]')";

            	return  $this->con->consulta($consulta);
		}
	}

	function ingresar_prcliente_cm ($info){
		if($this->con){
			$consulta="INSERT INTO prcliente_cm (cm_id, cm_idtipo, descripcion, descripcorta, email_addr,telefono) VALUES ('$info[0]', '$info[1]','$info[2]', '$info[3]', '$info[4]', '$info[5]')";
                        return  $this->con->consulta($consulta);
		}
    }

   	function ingresar_prcliente_metpago ($info){
		if($this->con){
			$consulta="INSERT INTO prcliente_metodopago (idtipopago, mp_idtipo,descripcion, descripcorta, tarjeta_crd_tipo, tarjeta_crd_numero,tarjeta_crd_apellido, tarjeta_crd_nombre,tarjeta_crd_nombre_exacto,tarjeta_crd_exp_mes, tarjeta_crd_exp_anno, tarjeta_crd_digito_verif , tarjeta_crd_cvv) VALUES ('$info[0]', '$info[1]','$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]','$info[7]','$info[8]', '$info[9]','$info[10]','$info[11]', '$info[12]')";
           	return  $this->con->consulta($consulta);
		}
    }

   	function ingresar_prcliente_tercero_cm ($info){
		if($this->con){
			$consulta="INSERT INTO prcliente_tercero_cm (idtercero,profile_cm_seq,cm_inicio_dt,cm_proposito_idtipo,cm_id,cm_idtipo) VALUES ('$info[0]', '$info[1]','$info[2]', '$info[3]', '$info[4]', '$info[5]')";
                         return  $this->con->consulta($consulta);
		}
    }

   	function ingresar_prcliente_tercero_metpago ($info){
		if($this->con){
			$consulta="INSERT INTO prcliente_tercero_metpago (idtercero,profile_metpago_seq,metpago_inicio_dt, metpago_prop_idtipo,idtipopago,metpago_idtipo) VALUES ('$info[0]', '$info[1]','$info[2]', '$info[3]', '$info[4]', '$info[5]')";
           	return  $this->con->consulta($consulta);
		}
    }

    function ingresar_role ($info){
		if($this->con){
			$consulta="INSERT INTO prcliente_role(idtercero,idroletipo,role_inicio_dt,role_fin_dt) VALUES ('$info[0]', '$info[1]','$info[2]', '')";
                        return  $this->con->consulta($consulta);
		}
	}
	
	// Formas de Pago
	
		function ingresar_forma_pago ($info){
		if($this->con){
			$consulta = "INSERT INTO tbl_forma_pago_cliente
            (setid,id_tercero, seq_numero, id_cliente, num_tarjeta, nombre,
             mm_expira, aa_expira, dig_verifica, cv_num, adiciona_fecha, ultima_actualizacion,
             id_cuenta, id_ambiente, tipo_tarjeta, fecha_aut, id_tipo_pago, idreserva) VALUES ('$info[0]', '$info[1]',
             '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '', '', now(), now(), '','','', now(), '$info[8]','$info[9]')";
        	return  $this->con->consulta($consulta);
		}
	}
	
	// ingresar en calendar_data
	
		function ingresar_calendardata ($info){
		if($this->con){
			$consulta = "INSERT INTO calendar_data
            ( bookingid, daypart, bookingdate, status) VALUES ('$info[0]', '$info[1]',
             '$info[2]', '$info[3]')";
             

                                    $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);



        	return  $this->con->consulta($consulta);
		}
		}
		
		function ingresar_calendardetails ($info){
		if($this->con){
			$consulta = "INSERT INTO calendar_details
            ( id, userid, ppttypeid, checkin, checkout, status, guestname, guestemail, guestphone, guestcountry, guestadult,
            guestchild, note_en, amount, deposit, balancedue, impuestos, cedula, setid, id_tercero, idcheckin) VALUES ('$info[0]', '$info[1]',
             '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '$info[8]', '$info[9]', '$info[10]',
             '$info[11]', '$info[12]', '$info[13]', '$info[14]', '$info[15]', '$info[16]', '$info[17]', '$info[18]', '$info[19]', '$info[20]')";


                                    $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);



      	return  $this->con->consulta($consulta);
		}
	}
	// buscar cliente
	
		function ingresar_customerzarest ($info){
		if($this->con){
			$consulta = "INSERT INTO zarest_customers (name, numdocu, email , phone ) VALUES
                       ('$info[0]', '$info[1]', '$info[2]', '$info[3]')";


           	return  $this->con->consulta($consulta);
		}
		}
		
			function borrar_calendardata ($numres){
		if($this->con){
			$consulta = "delete from calendar_data where bookingid = '$numres'";
           	return  $this->con->consulta($consulta);
		}
		}
		
		function borrar_calendardetail ($numres){
		if($this->con){
			$consulta = "delete from calendar_details where id = '$numres'";
           	return  $this->con->consulta($consulta);
		}
		}
	
	function buscar_cliente ($idtercero,$setid){
		if($this->con){
			$consulta = "SELECT id_cliente FROM tbl_clientes where id_tercero = '$idtercero' and setid= '$setid' ";
			return  $this->con->consulta($consulta);
		}
	}
	
		function buscar_numrescal ($numres){
		if($this->con){
			$consulta = "SELECT id FROM calendar_details where idcheckin = '$numres' and setid= '001' ";

          	return  $this->con->consulta($consulta);
		}
	}

	
	 function buscar_checkin ($setid,$idreserva){
		if($this->con){
			$consulta = "select ter.nombres, ter.numdoc, ter.email, ter.celular, ter.pais_res, res.fecha_reserva, res.valor_reserva,
             res.cant_adultos, res.cant_menores, detres.fecha_ini, detres.fecha_fin, prt.name , detres.adiciona_fecha,
            detres.asesor, detres.note , detres.desayuno, detres.parqueadero, detres.tipovehiculo, detres.placa , detres.idtipotarifa,
            res.cant_noches, detres.canal, detres.fecha_checkin, res.valor_deposito
            from tbl_reservas res INNER JOIN tbl_det_reservas detres ON detres.setid = res.setid and detres.id_reserva = res.id_reserva
            INNER JOIN tbl_terceros ter ON ter.setid = res.setid and ter.id_tercero = res.id_tercero
            INNER JOIN property_types prt ON prt.id = detres.id_habitacion where res.setid = '$setid' and res.id_reserva = '$idreserva'
            ";

            return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_pax ($setid,$idreserva){
		if($this->con){
			$consulta = "select ter.nombres, ter.numdoc , ter.email, ter.id_tercero
            from tbl_registro_huesped regpax
            INNER JOIN tbl_terceros ter ON ter.setid = regpax.setid and ter.id_tercero = regpax.id_tercero
            where regpax.setid = '$setid' and regpax.id_reserva = '$idreserva'
            ";


            return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_paxter ($setid,$idreserva,$idtercero){
		if($this->con){
			$consulta = "select regpax.id_tercero
            from tbl_registro_huesped regpax
            where regpax.setid = '$setid' and regpax.id_reserva = '$idreserva' and regpax.id_tercero= '$idtercero';
            ";
             return  $this->con->consulta($consulta);
		}
	}
	
		function buscar_venta ($idreserva){
		if($this->con){
			$consulta = "select zarest_sale_items.name, zarest_sale_items.price, zarest_sale_items.qt,zarest_sale_items.subtotal,
			zarest_sales.subtotal, zarest_sales.discount, zarest_sales.taxamount, zarest_sales.total, zarest_sales.totalitems,
			zarest_sales.paid
             from zarest_sales INNER JOIN zarest_sale_items ON zarest_sale_items.saled_id = zarest.sales.id
              where zares_sales.checkinid = '$idreserva'
            ";


			return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_salesid ($idreserva){
		if($this->con){
			$consulta = "select zarest_sales.id, zarest_sales.client_id, zarest_sales.clientname,
			zarest_sales.subtotal, zarest_sales.discountamount, zarest_sales.taxamount, zarest_sales.total, zarest_sales.totalitems,
			zarest_sales.paid, zarest_sales.status, zarest_sales.paidmethod, zarest_sales.numdoc, zarest_sales.numhab, zarest_sales.tax,
			zarest_sales.discount, zarest_sales.created_at
             from zarest_sales where zarest_sales.checkinid = '$idreserva'
            ";

          $ddf = fopen('error.log','a');
         fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
            fclose($ddf);

			return  $this->con->consulta($consulta);
		}
	}
	
		function buscar_possales($idregister,$idtable){
		if($this->con){
			$consulta = "select id, name, price, qt, product_id , sales_id , saleitem_id, time
            from zarest_posales
             where register_id = '$idregister' and table_id = '$idtable'
            ";

			return  $this->con->consulta($consulta);
		}
	}
	
	function delete_possales($filtro){
		if($this->con){
			$consulta = "delete from zarest_posales
             where $filtro
            ";
            
			return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_sumposales($idregister,$idtable){
		if($this->con){
			$consulta = "select sum(price*qt), sum(qt) from zarest_posales
             where register_id = '$idregister' and table_id = '$idtable'
            ";
			return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_sumpagos($idregister,$idsale){
		if($this->con){
			$consulta = "select sum(paid), count(id) from zarest_payements
             where register_id = '$idregister' and sale_id = '$idsale'
            ";
    		return  $this->con->consulta($consulta);
		}
	}
	
		function delete_salesitem($id){
		if($this->con){
			$consulta = "delete from zarest_sale_items
             where id like '$id'
            ";

       //          $ddf = fopen('error.log','a');
         //    fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
           //  fclose($ddf);


			return  $this->con->consulta($consulta);
		}
	}
	
	function delete_sales($id){
		if($this->con){
			$consulta = "delete from zarest_sales
             where id like '$id'
            ";

       //          $ddf = fopen('error.log','a');
         //    fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
           //  fclose($ddf);


			return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_settings (){
		if($this->con){
			$consulta = "SELECT currency,receiptheader,receiptfooter,tax,timezone,language,decimals,phone, companyname FROM zarest_settings";
			return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_ocupadas ($hoy){
		if($this->con){
			$consulta = " select count(DISTINCT(bookingid))from calendar_data
                          INNER JOIN calendar_details on calendar_details.id = calendar_data.bookingid where calendar_data.status = '10'";
     	return  $this->con->consulta($consulta);
		}
	}
	
    function actualiza_sales ($idsale,$paid,$status,$firstpayement){
		if($this->con){
			$consulta = " update zarest_sales set paid=$paid, status=$status, firstpayement=$firstpayement
                    where id = '$idsale' ";

                                    $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);


        	return  $this->con->consulta($consulta);
		}
	}
	
	function actualiza_saleshab ($campo,$checkin){
		if($this->con){
			$consulta = " update zarest_sales set $campo
                    where checkinid = '$checkin' ";

                                    $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);



          	return  $this->con->consulta($consulta);
		}
	}
	
	function actualiza_salesitemhab ($campo,$idsale){
		if($this->con){
			$consulta = " update zarest_sale_items set $campo
                    where sale_id = '$idsale' ";

                                     $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);

          	return  $this->con->consulta($consulta);
		}
	}

    	function actualiza_abonosale ($campo,$idsale){
		if($this->con){
			$consulta = " update zarest_payements set $campo
                    where sale_id = '$idsale' order by date asc limit 1 ";

                                     $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);

          	return  $this->con->consulta($consulta);
		}
	}


	
		function ingresar_abonossale ($info){
		if($this->con){
			$consulta = "INSERT INTO zarest_payements (date, paid, paidmethod, created_by, register_id, sale_id, waiter_id )
             VALUES  ('$info[0]', '$info[1]', '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]')";

                         $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);


           	return  $this->con->consulta($consulta);
		}
		}
		
		function buscar_hbloqueada(){
		if($this->con){
			$consulta = " select hab.id_habitacion, hab.numero_hab, hab.id_tipo_hab, hab.ultima_actualizacion,
            tipo.max_ocupacion, tipo.descripl, tipo.rutaimg
                    from tbl_habitaciones hab
                    INNER JOIN tbl_tipo_hab tipo ON tipo.id_tipo_hab = hab.id_tipo_hab
                    where hab.estado = 'BLOQUEADA'";

           	return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_estadohab($idhab){
		if($this->con){
			$consulta = " select tbl_habitaciones.estado from tbl_habitaciones
                    where id_habitacion = '$idhab'";

        	return  $this->con->consulta($consulta);
		}
	}
	
	function actualiza_habestado($idhab){
		if($this->con){
			$consulta = " update tbl_habitaciones set estado = ''
                    where id_habitacion = '$idhab' ";

        	return  $this->con->consulta($consulta);
		}
	}

    function actualiza_habbloqueada($numhab,$date){
		if($this->con){
			$consulta = " update tbl_habitaciones set estado = 'BLOQUEADA', ultima_actualizacion = '$date'
                    where numero_hab = '$numhab' ";

         	return  $this->con->consulta($consulta);
		}
	}
	
		function buscar_abonos1 ($filtros){
		if($this->con){
			$consulta = "SELECT zarest_sales.checkinid, zarest_sales.clientname, zarest_payements.date, zarest_payements.paid,
			             zarest_payements.paidmethod, zarest_sales.numhab,(zarest_sales.total - zarest_sales.paid), zarest_payements.id
			             from zarest_sales INNER JOIN zarest_payements ON zarest_payements.sale_id = zarest_sales.id
                         where $filtros ORDER BY zarest_sales.checkinid asc";

              $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);


        	return  $this->con->consulta($consulta);
		}
	}
	
		function buscar_datoscliente ($idcliente){
		if($this->con){
			$consulta = "SELECT zarest_customers.numdocu, zarest_customers.phone, zarest_customers.email, zarest_customers.PAIS,
			             zarest_customers.direccion
			             from zarest_customers
                         where zarest_customers.id = $idcliente";

              $ddf = fopen('error.log','a');
             fwrite($ddf,"[".date("r")."] Error  $consulta \r\n");
             fclose($ddf);


        	return  $this->con->consulta($consulta);
		}
	}



}

?>
