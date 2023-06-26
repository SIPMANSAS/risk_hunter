<?php
function cambiar_fecha($fecha){
	if(($fecha!="")&&($fecha!='--')){
		$nueva=explode('-',$fecha);
		if(strlen($nueva[2])<=1) $nueva[2]='0'.$nueva[2];
		if(strlen($nueva[1])<=1) $nueva[1]='0'.$nueva[1];
		$final=$nueva[2].'-'.$nueva[1].'-'.$nueva[0];
		return $final;
	}
}

function validar_datos($variable){
	if(isset($_POST[$variable]))
		$valor=$_POST[$variable];
	else
		$valor='';
	return $valor;
}

function hallar_menor($num1, $num2, $num3){
	if(($num1>0)&&($num2>0)&&($num3>0)){
		if(($num1<$num2)&&($num1<$num3))
			return 0;
		elseif($num2<$num3)
			return 1;
		else
			return 2;
	}
	elseif(($num1>0)&&($num2>0)&&($num3<=0)){
		if($num1<$num2)
			return 0;
		else
			return 1;
	}
	elseif(($num1>0)&&($num2<=0)&&($num3<=0)){
		return 0;
	}
	elseif(($num1>0)&&($num2<=0)&&($num3>0)){
		if($num1<$num3)
			return 0;
		else
			return 2;
	}
	elseif(($num1<=0)&&($num2>0)&&($num3>0)){
		if($num2<$num3)
			return 1;
		else
			return 2;
	}
	elseif(($num1<=0)&&($num2<=0)&&($num3>0)){
			return 2;
	}
	elseif(($num1<=0)&&($num2>0)&&($num3<=0)){
			return 1;
	}
	else
		return -1;
}

function retornar_mes($mes){
	if($mes!=""){
		$meses=array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		$nmes=(int) $mes - 1;
		$strmes=$meses[$nmes];
		return $strmes;
	}
}

function retornar_dia($dia){
	if($dia!=""){
		$dias=array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
		$ndia=(int) $dia;
		$strdia=$dias[$ndia];
		return $strdia;
	}
}

function operar_fechas($fecha, $i, $sentido){
	if($fecha!=""){
//		$fecha = strtot('Y-m-j');
		if($sentido=='2')
			//$nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $fecha ) ) ;
			$nuevafecha = strtotime($fecha."+ 1 days");
		else
//			$nuevafecha = strtotime ( '-'.$i.' day' , strtotime ( $fecha ) ) ;
			$nuevafecha = strtotime($fecha."- 1 days");
		$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
 		return $nuevafecha;
	}
}

function retornar_codigo($tam, $cod){
	$dim=strlen($cod);
	$ceros='';
	for($i=$dim;$i<$tam;$i++){
		$ceros.='0';
	}
	$codigo=$ceros.$cod;
	return $codigo;
}

function FncTabHospedaje($XLABEL, $XINFO){
	$XTIT48=explode(' ',$XLABEL[32]);
	$XTIT46=explode(' ',$XLABEL[28]);
	$XTIT47=explode(' ',$XLABEL[29]);
   	$XTABLA='<tr style="background-color:#ccc">
		<th align="center"></th>
		<th align="center">'.$XLABEL[33].'</th>
      	<th align="center">'.$XTIT48[0].'<br>'.$XTIT48[1].'</th>
		<th align="center">'.$XTIT46[0].'</th>
       	<th align="center">'.$XTIT47[0].'</th>
		<th align="center">'.$XLABEL[35].'</th>
		<th align="center">'.$XLABEL[141].'</th>
      	<th align="center">'.$XLABEL[34].'</th>
       	<th align="center">'.$XLABEL[36].'</th>
		<th align="center">'.$XLABEL[37].'</th>
   	</tr>';
	$XOBJRES=new greservas;
	$XRSRES=$XOBJRES->buscar_hospedaje();
	$XNUMHAB=$XOBJRES->numero_filas($XRSRES);
	$XNUMPER=$XINFO[1]+$XINFO[3];
	$XI=0;
	$XCANTHAB=0;
	while($XROWRES=$XOBJRES->obtener_fila($XRSRES)){
		$XA=0;
		$XN=0;
		if(($XROWRES[2]>=($XNUMPER/$XNUMHAB))&&($XROWRES[2]<=$XNUMPER)){
			if(($XINFO[3]>0)&&(($XROWRES[2]-$XINFO[3])>=0)){
				$XN=$XINFO[3];
				$XA=$XROWRES[2]-$XINFO[3];
				$XINFO[3]=0;
			}
			elseif(($XINFO[3]>0)&&(($XROWRES[2]-$XINFO[3])<0)){
				$XA=0;
				$XN=$XROWRES[2];
				$XINFO[3]=$XINFO[3]-$XROWRES[2];
			}
			else{
				$XN=0;
				if($XNUMPER<=$XROWRES[2])
					$XA=$XNUMPER;
				else
					$XA=$XROWRES[2];
			}
			$XCANTPER=$XA+$XN;
			$XTABLA.='<tr id="RowHosp'.$XI.'" style="background-color:#66FF66">
				<td>'.($XI+1).'</td>
    		   	<td> 
					<input type="hidden" id="Hddhab'.$XI.'" value="'.$XROWRES[0].'" >
					<input type="hidden" id="Hddtip'.$XI.'" value="'.$XROWRES[4].'" >
					<input type="hidden" id="Hddtar'.$XI.'" value="'.$XROWRES[2].'" >
					<input type="hidden" id="Hddadl'.$XI.'" value="'.$XA.'" >
					<input type="hidden" id="Hddnin'.$XI.'" value="'.$XN.'" >
					<input type="checkbox" id="ChkHosp'.$XI.'" checked="checked" onclick="FncSelecHab2('.$XI.')">
				</td>
			   	<td>
					<input type="text" id="TxtHab'.$XI.'" style="width:40px; text-align:center;" value="1" />
				</td>
		   		<td>
					<input type="text" id="TxtAd'.$XI.'" style="width:40px; text-align:center;" value="'.$XA.'" />
				</td>
			   	<td>
					<input type="text" id="TxtNin'.$XI.'" style="width:40px; text-align:center;" value="'.$XN.'" />
				</td>
		       	<td align="right">
	   				<select id="SlcTarifa'.$XI.'">';
						$XOBJTAR=new tarifas;
						$XRSTAR=$XOBJTAR->ver_tarifas_temporada($XROWRES[4]);
						while($XROWTAR=$XOBJTAR->obtener_fila($XRSTAR)){
							$XTABLA.='<option value="'.$XROWTAR[0].'">'.$XROWTAR[4].' $ '.number_format($XROWTAR[1]).'</option>';
						}
					$XTABLA.='</select>
				</td>
    		   	<td align="center">'.$XROWRES[5].'</td>
	       		<td align="left">'.$XROWRES[1].'</td>
    		   	<td align="center">'.$XROWRES[2].'</td>
       			<td align="left">'.$XROWRES[3].'</td>
	   		</tr>';
			$XNUMPER-=$XROWRES[2];
			$XNUMHAB--;
			$XCANTHAB++;
		}
		elseif(($XNUMPER>0)&&($XNUMPER<$XROWRES[2])){
			$XTABLA.='<tr id="RowHosp'.$XI.'" style="background-color:#66FF66">
				<td>'.($XI+1).'</td>
    		   	<td> 
					<input type="hidden" id="Hddhab'.$XI.'" value="'.$XROWRES[0].'" >
					<input type="hidden" id="Hddtip'.$XI.'" value="'.$XROWRES[4].'" >
					<input type="hidden" id="Hddtar'.$XI.'" value="'.$XROWRES[2].'" >
					<input type="hidden" id="Hddadl'.$XI.'" value="'.$XA.'" >
					<input type="hidden" id="Hddnin'.$XI.'" value="'.$XN.'" >
					<input type="checkbox" id="ChkHosp'.$XI.'" checked="checked" onclick="FncSelecHab2('.$XI.')">
				</td>
			   	<td>
					<input type="text" id="TxtHab'.$XI.'" style="width:40px; text-align:center;" value="1" />
				</td>
		   		<td>
					<input type="text" id="TxtAd'.$XI.'" style="width:40px; text-align:center;" value="'.$XA.'" />
				</td>
			   	<td>
					<input type="text" id="TxtNin'.$XI.'" style="width:40px; text-align:center;" value="'.$XN.'" />
				</td>
		       	<td align="right">
	   				<select id="SlcTarifa'.$XI.'">';
						$XOBJTAR=new tarifas;
						$XRSTAR=$XOBJTAR->ver_tarifas_temporada($XROWRES[4]);
						while($XROWTAR=$XOBJTAR->obtener_fila($XRSTAR)){
							$XTABLA.='<option value="'.$XROWTAR[0].'">'.$XROWTAR[4].' $ '.number_format($XROWTAR[1]).'</option>';
						}
					$XTABLA.='</select>
				</td>
    		   	<td align="center">'.$XROWRES[5].'</td>
	       		<td align="left">'.$XROWRES[1].'</td>
    		   	<td align="center">'.$XROWRES[2].'</td>
       			<td align="left">'.$XROWRES[3].'</td>
	   		</tr>';
			$XNUMPER-=$XROWRES[2];
			$XNUMHAB--;
			$XCANTHAB++;
		}
		else{
			$XTABLA.='<tr id="RowHosp'.$XI.'" style="background-color:#fff">
				<td>'.($XI+1).'</td>
    		   	<td> 
					<input type="hidden" id="Hddhab'.$XI.'" value="'.$XROWRES[0].'" >
					<input type="hidden" id="Hddtip'.$XI.'" value="'.$XROWRES[4].'" >
					<input type="hidden" id="Hddtar'.$XI.'" value="'.$XROWRES[2].'" >
					<input type="hidden" id="Hddadl'.$XI.'" value="'.$XA.'" >
					<input type="hidden" id="Hddnin'.$XI.'" value="'.$XN.'" >
					<input type="checkbox" id="ChkHosp'.$XI.'" onclick="FncSelecHab2('.$XI.')">
				</td>
			   	<td>
					<input type="text" id="TxtHab'.$XI.'" style="width:40px;" />
				</td>
		   		<td>
					<input type="text" id="TxtAd'.$XI.'" style="width:40px;" />
				</td>
			   	<td>
					<input type="text" id="TxtNin'.$XI.'" style="width:40px;" />
				</td>
		       	<td align="right">
	   				<select id="SlcTarifa'.$XI.'">';
						$XOBJTAR=new tarifas;
						$XRSTAR=$XOBJTAR->ver_tarifas_temporada($XROWRES[4]);
						while($XROWTAR=$XOBJTAR->obtener_fila($XRSTAR)){
							$XTABLA.='<option value="'.$XROWTAR[0].'">'.$XROWTAR[4].' $ '.number_format($XROWTAR[1]).'</option>';
						}
					$XTABLA.='</select>
				</td>
    		   	<td align="center">'.$XROWRES[5].'</td>
	       		<td align="left">'.$XROWRES[1].'</td>
    		   	<td align="center">'.$XROWRES[2].'</td>
       			<td align="left">'.$XROWRES[3].'</td>
	   		</tr>';
		}
		$XI++;
	}
	$XTABLA.='<input type="hidden" id="HddFil" value="'.$XI.'" >';
	$XARREGLO=array($XTABLA, $XCANTHAB);
	return $XARREGLO;
}

function FncTabInfoRes($XLABEL, $XRESERVA){
   	$XTABLA='<tr>
      	<td align="left">'.$XLABEL[25].'</td>
      	<td align="left"></td>
       	<td align="left">'.$XLABEL[26].'</td>
       	<td align="left">'.$XLABEL[2].': '.$XRESERVA.'</td>
	</tr>';
	return $XTABLA;
}

function FncTabReservaCli($XLABEL, $XINFO){
	$XTABLA='<tr>
       	<td align="right" height="30px" width="120px"><strong>'.$XLABEL[40].':</strong></td>
    	<td width="120px" align="center">
   	    	<input type="text" id="TxtIdCli" style="width:120px;" value="'.$XINFO[0].'" />
			<img src="images/icon-buscar.png" width="30px" height="30px" style="cursor:pointer" onclick="FncVerDlgCliente()" />
       	</td>
       	<td align="right" width="120px"><strong>'.$XLABEL[41].':</strong></td>
    	<td width="120px">'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" width="120px"><strong>'.$XLABEL[42].':</strong></td>
	   	<td width="100px">'.$XINFO[3].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[43].':</strong></td>
      	<td>'.$XINFO[4].'</td>
       	<td align="right"><strong>'.$XLABEL[62].':</strong></td>
       	<td>'.$XINFO[5].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[54].':</strong></td>
       	<td>'.$XINFO[14].'</td>
       	<td align="right"><strong>'.$XLABEL[56].':</strong></td>
      	<td>'.$XINFO[15].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabReservaPre($XLABEL, $XINFO, $XNUMREGPRE, $XTOTREGPRE){
	$XFECLLEG="'TxtResLleg'";
	$XFECSAL="'TxtResSal'";
	$XNUMNOC="'TxtResNoc'";
	if(count($XINFO)<=0) $XINFO=array('','','','','','','','','','','','','','','','','','','','');
	if($XINFO[9]=="") $XINFO[9]=0;
   	$XTABLA='<tr>
       	<td align="left" width="70%" style="">
			<table width="100%">
				<tr>
					<td width="60%"><strong>'.$XLABEL[61].'</strong></td>
					<td align="center" colspan="4">';
			$XTABLA.='<p class="paginacion" align="right" >';
			if($XNUMREGPRE>1){ 
				$XP=$XNUMREGPRE-1;
				$XTABLA.='<a onclick="FncVerPre('.$XP.')" style="cursor:pointer;"><img src="images/izq.gif" /></a>';
			}
			for($XJ=1;$XJ<=$XTOTREGPRE;$XJ++){
				$XTABLA.='<a onclick="FncVerPre('.$XJ.')" style="cursor:pointer; color:#FFFFFF; padding:4px 6px;">'.$XJ.'</a> ';
			}
			if(($XNUMREGPRE<$XTOTREGPRE)&&($XTOTREGPRE>1)){ 
				$XP=$XNUMREGPRE+1;
				$XTABLA.='<a onclick="FncVerPre('.$XP.')" style="cursor:pointer;"><img src="images/der.gif" /></a>';
			}
			$XTABLA.='</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" >
				<tr>
				   	<td align="right" width="120px"><strong>'.$XLABEL[27].':</strong></td>
			    	<td colspan="2" width="140px" align="left">
				    	<input type="text" id="TxtResLleg" style="width:120px; text-align:center;" value="'.cambiar_fecha($XINFO[0]).'" />
    				</td>
			       	<td align="right" colspan="2" ><strong>'.$XLABEL[63].':</strong></td>
    				<td width="40px">
   						<input type="text" id="TxtResNoc" style="width:30px; text-align:center;" value="'.utf8_encode($XINFO[1]).'" onblur="PrcCalcularFecha('.$XFECLLEG.', '.$XNUMNOC.', '.$XFECSAL.')" />
       				</td>
	   				<td align="right" width="120px"><strong>'.$XLABEL[30].':</strong></td>
			    	<td width="120px">
	    				<input type="text" id="TxtResSal" style="width:120px; text-align:center;" value="'.cambiar_fecha($XINFO[2]).'" />
       				</td>
       				<td align="right" width="30px"><strong>'.$XLABEL[64].':</strong></td>
    				<td width="60px">
   	    				<select id="SlcNumHab" style="width:100px;" >
							<option value="'.$XINFO[3].'">'.$XINFO[19].'</option>';
							if($XINFO[3]==""){
								$XOBJHAB=new habitaciones;
								$XRSHAB=$XOBJHAB->ver_habitaciones_xestado('disponible');
								while($XROWHAB=$XOBJHAB->obtener_fila($XRSHAB)){
									$XTABLA.='<option value="'.$XROWHAB[0].'">'.$XROWHAB[1].'</option>';
								}
							}
						$XTABLA.='</select>
					</td>
    				<td width="60px">
						<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncAdicionarHabitacion()"  />
						<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncEliminarHabitacion()" />
					</td>
				</tr>
				<tr>
    				<td align="right"><strong>'.$XLABEL[28].':</strong></td>
					<td align="left" colspan="2" valign="top">
   	    				<input type="text" id="TxtResAd" style="width:30px; text-align:center;" value="'.utf8_encode($XINFO[4]).'" />
						<strong>'.$XLABEL[29].':</strong>
						<input type="text" id="TxtResNin" style="width:30px; text-align:center;" value="'.utf8_encode($XINFO[5]).'" />
					</td>
			    	<td align="right" colspan="2" ><strong>'.$XLABEL[34].':</strong></td>
					<td width="60px" align="left">
   	    				<select id="SlcTipoHab" style="width:70px;" >
							<option value="'.$XINFO[6].'">'.$XINFO[7].'</option>';
						$XTABLA.='</select>
			       	</td>
					<td align="left" colspan="2">
  	    				<input type="text" id="TxtResTipoHab" style="width:200px; text-align:center; background-color:#fff;" readonly="readonly" value="'.$XINFO[18].'" />
					</td>
					<td align="right" colspan="2"><strong>'.$XLABEL[36].':</strong></td>
					<td align="left">
   	    				<input type="text" id="TxtMaxOcup" style="width:30px; text-align:center;" value="'.$XINFO[8].'" />
					</td>
			   	</tr>
			   	<tr>
			    	<td align="right"><strong>'.$XLABEL[67].':</strong></td>
					<td align="left" colspan="2" >
   	    				<select id="SlcResCodTar">
							<option value="'.$XINFO[14].'">'.$XINFO[16].'</option>
						</select>
			      	</td>';
					$XOBJMON=new monedas;
					if($XINFO[15]!=""){
						$XRSMON=$XOBJMON->buscar_monedas($XINFO[15]);
						$XROWMON=$XOBJMON->obtener_fila($XRSMON);
						$XMONEDA=$XROWMON[1];
						$XSIMBOLO=$XROWMON[2];
					}
					else{
						$XMONEDA='';
						$XSIMBOLO='';
					}
					if($XINFO[14]=="")$XINFO[14]=0;
					if($XINFO[13]=="")$XINFO[13]=0;
			    	$XTABLA.='<td align="right" ><strong>'.$XLABEL[68].':</strong></td>
					<td align="left" >
   	    				<select id="SlcResValTar">
							<option value="'.$XINFO[14].'">'.$XSIMBOLO.' '.number_format($XINFO[13]).'</option>';
							$XOBJTAR=new tarifas;
							$XRSTAR=$XOBJTAR->ver_tarifas($XINFO[6]);
							while($XROWTAR=$XOBJTAR->obtener_fila($XRSTAR)){
								$XTABLA.='<option value="'.$XROWTAR[0].'">'.$XSIMBOLO.' '.number_format($XROWTAR[1]).'</option>';
							}
						$XTABLA.='</select>
			       	</td>
					<td align="right"><strong>'.$XLABEL[69].':</strong></td>
					<td align="left">
   	    				<select id="SlcResMon" onchange="FncSelecMoneda()">
							<option value="'.$XINFO[15].'">'.$XINFO[15].'</option>';
							$XRSMON=$XOBJMON->ver_monedas();
							while($XROWMON=$XOBJMON->obtener_fila($XRSMON)){
								$XTABLA.='<option value="'.$XROWMON[0].'">'.$XROWMON[0].'</option>';
							}
						$XTABLA.='</select>
					</td>
					<td align="left">
	   	    			<input type="text" id="TxtResTipMon" style="width:120px; text-align:center; background-color:#fff;" readonly="readonly" value="'.$XMONEDA.'" />
					</td>
					<td align="right"><strong>'.$XLABEL[70].':</strong></td>
			       	<td align="left">
						<input type="text" id="TxtResDcto" style="width:100px; text-align:right;" />
			        </td>
				</tr>
			   	<tr>
					<td align="right" ><strong>'.$XLABEL[71].':</strong></td>
			       	<td colspan="2" align="left" >
        				<input type="text" id="TxtResPor" style="width:30px; text-align:center;" />
					</td>
			        <td align="right" colspan="2" ><strong>'.$XLABEL[72].':</strong></td>
			       	<td align="left" >
		  				<input type="text" id="TxtResOfer" style="width:100px; text-align:left;" />
			        </td>
			        <td align="right"><strong>'.$XLABEL[73].':</strong></td>
			       	<td align="left" >
		  				<input type="text" id="TxtResDias" style="width:60px; text-align:center;" />
			        </td>
			      	<td align="right"><strong>'.$XLABEL[74].':</strong></td>
			    	<td align="left">
				    	<input type="text" id="TxtResRaz" style="width:100px; text-align:center;" />
			    	</td>
				</tr>
				<tr>
				   	<td align="right" ><strong>'.$XLABEL[75].':</strong></td>
			       	<td colspan="4" ></td>
			       	<td align="right" ><strong>'.$XLABEL[76].':</strong></td>
			    	<td colspan="5" >
	    				<input type="text" id="TxtResObs" style="width:350px; text-align:center;" />
						<input type="hidden" id="TxtIdDetRes" value="'.$XINFO[11].'" />
						<input type="hidden" id="TxtIvaStay" value="'.$XINFO[17].'" />
			       	</td>
				</tr>
			</table>
		</td>
	</tr>
	<script>
		$("#TxtResLleg").datepicker({
    		showOn: "both",
        	buttonImage: "images/calendar.png",
        	buttonImageOnly: true,
        	buttonText: "Seleccione La Fecha",
        	changeYear: true,
        	changeMonth: true,
        	dateFormat: "dd-mm-yy",
        	minDate: "+0d",
		}); 
	</script>';
	return $XTABLA;
}

