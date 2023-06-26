<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="ISO-8859-1">
<title>Registro Unico de Preguntas</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<link href="css/bootstrap.min-2.css" rel="stylesheet">
<link rel="stylesheet" href="css/preguntas.css">
<link rel="stylesheet" href="css/totproyectos.css">
<link href="css/styledynam3.css" rel="stylesheet">
<link rel="stylesheet" href="css/regiones3.css">
<script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>  
 <link rel="stylesheet" href="css/regiones.css">
  

 <script>
function AgregarMas() {
    var id = $(".lista-producto").length + 1;
    $("<div>").load("InputDinamicoPreguntas.php", function() {
            var html = $(this).html();
            html = html.replace('identificador-1', 'identificador-' + id);
            html = html.replace('nombre-1', 'nombre-' + id);
            html = html.replace('padre-1', 'padre-' + id); 
            html = html.replace('nompadre-1', 'nompadre-' + id); 
            html = html.replace('nomrespuesta-1', 'nomrespuesta-' + id); 
            html = html.replace('idrespuesta-1', 'idrespuesta-' + id); 
            html = html.replace('respuestacierre-1', 'respuestacierre-' + id); 
            html = html.replace('respuestariesgo-1', 'respuestariesgo-' + id); 
            html = html.replace('switch-label-1', 'switch-label-' + id);
            html = html.replace('for="switch-label-1', 'for="switch-label-' + id);
            html = html.replace('nompreguntapadre-1', 'nompreguntapadre-' + id); 
	        html = html.replace('item-1', 'item-' + id);
	        $("#listpreguntas").append(html);
       	    $('#nombre-'+id).focus();
       	    buscarInfopreguntarespuesta();
       	    buscarInfopadres();
       	   
       	
	});
}

function BorrarRegistro() {
 	$('div.lista-producto').each(function(index, item){
	   var idval = index + 1;
		jQuery(':checkbox', this).each(function () {
            if ($("#item-" + idval).is(':checked')) {
				$(item).remove();
            }
        });
	});
}
</script>

<script>
function buscarInfopadres()
{
    $('[id^=nompreguntapadre-').on('keyup', function() {
        var key = $(this).val();
        var dataString = 'key='+key;
        var rowId = $(this).attr('id').split('-')[1];
 	$.ajax({
            type: "POST",
            url: "funciones/obtienesearchpadres.php",
            data: dataString,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#sugerencia9').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.sugerencia-element').on('click', function(){

                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        var nompadrecomp =  $('#'+id).attr('data') + ":" + id;
                        //Editamos el valor del input con data de la sugerencia pulsada
                         $('#nompadre-'+rowId).val(nompadrecomp);
                         $('#padre-'+rowId).val(id);
					    //Hacemos desaparecer el resto de sugerencias
                        $('#sugerencia9').fadeOut(1000);
                       return false;
                });
            }
        });
    });
}
    
$(document).ready(function() {
    buscarInfopadres();
});
    
function buscarInfopreguntarespuesta()
{
    $('[id^=nomrespuesta-').on('keyup', function() {
        var key = $(this).val();
        var dataString = 'key='+key;
        var rowId = $(this).attr('id').split('-')[1];
 	$.ajax({
            type: "POST",
            url: "funciones/obtienesearchpreguntarespuesta.php",
            data: dataString,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#sugerencia7').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.sugerencia-element').on('click', function(){

                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        var nomrespcomp =  $('#'+id).attr('data') + ":" + id;
                        //Editamos el valor del input con data de la sugerencia pulsada
                         $('#nomrespuesta-'+rowId).val(nomrespcomp);
                         $('#idrespuesta-'+rowId).val(id);
                         var idant = rowId - 1;
                         var nombre = $("#nombre-" + idant).val();  
                         var validant =  $("#identificador-" + idant).val();
                         if (rowId == 1) 
                         {
                             $("#padre-" + rowId).val(0);
    						  $("#nompadre-" + rowId).val("Raiz"); 
    	    	  		}
    	    	  		else
    	    	  		{
    	    		  		 $("#nompadre-" + rowId).val(nombre); 
    	    		  		 $("#padre-" + rowId).val(validant);
    		            }
                          $("#identificador-" + rowId).val(rowId);
                        
					    //Hacemos desaparecer el resto de sugerencias
                        $('#sugerencia7').fadeOut(1000);
                        $('#respuestacierre-'+rowId).focus();
                         var tipodato = $(this).attr('tipod');
                            $.ajax({
                              	 type: "POST",
                              	 data: {idrespuesta: id },
           						 url: "funciones/obtienelistavalores.php",
            					success: function(data1) {
            					       $("#respuestacierre-"+rowId).html(data1); 
                    				   $("#respuestariesgo-"+rowId).html(data1); 
            					}
     						});
                         cambioidpadre();  
                        return false;
                });          
            }
        });
    });
}
    
