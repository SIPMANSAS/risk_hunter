<?php include "sec_login.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regiones</title>
    <link rel="stylesheet" href="css/regiones.css">
     <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>  
<?php include 'header-rh.php'; ?>    
<div class="titulo_p"><div><i class="fa-solid fa-globe"></i> regiones </div></div>
<?php
if (isset($_POST["identificador"]))
   echo ' <div class="titulo2"> <i class="fa-solid fa-flag"></i><a href=""> Volver a Paises </a></div>';
else
   echo ' <div class="titulo2"> <i class="fa-solid fa-flag"></i><a href=""> Paises </a></div>';
?>
    <div class="contenedor_titulos ">
        <div class="campos titulo">código</div>
        <div class="campos titulo">nombre</div>
        <div class="campos titulo">tipo Estado</div>
        <div class="campos titulo">estado</div>      
    </div>
<?php 

if ($_POST["identificador"])
     $identificador = $_POST["identificador"];
else
     $identificador = "p";
                        

function callWebService($identificador, $idpais, $nombre, $codigodep)
{
    $archivo = __DIR__ . "/config/configuracion.php";
    $contenido = parse_ini_file($archivo, false);
    $LINKS = $contenido["LINK"];
    
    if (isset($identificador) && (isset($idpais) && ($idpais != "")))
    {
        if (isset($codigodep))
            $data = file_get_contents($LINKS.'funciones/obtienedominio.php?codigo='.$idpais.'&identificador='.$identificador.'&codigodep='.$codigodep);
        else
        $data = file_get_contents($LINKS.'funciones/obtienedominio.php?codigo='.$idpais.'&identificador='.$identificador);
    }
    else 
    {
        if (isset($nombre) && ($nombre != ""))
        {
            $data = file_get_contents($LINKS.'funciones/obtienedominio.php?nombre='.$nombre.'&identificador='.$identificador);
        }
         else    
        {
            $idpais="";
            $nombre="";
           $data = file_get_contents($LINKS.'funciones/obtienedominio.php');
        }
    }
           $data = json_decode($data,TRUE);
    return $data;
}
echo '<form id="form" action="region2.php" method="POST">';
if(isset($_POST["identificador"]) && ($_POST["identificador"] == 'd') && (isset($_POST["nombrepais"])))
{
    $nombre = $_POST["nombrepais"];
    $codigo = "";
    $codigodep="";
    $result1 = callWebService("p",$codigo,$nombre,$codigodep);
    if (isset($result1))
    {
        $tipo_estado = $result1["tipo_estado"][0];
        $estadopais = $result1["estadodominio"][0];
        $idpais = $result1["iddominio"][0];        
    }
    echo "  <div class=\"contenedor\">
            <div id=\"ID\" class=\"campos_pais\"> $idpais </div>                
            <div class=\"campos_pais\"><input type=\"button\" class=\"btn_sel\" name=\"nombrepais\"  value=\"".$nombre."\" ></div>
            <div class=\"campos_pais\">$tipo_estado </div>
            <div class=\"campos_pais\">$estadopais </div>
        </div> ";
    echo '
        <div class="titulo2"><i class="fa-regular fa-flag"></i> Departamentos</div>
        <div class="contenedor_titulos">
        <div class="campos titulo">código</div>
        <div class="campos titulo">nombre</div>
        <div class="campos titulo">tipo Estado</div>
        <div class="campos titulo">estado</div>
        </div>';
    $ident="c";
}