function FncTabDetalleServ($XLABEL, $XRES, $XIDHAB, $XNUMREG, $XTOTREG){
   	$XTABLA='<tr>
		<td width="50%" align="left" colspan="3">
			<strong>'.$XLABEL[77].'</strong>
		</td>
		<td>'.$XLABEL[7].'</td>
		<td align="center" colspan="4">';
			$XTABLA.='<p class="paginacion" align="right" >';
			if($XNUMREG>1){ 
				$XP=$XNUMREG-1;
				$XTABLA.='<a onclick="FncVerServ('.$XP.')" style="cursor:pointer;"><img src="images/izq.gif" /></a>';
			}
			for($XJ=1;$XJ<=$XTOTREG;$XJ++){
				$XTABLA.='<a onclick="FncVerServ('.$XJ.')" style="cursor:pointer; color:#FFFFFF; padding:4px 6px;">'.$XJ.'</a> ';
			}
			if(($XNUMREG<$XTOTREG)&&($XTOTREG>1)){ 
				$XP=$XNUMREG+1;
				$XTABLA.='<a onclick="FncVerServ('.$XP.')" style="cursor:pointer;"><img src="images/der.gif" /></a>';
			}
			$XTABLA.='</p>
		</td>
   	</tr>';
   	$XTABLA.='<tr>
		<td align="center"><strong>'.$XLABEL[79].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[80].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[81].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[82].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[83].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[84].'</strong></td>
    	<td align="center"></td>
	</tr>';
	if($XRES=="") $XRES='0';
	$XOFFSET=($XNUMREG-1)*4;
	if($XOFFSET<0) $XOFFSET=0;
	$XOBJSER=new servicios;
	$XRSDET=$XOBJSER->ver_servicios_reserva($XRES, $XIDHAB,$XOFFSET,4);
	$XI=0;
	while($XROWDET=$XOBJSER->obtener_fila($XRSDET)){
		$XTABLA.='<tr>
			<td align="center">
				<input type="text" id="TxtIdServ'.$XI.'" style="width:40px; text-align:center; font-size:10px;" readonly="readonly" value="'.$XROWDET[0].'" />
			</td>
			<td align="center">
				<select id="SlcServicio'.$XI.'" onchange="FncSeleccionServicio()">
					<option value="'.$XROWDET[0].'">'.$XROWDET[1].'</option>';
					$XOBJSER=new servicios;
					$XRSSER=$XOBJSER->ver_tipo_servicio();
					while($XROWSER=$XOBJSER->obtener_fila($XRSSER)){
						$XTABLA.='<option value="'.$XROWSER[0].'">'.$XROWSER[1].'</option>';
					}
				$XTABLA.='</select>
			</td>
			<td align="center">
				<input type="text" id="TxtTarServ'.$XI.'" style="width:40px; text-align:center; font-size:10px;" readonly="readonly" value="'.$XROWDET[2].'" />
			</td>
			<td align="center">
				<input type="text" id="TxtCanServ'.$XI.'" style="width:40px; text-align:center; font-size:10px;" value="'.$XROWDET[3].'" />
			</td>
			<td align="center">
				<input type="text" id="TxtFecIniServ'.$XI.'" style="width:80px; text-align:center; font-size:10px" value="'.cambiar_fecha($XROWDET[4]).'" />
			</td>
			<td align="center">
				<input type="text" id="TxtFecFinServ'.$XI.'" style="width:80px; text-align:center; font-size:10px" value="'.cambiar_fecha($XROWDET[5]).'" />
			</td>
			<td align="center">
				<img src="images/icon-mas.png" width="15px" height="15px" style="cursor:pointer" onclick="FncActualizarServicio('.$XI.')" >
				<img src="images/icon-menos.png" width="15px" height="15px" style="cursor:pointer" onclick="FncEliminarServicio('.$XROWDET[6].', '.$XNUMREG.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
    	<td align="center">
			<input type="text" id="TxtIdServ" style="width:40px; text-align:center; font-size:10px;" readonly="readonly" />
		</td>
        <td align="center">
			<select id="SlcServicio" onchange="FncSeleccionServicio()">
				<option value=""></option>';
				$XOBJSER=new servicios;
				$XRSSER=$XOBJSER->ver_tipo_servicio();
				while($XROWSER=$XOBJSER->obtener_fila($XRSSER)){
					$XTABLA.='<option value="'.$XROWSER[0].'">'.$XROWSER[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
        <td align="center">
			<input type="text" id="TxtTarServ" style="width:40px; text-align:center; font-size:10px;" readonly="readonly" />
		</td>
        <td align="center">
			<input type="text" id="TxtCanServ" style="width:40px; text-align:center; font-size:10px;" />
		</td>
        <td align="center">
			<input type="text" id="TxtFecIniServ" style="width:80px; text-align:center; font-size:10px" />
		</td>
        <td align="center">
			<input type="text" id="TxtFecFinServ" style="width:80px; text-align:center; font-size:10px" />
		</td>
        <td align="center">
			<img src="images/icon-mas.png" width="15px" height="15px" style="cursor:pointer" onclick="FncAdicionarServicio('.$XNUMREG.')" />
			<img src="images/icon-menos.png" width="15px" height="15px" style="cursor:pointer" onclick="FncEliminarServicio()" />
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabDetalleMenores($XLABEL, $XRES, $XHAB, $XMEN){
   	$XTABLA='<tr>
		<td width="20%" align="center">
			<strong>'.$XLABEL[135].'</strong>
		</td>
   	</tr>';
   	$XTABLA.='<tr>
		<td align="center"><strong>'.$XLABEL[66].'</strong></td>
		<input type="hidden" id="TxtResMen" value="'.$XMEN.'" />
	</tr>';
	$XOBJRES=new greservas;
	$XRSMEN=$XOBJRES->ver_menores($XRES, $XHAB);
	if($XOBJRES->numero_filas($XRSMEN)!=0){
		$XI=0;
		while($XROWMEN=$XOBJRES->obtener_fila($XRSMEN)){
			$XTABLA.='<tr>
				<td align="center">'.($XI+1).'.
					<input type="hidden" id="TxtIdMen'.$XI.'" value="'.$XROWMEN[1].'" />
					<select id="SlcRanEdad'.$XI.'">
						<option value="'.$XROWMEN[0].'">'.$XROWMEN[0].'</option>';
						for($XJ=0;$XJ<18;$XJ+=2){
							$XRANGO=$XJ.' - '.($XJ+2);
							$XTABLA.='<option value="'.$XRANGO.'">'.$XRANGO.'</option>';
						}
					$XTABLA.='</select>
				</td>
	       	</tr>';
			$XI++;
		}
	}
	else{
		for($XI=0;$XI<$XMEN;$XI++){
			$XTABLA.='<tr>
				<td align="center">'.($XI+1).'.
					<select id="SlcRanEdad'.$XI.'">
						<option value=""></option>';
						for($XJ=0;$XJ<18;$XJ+=2){
							$XRANGO=$XJ.' - '.($XJ+2);
							$XTABLA.='<option value="'.$XRANGO.'">'.$XRANGO.'</option>';
						}
					$XTABLA.='</select>
				</td>
	       	</tr>';
		}
	}
	return $XTABLA;
}

function FncTabDetallePagos($XLABEL, $XRES, $XHAB, $XNUMREG, $XTOTREG){
   	$XTABLA='<tr style="background-color:#a0cee6">
		<td width="63%" align="left" colspan="7">
			<strong>'.$XLABEL[78].'</strong>
			<input type="hidden" id="TxtNumRegAbo" value="'.$XNUMREG.'" />
			<input type="hidden" id="TxtTotRegAbo" value="'.$XTOTREG.'" />
		</td>
		<td align="right">'.$XLABEL[7].'
			<a onclick="FncPrimerPago()" style="cursor:pointer">'.$XLABEL[8].'</a>
			<img src="images/arrow_l.png" width="20px" height="15px" style="cursor:pointer;" onclick="FncAnteriorPago()" />
		</td>
		<td style="background-color:#fff;" align="center" >
			'.$XNUMREG.' '.$XLABEL[9].' '.$XTOTREG.'
		</td>
		<td align="left" colspan="2">
			<img src="images/arrow_r.png" width="20px" height="15px" style="cursor:pointer;" onclick="FncSiguientePago()" />
			<a onclick="FncUltimoPago()" style="cursor:pointer">'.$XLABEL[10].'</a>
		</td>
   	</tr>';
   	$XTABLA.='<tr>
		<td align="center"><strong>'.$XLABEL[85].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[86].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[87].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[88].'</strong></td>
    	<td align="center" colspan="2"><strong>'.$XLABEL[89].'</strong></td>
    	<td align="center" colspan="2"><strong>'.$XLABEL[90].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[91].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[92].'</strong></td>
    	<td align="center"></td>
	</tr>';
	$XOFFSET=($XNUMREG-1)*4;
	if($XOFFSET<0) $XOFFSET=0;
	$XOBJPAG=new pagos;
	$XRSDET=$XOBJPAG->ver_pagos_reserva($XRES, $XHAB,$XOFFSET,4);
	$XI=0;
	while($XROWDET=$XOBJPAG->obtener_fila($XRSDET)){
		$XTABLA.='<tr>
        <td align="center">
			<input type="text" id="TxtPago'.$XI.'" style="width:60px; text-align:center; font-size:10px;" readonly="readonly" value="'.$XROWDET[0].'" />
		</td>
    	<td align="center">
			<input type="text" id="TxtNumTc'.$XI.'" style="width:120px; text-align:center; font-size:10px;" readonly="readonly" value="'.$XROWDET[1].'" />
		</td>
        <td align="center">
			<input type="text" id="TxtDigito'.$XI.'" style="width:40px; text-align:center; font-size:10px;" readonly="readonly" value="'.$XROWDET[2].'" />
		</td>
        <td align="center">
			<input type="text" id="TxtCv'.$XI.'" style="width:40px; text-align:center; font-size:10px;" readonly="readonly" value="'.$XROWDET[3].'" />
		</td>
        <td align="right">
			<input type="text" id="TxtmmExpira'.$XI.'" style="width:40px; text-align:center; font-size:10px" readonly="readonly" value="'.$XROWDET[4].'" />
		</td>
        <td align="left">
			<input type="text" id="TxtaaExpira'.$XI.'" style="width:40px; text-align:center; font-size:10px" readonly="readonly" value="'.$XROWDET[5].'" />
		</td>
        <td align="right">
			<input type="text" id="TxtNombre'.$XI.'" style="width:200px; text-align:center; font-size:10px" readonly="readonly" value="'.$XROWDET[6].'" />
		</td>
        <td align="left">
			<input type="text" id="TxtApellido'.$XI.'" style="width:200px; text-align:center; font-size:10px" readonly="readonly" value="'.$XROWDET[7].'" />
		</td>
        <td align="center">
			<input type="text" id="TxtServPago'.$XI.'" style="width:60px; text-align:center; font-size:10px;" readonly="readonly" value="'.$XROWDET[8].'" />
		</td>';
		$XVALOR=$XROWDET[9]+$XROWDET[12];
        $XTABLA.='<td align="center">
			<input type="text" id="TxtValPago'.$XI.'" style="width:100px; text-align:right; font-size:10px" readonly="readonly" value="'.$XVALOR.'" />
		</td>
        <td align="center">
			<img src="images/icon-mas.png" width="15px" height="15px" style="cursor:pointer" onclick="FncAdicionarAbono()" />
			<img src="images/icon-menos.png" width="15px" height="15px" style="cursor:pointer" onclick="FncEliminarAbono('.$XI.')" />
			<input type="hidden" id="TxtIdAbono'.$XI.'" value="'.$XROWDET[10].'" />
			<input type="hidden" id="TxtIdPagoCli'.$XI.'" value="'.$XROWDET[11].'" />
		</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
        <td align="center">
			<select id="SlcPago">
				<option value=""></option>
				<option value="VISA">VISA</option>
			</select>
		</td>
    	<td align="center">
			<input type="text" id="TxtNumTc" style="width:120px; text-align:center; font-size:10px;" />
		</td>
        <td align="center">
			<input type="text" id="TxtDigito" style="width:40px; text-align:center; font-size:10px;" />
		</td>
        <td align="center">
			<input type="text" id="TxtCv" style="width:40px; text-align:center; font-size:10px;" />
		</td>
        <td align="right">
			<input type="text" id="TxtmmExpira" style="width:40px; text-align:center; font-size:10px" placeholder="MM" />
		</td>
        <td align="left">
			<input type="text" id="TxtaaExpira" style="width:40px; text-align:center; font-size:10px" placeholder="AA" />
		</td>
        <td align="right">
			<input type="text" id="TxtNombre" style="width:200px; text-align:center; font-size:10px; text-transform:uppercase" placeholder="NOMBRE" />
		</td>
        <td align="left">
			<input type="text" id="TxtApellido" style="width:200px; text-align:center; font-size:10px; text-transform:uppercase" placeholder="APELLIDO" />
		</td>
        <td align="center">
			<select id="SlcServPago">
				<option value=""></option>';
				$XOBJSER=new servicios;
				$XRSSER=$XOBJSER->ver_tipo_servicio();
				while($XROWSER=$XOBJSER->obtener_fila($XRSSER)){
					$XTABLA.='<option value="'.$XROWSER[0].'">'.$XROWSER[0].'</option>';
				}
			$XTABLA.='</select>
		</td>
        <td align="center">
			<input type="text" id="TxtValPago" style="width:60px; text-align:right; font-size:10px" />
		</td>
        <td align="center">
			<img src="images/icon-mas.png" width="15px" height="15px" style="cursor:pointer" onclick="FncAdicionarAbono()" />
			<img src="images/icon-menos.png" width="15px" height="15px" style="cursor:pointer" />
		</td>
	</tr>';
	return $XTABLA;
}

//PESTAÑA DISPONIBILIDAD
function FncTabClienteDisp($XLABEL, $XINFOCLI, $XINFORES){
	if($XINFORES[9]=="")$XINFORES[9]=0;
	if($XINFORES[4]=="")$XINFORES[4]=0;
	if($XINFORES[5]=="")$XINFORES[5]=0;
	if($XINFORES[3]=="")$XINFORES[3]=0;
   	$XTABLA='<tr>
       	<td align="left">
	       	'.$XLABEL[51].'
        </td>
       	<td align="left" colspan="5">'.$XINFOCLI[13].'</td>
       	<td align="right" rowspan="5">
			<table style="border:#BBB solid 1px; background-color:#ccc;">
				<tr>
					<td align="center"><strong>'.$XLABEL[60].':</strong></td>
				</tr>
				<tr>
					<td align="center"><strong>$ '.number_format($XINFORES[9]).'</strong></td>
				</tr>
				<tr>
					<td align="center"><strong>'.$XLABEL[94].':</strong></td>
				</tr>
				<tr>
					<td align="center"><strong>'.number_format($XINFORES[4]).'</strong></td>
				</tr>
				<tr>
					<td align="center"><strong>'.$XLABEL[95].':</strong></td>
				</tr>
				<tr>
					<td align="center"><strong>'.number_format($XINFORES[5]).'</strong></td>
				</tr>
				<tr>
					<td align="center"><strong>'.$XLABEL[32].':</strong></td>
				</tr>
				<tr>
					<td align="center"><strong>'.number_format($XINFORES[3]).'</strong></td>
				</tr>
			</table>
		</td>
	</tr>
    <tr>
   	   	<td align="left">
           	'.$XLABEL[93].'
        </td>
       	<td align="left" colspan="5">'.$XINFOCLI[4].' '.$XINFOCLI[5].'</td>
	</tr>
    <tr>
   	   	<td align="left">
           	'.$XLABEL[47].'
        </td>
       	<td align="left">'.$XINFOCLI[9].'</td>
   	   	<td align="left">
           	'.$XLABEL[50].'
        </td>
       	<td align="left" colspan="3">'.$XINFOCLI[12].'</td>
	</tr>
    <tr>
   	   	<td align="left">
           	'.$XLABEL[57].'
        </td>
       	<td align="left"></td>
   	  	<td align="left">
           	'.$XLABEL[58].'
        </td>
       	<td align="left"></td>
   	   	<td align="left">
           	'.$XLABEL[59].'
        </td>
       	<td align="left"></td>
    </tr>
	<tr>
       	<td align="left" colspan="6">
			<hr style="color:#BBB" width="100%" />			
		</td>
    </tr>
	<tr>
       	<td align="left" colspan="6">
			<strong>'.$XLABEL[61].'</strong>
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabHabitacionDisp($XLABEL, $XNUMRES){
	$XTABLA='<tr style="border:#BBB solid 1px; background-color:#fff;">
       	<td align="center"><strong>'.$XLABEL[33].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[64].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[34].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[80].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[36].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[67].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[68].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[27].'</strong></td>
      	<td align="center"><strong>'.$XLABEL[30].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[28].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[29].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[71].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[72].'</strong></td>
       	<td align="center"><strong>'.$XLABEL[96].'</strong></td>
	</tr>';
	$XOBJRES=new greservas;
	$XRSRES=$XOBJRES->ver_seleccion_habitaciones($XNUMRES);
	$XI=0;
	if($XOBJRES->numero_filas($XRSRES)<=0) $XROWSEL=array('','','','','','','','','','');
	while($XROWSEL=$XOBJRES->obtener_fila($XRSRES)){
		if($XROWSEL[5]=="") $XROWSEL[5]=0;
		$XIDHAB="'".$XROWSEL[0]."'";
		$XTABLA.='<tr id="RowHabDisp'.$XI.'" style="background-color:#FF9">
    	   	<td align="center">
				<input type="checkbox" id="ChkHabDisp'.$XI.'" checked="checked" onclick="FncSelecHabDisp('.$XI.')" />
				<input type="hidden" id="TxtNumHab'.$XI.'" value="'.$XROWSEL[0].'" />
				<input type="hidden" id="TxtTipoHab'.$XI.'" value="'.$XROWSEL[1].'" />
				<input type="hidden" id="TxtValTar'.$XI.'" value="'.$XROWSEL[5].'" />
			</td>
       		<td align="center">
				<a onclick="VerDetalleHabDisp('.$XIDHAB.')" style="cursor:pointer">'.$XROWSEL[0].'</a>
			</td>
	       	<td align="center">
				<a onclick="VerDetalleHabDisp('.$XIDHAB.')" style="cursor:pointer">'.$XROWSEL[11].'</a>
			</td>
    	   	<td align="center">
				<a onclick="VerDetalleHabDisp('.$XIDHAB.')" style="cursor:pointer">'.$XROWSEL[2].'</a>
			</td>
       		<td align="center">'.$XROWSEL[3].'</td>
	   		<td align="center">'.$XROWSEL[4].'</td>
	   		<td align="center">'.number_format($XROWSEL[5]).'</td>
    	   	<td align="center">'.cambiar_fecha($XROWSEL[6]).'</td>
      		<td align="center">'.cambiar_fecha($XROWSEL[7]).'</td>
	       	<td align="center">'.$XROWSEL[8].'</td>
    	   	<td align="center">'.$XROWSEL[9].'</td>
       		<td align="center"></td>
	       	<td align="center"></td>
    	   	<td align="center">
				<a onclick="VerDetalleHabDisp('.$XIDHAB.')" style="cursor:pointer">Detalle</a>
			</td>
		</tr>';
		$XI++;
	}
	$XRSRES=$XOBJRES->ver_habitaciones_libres();
	if($XOBJRES->numero_filas($XRSRES)<=0) $XROWSEL=array('','','','','','','','','','');
	while($XROWSEL=$XOBJRES->obtener_fila($XRSRES)){
		$XIDHAB="'".$XROWSEL[0]."'";
		$XTABLA.='<tr id="RowHabDisp'.$XI.'">
    	   	<td align="center">
				<input type="checkbox" id="ChkHabDisp'.$XI.'" onclick="FncSelecHabDisp('.$XI.')" />
				<input type="hidden" id="TxtNumHab'.$XI.'" value="'.$XROWSEL[0].'" />
				<input type="hidden" id="TxtTipoHab'.$XI.'" value="'.$XROWSEL[1].'" />
				<input type="hidden" id="TxtValTar'.$XI.'" value="'.$XROWSEL[5].'" />
			</td>
       		<td align="center">
				<a onclick="VerDetalleHabDisp('.$XIDHAB.')" style="cursor:pointer">'.$XROWSEL[0].'</a>
			</td>
	       	<td align="center">
				<a onclick="VerDetalleHabDisp('.$XIDHAB.')" style="cursor:pointer">'.$XROWSEL[6].'</a>
			</td>
    	   	<td align="center">
				<a onclick="VerDetalleHabDisp('.$XIDHAB.')" style="cursor:pointer">'.$XROWSEL[2].'</a>
			</td>
       		<td align="center">'.$XROWSEL[3].'</td>
	   		<td align="center">'.$XROWSEL[4].'</td>
	   		<td align="center">'.number_format($XROWSEL[5]).'</td>
    	   	<td align="center"></td>
      		<td align="center"></td>
	       	<td align="center"></td>
    	   	<td align="center"></td>
       		<td align="center"></td>
	       	<td align="center"></td>
    	   	<td align="center">
				<a onclick="VerDetalleHabDisp('.$XIDHAB.')" style="cursor:pointer">Detalle</a>
			</td>
		</tr>';
		$XI++;
	}
	$XTABLA.='<tr>
		<td>
			<input type="hidden" id="TxtLimHabDisp" value="'.$XI.'" />
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabDetallesHabitacion($XLABEL, $XNUMRES, $XIDHAB){
	$XOBJHAB=new habitaciones;
	$XRSHAB=$XOBJHAB->buscar_habitaciones($XIDHAB);
	$XROWHAB=$XOBJHAB->obtener_fila($XRSHAB);
	$XTABLA='
	<tr>
       	<td align="left" colspan="4">
			<hr style="color:#BBB" width="100%" />			
		</td>
    </tr>
	<tr>
     	<td align="center"><strong>'.$XLABEL[98].'</strong></td>
       	<td align="left"><strong>'.$XLABEL[64].' '.$XROWHAB[3].'</strong></td>
       	<td align="left"><strong>'.$XLABEL[99].' '.$XROWHAB[1].'</strong></td>
       	<td align="left"><strong>'.$XLABEL[100].' '.$XROWHAB[2].'</strong></td>
	</tr>
	<tr>
       	<td align="left" colspan="4">'.$XLABEL[101].': '.$XROWHAB[4].'</td>
	</tr>
	<tr>
       	<td align="center" width="50%" colspan="2" valign="top">';
			$XOBJMOB=new elementos;
			$XTXTNUMREGSERV=1;
			$XRSTOT=$XOBJMOB->total_mobiliario_reserva($XNUMRES, $XIDHAB);
			$XTOTALREGMOB=$XOBJMOB->numero_filas($XRSTOT);
			$XPAGSERV=ceil($XTOTALREGMOB/4);
			$XTABMOB=FncTabMobiliarioHab($XLABEL, $XNUMRES, $XIDHAB, $XTXTNUMREGSERV, $XPAGSERV);
			$XTABLA.=$XTABMOB;	
		$XTABLA.='</td>
       	<td align="center" width="50%" colspan="2" valign="top">';
			if(($XTXTNUMREGSERV=="")||($XTXTNUMREGSERV<=0)) $XTXTNUMREGSERV=1;
			$XRSTOT=$XOBJMOB->total_elementos_reserva($XNUMRES, $XIDHAB);
			$XTOTALREGMOB=$XOBJMOB->numero_filas($XRSTOT);
			$XPAGSERV=ceil($XTOTALREGMOB/4);
			$XTABMOB=FncTabElementosHab($XLABEL, $XNUMRES, $XIDHAB, $XTXTNUMREGSERV, $XPAGSERV);
			$XTABLA.=$XTABMOB;	
		$XTABLA.='</td>
	</tr>';
	return $XTABLA;
}

function FncTabMobiliarioHab($XLABEL, $XNUMRES, $XIDHAB, $XNUMREG, $XTOTREG){
	$XTABLA='<table width="100%" style="border:#BBB solid 1px; background-color:#fff;">
		<tr style="border:#BBB solid 1px; background-color:#fff;">
			<td align="left" colspan="2">
				<strong>'.$XLABEL[102].'</strong>
				<input type="hidden" id="TxtNumRegMob" value="'.$XNUMREG.'" />
				<input type="hidden" id="TxtTotRegMob" value="'.$XTOTREG.'" />
			</td>
			<td align="center" colspan="4">';
				$XTABLA.='<p class="paginacion" align="right" >';
				if($XNUMREG>1){ 
					$XP=$XNUMREG-1;
					$XTABLA.='<a onclick="FncVerMob('.$XP.')" style="cursor:pointer;"><img src="images/izq.gif" /></a>';
				}
				for($XJ=1;$XJ<=$XTOTREG;$XJ++){
					$XTABLA.='<a onclick="FncVerMob('.$XJ.')" style="cursor:pointer; color:#FFFFFF; padding:4px 6px;">'.$XJ.'</a> ';	
				}
				if(($XNUMREG<$XTOTREG)&&($XTOTREG>1)){ 
					$XP=$XNUMREG+1;
					$XTABLA.='<a onclick="FncVerMob('.$XP.')" style="cursor:pointer;"><img src="images/der.gif" /></a>';
				}
				$XTABLA.='</p>
			</td>
		</tr>
		<tr>
			<td><strong>'.$XLABEL[104].'</strong></td>
			<td><strong>'.$XLABEL[80].'</strong></td>
			<td><strong>'.$XLABEL[82].'</strong></td>
			<td><strong>'.$XLABEL[92].'</strong></td>
			<td><strong>'.$XLABEL[136].'</strong></td>
   			<td></td>
		</tr>';
		$XOBJMOB=new elementos;
		$XRES='0';
		$XOFFSET=($XNUMREG-1)*4;
		if($XOFFSET<0) $XOFFSET=0;
		$XRSMOB=$XOBJMOB->ver_mobiliario_reserva($XNUMRES, $XIDHAB, $XOFFSET,4);
		if($XOBJMOB->numero_filas($XRSMOB)!=0){
			while($XROWMOB=$XOBJMOB->obtener_fila($XRSMOB)){
				$XTABLA.='<tr>
					<td>'.$XROWMOB[0].'</td>
					<td>'.$XROWMOB[1].'</td>
					<td>'.$XROWMOB[2].'</td>
					<td>'.$XROWMOB[3].'</td>
					<td>'.$XROWMOB[4].'</td>
    				<td align="center">
						<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" >
						<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" >
					</td>
				</tr>';
			}
		}
		else{
			$XRSMOB=$XOBJMOB->ver_mobiliario_habitacion($XIDHAB);
			if($XOBJMOB->numero_filas($XRSMOB)!=0){
				while($XROWMOB=$XOBJMOB->obtener_fila($XRSMOB)){
					$XTABLA.='<tr>
						<td>'.$XROWMOB[0].'</td>
						<td>'.$XROWMOB[1].'</td>
						<td>'.$XROWMOB[2].'</td>
						<td>'.$XROWMOB[3].'</td>
   	    				<td></td>
   	    				<td align="center">
							<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" >
							<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" >
						</td>
					</tr>';
				}
			}
		}
		$XTABLA.='<tr>
			<td>
				<input type="text" id="TxtIdMob" style="width:40px; text-align:center; font-size:10px;" readonly="readonly" />
			</td>
			<td>
				<select id="SlcDesMob">
					<option value=""></option>';
					$XRSMOB=$XOBJMOB->ver_mobiliarios();
					while($XROWMOB=$XOBJMOB->obtener_fila($XRSMOB)){
						$XTABLA.='<option value="'.$XROWMOB[0].'">'.$XROWMOB[1].'</option>';
					}
				$XTABLA.='</select>
			</td>
			<td>
				<input type="text" id="TxtCanMob" style="width:40px; text-align:center; font-size:10px;" />
			</td>
			<td>
				<input type="text" id="TxtUniMob" style="width:60px; text-align:center; font-size:10px;" />
			</td>
			<td>
				<input type="text" id="TxtTotMob" style="width:60px; text-align:center; font-size:10px;" />
			</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" >
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" >
			</td>
		</tr>';
	$XTABLA.='</table>';
	return $XTABLA;
}

function FncTabElementosHab($XLABEL, $XNUMRES, $XIDHAB, $XNUMREG, $XTOTREG){
	$XTABLA='<table width="100%" style="border:#BBB solid 1px; background-color:#fff;">
		<tr style="border:#BBB solid 1px; background-color:#fff;">
			<td align="left" colspan="2">
				<strong>'.$XLABEL[103].'</strong>
				<input type="hidden" id="TxtNumRegElem" value="'.$XNUMREG.'" />
				<input type="hidden" id="TxtTotRegElem" value="'.$XTOTREG.'" />
			</td>
			<td align="center" colspan="5">';
				$XTABLA.='<p class="paginacion" align="right" >';
				if($XNUMREG>1){ 
					$XP=$XNUMREG-1;
					$XTABLA.='<a onclick="FncVerEle('.$XP.')" style="cursor:pointer;"><img src="images/izq.gif" /></a>';
				}
				for($XJ=1;$XJ<=$XTOTREG;$XJ++){
					$XTABLA.='<a onclick="FncVerEle('.$XJ.')" style="cursor:pointer; color:#FFFFFF; padding:4px 6px;">'.$XJ.'</a> ';	
				}
				if(($XNUMREG<$XTOTREG)&&($XTOTREG>1)){ 
					$XP=$XNUMREG+1;
					$XTABLA.='<a onclick="FncVerEle('.$XP.')" style="cursor:pointer;"><img src="images/der.gif" /></a>';
				}
				$XTABLA.='</p>
			</td>
		</tr>
		<tr>
			<td><strong>'.$XLABEL[105].'</strong></td>
			<td><strong>'.$XLABEL[80].'</strong></td>
			<td><strong>'.$XLABEL[106].'</strong></td>
			<td><strong>'.$XLABEL[82].'</strong></td>
			<td><strong>'.$XLABEL[92].'</strong></td>
			<td><strong>'.$XLABEL[136].'</strong></td>
  			<td></td>
		</tr>';
		$XOBJMOB=new elementos;
		$XRES='0';
		$XOFFSET=($XNUMREG-1)*4;
		if($XOFFSET<0) $XOFFSET=0;
		$XRSMOB=$XOBJMOB->ver_elementos_reserva($XNUMRES, $XIDHAB, $XOFFSET,4);
		if($XOBJMOB->numero_filas($XRSMOB)!=0){
			while($XROWMOB=$XOBJMOB->obtener_fila($XRSMOB)){
				$XTABLA.='<tr>
					<td>'.$XROWMOB[0].'</td>
					<td>'.$XROWMOB[1].'</td>
					<td>'.$XROWMOB[2].'</td>
					<td>'.$XROWMOB[3].'</td>
					<td>'.$XROWMOB[4].'</td>
					<td>'.$XROWMOB[5].'</td>
    				<td align="center">
						<img src="images/icon-mas.png" width="15px" height="15px" style="cursor:pointer" >
						<img src="images/icon-menos.png" width="15px" height="15px" style="cursor:pointer" >
					</td>
				</tr>';
			}
		}
		$XTABLA.='<tr>
			<td>
				<input type="text" id="TxtIdElem" style="width:40px; text-align:center; font-size:10px;" readonly="readonly" />
			</td>
			<td>
				<select id="SlcDesElem">
					<option value=""></option>';
					$XRSMOB=$XOBJMOB->ver_elementos();
					while($XROWMOB=$XOBJMOB->obtener_fila($XRSMOB)){
						$XTABLA.='<option value="'.$XROWMOB[0].'">'.$XROWMOB[1].'</option>';
					}
				$XTABLA.='</select>
			</td>
			<td>
				<input type="text" id="TxtTipoElem" style="width:40px; text-align:center; font-size:10px;" />
			</td>
			<td>
				<input type="text" id="TxtCanElem" style="width:40px; text-align:center; font-size:10px;" />
			</td>
			<td>
				<input type="text" id="TxtUniElem" style="width:60px; text-align:center; font-size:10px;" />
			</td>
			<td>
				<input type="text" id="TxtTotElem" style="width:60px; text-align:center; font-size:10px;" />
			</td>
			<td align="center">
				<img src="images/icon-mas.png" width="15px" height="15px" style="cursor:pointer" >
				<img src="images/icon-menos.png" width="15px" height="15px" style="cursor:pointer" >
			</td>
		</tr>';
	$XTABLA.='</table>';
	return $XTABLA;
}

//PESTAÑA CONFIRMAR
function FncTabClienteConf($XLABEL, $XINFOCLI, $XINFORES){
	if($XINFORES[9]=="") $XINFORES[9]=0;
   	$XTABLA='<tr>
       	<td align="left">
        	'.$XLABEL[51].'
   	    </td>
       	<td align="left" colspan="5">'.$XINFOCLI[13].'</td>
       	<td align="left">
        	'.$XLABEL[13].': '.$XINFORES[10].'
   	    </td>
       	<td align="right">
			<img src="images/icon-guardar.png" height="30px" width="30px" style="cursor:pointer" onclick="FncGuardarConfirmar()" />
			<img src="images/icon-impresora.png" height="30px" width="30px" style="cursor:pointer" />
		</td>
       	<td align="right" rowspan="4">
			<table style="border:#03F solid 2px; background-color:#ccc;">
				<tr>
					<td align="center"><strong>'.$XLABEL[60].':</strong></td>
				</tr>
				<tr>
					<td align="center"><strong>$ '.number_format($XINFORES[9]).'</strong></td>
				</tr>
				<tr>
					<td align="center"><strong>'.$XLABEL[111].':</strong></td>
				</tr>';
				$XOBJPAG=new pagos;
				$XRSTOT=$XOBJPAG->sumatoria_abonos_reserva($XINFORES[11]);
				$XROWSUM=$XOBJPAG->obtener_fila($XRSTOT);
				$XSUMATORIA=$XROWSUM[0];
				$XSALDO=$XINFORES[9]-$XSUMATORIA;
				$XTABLA.='<tr>
					<td align="center"><strong>$ '.number_format($XSALDO).'</strong></td>
				</tr>
			</table>
		</td>
	</tr>
   	<tr>
       	<td align="left">
        	'.$XLABEL[93].'
   	    </td>
       	<td align="left" colspan="5">'.$XINFOCLI[4].' '.$XINFOCLI[5].'</td>
       	<td align="left">
        	'.$XLABEL[108].'
   	    </td>
       	<td align="left"></td>
	</tr>
   	<tr>
       	<td align="left">
        	'.$XLABEL[47].'
   	    </td>
       	<td align="left">'.$XINFOCLI[9].'</td>
       	<td align="left">
        	'.$XLABEL[50].'
   	    </td>
       	<td align="left" colspan="5">'.$XINFOCLI[12].'</td>
	</tr>
   	<tr>
       	<td align="left">
        	'.$XLABEL[57].'
   	    </td>
       	<td align="left"></td>
       	<td align="left">
        	'.$XLABEL[58].'
   	    </td>
       	<td align="left"></td>
       	<td align="left">
	       	'.$XLABEL[59].'
        </td>
       	<td align="left"></td>
   	  	<td align="left">
           	'.$XLABEL[109].': 
			<select id="SlcEstRes">
				<option value="confirmada">Confirmada</option>
				<option value="anulada">Anulada</option>
			</select>
        </td>
       	<td align="left"></td>
	</tr>';
	return $XTABLA;
}

function FncTabPagosConf($XLABEL, $XNUMRES, $XPAGO){
	$XTABLA='<tr>
		<td colspan="8" align="left" >
			<strong>'.$XLABEL[129].'</strong>
		</td>
	</tr>
	<tr>
		<td colspan="8" align="left">
			<table id="TabDetallePagosConf" width="100%">';
				$XTABLA.=FncTabDetallePagosConf($XLABEL, $XNUMRES, $XPAGO);
			$XTABLA.='</table>
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabDetallePagosConf($XLABEL, $XNUMRES, $XPAGO){
	$XTABLA='<tr style="border:#BBB solid 1px; background-color:#fff;">
		<td>'.$XLABEL[64].'</td>
		<td>'.$XLABEL[34].'</td>
		<td>'.$XLABEL[80].'</td>
		<td>'.$XLABEL[68].'</td>
		<td>'.$XLABEL[117].'</td>
		<td>'.$XLABEL[118].'</td>
		<td>'.$XLABEL[130].'</td>
		<td>'.$XLABEL[131].'</td>
	</tr>';
	$XOBJPAG=new pagos;
	$XRSPAG=$XOBJPAG->ver_distribucion_reservas($XNUMRES, $XPAGO);
	while($XROWPAG=$XOBJPAG->obtener_fila($XRSPAG)){
		$XTABLA.='<tr>
			<td>'.$XROWPAG[0].'</td>
			<td>'.$XROWPAG[1].'</td>
			<td>'.$XROWPAG[2].'</td>
			<td>'.number_format($XROWPAG[3]).'</td>';
			$XTABLA.='<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>';
	}
	return $XTABLA;
}

//RESERVA

function FncTabDetallePagosRes($XLABEL, $XIDRES, $XVALOR){
	$XOBJPAG=new pagos;
	$XRSTOT=$XOBJPAG->sumatoria_abonos_reserva($XIDRES);
	$XROWSUM=$XOBJPAG->obtener_fila($XRSTOT);
	$XSUMATORIA=$XROWSUM[0];
	$XSALDO=$XVALOR-$XSUMATORIA;
	
	$XTABLA='<tr>
		<td width="60%" align="left">
			<strong>'.$XLABEL[139].'</strong>
		</td>
   	</tr>
	</table>
	<table>
	<tr>
       	<td align="right" height="30px" width="15%"><strong>'.$XLABEL[60].':</strong></td>
       	<td width="15%">
			<input type="hidden" id="TxtFecStay" value="'.date('d-m-Y').'" />
			<input type="text" id="TxtImpStay" style="width:120px; text-align:right;" value="'.number_format($XVALOR).'" readonly="readonly" />
		</td>
       	<td align="right" width="15%" ><strong>'.$XLABEL[69].':</strong></td>
       	<td width="15%">
			<select id="SlcMonStay">';
				$XOBJMON=new monedas;
				$XRSMON=$XOBJMON->ver_monedas();
				$XI=0;
				while($XROWMON=$XOBJMON->obtener_fila($XRSMON)){
					if($XI==0) $XMONEDA=$XROWMON[1];
					$XTABLA.='<option value="'.$XROWMON[0].'">'.$XROWMON[0].'</option>';
					$XI++;
				}
			$XTABLA.='</select>
			<input type="text" id="TxtCopStay" style="width:80px; text-align:center;" value="'.$XMONEDA.'" readonly="readonly" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[140].':</strong></td>
       	<td>
			<input type="text" id="TxtAbStay" style="width:120px; text-align:right;" value="'.number_format($XSUMATORIA).'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[111].':</strong></td>
       	<td>
			<input type="text" id="TxtSalStay" style="width:120px; text-align:right;" value="'.number_format($XSALDO).'" readonly="readonly" />
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabMetodoRes($XLABEL, $XMET, $XIDRES, $XPAG){
	$XMET=(int) $XMET;
	$XTABLA='<tr>
		<td align="left" colspan="7">
			<strong>'.$XLABEL[110].'</strong>
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncAdicionarStayPago()" />
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncEliminarStayPago()" />
		</td>
       	<td>';
			$XOBJPAG=new pagos;
			$XRSTOT=$XOBJPAG->total_abonos_xreserva($XIDRES);
			$XTOTPAG=$XOBJPAG->numero_filas($XRSTOT);

			//$XTOTPAG=$XOBJCTA->paginas_vales($XCTA, $XAMB);
			$XTABLA.='<p class="paginacion" align="right" >';
			if($XPAG>1){ 
				$XP=$XPAG-1;
				$XTABLA.='<a onclick="FncVerPago('.$XP.')" style="cursor:pointer;"><img src="images/izq.gif" /></a>';
			}
			for($XJ=1;$XJ<=$XTOTPAG;$XJ++){
				$XTABLA.='<a onclick="FncVerPago('.$XJ.')" style="cursor:pointer; color:#FFFFFF; padding:4px 6px;">'.$XJ.'</a> ';
			}
			if(($XPAG<$XTOTPAG)&&($XTOTPAG>1)){ 
				$XP=$XPAG+1;
				$XTABLA.='<a onclick="FncVerPago('.$XP.')" style="cursor:pointer;"><img src="images/der.gif" /></a>';
			}
			$XTABLA.='</p>';


//			for($XJ=1;$XJ<=$XPAG;$XJ++){
	//			$XTABLA.='<a onclick="FncVerPago('.$XJ.')" style="cursor:pointer;">'.$XJ.'</a> ';
		//	}
		$XTABLA.='</td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[120].':</strong></td>
       	<td align="center">
			<select id="SlcMetStay" onchange="FncValidarMedio()">';
				$XOBJMED=new medios;
				$XRSMED=$XOBJMED->ver_medios_vales();
				while($XROWMED=$XOBJMED->obtener_fila($XRSMED)){
					$XTABLA.='<option value="'.$XROWMED[0].'">'.$XROWMED[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[119].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtIdPago" style="width:60px; text-align:center;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[112].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtFecPago" style="width:120px; text-align:center;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ></td>
       	<td align="center"></td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[117].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtPorcPago" style="width:60px; text-align:right;" value="" onkeyup="FncCalcPagoPrc()" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[118].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtValorPago" style="width:120px; text-align:right;" value="" onkeyup="FncCalcPagoVal()" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[115].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtBasePago" style="width:120px; text-align:right;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[116].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtIvasPago" style="width:120px; text-align:right;" value="" readonly="readonly" />
		</td>
   	</tr>
	<tr>
       	<td align="right" height="30px">
			<div id="trtc1" style="display:none;">
				<strong>'.$XLABEL[121].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc2" style="display:none;">
				<select id="SlcFranStay">
					<option value=""></option>';
					$XOBJFRAN=new franquicias;
					$XRSFRAN=$XOBJFRAN->ver_franquicias();
					while($XROWFRAN=$XOBJFRAN->obtener_fila($XRSFRAN)){
						$XTABLA.='<option value="'.$XROWFRAN[0].'">'.$XROWFRAN[1].'</option>';
					}
				$XTABLA.='</select>
			</div>
		</td>
       	<td align="right" height="30px">
			<div id="trtc3" style="display:none;">
				<strong>'.$XLABEL[122].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc4" style="display:none;">
				<input type="text" id="TxtTcStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right" height="30px">
			<div id="trtc5" style="display:none;">
				<strong>'.$XLABEL[126].':</strong>
			</div>
		</td>
       	<td align="center" colspan="2">
			<div id="trtc6" style="display:none;">
				<input type="text" id="TxtTitStay" style="width:300px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
    </tr>
	<tr>
       	<td align="right" >
			<div id="trtc7" style="display:none;">
				<strong>'.$XLABEL[124].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc8" style="display:none;">
				<input type="text" id="TxtExpStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right" >
			<div id="trtc9" style="display:none;">
				<strong>'.$XLABEL[125].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc10" style="display:none;">
				<input type="text" id="TxtDigStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right">
			<div id="trtc11" style="display:none;">
				<strong>'.$XLABEL[127].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc12" style="display:none;">
				<input type="text" id="TxtCodStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right">
			<div id="trtc13" style="display:none;">
				<strong>'.$XLABEL[128].':</strong>
			</td>
       	<td align="center">
			<div id="trtc14" style="display:none;">
				<input type="text" id="TxtHorStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
    </tr>
	<tr>
       	<td align="center" colspan="8" height="30px">
			<input type="button" id="BtnPagar" value="';
				if($XMET!='2') 
					$XTABLA.=$XLABEL[123].'" onclick="FncAdicionarPagos()" />';
				else 
					$XTABLA.=$XLABEL[123].'" onclick="FncAdicionarPagos()" />';
		$XTABLA.='</td>
    </tr>';
	return $XTABLA;	
}



//PESTAÑA ALERTAS
function FncTabClienteAler($XLABEL, $XINFOCLI, $XINFORES){
   	$XTABLA='<tr>
       	<td align="left">
	       	'.$XLABEL[51].'
        </td>
       	<td align="left" colspan="5">'.$XINFOCLI[13].'</td>
	</tr>
    <tr>
   	   	<td align="left">
           	'.$XLABEL[93].'
        </td>
       	<td align="left" colspan="5">'.$XINFOCLI[4].' '.$XINFOCLI[5].'</td>
	</tr>
    <tr>
   	   	<td align="left">
           	'.$XLABEL[47].'
        </td>
       	<td align="left">'.$XINFOCLI[9].'</td>
   	   	<td align="left">
           	'.$XLABEL[50].'
        </td>
       	<td align="left" colspan="3">'.$XINFOCLI[12].'</td>
	</tr>
    <tr>
   	   	<td align="left">
           	'.$XLABEL[57].'
        </td>
       	<td align="left"></td>
   	  	<td align="left">
           	'.$XLABEL[58].'
        </td>
       	<td align="left"></td>
   	   	<td align="left">
           	'.$XLABEL[59].'
        </td>
       	<td align="left"></td>
    </tr>
	<tr>
       	<td align="left" colspan="6" width="100%">
			<hr style="color:#BBB" width="100%" />			
		</td>
	</tr>
	<tr>
       	<td align="left" colspan="6" width="100%">
			<table id="TabDetAlertas" width="100%">';
				$XTABLA.=FncTabDetalleAlertas($XLABEL, $XINFORES[11]);
			$XTABLA.='</table>
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabDetalleAlertas($XLABEL, $XNUMRES){
   	$XTABLA='<tr>
		<td width="40%" align="left" colspan="6">
			<strong>'.$XLABEL[137].'</strong>
		</td>
   	</tr>
	<tr>
		<td align="center"><strong>'.$XLABEL[64].'</strong></td>
    	<td align="center"><strong>'.$XLABEL[138].'</strong></td>
    	<td align="center" colspan="3"><strong>'.$XLABEL[76].'</strong></td>
    	<td align="center" ></td>
	</tr>';
	$XOBJALR=new alertas;
	$XRSALR=$XOBJALR->ver_alertas($XNUMRES);
	$XI=0;
	while($XROWALR=$XOBJALR->obtener_fila($XRSALR)){
		$XTABLA.='<tr>
			<td align="center">
				<select id="SlcAlrHab'.$XI.'">
					<option value="'.$XROWALR[0].'">'.$XROWALR[0].'</option>
				</select>
			</td>
			<td align="center">
				<select id="SlcAlrDep'.$XI.'">
					<option value="'.$XROWALR[1].'">'.$XROWALR[2].'</option>
				</select>
			</td>
			<td align="center" colspan="3">
				<textarea id="TxtAlrObs'.$XI.'" style="width:500px; height:40px; text-align:left; font-size:10px;">
					'.$XROWALR[3].'
				</textarea>
			</td>
			<td align="center">
				<img src="images/icon-mas.png" width="25px" height="25px" style="cursor:pointer" onclick="FncActualizarAlerta('.$XI.')" >
				<img src="images/icon-menos.png" width="25px" height="25px" style="cursor:pointer" onclick="FncEliminarAlerta('.$XROWALR[5].')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
    	<td align="center">
			<select id="SlcAlrHab">
				<option value=""></option>';
				$XOBJRES=new greservas;
				$XRSHAB=$XOBJRES->ver_seleccion_habitaciones($XNUMRES);
				while($XROWHAB=$XOBJRES->obtener_fila($XRSHAB)){
					$XTABLA.='<option value="'.$XROWHAB[0].'">'.$XROWHAB[0].'</option>';
				}
			$XTABLA.='</select>
		</td>
        <td align="center">
			<select id="SlcAlrDep">
				<option value="0"></option>';
				$XOBJDEP=new departamentos;
				$XRSDEP=$XOBJDEP->ver_departamentos();
				while($XROWDEP=$XOBJDEP->obtener_fila($XRSDEP)){
					$XTABLA.='<option value="'.$XROWDEP[0].'">'.$XROWDEP[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
        <td align="center" colspan="3">
			<textarea id="TxtAlrObs" style="width:500px; height:40px; text-align:left; font-size:10px;"></textarea>
		</td>
        <td align="center">
			<img src="images/icon-mas.png" width="25px" height="25px" style="cursor:pointer" onclick="FncAdicionarAlertas()" />
			<img src="images/icon-menos.png" width="25px" height="25px" style="cursor:pointer" onclick="FncEliminarAlerta()" />
		</td>
	</tr>';
	return $XTABLA;
}

//BUSQUEDA DE CLIENTES
function FncTabBuscarClientes($XLABEL, $XINFO, $XSIGNOS, $XBUSCAR){
  	$XTABLA='<tr style="background-color:#a0cee6">
       	<td align="center">'.$XLABEL[40].'</td>
       	<td align="center">'.$XLABEL[42].'</td>
      	<td align="center">'.$XLABEL[62].'</td>
       	<td align="center">'.$XLABEL[45].'</td>
       	<td align="center">'.$XLABEL[47].'</td>
       	<td align="center">'.$XLABEL[50].'</td>
       	<td align="center">'.$XLABEL[51].'</td>
   	</tr>';
	$XOBJCLI=new clientes;
	if($XBUSCAR=="2"){
		$XRSCLI=$XOBJCLI->busqueda_avanzada_clientes($XINFO,$XSIGNOS,0,100);
	}
	else{
		$XIDCLI=$XINFO[0];
		$XNOMCLI=$XINFO[1];
		$XIDTER=$XINFO[2];
		$XNOMTER=$XINFO[3];
		$XRSCLI=$XOBJCLI->busqueda_basica_clientes($XIDCLI,$XNOMCLI,$XIDTER,$XNOMTER,0,100);
	}
	while($XROWCLI=$XOBJCLI->obtener_fila($XRSCLI)){
		$XIDCLI="'".$XROWCLI[0]."'";
		$XTABLA.='<tr>
        	<td>
				<a onclick="FncBuscarCliente('.$XIDCLI.')" style="cursor:pointer">'.$XROWCLI[0].'</a>
			</td>
   	    	<td>'.$XROWCLI[1].'</td>
       	   	<td>
				<a onclick="FncBuscarCliente('.$XIDCLI.')" style="cursor:pointer">'.$XROWCLI[2].' '.$XROWCLI[3].'</a>
			</td>
       		<td>'.$XROWCLI[4].'</td>
   	       	<td>'.$XROWCLI[5].'</td>
   	       	<td>'.$XROWCLI[6].'</td>
   	       	<td>'.$XROWCLI[7].'</td>
   	   	</tr>';
	}
	return $XTABLA;
}

//DISPONIBILIDAD
function FncTabFiltroRes($XLABEL, $XFECHA, $XBLOQUE, $XESTADO, $XTIPOHAB){
	$XTIT3=explode(' ',$XLABEL[2]);
	$XTIT4=explode(' ',$XLABEL[6]);
	$XTIT5=explode(' ',$XLABEL[7]);
	$XTIT6=explode(' ',$XLABEL[9]);
	$XTIT7=explode('/',$XLABEL[5]);
	$XTABLA='<tr>
   		<td align="center"><strong>'.$XLABEL[8].'</strong></td>
   		<td align="center"><strong>'.$XTIT3[0].'<br />'.$XTIT3[1].'</strong></td>
       	<td align="center"><strong>'.$XTIT4[0].'<br />'.$XTIT4[1].'</strong></td>
       	<td align="center"><strong>'.$XTIT5[0].'<br />'.$XTIT5[1].'</strong></td>
    	<td align="center"><strong>'.$XTIT6[0].'<br />'.$XTIT6[1].'</strong></td>
   		<td align="center"><strong>'.$XTIT7[0].'/<br />'.$XTIT7[1].'</strong></td>
   	</tr>';
	$XOBJDIS=new disponibilidad;
	$XI=0;
	$XRSDIS=$XOBJDIS->ver_filtro_reservas2 ($XFECHA, $XBLOQUE, $XESTADO, $XTIPOHAB);
//	$XTABLA.='<tr><td align="center">'.$XRSDIS.'</td></tr>';
	while($XROWDIS=$XOBJDIS->obtener_fila($XRSDIS)){
		$XTABLA.='<tr>
   			<td align="center">
				<input type="checkbox" id="ChkHabDis'.$XI.'" />
			</td>
   			<td align="center">
				<a href="?sec=modulos/reservas/greservas&reserva='.$XROWDIS[7].'" style="color:'.$XROWDIS[6].'" >
					'.$XROWDIS[9].'
				</a>
			</td>
	       	<td align="center"">
				<a href="?sec=modulos/reservas/greservas&reserva='.$XROWDIS[7].'" style="color:'.$XROWDIS[6].'" >
					'.strtoupper($XROWDIS[1]).'
				</a>
			</td>
    	   	<td align="center"">
				<a href="?sec=modulos/reservas/greservas&reserva='.$XROWDIS[7].'" style="color:'.$XROWDIS[6].'" >
					'.$XROWDIS[2].'
				</a>
			</td>
    		<td align="center">
				<a href="?sec=modulos/reservas/greservas&reserva='.$XROWDIS[7].'" style="color:'.$XROWDIS[6].'" >
					'.strtoupper($XROWDIS[3]).'
				</a>
			</td>
			<td align="center">
				<a href="?sec=modulos/reservas/greservas&reserva='.$XROWDIS[7].'" style="color:'.$XROWDIS[6].'" >
					'.$XROWDIS[4].'/'.$XROWDIS[5].'
				</a>
			</td>
   		</tr>';
		$XI++;
	}
	return $XTABLA;
}

function FncTabPlanHab($XLABEL, $XFECHA, $XBLOQUE, $XESTADO, $XTIPOHAB){
	$XTIT3=explode(' ',$XLABEL[2]);
	$XTIT4=explode(' ',$XLABEL[6]);
	$XTIT5=explode(' ',$XLABEL[7]);
	$XTABLA='<tr style="border:0px;">
		<td align="center"></td>
		<td align="center"><input type="hidden" id="TxtFecIni" value="'.$XFECHA.'"></td>
		<td align="left"><img src="images/izq.gif" style="cursor:pointer;" onclick="FncRecorrerFecha(1)" /></td>
		<td align="left"></td>
		<td align="center"></td>
		<td align="center"></td>
		<td align="center"></td>
		<td align="right"><img src="images/der.gif" style="cursor:pointer;" onclick="FncRecorrerFecha(2)" /></td>
	</tr>
	<tr>
   		<td align="center" style="background-color:#CFE4EF;">'.$XTIT3[0].'<br />'.$XTIT3[1].'</td>
       	<td align="center" style="background-color:#CFE4EF;">'.$XTIT5[0].'<br />'.$XTIT5[1].'</td>';
		for($i=0;$i<6;$i++){
			$nfecha=operar_fechas($XFECHA,$i,'2');
			$ndia = date('w',strtotime($nfecha));
			$labfec=cambiar_fecha($nfecha);
			$dia=retornar_dia($ndia);
			$XTABLA.='<td align="center" style="background-color:#CFE4EF;">'.$dia.'<br />'.$labfec.'</td>';
		}
   	$XTABLA.='</tr>';
	$XOBJHAB=new habitaciones;
	$XOBJDIS=new disponibilidad;
	$XRSHAB=$XOBJHAB->ver_habitaciones();
	while($XROWHAB=$XOBJHAB->obtener_fila($XRSHAB)){
		$XTABLA.='<tr>
   			<td align="center" style="background-color:#CFE4EF;">'.$XROWHAB[1].'</td>
   			<td align="center" style="background-color:#CFE4EF;">'.$XROWHAB[4].'</td>';
			for($i=0;$i<6;$i++){
				$nfecha=operar_fechas($XFECHA,$i,'2');
				$ndia = date('w',strtotime($nfecha));
				$labfec=cambiar_fecha($nfecha);
				$dia=retornar_dia($ndia);
				$fechab=cambiar_fecha($labfec);
				$XRSPLAN=$XOBJDIS->ver_planhab ($fechab, $XROWHAB[0]);
				if($XOBJDIS->numero_filas($XRSPLAN)!=0){
					$XROWPLAN=$XOBJDIS->obtener_fila($XRSPLAN);
					$XCODIGO="'".$XROWPLAN[0]."'";
					$XTABLA.='<td align="center" style="background-color:'.$XROWPLAN[2].';">
						<a onclick="PrcEncontrarReserva('.$XCODIGO.')"  style="cursor:pointer">
							'.$XROWPLAN[1].'<br />'.$XROWPLAN[0].'
						</a>
					</td>';
				}
				else{
					$XRSPLAN=$XOBJDIS->ver_planres ($fechab, $XROWHAB[0]);
					if($XOBJDIS->numero_filas($XRSPLAN)!=0){
						$XROWPLAN=$XOBJDIS->obtener_fila($XRSPLAN);
						$idres="'".$XROWPLAN[0]."'";
						$div="'verDeta2'";
						$XTABLA.='<td align="center" style="background-color:'.$XROWPLAN[2].';">
							<a onclick="verDetaHab('.$idres.', '.$div.')"  style="cursor:pointer">
								'.$XROWPLAN[1].'<br />'.$XROWPLAN[0].'
							</a>
						</td>';
					}
					else{
						$XTABLA.='<td align="center"></td>';
					}
				}
			}
   		$XTABLA.='</tr>';
	}
	//RESERVAS
	/*$pfecha=operar_fechas($XFECHA,5,'2');
	$XRSHAB=$XOBJDIS->ver_reservas_fechas($XFECHA, $pfecha);
	while($XROWHAB=$XOBJDIS->obtener_fila($XRSHAB)){
		$XTABLA.='<tr>
		<td align="center" style="background-color:#CFE4EF;"></td>
		<td align="center" style="background-color:#CFE4EF;">'.$XROWHAB[1].'</td>';
		for($i=0;$i<6;$i++){
			$nfecha=operar_fechas($XFECHA,$i,'2');
			$ndia = date('w',strtotime($nfecha));
			$labfec=cambiar_fecha($nfecha);
			$dia=retornar_dia($ndia);
			$fechab=cambiar_fecha($labfec);
			$XRSPLAN=$XOBJDIS->ver_plan_reserva ($fechab, $XROWHAB[0]);
			if($XOBJDIS->numero_filas($XRSPLAN)!=0){
				$XROWPLAN=$XOBJDIS->obtener_fila($XRSPLAN);
				$idres="'".$XROWPLAN[0]."'";
				$div="'verDeta2'";
				$XTABLA.='<td align="center" style="background-color:'.$XROWPLAN[2].';">
					<a onclick="verDetaHab('.$idres.', '.$div.')" style="cursor:pointer;">
						'.$XROWPLAN[1].'<br />'.$XROWPLAN[0].'
					</a>
				</td>';
			}
			else{
				$XTABLA.='<td align="center"></td>';
			}
		}
   		$XTABLA.='</tr>';
	}*/
	return $XTABLA;
}

//PAGINA RECEPCION - CARGOS A CUENTAS

function FncTabCargosCli($XLABEL, $XINFO){
	$XTABLA='<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[9].':</strong></td>
       	<td align="center">'.$XINFO[0].'
			<input type="hidden" id="TxtIdCliCar" value="'.$XINFO[0].'" />
		</td>
       	<td align="right"><strong>'.$XLABEL[7].':</strong></td>
    	<td>
			<select id="SlcAmbCar" onchange="FncVerConsumosHuespedes()">
				<option value=""></option>';
				$XOBJAMB=new ambientes;
				$XRSAMB=$XOBJAMB->ver_ambientes();
				while($XROWAMB=$XOBJAMB->obtener_fila($XRSAMB)){
					$XTABLA.='<option value="'.$XROWAMB[0].'">'.utf8_encode($XROWAMB[1]).'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right"><strong>'.$XLABEL[8].':</strong></td>
	   	<td>
			<input type="text" id="TxtValCar" style="width:120px; text-align:right;" readonly="readonly" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" ><strong>'.$XLABEL[11].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[12].':</strong></td>
       	<td>'.$XINFO[5].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[13].':</strong></td>
       	<td>'.$XINFO[6].'</td>
       	<td align="right"><strong>'.$XLABEL[14].':</strong></td>
      	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[15].':</strong></td>
       	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[16].':</strong></td>
       	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[17].':</strong></td>
      	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[18].':</strong></td>
       	<td>'.$XINFO[11].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabDetalleCons($XLABEL, $XCTA, $XAMB, $XNUMREG, $XTOTREG){
	$XOFFSET=($XNUMREG-1)*8;
	if($XOFFSET<0) $XOFFSET=0;
	$XOBJCTA=new cuentas;
	$XRSDET=$XOBJCTA->ver_detalle_cuentas($XCTA, $XAMB,$XOFFSET,8);
	$XFILAS=$XOBJCTA->numero_filas($XRSDET);
   	$XTABLA='<div class="container">
	<input type="hidden" id="TxtNumRegCons" value="'.$XNUMREG.'" />
	<input type="hidden" id="TxtTotRegCons" value="'.$XTOTREG.'" />
	<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[19].'</caption>';
	/*<tr>
		<td width="50%" align="left" colspan="8">
			<strong>'.$XLABEL[19].'</strong>
			<input type="hidden" id="TxtNumRegCons" value="'.$XNUMREG.'" />
			<input type="hidden" id="TxtTotRegCons" value="'.$XTOTREG.'" />
		</td>
		<td>'.$XLABEL[20].'</td>
		<td align="center">
			<a onclick="FncPrimerCons()" style="cursor:pointer">'.$XLABEL[21].'</a>
			<img src="images/arrow_l.png" width="20px" height="15px" style="cursor:pointer;" onclick="FncAnteriorCons()" />
		</td>
		<td style="background-color:#fff;" align="center" >
			'.$XNUMREG.' '.$XLABEL[35].' '.$XTOTREG.'
		</td>
		<td align="center">
			<img src="images/arrow_r.png" width="20px" height="15px" style="cursor:pointer;" onclick="FncSiguienteCons()" />
			<a onclick="FncUltimoCons()" style="cursor:pointer">'.$XLABEL[22].'</a>
		</td>
   	</tr>*/
	$XTABLA.='<tr>
		<th width="60px">'.$XLABEL[23].'</th>
    	<th width="240px">'.$XLABEL[24].'</th>
    	<th width="50px">'.$XLABEL[25].'</th>
    	<th width="20px">'.$XLABEL[26].'</th>
    	<th width="60px">'.$XLABEL[27].'</th>
    	<th width="20px">'.$XLABEL[28].'</th>
    	<th width="50px">'.$XLABEL[48].'</th>
    	<th width="50px">'.$XLABEL[29].'</th>
    	<th width="50px">'.$XLABEL[30].'</th>
    	<th width="50px">'.$XLABEL[31].'</th>
    	<th width="60px">'.$XLABEL[32].'</th>';
		if($XFILAS<=0){
			$XTABLA.='<th>
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</th>
			<th>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" />
			</th>';
		}
	$XTABLA.='</tr>';
	//if(($XCTA=="")||($XCTA<="0")) $XCTA='1';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="center">'.$XROWDET[0].'
				<input type="hidden" id="TxtIdCons'.$XI.'" value="'.$XROWDET[0].'" />
			</td>
			<td align="center">'.$XROWDET[2].'
				<input type="hidden" id="HddProdCons'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.$XROWDET[6].'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'
				<input type="hidden" id="HddIvaCons'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</td>
			<td>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncEliminarCons('.$XIDCONSUMO.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='</table>
	<div>
	<table id="TdDetalleCons" style="display:none" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<input type="hidden" id="TxtIdCons" />
			<select id="SlcDescCons">
				<option value=""></option>';
				$XOBJPROD=new productos;
				$XRSPROD=$XOBJPROD->ver_productos();
				while($XROWPROD=$XOBJPROD->obtener_fila($XRSPROD)){
					$XTABLA.='<option value="'.$XROWPROD[0].'">'.$XROWPROD[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
		<td align="right">
			<input type="text" id="TxtVlrCons" style="width:50px; text-align:right; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="center">
			<input type="text" id="TxtCanCons" style="width:20px; text-align:center; font-size:10px;" value="" onfocus="FncSelProdHuesped()" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtStCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly"  onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtPorCons" style="width:20px; text-align:center; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtDscCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="left">
			<input type="text" id="TxtBasCons" style="width:50px; text-align:right; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtIvaCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
			<input type="hidden" id="HddIvaCons" />
		</td>
		<td align="center">
			<input type="text" id="TxtPropCons" style="width:30px; text-align:right; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtTotCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly" />
		</td>
       	<td align="center">
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncAdiConsumosCargo()" title="Adicionar Consumo" />
		</td>
		<td>
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncOcultarFilaConsumos()" />
		</td>
	</tr>
	</table>
	<script>
		$("#TxtTotCons").keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == "13"){
        		FncAdiConsumosCargo(); 
    		}	
		});
	</script>
	<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Ver todos los Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input
					.val( "" )
					.attr( "title", value + " No Coincide con ningun Registro" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#SlcDescCons" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#SlcDescCons" ).toggle();
		});

	});
	</script>';
	return $XTABLA;
}

function FncTabPaidOut($XLABEL, $XINFO){
	$XTABLA='<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[9].':</strong></td>
       	<td align="center">'.$XINFO[0].'
			<input type="hidden" id="TxtIdCliPaid" value="'.$XINFO[0].'" />
		</td>
       	<td align="right"><strong>'.$XLABEL[7].':</strong></td>
    	<td>
			<select id="SlcAmbPaid" onchange="FncVerConsumosPaidOut()">
				<option value=""></option>';
				$XOBJAMB=new ambientes;
				$XRSAMB=$XOBJAMB->ver_ambientes();
				while($XROWAMB=$XOBJAMB->obtener_fila($XRSAMB)){
					$XTABLA.='<option value="'.$XROWAMB[0].'">'.utf8_encode($XROWAMB[1]).'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right"><strong>'.$XLABEL[8].':</strong></td>
	   	<td>
			<input type="text" id="TxtValPaid" style="width:120px; text-align:right;" readonly="readonly" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" ><strong>'.$XLABEL[11].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[12].':</strong></td>
       	<td>'.$XINFO[5].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[13].':</strong></td>
       	<td>'.$XINFO[6].'</td>
       	<td align="right"><strong>'.$XLABEL[14].':</strong></td>
      	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[15].':</strong></td>
       	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[16].':</strong></td>
       	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[17].':</strong></td>
      	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[18].':</strong></td>
       	<td>'.$XINFO[11].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabDetallePaid($XLABEL, $XCTA, $XAMB, $XNUMREG, $XTOTREG){
	$XOFFSET=($XNUMREG-1)*8;
	if($XOFFSET<0) $XOFFSET=0;
	$XOBJCTA=new cuentas;
	$XRSDET=$XOBJCTA->ver_detalle_cuentas($XCTA, $XAMB,$XOFFSET,8);
	$XFILAS=$XOBJCTA->numero_filas($XRSDET);
   	$XTABLA='<div class="container">
	<input type="hidden" id="TxtNumRegPaid" value="'.$XNUMREG.'" />
	<input type="hidden" id="TxtTotRegPaid" value="'.$XTOTREG.'" />
	<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[19].'</caption>';
	/*<tr>
		<td width="50%" align="left" colspan="8">
			<strong>'.$XLABEL[19].'</strong>
			<input type="hidden" id="TxtNumRegCons" value="'.$XNUMREG.'" />
			<input type="hidden" id="TxtTotRegCons" value="'.$XTOTREG.'" />
		</td>
		<td>'.$XLABEL[20].'</td>
		<td align="center">
			<a onclick="FncPrimerCons()" style="cursor:pointer">'.$XLABEL[21].'</a>
			<img src="images/arrow_l.png" width="20px" height="15px" style="cursor:pointer;" onclick="FncAnteriorCons()" />
		</td>
		<td style="background-color:#fff;" align="center" >
			'.$XNUMREG.' '.$XLABEL[35].' '.$XTOTREG.'
		</td>
		<td align="center">
			<img src="images/arrow_r.png" width="20px" height="15px" style="cursor:pointer;" onclick="FncSiguienteCons()" />
			<a onclick="FncUltimoCons()" style="cursor:pointer">'.$XLABEL[22].'</a>
		</td>
   	</tr>*/
	$XTABLA.='<tr>
		<th width="60px">'.$XLABEL[23].'</th>
    	<th width="240px">'.$XLABEL[24].'</th>
    	<th width="50px">'.$XLABEL[25].'</th>
    	<th width="20px">'.$XLABEL[26].'</th>
    	<th width="60px">'.$XLABEL[27].'</th>
    	<th width="20px">'.$XLABEL[28].'</th>
    	<th width="50px">'.$XLABEL[48].'</th>
    	<th width="50px">'.$XLABEL[29].'</th>
    	<th width="50px">'.$XLABEL[30].'</th>
    	<th width="50px">'.$XLABEL[31].'</th>
    	<th width="60px">'.$XLABEL[32].'</th>';
		if($XFILAS<=0){
			$XTABLA.='<th>
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaPaid()" >
			</th>
			<th>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" />
			</th>';
		}
	$XTABLA.='</tr>';
	//if(($XCTA=="")||($XCTA<="0")) $XCTA='1';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="center">'.$XROWDET[0].'
				<input type="hidden" id="TxtIdPaid'.$XI.'" value="'.$XROWDET[0].'" />
			</td>
			<td align="center">'.$XROWDET[2].'
				<input type="hidden" id="HddProdPaid'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.$XROWDET[6].'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'
				<input type="hidden" id="HddIvaPaid'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaPaid()" >
			</td>
			<td>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncEliminarPaid('.$XIDCONSUMO.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='</table>
	<div>
	<table id="TdDetallePaid" style="display:none" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<input type="hidden" id="TxtIdPaid" />
			<select id="SlcDescPaid">
				<option value=""></option>';
				$XOBJPROD=new productos;
				$XRSPROD=$XOBJPROD->ver_productos();
				while($XROWPROD=$XOBJPROD->obtener_fila($XRSPROD)){
					$XTABLA.='<option value="'.$XROWPROD[0].'">'.$XROWPROD[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
		<td align="right">
			<input type="text" id="TxtVlrPaid" style="width:50px; text-align:right; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="center">
			<input type="text" id="TxtCanPaid" style="width:20px; text-align:center; font-size:10px;" value="" onfocus="FncSelProdPaid()" onblur="FncCalcProdPaid()" />
		</td>
		<td align="center">
			<input type="text" id="TxtStPaid" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly"  onblur="FncCalcProdPaid()" />
		</td>
		<td align="center">
			<input type="text" id="TxtPorPaid" style="width:20px; text-align:center; font-size:10px" value="" onblur="FncCalcProdPaid()" />
		</td>
		<td align="center">
			<input type="text" id="TxtDscPaid" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdPaid()" />
		</td>
		<td align="left">
			<input type="text" id="TxtBasPaid" style="width:50px; text-align:right; font-size:10px" value="" onblur="FncCalcProdPaid()" />
		</td>
		<td align="center">
			<input type="text" id="TxtIvaPaid" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdPaid()" />
			<input type="hidden" id="HddIvaPaid" />
		</td>
		<td align="center">
			<input type="text" id="TxtPropPaid" style="width:30px; text-align:right; font-size:10px" value="" onblur="FncCalcProdPaid()" />
		</td>
		<td align="center">
			<input type="text" id="TxtTotPaid" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly" />
		</td>
       	<td align="center">
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncAdicionarPaid()" />
		</td>
		<td>
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncOcultarFilaPaid()" />
		</td>
	</tr>
	</table>
	<script>
		$("#TxtTotPaid").keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == "13"){
        		FncAdicionarPaid(); 
    		}	
		});
	</script>
	<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Ver todos los Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input
					.val( "" )
					.attr( "title", value + " No Coincide con ningun Registro" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#SlcDescPaid" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#SlcDescPaid" ).toggle();
		});

	});
	</script>';
	return $XTABLA;
}

function FncTabExtra($XLABEL, $XINFO){
	$XTABLA='<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[9].':</strong></td>
       	<td align="center">'.$XINFO[0].'
			<input type="hidden" id="TxtIdCliExtra" value="'.$XINFO[0].'" />
		</td>
       	<td align="right"><strong>'.$XLABEL[7].':</strong></td>
    	<td>
			<select id="SlcAmbExtra" onchange="FncVerConsExtra()">
				<option value=""></option>';
				$XOBJAMB=new ambientes;
				$XRSAMB=$XOBJAMB->ver_ambientes();
				while($XROWAMB=$XOBJAMB->obtener_fila($XRSAMB)){
					$XTABLA.='<option value="'.$XROWAMB[0].'">'.utf8_encode($XROWAMB[1]).'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right"><strong>'.$XLABEL[8].':</strong></td>
	   	<td>
			<input type="text" id="TxtValExtra" style="width:120px; text-align:right;" readonly="readonly" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" ><strong>'.$XLABEL[11].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[12].':</strong></td>
       	<td>'.$XINFO[5].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[13].':</strong></td>
       	<td>'.$XINFO[6].'</td>
       	<td align="right"><strong>'.$XLABEL[14].':</strong></td>
      	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[15].':</strong></td>
       	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[16].':</strong></td>
       	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[17].':</strong></td>
      	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[18].':</strong></td>
       	<td>'.$XINFO[11].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabDetalleExtra($XLABEL, $XCTA, $XAMB, $XNUMREG, $XTOTREG){
	$XOFFSET=($XNUMREG-1)*8;
	if($XOFFSET<0) $XOFFSET=0;
	$XOBJCTA=new cuentas;
	$XRSDET=$XOBJCTA->ver_detalle_cuentas($XCTA, $XAMB,$XOFFSET,8);
	$XFILAS=$XOBJCTA->numero_filas($XRSDET);
   	$XTABLA='<div class="container">
	<input type="hidden" id="TxtNumRegExtra" value="'.$XNUMREG.'" />
	<input type="hidden" id="TxtTotRegExtra" value="'.$XTOTREG.'" />
	<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[19].'</caption>';
	/*<tr>
		<td width="50%" align="left" colspan="8">
			<strong>'.$XLABEL[19].'</strong>
			<input type="hidden" id="TxtNumRegCons" value="'.$XNUMREG.'" />
			<input type="hidden" id="TxtTotRegCons" value="'.$XTOTREG.'" />
		</td>
		<td>'.$XLABEL[20].'</td>
		<td align="center">
			<a onclick="FncPrimerCons()" style="cursor:pointer">'.$XLABEL[21].'</a>
			<img src="images/arrow_l.png" width="20px" height="15px" style="cursor:pointer;" onclick="FncAnteriorCons()" />
		</td>
		<td style="background-color:#fff;" align="center" >
			'.$XNUMREG.' '.$XLABEL[35].' '.$XTOTREG.'
		</td>
		<td align="center">
			<img src="images/arrow_r.png" width="20px" height="15px" style="cursor:pointer;" onclick="FncSiguienteCons()" />
			<a onclick="FncUltimoCons()" style="cursor:pointer">'.$XLABEL[22].'</a>
		</td>
   	</tr>*/
	$XTABLA.='<tr>
		<th width="60px">'.$XLABEL[23].'</th>
    	<th width="240px">'.$XLABEL[24].'</th>
    	<th width="50px">'.$XLABEL[25].'</th>
    	<th width="20px">'.$XLABEL[26].'</th>
    	<th width="60px">'.$XLABEL[27].'</th>
    	<th width="20px">'.$XLABEL[28].'</th>
    	<th width="50px">'.$XLABEL[48].'</th>
    	<th width="50px">'.$XLABEL[29].'</th>
    	<th width="50px">'.$XLABEL[30].'</th>
    	<th width="50px">'.$XLABEL[31].'</th>
    	<th width="60px">'.$XLABEL[32].'</th>';
		if($XFILAS<=0){
			$XTABLA.='<th>
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaExtra()" >
			</th>
			<th>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" />
			</th>';
		}
	$XTABLA.='</tr>';
	//if(($XCTA=="")||($XCTA<="0")) $XCTA='1';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="center">'.$XROWDET[0].'
				<input type="hidden" id="TxtIdExtra'.$XI.'" value="'.$XROWDET[0].'" />
			</td>
			<td align="center">'.$XROWDET[2].'
				<input type="hidden" id="HddProdExtra'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.$XROWDET[6].'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'
				<input type="hidden" id="HddIvaExtra'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaExtra()" >
			</td>
			<td>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncEliminarExtra('.$XIDCONSUMO.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='</table>
	<div>
	<table id="TdDetalleExtra" style="display:none" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<input type="hidden" id="TxtIdExtra" />
			<select id="SlcDescExtra">
				<option value=""></option>';
				$XOBJPROD=new productos;
				$XRSPROD=$XOBJPROD->ver_productos();
				while($XROWPROD=$XOBJPROD->obtener_fila($XRSPROD)){
					$XTABLA.='<option value="'.$XROWPROD[0].'">'.$XROWPROD[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
		<td align="right">
			<input type="text" id="TxtVlrExtra" style="width:50px; text-align:right; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="center">
			<input type="text" id="TxtCanExtra" style="width:20px; text-align:center; font-size:10px;" value="" onfocus="FncSelProdExtra()" onblur="FncCalcProdExtra()" />
		</td>
		<td align="center">
			<input type="text" id="TxtStExtra" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly"  onblur="FncCalcProdExtra()" />
		</td>
		<td align="center">
			<input type="text" id="TxtPorExtra" style="width:20px; text-align:center; font-size:10px" value="" onblur="FncCalcProdExtra()" />
		</td>
		<td align="center">
			<input type="text" id="TxtDscExtra" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdExtra()" />
		</td>
		<td align="left">
			<input type="text" id="TxtBasExtra" style="width:50px; text-align:right; font-size:10px" value="" onblur="FncCalcProdExtra()" />
		</td>
		<td align="center">
			<input type="text" id="TxtIvaExtra" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdExtra()" />
			<input type="hidden" id="HddIvaExtra" />
		</td>
		<td align="center">
			<input type="text" id="TxtPropExtra" style="width:30px; text-align:right; font-size:10px" value="" onblur="FncCalcProdExtra()" />
		</td>
		<td align="center">
			<input type="text" id="TxtTotExtra" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly" />
		</td>
       	<td align="center">
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncAdicionarExtra()" />
		</td>
		<td>
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncOcultarFilaExtra()" />
		</td>
	</tr>
	</table>
	<script>
		$("#TxtTotExtra").keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == "13"){
        		FncAdicionarExtra(); 
    		}	
		});
	</script>
	<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Ver todos los Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input
					.val( "" )
					.attr( "title", value + " No Coincide con ningun Registro" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#SlcDescExtra" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#SlcDescExtra" ).toggle();
		});

	});
	</script>';
	return $XTABLA;
}

//PAGINA RECEPCION - CHECK-OUT

function FncTabTrasladoCli($XLABEL, $XINFO){
	$XTABLA='<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[9].':</strong></td>
       	<td align="center" width="250px">'.$XINFO[0].'
			<input type="hidden" id="TxtIdCliTras" value="'.$XINFO[0].'" />
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" ><strong>'.$XLABEL[11].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[12].':</strong></td>
       	<td>'.$XINFO[5].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[13].':</strong></td>
       	<td>'.$XINFO[6].'</td>
       	<td align="right"><strong>'.$XLABEL[14].':</strong></td>
      	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[15].':</strong></td>
       	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[16].':</strong></td>
       	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[17].':</strong></td>
      	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[18].':</strong></td>
       	<td>'.$XINFO[11].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabDetalleTraslado($XLABEL, $XCTA, $XNUMREG, $XTOTREG){
   	$XTABLA='<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[49].'</caption>';
   	$XTABLA.='<tr>
		<th width="60px" align="center">'.$XLABEL[23].'</th>
		<th width="40px" align="center">'.$XLABEL[44].'</th>
    	<th width="240px" align="center">'.$XLABEL[24].'</th>
    	<th width="60px" align="center">'.$XLABEL[25].'</th>
    	<th width="60px" align="center">'.$XLABEL[26].'</th>
    	<th width="60px" align="center">'.$XLABEL[27].'</th>
    	<th width="60px" align="center">'.$XLABEL[48].'</th>
    	<th width="60px" align="center">'.$XLABEL[32].'</th>
    	<th width="80px" align="center">'.$XLABEL[117].'</th>
    	<th width="60px" align="center"></td>
	</tr>';
	if($XCTA=="") $XCTA='0';
	$XOFFSET=($XNUMREG-1)*10;
	if($XOFFSET<0) $XOFFSET=0;
	$XOBJCTA=new cuentas;
	$XRSDET=$XOBJCTA->ver_cuentas_traslado($XCTA,$XOFFSET,40);
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XVALPAGAR="'".$XROWDET[8]."'";
		$XTABLA.='<tr>
			<td align="center">
				'.$XROWDET[0].'
				<input type="hidden" id="TxtIdConsTras'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="TxtIdPagarTras'.$XI.'" value="'.$XROWDET[8].'" />
			</td>
			<td align="center">'.$XROWDET[1].'</td>
			<td align="center">'.$XROWDET[2].'</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="center">
				<img src="images/arrow2.gif" width="15px" height="15px" style="cursor:pointer" onclick="FncVerDetalleTrasCargos('.$XIDCONSUMO.', '.$XVALPAGAR.', '.$XROWDET[10].')" >
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='</table>';
	return $XTABLA;
}

function FncTabDetalleTrasCargos($XLABEL, $XCTA, $XNUMREG, $XTOTREG){
   	$XTABLA='<caption>'.$XLABEL[116].'</caption>
			<input type="hidden" id="TxtNumRegTrasCargos" value="'.$XNUMREG.'" />
			<input type="hidden" id="TxtTotRegTrasCargos" value="'.$XTOTREG.'" />';
   	$XTABLA.='<tr>
		<th width="60px" align="center">'.$XLABEL[23].'</th>
		<th width="100px" align="center">'.$XLABEL[46].'</th>
		<th width="60px" align="center">'.$XLABEL[9].'</th>
		<th width="60px" align="center">'.$XLABEL[10].'</th>
		<th width="60px" align="center">'.$XLABEL[11].'</th>
    	<th width="60px" align="center">%</th>
    	<th width="60px" align="center">'.$XLABEL[47].'</th>
    	<th width="60px" align="center">
			<img src="images/arrow3.gif" width="15px" height="15px" style="cursor:pointer" onclick="FncOcultarDetalleTrasCargos()" >
		</th>
	</tr>';
	if($XCTA=="") $XCTA='0';
	$XOFFSET=($XNUMREG-1)*10;
	if($XOFFSET<0) $XOFFSET=0;
	$XOBJSER=new cuentas;
	$XRSDET=$XOBJSER->ver_traslado_cargos($XCTA,$XOFFSET,4);
	$XI=0;
	while($XROWDET=$XOBJSER->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[9]."'";
		$XTABLA.='<tr>
			<td align="center">'.$XROWDET[0].'</td>
			<td align="center">
				'.$XROWDET[1].'
				<input type="hidden" id="TxtIdTrasCar'.$XI.'" value="'.$XROWDET[9].'" />
			</td>
			<td align="center">'.$XROWDET[2].'</td>
			<td align="center">'.$XROWDET[3].' '.$XROWDET[4].'</td>
			<td align="center">'.$XROWDET[6].' '.$XROWDET[5].'</td>
			<td align="center">'.$XROWDET[7].'</td>
			<td align="center">'.$XROWDET[8].'</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncActualizarTrasCargos('.$XIDCONSUMO.')" >
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncEliminarTrasCargos('.$XIDCONSUMO.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
		<td align="center">
			<input type="text" id="TxtIdConsTrasCar" style="width:60px; font-size:10px;" readonly="readonly" value="" />
			<input type="hidden" id="TxtPagarTrasCar" />
			<input type="hidden" id="TxtSeqTrasCar" />
		</td>
		<td align="center">
			<input type="text" id="TxtIdTrasCta" style="width:60px; text-align:right; font-size:10px;" readonly="readonly" value="" />
			<img src="images/icon-buscar.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncVerDlgCuenta()" />
		</td>
		<td align="center">
			<input type="text" id="TxtIdCliTrasCar" style="width:60px; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="center">
			<input type="text" id="TxtDocCliTrasCar" style="width:60px; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="center">
			<input type="text" id="TxtNomCliTrasCar" style="width:220px; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="center">
			<input type="text" id="TxtPorTrasCar" style="width:20px; text-align:center; font-size:10px" value="" onblur="FncCalcTrasCar()" />
		</td>
		<td align="center">
			<input type="text" id="TxtValTrasCar" style="width:80px; text-align:center; font-size:10px" value="" onblur="FncCalcTrasCar()" />
		</td>
       	<td align="center">
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncAdicionarTrasCargos()" />
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncEliminarTrasCargos()" />
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabLiquidacion($XLABEL, $XINFO){
	if((count($XINFO)<=0)||($XINFO==""))
		$XINFO=array('','','','','','','','','','','','','','');
	$XTABLA='<tr>
       	<td align="right" height="30px" width="120px"><strong>'.$XLABEL[51].':</strong></td>
    	<td width="150px" align="center">
   	    	<input type="text" id="TxtFecCar" style="width:120px;" value="'.date('d-m-y').'" />
       	</td>
       	<td align="right" width="120px"><strong>'.$XLABEL[52].':</strong></td>
    	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" width="120px"><strong>'.$XLABEL[5].':</strong></td>
	   	<td>'.$XINFO[3].'</td>
       	<td align="right" width="120px"><strong>'.$XLABEL[4].':</strong></td>
	   	<td>'.$XINFO[3].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[40].':</strong></td>
       	<td align="center" width="250px">
			<input type="text" id="TxtIdCli" style="width:120px; text-align:center;" value="'.$XINFO[4].'" />
			<img src="images/icon-buscar.png" width="30px" height="30px" style="cursor:pointer;" />
		</td>
       	<td align="right" height="30px"></td>
       	<td></td>
       	<td align="right" ></td>
       	<td></td>
       	<td align="right" ><strong>'.$XLABEL[55].':</strong></td>
       	<td></td>
    </tr>';
	return $XTABLA;	
}

function FncTabInfoHues($XLABEL, $XINFO){
	if((count($XINFO)<=0)||($XINFO==""))
		$XINFO=array('','','','','','','','','','','','','','');
	$XTABLA='<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[9].':</strong></td>
       	<td align="center" width="250px">'.$XINFO[0].'
			<input type="hidden" id="TxtIdCliTras" value="'.$XINFO[0].'" />
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" ><strong>'.$XLABEL[11].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[12].':</strong></td>
       	<td>'.$XINFO[5].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[13].':</strong></td>
       	<td>'.$XINFO[6].'</td>
       	<td align="right"><strong>'.$XLABEL[14].':</strong></td>
      	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[15].':</strong></td>
       	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[16].':</strong></td>
       	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[17].':</strong></td>
      	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[18].':</strong></td>
       	<td>'.$XINFO[11].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabDetalleLiqCta($XLABEL, $XIDCTA, $XNUMREG, $XTOTREG){
	$XOFFSET=($XNUMREG-1)*8;
	if($XOFFSET<0) $XOFFSET=0;
	$XOBJCTA=new cuentas;
	$XRSDET=$XOBJCTA->ver_cuentas_traslado($XIDCTA, $XOFFSET, 40);
   	$XTABLA='<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[19].'</caption>';
   	$XTABLA.='<tr>
		<th width="60px" align="center">'.$XLABEL[23].'</th>
		<th width="70px" align="center">'.$XLABEL[107].'</th>
		<th width="20px" align="center">'.$XLABEL[44].'</th>
    	<th width="220px" align="center">'.$XLABEL[24].'</th>
    	<th width="50px" align="center">'.$XLABEL[25].'</th>
    	<th width="30px" align="center">'.$XLABEL[26].'</th>
    	<th width="60px" align="center">'.$XLABEL[27].'</th>
    	<th width="50px" align="center">'.$XLABEL[48].'</th>
    	<th width="50px" align="center">'.$XLABEL[32].'</th>
    	<th width="10px" align="center">'.$XLABEL[45].'</th>
    	<th width="50px" align="center">'.$XLABEL[46].'</th>
    	<th width="20px" align="center">%</th>
    	<th width="90px" align="center">'.$XLABEL[117].'</th>
	</tr>';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="center">'.$XROWDET[0].'</td>
			<td align="center">'.cambiar_fecha($XROWDET[13]).'</td>
			<td align="center">'.$XROWDET[1].'</td>
			<td align="center">'.$XROWDET[2].'</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.number_format($XROWDET[4]).'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="center">'.number_format($XROWDET[11]).'</td>
			<td align="center">'.$XROWDET[9].'</td>
			<td align="right">'.$XROWDET[12].'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
       	</tr>';
	$XI++;
	}
   	$XTABLA.='<tr>
		<td align="right" colspan="11"><strong>'.$XLABEL[118].'</strong></td>
		<td align="right" colspan="2"><strong>'.number_format($XOBJCTA->total_cuentas_cliente($XIDCTA)).'</strong></td>
	</tr>
	</table>';
	return $XTABLA;
}

function FncTabStayCli($XLABEL, $XIDCTA){
	$XOBJCLI=new clientes;
	$XRSCLI=$XOBJCLI->buscar_cuentas_cliente($XIDCTA);
	if($XOBJCLI->numero_filas($XRSCLI)!=0){
		$XINFO=$XOBJCLI->obtener_fila($XRSCLI);
	}
	else{
		$XINFO=array('','','','','','','','','','','','');
	}
	$XTABLA='<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[9].':</strong></td>
       	<td align="center" width="250px">'.$XINFO[0].'
			<input type="hidden" id="TxtIdCli" value="'.$XINFO[0].'" />
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" ><strong>'.$XLABEL[11].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[12].':</strong></td>
       	<td>'.$XINFO[5].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[13].':</strong></td>
       	<td>'.$XINFO[6].'</td>
       	<td align="right"><strong>'.$XLABEL[14].':</strong></td>
      	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[15].':</strong></td>
       	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[16].':</strong></td>
       	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[17].':</strong></td>
      	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[18].':</strong></td>
       	<td>'.$XINFO[11].'</td>
       	<td align="right" width="120px"><strong>'.$XLABEL[7].':</strong></td>
    	<td>
			<select id="SlcAmbStay" onchange="FncVerConsumosStay()">
				<option value=""></option>';
				$XOBJAMB=new ambientes;
				$XRSAMB=$XOBJAMB->ver_ambientes();
				while($XROWAMB=$XOBJAMB->obtener_fila($XRSAMB)){
					$XTABLA.='<option value="'.$XROWAMB[0].'">'.$XROWAMB[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabStayDet($XLABEL, $XIDCTA, $XIDAMB){
   	$XTABLA='<caption>'.$XLABEL[19].' || '.$XLABEL[120].'
			<a onclick="FncMarcarStay()" style="cursor:pointer">'.$XLABEL[121].'</a>
			<a onclick="FncDesmarcarStay()" style="cursor:pointer">'.$XLABEL[122].'</a>
	</caption>';
   	$XTABLA.='<tr>
		<th width="20px" align="center"></th>
		<th width="60px" align="center">'.$XLABEL[23].'</th>
		<th width="80px" align="center">'.$XLABEL[107].'</th>
		<th width="20px" align="center">'.$XLABEL[44].'</th>
    	<th width="240px" align="center">'.$XLABEL[24].'</th>
    	<th width="50px" align="center">'.$XLABEL[25].'</th>
    	<th width="30px" align="center">'.$XLABEL[26].'</th>
    	<th width="60px" align="center">'.$XLABEL[27].'</th>
    	<th width="50px" align="center">'.$XLABEL[48].'</th>
    	<th width="60px" align="center">'.$XLABEL[32].'</th>
    	<th width="20px" align="center">%</th>
    	<th width="80px" align="center">'.$XLABEL[117].'</th>
	</tr>';
	if($XIDCTA=="") $XIDCTA='0';
	$XOBJSER=new cuentas;
	$XRSDET=$XOBJSER->ver_cuentas_caja($XIDCTA, $XIDAMB);
	$XI=0;
	while($XROWDET=$XOBJSER->obtener_fila($XRSDET)){
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="center">
				<input type="checkbox" id="chkstay'.$XI.'" onclick="FncCalcTotStay()">
				<input type="hidden" id="TxtTotStay'.$XI.'" value="'.$XROWDET[8].'" />
				<input type="hidden" id="TxtIvaStay'.$XI.'" value="'.$XROWDET[14].'" />
			</td>
			<td align="center">'.$XROWDET[0].'</td>
			<td align="center">'.cambiar_fecha($XROWDET[13]).'</td>
			<td align="center">'.$XROWDET[1].'</td>
			<td align="center">'.$XROWDET[2].'</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.$XROWDET[12].'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
       	</tr>';
		$XI++;
	}
	$XRSCTA=$XOBJSER->subtotal_cuentas_caja($XIDCTA, $XIDAMB);
	$XROWCTA=$XOBJSER->obtener_fila($XRSCTA);
   	$XTABLA.='<tr style="background-color:#a0cee6">
		<td align="right" colspan="10"><strong>'.$XLABEL[118].'</strong></td>
		<td align="right" colspan="2"><strong>'.number_format($XROWCTA[0]).'</strong></td>
		<input type="hidden" id="TxtTotStay" value="'.$XROWCTA[0].'" />
		<input type="hidden" id="TxtTotIvaStay" value="'.$XROWCTA[1].'" />
		<input type="hidden" id="TxtContador" value="'.$XI.'" />
	</tr>';
	return $XTABLA;
}

function FncTabStayPago($XLABEL, $XIDCTA, $XNUMREG, $XTOTREG){
	$XTABLA='<tr>
		<td width="60%" align="left">
			<strong>'.$XLABEL[59].'</strong>
			<input type="hidden" id="TxtNumRegServ" value="'.$XNUMREG.'" />
			<input type="hidden" id="TxtTotRegServ" value="'.$XTOTREG.'" />
		</td>
   	</tr>
	</table>
	<table>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[60].':</strong></td>
       	<td>
			<input type="hidden" id="TxtFecStay" value="'.date('d-m-Y').'" />
			<input type="text" id="TxtImpStay" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right" ><strong>'.$XLABEL[61].':</strong></td>
       	<td>
			<select id="TxtMonStay">';
				$XOBJMON=new monedas;
				$XRSMON=$XOBJMON->ver_monedas();
				$XI=0;
				while($XROWMON=$XOBJMON->obtener_fila($XRSMON)){
					if($XI==0) $XMONEDA=$XROWMON[1];
					$XTABLA.='<option value="'.$XROWMON[0].'">'.$XROWMON[0].'</option>';
					$XI++;
				}
			$XTABLA.='</select>
			<input type="text" id="TxtCopStay" style="width:80px; text-align:center;" value="'.$XMONEDA.'" readonly="readonly" />
		</td>
       	<td></td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[62].':</strong></td>
       	<td>
			<input type="text" id="TxtTrmStay" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[63].':</strong></td>
       	<td>
			<input type="text" id="TxtBasStay" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[64].':</strong></td>
       	<td>
			<input type="text" id="TxtIvaStay" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[72].':</strong></td>
       	<td>
			<input type="text" id="TxtDscStay" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabStayMetodo($XLABEL, $XPAGO){
	$XTABLA='<tr>
		<td width="100%" align="left" colspan="8">
			<strong>'.$XLABEL[73].'</strong>
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncAdicionarStayPago()" />
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncEliminarStayPago()" />
		</td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[74].':</strong></td>
       	<td align="center">
			<select id="TxtMetStay" onchange="FncValidarMedio()">';
				$XOBJMED=new medios;
				$XRSMED=$XOBJMED->ver_medios_vales();
				while($XROWMED=$XOBJMED->obtener_fila($XRSMED)){
					$XTABLA.='<option value="'.$XROWMED[0].'">'.$XROWMED[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[75].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtTcStay" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right" ><strong>'.$XLABEL[76].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtExpStay" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right" ><strong>'.$XLABEL[80].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtDigStay" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[77].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtTitStay" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[78].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtCodStay" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[79].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtHorStay" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabCheckCli($XLABEL, $XIDCTA){
	$XOBJCLI=new clientes;
	$XRSCLI=$XOBJCLI->buscar_cuentas_cliente($XIDCTA);
	if($XOBJCLI->numero_filas($XRSCLI)!=0){
		$XINFO=$XOBJCLI->obtener_fila($XRSCLI);
	}
	else{
		$XINFO=array('','','','','','','','','','','','');
	}
	$XTABLA='<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[9].':</strong></td>
       	<td align="center" width="250px">'.$XINFO[0].'
			<input type="hidden" id="TxtIdCli" value="'.$XINFO[0].'" />
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" ><strong>'.$XLABEL[11].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[12].':</strong></td>
       	<td>'.$XINFO[5].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[13].':</strong></td>
       	<td>'.$XINFO[6].'</td>
       	<td align="right"><strong>'.$XLABEL[14].':</strong></td>
      	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[15].':</strong></td>
       	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[16].':</strong></td>
       	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[17].':</strong></td>
      	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[18].':</strong></td>
       	<td>'.$XINFO[11].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabCheckDet($XLABEL, $XIDCTA){
   	$XTABLA='<caption>'.$XLABEL[19].'</td>';
   	$XTABLA.='<tr>
		<th width="60px" align="center">'.$XLABEL[23].'</th>
		<th width="80px" align="center">'.$XLABEL[107].'</th>
		<th width="20px" align="center">'.$XLABEL[44].'</th>
    	<th width="240px" align="center">'.$XLABEL[24].'</th>
    	<th width="50px" align="center">'.$XLABEL[25].'</th>
    	<th width="30px" align="center">'.$XLABEL[26].'</th>
    	<th width="60px" align="center">'.$XLABEL[27].'</th>
    	<th width="50px" align="center">'.$XLABEL[48].'</th>
    	<th width="60px" align="center">'.$XLABEL[32].'</th>
    	<th width="20px" align="center">%</th>
    	<th width="80px" align="center">'.$XLABEL[117].'</th>
	</tr>';
	if($XIDCTA=="") $XIDCTA='0';
	$XOBJSER=new cuentas;
	$XRSDET=$XOBJSER->ver_cuentas_caja($XIDCTA, '');
	$XI=0;
	while($XROWDET=$XOBJSER->obtener_fila($XRSDET)){
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="center">'.$XROWDET[0].'</td>
			<td align="center">'.cambiar_fecha($XROWDET[13]).'</td>
			<td align="center">'.$XROWDET[1].'</td>
			<td align="center">'.$XROWDET[2].'</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.$XROWDET[12].'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
       	</tr>';
		$XI++;
	}
	$XRSCTA=$XOBJSER->subtotal_cuentas_caja($XIDCTA, '');
	$XROWCTA=$XOBJSER->obtener_fila($XRSCTA);
   	$XTABLA.='<tr style="background-color:#a0cee6">
		<td align="right" colspan="10"><strong>'.$XLABEL[118].'</strong></td>
		<td align="right" colspan="2"><strong>'.number_format($XROWCTA[0]).'</strong></td>
		<input type="hidden" id="TxtTotOtro" value="'.$XROWCTA[0].'" />
		<input type="hidden" id="TxtTotIvaOtro" value="'.$XROWCTA[1].'" />
		<input type="hidden" id="TxtContador" value="'.$XI.'" />
	</tr>';
	return $XTABLA;
}

function FncTabCheckPago($XLABEL, $XIDCTA, $XNUMREG, $XTOTREG){
	$XOBJSER=new cuentas;
	$XRSCTA=$XOBJSER->subtotal_cuentas_caja($XIDCTA, '');
	$XROWCTA=$XOBJSER->obtener_fila($XRSCTA);
	$XBASE=$XROWCTA[0]-$XROWCTA[1];
	$XTABLA='<tr>
		<td width="60%" align="left">
			<strong>'.$XLABEL[59].'</strong>
			<input type="hidden" id="TxtNumRegServ" value="'.$XNUMREG.'" />
			<input type="hidden" id="TxtTotRegServ" value="'.$XTOTREG.'" />
		</td>
   	</tr>
	</table>
	<table>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[60].':</strong></td>
       	<td>
			<input type="hidden" id="TxtFecCheck" value="'.date('d-m-Y').'" />
			<input type="text" id="TxtImpCheck" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right" ><strong>'.$XLABEL[61].':</strong></td>
       	<td>
			<select id="TxtMonCheck">';
				$XOBJMON=new monedas;
				$XRSMON=$XOBJMON->ver_monedas();
				$XI=0;
				while($XROWMON=$XOBJMON->obtener_fila($XRSMON)){
					if($XI==0) $XMONEDA=$XROWMON[1];
					$XTABLA.='<option value="'.$XROWMON[0].'">'.$XROWMON[0].'</option>';
					$XI++;
				}
			$XTABLA.='</select>
			<input type="text" id="TxtCopCheck" style="width:80px; text-align:center;" value="'.$XMONEDA.'" readonly="readonly" />
		</td>
       	<td></td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[62].':</strong></td>
       	<td>
			<input type="text" id="TxtTrmCheck" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[63].':</strong></td>
       	<td>
			<input type="text" id="TxtBasCheck" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[64].':</strong></td>
       	<td>
			<input type="text" id="TxtIvaCheck" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[72].':</strong></td>
       	<td>
			<input type="text" id="TxtDscCheck" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabCheckMetodo($XLABEL, $XPAGO){
	$XTABLA='<tr>
		<td width="100%" align="left" colspan="8">
			<strong>'.$XLABEL[73].'</strong>
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncAdicionarCheckPago()" />
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncEliminarCheckPago()" />
		</td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[74].':</strong></td>
       	<td align="center">
			<select id="TxtMetCheck" onchange="FncValidarMedio()">';
				$XOBJMED=new medios;
				$XRSMED=$XOBJMED->ver_medios_vales();
				while($XROWMED=$XOBJMED->obtener_fila($XRSMED)){
					$XTABLA.='<option value="'.$XROWMED[0].'">'.$XROWMED[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[75].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtTcCheck" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right" ><strong>'.$XLABEL[76].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtExpCheck" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right" ><strong>'.$XLABEL[80].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtDigCheck" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[77].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtTitCheck" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[78].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtCodCheck" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[79].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtHorCheck" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabOtroCli($XLABEL, $XIDCTA){
	$XOBJCLI=new clientes;
	$XRSCLI=$XOBJCLI->buscar_cuentas_cliente($XIDCTA);
	if($XOBJCLI->numero_filas($XRSCLI)!=0){
		$XINFO=$XOBJCLI->obtener_fila($XRSCLI);
	}
	else{
		$XINFO=array('','','','','','','','','','','','');
	}
	$XTABLA='<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[9].':</strong></td>
       	<td align="center" width="250px">'.$XINFO[0].'
			<input type="hidden" id="TxtIdCli" value="'.$XINFO[0].'" />
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" ><strong>'.$XLABEL[11].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[12].':</strong></td>
       	<td>'.$XINFO[5].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[13].':</strong></td>
       	<td>'.$XINFO[6].'</td>
       	<td align="right"><strong>'.$XLABEL[14].':</strong></td>
      	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[15].':</strong></td>
       	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[16].':</strong></td>
       	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[17].':</strong></td>
      	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[18].':</strong></td>
       	<td>'.$XINFO[11].'</td>
       	<td align="right" width="120px"><strong>'.$XLABEL[7].':</strong></td>
    	<td>
			<select id="SlcAmbOtro" onchange="FncVerConsumosOtro()">
				<option value=""></option>';
				$XOBJAMB=new ambientes;
				$XRSAMB=$XOBJAMB->ver_ambientes();
				while($XROWAMB=$XOBJAMB->obtener_fila($XRSAMB)){
					$XTABLA.='<option value="'.$XROWAMB[0].'">'.$XROWAMB[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabOtroDet($XLABEL, $XIDCTA, $XIDAMB){
   	$XTABLA='<caption>'.$XLABEL[19].' || '.$XLABEL[120].'
			<a onclick="FncMarcarOtro()" style="cursor:pointer">'.$XLABEL[121].'</a>
			<a onclick="FncDesmarcarOtro()" style="cursor:pointer">'.$XLABEL[122].'</a>
	</caption>';
   	$XTABLA.='<tr>
		<th width="20px" align="center"></th>
		<th width="60px" align="center">'.$XLABEL[23].'</th>
		<th width="80px" align="center">'.$XLABEL[107].'</th>
		<th width="20px" align="center">'.$XLABEL[44].'</th>
    	<th width="240px" align="center">'.$XLABEL[24].'</th>
    	<th width="50px" align="center">'.$XLABEL[25].'</th>
    	<th width="30px" align="center">'.$XLABEL[26].'</th>
    	<th width="60px" align="center">'.$XLABEL[27].'</th>
    	<th width="50px" align="center">'.$XLABEL[48].'</th>
    	<th width="60px" align="center">'.$XLABEL[32].'</th>
    	<th width="20px" align="center">%</th>
    	<th width="80px" align="center">'.$XLABEL[117].'</th>
	</tr>';
	if($XIDCTA=="") $XIDCTA='0';
	$XOBJSER=new cuentas;
	$XRSDET=$XOBJSER->ver_cuentas_caja($XIDCTA, $XIDAMB);
	$XI=0;
	while($XROWDET=$XOBJSER->obtener_fila($XRSDET)){
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="center">
				<input type="checkbox" id="chkOtro'.$XI.'" onclick="FncCalcTotOtro()">
				<input type="hidden" id="TxtTotOtro'.$XI.'" value="'.$XROWDET[8].'" />
				<input type="hidden" id="TxtIvaOtro'.$XI.'" value="'.$XROWDET[14].'" />
			</td>
			<td align="center">'.$XROWDET[0].'</td>
			<td align="center">'.cambiar_fecha($XROWDET[13]).'</td>
			<td align="center">'.$XROWDET[1].'</td>
			<td align="center">'.$XROWDET[2].'</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.$XROWDET[12].'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
       	</tr>';
		$XI++;
	}
	$XRSCTA=$XOBJSER->subtotal_cuentas_caja($XIDCTA, $XIDAMB);
	$XROWCTA=$XOBJSER->obtener_fila($XRSCTA);
   	$XTABLA.='<tr style="background-color:#a0cee6">
		<td align="right" colspan="10"><strong>'.$XLABEL[118].'</strong></td>
		<td align="right" colspan="2"><strong>'.number_format($XROWCTA[0]).'</strong></td>
		<input type="hidden" id="TxtTotOtro" value="'.$XROWCTA[0].'" />
		<input type="hidden" id="TxtTotIvaOtro" value="'.$XROWCTA[1].'" />
		<input type="hidden" id="TxtContador" value="'.$XI.'" />
	</tr>';
	return $XTABLA;
}

function FncTabOtroPago($XLABEL, $XIDCTA, $XNUMREG, $XTOTREG){
//	if((count($XINFO)<=0)||($XINFO==""))
		$XINFO=array('','','','','','','','','','','','','','');
	$XTABLA='<tr>
		<td width="60%" align="left">
			<strong>'.$XLABEL[59].'</strong>
			<input type="hidden" id="TxtNumRegServ" value="'.$XNUMREG.'" />
			<input type="hidden" id="TxtTotRegServ" value="'.$XTOTREG.'" />
		</td>
   	</tr>
	</table>
	<table>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[60].':</strong></td>
       	<td>
			<input type="hidden" id="TxtFecOtro" value="'.date('d-m-Y').'" />
			<input type="text" id="TxtImpOtro" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right" ><strong>'.$XLABEL[61].':</strong></td>
       	<td>
			<select id="TxtMonOtro">';
				$XOBJMON=new monedas;
				$XRSMON=$XOBJMON->ver_monedas();
				$XI=0;
				while($XROWMON=$XOBJMON->obtener_fila($XRSMON)){
					if($XI==0) $XMONEDA=$XROWMON[1];
					$XTABLA.='<option value="'.$XROWMON[0].'">'.$XROWMON[0].'</option>';
					$XI++;
				}
			$XTABLA.='</select>
			<input type="text" id="TxtCopOtro" style="width:80px; text-align:center;" value="'.$XMONEDA.'" readonly="readonly" />
		</td>
       	<td></td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[62].':</strong></td>
       	<td>
			<input type="text" id="TxtTrmOtro" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[63].':</strong></td>
       	<td>
			<input type="text" id="TxtBasOtro" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[64].':</strong></td>
       	<td>
			<input type="text" id="TxtIvaOtro" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[72].':</strong></td>
       	<td>
			<input type="text" id="TxtDscOtro" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabOtroMetodo($XLABEL, $XPAGO){
	$XTABLA='<tr>
		<td width="100%" align="left" colspan="8">
			<strong>'.$XLABEL[73].'</strong>
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncAdicionarOtroPago()" />
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncEliminarOtroPago()" />
		</td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[74].':</strong></td>
       	<td align="center">
			<select id="TxtMetOtro" onchange="FncValidarMedio()">';
				$XOBJMED=new medios;
				$XRSMED=$XOBJMED->ver_medios_vales();
				while($XROWMED=$XOBJMED->obtener_fila($XRSMED)){
					$XTABLA.='<option value="'.$XROWMED[0].'">'.$XROWMED[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[75].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtTcOtro" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right" ><strong>'.$XLABEL[76].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtExpOtro" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right" ><strong>'.$XLABEL[80].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtDigOtro" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[77].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtTitOtro" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[78].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtCodOtro" style="width:120px; text-align:center;" value="" />
		</td>
       	<td align="right"><strong>'.$XLABEL[79].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtHorOtro" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabCambMoneda($XLABEL, $XINFO){
	if((count($XINFO)<=0)||($XINFO==""))
		$XINFO=array('','','','','','','','','','','','','','');
	$XTABLA='<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[82].':</strong></td>
       	<td align="center" width="250px">
			<input type="text" id="TxtIdCli" style="width:120px; text-align:center;" value="'.$XINFO[4].'" />
			<img src="images/icon-buscar.png" width="30px" height="30px" style="cursor:pointer;" />
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[83].':</strong></td>
       	<td>
			'.$XINFO[5].'
			<img src="images/icon-buscar.png" width="30px" height="30px" style="cursor:pointer;" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[84].':</strong></td>
       	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[85].':</strong></td>
      	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[86].':</strong></td>
       	<td>'.$XINFO[10].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[87].':</strong></td>
       	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[88].':</strong></td>
      	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td colspan="2" align="center">
			<input type="button" value="'.$XLABEL[89].'">
		</td>
    </tr>
	<tr>
       	<td align="center" height="30px" colspan="2"><strong>'.$XLABEL[90].':</strong></td>
       	<td align="center" colspan="2"><strong>'.$XLABEL[91].':</strong></td>
    </tr>';
	return $XTABLA;	
}

//BUSQUEDA DE CUENTAS
function FncTabBuscarCtaExtra($XLABEL, $XIDCLI, $XNOMCLI, $XCTA){
  	$XTABLA='<tr style="background-color:#a0cee6">
       	<td align="center">'.$XLABEL[40].'</td>
       	<td align="center">'.$XLABEL[9].'</td>
      	<td align="center">'.$XLABEL[10].'</td>
       	<td align="center">'.$XLABEL[11].'</td>
   	</tr>';
	$XOBJCLI=new clientes;
	$XRSCLI=$XOBJCLI->busqueda_basica_cuentas($XIDCLI,$XNOMCLI,$XCTA);

	while($XROWCLI=$XOBJCLI->obtener_fila($XRSCLI)){
		$XIDCTA="'".$XROWCLI[0]."'";
		$XTABLA.='<tr>
        	<td>
				<a onclick="FncBuscarCtaExtra('.$XIDCTA.')" style="cursor:pointer">'.$XROWCLI[0].'</a>
			</td>
   	    	<td>'.$XROWCLI[1].'</td>
   	    	<td>'.$XROWCLI[2].' '.$XROWCLI[3].'</td>
       	   	<td>
				<a onclick="FncBuscarCtaExtra('.$XIDCTA.')" style="cursor:pointer">'.$XROWCLI[5].' '.$XROWCLI[4].'</a>
			</td>
   	   	</tr>';
	}
	return $XTABLA;
}

//FACTURACION Y PUNTOS DE VENTA

function FncMesasAmbiente($XLABEL, $XAMB){
	$XOBJAMB=new mesas;
	$XRSAMB=$XOBJAMB->ver_mesas($XAMB);
	$XI=0;
	$XTABLA='';
	while($XROWAMB=$XOBJAMB->obtener_fila($XRSAMB)){
		if($XI==0)$XTABLA.='<tr>';
			$XTABLA.='<td align="center" valign="middle" width="100px">
       		<a class="codrops-idioma" href="?sec=modulos/facturacion/mesas&ambiente='.$XAMB.'&mesa='.$XROWAMB[1].'" style="width:50px">';
				$XRSOCP=$XOBJAMB->buscar_mesas_ocupadas($XROWAMB[1], $XAMB, 'ocupada');
				if($XOBJAMB->numero_filas($XRSOCP)!=0)
	        	    $XTABLA.='<img src="images/table-red.png" width="40px" height="40px" />';
				else
	        	    $XTABLA.='<img src="images/table-green.png" width="40px" height="40px" />';
   	        	$XTABLA.='<p>'.$XROWAMB[1].'</p>
          	</a>
		</td>';
		$XI++;
		if($XI==4){
			$XTABLA.='</tr>';
			$XI=0;
		}
	}
	
	return $XTABLA;
}

function FncTabDetalleMesa($XLABEL, $XMESA, $XAMB){
	$XOBJCTA=new cuentas;
	$XRSDET=$XOBJCTA->ver_detalle_mesas($XMESA, $XAMB, 'ocupada');
	$XFILAS=$XOBJCTA->numero_filas($XRSDET);
   	$XTABLA='<div class="container">
	<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[19].'</caption>';
	$XTABLA.='<tr>
		<th width="60px">'.$XLABEL[8].'</th>
    	<th width="240px">'.$XLABEL[9].'</th>
    	<th width="50px">'.$XLABEL[10].'</th>
    	<th width="20px">'.$XLABEL[11].'</th>
    	<th width="60px">'.$XLABEL[12].'</th>
    	<th width="20px">'.$XLABEL[13].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[14].'</th>
    	<th width="50px">'.$XLABEL[15].'</th>
    	<th width="50px">'.$XLABEL[16].'</th>
    	<th width="60px">'.$XLABEL[17].'</th>';
		if($XFILAS<=0){
			$XTABLA.='<th>
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</th>
			<th>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" />
			</th>';
		}
	$XTABLA.='</tr>';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="center">'.$XROWDET[0].'
				<input type="hidden" id="TxtIdCons'.$XI.'" value="'.$XROWDET[0].'" />
			</td>
			<td align="center">'.$XROWDET[2].'
				<input type="hidden" id="HddProdCons'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.$XROWDET[6].'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'
				<input type="hidden" id="HddIvaCons'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</td>
			<td>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncEliminarCons('.$XIDCONSUMO.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='</table>
	<div>
	<table id="TdDetalleCons" style="display:none" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<input type="hidden" id="TxtIdCons" />
			<select id="SlcDescCons">
				<option value=""></option>';
				$XOBJPROD=new productos;
				$XRSPROD=$XOBJPROD->ver_productos();
				while($XROWPROD=$XOBJPROD->obtener_fila($XRSPROD)){
					$XTABLA.='<option value="'.$XROWPROD[0].'">'.$XROWPROD[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
		<td align="right">
			<input type="text" id="TxtVlrCons" style="width:50px; text-align:right; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="center">
			<input type="text" id="TxtCanCons" style="width:20px; text-align:center; font-size:10px;" value="" onfocus="FncSelProdHuesped()" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtStCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly"  onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtPorCons" style="width:20px; text-align:center; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtDscCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="left">
			<input type="text" id="TxtBasCons" style="width:50px; text-align:right; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtIvaCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
			<input type="hidden" id="HddIvaCons" />
		</td>
		<td align="center">
			<input type="text" id="TxtPropCons" style="width:30px; text-align:right; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtTotCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly" />
		</td>
       	<td align="center">
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncAdiConsumosVenta()" title="Adicionar Consumo" />
		</td>
		<td>
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncOcultarFilaConsumos()" />
		</td>
	</tr>
	</table>
	<script>
		$("#TxtTotCons").keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == "13"){
        		FncAdiConsumosVenta(); 
    		}	
		});
	</script>
	<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Ver todos los Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input
					.val( "" )
					.attr( "title", value + " No Coincide con ningun Registro" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#SlcDescCons" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#SlcDescCons" ).toggle();
		});

	});
	</script>';
	return $XTABLA;
}

function FncTabPagosMesa($XLABEL, $XMESA, $XAMB){
	$XOBJCTA=new cuentas;
	$XRSDET=$XOBJCTA->ver_detalle_mesas($XMESA, $XAMB, 'ocupada');
	$XFILAS=$XOBJCTA->numero_filas($XRSDET);
   	$XTABLA='<div class="container">
	<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[19].'</caption>';
	$XTABLA.='<tr>
		<th width="60px">'.$XLABEL[21].'</th>
		<th width="60px">'.$XLABEL[8].'</th>
    	<th width="240px">'.$XLABEL[9].'</th>
    	<th width="50px">'.$XLABEL[10].'</th>
    	<th width="20px">'.$XLABEL[11].'</th>
    	<th width="60px">'.$XLABEL[12].'</th>
    	<th width="20px">'.$XLABEL[13].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[14].'</th>
    	<th width="50px">'.$XLABEL[15].'</th>
    	<th width="50px">'.$XLABEL[16].'</th>
    	<th width="60px">'.$XLABEL[17].'</th>';
	$XTABLA.='</tr>';
	//if(($XCTA=="")||($XCTA<="0")) $XCTA='1';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="right">
				<input type="checkbox" id="ChkCons'.$XI.'" onclick="FncCalcTotPagos()" >
				<input type="hidden" id="TxtTotStay'.$XI.'" value="'.$XROWDET[11].'" />
				<input type="hidden" id="TxtIvaStay'.$XI.'" value="'.$XROWDET[9].'" />
			</td>
			<td align="center">'.$XROWDET[0].'
				<input type="hidden" id="TxtIdCons'.$XI.'" value="'.$XROWDET[0].'" />
			</td>
			<td align="center">'.$XROWDET[2].'
				<input type="hidden" id="HddProdCons'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.$XROWDET[6].'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'
				<input type="hidden" id="HddIvaCons'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
			<td colspan="2" align="center">
				<a onclick="FncMarcarCons()" style="cursor:pointer;" >'.$XLABEL[58].'</a>
				<input type="hidden" id="TxtContador" value="'.$XI.'">
			</td>
			<td colspan="2" align="left">
				<a onclick="FncDesmarcarCons()" style="cursor:pointer;" >'.$XLABEL[59].'</a>
			</td>
		</tr>
	</table>
	<div>';
	return $XTABLA;
}

function FncTabMesaPago($XLABEL, $XIDCTA, $XAMB){
	$XOBJCTA=new cuentas;
	$XRSCTA=$XOBJCTA->subtotal_cuentas_caja($XIDCTA, $XAMB);
	$XROWCTA=$XOBJCTA->obtener_fila($XRSCTA);
	$XTOTAL=$XROWCTA[0];
	$XIVA=$XROWCTA[1];
	$XDESC=$XROWCTA[2];
	$XBASE=$XTOTAL-$XIVA;
	
	$XOBJPAG=new pagos;
	$XRSPAG=$XOBJPAG->ver_saldos_cuenta($XIDCTA, $XAMB);
	if($XOBJPAG->numero_filas($XRSPAG)!=0){
		$XROWPAG=$XOBJPAG->obtener_fila($XRSPAG);
		$XABONO=$XROWPAG[0];
		$XTRAS=$XROWPAG[1];
		$XSALDO=$XTOTAL-($XABONO+$XTRAS);
	}
	else{
		$XABONO='0';
		$XTRAS='0';
		$XSALDO=$XTOTAL;
	}
	
	$XTABLA='<tr>
		<td width="60%" align="left">
			<strong>'.$XLABEL[22].'</strong>
		</td>
   	</tr>
	</table>
	<table>
	<tr>
       	<td align="right" height="30px" width="15%"><strong>'.$XLABEL[23].':</strong></td>
       	<td width="15%">
			<input type="hidden" id="TxtFecStay" value="'.date('d-m-Y').'" />
			<input type="text" id="TxtImpStay" style="width:120px; text-align:right;" value="'.number_format($XTOTAL).'" readonly="readonly" />
		</td>
       	<td align="right" width="15%" ><strong>'.$XLABEL[24].':</strong></td>
       	<td width="15%">
			<select id="SlcMonStay">';
				$XOBJMON=new monedas;
				$XRSMON=$XOBJMON->ver_monedas();
				$XI=0;
				while($XROWMON=$XOBJMON->obtener_fila($XRSMON)){
					if($XI==0) $XMONEDA=$XROWMON[1];
					$XTABLA.='<option value="'.$XROWMON[0].'">'.$XROWMON[0].'</option>';
					$XI++;
				}
			$XTABLA.='</select>
			<input type="text" id="TxtCopStay" style="width:80px; text-align:center;" value="'.$XMONEDA.'" readonly="readonly" />
		</td>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[38].':</strong></td>
       	<td width="15%">
			<input type="text" id="TxtTrmStay" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[25].':</strong></td>
       	<td>
			<input type="text" id="TxtBasStay" style="width:120px; text-align:right;" value="'.number_format($XBASE).'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[26].':</strong></td>
       	<td>
			<input type="text" id="TxtIvaStay" style="width:120px; text-align:right;" value="'.number_format($XIVA).'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[27].':</strong></td>
       	<td>
			<input type="text" id="TxtDscStay" style="width:120px; text-align:right;" value="'.number_format($XDESC).'" readonly="readonly" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[40].':</strong></td>
       	<td>
			<input type="text" id="TxtAbStay" style="width:120px; text-align:right;" value="'.$XABONO.'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[60].':</strong></td>
       	<td>
			<input type="text" id="TxtTrasStay" style="width:120px; text-align:right;" value="'.$XTRAS.'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[41].':</strong></td>
       	<td>
			<input type="text" id="TxtSalStay" style="width:120px; text-align:right;" value="'.$XSALDO.'" readonly="readonly" />
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabMesaMetodo($XLABEL, $XMESA, $XAMB, $XMET, $XINFO, $XIDCTA, $XPAG){
	$XMET=(int) $XMET;
	$XTABLA='<tr>
		<td align="left" colspan="7">
			<strong>'.$XLABEL[30].'</strong>
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncAdicionarStayPago()" />
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncEliminarStayPago()" />
		</td>
       	<td>';
			$OBJPAG=new pagos;
			$XTOTPAG=$OBJPAG->num_pagos_cuenta($XIDCTA, $XAMB);

			//$XTOTPAG=$XOBJCTA->paginas_vales($XCTA, $XAMB);
			$XTABLA.='<p class="paginacion" align="right" >';
			if($XPAG>1){ 
				$XP=$XPAG-1;
				$XTABLA.='<a onclick="FncVerPago('.$XP.')" style="cursor:pointer;"><img src="images/izq.gif" /></a>';
			}
			for($XJ=1;$XJ<=$XTOTPAG;$XJ++){
				$XTABLA.='<a onclick="FncVerPago('.$XJ.')" style="cursor:pointer; color:#FFFFFF; padding:4px 6px;">'.$XJ.'</a> ';
			}
			if(($XPAG<$XTOTPAG)&&($XTOTPAG>1)){ 
				$XP=$XPAG+1;
				$XTABLA.='<a onclick="FncVerPago('.$XP.')" style="cursor:pointer;"><img src="images/der.gif" /></a>';
			}
			$XTABLA.='</p>';
		$XTABLA.='</td>
   	</tr>
	<tr>
       	<td align="right" height="30px" ><strong>'.$XLABEL[31].':</strong></td>
       	<td align="center">
			<select id="SlcMetStay" onchange="FncValidarMedio()">';
				$XOBJMED=new medios;
				$XRSMED=$XOBJMED->ver_medios();
				while($XROWMED=$XOBJMED->obtener_fila($XRSMED)){
					$XTABLA.='<option value="'.$XROWMED[0].'">'.$XROWMED[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[55].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtIdPago" style="width:60px; text-align:center;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[61].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtFecPago" style="width:120px; text-align:center;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px">
			<div id="tdhab1" style="display:none;">
				<strong>'.$XLABEL[53].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="tdhab2" style="display:none;">
				<select id="SlcHabStay" onchange="FncSelecHabCta()" '; if($XMET!='2')$XTABLA.='disabled="disabled"'; $XTABLA.='>
					<option value=""></option>';
					$XOBJHAB=new habitaciones;
					$XRSHAB=$XOBJHAB->ver_habitaciones_xestado('ocupada');
					while($XROWHAB=$XOBJHAB->obtener_fila($XRSHAB)){
						$XTABLA.='<option value="'.$XROWHAB[0].'">'.$XROWHAB[1].'</option>';
					}
				$XTABLA.='</select>
				<input type="hidden" id="TxtIdCtaHab" value="" />
			</div>
		</td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[42].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtPorcPago" style="width:60px; text-align:right;" value="" onblur="FncCalcPagoPrc()" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[39].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtValorPago" style="width:120px; text-align:right;" value="" onblur="FncCalcPagoVal()" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[25].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtBasePago" style="width:120px; text-align:right;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[26].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtIvasPago" style="width:120px; text-align:right;" value="" readonly="readonly" />
		</td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[44].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtIdCliPag" value="'.$XINFO[0].'" readonly="readonly" style="width:80px" />';
			if($XMET!='2')
				$XTABLA.='<img src="images/icon-buscar.png" width="30px" height="30px" style="cursor:pointer" onclick="FncVerDlgCliente()" />';
		$XTABLA.='</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[45].':</strong></td>
       	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" ><strong>'.$XLABEL[46].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[47].':</strong></td>
       	<td>'.$XINFO[6].'</td>
       	<td align="right"><strong>'.$XLABEL[48].':</strong></td>
      	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[49].':</strong></td>
       	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[50].':</strong></td>
       	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[51].':</strong></td>
      	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[52].':</strong></td>
       	<td>'.$XINFO[11].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px">
			<div id="trtc1" style="display:none;">
				<strong>'.$XLABEL[63].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc2" style="display:none;">
				<select id="SlcFranStay">
					<option value=""></option>';
					$XOBJFRAN=new franquicias;
					$XRSFRAN=$XOBJFRAN->ver_franquicias();
					while($XROWFRAN=$XOBJFRAN->obtener_fila($XRSFRAN)){
						$XTABLA.='<option value="'.$XROWFRAN[0].'">'.$XROWFRAN[1].'</option>';
					}
				$XTABLA.='</select>
			</div>
		</td>
       	<td align="right" height="30px">
			<div id="trtc3" style="display:none;">
				<strong>'.$XLABEL[32].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc4" style="display:none;">
				<input type="text" id="TxtTcStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right" height="30px">
			<div id="trtc5" style="display:none;">
				<strong>'.$XLABEL[35].':</strong>
			</div>
		</td>
       	<td align="center" colspan="2">
			<div id="trtc6" style="display:none;">
				<input type="text" id="TxtTitStay" style="width:300px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
    </tr>
	<tr>
       	<td align="right" >
			<div id="trtc7" style="display:none;">
				<strong>'.$XLABEL[33].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc8" style="display:none;">
				<input type="text" id="TxtExpStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right" >
			<div id="trtc9" style="display:none;">
				<strong>'.$XLABEL[34].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc10" style="display:none;">
				<input type="text" id="TxtDigStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right">
			<div id="trtc11" style="display:none;">
				<strong>'.$XLABEL[36].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc12" style="display:none;">
				<input type="text" id="TxtCodStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right">
			<div id="trtc13" style="display:none;">
				<strong>'.$XLABEL[37].':</strong>
			</td>
       	<td align="center">
			<div id="trtc14" style="display:none;">
				<input type="text" id="TxtHorStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
    </tr>
	<tr>
       	<td align="center" colspan="8" height="30px">
			<input type="button" id="BtnPagar" value="';
				if($XMET!='2') 
					$XTABLA.=$XLABEL[54].'" onclick="FncAdicionarPagos()" />';
				else 
					$XTABLA.=$XLABEL[57].'" onclick="FncAdicionarPagos()" />';
		$XTABLA.='</td>
    </tr>';
	return $XTABLA;	
}

//AMBIENTES MINIBAR, LAVANDERIA, ROOMSERVICE

function FncTabCargosCliAmb($XLABEL, $XINFO){
	$XTABLA='<tr>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[44].':</strong></td>
       	<td width="15%" align="center">'.$XINFO[0].'
			<input type="hidden" id="TxtIdCliCar" value="'.$XINFO[0].'" />
		</td>
       	<td width="15%" align="right" height="30px"></td>
       	<td width="15%"></td>
       	<td width="15%" align="right"><strong>'.$XLABEL[4].':</strong></td>
	   	<td width="15%">
			<input type="text" id="TxtValCar" style="width:120px; text-align:right;" readonly="readonly" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[45].':</strong></td>
       	<td>'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td align="right" ><strong>'.$XLABEL[46].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[47].':</strong></td>
       	<td>'.$XINFO[5].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[48].':</strong></td>
       	<td>'.$XINFO[6].'</td>
       	<td align="right"><strong>'.$XLABEL[49].':</strong></td>
      	<td>'.$XINFO[7].'</td>
       	<td align="right"><strong>'.$XLABEL[62].':</strong></td>
       	<td>'.$XINFO[8].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[50].':</strong></td>
       	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[51].':</strong></td>
      	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[52].':</strong></td>
       	<td>'.$XINFO[11].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabDetalleConsAmb($XLABEL, $XCTA, $XAMB, $XPAG){
	$XTABLA='<tr>
		<td>';
	$XOBJCTA=new cuentas;
	$XTOTPAG=0;
	$XTOTPAG=$XOBJCTA->paginas_vales($XCTA, $XAMB);
	$XTABLA.='<p class="paginacion" align="right" >';
		if($XPAG>1){ 
			$XP=$XPAG-1;
			$XTABLA.='<a onclick="FncPagConsAmb('.$XP.')" style="cursor:pointer;"><img src="images/izq.gif" /></a>';
		}
		for($XJ=1;$XJ<=$XTOTPAG;$XJ++){
			$XTABLA.='<a onclick="FncPagConsAmb('.$XJ.')" style="cursor:pointer; color:#FFFFFF; padding:4px 6px;">'.$XJ.'</a> ';
		}
		if(($XPAG<$XTOTPAG)&&($XTOTPAG>1)){ 
			$XP=$XPAG+1;
			$XTABLA.='<a onclick="FncPagConsAmb('.$XP.')" style="cursor:pointer;"><img src="images/der.gif" /></a>';
		}
	$XTABLA.='</p>';
	$XTABLA.='<table width="100%">
    	<tr>
        	<td width="90%" valign="top">';
	$XOFFSET=(int) $XPAG;
	$XOFFSET--;
	if($XOFFSET>=0)
		$XVALE=$XOBJCTA->hallar_vales($XCTA, $XAMB, $XOFFSET, 1);
	else
		$XVALE='';
//MUESTRA LOS DETALLES DE LA TABLA
	$XRSDET=$XOBJCTA->ver_detalle_vales($XCTA, $XAMB, $XVALE);
	$XFILAS=$XOBJCTA->numero_filas($XRSDET);
   	$XTABLA.='<div class="container">
	<table width="100%" cellpadding="0" cellspacing="0" style="border:#BBB solid 1px; background-color:#fff;">
	<input type="hidden" id="TxtValeAmb" value="'.$XVALE.'" />
	<input type="hidden" id="TxtPagAmb" value="'.$XPAG.'" />
  	<caption>'.$XLABEL[19].'</caption>';
	$XTABLA.='<tr>
		<th width="70px">'.$XLABEL[61].'</th>
    	<th width="230px">'.$XLABEL[9].'</th>
    	<th width="50px">'.$XLABEL[10].'</th>
    	<th width="20px">'.$XLABEL[11].'</th>
    	<th width="60px">'.$XLABEL[12].'</th>
    	<th width="20px">'.$XLABEL[13].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[14].'</th>
    	<th width="50px">'.$XLABEL[15].'</th>
    	<th width="50px">'.$XLABEL[16].'</th>
    	<th width="60px">'.$XLABEL[17].'</th>';
		if($XFILAS<=0){
			$XTABLA.='<th>
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</th>
			<th>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" />
			</th>';
		}
	$XTABLA.='</tr>';
	//if(($XCTA=="")||($XCTA<="0")) $XCTA='1';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="center">'.cambiar_fecha($XROWDET[13]).'
				<input type="hidden" id="TxtIdCons'.$XI.'" value="'.$XROWDET[0].'" />
			</td>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="HddProdCons'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.$XROWDET[6].'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'
				<input type="hidden" id="HddIvaCons'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</td>
			<td>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncEliminarCons('.$XIDCONSUMO.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
			<td colspan="9" align="right"><strong>Subtotal ($):</strong></td>';
			$XSUBTOTAL=$XOBJCTA->total_cuentas_vales($XCTA, $XAMB, $XVALE);
			$XTABLA.='<td colspan="2" align="right"><strong>'.number_format($XSUBTOTAL).'</strong></td>
			<td colspan="2"></td>
		</tr>
	</table>
	<div>
	<table id="TdDetalleCons" style="display:none" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<input type="hidden" id="TxtIdCons" />
			<select id="SlcDescCons">
				<option value=""></option>';
				$XOBJPROD=new productos;
				$XRSPROD=$XOBJPROD->ver_productos();
				while($XROWPROD=$XOBJPROD->obtener_fila($XRSPROD)){
					$XTABLA.='<option value="'.$XROWPROD[0].'">'.$XROWPROD[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
		<td align="right">
			<input type="text" id="TxtVlrCons" style="width:50px; text-align:right; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="center">
			<input type="text" id="TxtCanCons" style="width:20px; text-align:center; font-size:10px;" value="" onfocus="FncSelProdHuesped()" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtStCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly"  onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtPorCons" style="width:20px; text-align:center; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtDscCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="left">
			<input type="text" id="TxtBasCons" style="width:50px; text-align:right; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtIvaCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
			<input type="hidden" id="HddIvaCons" />
		</td>
		<td align="center">
			<input type="text" id="TxtPropCons" style="width:30px; text-align:right; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtTotCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly" />
		</td>
       	<td align="center">
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncAdiConsumosVenta()" title="Adicionar Consumo" />
		</td>
		<td>
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncOcultarFilaConsumos()" />
		</td>
	</tr>
	</table>
	<script>
		$("#TxtTotCons").keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == "13"){
        		FncAdiConsumosVenta(); 
    		}	
		});
	</script>
	<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Ver todos los Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input
					.val( "" )
					.attr( "title", value + " No Coincide con ningun Registro" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#SlcDescCons" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#SlcDescCons" ).toggle();
		});

	});
	</script>
			</td>
    	</tr>
   	</table>
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabPagosAmbiente($XLABEL, $XIDCTA, $XAMB){
	$XOBJCTA=new cuentas;
	$XRSDET=$XOBJCTA->ver_detalle_cuentas($XIDCTA, $XAMB,0,1000);
	$XFILAS=$XOBJCTA->numero_filas($XRSDET);
   	$XTABLA='<div class="container">
	<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[19].'</caption>';
	$XTABLA.='<tr>
		<th width="60px">'.$XLABEL[21].'</th>
		<th width="60px">'.$XLABEL[8].'</th>
    	<th width="240px">'.$XLABEL[9].'</th>
    	<th width="50px">'.$XLABEL[10].'</th>
    	<th width="20px">'.$XLABEL[11].'</th>
    	<th width="60px">'.$XLABEL[12].'</th>
    	<th width="20px">'.$XLABEL[13].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[14].'</th>
    	<th width="50px">'.$XLABEL[15].'</th>
    	<th width="50px">'.$XLABEL[16].'</th>
    	<th width="60px">'.$XLABEL[17].'</th>';
	$XTABLA.='</tr>';
	//if(($XCTA=="")||($XCTA<="0")) $XCTA='1';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="right">
				<input type="checkbox" id="ChkCons'.$XI.'" onclick="FncCalcTotPagos()" >
				<input type="hidden" id="TxtTotStay'.$XI.'" value="'.$XROWDET[11].'" />
				<input type="hidden" id="TxtIvaStay'.$XI.'" value="'.$XROWDET[9].'" />
			</td>
			<td align="center">'.$XROWDET[0].'
				<input type="hidden" id="TxtIdCons'.$XI.'" value="'.$XROWDET[0].'" />
			</td>
			<td align="center">'.$XROWDET[2].'
				<input type="hidden" id="HddProdCons'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="right">'.number_format($XROWDET[3]).'</td>
			<td align="center">'.$XROWDET[4].'</td>
			<td align="right">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.$XROWDET[6].'</td>
			<td align="right">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'
				<input type="hidden" id="HddIvaCons'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
			<td colspan="2" align="center">
				<a onclick="FncMarcarCons()" style="cursor:pointer;" >'.$XLABEL[58].'</a>
				<input type="hidden" id="TxtContador" value="'.$XI.'">
			</td>
			<td colspan="2" align="left">
				<a onclick="FncDesmarcarCons()" style="cursor:pointer;" >'.$XLABEL[59].'</a>
			</td>
		</tr>
	</table>
	<div>';
	return $XTABLA;
}

function FncTabDetallePagosAmb($XLABEL, $XIDCTA, $XAMB){
	$XOBJCTA=new cuentas;
	$XRSCTA=$XOBJCTA->subtotal_cuentas_caja($XIDCTA, $XAMB);
	$XROWCTA=$XOBJCTA->obtener_fila($XRSCTA);
	$XTOTAL=$XROWCTA[0];
	$XIVA=$XROWCTA[1];
	$XDESC=$XROWCTA[2];
	$XBASE=$XTOTAL-$XIVA;
	
	$XOBJPAG=new pagos;
	$XRSPAG=$XOBJPAG->ver_saldos_cuenta($XIDCTA, $XAMB);
	if($XOBJPAG->numero_filas($XRSPAG)!=0){
		$XROWPAG=$XOBJPAG->obtener_fila($XRSPAG);
		$XABONO=$XROWPAG[0];
		$XTRAS=$XROWPAG[1];
		$XSALDO=$XTOTAL-($XABONO+$XTRAS);
	}
	else{
		$XABONO='0';
		$XTRAS='0';
		$XSALDO=$XTOTAL;
	}
	
	$XTABLA='<tr>
		<td width="60%" align="left">
			<strong>'.$XLABEL[22].'</strong>
		</td>
   	</tr>
	</table>
	<table>
	<tr>
       	<td align="right" height="30px" width="15%"><strong>'.$XLABEL[23].':</strong></td>
       	<td width="15%">
			<input type="hidden" id="TxtFecStay" value="'.date('d-m-Y').'" />
			<input type="text" id="TxtImpStay" style="width:120px; text-align:right;" value="'.number_format($XTOTAL).'" readonly="readonly" />
		</td>
       	<td align="right" width="15%" ><strong>'.$XLABEL[24].':</strong></td>
       	<td width="15%">
			<select id="SlcMonStay">';
				$XOBJMON=new monedas;
				$XRSMON=$XOBJMON->ver_monedas();
				$XI=0;
				while($XROWMON=$XOBJMON->obtener_fila($XRSMON)){
					if($XI==0) $XMONEDA=$XROWMON[1];
					$XTABLA.='<option value="'.$XROWMON[0].'">'.$XROWMON[0].'</option>';
					$XI++;
				}
			$XTABLA.='</select>
			<input type="text" id="TxtCopStay" style="width:80px; text-align:center;" value="'.$XMONEDA.'" readonly="readonly" />
		</td>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[38].':</strong></td>
       	<td width="15%">
			<input type="text" id="TxtTrmStay" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[25].':</strong></td>
       	<td>
			<input type="text" id="TxtBasStay" style="width:120px; text-align:right;" value="'.number_format($XBASE).'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[26].':</strong></td>
       	<td>
			<input type="text" id="TxtIvaStay" style="width:120px; text-align:right;" value="'.number_format($XIVA).'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[27].':</strong></td>
       	<td>
			<input type="text" id="TxtDscStay" style="width:120px; text-align:right;" value="'.number_format($XDESC).'" readonly="readonly" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[40].':</strong></td>
       	<td>
			<input type="text" id="TxtAbStay" style="width:120px; text-align:right;" value="'.$XABONO.'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[60].':</strong></td>
       	<td>
			<input type="text" id="TxtTrasStay" style="width:120px; text-align:right;" value="'.$XTRAS.'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[41].':</strong></td>
       	<td>
			<input type="text" id="TxtSalStay" style="width:120px; text-align:right;" value="'.$XSALDO.'" readonly="readonly" />
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabAmbienteMetodo($XLABEL, $XAMB, $XMET, $XIDCTA, $XPAG){
	$XMET=(int) $XMET;
	$XTABLA='<tr>
		<td align="left" colspan="7">
			<strong>'.$XLABEL[30].'</strong>
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncAdicionarStayPago()" />
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncEliminarStayPago()" />
		</td>
       	<td>';
			$OBJPAG=new pagos;
			$XTOTPAG=$OBJPAG->num_pagos_cuenta($XIDCTA, $XAMB);

			//$XTOTPAG=$XOBJCTA->paginas_vales($XCTA, $XAMB);
			$XTABLA.='<p class="paginacion" align="right" >';
			if($XPAG>1){ 
				$XP=$XPAG-1;
				$XTABLA.='<a onclick="FncVerPago('.$XP.')" style="cursor:pointer;"><img src="images/izq.gif" /></a>';
			}
			for($XJ=1;$XJ<=$XTOTPAG;$XJ++){
				$XTABLA.='<a onclick="FncVerPago('.$XJ.')" style="cursor:pointer; color:#FFFFFF; padding:4px 6px;">'.$XJ.'</a> ';
			}
			if(($XPAG<$XTOTPAG)&&($XTOTPAG>1)){ 
				$XP=$XPAG+1;
				$XTABLA.='<a onclick="FncVerPago('.$XP.')" style="cursor:pointer;"><img src="images/der.gif" /></a>';
			}
			$XTABLA.='</p>';


//			for($XJ=1;$XJ<=$XPAG;$XJ++){
	//			$XTABLA.='<a onclick="FncVerPago('.$XJ.')" style="cursor:pointer;">'.$XJ.'</a> ';
		//	}
		$XTABLA.='</td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[31].':</strong></td>
       	<td align="center">
			<select id="SlcMetStay" onchange="FncValidarMedio()">';
				$XOBJMED=new medios;
				$XRSMED=$XOBJMED->ver_medios_vales();
				while($XROWMED=$XOBJMED->obtener_fila($XRSMED)){
					$XTABLA.='<option value="'.$XROWMED[0].'">'.$XROWMED[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[55].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtIdPago" style="width:60px; text-align:center;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[61].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtFecPago" style="width:120px; text-align:center;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ></td>
       	<td align="center"></td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[42].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtPorcPago" style="width:60px; text-align:right;" value="" onblur="FncCalcPagoPrc()" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[39].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtValorPago" style="width:120px; text-align:right;" value="" onblur="FncCalcPagoVal()" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[25].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtBasePago" style="width:120px; text-align:right;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[26].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtIvasPago" style="width:120px; text-align:right;" value="" readonly="readonly" />
		</td>
   	</tr>
	<tr>
       	<td align="right" height="30px">
			<div id="trtc1" style="display:none;">
				<strong>'.$XLABEL[63].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc2" style="display:none;">
				<select id="SlcFranStay">
					<option value=""></option>';
					$XOBJFRAN=new franquicias;
					$XRSFRAN=$XOBJFRAN->ver_franquicias();
					while($XROWFRAN=$XOBJFRAN->obtener_fila($XRSFRAN)){
						$XTABLA.='<option value="'.$XROWFRAN[0].'">'.$XROWFRAN[1].'</option>';
					}
				$XTABLA.='</select>
			</div>
		</td>
       	<td align="right" height="30px">
			<div id="trtc3" style="display:none;">
				<strong>'.$XLABEL[32].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc4" style="display:none;">
				<input type="text" id="TxtTcStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right" height="30px">
			<div id="trtc5" style="display:none;">
				<strong>'.$XLABEL[35].':</strong>
			</div>
		</td>
       	<td align="center" colspan="2">
			<div id="trtc6" style="display:none;">
				<input type="text" id="TxtTitStay" style="width:300px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
    </tr>
	<tr>
       	<td align="right" >
			<div id="trtc7" style="display:none;">
				<strong>'.$XLABEL[33].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc8" style="display:none;">
				<input type="text" id="TxtExpStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right" >
			<div id="trtc9" style="display:none;">
				<strong>'.$XLABEL[34].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc10" style="display:none;">
				<input type="text" id="TxtDigStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right">
			<div id="trtc11" style="display:none;">
				<strong>'.$XLABEL[36].':</strong>
			</div>
		</td>
       	<td align="center">
			<div id="trtc12" style="display:none;">
				<input type="text" id="TxtCodStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
       	<td align="right">
			<div id="trtc13" style="display:none;">
				<strong>'.$XLABEL[37].':</strong>
			</td>
       	<td align="center">
			<div id="trtc14" style="display:none;">
				<input type="text" id="TxtHorStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
			</div>
		</td>
    </tr>
	<tr>
       	<td align="center" colspan="8" height="30px">
			<input type="button" id="BtnPagar" value="';
				if($XMET!='2') 
					$XTABLA.=$XLABEL[54].'" onclick="FncAdicionarPagos()" />';
				else 
					$XTABLA.=$XLABEL[57].'" onclick="FncAdicionarPagos()" />';
		$XTABLA.='</td>
    </tr>';
	return $XTABLA;	
}

//BUSQUEDA DE CLIENTES EN FACTURACION
function FncTabBuscarClientesFac($XLABEL, $XINFO, $XSIGNOS, $XBUSCAR){
  	$XTABLA='<tr style="background-color:#a0cee6">
       	<td align="center">'.$XLABEL[44].'</td>
       	<td align="center">'.$XLABEL[71].'</td>
      	<td align="center">'.$XLABEL[65].'</td>
       	<td align="center">'.$XLABEL[47].'</td>
       	<td align="center">'.$XLABEL[48].'</td>
       	<td align="center">'.$XLABEL[49].'</td>
       	<td align="center">'.$XLABEL[72].'</td>
   	</tr>';
	$XOBJCLI=new clientes;
	if($XBUSCAR=="2"){
		$XRSCLI=$XOBJCLI->busqueda_avanzada_clientes($XINFO,$XSIGNOS,0,100);
	}
	else{
		$XIDCLI=$XINFO[0];
		$XNOMCLI=$XINFO[1];
		$XIDTER=$XINFO[2];
		$XNOMTER=$XINFO[3];
		$XRSCLI=$XOBJCLI->busqueda_basica_clientes($XIDCLI,$XNOMCLI,$XIDTER,$XNOMTER,0,100);
	}
	while($XROWCLI=$XOBJCLI->obtener_fila($XRSCLI)){
		$XIDCLI="'".$XROWCLI[0]."'";
		$XTABLA.='<tr>
        	<td>
				<a onclick="FncBuscarCliente('.$XIDCLI.')" style="cursor:pointer">'.$XROWCLI[0].'</a>
			</td>
   	    	<td>'.$XROWCLI[1].'</td>
       	   	<td>
				<a onclick="FncBuscarCliente('.$XIDCLI.')" style="cursor:pointer">'.$XROWCLI[2].' '.$XROWCLI[3].'</a>
			</td>
       		<td>'.$XROWCLI[4].'</td>
   	       	<td>'.$XROWCLI[5].'</td>
   	       	<td>'.$XROWCLI[6].'</td>
   	       	<td>'.$XROWCLI[7].'</td>
   	   	</tr>';
	}
	return $XTABLA;
}


//COMPRAS

//BUSQUEDA DE PROVEEDORES EN COMPRAS
function FncTabBuscarProveedores($XLABEL, $XINFO, $XSIGNOS, $XBUSCAR){
  	$XTABLA='<tr style="background-color:#a0cee6">
       	<td align="center">'.$XLABEL[2].'</td>
       	<td align="center">'.$XLABEL[5].'</td>
       	<td align="center">'.$XLABEL[8].'</td>
       	<td align="center">'.$XLABEL[10].'</td>
   	</tr>';
	$XOBJCLI=new clientes;
	if($XBUSCAR=="2"){
		$XRSCLI=$XOBJCLI->busqueda_avanzada_clientes($XINFO,$XSIGNOS,0,100);
	}
	else{
		$XIDCLI=$XINFO[0];
		$XNOMCLI=$XINFO[1];
		$XIDTER=$XINFO[2];
		$XNOMTER=$XINFO[3];
		$XRSCLI=$XOBJCLI->busqueda_basica_proveedores($XIDCLI,$XNOMCLI,0,100);
	}
	while($XROWCLI=$XOBJCLI->obtener_fila($XRSCLI)){
		$XIDCLI="'".$XROWCLI[0]."'";
		$XTABLA.='<tr>
        	<td>
				<a onclick="FncBuscarProveedor('.$XIDCLI.')" style="cursor:pointer">'.$XROWCLI[0].'</a>
			</td>
       	   	<td>
				<a onclick="FncBuscarProveedor('.$XIDCLI.')" style="cursor:pointer">'.$XROWCLI[1].' '.$XROWCLI[2].'</a>
			</td>
   	    	<td>'.$XROWCLI[3].'</td>
       		<td>'.$XROWCLI[4].'</td>
   	   	</tr>';
	}
	return $XTABLA;
}

function FncTabComprasProv($XLABEL, $XINFO){
	$XTABLA='<tr>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[2].':</strong></td>
       	<td width="15%" align="center">
			<input type="text" id="TxtIdCliCar" value="'.$XINFO[0].'" style="width:80px; text-align:right;" readonly="readonly" />
			<img src="images/icon-buscar.png" width="30px" height="30px" style="cursor:pointer" onclick="FncVerDlgProveedor()" />
		</td>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[4].':</strong></td>
       	<td width="15%">'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td width="15%" align="right"></td>
	   	<td width="15%"></td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[5].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[6].':</strong></td>
       	<td>'.$XINFO[5].' / '.$XINFO[6].'</td>
       	<td align="right" ><strong>'.$XLABEL[7].':</strong></td>
       	<td>'.$XINFO[7].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[8].':</strong></td>
       	<td>'.$XINFO[8].'</td>
       	<td align="right"><strong>'.$XLABEL[9].':</strong></td>
      	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[10].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabDetalleCompra($XLABEL, $XCOMPRA){
	$XOBJCTA=new compras;
	$XRSDET=$XOBJCTA->ver_detalle_compras($XCOMPRA);
	//$XFILAS=$XOBJCTA->numero_filas($XRSDET);
	$XFILAS=0;
   	$XTABLA='<div class="container">
	<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[11].'</caption>';
	$XTABLA.='<tr>
    	<th width="320px">'.$XLABEL[12].'</th>
		<th width="50px">'.$XLABEL[13].'</th>
    	<th width="60px">'.$XLABEL[14].'</th>
    	<th width="30px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="60px">'.$XLABEL[21].'</th>';
		if($XFILAS<=0){
			$XTABLA.='<th>
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</th>
			<th>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" />
			</th>';
		}
	$XTABLA.='</tr>';
	//if(($XCTA=="")||($XCTA<="0")) $XCTA='1';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdCons'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdCons'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">'.number_format($XROWDET[4]).'</td>
			<td align="center">'.$XROWDET[5].'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="center">'.$XROWDET[7].'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'
				<input type="hidden" id="HddIvaCons'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</td>
			<td>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncEliminarCons('.$XIDCONSUMO.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='</table>
	<div>
	<table id="TdDetalleCons" style="display:none" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<input type="hidden" id="TxtIdCons" />
			<select id="SlcDescCons">
				<option value=""></option>';
				$XOBJPROD=new productos;
				$XRSPROD=$XOBJPROD->ver_productos();
				while($XROWPROD=$XOBJPROD->obtener_fila($XRSPROD)){
					$XTABLA.='<option value="'.$XROWPROD[0].'">'.$XROWPROD[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
		<td align="right">
			<input type="text" id="TxtClsCons" style="width:30px; text-align:center; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="right">
			<input type="text" id="TxtVlrCons" style="width:50px; text-align:right; font-size:10px;" value="" onfocus="FncSelProdHuesped()" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtCanCons" style="width:20px; text-align:center; font-size:10px;" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtStCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly"  onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtPorCons" style="width:20px; text-align:center; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtDscCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="left">
			<input type="text" id="TxtBasCons" style="width:50px; text-align:right; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtIvaCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
			<input type="hidden" id="HddIvaCons" />
		</td>
		<td align="center">
			<input type="text" id="TxtTotCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly" />
		</td>
       	<td align="center">
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncAdiConsumosVenta()" title="Adicionar Consumo" />
		</td>
		<td>
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncOcultarFilaConsumos()" />
		</td>
	</tr>
	</table>
	<script>
		$("#TxtTotCons").keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == "13"){
        		FncAdiConsumosVenta(); 
    		}	
		});
	</script>
	<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Ver todos los Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input
					.val( "" )
					.attr( "title", value + " No Coincide con ningun Registro" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#SlcDescCons" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#SlcDescCons" ).toggle();
		});

	});
	</script>';
	return $XTABLA;
}

function FncTabDetallePagosCom($XLABEL, $XIDCTA){
	$XOBJCTA=new compras;
	$XRSCTA=$XOBJCTA->totalizar_compras($XIDCTA);
	$XROWCTA=$XOBJCTA->obtener_fila($XRSCTA);
	$XTOTAL=$XROWCTA[0];
	$XIVA=$XROWCTA[1];
	$XDESC=$XROWCTA[2];
	$XBASE=$XTOTAL-$XIVA;
	
	$XOBJPAG=new egresos;
	$XABONO=$XOBJPAG->ver_saldos_compra($XIDCTA);
	$XSALDO=$XTOTAL-$XABONO;
	
	$XTABLA='<tr>
       	<td align="right" height="30px" width="15%"><strong>'.$XLABEL[31].':</strong></td>
       	<td width="15%">
			<input type="hidden" id="TxtFecStay" value="'.date('d-m-Y').'" />
			<input type="text" id="TxtImpStay" style="width:120px; text-align:right;" value="'.number_format($XTOTAL).'" readonly="readonly" />
		</td>
       	<td align="right" width="15%" ><strong>'.$XLABEL[32].':</strong></td>
       	<td width="15%">
			<select id="SlcMonStay">';
				$XOBJMON=new monedas;
				$XRSMON=$XOBJMON->ver_monedas();
				$XI=0;
				while($XROWMON=$XOBJMON->obtener_fila($XRSMON)){
					if($XI==0) $XMONEDA=$XROWMON[1];
					$XTABLA.='<option value="'.$XROWMON[0].'">'.$XROWMON[0].'</option>';
					$XI++;
				}
			$XTABLA.='</select>
			<input type="text" id="TxtCopStay" style="width:80px; text-align:center;" value="'.$XMONEDA.'" readonly="readonly" />
		</td>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[33].':</strong></td>
       	<td width="15%">
			<input type="text" id="TxtTrmStay" style="width:120px; text-align:center;" value="" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[34].':</strong></td>
       	<td>
			<input type="text" id="TxtBasStay" style="width:120px; text-align:right;" value="'.number_format($XBASE).'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[35].':</strong></td>
       	<td>
			<input type="text" id="TxtIvaStay" style="width:120px; text-align:right;" value="'.number_format($XIVA).'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[36].':</strong></td>
       	<td>
			<input type="text" id="TxtDscStay" style="width:120px; text-align:right;" value="'.number_format($XDESC).'" readonly="readonly" />
		</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[37].':</strong></td>
       	<td>
			<input type="text" id="TxtAbStay" style="width:120px; text-align:right;" value="'.$XABONO.'" readonly="readonly" />
		</td>
       	<td align="right"><strong>'.$XLABEL[38].':</strong></td>
       	<td>
			<input type="text" id="TxtSalStay" style="width:120px; text-align:right;" value="'.$XSALDO.'" readonly="readonly" />
		</td>
       	<td align="right"></td>
       	<td></td>
    </tr>';
	return $XTABLA;	
}

function FncTabComprasMetodo($XLABEL, $XMET, $XIDCTA, $XPAG){
	$XMET=(int) $XMET;
	$XTABLA='<tr>
		<td align="left" colspan="7">
			<strong>'.$XLABEL[39].'</strong>
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncAdicionarStayPago()" />
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer;" onclick="FncEliminarStayPago()" />
		</td>
       	<td>';
			$OBJPAG=new egresos;
			$XTOTPAG=$OBJPAG->num_pagos_compra($XIDCTA);

			//$XTOTPAG=$XOBJCTA->paginas_vales($XCTA, $XAMB);
			$XTABLA.='<p class="paginacion" align="right" >';
			if($XPAG>1){ 
				$XP=$XPAG-1;
				$XTABLA.='<a onclick="FncVerPago('.$XP.')" style="cursor:pointer;"><img src="images/izq.gif" /></a>';
			}
			for($XJ=1;$XJ<=$XTOTPAG;$XJ++){
				$XTABLA.='<a onclick="FncVerPago('.$XJ.')" style="cursor:pointer; color:#FFFFFF; padding:4px 6px;">'.$XJ.'</a> ';
			}
			if(($XPAG<$XTOTPAG)&&($XTOTPAG>1)){ 
				$XP=$XPAG+1;
				$XTABLA.='<a onclick="FncVerPago('.$XP.')" style="cursor:pointer;"><img src="images/der.gif" /></a>';
			}
			$XTABLA.='</p>';

		$XTABLA.='</td>
   	</tr>
	<tr>
       	<td align="right" height="30px" ><strong>'.$XLABEL[40].':</strong></td>
       	<td align="center">
			<select id="SlcMetStay" onchange="FncValidarMedio()">';
				$XOBJMED=new medios;
				$XRSMED=$XOBJMED->ver_medios_vales();
				while($XROWMED=$XOBJMED->obtener_fila($XRSMED)){
					$XTABLA.='<option value="'.$XROWMED[0].'">'.$XROWMED[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[41].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtIdPago" style="width:60px; text-align:center;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[28].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtFecPago" style="width:120px; text-align:center;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ></td>
       	<td align="center"></td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[42].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtPorcPago" style="width:60px; text-align:right;" value="" onblur="FncCalcPagoPrc()" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[43].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtValorPago" style="width:120px; text-align:right;" value="" onblur="FncCalcPagoVal()" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[34].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtBasePago" style="width:120px; text-align:right;" value="" readonly="readonly" />
		</td>
       	<td align="right" height="30px" ><strong>'.$XLABEL[35].':</strong></td>
       	<td align="center" height="30px">
			<input type="text" id="TxtIvasPago" style="width:120px; text-align:right;" value="" readonly="readonly" />
		</td>
   	</tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[44].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtTcStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[45].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtBcoStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
		</td>
       	<td align="right" height="30px"><strong>'.$XLABEL[46].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtCtaStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
		</td>
    </tr>
	<tr>
       	<td align="right" ><strong>'.$XLABEL[47].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtExpStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
		</td>
       	<td align="right" ><strong>'.$XLABEL[48].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtDigStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
		</td>
       	<td align="right"><strong>'.$XLABEL[49].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtCodStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
		</td>
       	<td align="right"><strong>'.$XLABEL[50].':</strong></td>
       	<td align="center">
			<input type="text" id="TxtHorStay" style="width:120px; text-align:center;" value="" disabled="disabled" />
		</td>
    </tr>
	<tr>
       	<td align="center" colspan="8" height="30px">
			<input type="button" id="BtnPagar" value="';
				$XTABLA.=$XLABEL[51].'" onclick="FncAdicionarPagos()" />';
		$XTABLA.='</td>
    </tr>';
	return $XTABLA;	
}

//INTENCIONES

function FncTabDetalleIntencion($XLABEL, $XCOMPRA){
	$XOBJCTA=new intenciones;
	$XRSDET=$XOBJCTA->ver_detalle_intenciones($XCOMPRA);
	$XFILAS=$XOBJCTA->numero_filas($XRSDET);
   	$XTABLA='<div class="container">
	<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[60].'</caption>';
	$XTABLA.='<tr>
    	<th width="320px">'.$XLABEL[12].'</th>
		<th width="50px">'.$XLABEL[13].'</th>
    	<th width="60px">'.$XLABEL[14].'</th>
    	<th width="30px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="60px">'.$XLABEL[21].'</th>';
		if($XFILAS<=0){
			$XTABLA.='<th>
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</th>
			<th>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" />
			</th>';
		}
	$XTABLA.='</tr>';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdCons'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdCons'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">'.number_format($XROWDET[4]).'</td>
			<td align="center">'.$XROWDET[5].'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="center">'.$XROWDET[7].'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'
				<input type="hidden" id="HddIvaCons'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</td>
			<td>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncEliminarCons('.$XIDCONSUMO.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='</table>';
	$XTABLA.='<table id="TdDetalleCons" style="display:none" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<input type="hidden" id="TxtIdCons" />
			<select id="SlcDescCons">
				<option value=""></option>';
				$XOBJPROD=new productos;
				$XRSPROD=$XOBJPROD->ver_productos();
				while($XROWPROD=$XOBJPROD->obtener_fila($XRSPROD)){
					$XTABLA.='<option value="'.$XROWPROD[0].'">'.$XROWPROD[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
		<td align="right">
			<input type="text" id="TxtClsCons" style="width:30px; text-align:center; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="right">
			<input type="text" id="TxtVlrCons" style="width:50px; text-align:right; font-size:10px;" value="" onfocus="FncSelProdHuesped()" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtCanCons" style="width:20px; text-align:center; font-size:10px;" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtStCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly"  onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtPorCons" style="width:20px; text-align:center; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtDscCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="left">
			<input type="text" id="TxtBasCons" style="width:50px; text-align:right; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtIvaCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
			<input type="hidden" id="HddIvaCons" />
		</td>
		<td align="center">
			<input type="text" id="TxtTotCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly" />
		</td>
       	<td align="center">
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncAdiConsumosInt()" title="Adicionar Consumo" />
		</td>
		<td>
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncOcultarFilaConsumos()" />
		</td>
	</tr>
	</table>
	</div>
	<script>
		$("#TxtTotCons").keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == "13"){
        		FncAdiConsumosInt(); 
    		}	
		});
	</script>
	<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Ver todos los Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input

					.val( "" )
					.attr( "title", value + " No Coincide con ningun Registro" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#SlcDescCons" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#SlcDescCons" ).toggle();
		});

	});
	</script>';
	return $XTABLA;
}

//COTIZACIONES

function FncTabCotizaProv1($XLABEL, $XINFO){
	$XTABLA='<tr>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[2].':</strong></td>
       	<td width="15%" align="center">
			<input type="text" id="TxtIdProv1" value="'.$XINFO[0].'" style="width:80px; text-align:right;" readonly="readonly" />
			<img src="images/icon-buscar.png" width="30px" height="30px" style="cursor:pointer" onclick="FncVerDlgCotizacion(1)" />
		</td>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[4].':</strong></td>
       	<td width="15%">'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td width="15%"></td>
	   	<td width="15%"></td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[5].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[6].':</strong></td>
       	<td>'.$XINFO[5].' / '.$XINFO[6].'</td>
       	<td align="right" ><strong>'.$XLABEL[7].':</strong></td>
       	<td>'.$XINFO[7].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[8].':</strong></td>
       	<td>'.$XINFO[8].'</td>
       	<td align="right"><strong>'.$XLABEL[9].':</strong></td>
      	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[10].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabCotizaProv2($XLABEL, $XINFO){
	$XTABLA='<tr>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[2].':</strong></td>
       	<td width="15%" align="center">
			<input type="text" id="TxtIdProv2" value="'.$XINFO[0].'" style="width:80px; text-align:right;" readonly="readonly" />
			<img src="images/icon-buscar.png" width="30px" height="30px" style="cursor:pointer" onclick="FncVerDlgCotizacion(2)" />
		</td>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[4].':</strong></td>
       	<td width="15%">'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td width="15%"></td>
	   	<td width="15%"></td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[5].':</strong></td>
       	<td>'.$XINFO[4].' '.$XINFO[3].'</td>
       	<td align="right" ><strong>'.$XLABEL[6].':</strong></td>
       	<td>'.$XINFO[5].' / '.$XINFO[6].'</td>
       	<td align="right" ><strong>'.$XLABEL[7].':</strong></td>
       	<td>'.$XINFO[7].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[8].':</strong></td>
       	<td>'.$XINFO[8].'</td>
       	<td align="right"><strong>'.$XLABEL[9].':</strong></td>
      	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[10].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabCotizaProv3($XLABEL, $XINFO){
	$XTABLA='<tr>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[2].':</strong></td>
       	<td width="15%" align="center">
			<input type="text" id="TxtIdProv3" value="'.$XINFO[0].'" style="width:80px; text-align:right;" readonly="readonly" />
			<img src="images/icon-buscar.png" width="30px" height="30px" style="cursor:pointer" onclick="FncVerDlgCotizacion(3)" />
		</td>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[4].':</strong></td>
       	<td width="15%">'.$XINFO[1].' '.$XINFO[2].'</td>
       	<td width="15%"></td>
	   	<td width="15%"></td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[5].':</strong></td>
       	<td>'.$XINFO[3].' '.$XINFO[4].'</td>
       	<td align="right" ><strong>'.$XLABEL[6].':</strong></td>
       	<td>'.$XINFO[5].' / '.$XINFO[6].'</td>
       	<td align="right" ><strong>'.$XLABEL[7].':</strong></td>
       	<td>'.$XINFO[7].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[8].':</strong></td>
       	<td>'.$XINFO[8].'</td>
       	<td align="right"><strong>'.$XLABEL[9].':</strong></td>
      	<td>'.$XINFO[9].'</td>
       	<td align="right"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[10].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabDetalleCot1($XLABEL, $XIDCTA, $XIDCOT){
	$XTABLA='<tr>
    	<th width="320px">'.$XLABEL[12].'</th>
		<th width="50px">'.$XLABEL[13].'</th>
    	<th width="60px">'.$XLABEL[14].'</th>
    	<th width="30px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="60px">'.$XLABEL[21].'</th>';
	$XTABLA.='</tr>';
	$XI=0;
	if($XIDCOT==""){
		$XOBJCTA=new intenciones;
		$XRSDET=$XOBJCTA->ver_detalle_intenciones($XIDCTA);
	}
	else{
		$XOBJCTA=new cotizaciones;
		$XRSDET=$XOBJCTA->ver_detalle_cotizaciones($XIDCOT);
	}
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
       		if ($XI%2==0)
           		$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
   	  	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdCot1'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdCot1'.$XI.'" value="'.$XROWDET[1].'" />
				<input type="hidden" id="TxtClsCot1'.$XI.'" value="'.$XROWDET[3].'" />
				<input type="hidden" id="HddIvaCot1'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">
				<input type="text" id="TxtVlrCot1'.$XI.'" style="width:50px; text-align:right; font-size:10px;" value="'.$XROWDET[4].'" onblur="FncCalcProdCot(1,'.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtCanCot1'.$XI.'" style="width:20px; text-align:center; font-size:10px;" value="'.$XROWDET[5].'" onblur="FncCalcProdCot(1,'.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtStCot1'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[6].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtPorCot1'.$XI.'" style="width:20px; text-align:center; font-size:10px" value="'.$XROWDET[7].'" onblur="FncCalcProdCot(1,'.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtDscCot1'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[8].'" readonly="readonly" />
			</td>
			<td align="left">
				<input type="text" id="TxtBasCot1'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[9].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtIvaCot1'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[10].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtTotCot1'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[11].'" readonly="readonly" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
		<td align="center" colspan="10">
			<input type="hidden" id="TxtLimCot1" value="'.$XI.'" />
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabDetalleCot2($XLABEL, $XIDCTA, $XIDCOT){
	$XTABLA='<tr>
    	<th width="320px">'.$XLABEL[12].'</th>
		<th width="50px">'.$XLABEL[13].'</th>
    	<th width="60px">'.$XLABEL[14].'</th>
    	<th width="30px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="60px">'.$XLABEL[21].'</th>';
	$XTABLA.='</tr>';
	$XI=0;
	if($XIDCOT==""){
		$XOBJCTA=new intenciones;
		$XRSDET=$XOBJCTA->ver_detalle_intenciones($XIDCTA);
	}
	else{
		$XOBJCTA=new cotizaciones;
		$XRSDET=$XOBJCTA->ver_detalle_cotizaciones($XIDCOT);
	}
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
       		if ($XI%2==0)
           		$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
   	  	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdCot2'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdCot2'.$XI.'" value="'.$XROWDET[1].'" />
				<input type="hidden" id="TxtClsCot2'.$XI.'" value="'.$XROWDET[3].'" />
				<input type="hidden" id="HddIvaCot2'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">
				<input type="text" id="TxtVlrCot2'.$XI.'" style="width:50px; text-align:right; font-size:10px;" value="'.$XROWDET[4].'" onblur="FncCalcProdCot(2,'.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtCanCot2'.$XI.'" style="width:20px; text-align:center; font-size:10px;" value="'.$XROWDET[5].'" onblur="FncCalcProdCot(2,'.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtStCot2'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[6].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtPorCot2'.$XI.'" style="width:20px; text-align:center; font-size:10px" value="'.$XROWDET[7].'" onblur="FncCalcProdCot(2,'.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtDscCot2'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[8].'" readonly="readonly" />
			</td>
			<td align="left">
				<input type="text" id="TxtBasCot2'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[9].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtIvaCot2'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[10].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtTotCot2'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[11].'" readonly="readonly" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
		<td align="center" colspan="10">
			<input type="hidden" id="TxtLimCot2" value="'.$XI.'" />
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabDetalleCot3($XLABEL, $XIDCTA, $XIDCOT){
	$XTABLA='<tr>
    	<th width="320px">'.$XLABEL[12].'</th>
		<th width="50px">'.$XLABEL[13].'</th>
    	<th width="60px">'.$XLABEL[14].'</th>
    	<th width="30px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="60px">'.$XLABEL[21].'</th>';
	$XTABLA.='</tr>';
	$XI=0;
	if($XIDCOT==""){
		$XOBJCTA=new intenciones;
		$XRSDET=$XOBJCTA->ver_detalle_intenciones($XIDCTA);
	}
	else{
		$XOBJCTA=new cotizaciones;
		$XRSDET=$XOBJCTA->ver_detalle_cotizaciones($XIDCOT);
	}
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
       		if ($XI%2==0)
           		$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
   	  	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdCot3'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdCot3'.$XI.'" value="'.$XROWDET[1].'" />
				<input type="hidden" id="TxtClsCot3'.$XI.'" value="'.$XROWDET[3].'" />
				<input type="hidden" id="HddIvaCot3'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">
				<input type="text" id="TxtVlrCot3'.$XI.'" style="width:50px; text-align:right; font-size:10px;" value="'.$XROWDET[4].'" onblur="FncCalcProdCot(3, '.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtCanCot3'.$XI.'" style="width:20px; text-align:center; font-size:10px;" value="'.$XROWDET[5].'" onblur="FncCalcProdCot(3, '.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtStCot3'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[6].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtPorCot3'.$XI.'" style="width:20px; text-align:center; font-size:10px" value="'.$XROWDET[7].'" onblur="FncCalcProdCot(3, '.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtDscCot3'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[8].'" readonly="readonly" />
			</td>
			<td align="left">
				<input type="text" id="TxtBasCot3'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[9].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtIvaCot3'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[10].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtTotCot3'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[11].'" readonly="readonly" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
		<td align="center" colspan="10">
			<input type="hidden" id="TxtLimCot3" value="'.$XI.'" />
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabCotizaCompra($XLABEL, $XIDCTA, $XCOTIZ){
	$XOBJCTA=new cotizaciones;
	$XRSCOT=$XOBJCTA->buscar_cotizaciones($XIDCTA, $XCOTIZ, 1);
	$XINFO=$XOBJCTA->obtener_fila($XRSCOT);
	$XTABLA='<tr>
       	<td width="15%" align="right"><strong>'.$XLABEL[58].':</strong></td>
	   	<td width="15%" align="center">
			1 <input type="radio" name="RdCot" id="RdCot1" value="0" onclick="FncEscogerCotizacion(0)"'; 
				if($XCOTIZ=='0') $XTABLA.=' checked="checked"'; $XTABLA.='/>
			2 <input type="radio" name="RdCot" id="RdCot2" value="1" onclick="FncEscogerCotizacion(1)"'; 
				if($XCOTIZ=='1') $XTABLA.=' checked="checked"'; $XTABLA.='/>
			3 <input type="radio" name="RdCot" id="RdCot3" value="2" onclick="FncEscogerCotizacion(2)"'; 
				if($XCOTIZ=='2') $XTABLA.=' checked="checked"'; $XTABLA.='/>
		</td>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[2].':</strong></td>
       	<td width="15%" align="center">'.$XINFO[2].'
			<input type="hidden" id="TxtIdProv" value="'.$XINFO[2].'" />
		</td>
       	<td width="15%" align="right" height="30px"><strong>'.$XLABEL[4].':</strong></td>
       	<td width="15%">'.$XINFO[3].' '.$XINFO[4].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[5].':</strong></td>
       	<td>'.$XINFO[5].' '.$XINFO[6].'</td>
       	<td align="right" ><strong>'.$XLABEL[6].':</strong></td>
       	<td>'.$XINFO[7].' / '.$XINFO[8].'</td>
       	<td align="right" ><strong>'.$XLABEL[7].':</strong></td>
       	<td>'.$XINFO[9].'</td>
    </tr>
	<tr>
       	<td align="right" height="30px"><strong>'.$XLABEL[8].':</strong></td>
       	<td>'.$XINFO[10].'</td>
       	<td align="right"><strong>'.$XLABEL[9].':</strong></td>
      	<td>'.$XINFO[11].'</td>
       	<td align="right"><strong>'.$XLABEL[10].':</strong></td>
       	<td>'.$XINFO[12].'</td>
    </tr>';
	return $XTABLA;	
}

function FncTabDetalleComInt($XLABEL, $XIDCTA, $XCOTIZ){
	$XTABLA='<tr>
    	<th width="320px">'.$XLABEL[12].'</th>
		<th width="50px">'.$XLABEL[13].'</th>
    	<th width="60px">'.$XLABEL[14].'</th>
    	<th width="30px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="60px">'.$XLABEL[21].'</th>';
	$XTABLA.='</tr>';
	$XI=0;
	$XOBJCTA=new cotizaciones;
	$XRSCOT=$XOBJCTA->buscar_cotizaciones($XIDCTA, $XCOTIZ, 1);
	$XROWCOT=$XOBJCTA->obtener_fila($XRSCOT);
	
	$XRSDET=$XOBJCTA->ver_detalle_cotizaciones($XROWCOT[0]);
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
       		if ($XI%2==0)
           		$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
   	  	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdCom'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdCom'.$XI.'" value="'.$XROWDET[1].'" />
				<input type="hidden" id="TxtClsCom'.$XI.'" value="'.$XROWDET[3].'" />
				<input type="hidden" id="HddIvaCom'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">
				<input type="text" id="TxtVlrCom'.$XI.'" style="width:50px; text-align:right; font-size:10px;" value="'.$XROWDET[4].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtCanCom'.$XI.'" style="width:20px; text-align:center; font-size:10px;" value="'.$XROWDET[5].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtStCom'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[6].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtPorCom'.$XI.'" style="width:20px; text-align:center; font-size:10px" value="'.$XROWDET[7].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtDscCom'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[8].'" readonly="readonly" />
			</td>
			<td align="left">
				<input type="text" id="TxtBasCom'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[9].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtIvaCom'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[10].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtTotCom'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[11].'" readonly="readonly" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
		<td align="center" colspan="10">
			<input type="hidden" id="TxtLimCom" value="'.$XI.'" />
		</td>
	</tr>';
	return $XTABLA;
}


//EGRESOS

function FncTabMetodoEgr($XLABEL, $XIDCTA, $XINFO){
	$XTABLA='<tr>
       	<td align="right" height="30px" ><strong>'.$XLABEL[40].':</strong></td>
       	<td align="center">
			<select id="SlcMetEgr" onchange="FncValidarMedEgr()">';
				$XOBJMED=new medios;
				$XRSMED=$XOBJMED->ver_medios_vales();
				$XTABLA.='<option value="'.$XINFO[0].'">'.$XINFO[1].'</option>';
				while($XROWMED=$XOBJMED->obtener_fila($XRSMED)){
					$XTABLA.='<option value="'.$XROWMED[0].'">'.$XROWMED[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right" height="30px" >
			<div id="DivBanEgr" style="display:none;"><strong>'.$XLABEL[45].':</strong></div>
		</td>
       	<td align="center" height="30px">
			<select id="SlcBanEgr" onchange="FncValidarCuentas()" style="display:none;" >';
				$XOBJBAN=new bancos;
				$XRSBAN=$XOBJBAN->ver_bancos();
				$XTABLA.='<option value="'.$XINFO[2].'">'.$XINFO[3].'</option>';
				while($XROWBAN=$XOBJBAN->obtener_fila($XRSBAN)){
					$XTABLA.='<option value="'.$XROWBAN[0].'">'.$XROWBAN[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
       	<td align="right" height="30px" >
			<div id="DivBanCta" style="display:none;"><strong>'.$XLABEL[44].':</strong></div>
		</td>
       	<td align="center" height="30px">
			<select id="SlcBanCta" style="display:none;">';
				$XTABLA.='<option value="'.$XINFO[4].'">'.$XINFO[4].'</option>';
			$XTABLA.='</select>
		</td>
    </tr>';
	return $XTABLA;	
}

function FncTabDetalleEgreso($XLABEL, $XCOMPRA){
	$XOBJCTA=new egresos;
	$XRSDET=$XOBJCTA->ver_detalle_egresos($XCOMPRA);
	//$XFILAS=$XOBJCTA->numero_filas($XRSDET);
	$XFILAS=0;
   	$XTABLA='<div class="container">
	<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[55].'</caption>';
	$XTABLA.='<tr>
    	<th width="320px">'.$XLABEL[53].'</th>
		<th width="460px">'.$XLABEL[54].'</th>
    	<th width="100px">'.$XLABEL[21].'</th>';
		if($XFILAS<=0){
			$XTABLA.='<th>
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</th>
			<th>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" />
			</th>';
		}
	$XTABLA.='</tr>';
	//if(($XCTA=="")||($XCTA<="0")) $XCTA='1';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdCons'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdCons'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">'.number_format($XROWDET[4]).'</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</td>
			<td>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncElimDetalleEgreso('.$XIDCONSUMO.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='</table>
	<div>
	<table id="TdDetalleCons" style="display:none" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<input type="hidden" id="TxtIdCons" />
			<select id="SlcDescCons">
				<option value=""></option>';
				$XOBJPROD=new conceptos;
				$XRSPROD=$XOBJPROD->ver_conceptos_egresos();
				while($XROWPROD=$XOBJPROD->obtener_fila($XRSPROD)){
					$XTABLA.='<option value="'.$XROWPROD[0].'">'.$XROWPROD[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
		<td align="right">
			<input type="text" id="TxtObsCons" style="width:450px; text-align:left; font-size:10px;" value="" />
		</td>
		<td align="right">
			<input type="text" id="TxtVlrCons" style="width:100px; text-align:right; font-size:10px;" value="" />
		</td>
       	<td align="center">
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncAdiDetalleEgreso()" title="Adicionar Consumo" />
		</td>
		<td>
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncOcultarFilaConsumos()" />
		</td>
	</tr>
	</table>
	<script>
		$("#TxtVlrCons").keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == "13"){
        		FncAdiDetalleEgreso(); 
    		}	
		});
	</script>
	<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Ver todos los Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input

					.val( "" )
					.attr( "title", value + " No Coincide con ningun Registro" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#SlcDescCons" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#SlcDescCons" ).toggle();
		});

	});
	</script>';
	return $XTABLA;
}

//REQUISICIONES

function FncTabDetalleRequisicion($XLABEL, $XCOMPRA){
	$XOBJCTA=new requisiciones;
	$XRSDET=$XOBJCTA->ver_detalle_requisiciones($XCOMPRA);
	//$XFILAS=$XOBJCTA->numero_filas($XRSDET);
	$XFILAS=0;
   	$XTABLA='<div class="container">
	<table width="100%" cellpadding="0" cellspacing="0">
  	<caption>'.$XLABEL[13].'</caption>';
	$XTABLA.='<tr>
    	<th width="320px">'.$XLABEL[14].'</th>
		<th width="50px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="60px">'.$XLABEL[18].'</th>
    	<th width="30px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="50px">'.$XLABEL[21].'</th>
    	<th width="50px">'.$XLABEL[22].'</th>
    	<th width="60px">'.$XLABEL[8].'</th>';
		if($XFILAS<=0){
			$XTABLA.='<th>
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</th>
			<th>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" />
			</th>';
		}
	$XTABLA.='</tr>';
	//if(($XCTA=="")||($XCTA<="0")) $XCTA='1';
	$XI=0;
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdCons'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdCons'.$XI.'" value="'.$XROWDET[1].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">'.number_format($XROWDET[4]).'</td>
			<td align="center">'.$XROWDET[5].'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="center">'.$XROWDET[7].'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'
				<input type="hidden" id="HddIvaCons'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
			<td align="center">
				<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncVerFilaConsumos()" >
			</td>
			<td>
				<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncElimConsReq('.$XIDCONSUMO.')" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='</table>
	<div>
	<table id="TdDetalleCons" style="display:none" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<input type="hidden" id="TxtIdCons" />
			<select id="SlcDescCons">
				<option value=""></option>';
				$XOBJPROD=new productos;
				$XRSPROD=$XOBJPROD->ver_productos();
				while($XROWPROD=$XOBJPROD->obtener_fila($XRSPROD)){
					$XTABLA.='<option value="'.$XROWPROD[0].'">'.$XROWPROD[1].'</option>';
				}
			$XTABLA.='</select>
		</td>
		<td align="right">
			<input type="text" id="TxtClsCons" style="width:30px; text-align:center; font-size:10px;" readonly="readonly" value="" />
		</td>
		<td align="right">
			<input type="text" id="TxtVlrCons" style="width:50px; text-align:right; font-size:10px;" value="" onfocus="FncSelProdHuesped()" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtCanCons" style="width:20px; text-align:center; font-size:10px;" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtStCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly"  onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtPorCons" style="width:20px; text-align:center; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtDscCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="left">
			<input type="text" id="TxtBasCons" style="width:50px; text-align:right; font-size:10px" value="" onblur="FncCalcProdHuesped()" />
		</td>
		<td align="center">
			<input type="text" id="TxtIvaCons" style="width:40px; text-align:right; font-size:10px" value="" readonly="readonly" onblur="FncCalcProdHuesped()" />
			<input type="hidden" id="HddIvaCons" />
		</td>
		<td align="center">
			<input type="text" id="TxtTotCons" style="width:50px; text-align:right; font-size:10px" value="" readonly="readonly" />
		</td>
       	<td align="center">
			<img src="images/icon-mas.png" width="20px" height="20px" style="cursor:pointer" onclick="FncAdiConsumosReq()" title="Adicionar Consumo" />
		</td>
		<td>
			<img src="images/icon-menos.png" width="20px" height="20px" style="cursor:pointer" onclick="FncOcultarFilaConsumos()" />
		</td>
	</tr>
	</table>
	<script>
		$("#TxtTotCons").keypress(function(event){
		    var keycode = (event.keyCode ? event.keyCode : event.which);
    		if(keycode == "13"){
        		FncAdiConsumosReq(); 
    		}	
		});
	</script>
	<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-combobox" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						tooltipClass: "ui-state-highlight"
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Ver todos los Items" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-combobox-toggle ui-corner-right" )
					.mousedown(function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.click(function() {
						input.focus();

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input

					.val( "" )
					.attr( "title", value + " No Coincide con ningun Registro" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
	})( jQuery );

	$(function() {
		$( "#SlcDescCons" ).combobox();
		$( "#toggle" ).click(function() {
			$( "#SlcDescCons" ).toggle();
		});

	});
	</script>';
	return $XTABLA;
}

function FncTabDetalleEntAlm($XLABEL, $XCOMPRA){
	$XTABLA='<tr>
    	<th width="320px">'.$XLABEL[14].'</th>
		<th width="50px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="60px">'.$XLABEL[18].'</th>
    	<th width="30px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="50px">'.$XLABEL[21].'</th>
    	<th width="50px">'.$XLABEL[22].'</th>
    	<th width="60px">'.$XLABEL[8].'</th>';
	$XTABLA.='</tr>';
	$XI=0;
	$XOBJCTA=new requisiciones;
	$XRSDET=$XOBJCTA->ver_detalle_requisiciones($XCOMPRA);
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdSal'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdSal'.$XI.'" value="'.$XROWDET[1].'" />
				<input type="hidden" id="TxtClsSal'.$XI.'" value="'.$XROWDET[3].'" />
				<input type="hidden" id="HddIvaSal'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">
				<input type="text" id="TxtVlrSal'.$XI.'" style="width:50px; text-align:right; font-size:10px;" value="'.$XROWDET[4].'"  readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtCanSal'.$XI.'" style="width:20px; text-align:center; font-size:10px;" value="'.$XROWDET[5].'" onblur="FncCalcProdSal('.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtStSal'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[6].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtPorSal'.$XI.'" style="width:20px; text-align:center; font-size:10px" value="'.$XROWDET[7].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtDscSal'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[8].'" readonly="readonly" />
			</td>
			<td align="left">
				<input type="text" id="TxtBasSal'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[9].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtIvaSal'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[10].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtTotSal'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[11].'" readonly="readonly" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
				<td align="center" colspan="10">
					<input type="hidden" id="TxtLimSal" value="'.$XI.'" />
					<input type="button" value="'.$XLABEL[26].'" onclick="FncSalidaAlm()" />
				</td>
			</tr>';
	return $XTABLA;
}

function FncTabDetalleEntAlm2($XLABEL, $XCOMPRA){
	$XTABLA='<tr>
    	<th width="320px">'.$XLABEL[14].'</th>
		<th width="50px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="60px">'.$XLABEL[18].'</th>
    	<th width="30px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="50px">'.$XLABEL[21].'</th>
    	<th width="50px">'.$XLABEL[22].'</th>
    	<th width="60px">'.$XLABEL[8].'</th>';
	$XTABLA.='</tr>';
	$XI=0;
	$XOBJCTA=new salidas;
	$XRSDET=$XOBJCTA->ver_detalle_salidas($XCOMPRA);
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">'.number_format($XROWDET[4]).'</td>
			<td align="center">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="center">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
       	</tr>';
	$XI++;
	}
	return $XTABLA;
}

function FncTabDetalleEntAmb($XLABEL, $XCOMPRA){
	$XTABLA='<tr>
    	<th width="320px">'.$XLABEL[14].'</th>
		<th width="50px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="60px">'.$XLABEL[18].'</th>
    	<th width="30px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="50px">'.$XLABEL[21].'</th>
    	<th width="50px">'.$XLABEL[22].'</th>
    	<th width="60px">'.$XLABEL[8].'</th>';
	$XTABLA.='</tr>';
	$XI=0;
	$XOBJCTA=new salidas;
	$XRSDET=$XOBJCTA->ver_detalle_salidas($XCOMPRA);
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdEnt'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdEnt'.$XI.'" value="'.$XROWDET[1].'" />
				<input type="hidden" id="TxtClsEnt'.$XI.'" value="'.$XROWDET[3].'" />
				<input type="hidden" id="HddIvaEnt'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">
				<input type="text" id="TxtVlrEnt'.$XI.'" style="width:50px; text-align:right; font-size:10px;" value="'.$XROWDET[4].'"  readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtCanEnt'.$XI.'" style="width:20px; text-align:center; font-size:10px;" value="'.$XROWDET[5].'" onblur="FncCalcProdEnt('.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtStEnt'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[6].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtPorEnt'.$XI.'" style="width:20px; text-align:center; font-size:10px" value="'.$XROWDET[7].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtDscEnt'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[8].'" readonly="readonly" />
			</td>
			<td align="left">
				<input type="text" id="TxtBasEnt'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[9].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtIvaEnt'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[10].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtTotEnt'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[11].'" readonly="readonly" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
				<td align="center" colspan="10">
					<input type="hidden" id="TxtLimEnt" value="'.$XI.'" />
					<input type="button" value="'.$XLABEL[26].'" onclick="FncEntradaAmb()" />
				</td>
			</tr>';
	return $XTABLA;
}

function FncTabDetalleEntAmb2($XLABEL, $XCOMPRA){
	$XTABLA='<tr>
    	<th width="320px">'.$XLABEL[14].'</th>
		<th width="50px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="60px">'.$XLABEL[18].'</th>
    	<th width="30px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="50px">'.$XLABEL[21].'</th>
    	<th width="50px">'.$XLABEL[22].'</th>
    	<th width="60px">'.$XLABEL[8].'</th>';
	$XTABLA.='</tr>';
	$XI=0;
	$XOBJCTA=new entradas;
	$XRSDET=$XOBJCTA->ver_detalle_entradas($XCOMPRA);
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">'.number_format($XROWDET[4]).'</td>
			<td align="center">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="center">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
       	</tr>';
	$XI++;
	}
	return $XTABLA;
}

function FncTabEntradaAlmacen($XLABEL, $XCOMPRA){
	$XTABLA='<tr>
    	<th width="320px">'.$XLABEL[12].'</th>
		<th width="50px">'.$XLABEL[13].'</th>
    	<th width="60px">'.$XLABEL[14].'</th>
    	<th width="30px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="60px">'.$XLABEL[21].'</th>';
	$XTABLA.='</tr>';
	$XI=0;
	$XOBJCTA=new compras;
	$XRSDET=$XOBJCTA->ver_detalle_compras($XCOMPRA);
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'
				<input type="hidden" id="TxtIdSal'.$XI.'" value="'.$XROWDET[0].'" />
				<input type="hidden" id="HddProdSal'.$XI.'" value="'.$XROWDET[1].'" />
				<input type="hidden" id="TxtClsSal'.$XI.'" value="'.$XROWDET[3].'" />
				<input type="hidden" id="HddIvaSal'.$XI.'" value="'.$XROWDET[12].'" />
			</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">
				<input type="text" id="TxtVlrSal'.$XI.'" style="width:50px; text-align:right; font-size:10px;" value="'.$XROWDET[4].'"  readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtCanSal'.$XI.'" style="width:20px; text-align:center; font-size:10px;" value="'.$XROWDET[5].'" onblur="FncCalcProdSal('.$XI.')" />
			</td>
			<td align="center">
				<input type="text" id="TxtStSal'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[6].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtPorSal'.$XI.'" style="width:20px; text-align:center; font-size:10px" value="'.$XROWDET[7].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtDscSal'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[8].'" readonly="readonly" />
			</td>
			<td align="left">
				<input type="text" id="TxtBasSal'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[9].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtIvaSal'.$XI.'" style="width:40px; text-align:right; font-size:10px" value="'.$XROWDET[10].'" readonly="readonly" />
			</td>
			<td align="center">
				<input type="text" id="TxtTotSal'.$XI.'" style="width:50px; text-align:right; font-size:10px" value="'.$XROWDET[11].'" readonly="readonly" />
			</td>
       	</tr>';
	$XI++;
	}
	$XTABLA.='<tr>
		<td align="center" colspan="10">
			<input type="hidden" id="TxtLimSal" value="'.$XI.'" />
		</td>
	</tr>';
	return $XTABLA;
}

function FncTabEntradaAlmacen2($XLABEL, $XCOMPRA){
	$XTABLA='<tr>
    	<th width="320px">'.$XLABEL[12].'</th>
		<th width="50px">'.$XLABEL[13].'</th>
    	<th width="60px">'.$XLABEL[14].'</th>
    	<th width="30px">'.$XLABEL[15].'</th>
    	<th width="60px">'.$XLABEL[16].'</th>
    	<th width="30px">'.$XLABEL[17].'</th>
    	<th width="50px">'.$XLABEL[18].'</th>
    	<th width="50px">'.$XLABEL[19].'</th>
    	<th width="50px">'.$XLABEL[20].'</th>
    	<th width="60px">'.$XLABEL[21].'</th>';
	$XTABLA.='</tr>';
	$XI=0;
	$XOBJCTA=new almacen;
	$XRSDET=$XOBJCTA->ver_detalle_almacen($XCOMPRA);
	while($XROWDET=$XOBJCTA->obtener_fila($XRSDET)){
		$XIDCONSUMO="'".$XROWDET[0]."'";
		$XTABLA.='<tr';
        	if ($XI%2==0)
            	$XTABLA.=' style="background-color:#e6e6fa;"'; //si el resto de la división es 0 pongo un color
           	else
      	    	$XTABLA.=' style="background-color:#d3d3d3;"';
		$XTABLA.='>
			<td align="left">'.$XROWDET[2].'</td>
			<td align="center">'.$XROWDET[3].'</td>
			<td align="right">'.number_format($XROWDET[4]).'</td>
			<td align="center">'.number_format($XROWDET[5]).'</td>
			<td align="right">'.number_format($XROWDET[6]).'</td>
			<td align="center">'.number_format($XROWDET[7]).'</td>
			<td align="right">'.number_format($XROWDET[8]).'</td>
			<td align="right">'.number_format($XROWDET[9]).'</td>
			<td align="right">'.number_format($XROWDET[10]).'</td>
			<td align="right">'.number_format($XROWDET[11]).'</td>
       	</tr>';
	$XI++;
	}
	return $XTABLA;
}

?>