$(document).ready(function() {
	    buscarInfopreguntarespuesta();
});

function cambioidpadre(){
    $('[id^=padre-').on('keyup', function() {
        var key1 = $(this).val();
        var dataString = 'key='+key1;
        var rowId = $(this).attr('id').split('-')[1];
 	                      var nombre = $("#nombre-" + key1).val();  
                      	 $("#nompadre-" + rowId).val(nombre); 
    	    		    return false;
           });
}
    
$(document).ready(function() {
	    cambioidpadre();
});
     
</script>

<script>
function prcadicionarriesgo(idres, idbloque, cons){
  window.open("creapreguntabloqueriesgo.php?idres="+idres+"&idbloque="+idbloque+"&consulta="+cons, "", "toolbar=0,location=0,status=0,resizable=0,width=550, height=550, top=30, left=300, scrollbars=NO");
}
</script>

</head>
<body>
<?php  

include "clases/Json.class.php";
$Json     = new Json;
$Json->iniciarVariables();


function insertarpregunta($idbloque, $nom_pregunta, $nom_respuesta, $respuesta_cierre, $respuesta_riesgo, $id_padre, $id_respuesta, $estadoval )
{
    echo "ingrese a insertar preguntas";
    
    include_once "clases/Json.class.php";
    $Json     = new Json;
    $Json->iniciarVariables();
    
    /* luego procedo a insertar las preguntas */
    $tabla = "enc_preguntas";
    $identificador = "identificador";
    
    for ($i=0; $i < count($nom_pregunta); $i++)      
    {
            if (isset($id_respuesta[$i]))
            {
                $idrespuesta[$i] = $id_respuesta[$i];
            }
            else
            {
                $respini = explode(":",$nom_respuesta[$i]);
                $idrespuesta[$i] = $respini[1];
            }
            /* Recorro el numero de preguntas padres creadas y las inserto */
            $xsequencia = $Json->buscarsecuenciaglobal($tabla, $identificador);
            $ultimocodigo = $Json->obtener_fila($xsequencia);
            if (!isset($ultimocodigo["maximo"]))
                $maxid=0;
            else
                $maxid = $ultimocodigo["maximo"];
            
            if ($estadoval[$i] == "on")
               $estadoval[$i] = 1;
            else
               $estadoval[$i] = 0;
            
               echo "estadoval es $estadoval[$i]";
            $arrpadre[$i] = $maxid;
            $varpadre = $i - $id_padre[$i];
            $valp = $id_padre[$i] ;
            if ($valp == 0)
               $padrefin = 0;
            else
            {
               if ($varpadre == 1)
                  $padrefin = $maxid;
               else
               {
                  if ($id_padre[$i] <= $i)
                      $padrefin = $arrpadre[$valp];
                  else
                      $padrefin = $valp;
               }
             }
             $xidpregunta = $maxid + 1;
             $xpregunta[0] = $xidpregunta;
             $xpregunta[1] = $nom_pregunta[$i];
             $xpregunta[2] = "17";
             $xpregunta[3] = $estadoval[$i];
             $xpregunta[4] = date('Y-m-d H:i:s');
             $xpregunta[5] = $padrefin;
             $xpregunta[6] = $respuesta_cierre[$i];
             $xpregunta[7] = $idbloque;
             $xpregunta[8] = $respuesta_riesgo[$i];
             $xpregunta[9] = $id_respuesta[$i];
             $xinsertpregunta = $Json->insertapregunta($xpregunta);
             if((!isset($xinsertpregunta)) or ($xinsertpregunta == FALSE)) 
                 $correcto = "false";
              else
               $correcto = "true";
     }
     if ($correcto)
            $disp = "Se han insertado las preguntas correctamente.";
     else
            $disp = "Se ha presentado un error insertando las preguntas...";
                
      return array($correcto,$disp);
}

