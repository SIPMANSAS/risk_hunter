<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Preguntas</title>
    
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>      
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/regiones.css">
    <link rel="stylesheet" href="css/preguntas.css">
    <link href="css/styledynam.css" rel="stylesheet">

 <script>
function AgregarMas() {
    var id = $(".lista-producto").length + 1;
    var idant = id - 1;
    var nombrepp = 'esp-' + idant;
    var nombre = 'esp-' + id;
    var nombreant =    $("#totnombre").val();
    var nombre2 = "";
      $("<div>").load("InputDinamicoPreguntas.php", function() {
            var html = $(this).html();
            html = html.replace('identificador-1', 'identificador-' + id);
            html = html.replace('nombre-1', 'nombre-' + id);
            html = html.replace('tipoestado-1', 'tipoestado-' + id);
            html = html.replace('estado-1', 'estado-' + id);
            html = html.replace('espadre-1', 'espadre-' + id); 
            html = html.replace('esp-1', 'esp-' + id);
            html = html.replace('esp2-1', 'esp2-' + id);
            html = html.replace('nombre2-1', 'nombre2-' + id);
             var radios = document.querySelectorAll('input[type=radio][name="esp-1"]');
    radios.forEach(radio => radio.addEventListener('change', () => 
    		    $("#espadre-" + idant).val(radio.value)  
    		));
    		  nombre2 =  nombre2.concat(nombreant);
    		  nombre2 =  nombre2.concat($("#nombre-" + idant).val());
    		  nombre2 =  nombre2.concat(",");
    		$("#identificador-" + idant).val(idant);
 		    $("#nombre2-" + idant).val(nombre2);
 		    $("#totnombre").val(nombre2);
       	    $("#totregistro").val(id);
       	    $("#listpreguntas").append(html);
	});
}
function BorrarRegistro() {
	$('div.lista-producto').each(function(index, item){
		jQuery(':checkbox', this).each(function () {
            if ($(this).is(':checked')) {
				$(item).remove();
            }
        });
	});
}
$.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: $(this).serialize(),
    success: function(data) {
      $('#result').text(data.disp);
      }
});
</script>

