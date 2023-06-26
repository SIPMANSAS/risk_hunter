<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="ISO-8859-1">
<title>Registro Unico de Preguntas</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<link href="css/bootstrap.min-2.css" rel="stylesheet">
<link rel="stylesheet" href="css/regiones4.css">
<link rel="stylesheet" href="css/preguntas.css">
<link rel="stylesheet" href="css/totproyectos.css">
<link href="css/styledynam4.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    


 <script>
function AgregarMas() {
    var id = $(".lista-producto").length + 1;
    var idant = id - 1;
    var nombreant =    $("#totnombre").val();
    var nombre2 = "";
    $("<div>").load("InputDinamicoriesgo.php", function() {
            var html = $(this).html();
            html = html.replace('nomriesgo-1', 'nomriesgo-' + id);
	        html = html.replace('idriesgo-1' , 'idriesgo-' + id );
	        html = html.replace('item-1', 'item-' + id );
	     	
	        $("#listriesgo").append(html);
       	    buscarInforiesgo();
       	 
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
    
function buscarInforiesgo(){
    $('[id^=nomriesgo-').on('keyup', function() {
        var key = $(this).val();
        var dataString = 'key='+key;
        var rowId = $(this).attr('id').split('-')[1];
        var idant = rowId - 1;
        var nombreant =    $("#totnombre").val();
        var nombre2 = "";
  
  	$.ajax({
            type: "POST",
            url: "funciones/obtienesearchriesgo.php",
            data: dataString,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#sugerencia10').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.sugerencia-element').on('click', function(){

                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        var nomriesgocomp =  $('#'+id).attr('data') + ":" + id ;
                        //Editamos el valor del input con data de la sugerencia pulsada
                         $('#nomriesgo-' + rowId).val(nomriesgocomp);
                         $('#idriesgo-' + rowId).val(id);
                         nombre2 =  nombre2.concat(nombreant);
    	            	  nombre2 =  nombre2.concat($("#nomriesgo-" + rowId).val());
    		              nombre2 =  nombre2.concat(";"); 
    		              $("#totnombre").val(nombre2);
 		 	              
					    //Hacemos desaparecer el resto de sugerencias
                        $('#sugerencia10').fadeOut(1000);
                       return false;
                });
            }
        });
    });
    }
    
    $(document).ready(function() {
    buscarInforiesgo();
    });
  
</script>

</head>
<body>
<header>
       <div class="logo">
       <a href="menu.php"><img src="img/logo_ies.fw.png" alt=""></a>
       </div>
       <nav class="m_admin ">
       </nav>
       <div class="usuario">
           <a href=""><i class="fa-solid fa-user"></i></a>
       </div>
</header>
<?php
include "clases/Json.class.php";
if (isset($_POST["descripcion"]))
    $descripcion = $_POST["descripcion"];
else
    $descripcion = "";
    $correcto="";
    $disp="";
    $setid="";
    $resultado="";
    
    if (isset($_GET["idres"]) or (isset($_POST["idbloque"])))
    {
        $Json     = new Json;
        $Json->iniciarVariables();
        if (isset($_GET["idres"]))
            $idres = $_GET["idres"];
        if (isset($_GET["idbloque"]))
            $idbloque = $_GET["idbloque"];
                
                 /* busco las preguntas de este bloque */
                
                $filtro = "p.id_bloque_preguntas = '$idbloque' and p.identificador = '$idres'";
                $result = $Json->buscarpreguntas($filtro);
                $xrowpr = $Json->obtener_fila($result);
                $nompregunta = utf8_encode($xrowpr["nombre"]);
                $idrespuesta = utf8_encode($xrowpr["id_respuesta"]);
                $valorrespriesgo = utf8_encode($xrowpr["respriesgo"]);
                $nombreresp = $xrowpr["nomrespuesta"];
                $filtroriesgo = "identificador = '$valorrespriesgo' and id_respuesta = '$idrespuesta'";
                $resultriesgo = $Json->buscaenclistavalores($filtroriesgo);
                $xrowriesgo = $Json->obtener_fila($resultriesgo);
                $nomvalriesgo = $xrowriesgo["valor_alfa_numerico"];
     }
    
