<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="ISO-8859-1">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>      
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <link rel="stylesheet" href="css/preguntas.css">
	<link href="css/styledynam.css" rel="stylesheet">
	<link href="css/bootstrap.min-2.css" rel="stylesheet">
	
    
   
   <script>
		
$(document).ready(function () {
  
const checkbox = document.getElementById('listad')

checkbox.addEventListener('change', (event) => {
  if (event.currentTarget.checked) {
    alert('Digite los valores de la lista');
    resp = "Digite los valores de la lista";
    $("#resplist").text(resp);
    $("#nombre-1").focus();
  } 
})
});	

$(document).ready(function () {
  
const checkbox = document.getElementById('listam')

checkbox.addEventListener('change', (event) => {
  if (event.currentTarget.checked) {
    alert('Digite los valores de la lista');
    resp = "Digite los valores de la lista";
    $("#resplist").text(resp);
    $("#nombre-1").focus();
  } 
})
});	

function AgregarMas() {
    var id = $(".lista-valores").length + 1;
    var idant = id - 1;
  	
         $("<div>").load("InputDinamicovalores.php", function() {
            var html = $(this).html();
            html = html.replace('identificador-1', 'identificador-' + id);
            html = html.replace('nombre-1', 'nombre-' + id);
            $("#identificador-" + idant).val(idant);
 	
            $("#listvalores").append(html);
	});
}

function BorrarRegistro() {
	$('div.lista-valores').each(function(index, item){
		jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
				$(item).remove();
            }
        });
	});
}



</script> 

</head>
<?php
include "clases/Json.class.php";
 $correcto="";
 $respuesta = "";
 $disp = "";
