<?php
$id_departamento = $_POST['id_departamento'];
include("conexion.php");
$departamentos ="SELECT * FROM `rg_departamentos";
$ciudad = "SELECT * FROM `rg_ciudades` where codigo_departamento=$id_departamento ";
$resul_ciudad =pg_query($conexion,$ciudad);

//imprime los titulos de ciudades
echo'
<div class="titulo2"><i class="fa-solid fa-city"></i> Ciudades</div>
    <div class="contenedor_titulos">
        <div class="campos titulo">cod pais</div>
        <div class="campos titulo">cod _dep/to</div>
        <div class="campos titulo">cod</div>
        <div class="campos titulo">nombre</div>
        <div class="campos titulo">es capital</div>
        <div class="campos titulo">tipo Est</div>
        <div class="campos titulo">estado</div>
    </div>';

while($mostrar_c=pg_fetch_array($resul_ciudad)){
    echo '
    <div class="contenedor">
        <div class="campos">'.$mostrar_c['codigo_pais'].'</div>
        <div class="campos">'.$mostrar_c['codigo_departamento'].'</div>
        <div class="campos">'.$mostrar_c['codigo'].'</div>
        <div class="campos">'.$mostrar_c['nombre'].'</a> </div>
        <div class="campos">'.$mostrar_c['es_capital'].'</div>
        <div class="campos">'.$mostrar_c['tipo_estado'].'</div>
        <div class="campos">'.$mostrar_c['estado'].'</div>
    </div>';
 }
    echo'<div class="cont_fin"></div>
    
    
    ';