if ($identificador == 'p')
{
    $nombre="";
    $codigo="";
    $codigodep="";
}
else {
    $identificador = "d";
    $codigo = $idpais;
    $codigodep="";
}

    if (isset($_POST["coddep"]))
    {
        $codigodep = $_POST["coddep"];
        $idpais = $_POST["idpais"];
         $nombre="";
        $codigo = $_POST["idpaisdef"];
        $result2 = callWebService("c",$codigo,$nombre,$codigodep);
        $pais = $result2["pais"][0];
        $departamento =$result2["departamento"][0];
        $totciudad = $result2["totald"];
       
            $tipo_estado = "PAISES";
            $estadopais = "ACTIVO";
          
        echo "<div class=\"contenedor\">
                <div id=\"ID\" class=\"campos_pais\"> $codigo </div>               
                <div class=\"campos_pais\"><input type=\"button\" class=\"btn_sel\" name=\"nombrepais\"  value=\"".$pais."\" ></div>
                <div class=\"campos_pais\">$tipo_estado </div>
                <div class=\"campos_pais\">$estadopais </div>
            </div>";
        echo '
        <div class="titulo2"><i class="fa-regular fa-flag"></i> Departamentos</div>
        <div class="contenedor_titulos">
            <div class="campos titulo">código</div>
            <div class="campos titulo">nombre</div>
            <div class="campos titulo">tipo Estado</div>
            <div class="campos titulo">estado</div>
        </div>';
        $tipo_estado = "DEPARTAMENTO";
        $estadopais = "ACTIVO";
        
        echo "  <div class=\"contenedor\">
                <div id=\"ID\" class=\"campos_departamento\"> $codigodep </div>                
                <div class=\"campos_departamento\"><input type=\"button\" class=\"btn_sel\" name=\"nombredep\"  value=\"".$departamento."\" ></div>
                <div class=\"campos_departamento\">$tipo_estado </div>
                <div class=\"campos_departamento\">$estadopais </div>
        </div> ";
        echo '
        <div class="titulo2"><i class="fa-regular fa-flag"></i> Ciudades</div>
        <div class="contenedor_titulos">
        <div class="campos titulo">código</div>
        <div class="campos titulo">nombre</div>
        <div class="campos titulo">tipo Estado</div>
        <div class="campos titulo">estado</div>
        <div class="campos titulo">Es Capital?</div>
        </div>';
        for ($xi=0; $xi < $totciudad; $xi++) {
            if (isset($result2["iddominio"][$xi]))
            {                
                $codigo = $result2["iddominio"][$xi];
                $nombre = $result2["nombre"][$xi];
                $tipo_estado = $result2["tipo_estado"][$xi];
                $estadopais = $result2["estadodominio"][$xi];
                $escapital = $result2["escapital"][$xi];
                echo " <div class=\"contenedor\">";
                echo "<div class=\"campos_ciudad\">$codigo</div>";
                echo "<div class=\"campos_ciudad\"><input type=\"button\"  id=\"nompais\" class=\"resalta\" name=\"nombrepais\"  value=\"$nombre\" ></div>";
                echo " <div class=\"campos_ciudad\">$tipo_estado </div>
                <div class=\"campos_ciudad\">$estadopais </div> ";
                echo "<div class=\"campos_ciudad\">$escapital</div></div>";
            }
        }
    }
    else
{
$result = callWebService($identificador,$codigo,$nombre,$codigodep);
if (isset($result["estado"]) && ($result["estado"] == 1) )
{
        $totalpais = $result["totald"];
        $codpais= $codigo;        
        
        for ($xi=0; $xi < $totalpais; $xi++) {
            if (isset($result["iddominio"][$xi]))
            {                
                $codigo = $result["iddominio"][$xi];
                $nombre = $result["nombre"][$xi];
                $tipo_estado = $result["tipo_estado"][$xi];
                $estadopais = $result["estadodominio"][$xi];
                
               echo " <div class=\"contenedor\">";
                if ($identificador == "p")
                {
                echo "<div class=\"campos_pais\">$codigo</div>";
                echo "<div class=\"campos_pais\"><input type=\"submit\"  id=\"nompais\" class=\"\" name=\"nombrepais\"  value=\"$nombre\" ></div>";
                }
                else
                {
                  echo " <div class=\"campos_departamento\"><input type=\"submit\"  id=\"coddep\" class=\"resalta\" name=\"coddep\"  value=\"$codigo\" ></div>";
                  echo " <div class=\"campos_departamento\"><input type=\"button\"  id=\"ndep\" class=\"resalta\" name=\"ndep\"  value=\"$nombre\" ></div>";
                }
            echo " <div class=\"campos_pais\">$tipo_estado </div>
            <div class=\"campos_pais\">$estadopais </div>        
        </div> ";  
            } 
       };
}
else
  echo    "No se encontraron paises segun criterios solicitados";
  echo '  <input type="hidden" id="identificador" name="identificador" value="d" >';
  echo '  <input type="hidden" id="totalpais" name="totalpais" value='.$totalpais.' >';
  echo '  <input type="hidden"  name="idpaisdef" value='.$codpais.' >';
  echo '  </form>';
}
?>
<?php include 'footer.php' ?>
</body>

</html>