if (isset($_POST["descripcion"]))
    $descripcion = $_POST["descripcion"];
else
    $descripcion = "";
$correcto="";
$disp="";
    
if (isset($_GET["id"]) or (isset($_POST["id"])))
{
         if (isset($_GET["id"]))
            $id = $_GET["id"];
         else
            $id = $_POST["id"];
         $filtro = "identificador = '$id'";
         $result = $Json->buscarbloquepregunta($filtro);
         $xinfobloque = $Json->obtener_fila($result);
         $descripcion = utf8_encode($xinfobloque["descripcion"]);
         $estado = $xinfobloque["estado"];
         if ($estado == "2")
            $estado = "off";
         else 
            $estado = "on";
}
    
if ((isset($_POST['guardar'])) && ($_POST['guardar'] == "Guardar Ahora"))
{   
    $descripcion = $_POST['descripcion'];
    $seltipoest = "15";
    if (isset($_POST['estadobloque']))
        $estadobloque = $_POST['estadobloque'];
    if ($estadobloque == "on")
        $estadobloque = "1";
    else 
        $estadobloque = "2";
    $id = $_POST["id"];
    if (isset($id) && ($id > 0))
    {
        $bloquep[1] = $descripcion;
        $bloquep[3] = $estadobloque;
        $cadena = "descripcion = '$descripcion' , estado = '$estadobloque'";
        $filtro = "identificador = '$id'";
        $xactualizabloquep = $Json->actualizabloquep($filtro,$cadena);
        if((!isset($xactualizabloquep)) or ($xactualizabloquep == FALSE)) {
            $correcto = "false";
            $disp .= "Se ha presentado un error en la actualizacion del bloque de preguntas... ".$xactualizabloquep . "<br>";
        }
        else
        {
            $correcto = "true";
            $disp .= "Se ha actualizado el Bloque de Preguntas correctamente. <br>";
        }
        $filtro = "p.id_bloque_preguntas = '$id'";
        $result = $Json->buscarpreguntas($filtro);
        $xrowp = array();
        $xi = 0;
        while ($xrowp = $Json->obtener_fila($result)) {
            $nombreest = "estadovalupd-".$xi;
            if (!isset($_POST[$nombreest]))
               $estadop = "2";
           else 
               $estadop = "1";
           $identfp = $xrowp["identificador"];
           $cadena = "estado = '$estadop'";
           $filtro = "identificador = '$identfp' and id_bloque_preguntas = '$id'";
           $xactualizapreg = $Json->actualizapreg($filtro,$cadena);
           if((!isset($xactualizapreg)) or ($xactualizapreg == FALSE)) {
               $correcto = "false";
            }
           else
           {
               $correcto = "true";
            }
            $xi++;
        }
        /* luego procedo a insertar las preguntas */
        if ($correcto)
            $disp .= "Se han actualizado las preguntas correctamente.";
        else 
            $disp .= "Se ha presentado un error en la actualizacion de las preguntas...";
        list ($correcto, $disp2) = insertarpregunta($id, $_POST["pro_nom"], $_POST["nom_respuesta"], $_POST["respuestacierre"], $_POST["respuestariesgo"], $_POST["pro_padre"], $_POST["id_respuesta"], $_POST["estadoval"]); 
        $disp = $disp."<br>".$disp2;
    }
    else 
    {
    /* llamo clase para insertar datos del bloque */
    $tabla = "enc_bloque_preguntas";
    $identificador = "identificador";
    $xsequencia = $Json->buscarsecuenciaglobal($tabla, $identificador);
        $ultimocodigo = $Json->obtener_fila($xsequencia);
        if (!isset($ultimocodigo["maximo"]))
            $maxid=0;
        else
             $maxid = $ultimocodigo["maximo"];
        if ($estadobloque == "on")
            $estadobloque = 1;
        else
            $estadobloque = 0;
            $xidbloquepregunta = $maxid + 1;
            $bloquep[0] = $xidbloquepregunta;
            $bloquep[1] = $descripcion;
            $bloquep[2] = $seltipoest;
            $bloquep[3] = $estadobloque;
            $xinsertbloquep = $Json->insertabloquep($bloquep);
        if((!isset($xinsertbloquep)) or ($xinsertbloquep == FALSE)) {
             $correcto = "false";
             $disp .= "Se ha presentado un error en la creacion del bloque de preguntas... ".$xinsertbloquep . "<br>";
        }
        else
        {
            $correcto = "true";
            $disp .= "Se ha creado el Bloque de Preguntas correctamente. <br>";
        }
    
            
        /* luego procedo a insertar las preguntas */
        list ($correcto, $disp2) = insertarpregunta($xidbloquepregunta, $_POST["pro_nom"], $_POST["nom_respuesta"], $_POST["respuestacierre"], $_POST["respuestariesgo"], $_POST["pro_padre"], $_POST["id_respuesta"], $_POST["estadoval"]);
        $disp = $disp."<br>".$disp2;
          }
}


    /* ingreso al formulario inicial */

