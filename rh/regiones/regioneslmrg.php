<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regiones</title>
    <link rel="stylesheet" href="css/regiones.css">

</head>
<body>  
    <header>
        <div class="logo">
            <a href=""><i class="fa-solid fa-globe"></i> logo</a>
        </div>
        <div class="usuario">
            <a href=""><i class="fa-solid fa-user"></i></a>
        </div>
    </header>
    
    <div class="titulo_p"><div><i class="fa-solid fa-globe"></i> regiones </div></div>
    <div class="titulo2"><i class="fa-solid fa-flag"></i><a href=""> paises </a></div>
    <div class="contenedor_titulos ">
        <div class="campos titulo">cod</div>
        <div class="campos titulo">nombre</div>
        <div class="campos titulo">tipo Est</div>
        <div class="campos titulo">estado</div>      
    </div>

<?php 

if ($_POST["identificador"])
     $identificador = $_POST["identificador"];
else
     $identificador = "p";
                        

function callWebService($identificador, $idpais, $nombre, $codigodep)
{
    if (isset($identificador) && (isset($idpais) && ($idpais != "")))
    {
        if (isset($codigodep))
            $data = file_get_contents('http://rh.deshida.com.co/rh/regiones/funciones/obtienedominio.php?codigo='.$idpais.'&identificador='.$identificador.'&codigodep='.$codigodep);
        else
        $data = file_get_contents('http://rh.deshida.com.co/rh/regiones/funciones/obtienedominio.php?codigo='.$idpais.'&identificador='.$identificador);
        
    }
    else 
    {
        if (isset($nombre) && ($nombre != ""))
        {
            $data = file_get_contents('http://rh.deshida.com.co/rh/regiones/funciones/obtienedominio.php?nombre='.$nombre.'&identificador='.$identificador);
            
            
        }
         else    
        {
            $idpais="";
            $nombre="";
           $data = file_get_contents('http://rh.deshida.com.co/rh/regiones/funciones/obtienedominio.php');
        }
    }
           $data = json_decode($data,TRUE);
           
           echo "data estado". $data["estado"];
    return $data;
}



echo '<form id="form" action="regioneslmrg.php" method="POST">';

