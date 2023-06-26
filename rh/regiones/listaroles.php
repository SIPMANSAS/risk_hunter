<?php include "sec_login.php"; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>  
    <?php
        include 'header-rh.php';
    ?>
        <div class="titulo_p"><div><i class="fa-solid fa-user"></i> Roles </div></div>
<?php
       if(isset($_POST["identificau"]))
		echo ' <div class="link_int"><div class="titulo2"><i class="fa-solid fa-user"></i><a href=""> Volver a Roles</a></div>';
       else
          echo '<div class="link_int"><div class="titulo2"><i class="fa-solid fa-user"></i><a href=""> Roles</a></div>';
       echo ' <div class="titulo3"><a href="roles.php">Crear Roles</a></div></div>
        <div class="contenedor_titulos">
        <div class=" titulo_list_r">ID</div>
        <div class=" titulo_list_r">Nombre</div>  
        <div class=" titulo_list_r">Descripcion</div>
        <div class=" titulo_list_r">Tipo Estado</div>   
        <div class=" titulo_list_r">Estado</div>   
        </div>';

include  "clases/Json.class.php";
    $identificador = "1";
    $filtro = "sr.identificador like '%%'";
if(isset($_POST["identificau"]))
{
    include_once '';  "clases/Json.class.php";
    $identificador = $_POST["identificau"];
    $Json     = new Json;
    $Json->iniciarVariables();
    $filtro = "sr.identificador = '$identificador'";
    $result = $Json->buscarol($filtro);
    $xinforol = $Json->obtener_fila($result);
    $nombre_corto = $xinforol["nombre_corto"];
    $descripcion = $xinforol["descripcion"];
    $tipoestado = $xinforol["tipo_estado"];
    $estado = $xinforol["estado"];
    //aqui cambio el id de la sugunda pagina
    
    echo " <div class=\"contenedor\">";
    echo "<div class=\"campos_list_u\"><input type=\"submit\"  class=\"btn_sel\" name=\"identificau\"  value=\"$identificador\" >
           </div>";
    echo "<div class=\"campos_list_u\">$nombre_corto </div>
          <div class=\"campos_list_u\">$descripcion </div>
           <div class=\"campos_list_u\">$tipoestado </div>
           <div class=\"campos_list_u\">$estado </div>
           </div> ";  
    
      echo '
        <div class="titulo2"><i class="fa-solid fa-user"></i> Permisos del Rol</div>
        <div class="contenedor_titulos">
        <div class="campos_list_u titulo">Nombre de la Clase</div>
        <div class="campos_list_u titulo">Estado de la clase</div>
        <div class="campos_list_u titulo">Id Objeto</div>
        <div class="campos_list_u titulo">Nombre Objeto </div>
        <div class="campos_list_u titulo">Estado Objeto </div>
        <div class="campos_list_u titulo">Tipo Permiso </div>
       <div class="campos_list_u titulo">Estado Permiso </div>
    
        </div>';
    $filtro = "id_rol = $identificador";
    $result = $Json->buscarrolpermiso($filtro);
    $xrowrol = array();
    while ($xrowrol = $Json->obtener_fila($result)) {
        $clase = utf8_encode($xrowrol["nom_clase"]);
        $estadoclase = $xrowrol["est_clase"];
        $idobjeto = $xrowrol["id_objeto"];
        $nomobjeto = utf8_encode($xrowrol["nom_objeto"]);
        $estadoobjeto = $xrowrol["est_objeto"];
        $tipopermiso = $xrowrol["tipo_permiso"];
        $estadopermiso = $xrowrol["est_permiso"];
        
        echo " <div class=\"contenedor\">";
        echo "<div class=\"campos_list_u\">$clase</div>";
        echo "<div class=\"campos_list_u\">$estadoclase</div>";
        echo " <div class=\"campos_list_u\">$idobjeto </div>";
        echo "<div class=\"campos_list_u\">$nomobjeto </div> ";
        echo "<div class=\"campos_list_u\">$estadoobjeto</div>";
        echo " <div class=\"campos_list_u\">$tipopermiso </div>";
        echo "<div class=\"campos_list_u\">$estadopermiso </div> ";
        
        echo "</div> ";  
    }
    $Json->cerrar();
}
else {
/* ingresa al formulario de listado de roles y seleccion para listar permisos */

echo '<form id="form" action="listaroles.php" method="POST">';
/* se llama la clase Json */
       $Json     = new Json;
       $Json->iniciarVariables();
       $result = $Json->buscarol($filtro);
       $xrowrol = array();
     while ($xrowrol = $Json->obtener_fila($result)) {
        $identificador = $xrowrol["identificador"];
        $nombre_corto = utf8_encode($xrowrol["nombre_corto"]);
        $descripcion = utf8_encode($xrowrol["descripcion"]);
        $tipoestado = $xrowrol["tipo_estado"];
        $estado = $xrowrol["estado"];
      echo " <div class=\"contenedor\">";
    echo "<div class=\"campos_list_u\"><input type=\"submit\"  class=\"btn_sel\" name=\"identificau\"  value=\"$identificador\" ></div>";
            echo "<div class=\"campos_list_u\">$nombre_corto </div>";
            echo " <div class=\"campos_list_u\">$descripcion </div>
                   <div class=\"campos_list_u\">$tipoestado </div>
                   <div class=\"campos_list_u\">$estado </div>                   
                  
";
          echo "</div> ";  
}
echo '  <input type="hidden" id="identifu" name="identifu" value="d" >';
echo '  </form>';
$Json->cerrar();
}
echo '<div class="cont_fin"></div>';
include 'footer.php'; ?>

</body>
</html>

