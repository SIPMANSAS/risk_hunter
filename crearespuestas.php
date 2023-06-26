<?php include "sec_login.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="ISO-8859-1">
    <title>Crear Respuestas</title>
    
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>      
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <link rel="stylesheet" href="css/preguntas.css">
	<link href="css/styledynam.css" rel="stylesheet">
	<link href="css/bootstrap.min-2.css" rel="stylesheet">
	  <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="css/regiones.css">
	<script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
	<script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
 
   <script>
		

function AgregarMas() {
    var id = $(".lista-valores").length + 1;
    var idant = id - 1;
  	
         $("<div>").load("InputDinamicovalores.php", function() {
            var html = $(this).html();
            html = html.replace('identificador-1', 'identificador-' + id);
            html = html.replace('nomb-1', 'nomb-' + id);
            html = html.replace('switch-label-1', 'switch-label-' + id);
            html = html.replace('for="switch-label-1', 'for="switch-label-' + id);
	        html = html.replace('item-1', 'item-' + id);
	          
            $("#identificador-" + idant).val(idant);
            $("#listvalores").append(html);
            cambionomb();
	});
}

function BorrarRegistro() {
 
	$('div.lista-valores').each(function(index, item){
	    var idval = index + 1;
	 	jQuery(':checkbox', this).each(function () {
		       if ($("#item-" + idval).is(':checked')) {
                       $(item).remove();
                 }
        });
	});
}

function cambionomb(){
    $('[id^=nomb-').on('keyup', function() {
        var key1 = $(this).val();
        var dataString = 'key='+key1;
        var rowId = $(this).attr('id').split('-')[1];
 	     $("#identificador-" + rowId).val(rowId); 
    	 return false;
           });
    }
    
    $(document).ready(function() {
	    cambionomb();
    });


</script> 

</head>
<?php
include 'header-rh.php';

include "clases/Json.class.php";
$Json     = new Json;
$Json->iniciarVariables();


$correcto="";
 $respuesta = "";
 $descripcion = "";
 $disp = "";
 
      
 if (isset($_GET["id"]) or (isset($_POST["id_respuesta"])))
 {
     if (isset($_GET["id"]))
         $id = $_GET["id"];
         else
             $id = $_POST["id_respuesta"];
             $filtro = "identificador = '$id'";
             $result = $Json->buscarespuestas($filtro);
             $xinfobloque = $Json->obtener_fila($result);
             $descripcion = ($xinfobloque["descripcion"]);
             $vtipodato = $xinfobloque["vdom_tipo_dato"];
             $estado = $xinfobloque["estado"];
             if ($estado == "2")
                 $estado = "off";
             else
                 $estado = "on";
             $idrespuesta = $id;
 }
 
 
