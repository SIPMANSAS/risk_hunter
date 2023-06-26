<?php  include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuestas</title>
    <link rel="stylesheet" href="css/regiones.css">
    <link rel="stylesheet" href="css/totproyectos.css">
      <link rel="shortcut icon" href="favicon.ico">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
$(document).ready(function() {
    $('#search').on('keyup', function() {
        var key = $(this).val();
        var dataString = 'key='+key;
      
        var parametros = {
      "search": search,
     }
	$.ajax({
            type: "POST",
            url: "funciones/obtienesearchpreguntarespuesta.php",
            data: dataString,
             success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#sugerencia').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.sugerencia-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#search').val($('#'+id).attr('data'));
                        
                        //Hacemos desaparecer el resto de sugerencias
                        $('#sugerencia').fadeOut(1000);
                        $('#identificau').val(id);
                        $('#idbloque').val(id);
                   	document.getElementById('form').submit();
	                  return false;
                });
            }
        });
    });
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
        include 'header-rh.php';
    ?>
        <div class="titulo_p"><div><i class="fa-solid fa-question"></i> Respuestas </div></div>
        
<?php 
include_once  "clases/Json.class.php";
$filtro = "1";
if(isset($_POST["identificau"]) or (isset($_POST["idbloque"])))
{
    if (isset($_POST["identificau"]))
         $identificador = $_POST["identificau"];
    elseif (isset($_POST["idbloque"]))
             $identificador = $_POST["idbloque"];
    else
             $identificador = "1";
    $Json     = new Json;
    $Json->iniciarVariables();
    $filtro = "identificador = '".$identificador."'";
    $result = $Json->buscarespuestas($filtro);
    $xrowb = $Json->obtener_fila($result);
    $nombre = $xrowb["descripcion"];
    $estado = $xrowb["estado"];
    $filtro = "tipo_estado = '18' and identificador = '$estado' ";
    $resestado = $Json->buscaestado($filtro);
    $xrowestado = $Json->obtener_fila($resestado);
    $nombreestado = $xrowestado["nombre"];
    $filtro = "identificador = '16' ";
    $resestado = $Json->seltipoestados($filtro);
    $xrowtipoestado = $Json->obtener_fila($resestado);
    $nomtipoestado = $xrowtipoestado["nombre"];
     
    //aqui cambio el id de la sugunda pagina
    echo '<div class="link_int"><div class="titulo2"><i class="fa-solid fa-user"></i> <a href="">Volver a Consultar Respuestas</a></div>
<div class="titulo3"><a href="crearespuestas.php?id='.$identificador.'">Administrar Respuestas</a></div></div>';
    
    echo '<div class="contenedor_titulos">
    <div class=" titulo">ID</div>
    <div class=" titulo">Descripcion</div>
    <div class=" titulo">Tipo Estado</div>
    <div class=" titulo">Estado</div>
    </div>';
    echo " <div class=\"contenedor\">
          <div class=\"campos_f\">". utf8_encode($identificador) ."</div>
          <div class=\"campos_f\"> ". ($nombre) ."</div>
          <div class=\"campos_f\"> ". utf8_encode($nomtipoestado) ."</div>
       <div class=\"campos_f\"> ". utf8_encode($nombreestado)."</div>
        </div> ";
    echo '
        <div class="titulo2"><i class="fa-solid fa-user"></i> Valores de Respuestas </div>
        <div class="contenedor_titulos">
        <div class="campos titulo">Valor</div>
       
        <div class="campos titulo">Estado</div>
       
  
        </div>';   
    $filtro = "id_respuesta = '".$identificador."'";
    $result = $Json->buscaenclistavalores($filtro);    
    $xrowp = array();
    while ($xrowp = $Json->obtener_fila($result)) {
        $estado = $xrowp["estado"];
        $nomvalor = $xrowp["valor_alfa_numerico"];
        $filtroestado = "tipo_estado = '16' and identificador = '$estado' ";
        $resestado = $Json->buscaestado($filtroestado);
        $xrowestado = $Json->obtener_fila($resestado);
        $nombreestado = $xrowestado["nombre"];
         
        echo " <div class=\"contenedor\">";
        echo utf8_encode("<div class=\"campos_f\">$nomvalor</div>");
        //echo "<div class=\"campos_f\"></div>";
        echo "<div class=\"campos_f\"   >$nombreestado </div> ";
        echo "</div>";  
       
    }
}
else
{
echo '<form id="form" action="listarrespuestasrh.php" method="POST">';
echo '<div class="link_int"><div class="titulo2"><i class="fa-solid fa-user"></i> <a href="">Respuestas</a></div>
<div class="titulo3"><a href="crearespuestas.php">Administrar Respuestas </a></div></div>';
echo '<div class="buscar">';
echo '<div class="contenedor-1">
        <span class="icon"><i class="fa fa-search"></i></span>
        <input type="search" id="search" placeholder="Buscar respuestas..." autocomplete="off" />
    </div>
    
 <div id="sugerencia"></div>
    </div>';

echo '<div class="contenedor_titulos">
<div class="titulo">Identificador</div>
<div class="titulo">Descripci&oacute;n</div>
<div class="titulo">Tipo Dato</div>
<div class="titulo">Estado</div>

</div>';
      $Json     = new Json;
       $Json->iniciarVariables();
       $filtro = "1";
       $result = $Json->buscarespuestas($filtro);
$xrowuser = array();
$xi=0;
while ($xrowuser = $Json->obtener_fila($result)) {
    $identificador = $xrowuser["identificador"];
    $nombre = ($xrowuser["descripcion"]);
    $tipodato = $xrowuser["vdom_tipo_dato"];
    $filtro = "id_dominio = '23' and identificador = '$tipodato'";
    $resdato = $Json->buscacgvaloresdominio($filtro);
    $xrowtipodato = $Json->obtener_fila($resdato);
    $nomtipodato = $xrowtipodato["nombre"];
    $desctipodato = $xrowtipodato["descripcion"];
    $tipoestado = $xrowuser["tipo_estado"];
    $estador = $xrowuser["estado"];
    $filtro = "identificador = '18' ";
    $resestado = $Json->seltipoestados($filtro);
    $xrowtipoestado = $Json->obtener_fila($resestado);
    $nomtipoestado = $xrowtipoestado["nombre"];    
    $filtro = "tipo_estado = '18' and identificador = '$estador' ";
    $resestado = $Json->buscaestado($filtro);
    $xrowestado = $Json->obtener_fila($resestado);
    $nombreestado = $xrowestado["nombre"];
    if (!isset($nombreestado))
        $nombreestado = "Activo";
    
    echo " <div class=\"contenedor\">";
    echo "<div class=\"campos_reg\"><input type=\"submit\"  class=\"btn_sel\" name=\"identificau\" id=\"identificau\" value=\"$identificador\" ></div>";
            echo " <div class=\"campos_reg\">$nombre </div>
                   <div class=\"campos_reg\"><div>$desctipodato  $nomtipodato</div> </div>
                   <div class=\"campos_reg\">$nombreestado </div>                   
                   
";
          echo "</div> ";  
}
echo '  <input type="hidden" id="idbloque" name="idbloque" value="'.$identificador.'" >';
echo '  <input type="hidden" id="idnombre" name="nombre" value='.$nombre.' >';


echo '  </form><div class="cont_fin"></div> ';
}
include 'footer.php'; 
?>

</body>
</html>