if(isset($_POST["identificador"]) && ($_POST["identificador"] == 'd') && (isset($_POST["nombrepais"])))
{
    $nombre = $_POST["nombrepais"];
    $codigo = "";
    $codigodep="";
    echo "voy a llamar call";
    $result1 = callWebService("p",$codigo,$nombre,$codigodep);
    echo "salida dos de llamar";
    if (isset($result1))
    {
        $tipo_estado = $result1["tipo_estado"][0];
        $estadopais = $result1["estadodominio"][0];
        $idpais = $result1["iddominio"][0];
        
    }
    echo " <div class=\"contenedor\">
                <div id=\"ID\" class=\"campos\"> $idpais </div>
                
            <div class=\"campos\"><input type=\"button\" class=\"btn_sel\" name=\"nombrepais\"  value=\"".$nombre."\" ></div>
            <div class=\"campos\">$tipo_estado </div>
            <div class=\"campos\">$estadopais </div>
        </div> ";
    echo '
        <div class="titulo2"><i class="fa-regular fa-flag"></i> Departamentos</div>
        <div class="contenedor_titulos">
        <div class="campos titulo">cod</div>
        <div class="campos titulo">nombre</div>
        <div class="campos titulo">tipo Est</div>
        <div class="campos titulo">estado</div>
        </div>';
    $ident="c";
}
else
    if (isset($_POST["codigodep"]) && ($ident="c"))
    {
        echo "debo llamar a ciudad";
        $codigo = $idpais;
        $identificador = "c";
        $nombre="";
        $codigodep = $_POST["codigodep"];
        echo "codigodep es $codigodep totald es $totald";
        
        $result3 = callWebService($identificador,$codigo,$nombre,$codigodep);
        $totciudad = $result3["totald"];
        
        
        for ($xi=0; $xi < $totciudad; $xi++) {
            if (isset($result3["iddominio"][$xi]))
            {
                $codigo = $result3["iddominio"][$xi];
                $nombre = $result3["nombre"][$xi];
                $tipo_estado = $result3["tipo_estado"][$xi];
                $estadopais = $result3["estadodominio"][$xi];
                $escapital = $result3["escapital"][$xi];
                $codigop = $result3["codigop"][$xi];
                $codigod = $result3["codigod"][$xi];
                $pais = $result3["pais"][$xi];
                $departamento = $result3["departamento"][$xi];
                
                echo " <div class=\"contenedor\">";
                    echo "<div class=\"campos\">$codigop</div>";
                    echo "<div class=\"campos\"><input type=\"button\"  id=\"nompais\" class=\"btn_sel\" name=\"nombrepais\"  value=\"$pais\" ></div>";
               
                echo "</div> 
                </div> ";
                echo '
        <div class="titulo2"><i class="fa-regular fa-flag"></i> Departamentos</div>
        <div class="contenedor_titulos">
        <div class="campos titulo">cod</div>
        <div class="campos titulo">nombre</div>
        <div class="campos titulo">tipo Est</div>
        <div class="campos titulo">estado</div>
        </div>';
             
        echo " <div class=\"contenedor\">
                <div id=\"ID\" class=\"campos\"> $codigodep </div>
                
            <div class=\"campos\"><input type=\"button\" class=\"btn_sel\" name=\"nombredep\"  value=\"".$departamento."\" ></div>
         </div> ";
   
        echo '
        <div class="titulo2"><i class="fa-regular fa-flag"></i> Ciudades</div>
        <div class="contenedor_titulos">
        <div class="campos titulo">cod</div>
        <div class="campos titulo">nombre</div>
        <div class="campos titulo">tipo Est</div>
        <div class="campos titulo">estado</div>
 <div class="campos titulo">escapital</div>
       
        </div>';
            
        echo " <div class=\"contenedor\">
                <div id=\"ID\" class=\"campos\"> $codigo </div>
                
            <div class=\"campos\"><input type=\"button\" class=\"btn_sel\" name=\"nombreciudad\"  value=\"".$nombre."\" ></div>
            <div class=\"campos\">$tipo_estado </div>
            <div class=\"campos\">$estadopais </div>
            <div class=\"campos\">$escapital </div>
        </div> ";
        
        
        
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

$result = callWebService($identificador,$codigo,$nombre,$codigodep);
if (isset($result["estado"]) && ($result["estado"] == 1) )
{
        $totalpais = $result["totald"];
        
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
                  echo "<div class=\"campos\">$codigo</div>";
                echo "<div class=\"campos\"><input type=\"submit\"  id=\"nompais\" class=\"btn_sel\" name=\"nombrepais\"  value=\"$nombre\" ></div>";
                }
               else
               {
                  echo " <div class=\"campos\"><input type=\"submit\"  id=\"coddep\" class=\"btn_sel\" name=\"coddep\"  value=\"$codigo\" ></div>";
                  echo " <div class=\"campos\">$nombre </div>";
                }
            echo " <div class=\"campos\">$tipo_estado </div>
            <div class=\"campos\">$estadopais </div>        
        </div> ";  
            } 
       };
}
else
    echo "No se encontraron paises segun criterios solicitados";

  echo '  <input type="hidden" id="identificador" name="identificador" value="d" >';
  echo '  <input type="hidden" id="totalpais" name="totalpais" value='.$totalpais.' >';
  
  echo '  </form>';






?>
    <div class="cont_fin"></div>
    <div id="mostrar_dep" ></div>
    <div id="mostrar_ciudad"></div>


        <script>
            function departamentos(boton)
            {
            accion = boton;
            var parametros = {
             "id_pais" : accion
            };
            $.ajax({
                data: parametros,
                url:'mos_dep.php',
                type: 'POST',
                
                beforesend: function()
                {
                    $('#mostrar_dep').html("mensaje antes de enviar");
                },
                success: function(mensaje)
                {
                    $('#mostrar_dep').html(mensaje);
                }
            });
            } 
            function ciudades(boton)
            {
            accion = boton;
            var parametros = {
             "id_departamento" : accion
            };
            $.ajax({
                data: parametros,
                url:'mos_ciu.php',
                type: 'POST',
                
                beforesend: function()
                {
                    $('#mostrar_ciudad').html("mensaje antes de enviar");
                },
                success: function(mensajeb)
                {
                    $('#mostrar_ciudad').html(mensajeb);
                }
            });
            }   
         
        </script>
</body>

</html>