</head>
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
if ((isset($_POST['guardar'])) && ($_POST['guardar'] == "Guardar Ahora"))
{
    include_once  "clases/Json.class.php";
    /* capturo datos del post e inicializar variables */   
    $descripcion = $_POST['descripcion'];
    $seltipoest = $_POST['seltipoest'];
    $estadobloque = $_POST['estadobloque'];
  
    /* llamo clase para insertar datos del bloque */
    $Json     = new Json;
    $Json->iniciarVariables();   
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
             $disp .= "Se ha presentado un error en la creacion del bloque de preguntas... ".$xinsertbloquep;
        }
        else
        {
            $correcto = "true";
            $disp .= "Se ha creado el Bloque de Preguntas correctamente.";
        }

        /* luego procedo a insertar las preguntas */
        $tabla = "enc_preguntas";
        $identificador = "identificador";
        $xnombre = $_POST["totnombre"];
        $contador = $_POST["totregistro"];
        $xnombresp = explode(",",$xnombre);
        $pro_espadre = $_POST['pro_espadre'];
        $pro_espadre[0] = "SI";
        $pro_espadre[2] = "SI";

        for ($i=0; $i < $contador-1; $i++)
        {
           /* Recorro el numero de preguntas padres creadas y las inserto */
            $xsequencia = $Json->buscarsecuenciaglobal($tabla, $identificador);
            $ultimocodigo = $Json->obtener_fila($xsequencia);
            if (!isset($ultimocodigo["maximo"]))
                $maxid=0;
            else
                $maxid = $ultimocodigo["maximo"];        
                $xidpregunta = $maxid + 1;
                $xpregunta[0] = $xidpregunta;
                $xpregunta[1] = $xnombresp[$i];
                $xpregunta[2] = "17";
                $xpregunta[3] = "1";
                $xpregunta[4] = date('Y-m-d H:i:s'); 
                $xpregunta[5] = "0";
                $xpregunta[6] = NULL;
                $xpregunta[7] = $xidbloquepregunta;
                $xpregunta[8] = "";
                $xinsertpregunta = $Json->insertapregunta($xpregunta);
            if((!isset($xinsertpregunta)) or ($xinsertpregunta == FALSE)) {
                $correcto = "false";
                $disp .= "Se ha presentado un error en la creacion de las preguntas... ".$xinsertpregunta;
            }
            else
            {
               $correcto = "true";
               $disp .= "Se ha creado la Pregunta correctamente.";                         
            }
            if (isset($pro_espadre[$i]) && $pro_espadre[$i] == "SI" )
            {     
                /* se procede a crear las preguntas hijas */
                echo ' <input type="button" name="asignarr" value="Asignar Respuestas y Riesgos"> ';
                echo ' <form name="bloque" id="form'.$i.'" class="registro" action="creapreguntas.php" method="post"> ';
                echo '
                <div class="mt-5">
                <div class="row">
                <div class="col-12 col-md-12">
                <!-- Contenido -->
                <h3>Preguntas Hijas de la Pregunta '. $xnombresp[$i] .'</h3> ';
                echo '
                <div id="outer">
                <div id="header">
                <div > Nro.</div>
                <div > Id</div>
                <div > Nombre</div>
                <div > Es Pregunta Padre?</div>
                <div > Padre</div>
                <div > Tipo Estado</div>
                <div > On/Off</div>
                </div>
                <div id="listpreguntas">';
                require_once("InputDinamicoPreguntas.php"); 
                 echo '   </div>
                    <div id="suggestions2"> </div>
                    <div class="btn-action float-clear">
                    <input class="btn btn-success" type="button" name="agregar_registros" value="Agregar Mas" onClick="AgregarMas();" />
                    <input class="btn btn-danger" type="button" name="borrar_registros" value="Borrar Campos" onClick="BorrarRegistro();" />
                    <span class="success"><?php if(isset($disp)) { echo $disp; }?></span>
                    </div>
                    <div style="position: relative;">
                    <input class="btn btn-primary" type="submit" name="guardarhija" value="Guardar Pregunta Hija" onClick="insertarhija();" />
                        </div></div></div></div></div></div>';
                 echo "</form>";
            }
        }
}
else 
{
    /* ingreso al formulario inicial */
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
                        <div class="titulo_p"><i class="fa-solid fa-user"> </i>&nbsp;<div>Registro único de Preguntas</div></div>
                        <div class="titulo2"><i class="fa-solid fa-user"></i><a href=""> Nuevo Bloque de Preguntas</a></div>
                        <div class="contenedor_titulos ">
                        <div class="campos titulo">Nuevas Preguntas</div>
                        </div>';
    echo ' <div class="contenedor"><form name="bloque" class="registro" action="" method="post"> ';  
                 /* Llamo a la clase */
                $Json     = new Json;
                $Json->iniciarVariables();   
                /* ingreso campos del formulario de bloque de preguntas */
                echo '<div class="nueva_pre">';
                echo '<div><legend>Descripcion: </legend><input name="descripcion" type="text" value="'.$descripcion.'"  > </div>';
                /* tipo de estados select */
                $xcomptipoest = $Json->seltipoestados();
                $xrowtipoest = array();
                $xi=0;
                echo '<div>
               <legend>Tipos de Estado</legend>';
                echo '<SELECT name= "seltipoest" size=2 id="iseltipoest" >';
                $checked = "15";
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
                echo '<div class="switch-button"><legend>Estado: </legend>
                    <input type="checkbox" name="estadobloque" id="switch-label" class="switch-button__checkbox" checked>
                    <label for="switch-label" class="switch-button__label"></label>
                </div>';
                echo '<input type="hidden" readonly id="totregistro" name="totregistro" />';
                echo '<input type="hidden" readonly id="totnombre" name="totnombre" />';
                echo '<input type="hidden" readonly id="totespadre" name="totespadre" />';
                echo "</div>";
                $resultado = "";
                $setid = "";
                $disp = "";
                $correcto = "";
?>
    <div class="mt-5">
        <div class="row">
            <div >
            <!-- Contenido -->
                <h3 class="titulo4">Preguntas que pertenecen al Bloque </h3>
                <div id="outer">
                <div id="header">
                <div >Nro.</div>
                <div > Id</div>
                <div > Nombre</div>
                <div > Es Pregunta Padre?</div>
                <div > Padre</div>
                <div > Tipo Estado</div>  
               <div> On / Off</div>
            </div>
            <div id="listpreguntas">
                <?php require_once("InputDinamicoPreguntas.php") ?>
            </div>
            <div class="btn-action float-clear">
                <input class="btn btn-success" type="button" name="agregar_registros" value="Agregar Mas" onClick="AgregarMas();" />
                <input class="btn btn-danger" type="button" name="borrar_registros" value="Borrar Campos" onClick="BorrarRegistro();" />
                <span class="success"><?php if(isset($disp)) { echo $disp; }?></span>
            </div>
            <div >
                <input class="btn btn-primary" type="submit" name="guardar" value="Guardar Ahora" />
            </div>
        </div>
    </div>
<?php
 echo '<input type="hidden" name="setid" value="'.$setid.'">
        </form>
                    </div>
                    <div class="registro registro-b">';
/* Publico mensajes del resultado de la insercion de usuarios */
       if ($correcto == "true")
           echo ' <div class="msj_verde"><span>'.$disp.'</span></div>';  
       elseif ($correcto == "false")
           echo ' <div class="msj_rojo"><span>'.$disp.'</span></div>';
       echo '</div>';
       echo "</div></div>";
}
?>
<script src="js/bootstrap.min.js"></script>
</body>
</html>