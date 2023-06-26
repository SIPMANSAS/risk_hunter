<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
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
            url: "funciones/obtienesearchusuario.php",
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
                        $('#identifu').val("d");
                        
                        
			document.getElementById('form').submit();
	                  return false;
                });
            }
        });
    });
}); 
</script>
    
    
    
</head>
<body>  
     <?php include '../header.php'; ?>
    <div class="titulo_p">
        <center>USUARIOS</center>
    </div>
    <div class="link_int">
    </div>
        
<?php 
include_once  "clases/Json.class.php";
if (isset($_POST["identificau"]))
        $identificador = $_POST["identificau"];
    elseif (isset($_POST["idusuario"]))
        $identificador = $_POST["idusuario"];
    else
        $identificador = "1";
    $filtro = "1";
if(isset($_POST["identificau"]) or (isset($_POST["idusuario"])))
{
    /* entrada al metodo post para mostrar informacion de usuario y actualizar */
    
    if (isset($_POST["identificau"]))
         $identificador = $_POST["identificau"];
    elseif (isset($_POST["idusuario"]))
        $identificador = $_POST["idusuario"];
    
    $Json     = new Json;
    $Json->iniciarVariables();
    $filtro = "identificador = '$identificador'";
    $result = $Json->buscarusuarios($filtro);
    $xinfouser = $Json->obtener_fila($result);
    //aqui cambio el id de la sugunda pagina
    echo '<div class="link_int"><div class="titulo2"><i class="fa-solid fa-user"></i> <a href="">Volver a Consultar Usuarios</a></div>
<div class="titulo3"><a href="crearusuariosrh.php?id='.$identificador.'">Administrar Usuario</a></div></div>';
    
    echo '<div class="contenedor_titulos">
    <div class=" titulo_list_u">ID</div>
    <div class=" titulo_list_u">Email</div>
    <div class=" titulo_list_u">Nombres</div>
    <div class=" titulo_list_u">Indentificación</div>
    <div class=" titulo_list_u">Teléfono</div>
    
    <div class=" titulo_list_u">Ciudad</div>
    <div class=" titulo_list_u">Dirección</div>
    <div class=" titulo_list_u">Usuario Asignado</div>
    </div>';
    echo " <div class=\"contenedor\">
          <div class=\"campos_list_u\">". $identificador ."</div>
          <div class=\"campos_list_u\"> ". $xinfouser["email"] ."</div>
          <div class=\"campos_list_u\"> ". utf8_encode($xinfouser["nombre_completo"]) ."</div>
          <div class=\"campos_list_u\"> ". utf8_encode($xinfouser["identificacion"]) ."</div>
          <div class=\"campos_list_u\"> ". $xinfouser["numero_telefono"] ."</div>
          <div class=\"campos_list_u\"> ". utf8_encode($xinfouser["ciudad"]) ."</div>
    
          <div class=\"campos_list_u\"> ". $xinfouser["direccion"] ."</div>
    
          <div class=\"campos_list_u\"> ". $xinfouser["usuario"] ."</div>
        </div> ";
    echo '
        <div class="titulo2"><i class="fa-solid fa-user"></i> Roles del Usuario</div>
        <div class="contenedor_titulos">
        <div class="campos_list_u titulo">Usuario</div>
        <div class="campos_list_u titulo">Rol</div>
        <div class="campos_list_u titulo">Fecha Efectiva</div>
        <div class="campos_list_u titulo">Estado</div>
        </div>';
    $filtro = "id_usuario = $identificador";
    $result = $Json->buscarrolusuario($filtro);
    $xrowrol = array();
    while ($xrowrol = $Json->obtener_fila($result)) {
        $usuario = $xrowrol["usuario"];
        $rol = utf8_encode($xrowrol["rol"]);
        $fecha_efectiva = $xrowrol["fecha_efectiva"];
        $estado = $xrowrol["estado"];
        echo " <div class=\"contenedor\">";
        echo "<div class=\"campos_list_u\">$usuario</div>";
        echo "<div class=\"campos_list_u\">".$rol."</div>";
        echo " <div class=\"campos_list_u\">$fecha_efectiva </div><div class=\"campos_list_u\">$estado </div> ";
        echo "</div> ";  
    }
    echo '
        <div class="titulo2"><i class="fa-solid fa-user"></i> Clientes del Usuario </div>
        <div class="contenedor_titulos">
        <div class="campos_list_u titulo">Usuario</div>
        <div class="campos_list_u titulo">Tipo Identificación</div>
        <div class="campos_list_u titulo">Número Identificación</div>
        <div class="campos_list_u titulo">Nombres</div>
        <div class="campos_list_u titulo">Fecha Efectiva</div>
        <div class="campos_list_u titulo">Estado</div> 
        </div>';
    $filtro = "id_usuario = $identificador";
    $result = $Json->buscarclienteusuario($filtro);
    $xrowcl = array();
    while ($xrowcl = $Json->obtener_fila($result)) {
        $usuario = $xrowcl["usuario"];
        $tipoidentificacionc = utf8_encode($xrowcl["tipo_identificacion"]);
        $numeroidentificacionc = $xrowcl["numero_identificacion"];
        $nombrec = utf8_encode($xrowcl["nombres"]);
        $fechaefectivac = $xrowcl["fecha_efectiva"];
        $estadoc = utf8_encode($xrowcl["estado"]);
        
      
        
        
        echo " <div class=\"contenedor\">";
    
        echo "<div class=\"campos_list_u\">".$usuario."</div>";
        echo " <div class=\"campos_list_u\">".$tipoidentificacionc."</div> ";
        echo " <div class=\"campos_list_u\">".$numeroidentificacionc."</div> ";
        echo "<div class=\"campos_list_u\">".$nombrec."</div>";
        echo " <div class=\"campos_list_u\">".$fechaefectivac."</div> ";
        echo "<div class=\"campos_list_u\">".$estadoc."</div>";
        
        echo "</div> ";
    }
    echo "<br>";
}
else
{
echo '<form id="form" action="listausuariosrh.php" method="POST">';
echo '<div class="link_int"><div class="titulo2"><i class="fa-solid fa-user"></i> <a href="">Volver a Consultar Usuarios</a></div>
<div class="titulo3"><a href="crearusuariosrh.php">Administrar Usuario</a></div></div>';
echo '<div class="buscar">';
echo '<div class="contenedor-1">
        <span class="icon"><i class="fa fa-search"></i></span>
        <input type="search" id="search" placeholder="Buscar Usuario..." autocomplete="off" />
    </div>
    
 <div id="sugerencia"></div>
    </div>';

echo '<div class="contenedor_titulos">
<div class=" titulo_list_u">ID</div>
<div class=" titulo_list_u">Email</div>
<div class=" titulo_list_u">Nombres</div>
<div class=" titulo_list_u">Indentificación</div>
<div class=" titulo_list_u">Teléfono</div>

<div class=" titulo_list_u">Ciudad</div>
<div class=" titulo_list_u">Dirección</div>
<div class=" titulo_list_u">Usuario Asignado</div>
</div>';
      $Json     = new Json;
       $Json->iniciarVariables();
       $result = $Json->buscarusuarios($filtro);
$xrowuser = array();
$xi=0;
while ($xrowuser = $Json->obtener_fila($result)) {
    $identificador = $xrowuser["identificador"];
    $email = $xrowuser["email"];
    $nombre = utf8_encode($xrowuser["nombre"]);
    $apellidos = utf8_encode($xrowuser["apellidos"]);
    $tipoidentificacion = utf8_encode($xrowuser["tipo_identificacion"]);
    $numidentificacion = $xrowuser["numidentificacion"];
    $numerotelefono = $xrowuser["numero_telefono"];
    $pais = utf8_encode($xrowuser["pais"]);
    $departamento = utf8_encode($xrowuser["departamento"]);
    $ciudad = utf8_encode($xrowuser["ciudad"]);
    $direccion = $xrowuser["direccion"];
    $usuario = $xrowuser["usuario"];
    $nombrecompleto = $xrowuser["nombre_completo"];
    $identificacionu = $xrowuser["identificacion"];
    echo " <div class=\"contenedor\">";
    echo "<div class=\"campos_list_u\"><input type=\"submit\"  class=\"btn_sel\" name=\"identificau\" id=\"identificau\" value=\"$identificador\" ></div>";
            echo "<div class=\"campos_list_u\">$email </div>";
            echo " <div class=\"campos_list_u\">$nombrecompleto </div>
                   <div class=\"campos_list_u\">$identificacionu </div>
                   <div class=\"campos_list_u\">$numerotelefono </div>                   
                   <div class=\"campos_list_u\">$ciudad </div>
                   <div class=\"campos_list_u\">$direccion </div>
                   <div class=\"campos_list_u\">$usuario </div>
";
          echo "</div> ";  
}
echo '  <input type="hidden" id="identifu" name="identifu" value="d" >';
echo '  <input type="hidden" id="idusuario" name="idusuario" >';

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

