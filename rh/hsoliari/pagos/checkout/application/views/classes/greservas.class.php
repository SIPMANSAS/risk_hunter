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
            cant_hab, valor_reserva, estado, adiciona_fecha, ultima_actualizacion, ajapues, origen , valor_deposito, id_cliente) VALUES
             ('$info[0]', '$info[1]', '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '$info[8]', '$info[9]',now(), now(), '0',
             '$info[10]', '$info[11]', '$info[12]')";
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
			$consulta="INSERT INTO tbl_det_reservas (setid, id_reserva, fecha_ini, fecha_checkin, fecha_fin,
             fecha_checkout, idtipotarifa, cant_adultos, cant_menores, id_tipo_hab, id_habitacion, estado,
             adiciona_fecha, ultima_actualizacion, cantidad, ajapues) VALUES ('$info[0]', '$info[1]','$info[2]',
             now(), '$info[3]', '', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '$info[8]', '$info[9]',
             now(), now(), '$info[10]', '0')";
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
	
		function buscar_sales ($cliente){
		if($this->con){
			$consulta = "SELECT id,total,subtotal,paid,taxamount FROM zarest_sales WHERE client_id='$cliente' and paidmethod like '2~%' ";
            echo "consulta e s" .$consulta;
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
	
		function buscar_estadoreserva (){
		if($this->con){
			$consulta = "SELECT id, title_es , colorhex FROM property_blockstatuses";
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
			$consulta = "SELECT DISTINCT tbl_reservas.id_reserva, tbl_terceros.nombres, tbl_terceros.apellidos, tbl_terceros.id_segm_ter, tbl_det_reservas.id_tipo_pago, tbl_reservas.fecha_reserva, tbl_reservas.estado, prestilo.color_background FROM ((tbl_reservas INNER JOIN tbl_det_reservas ON tbl_reservas.id_reserva=tbl_det_reservas.id_reserva) INNER JOIN (tbl_clientes INNER JOIN tbl_terceros ON tbl_clientes.id_tercero=tbl_terceros.id_tercero) ON tbl_reservas.id_cliente=tbl_clientes.id_cliente) INNER JOIN prestilo ON tbl_reservas.estado=prestilo.estilo_nombre ORDER BY tbl_reservas.id_reserva DESC";
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
	
	function buscar_habcalendar (){
		if($this->con){
			$consulta = "SELECT distinct(thab.id) , thab.name, tipohab.max_ocupacion, tipohab.id_tipo_hab
            from property_types thab
            INNER JOIN tbl_habitaciones hab ON thab.id = hab.id_habitacion
            INNER JOIN tbl_tipo_hab tipohab ON tipohab.id_tipo_hab = hab.id_tipo_hab
             order by thab.name asc";
			return  $this->con->consulta($consulta);
		}
	}
	
	function buscar_tipotarifa ($numhab){
		if($this->con){
			$consulta = "SELECT tarf.idtipotarifa, tarf.descripcion, tarf.tarifa
            from property_types thab
            INNER JOIN tbl_habitaciones hab ON thab.id = hab.id_habitacion
            INNER JOIN tbl_tipo_hab tipohab ON tipohab.id_tipo_hab = hab.id_tipo_hab
            INNER JOIN tbl_tarifas tarf ON tarf.idtipohab = tipohab.id_tipo_hab
            where thab.name = '$numhab'
            ";
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
	
	 function buscar_asesor ($setid,$asesor){
		if($this->con){
			$consulta = "SELECT *
            from tbl_asesores where setid like '%$setid%' and idasesor like '%$asesor%'
            order by nombre asc
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
            (setid,id_tercero, id_tipo_pago, id_cliente, num_tarjeta, nombre,
             mm_expira, aa_expira, dig_verifica, cv_num, adiciona_fecha, ultima_actualizacion,
             id_cuenta, id_ambiente, tipo_tarjeta, fecha_aut) VALUES ('$info[0]', '$info[1]',
             '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '', '', now(), now(), '','','', now())";
			return  $this->con->consulta($consulta);
		}
	}
	
	// buscar cliente
	
	function buscar_cliente ($idtercero,$setid){
		if($this->con){
			$consulta = "SELECT id_cliente FROM tbl_clientes where id_tercero = '$idtercero' and setid= '$setid' ";
			return  $this->con->consulta($consulta);
		}
	}
}
?>