if ((isset($_POST['guardar'])) && ($_POST['guardar'] == "Guardar Ahora"))
{
    include_once  "clases/Json.class.php";
    $Json     = new Json;
    $Json->iniciarVariables();   
    $idriesgof = array();
    $nombreriesgo = array();
    $idriesgof = $_POST["idriesgof"];
    $numr = $_POST["numr"];
    $nombreriesgo = $_POST["nombriesgo"];
    $totnombre = $_POST["totnombre"];
    $nom1 = explode(";" , $totnombre);
    $idriesgox = explode(":", $nom1);
    $contador = count($nom1);
    $id_pregunta = $_POST["id_pregunta"];
    $filtro = "id_pregunta = '$id_pregunta'";
    $Json->borrarriesgopreg($filtro);
    
    for ($i = 0; $i < count($idriesgof); $i++)
    {
                $riesgo[0] = $idriesgof[$i];
                $riesgo[1] = $id_pregunta;
                $riesgo[2] = date('Y-m-d');
                $riesgo[3] = '19';
                $riesgo[4] = '1';
                $xinsertriesgo = $Json->insertariesgopreg($riesgo);
                if((!isset($xinsertriesgo)) or ($xinsertriesgo == FALSE)) {
                    $correcto = "false";
                    $disp = "Se ha presentado un error en la creacion del riesgo... ".$xinsertriesgo;
                }
                else
                {
                    $correcto = "true";
                    $disp = "Se ha creado el riesgo correctamente.";
                }
        }
}

    /* ingreso al formulario inicial */

    echo ' <div class="contenedor"><form name="bloque" class="registro" action="" method="post"> ';
    /* Llamo a la clase */
    $Json     = new Json;
    $Json->iniciarVariables();
    $filtro = "identificador = $idbloque";
    $result = $Json->buscarbloquepregunta($filtro);
    $xrowb = $Json->obtener_fila($result);
    $descripcion = $xrowb["descripcion"];
    
    echo '<div class="bloque-p">';
    echo "<div><b>Bloque de Pregunta: </b> ".$descripcion."   </div>";
     echo "<div><b>Pregunta: </b>".$nompregunta."   </div>";
    //editcion por grabriel 17112022
    //echo "<div><b>Respuesta: </b>".$nombreresp."   </div>";
    //echo "<div><b>Valor Respuesta que Activa Riesgo:</b> ".$nomvalriesgo." </div>";
    //fin edicion gabriel
    echo "</div>";
     echo '<input type="hidden" readonly id="totnombre" name="totnombre" />';
    
     /* Hago el select de los riesgos*/
     $filtro = "r.id_pregunta = '$idres'";
     $result = $Json->buscariesgopreg($filtro);
     $xrowriesgo = array();
     $ir=1;
     while ($xrowriesgo = $Json->obtener_fila($result)) {
         $riesgo[$ir] = utf8_encode($xrowriesgo["nombre"]);
         $id_riesgo[$ir] = $xrowriesgo["id_riesgo"];
         $ir++;
     }
     echo '<div class="mt-5">
          <div class="row">
          <div class="col-12 col-md-12">
                <!-- Contenido -->
                <h3 class="titulo">Riesgos que pertenecen a la Pregunta </h3>
                <div id="outer">    
           <div id="listriesgo">';
    require_once("InputDinamicoriesgo.php"); 
    echo "</div>";
     
    echo ' <div class="btn-action float-clear">
                <input class="btn_gris" type="button" name="agregar_registros" value="Agregar Mas" onClick="AgregarMas();" />
                <input class="btn_rojo" type="button" name="borrar_registros" value="Borrar Campos" onClick="BorrarRegistro();" />
              ';
    echo '<div id="sugerencia10" class="l_bloques"></div>';
    echo '<input type="hidden" name="id_pregunta" value="'.$idres.'" />';
    echo '<input type="hidden" name="numr" value="'.$ir.'" />';
    
     echo ' </div>
			<div style="position: relative;">
			<input class="btn btn-primary" type="submit" name="guardar" value="Guardar Ahora" /></div>
    </div> ';
     echo '   </form>
        </div></div>

        </div></div>
       <div class="registro registro-b">';
    /* Publico mensajes del resultado de la insercion de preguntas */
    //edicion gabriel ajuste cerrar ventana 17112022
    //if ($correcto == "true")
    //    echo ' <div class="msj_verde"><span>'.$disp.'</span></div>';
    //elseif ($correcto == "false")
    //    echo ' <div class="msj_rojo"><span>'.$disp.'</span></div>';
            
    //    echo '<a href="javascript:window.close();"> <legend> Cerrar la ventana </legend> </a>'; 
    if ($correcto == "true")
        echo ' <div class="msj_verde"><span>'.$disp.'</span></div>';
    elseif ($correcto == "false")
        echo ' <div class="msj_rojo"><span>'.$disp.'</span></div>';
            
        echo '<div class="cont_fin"><a href="javascript:window.close();"> <legend> Cerrar la ventana </legend> </a> </div></div></div>'; 
      
      

?>  
<script src="js/bootstrap.min.js"></script> 
</body>
</html>