<?php
$id_pais = $_POST['id_pais'];
include("conexion.php");
$paises = "SELECT * FROM rg_paises" ;
$departamentos ="SELECT * FROM `rg_departamentos` where codigo_pais=$id_pais " ;
$resul_pais =pg_query($conexion,$paises) ;
$resul_departamento =pg_query($conexion,$departamentos);
//imprime los titulos del departamento
echo
'
<div class="titulo2"><i class="fa-regular fa-flag"></i> Departamentos</div>
<div class="contenedor_titulos">
    <div class="campos titulo">cod pais</div>
    <div class="campos titulo">cod</div>
    <div class="campos titulo">nombre</div>
    <div class="campos titulo">tipo Est</div>
    <div class="campos titulo">estado</div>
</div>
';
//impreime departamentos por id mde pais
while($mostrar_d=pg_fetch_array($resul_departamento,))
{       
    echo
    '
    <div class="contenedor">
        <div class="campos">'.$mostrar_d['codigo_pais'].'</div>
        <div class="campos">'.$mostrar_d['codigo'].'</div>
        <div class="campos"><input type="button" id='.$mostrar_d['codigo'].' class="btn_sel" value="'. $mostrar_d['nombre'].'" onclick="ciudades('.$mostrar_d['codigo'].')"></div>
        <div class="campos">'.$mostrar_d['tipo_estado'].'</div>
        <div class="campos">'.$mostrar_d['estado'].'</div>
    </div>
    ';
}
echo '<div class="cont_fin"></div> 
';

?>