if ((isset($_POST['enviar'])) && ($_POST['enviar'] == "Enviar"))
{
    
    include_once  "clases/Json.class.php";
    /* capturo datos del post e inicializar variables */  
    if (isset($_POST["descripcion"]))
       $descripcion = ($_POST["descripcion"]);
    if (isset($_POST["tipodato"]))
        $tipodato = $_POST["tipodato"];
     $seltipoest = "18";
     if (isset($_POST['estadobloque']))
         $estadobloque = $_POST['estadobloque'];
     if ($estadobloque == "on")
             $estadobloque = "1";
       else
             $estadobloque = "2";
             
    /* llamo clase para insertar datos  */
    $Json     = new Json;
    $Json->iniciarVariables();   
   
    $idrespuesta = $_POST["id_respuesta"];
    
    if ($idrespuesta > 0)
    {
         if (isset($_POST["descripcion"]))                     
             $cadena = "descripcion = '$descripcion' , estado = '$estadobloque'";
        elseif (isset($_POST["estadobloque"]))    
            $cadena = "estado = '$estadobloque'";
        else
        {
            $estadobloque = "1";
            $cadena = "estado = '$estadobloque'";
        }
        $filtro = "identificador = '$idrespuesta'";
        $xactualizabloquep = $Json->actualizarespuesta($filtro,$cadena);
        if((!isset($xactualizabloquep)) or ($xactualizabloquep == FALSE)) {
            $correcto = "false";
            $disp .= "Se ha presentado un error en la actualizacion de la respuesta... ".$xactualizabloquep . "<br>";
        }
        else
        {
            $correcto = "true";
            $disp .= "Se ha actualizado correctamente la respuesta. <br>";
        }
       
        
        $filtro = "id_respuesta = '$idrespuesta'";
        $Json->borrarvalores($filtro);
        $xidresp = $idrespuesta;
    }
    else 
    {
    $tabla = "enc_respuestas";
    $identificador = "identificador";
    $xsequencia = $Json->buscarsecuenciaglobal($tabla, $identificador);
        $ultimocodigo = $Json->obtener_fila($xsequencia);
        if (!isset($ultimocodigo["maximo"]))
            $maxid=0;
        else
             $maxid = $ultimocodigo["maximo"];
    $xidresp = $maxid + 1;
    $respval[0] = $xidresp;
    $respval[2] = $tipodato;
    $respval[3] = $seltipoest;
    $respval[4] = $estadobloque;
    $respval[1] = ($descripcion);
        
        
         $xinsertrespuesta = $Json->insertarespuesta($respval);
        if((!isset($xinsertrespuesta)) or ($xinsertrespuesta == FALSE)) {
             $correcto = "false";
             $disp .= "Se ha presentado un error en la creacion de la respuesta... ".$xinsertrespuesta;
        }
        else
        {
            $correcto = "true";
            $disp .= "Se ha creado la respuesta correctamente";
        }
    }

        if (isset($_POST["pro_identificador"]))
           $identificadorvalores = $_POST["pro_identificador"];
        else
            $identificadorvalores = "0";
        if (isset($_POST["pro_nomvalor"]))
           $nombreval = $_POST["pro_nomvalor"];
        else 
            $nombreval = "No Asignado";
        if (isset($_POST["estadoval"]))
            $estadoval = $_POST["estadoval"];
        else 
            $estadoval = "on";
         
        for ($i=0;$i < count($identificadorvalores); $i++)
        {
            $tabla = "enc_lista_valores";
            $identificador = "identificador";
            $xsequencia = $Json->buscarsecuenciaglobal($tabla, $identificador);
            $ultimocodigo = $Json->obtener_fila($xsequencia);
            if (!isset($ultimocodigo["maximo"]))
                $maxid=0;
                else
                    $maxid = $ultimocodigo["maximo"];
            $idvalormax = $maxid + 1;                    
            $xtipoest = "16";
            $xunidadmedida = "0";
            $xvalornumerico = "0";
            $idrespuesta = $xidresp;
            if ($estadoval[$i] == "on")
                $estadoval[$i] = 1;
            else
                $estadoval[$i] = 0;
                    
            $xvaloralfa = $nombreval[$i];
            $rvalor[0] = $idvalormax;
            $rvalor[1] = $xvalornumerico;
            $rvalor[2] = $xvaloralfa;
            $rvalor[3] = $xunidadmedida;
            $rvalor[4] = $idrespuesta;
            $rvalor[5] = $xtipoest;
            $rvalor[6] = $estadoval[$i];
            
            $xinsertlist = $Json->insertalistavalores($rvalor);
            if((!isset($xinsertlist)) or ($xinsertlist == FALSE)) {
                $correcto = "false";
            }
            else
                $correcto = "true";
            
        }
        if ($correcto == "false")
            $disp .= " Se ha presento error en la creacion de la lista de valores... ";
        else
            $disp .= " Lista de valores creados correctamente. "; 
     
 }
    
echo "<body>"; 
                 echo '  <div class="titulo_p"><i class="fa-solid fa-check"></i>&nbsp;<div>Registro único de Respuestas</div></div>
                        <div class="link_int">
                         <div class="titulo2"><i class="fa-solid fa-user"></i><a href=""> Nueva Respuesta</a></div>
                        <div class="titulo3"><a href="listarrespuestasrh.php">Listar Respuestas</a></div></div>
                        </div>
                        <div class="contenedor_titulos ">
                        <div class="campos titulo">Registro de Respuesta</div>
                        </div>';
