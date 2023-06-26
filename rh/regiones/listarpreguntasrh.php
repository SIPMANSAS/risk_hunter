<?php include 'sec_login.php'; ?>
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
$(document).ready(function() {
    $('#searchB').on('keyup', function() {
        var search = $(this).val();	
        var dataString = 'search='+search;
        var parametros = {
      "search": search,
     }
	$.ajax({
            type: "POST",
            url: "funciones/obtienesearchbloquepreguntaB.php",
            data: parametros,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#sugerenciaB').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.sugerencia-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#searchB').val($('#'+id).attr('data'));
                        
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
$(document).ready(function() {
    $('#searchC').on('keyup', function() {
        var search = $(this).val();	
        var dataString = 'search='+search;
        var parametros = {
      "search": search,
     }
	$.ajax({
            type: "POST",
            url: "funciones/obtienesearchbloquepreguntaB.php",
            data: parametros,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#sugerencia').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.sugerencia-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#searchC').val($('#'+id).attr('data'));
                        
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
  
  
<script>
/*
    function abrir(URL){
    window.open(URL,"",'width=600,height=600,left=600, top=600,toolbar=0,scrollbars=0,statusbar=0,menubar =0,resizable=0');
    }*/
</script>  
       
    
</head>
<body>  
    <?php
        include 'header-rh.php';
    ?>
        <div class="titulo_p"><div><i class="fa-solid fa-question"></i> Preguntas </div></div>
        
<?php 
include_once  "clases/Json.class.php";
///////////////////Modificacion sebastian 02/12/22
if (isset($_POST["identificau"]))
{
  
        $identificador = $_POST["identificau"];
}   
///////////////////Modificacion sebastian 02/12/22
    elseif (isset($_POST["idbloque"])or (isset($_POST["idbloque"])))
    {
        $identificador = $_POST["idbloque"];
     }
    else
        $identificador = "1";
    $filtro = "1";
if(isset($_POST["identificau"]) or (isset($_POST["idbloque"])))
{
    /* entrada al metodo post para mostrar informacion de usuario y actualizar */
    
    ///////////////////Modificacion sebastian 02/12/22
    if (isset($_POST["identificau"]))
         $identificador = $_POST["identificau"];
    ///////////////////Modificacion sebastian 02/12/22
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
    $nombre = ($xrowb["descripcion"]);
    $estado = $xrowb["estado"];
    $filtro = "tipo_estado = '15' and identificador = '$estado' ";
    $resestado = $Json->buscaestado($filtro);
    $xrowestado = $Json->obtener_fila($resestado);
    $nombreestado = $xrowestado["nombre"];
    if (!isset($nombreestado))
        $nombreestado = "ACTIVO";
    
    //aqui cambio el id de la sugunda pagina 
    //por gabriel califa 17112022 edite css de pintar campos/ 21112022 agrgo buscador depreguntas hija
    //<div class="titulo3"><a href="creapreguntabloque.php?id='.$identificador.'"></a></div>
    
    echo '<div class="link_int"><div class="titulo2"><i class="fa-solid fa-user"></i> <a href="">Volver a Consultar Bloque de Preguntas</a></div>
        </div>';
        
    echo '<div class="contenedor_titulos">
    
    <div class=" titulo">Identificador</div>
    <div class=" titulo">Nombre</div>
    <div class=" titulo">Estado</div>
    </div>';
    echo " <div class=\"contenedor\">
          <div class=\"campos_pre\">". $identificador ."</div>
          <div class=\"campos_pre\"> ". utf8_encode($nombre) ."</div>
         <div class=\"campos_pre\"> ". $nombreestado."</div>
        </div> <div class=\"cont_fin\"></div>";
        echo '<br>';
        echo '<div>';
        ?>
        <div class="titulo2">
            <i class="fa-solid fa-user"></i>Preguntas del Bloque
        </div>
        <?php
    
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="searchC" placeholder="Buscar Pregunta..." autocomplete="off" />
        </div>
        <div id="sugerencia"></div>
        </div>';
        
        ?>
                </div>
            </div>
        
        <?php
        
        echo "
        <div class=\"contenedor_titulos\">
        <div class=\"campos_pre titulo\">Identificador</div>
        <div class=\"campos_pre titulo\">Pregunta Padre</div>
        <div class=\"campos_pre titulo\">Nombre Pregunta</div>        
        <div class=\"campos_pre titulo\">Respuesta</div>
        <div class=\"campos_pre titulo\">Respuesta  Cierre</div>
        <div class=\"campos_pre titulo\">Respuesta  Activa Riesgo</div>
        <div class=\"campos_pre titulo\">Estado</div>
        <div class=\"campos_pre titulo\">Gestionar Riesgo</div>
        <div class=\"campos_pre titulo\">Acciones</div>
        
        </div>";
        ?>
    <?php
    
    
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
        $codigo = $xrowpadre['codigo'];
        
        
         
        echo " <div class=\"contenedor\">";
        //inicio modificacion gabriel17112022
        ?>
        <div class="campos_pre">
                              <form action="listarpreguntash.php" method="POST" target="blank">
                <input class="ver" value="<?php echo utf8_encode($nompadre) ?>" name="nombrepadre">
                <input class="ver" value="<?php echo $padre ?>" name="idpregunta">
                <button type="submit" class="btn_sel"  name="verrespuestas"><?php echo $identificadorpreg?></button>
            </form>
        </div>
        <?php
        echo "<div style=text-align:left class=\"campos_pre\">".utf8_encode($nompadre)."</div>";
        echo "<div style=text-align:left class=\"campos_pre\">".(($nombrepregunta))."</div>";
        ?>
      <div class="campos_pre">
                 <form action="vervalores.php" id="form" method="POST" target="_blank">
                    <input class="ver" value="<?php echo ($nombrepregunta) ?>" name="nombrepadre">
                    <input class="ver" value="<?php echo $identificadorpreg ?>" name="idpregunta">
                    <input class="ver" value="<?php echo $nombreestado ?>" name="estadoN">
                     <input class="ver" value="<?php echo $idrespuesta ?>" name="idrespuesta">
                    <button type="submit" class="btn_sel"  name="verrespuestas">Valores</button>
                 </form>
        </div>
        
        <?php
        //echo "<div class=\"campos_pre\">".utf8_encode($nombreresp)."</div>";        
        //echo "<div class=\"campos_pre\">$nombrepregunta</div>";
        //echo "<div class=\"campos_pre\">".$nompadre."</div>";
        //echo "<div class=\"campos_pre\">$nombreresp</div>";
        //fin modificacion gabriel 17112022
        

        
        
        echo "<div class=\"campos_pre\">$nomcierre</div>";
        echo "<div class=\"campos_pre\">$nomriesgo</div>";
        echo "<div class=\"campos_pre\">$nombreestado </div> ";
         
        echo "<div class=\"campos_pre\"><input type=\"submit\"  class=\"btn_sel\" name=\"adicionariesgo\" 
              id=\"adicionariesgo\" value=\"Riesgo\" onclick=\"prcadicionarriesgo($identificadorpreg, $identificador)\" ></div>";
        ?>
        
        <!----------------------------------------------------- INICIO MODIFICACION SEBASTIAN 1/12/22---------------------------------------------------------->
        <div class=campos_pre>
             <form action="listarpreguntash.php" method="POST" target="blank">
                <input class="ver" value="<?php echo utf8_encode($nompadre) ?>" name="nombrepadre">
                <input class="ver" value="<?php echo $padre ?>" name="idpregunta">
                <button type="submit" class="btn_sel"  name="verrespuestas">Detalle</button>
            </form>
        <br>
        <br>
             <form action="creapreguntabloque.php" method="POST" target="_blank">
                <input class="ver" value="<?php echo utf8_encode($nombrepregunta) ?>" name="nombrepadre">
                <input class="ver" value="<?php echo $identificadorpreg ?>" name="id">
                 <input class="ver" value="<?php echo $identificador ?>" name="idbloque">
                <button type="submit" class="btn_sel"  name="verrespuestas">Crear</button>
            </form>
        </div>
        <!----------------------------------------------------- FIN MODIFICACION SEBASTIAN 1/12/22---------------------------------------------------------->
        <?php
          echo "</div>";  
          
    }
    
}
else
{
echo '<form id="form" action="listarpreguntasrh.php" method="POST">';
?>

<input type="hidden" value="<?php echo $nombrepregunta ?>" name="nombrepadre">
<input type="hidden" value="<?php echo $identificadorpreg ?>" name="idpregunta">
<?php
echo '<div class="link_int"><div class=""><i class=""></i> </div>';//Bloque de Preguntas
echo '<div class="titulo3"><a href="creapreguntabloque.php">Administrar Preguntas </a></div></div>';
        echo '<div class="buscar">';
        echo '<div class="contenedor-1">
            <span class="icon"><i class="fa fa-search"></i></span>
            <input type="search" id="search" placeholder="Buscar Bloque de preguntas..." autocomplete="off" />
        </div>
     <div id="sugerencia"></div>
        </div>';

echo '<div class="contenedor_titulos">
<div class=" titulo">Identificador</div>
<div class=" titulo">Bloque de Preguntas</div>
<div class=" titulo">Estado</div>
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
    if (!isset($nombreestado))
        $nombreestado = "ACTIVO";
    
    echo " <div class=\"contenedor\">";
    echo "<div class=\"campos_pre\"><input type=\"submit\"  class=\"btn_sel\" name=\"identificau\" id=\"identificau\" value=\"$identificador\" ></div>";
        echo "<div class=\"campos_reg\">$nombre </div>
                    <div class=\"campos_reg\">$nombreestado </div>";
        echo "</div> ";  
}
echo '  <input type="hidden" id="identifu" name="identifu" value="d" >';
echo '  <input type="hidden" id="idbloque" name="idbloque" value="'.$identificador.'" >';
echo '  <input type="hidden" id="idnombre" name="nombre" value='.$nombre.' >';
echo '  <input type="hidden" id="idestado" name="estado" value='.$estado.' >';
echo '  </form><div class="cont_fin_b"></div> ';
}

echo"<div class=\"cont_fin\"></div>";
include 'footer.php'; ?>

</body>
</html>

