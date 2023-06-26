<style>
        .verticalText {
            writing-mode: vertical-lr;
            transform: rotate(180deg);
        }
        
        .verticalTextB {
            writing-mode: vertical-lr;
            transform: rotate(180deg);
            min-height: 114;
        }
        .table{
            width: 60%;
	        height: 300px;
        }
  </style>

<?php

 include 'conexion/conexion.php';
////////////////////////////////////// TAMAÑO DE LA MATRIZ  ///////////////////////////////////////////////////////////////////////////////////////////
$consultalabelshorizontales = $mysqli->query("SELECT * FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
$consultamatriz = $mysqli->query("SELECT f_dimension_matriz() AS Matriz");
$extraerDatos = $consultamatriz->fetch_array(MYSQLI_ASSOC);
$tamano_matriz = $extraerDatos['Matriz'];

$filas = $tamano_matriz;
$columnas = $tamano_matriz;
$textoF = strval($filas+1);
$textoC = strval($filas+3);
$numero = 1;
///////////////////////////////////////// END  TAMAÑO DE LA MATRIZ /////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////// PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////
$tabla = "<table border='1' width='60' height='60'>";
$color_actual = ' ';
$tabla .= "<th colspan='4' style='background-color:#00E0FF'><h2><h2></th>";
$tabla .= "<th colspan='$textoF+$columnas' style='background-color:#00E0FF'><h3>Impacto o Intensidad<h3></th>";
$tabla .= "<tr>";
$tabla .= "";

///////////////////////////////////////// END PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////////////////////////////////////////////

$consultaFilas = $mysqli->query("SELECT D.nombre,D.identificador ,COUNT(D.identificador) AS Cantidad FROM mat_filas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY `D`.`identificador` DESC");
//////////////////////////////////////// PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////
$tabla.="   <td class='verticalText' style='background-color:#00E0FF' colspan='4' rowspan='$textoC'>
                <h3>
                    <center>Probabilidad(%)</center>
                </h3>
            </td>
            <td rowspan='$textoC'>
                <table border='1'>";
                
                //////////////////////////////////////// END PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////////////////////////////////////////////////
                
                //////////////////////////////////AQUI INICIA DONDE SE PINTAN LAS COLUMNAS DE PROBABILIDAD //////////////////////////////////////////////////////////////////////////////////////
                $consultarangos= $mysqli->query("SELECT DISTINCT nombre ,COUNT(nombre) Cantidad FROM mat_filas  C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador DESC");
                $tabla .="<br><br><br>";
                while($extraermatcolumnas = $consultarangos->fetch_array()){
                    $extraermatcolumnas['Cantidad'].'-'.$extraermatcolumnas['nombre'];
                    $ancho = $extraermatcolumnas['Cantidad'];
                    $tabla .= "<td widht='$ancho' class='verticalTextB' ><b>".$extraermatcolumnas['nombre']."</center><b></td><tr>";
                     
                }
                $tabla .="</tr>";
                //$tabla .="<tr>";
                
                $tabla.="</table>
            </td>
            
            ";
            //////////////////////////////////////// END PINTA LOS TITULOS LAS COLUMNAS DE PROBABILIDAD /////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////// CONSULTA LABELS HORIZONTALES (TITULOS IMPACTO (MUY BAJO, BAJO ,MEDIO ,ETC....))//////////////////////////////////////////////////////////////////////////////
$consultalabelshorizontales = $mysqli->query("SELECT * FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
$consultaColumnas = $mysqli->query("SELECT D.identificador ,COUNT(D.identificador) AS Cantidad,D.nombre FROM mat_columnas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY D.identificador DESC");
while($extraerDatos = $consultalabelshorizontales->fetch_array()){
    while($extraerlongitudes = $consultaColumnas->fetch_array()){
        $tabla .= "<td colspan='".$extraerlongitudes['Cantidad']."'><b><center>".$extraerlongitudes['nombre']."</center><b></td>";
    }
}
$tabla .="<tr>";
/////////////////////////////////////////////////////////////// END CONSULTA LABELS HORIZONTALES (TITULOS IMPACTO (MUY BAJO, BAJO ,MEDIO ,ETC....)) ///////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////// CONSULTA RANGOS IMPACTO O INTENSIDAD /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$consultarangos= $mysqli->query("SELECT * FROM mat_columnas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador;");
//while($extraermatcolumnas = $consultarangos->fetch_array()){
  //  $tabla .= "<td style='background-color:#C9C6C4'>".'> '.$extraermatcolumnas['valor_inicial'].'% - = '.$extraermatcolumnas['valor_final'].'%'."</td>";
//}
///////////////////////////////////////////////////////////////////// END CONSULTA RANGOS IMPACTO O INTENSIDAD  ///////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////// FOR PARA PINTAR EL CONTENIDO DE LA MATRIZ //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$numeracion = $filas;

for($i = 1; $i <= $filas; $i++) {
    
    $tabla .= "<tr>";

    for($j = 1; $j <= $columnas; $j++) {
                                                                        
             $hay_color = $mysqli->query("SELECT MC.codigo,COUNT(1) AS Cantidad 
                                                                        FROM par_pintar_matriz PM,mat_colores MC
                                                                        WHERE fila='$i' 
                                                                        AND col_inicio_color = '$j'
                                                                        AND MC.identificador = PM.color
                                                                        GROUP BY MC.codigo;");
                                        $datocolor = $hay_color->fetch_array(MYSQLI_ASSOC);
                                        $colorCantidad = $datocolor['Cantidad'];
                                        $color= $datocolor['codigo'];
            if($colorCantidad > 0){
                $color_actual = $color;
            } 
            $texto_celdas = $mysqli->query("SELECT f_texto_matriz($i,$j,161) AS texto_matriz");
            $extraerDatosCelda = $texto_celdas->fetch_array(MYSQLI_ASSOC);
             $datoceldas = $extraerDatosCelda['texto_matriz'];
           
            $tabla .= "<td border='0' valign='top' style='background:$color_actual;font-size:10px' > ".$datoceldas.' '."</td>";
        $numero++;

    }

    $tabla .= "</tr>";

}
//////////////////////////////////////////////////////////////////////////// FIN PINTA MATRIZ CON COLORES (COMPLETA) ////////////////////////////////////////////////////////////////////////////////////////////
$tabla .= "</table>";

echo $tabla;

///////////////////////////////////////////////////////////////////////////////////////////////////END /////////////////////////////////////////////////////////////////////////////////////////////////////
?>