if ((isset($_POST['enviar'])) && ($_POST['enviar'] == "Enviar"))
{
    
    include_once  "clases/Json.class.php";
    /* capturo datos del post e inicializar variables */   
     
     $descripcion = utf8_encode($_POST["descripcion"]);
     $identificadorvalores = $_POST["pro_identificador"];
     $nombreval = $_POST["pro_nomvalor"];
     $tipodato = $_POST["tipodato"];
     $seltipoest = $_POST["seltipoest"];
     $estadobloque = $_POST["estadobloque"];
     $totregistrovalores = $_POST["totregistro"];
     if ($estadobloque == "on")
         $estadobloque = 1;
     else
         $estadobloque = 0;
             
    /* llamo clase para insertar datos  */
    $Json     = new Json;
    $Json->iniciarVariables();   
   
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
    $respval[1] = utf8_encode($descripcion);
        
        
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
  
        for ($i=0;$i < count($identificadorvalores)-1; $i++)
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
            $xest = "1";
            $xunidadmedida = "0";
            $xvalornumerico = "0";
            $idrespuesta = $xidresp;
            $xvaloralfa = $nombreval[$i];
            $rvalor[0] = $idvalormax;
            $rvalor[1] = $xvalornumerico;
            $rvalor[2] = $xvaloralfa;
            $rvalor[3] = $xunidadmedida;
            $rvalor[4] = $idrespuesta;
            $rvalor[5] = $xtipoest;
            $rvalor[6] = $xest;
            
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
?>
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
                 echo '   
                        <div class="titulo_p"><i class="fa-solid fa-check"></i>&nbsp;<div>Registro único de Respuestas</div></div>
                        <div class="titulo2"><i class="fa-solid fa-user"></i><a href=""> Nueva Respuesta</a></div>
                        <div class="contenedor_titulos ">
                        <div class="campos titulo">Nuevo Respuesta</div>
                        </div>';
    echo ' <div class="contenedor"><form class="registro-respuestas" action="crearespuestas.php" method="post"> ';  
                 /* Llamo a la clase */
                $Json     = new Json;
                $Json->iniciarVariables();
               /* ingreso campos del formulario */
                echo '<div class="nueva_pre">';
                echo '<div class="campos"><legend>Descripcion: </legend><input name="descripcion" type="text" value="'.$descripcion.'"  > </div>';            
                
                /* tipo de estados select */
                $xcomptipoest = $Json->seltipoestados();
                $xrowtipoest = array();
                $xi=0;
                echo '<div class="campos">
               <legend>Tipos de Estado</legend>';
                echo '<SELECT name= "seltipoest" size=2 id="iseltipoest" >';
                $checked = "18";
                while ($xrowtipoest = $Json->obtener_fila($xcomptipoest)) {
                    $nombrer[$xi] = utf8_encode($xrowtipoest['nombre']) ;
                    $identificadorr[$xi] = $xrowtipoest['identificador'];
                   if ($identificadorr[$xi] == $checked)
                        echo  '<option value="'.$identificadorr[$xi].'" selected="selected">'.$nombrer[$xi].'</option>';
                        else
                            echo  '<option value="'.$identificadorr[$xi].'">'.$nombrer[$xi].'</option>';
                            $xi++;
                }
                echo '</select></div>';
                echo '<div class="campos"><div class="switch-button"><legend>Estado: </legend>
                    <input type="checkbox" name="estadobloque" id="switch-label" class="switch-button__checkbox" checked>
                    <label for="switch-label" class="switch-button__label"></label>
                </div></div>';
                
                echo "</div>";
                echo ' <br><div><legend>Tipo de Datos</legend>
                     <div class="r_iconos">
                    <span>
                    <input type="checkbox"  id="fecha" name="tipodato" value="1">
                    <label for="fecha">
                         <i class="fa-solid fa-calendar-days"></i>
                        Fecha
                      </label> </span><span>
                    <input type="checkbox"  id="textoa" name="tipodato" value="2">
                    <label for="textoa">
                    <i class="fa-solid fa-arrows-spin"></i>
                        Texto Automatico
                    </label></span><span>
                   <input type="checkbox"  id="listad" name="tipodato" value="3">
                    <label for="listad">
                     <i class="fa-solid fa-rectangle-list"></i>
                    Lista Desplegable
                    </label></span><span>
                    <input type="checkbox"  id="listam" name="tipodato" value="4">
                    <label for="listam">
                    <i class="fa-solid fa-list-check"></i>
                    seleccion multiple
                    </label>
                    </span></div>
                </div>
                ';
                echo '<br>
    			<div class="mt-5">
                <div class="row">
                <div class="col-12 col-md-12">
                <!-- Contenido -->
                <h3>Valores del Tipo de Dato </h3>
                
                <div id="outer">
                <div id="header">
                <div class="float-left">&nbsp; Nro.</div>
                <div class="float-left col-heading2"> Id</div>
                <div class="float-left col-heading"> Nombre</div>
                </div>
    <div id="listvalores">';
                require_once("InputDinamicovalores.php");
                echo '        </div>
            <div class="btn-action float-clear">
                <input class="btn btn-success" type="button" name="agregar_registros" value="Agregar Mas" onClick="AgregarMas();" />
                <input class="btn btn-danger" type="button" name="borrar_registros" value="Borrar Campos" onClick="BorrarRegistro();" />
             </div>
			<div style="position: relative;">
			<input class="btn btn-primary" type="submit" name="enviar" value="Enviar" /></div>
    </div> ';
                
            echo "</div></div>";
            echo '<div id="reptlist"> </div>';
            
             echo "<br><!-- Respuestas -->
                    </form></div></div>
                    </div>
                    <div class=\"registro registro-b\">";
/* Publico mensajes del resultado de la insercion de respuestas */
              
       if ($correcto == "true")
           echo ' <div class="msj_verde"><span>'.$disp.'</span></div>';  
       elseif ($correcto == "false")
           echo ' <div class="msj_rojo"><span>'.$disp.'</span></div>';
       echo '</div>';
?>
<script src="js/bootstrap.min.js"></script> 

</body>
</html>