include 'header2rh.php';

    echo '
                        <div class="titulo_p"><i class="fa-solid fa-question"></i>&nbsp;<div>Registro único de Preguntas</div></div>
                        <div class="link_int">
                        <div class="titulo2"><i class="fa-solid fa-question"></i><a href="creapreguntabloque.php"> Registro Bloque de Preguntas</a></div>
                        <div class="titulo3"><a href="listarpreguntasrh.php">Listar Preguntas</a></div></div>
                        <div class="contenedor_titulos ">
                        <div class="campos titulo">Bloque de Preguntas</div>
                        </div>';
    echo ' <div class="contenedor"><form name="bloque" class="registro" action="" method="post"> ';
    /* Llamo a la clase */
    $Json     = new Json;
    $Json->iniciarVariables();
/* ingreso campos del formulario de bloque de preguntas */
    echo '<div class="nueva_pre">';
    echo '<div><legend>Descripcion: </legend><input name="descripcion" type="text" value="'.$descripcion.'"  > </div>';
    /* tipo de estados select */
    echo '<div class="switch-button"><legend>Estado: </legend>';
    if (isset($estado))
        if ($estado == "on")
            echo ' <input type="checkbox" name="estadobloque" id="switch-label" class="switch-button__checkbox" checked>';
        else 
            echo ' <input type="checkbox" name="estadobloque" id="switch-label" class="switch-button__checkbox" >';
    else
        echo ' <input type="checkbox" name="estadobloque" id="switch-label" class="switch-button__checkbox" checked>';
    echo '<label for="switch-label" class="switch-button__label"></label>
                </div>';
    echo "</div>";
    $resultado = "";
    $setid = "";
    
    /* busco la informacion de las preguntas que tiene el bloque */
   if (isset($_GET["id"]) or (isset($_POST["id"])))        
    {
        if (isset($_GET["id"]))
            $idpr = $_GET["id"];
        else 
            $idpr = $_POST["id"];
            $filtro = "p.id_bloque_preguntas = '$idpr'";
            $result = $Json->buscarpreguntas($filtro);
            $xrowp = array();
             $xpreg = 0;
        echo '
        <div class="titulo2"><i class="fa-solid fa-user"></i> Preguntas del Bloque</div>
        <div class="contenedor_titulos">
        <div class="campos_list_u titulo">Id</div>
        <div class="campos_list_u titulo">Nombre Pregunta</div>
        <div class="campos_list_u titulo">Pregunta Padre</div>
        <div class="campos_list_u titulo">Respuesta</div>
        <div class="campos_list_u titulo">Valor Respuesta  Cierre</div>
        <div class="campos_list_u titulo">Valor Respuesta  Activa Riesgo</div>
        <div class="campos_list_u titulo">Fecha Efectiva</div>
        <div class="campos_list_u titulo">Estado</div>
        <div class="campos_list_u titulo">Gestionar Riesgo</div>                    
        </div>';
    
         while ($xrowp = $Json->obtener_fila($result)) {
        
        $nombrepregunta = utf8_encode($xrowp["nombre"]);
        $identificadorpreg =  $xrowp["identificador"];
        $padre = utf8_encode($xrowp["padre"]);
        $fecha_efectiva = $xrowp["fecha_efectiva"];
        $estado = $xrowp["estado"];
        $idrespuesta = $xrowp["id_respuesta"];
        $valorrespcierre = $xrowp["respcierre"];
        $valorrespriesgo = $xrowp["respriesgo"];
        $nombreresp = $xrowp["nomrespuesta"];
        $filtropadre = "identificador = '$padre'";
        $resultpadre = $Json->buscapadres($filtropadre);
        $xrowpadre = $Json->obtener_fila($resultpadre);
        $nompadre = $xrowpadre["nombre"];
        $filtrorespcierre = "identificador = '$valorrespcierre'";
        $resultrespcierre = $Json->buscaenclistavalores($filtrorespcierre);
        $xrowcierre = $Json->obtener_fila($resultrespcierre);
        $nomcierre = $xrowcierre["valor_alfa_numerico"];
        $filtroriesgo = "identificador = '$valorrespriesgo'";
        $resultriesgo = $Json->buscaenclistavalores($filtroriesgo);
        $xrowriesgo = $Json->obtener_fila($resultriesgo);
        $nomriesgo = $xrowriesgo["valor_alfa_numerico"];
        $nomestf = "estadovalupd-".$xpreg;
        
        echo " <div class=\"contenedor\">";
        echo "<div class=\"campos_list_u\">$identificadorpreg</div>";
        echo "<div class=\"campos_list_u\">$nombrepregunta</div>";
        echo "<div class=\"campos_list_u\">".$nompadre."</div>";
        echo "<div class=\"campos_list_u\">$nombreresp</div>";
        echo "<div class=\"campos_list_u\">$nomcierre</div>";
        echo "<div class=\"campos_list_u\">$nomriesgo</div>";
        echo "<div class=\"campos_list_u\">$fecha_efectiva </div>";
        echo '<div class="estado">
         <div class="switch-button">';
        if ($estado == "2")
           echo '<input type="checkbox" name="'.$nomestf.'" id="estadovalupd-'.$xpreg.'" class="switch-button__checkbox" >';
        else
           echo '<input type="checkbox" name="'.$nomestf.'" id="estadovalupd-'.$xpreg.'" class="switch-button__checkbox" checked>';
        echo '<label for="estadovalupd-'.$xpreg.'" class="switch-button__label"></label>
        </div>
        </div>';
        echo "<div class=\"campos_list_u\"><input type=\"submit\"  class=\"btn_sel\" name=\"adicionariesgo\"
              id=\"adicionariesgo\" value=\"Riesgo\" onclick=\"prcadicionarriesgo($identificadorpreg, $idpr)\" ></div>";
         
        echo "</div>";  
         $xpreg++;    
      }
    }
     /* aqui finaliza la busqueda */
    
    
    echo '
    			<div class="mt-5">
                <div class="row">
                <div class="col-12 col-md-12">
                <!-- Contenido -->
                <h3 class="titulo">Preguntas para Adicionar al Bloque </h3>
                <div id="outer">
                
    <div id="listpreguntas">';
    require_once("InputDinamicoPreguntas.php"); 
    echo '</div>';
 echo '<div id="sugerencia7" class="l_bloques"></div>
 	   <div id="sugerencia9" class="l_bloques"></div>';
   echo ' <div class="btn-action float-clear">
                <input class="btn_gris" type="button" name="agregar_registros" value="Agregar Mas" onClick="AgregarMas();" />
                <input class="btn_rojo" type="button" name="borrar_registros" value="Borrar Campos" onClick="BorrarRegistro();" />
              ';
   echo '<div> <input type="hidden" name="id" value='.$id.'></div>';
    echo ' 
            </div>
			<div style="position: relative;width:90%; margin:0 auto;">
			<input class="btn btn-primary" type="submit" name="guardar" value="Guardar Ahora" /></div>
    </div> '; 
     echo '   </form>
        </div>
       <div class="registro registro-b">';
    /* Publico mensajes del resultado de la insercion de preguntas */
    if ($correcto == "true")
        echo ' <div class="msj_verde"><span>'.$disp.'</span></div>';
    elseif ($correcto == "false")
        echo ' <div class="msj_rojo"><span>'.$disp.'</span></div>';
            
        echo '</div>';
        echo "</div></div></div>";
?>  
<script src="js/bootstrap.min.js"></script> <div class="cont_fin"></div>
</body>
</html>