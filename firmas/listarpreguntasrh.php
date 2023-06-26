<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas</title>
    <link rel="stylesheet" href="css/regiones.css">
    <link rel="stylesheet" href="css/totproyectos.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
$(document).ready(function() {
    $('#search').on('keyup', function() {
        var search = $(this).val();	
        var dataString = 'search='+search;
        var parametros = {
      "search": search,
     }
	$.ajax({
            type: "POST",
            url: "funciones/obtienesearchbloquepregunta.php",
            data: parametros,
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
        <div class="titulo_p"><div><i class="fa-solid fa-question"></i> Preguntas </div></div>
        
<?php 
include_once  "clases/Json.class.php";
if (isset($_POST["identificau"]))
{
  
        $identificador = $_POST["identificau"];
}
    elseif (isset($_POST["idbloque"]))
    {
        $identificador = $_POST["idbloque"];
     }
    else
        $identificador = "1";
    $filtro = "1";
if(isset($_POST["identificau"]) or (isset($_POST["idbloque"])))
{
    /* entrada al metodo post para mostrar informacion de usuario y actualizar */
    
    if (isset($_POST["identificau"]))
         $identificador = $_POST["identificau"];
    elseif (isset($_POST["idbloque"]))
    {
             $identificador = $_POST["idbloque"];
    }
    else
             $identificador = "1";
             
    $Json     = new Json;
    $Json->iniciarVariables();
    $filtro = "identificador = '".$identificador."'";
    $result = $Json->buscarbloquepregunta($filtro);
    $xrowb = $Json->obtener_fila($result);
    $nombre = $xrowb["descripcion"];
    $estado = $xrowb["estado"];
    $filtro = "tipo_estado = '15' and identificador = '$estado' ";
    $resestado = $Json->buscaestado($filtro);
    $xrowestado = $Json->obtener_fila($resestado);
    $nombreestado = $xrowestado["nombre"];
    
    //aqui cambio el id de la sugunda pagina
    echo '<div class="link_int"><div class="titulo2"><i class="fa-solid fa-user"></i> <a href="">Volver a Consultar Bloque de Preguntas</a></div>
<div class="titulo3"><a href="creapreguntabloque.php?id='.$identificador.'">Administrar Preguntas</a></div></div>';
    
    echo '<div class="contenedor_titulos">
    <div class=" titulo_list_u">ID</div>
    <div class=" titulo_list_u">Nombre</div>
    <div class=" titulo_list_u">Tipo Estado</div>
    <div class=" titulo_list_u">Estado</div>
    </div>';
    echo " <div class=\"contenedor\">
          <div class=\"campos_list_u\">". $identificador ."</div>
          <div class=\"campos_list_u\"> ". $nombre ."</div>
          <div class=\"campos_list_u\"> Bloque de Pregunta </div>
       <div class=\"campos_list_u\"> ". $nombreestado."</div>
        </div> ";
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
    $filtro = "p.id_bloque_preguntas = '$identificador'";
    $result = $Json->buscarpreguntas($filtro);
    $xrowp = array();
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
        $filtroestado = "tipo_estado = '17' and identificador = '$estado' ";
        $resestado = $Json->buscaestado($filtroestado);
        $xrowestado = $Json->obtener_fila($resestado);
        $nombreestado = $xrowestado["nombre"];
        
        
        
        echo " <div class=\"contenedor\">";
        echo "<div class=\"campos_list_u\">$identificadorpreg</div>";
        echo "<div class=\"campos_list_u\">$nombrepregunta</div>";
        echo "<div class=\"campos_list_u\">".$nompadre."</div>";
        echo "<div class=\"campos_list_u\">$nombreresp</div>";
        echo "<div class=\"campos_list_u\">$nomcierre</div>";
        echo "<div class=\"campos_list_u\">$nomriesgo</div>";
        echo "<div class=\"campos_list_u\">$fecha_efectiva </div>";
        echo "<div class=\"campos_list_u\">$nombreestado </div> ";
        echo "<div class=\"campos_list_u\"><input type=\"submit\"  class=\"btn_sel\" name=\"adicionariesgo\" 
              id=\"adicionariesgo\" value=\"Riesgo\" onclick=\"prcadicionarriesgo($identificadorpreg, $identificador)\" ></div>";
          echo "</div>";  
       
    }
}
else
{
echo '<form id="form" action="listarpreguntasrh.php" method="POST">';
echo '<div class="link_int"><div class="titulo2"><i class="fa-solid fa-user"></i> <a href="">Volver a Consultar Bloque de Preguntas</a></div>
<div class="titulo3"><a href="creapreguntabloque.php">Administrar Preguntas </a></div></div>';
echo '<div class="buscar">';
echo '<div class="contenedor-1">
        <span class="icon"><i class="fa fa-search"></i></span>
        <input type="search" id="search" placeholder="Buscar Bloque pregunta..." autocomplete="off" />
    </div>
    
 <div id="sugerencia"></div>
    </div>';

echo '<div class="contenedor_titulos">
<div class=" titulo_list_u">ID</div>
<div class=" titulo_list_u">Descripcion</div>
<div class=" titulo_list_u">Tipo Estado</div>
<div class=" titulo_list_u">Estado</div>
</div>';
      $Json     = new Json;
       $Json->iniciarVariables();
       $filtro = "1";
       $result = $Json->buscarbloquepregunta($filtro);
$xrowuser = array();
$xi=0;
while ($xrowuser = $Json->obtener_fila($result)) {
    $identificador = $xrowuser["identificador"];
    $nombre = utf8_encode($xrowuser["descripcion"]);
    $tipoestado = $xrowuser["tipo_estado"];
    $nomtipoestado = "BLOQUE PREGUNTA";    
    $estado = $xrowuser["estado"];
    $filtro = "tipo_estado = '15' and identificador = '$estado' ";
    $resestado = $Json->buscaestado($filtro);
    $xrowestado = $Json->obtener_fila($resestado);
    $nombreestado = $xrowestado["nombre"];
    
    echo " <div class=\"contenedor\">";
    echo "<div class=\"campos_list_u\"><input type=\"submit\"  class=\"btn_sel\" name=\"identificau\" id=\"identificau\" value=\"$identificador\" ></div>";
            echo " <div class=\"campos_reg\">$nombre </div>
                   <div class=\"campos_reg\">$nomtipoestado </div>
                   <div class=\"campos_reg\">$nombreestado </div>                   
                   
";
          echo "</div> ";  
}
echo '  <input type="hidden" id="identifu" name="identifu" value="d" >';
echo '  <input type="text" id="idbloque" name="idbloque" value="'.$identificador.'" >';
echo '  <input type="hidden" id="idnombre" name="nombre" value='.$nombre.' >';
echo '  <input type="hidden" id="idestado" name="estado" value='.$estado.' >';


echo '  </form><div class="cont_fin"></div> ';
}
include 'footer.php'; ?>
<script>
    function vermenu(){
        document.getElementById('m_ad').classList.toggle('ver');
    }
</script>
</body>
</html>