/* Inicio el Formulario */
                 
    echo ' <div class="contenedor"><form class="registro" action="crearespuestas.php" method="post"> ';  
                 /* Llamo a la clase */
                $Json     = new Json;
                $Json->iniciarVariables();
                 
                   /* ingreso campos del formulario */
                echo '<div class="nueva_pre">';
                echo '<div><legend>Descripci&oacute;n: </legend><input name="descripcion" type="text" value="'.$descripcion.'" required > </div>';
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
                $filtro = "cvd.id_dominio = '23'";
                echo '<br><div><legend>Tipo de Datos</legend>
                     <div class="r_iconos">';
               $xcomptipoest = $Json->seltipodato($filtro);
                $i=0;
                while ($xrowtipoest = $Json->obtener_fila($xcomptipoest)) {
                    $nombretipoest = $xrowtipoest["id_alfanumerico"];
                    $css = $xrowtipoest["descripcion"];
                    $identificador = $xrowtipoest["identificador"];
                    
                    echo '<span>';
                    if ($vtipodato == $identificador)
                    {
                        echo '<input type="radio"  id="tipo-'.$identificador.'" name="tipodato" value="'.$identificador.'" checked >';
                    }
                    else
                       echo '<input type="radio"  id="tipo-'.$identificador.'" name="tipodato" value="'.$identificador.'">';
                    echo '<label for="tipo-'.$identificador.'">';
                        echo $css;
                        echo " ". $nombretipoest;
                   
                    echo '  </label> </span>';
                    $i++;
                }
                echo ' </div></div> ';
                $filtro = "id_respuesta = '$id'";
                $result = $Json->buscaenclistavalores($filtro);
                $xrowvalores = array();
                $ir=1;
                while ($xrowvalores = $Json->obtener_fila($result)) {
                    $valores[$ir] = utf8_encode($xrowvalores["valor_alfa_numerico"]);
                    $id_valor[$ir] = $xrowvalores["identificador"];
                    $ir++;
                }
                echo '<br>
    			<div class="mt-5">
                <div class="row">
                <div class="col-12 col-md-12">
                <!-- Contenido -->
                <h3 class="titulo">Valores del Tipo de Dato </h3>
                
                <div id="outer">
                <div id="header">
                <div class="float-left">N&uacute;mero.</div>
                <div class="float-left col-heading"> Identificador</div>
                <div class="float-left col-heading"> Nombre</div>
                <div class="float-left col-heading"> Estado </div>
                </div>
    <div id="listvalores">';
                require_once("InputDinamicovalores.php");
                echo '        </div>
            <div class="btn-action float-clear">
                <input class="btn btn-success" type="button" name="agregar_registros" value="Agregar" onClick="AgregarMas();" />
                <input class="btn btn-danger" type="button" name="borrar_registros" value="Borrar Campos" onClick="BorrarRegistro();" />
             </div>
			<div style="position: relative;">';
                echo '<input type="hidden" name="id_respuesta" value="'.$id.'" />';
                
			echo '<input class="btn btn-primary" type="submit" name="enviar" value="Enviar" /></div>
    </div> ';
                
            echo "</div></div>";
            echo '<div id="reptlist"> </div>';
            
             echo "<br><!-- Respuestas -->
                    </form>
                    
                    <div class=\"registro-b\">";
/* Publico mensajes del resultado de la insercion de respuestas */
              
       if ($correcto == "true")
           echo ' <div class="msj_verde"><span>'.$disp.'</span></div>';  
       elseif ($correcto == "false")
           echo ' <div class="msj_rojo"><span>'.$disp.'</span></div>';
       echo '</div></div></div>';
?>
<div class="cont_fin"></div>
<br>
<br>
<br>
<br>
<?php include 'footer.php';?>
<script src="js/bootstrap.min.js"></script> 

</body>
</html>