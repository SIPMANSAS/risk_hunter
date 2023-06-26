<?php include "sec_login.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dominios</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>  
<?php include 'header-rh.php'; 
  echo ' <div class="titulo_p"><div><i class="fa-solid fa-spinner"></i> Dominios </div></div>';
  if (isset($_POST["identificador"]))
    echo ' <div class="titulo2"><i class="fa-solid fa-spinner"></i><a href=""> Volver a Grupos de Dominios </a></div>';
  else
   echo ' <div class="titulo2"><i class="fa-solid fa-spinner"></i><a href=""> Grupos de Dominios </a></div>';
  echo '  <div class="contenedor_titulos ">
        <div class="campos titulo">Identificación</div>
        <div class="campos titulo">nombre</div>   
    </div>';


if ($_POST["identificador"])
     $identificador = $_POST["identificador"];
else
     $identificador = "p";
function callWebService($identificador, $tipo, $nombre, $codigodep)
{
    if (isset($identificador) && (isset($tipo) && ($tipo != "")))
    {
        if (isset($codigodep))
            $data = file_get_contents('http://rh.deshida.com.co/rh/regiones/funciones/obtienedominioglobal.php?codigo='.$tipo.'&identificador='.$identificador.'&codigodep='.$codigodep);
        else
        $data = file_get_contents('http://rh.deshida.com.co/rh/regiones/funciones/obtienedominioglobal.php?codigo='.$tipo.'&identificador='.$identificador);
    }
    else 
    {

        if (isset($nombre) && ($nombre != ""))
        {
            $data = file_get_contents('http://rh.deshida.com.co/rh/regiones/funciones/obtienedominioglobal.php?nombre='.$nombre.'&identificador='.$identificador);
        }
         else    
        {
            $tipo="";
            $nombre="";
            $data = file_get_contents('http://rh.deshida.com.co/rh/regiones/funciones/obtienedominioglobal.php');
        }
    }
           $data = json_decode($data,TRUE);
    return $data;
}
echo '<form id="form" action="dominios.php" method="POST">';
if ($identificador == 'p')
{
    $nombre="";
    $codigo="";
    $codigodep="";
}
else {
    $identificador = "d";
    $codigo = $_POST["codigodominio"];
    $codigodep="";
}
$result = callWebService($identificador,$codigo,$nombre,$codigodep);
if (isset($result["estado"]) && ($result["estado"] == 1) )
{
        $totaldominio = $result["totald"];
        if(isset($_POST["identificador"]) && ($_POST["identificador"] == 'd') && (isset($_POST["codigodominio"])))
        {
            $codigo = $_POST["codigodominio"];
            $grupo_nombre = $result["grupo_dominio"][0];
              
        echo  " <div class=\"contenedor\">
                <div id=\"ID\" class=\"campos_dom_a\"> ". $codigo ."</div>
                <div class=\"campos_dom_a bonito\">".$grupo_nombre."</div>
                </div> ";
            echo '
        <div class="titulo2"><i class="fa-solid fa-spinner"></i> Dominios</div>
        <div class="contenedor_titulos">
        <div class="campos titulo">Grupo</div>
        <div class="campos titulo">Grupo Dominio</div>
        <div class="campos titulo">Clasificación</div>
        <div class="campos titulo">Nombre</div>
        <div class="campos titulo">Descripción</div>
        <div class="campos titulo">Id Alfanumérico</div>
        <div class="campos titulo">Valor Padre</div>
        </div>';
        }
        for ($xi=0; $xi < $totaldominio; $xi++) {
            if (isset($result["iddominio"][$xi]))
            {
                $codigo = $result["iddominio"][$xi];
                $nombre = $result["nombre"][$xi];
                $descripcion = $result["descripcion"][$xi];
                $clasificacion = $result["clasificacion"][$xi];
                $id_alfanumerico = $result["id_alfanumerico"][$xi];
                $grupo_nombre = $result["grupo_dominio"][$xi];
                $valor_padre = $result["valor_padre"][$xi];
               echo " <div class=\"contenedor\">";
               echo "<div class=\"campos_dom_b \"><input type=\"submit\"  class=\"btn_sel\" name=\"codigodominio\"  value=\"$codigo\" ></div>";
                if ($identificador == "p")
                    echo "<div class=\"campos_dom_b\">$nombre</div>";
               else
               {
                   echo "<div class=\"campos_dom_b\">$grupo_nombre</div>";
                   echo " <div class=\"campos_dom_b\">$clasificacion </div>
                          <div class=\"campos_dom_b\">$nombre </div>
                          <div class=\"campos_dom_b\">$descripcion </div>
                          <div class=\"campos_dom_b\">$id_alfanumerico </div>
                          <div class=\"campos_dom_b\">$valor_padre </div>";
               }
               echo "</div> ";  
            } 
       };
}
else
    echo "No se encontraron dominios segun criterios solicitados";
  echo '  <input type="hidden" id="identificador" name="identificador" value="d" >';
  echo '  <input type="hidden" id="totaldominio" name="totald" value='.$totaldominio.' >';
  echo '  <input type="hidden"  name="iddef" value='.$codigo.' >';
  echo '  </form><div class="cont_fin"></div>';
//}
include 'footer.php'; ?>
<script>
        function vermenu(){
            document.getElementById('m_ad').classList.toggle('ver');
        }
</script>
</body>
</html>