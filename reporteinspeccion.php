<?php

$origen = $_POST['proceso'];


//////////////////////////////////////////////////// INCLUDE LAS DEPENDENCIAS PARA LAS LIBRERIAS DOMPDF //////////////////////////////////////////
require_once  'vendor/autoload.php';
include 'vendor/dompdf';
////////////////////////////////////// FIN DE LA CONEXION //////////////////////////////////////////
$mysqli = new mysqli('185.212.71.204', 'u571892443_risk_hunter', '#6mL0I[Jd7ZW', 'u571892443_risk_hunter');

$inspeccion = $_POST['inspeccion'];
$identificador = $_POST['identificador'];
$firmainspectora = $_POST['firmainspectora'];
$identificacion = $_POST['identificacion'];
$tipodocumentosolicitante = $_POST['tipodocumentosolicitante'];
$nombrepersonaatiende = $_POST['nombrepersonaatiende'];
$fecha_elaboracion = $_POST['fecha_solicitudB'];
$contactofirma = $_POST['contactofirma'];
$pais = $_POST['pais'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$nombreedificacion = $_POST['nombreedificacion'];
$nombrepersonaatiende = $_POST['nombrepersonaatiende'];
$contactopersonaatiende = $_POST['contactopersonaatiende'];
$inspectorasignado = $_POST['inspectorasignado'];
$longitud = $_POST['longitud'];
$latitud = $_POST['latitud'];
$espaciogeografico = $_POST['espaciogeografico'];
$estrato = $_POST['estrato'];
$bloque_inspeccion = $_POST['bloque_inspeccion'];
$fecha_terminacion = $_POST['fecha_terminacion'];
$fecha_actualizacion = $_POST['fecha_actualizacion'];
$texto_informe = $_POST['texto_informe'];
$origen = $_POST['origen'];

$identificadorI = $identificador;




if ($origen == '1') {


    $consultaimagenportada = $mysqli->query("SELECT *,MIN(identificador) FROM enc_imagenes_inspeccion WHERE id_inspeccion = '$identificador'");
    $extraerRutaImagen = $consultaimagenportada->fetch_array(MYSQLI_ASSOC);
    $rutaImagen = $extraerRutaImagen['archivo'];

    $mysqli = new mysqli('185.212.71.204', 'u571892443_risk_hunter', '#6mL0I[Jd7ZW', 'u571892443_risk_hunter');

    $enc_inmuebles = $mysqli->query("SELECT * FROM enc_inmuebles WHERE id_encuesta= '$identificador'");

    $resultconvensiones = $mysqli->query("SELECT * FROM v_matriz_r_b WHERE id_inspeccion='$identificador' AND nr<>0");

    $resultcalificacionesriesgos = $mysqli->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion= '$identificador'");

    $consultatextolinderos = $mysqli->query("SELECT p_informe_obligatorio($identificador) AS InformeO");
    $extraerDatosTextoLindero = $consultatextolinderos->fetch_array(MYSQLI_ASSOC);
    $textofinlalinderos = 'DESDE CA' . $f_ci . $extraerDatosTextoLindero['InformeO'];


    $consultaimagenes = $mysqli->query("SELECT * FROM enc_imagenes_inspeccion WHERE id_inspeccion='$identificador'");
    while ($extraerimagen = $consultaimagenes->fetch_array()) {
        $imagen = $extraerimagen['archivo'];
        $pie_de_pagina = $extraerimagen['pie_de_imagen'];
    }

    $consultavaloresdescripcioncolores = $mysqli->query("SELECT * FROM mat_colores WHERE valor_inicial_cr IS NOT NULL");

    $ColorRiesgo = '<table>
<thead>
    <tr>
        <td style="text-align:left">Descripción</td>
        <td>Sugerencias</td>
    </tr>
</thead>
<tbody>';
    while ($extraerDatosdescripcioncolores = $consultavaloresdescripcioncolores->fetch_array()) {
        $ColorRiesgo .= '<tr>
        <th><button type="" style="background-color:' . $extraerDatosdescripcioncolores['codigo'] . '; text-align:right;">' . $identificadorI = $extraerDatosdescripcioncolores['descripcion'] . '</button></th>
        <th><div style="background-color:' . $extraerDatosdescripcioncolores['codigo'] . '" class="campos_f">' . $identificadorI = ' ' . $extraerDatosdescripcioncolores['descripcion_texto_cr'] . '</div></th>
        </tr>';
    }

    $ColorRiesgo .= '</tbody>
</table>';


    $consultavaloresdescripcioncolores2 = $mysqli->query("SELECT * FROM mat_colores WHERE valor_inicial_nr IS NOT NULL");
    $ColorRiesgo2 = '<table>
<thead>
    <tr>
        <td>Descripción</td>
        <td>Sugerencia</td>
    </tr>
</thead>
<tbody>';
    while ($extraerDatosdescripcioncolores = $consultavaloresdescripcioncolores2->fetch_array()) {
        $ColorRiesgo2 .= '<tr>
        <th><button type="" style="background-color:' . $extraerDatosdescripcioncolores['codigo'] . '">' . $identificadorI = $extraerDatosdescripcioncolores['descripcion'] . '</button></th>
        <th><div style="background-color:' . $extraerDatosdescripcioncolores['codigo'] . '" class="campos_f">' . $identificadorI = ' ' . $extraerDatosdescripcioncolores['descripcion_texto_nr'] . '</div></th>
        </tr>';
    }

    $ColorRiesgo2 .= '</tbody>
</table>';


    $result = '<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>Descripción</th>
            <th></th>
            <th></th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>';
    while ($row = $enc_inmuebles->fetch_assoc()) {
        $result .= '<tr>
            <td></td>
            <td></td>
            <td>' . $row['descripcion'] . '</td>
            <td></td>
            <td></td>
            <td>' . $row['observaciones'] . '</td>
        </tr>';
    }
    $result .= '</tbody>
</table>';


    $resultcalificacionesriesgos2 = '<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>Descripción</th>
            <th></th>
            <th></th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>';
    while ($row = $resultcalificacionesriesgos->fetch_assoc()) {
        $resultcalificacionesriesgos2 .= '<tr>
            <td></td>
            <td></td>
            <td>' . $row['riesgo'] . '</td>
            <td></td>
            <td></td>
            <td>' . $row['cr'] . '</td>
        </tr>';
    }
    $resultcalificacionesriesgos2 .= '</tbody>
</table>';

    $convensiones = '<table>
    <thead>
        <tr>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>';
    while ($rowconvensiones = $resultconvensiones->fetch_assoc()) {
        $convensiones .= '<tr>
            <td>' . $rowconvensiones['dsp_riesgo'] . '</td>
        </tr>';
    }
    $convensiones .= '</tbody>
</table>';

    // Obtener Cordenadas de google maps
    $url = "https://maps.googleapis.com/maps/api/staticmap?center={$latitud},{$longitud}&zoom=15&size=640x640&markers=color:red%7Clabel:M%7C{$latitud},{$longitud}&key=AIzaSyBUdqwj6Cp2rVXv2RzGdXU40rZt8agrMNE";
    $imagenmapa = file_get_contents($url);
    file_put_contents('MostrarPDF/mapa.png', $imagenmapa);


    $dbHost = '185.212.71.204';
    $dbUsername = 'u571892443_risk_hunter';
    $dbPassword = '#6mL0I[Jd7ZW';
    $dbName = 'u571892443_risk_hunter';


    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // GRAFICA #1
    $resultgrafica = $db->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion = $identificador ORDER BY riesgo ASC");
    $grafica_data = [];
    $riesgo = [];
    $nr = [];
    $color_nr = [];
    if ($resultgrafica->num_rows > 0) {
        while ($row = $resultgrafica->fetch_assoc()) {
            $riesgo[] = utf8_encode($row['riesgo']);
            $nr[] = $row['cr'];
            $color_nr[] = $row['color_cr'];
        }
        $grafica_data[] = [
            'label' => $riesgo,
            'data' => $nr,
            'backgroundColor' => $color_nr
        ];
    } else {
        $grafica_data[] = [
            'label' => 'SIN DATOS',
            'data' => [0],
            'backgroundColor' => '#000000'
        ];
    }

    $grafica_options = [
        'title' => 'Nivel de riesgos',
        'width' => 250,
        'height' => 250,
        'legend' => [
            'display' => false
        ],
        'scales' => [
            'yAxes' => [
                [
                    'ticks' => [
                        'beginAtZero' => false,
                        'max' => 100
                    ]
                ]
            ],
            'xAxes' => [
                [
                    'ticks' => [
                        'autoSkip' => false
                    ]
                ]
            ]
        ]
    ];

    $chartUrl = 'https://quickchart.io/chart?' . http_build_query([
        'c' => json_encode([
            'type' => 'bar',
            'data' => [
                'labels' => $riesgo,
                'datasets' => $grafica_data
            ],
            'options' => $grafica_options,
        ])
    ]);

    // Obtener la imagen en formato PNG desde la URL de QuickChart
    $Imagen_Grafica = base64_encode(file_get_contents($chartUrl));
    file_put_contents('MostrarPDF/Imagen_Grafica.png', file_get_contents($chartUrl));

    // GRAFICA #2
    $resultgrafica2 = $db->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion = $identificador ORDER BY riesgo");
    $grafica_data2 = [];
    $riesgo2 = [];
    $nr = [];
    $color_nr = [];
    if ($resultgrafica2->num_rows > 0) {
        while ($row = $resultgrafica2->fetch_assoc()) {
            $riesgo2[] = utf8_encode($row['riesgo']);
            $nr[] = $row['nr'];
            $color_nr[] = $row['color_nr'];
        }
        $grafica_data2[] = [
            'label' => $riesgo2,
            'data' => $nr,
            'backgroundColor' => $color_nr
        ];
    } else {
        $grafica_data2[] = [
            'label' => 'SIN DATOS',
            'data' => [0],
            'backgroundColor' => '#000000'
        ];
    }

    $grafica_options2 = [
        'title' => 'Nivel de riesgos',
        'width' => 250,
        'height' => 250,
        'legend' => [
            'display' => false
        ],
        'scales' => [
            'yAxes' => [
                [
                    'ticks' => [
                        'beginAtZero' => false,
                        'max' => 100
                    ]
                ]
            ],
            'xAxes' => [
                [
                    'ticks' => [
                        'autoSkip' => false
                    ]
                ]
            ]
        ]
    ];

    $chartUrl2 = 'https://quickchart.io/chart?' . http_build_query([
        'c' => json_encode([
            'type' => 'bar',
            'data' => [
                'labels' => $riesgo2,
                'datasets' => $grafica_data2
            ],
            'options' => $grafica_options2,
        ])
    ]);

    // Obtener la imagen en formato PNG desde la URL de QuickChart
    $Imagen_Grafica2 = base64_encode(file_get_contents($chartUrl2));
    file_put_contents('MostrarPDF/Imagen_Grafica2.png', file_get_contents($chartUrl2));


    //////////////////////////// TAMAÑO DE LA MATRIZ  ////////////////////////////////////////////
    $consultalabelshorizontales = $mysqli->query("SELECT * FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
    $consultamatriz = $mysqli->query("SELECT f_dimension_matriz() AS Matriz");
    $extraerDatos = $consultamatriz->fetch_array(MYSQLI_ASSOC);
    $tamano_matriz = $extraerDatos['Matriz'];
    $color_matriz =  $extraerDatos['id_alfanumerico'];

    $filas = $tamano_matriz;
    $columnas = $tamano_matriz;
    $textoF = strval($filas + 1);
    $textoC = strval($filas + 3);
    $numero = 1;
    //////////////////////////// END TAMAÑO DE LA MATRIZ  ////////////////////////////////////////////
    /////////////////////////// PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////
    $tabla = "<table border='1' width='100%' height='60%'>";
    $color_actual = ' ';
    $tabla .= "<th colspan='2' style='background-color:#00E0FF'><h2><h2></th>";
    $tabla .= "<th style='background-color:#00E0FF;'><h3>Impacto o Intensidad<h3></th>";
    $tabla .= "<tr>";
    $tabla .= "";
    /////////////////////////// END PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////
    $consultaFilas = $mysqli->query("SELECT D.nombre,D.identificador ,COUNT(D.identificador) AS Cantidad FROM mat_filas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY `D`.`identificador` DESC");
    $tabla .= "<td class='verticalText' style='background-color:#00E0FF;width: 50px;' colspan='1' rowspan='$textoC'>
                <h3>
                    <center>Probabilidad(%)</center>
                </h3>
                ";
    /* <table>
                $consultalabelshorizontales = $mysqli->query("SELECT id_alfanumerico FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
    $consultarangos = $mysqli->query("SELECT nombre ,COUNT(nombre) Cantidad FROM mat_filas  C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador DESC");
    $colores = array();
    $num = 0;
    while ($extraerColores = $consultalabelshorizontales->fetch_array()) {
        $colores[] =$extraerColores['id_alfanumerico'];
    }
    while ($extraermatcolumnas = $consultarangos->fetch_array()) {
        $num++;
        $extraermatcolumnas['Cantidad'] . '-' . $extraermatcolumnas['nombre'];
        $ancho = $extraermatcolumnas['Cantidad']."%";
        $color = $colores[$num-1];
        $tabla .= "<td colspan='6' class='verticalTextB' style='background-color: $color;height: $ancho;border: 1px solid black;'><b>" . $extraermatcolumnas['nombre'] . "<b></td><tr>";
    }
    $tabla .= "</tr>";

    $tabla .= "</table>";
*/
    $consultalabelshorizontales = $mysqli->query("SELECT id_alfanumerico FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
    $consultaColumnas = $mysqli->query("SELECT D.identificador ,COUNT(D.identificador) AS Cantidad,D.nombre FROM mat_columnas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY D.identificador DESC");
    $colores = array();
    $num = 0;
    while ($extraerColores = $consultalabelshorizontales->fetch_array()) {
        $colores[] = $extraerColores['id_alfanumerico'];
    }
    $tabla .= "<td style='background-color:#00E0FF;width: 50px;' colspan='1'><b><center>Escala</center><b></td>";
    while ($extraerlongitudes = $consultaColumnas->fetch_array()) {
        $num++;
        $color = $colores[$num - 1];
        $tabla .= "<td style='background-color:$color;' colspan='" . $extraerlongitudes['Cantidad'] . "'><b><center>" . $extraerlongitudes['nombre'] . "</center><b></td>";
    }
    $tabla .= "<tr>";

    $numeracion = $filas;

    for ($i = 1; $i <= $filas; $i++) {

        $tabla .= "<tr>";

        for ($j = 0; $j <= $columnas; $j++) {


            $hay_color = $mysqli->query("SELECT MC.codigo,COUNT(1) AS Cantidad 
                                                                        FROM par_pintar_matriz PM,mat_colores MC
                                                                        WHERE fila='$i' 
                                                                        AND col_inicio_color = '$j'
                                                                        AND MC.identificador = PM.color
                                                                        GROUP BY MC.codigo;");
            $datocolor = $hay_color->fetch_array(MYSQLI_ASSOC);
            if ($j <= 0) {
                $colorCantidad = 1;
                $color = "#ffffff";
            }

            $colorCantidad = $datocolor['Cantidad'];
            $color = $datocolor['codigo'];

            if ($colorCantidad > 0) {
                $color_actual = $color;
            }
            $texto_celdas = $mysqli->query("SELECT f_texto_matriz($i,$j,$identificador) AS texto_matriz");
            $extraerDatosCelda = $texto_celdas->fetch_array(MYSQLI_ASSOC);
            $datoceldas = $extraerDatosCelda['texto_matriz'];

            $tabla .= "<td border='0' valign='top' style='background:$color_actual;font-size:10px' > " . $datoceldas . ' ' . "</td>";
            $numero++;
        }

        $tabla .= "</tr>";
    }
    $tabla .= "</table>";
} elseif ($origen == '3') {


    $consultaimagenportada = $mysqli->query("SELECT *,MIN(identificador) FROM enc_imagenes_inspeccion WHERE id_inspeccion = '$identificador'");
    $extraerRutaImagen = $consultaimagenportada->fetch_array(MYSQLI_ASSOC);
    $rutaImagen = $extraerRutaImagen['archivo'];

    $mysqli = new mysqli('185.212.71.204', 'u571892443_risk_hunter', '#6mL0I[Jd7ZW', 'u571892443_risk_hunter');

    $enc_inmuebles = $mysqli->query("SELECT * FROM enc_inmuebles WHERE id_encuesta= '$identificador'");

    $resultconvensiones = $mysqli->query("SELECT * FROM v_matriz_r_b WHERE id_inspeccion='$identificador' AND nr<>0");

    $resultcalificacionesriesgos = $mysqli->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion= '$identificador'");

    $consultatextolinderos = $mysqli->query("SELECT p_informe_obligatorio($identificador) AS InformeO");
    $extraerDatosTextoLindero = $consultatextolinderos->fetch_array(MYSQLI_ASSOC);
    $textofinlalinderos = $extraerDatosTextoLindero['InformeO'];

    $consultafuncionci = $mysqli->query("SELECT f_ci($identificador) AS f_ci");
    $extraerDatosfuncionCi = $consultafuncionci->fetch_array(MYSQLI_ASSOC);
    $f_ci = $extraerDatosfuncionCi['f_ci'];

    $consultaimagenes = $mysqli->query("SELECT * FROM enc_imagenes_inspeccion WHERE id_inspeccion='$identificador'");
    while ($extraerimagen = $consultaimagenes->fetch_array()) {
        $imagen = $extraerimagen['archivo'];
        $pie_de_pagina = $extraerimagen['pie_de_imagen'];
    }

    $consultavaloresdescripcioncolores = $mysqli->query("SELECT * FROM mat_colores WHERE valor_inicial_cr IS NOT NULL");

    $ColorRiesgo = '<table>
<thead>
    <tr>
        <td>Descripción DESDE FI</td>
        <td>Sugerencias</td>
    </tr>
</thead>
<tbody>';
    while ($extraerDatosdescripcioncolores = $consultavaloresdescripcioncolores->fetch_array()) {
        $ColorRiesgo .= '<tr>
        <th><button type="" style="background-color:' . $extraerDatosdescripcioncolores['codigo'] . '">' . $identificadorI = $extraerDatosdescripcioncolores['descripcion'] . '</button></th>
        <th><div style="background-color:' . $extraerDatosdescripcioncolores['codigo'] . '" class="campos_f">' . $identificadorI = ' ' . $extraerDatosdescripcioncolores['descripcion_texto_cr'] . '</div></th>
        </tr>';
    }

    $ColorRiesgo .= '</tbody>
</table>';


    $consultavaloresdescripcioncolores2 = $mysqli->query("SELECT * FROM mat_colores WHERE valor_inicial_nr IS NOT NULL");
    $ColorRiesgo2 = '<table>
<thead>
    <tr>
        <td>Descripción</td>
        <td>Sugerencias</td>
    </tr>
</thead>
<tbody>';
    while ($extraerDatosdescripcioncolores = $consultavaloresdescripcioncolores2->fetch_array()) {
        $ColorRiesgo2 .= '<tr>
        <th><button type="" style="background-color:' . $extraerDatosdescripcioncolores['codigo'] . '">' . $identificadorI = $extraerDatosdescripcioncolores['descripcion'] . '</button></th>
        <th><div style="background-color:' . $extraerDatosdescripcioncolores['codigo'] . '" class="campos_f">' . $identificadorI = ' ' . $extraerDatosdescripcioncolores['descripcion_texto_nr'] . '</div></th>
        </tr>';
    }

    $ColorRiesgo2 .= '</tbody>
</table>';


    $result = '<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>Descripción</th>
            <th></th>
            <th></th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>';
    while ($row = $enc_inmuebles->fetch_assoc()) {
        $result .= '<tr>
            <td></td>
            <td></td>
            <td>' . $row['descripcion'] . '</td>
            <td></td>
            <td></td>
            <td>' . $row['observaciones'] . '</td>
        </tr>';
    }
    $result .= '</tbody>
</table>';


    $resultcalificacionesriesgos2 = '<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>Descripción</th>
            <th></th>
            <th></th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>';
    while ($row = $resultcalificacionesriesgos->fetch_assoc()) {
        $resultcalificacionesriesgos2 .= '<tr>
            <td></td>
            <td></td>
            <td>' . $row['riesgo'] . '</td>
            <td></td>
            <td></td>
            <td>' . $row['cr'] . '</td>
        </tr>';
    }
    $resultcalificacionesriesgos2 .= '</tbody>
</table>';

    $convensiones = '<table>
    <thead>
        <tr>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>';
    while ($rowconvensiones = $resultconvensiones->fetch_assoc()) {
        $convensiones .= '<tr>
            <td>' . $rowconvensiones['dsp_riesgo'] . '</td>
        </tr>';
    }
    $convensiones .= '</tbody>
</table>';

    // Obtener Cordenadas de google maps
    $url = "https://maps.googleapis.com/maps/api/staticmap?center={$latitud},{$longitud}&zoom=15&size=640x640&markers=color:red%7Clabel:M%7C{$latitud},{$longitud}&key=AIzaSyBUdqwj6Cp2rVXv2RzGdXU40rZt8agrMNE";
    $imagenmapa = file_get_contents($url);
    file_put_contents('MostrarPDF/mapa.png', $imagenmapa);


    $dbHost = '185.212.71.204';
    $dbUsername = 'u571892443_risk_hunter';
    $dbPassword = '#6mL0I[Jd7ZW';
    $dbName = 'u571892443_risk_hunter';


    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // GRAFICA #1
    $resultgrafica = $db->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion = $identificador ORDER BY riesgo ASC");
    $grafica_data = [];

    $riesgo = [];
    $cr = [];
    $color_cr = [];
    if ($resultgrafica->num_rows > 0) {
        while ($row = $resultgrafica->fetch_assoc()) {
            $riesgo[] = utf8_encode($row['riesgo']);
            $cr[] = $row['cr'];
            $color_cr[] = $row['color_cr'];
        }
        $grafica_data[] = [
            'label' => $riesgo,
            'data' => $cr,
            'backgroundColor' => $color_cr
        ];
    } else {
        $grafica_data[] = [
            'label' => 'SIN DATOS',
            'data' => [0],
            'backgroundColor' => '#000000'
        ];
    }

    $grafica_options = [
        'title' => 'Nivel de riesgos',
        'width' => 250,
        'height' => 250,
        'legend' => [
            'display' => false
        ],
        'scales' => [
            'yAxes' => [
                [
                    'ticks' => [
                        'beginAtZero' => false,
                        'max' => 100
                    ]
                ]
            ],
            'xAxes' => [
                [
                    'ticks' => [
                        'autoSkip' => false
                    ]
                ]
            ]
        ]
    ];

    $chartUrl = 'https://quickchart.io/chart?' . http_build_query([
        'c' => json_encode([
            'type' => 'bar',
            'data' => [
                'labels' => $riesgo,
                'datasets' => $grafica_data
            ],
            'options' => $grafica_options,
        ])
    ]);

    // Obtener la imagen en formato PNG desde la URL de QuickChart
    $Imagen_Grafica = base64_encode(file_get_contents($chartUrl));
    file_put_contents('MostrarPDF/Imagen_Grafica.png', file_get_contents($chartUrl));

    // GRAFICA #2
    $resultgrafica2 = $db->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion = $identificador ORDER BY riesgo");
    $grafica_data2 = [];
    $riesgo2 = [];
    $nr = [];
    $color_nr = [];
    if ($resultgrafica2->num_rows > 0) {
        while ($row = $resultgrafica2->fetch_assoc()) {
            $riesgo2[] = utf8_encode($row['riesgo']);
            $nr[] = $row['nr'];
            $color_nr[] = $row['color_nr'];
        }
        $grafica_data2[] = [
            'label' => $riesgo2,
            'data' => $nr,
            'backgroundColor' => $color_nr
        ];
    } else {
        $grafica_data2[] = [
            'label' => 'SIN DATOS',
            'data' => [0],
            'backgroundColor' => '#000000'
        ];
    }

    $grafica_options2 = [
        'title' => 'Nivel de riesgos',
        'width' => 250,
        'height' => 250,
        'legend' => [
            'display' => false
        ],
        'scales' => [
            'yAxes' => [
                [
                    'ticks' => [
                        'beginAtZero' => false,
                        'max' => 100
                    ]
                ]
            ],
            'xAxes' => [
                [
                    'ticks' => [
                        'autoSkip' => false
                    ]
                ]
            ]
        ]
    ];

    $chartUrl2 = 'https://quickchart.io/chart?' . http_build_query([
        'c' => json_encode([
            'type' => 'bar',
            'data' => [
                'labels' => $riesgo2,
                'datasets' => $grafica_data2
            ],
            'options' => $grafica_options2,
        ])
    ]);

    // Obtener la imagen en formato PNG desde la URL de QuickChart
    $Imagen_Grafica2 = base64_encode(file_get_contents($chartUrl2));
    file_put_contents('MostrarPDF/Imagen_Grafica2.png', file_get_contents($chartUrl2));

    //////////////////////////// TAMAÑO DE LA MATRIZ  ////////////////////////////////////////////
    $consultalabelshorizontales = $mysqli->query("SELECT * FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
    $consultamatriz = $mysqli->query("SELECT f_dimension_matriz() AS Matriz");
    $extraerDatos = $consultamatriz->fetch_array(MYSQLI_ASSOC);
    $tamano_matriz = $extraerDatos['Matriz'];

    $filas = $tamano_matriz;
    $columnas = $tamano_matriz;
    $textoF = strval($filas + 1);
    $textoC = strval($filas + 3);
    $numero = 1;
    //////////////////////////// END TAMAÑO DE LA MATRIZ  ////////////////////////////////////////////
    /////////////////////////// PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////
    $tabla = "<table border='1' width='80%' height='60%'>";
    $color_actual = ' ';
    $tabla .= "<th colspan='4' style='background-color:#00E0FF'><h2><h2></th>";
    $tabla .= "<th colspan='$textoF+$columnas' style='background-color:#00E0FF'><h3>Impacto o Intensidad<h3></th>";
    $tabla .= "<tr>";
    $tabla .= "";
    /////////////////////////// END PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////
    $consultaFilas = $mysqli->query("SELECT D.nombre,D.identificador ,COUNT(D.identificador) AS Cantidad FROM mat_filas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY `D`.`identificador` DESC");
    $tabla .= "   <td class='verticalText' style='background-color:#00E0FF' colspan='3' rowspan='$textoC'>
                <h3>
                    <center>Probabilidad(%)</center>
                </h3>
            </td>
            <td rowspan='$textoC' bgcolor='#00E0FF'>
                <table>";

    $consultalabelshorizontales = $mysqli->query("SELECT id_alfanumerico FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
    $consultarangos = $mysqli->query("SELECT DISTINCT nombre ,COUNT(nombre) Cantidad FROM mat_filas  C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador DESC");

    $colores = array();
    $num = 0;
    while ($extraerColores = $consultalabelshorizontales->fetch_array()) {
        $colores[] = $extraerColores['id_alfanumerico'];
    }
    while ($extraermatcolumnas = $consultarangos->fetch_array()) {
        $num++;
        $extraermatcolumnas['Cantidad'] . '-' . $extraermatcolumnas['nombre'];
        $ancho = $extraermatcolumnas['Cantidad'] . "%";
        $color = $colores[$num - 1];
        $tabla .= "<td colspan='6' class='verticalTextB' style='background-color: $color;height: $ancho;border: 1px solid black;'><b>" . $extraermatcolumnas['nombre'] . "<b></td><tr>";
    }

    $tabla .= "</tr>";

    $tabla .= "</table>
            </td>";

    $consultalabelshorizontales = $mysqli->query("SELECT id_alfanumerico FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
    $consultaColumnas = $mysqli->query("SELECT D.identificador ,COUNT(D.identificador) AS Cantidad,D.nombre FROM mat_columnas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY D.identificador DESC");
    $colores = array();
    $num = 0;
    while ($extraerColores = $consultalabelshorizontales->fetch_array()) {
        $colores[] = $extraerColores['id_alfanumerico'];
    }
    while ($extraerlongitudes = $consultaColumnas->fetch_array()) {
        $num++;
        $color = $colores[$num - 1];
        $tabla .= "<td colspan='" . $extraerlongitudes['Cantidad'] . "' style='background-color:$color;'><b><center>" . $extraerlongitudes['nombre'] . "</center><b></td>";
    }
    $tabla .= "<tr>";

    $numeracion = $filas;

    for ($i = 1; $i <= $filas; $i++) {

        $tabla .= "<tr>";

        for ($j = 1; $j <= $columnas; $j++) {

            $hay_color = $mysqli->query("SELECT MC.codigo,COUNT(1) AS Cantidad 
                                                                        FROM par_pintar_matriz PM,mat_colores MC
                                                                        WHERE fila='$i' 
                                                                        AND col_inicio_color = '$j'
                                                                        AND MC.identificador = PM.color
                                                                        GROUP BY MC.codigo;");
            $datocolor = $hay_color->fetch_array(MYSQLI_ASSOC);
            $colorCantidad = $datocolor['Cantidad'];
            $color = $datocolor['codigo'];
            if ($colorCantidad > 0) {
                $color_actual = $color;
            }
            $texto_celdas = $mysqli->query("SELECT f_texto_matriz($i,$j,$identificador) AS texto_matriz");
            $extraerDatosCelda = $texto_celdas->fetch_array(MYSQLI_ASSOC);
            $datoceldas = $extraerDatosCelda['texto_matriz'];

            $tabla .= "<td border='0' valign='top' style='background:$color_actual;font-size:10px' > " . $datoceldas . ' ' . "</td>";
            $numero++;
        }

        $tabla .= "</tr>";
    }
    $tabla .= "</table>";
} else {



    $consultaimagenportada = $mysqli->query("SELECT *,MIN(identificador) FROM enc_imagenes_inspeccion WHERE id_inspeccion = '$identificador'");
    $extraerRutaImagen = $consultaimagenportada->fetch_array(MYSQLI_ASSOC);
    $rutaImagen = $extraerRutaImagen['archivo'];

    $mysqli = new mysqli('185.212.71.204', 'u571892443_risk_hunter', '#6mL0I[Jd7ZW', 'u571892443_risk_hunter');

    $enc_inmuebles = $mysqli->query("SELECT * FROM enc_inmuebles WHERE id_encuesta= '$identificador'");

    $resultconvensiones = $mysqli->query("SELECT * FROM v_matriz_r_b WHERE id_inspeccion='$identificador' AND nr<>0");

    $resultcalificacionesriesgos = $mysqli->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion= '$identificador'");

    $consultatextolinderos = $mysqli->query("SELECT p_informe_obligatorio($identificador) AS InformeO");
    $extraerDatosTextoLindero = $consultatextolinderos->fetch_array(MYSQLI_ASSOC);
    $textofinlalinderos = $extraerDatosTextoLindero['InformeO'];

    $consultafuncionci = $mysqli->query("SELECT f_ci($identificador) AS f_ci");
    $extraerDatosfuncionCi = $consultafuncionci->fetch_array(MYSQLI_ASSOC);
    $f_ci = $extraerDatosfuncionCi['f_ci'];

    $consultaimagenes = $mysqli->query("SELECT * FROM enc_imagenes_inspeccion WHERE id_inspeccion='$identificador'");
    while ($extraerimagen = $consultaimagenes->fetch_array()) {
        $imagen = $extraerimagen['archivo'];
        $pie_de_pagina = $extraerimagen['pie_de_imagen'];
    }

    $consultavaloresdescripcioncolores = $mysqli->query("SELECT * FROM mat_colores WHERE valor_inicial_cr IS NOT NULL");

    $ColorRiesgo = '<table>
<thead>
    <tr>
        <td>Descripción DESDE IN</td>
        <td>Sugerencias</td>
    </tr>
</thead>
<tbody>';
    while ($extraerDatosdescripcioncolores = $consultavaloresdescripcioncolores->fetch_array()) {
        $ColorRiesgo .= '<tr>
        <th><button type="" style="background-color:' . $extraerDatosdescripcioncolores['codigo'] . '">' . $identificadorI = $extraerDatosdescripcioncolores['descripcion'] . '</button></th>
        <th><div class="campos_f">' . $identificadorI = ' ' . $extraerDatosdescripcioncolores['descripcion_texto_cr'] . '</div></th>
        </tr>';
    }

    $ColorRiesgo .= '</tbody>
</table>';


    $consultavaloresdescripcioncolores2 = $mysqli->query("SELECT * FROM mat_colores WHERE valor_inicial_nr IS NOT NULL");
    $ColorRiesgo2 = '<table>
<thead>
    <tr>
        <td>Descripción</td>
        <td>Sugerencias</td>
    </tr>
</thead>
<tbody>';
    while ($extraerDatosdescripcioncolores = $consultavaloresdescripcioncolores2->fetch_array()) {
        $ColorRiesgo2 .= '<tr>
        <th><button type="" style="background-color:' . $extraerDatosdescripcioncolores['codigo'] . '">' . $identificadorI = $extraerDatosdescripcioncolores['descripcion'] . '</button></th>
        <th><div class="campos_f">' . $identificadorI = ' ' . $extraerDatosdescripcioncolores['descripcion_texto_nr'] . '</div></th>
        </tr>';
    }

    $ColorRiesgo2 .= '</tbody>
</table>';


    $result = '<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>Descripción</th>
            <th></th>
            <th></th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>';
    while ($row = $enc_inmuebles->fetch_assoc()) {
        $result .= '<tr>
            <td></td>
            <td></td>
            <td>' . $row['descripcion'] . '</td>
            <td></td>
            <td></td>
            <td>' . $row['observaciones'] . '</td>
        </tr>';
    }
    $result .= '</tbody>
</table>';


    $resultcalificacionesriesgos2 = '<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th>Descripción</th>
            <th></th>
            <th></th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>';
    while ($row = $resultcalificacionesriesgos->fetch_assoc()) {
        $resultcalificacionesriesgos2 .= '<tr>
            <td></td>
            <td></td>
            <td>' . $row['riesgo'] . '</td>
            <td></td>
            <td></td>
            <td>' . $row['cr'] . '</td>
        </tr>';
    }
    $resultcalificacionesriesgos2 .= '</tbody>
</table>';

    $convensiones = '<table>
    <thead>
        <tr>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>';
    while ($rowconvensiones = $resultconvensiones->fetch_assoc()) {
        $convensiones .= '<tr>
            <td>' . $rowconvensiones['dsp_riesgo'] . '</td>
        </tr>';
    }
    $convensiones .= '</tbody>
</table>';

    // Obtener Cordenadas de google maps
    $url = "https://maps.googleapis.com/maps/api/staticmap?center={$latitud},{$longitud}&zoom=15&size=640x640&markers=color:red%7Clabel:M%7C{$latitud},{$longitud}&key=AIzaSyBUdqwj6Cp2rVXv2RzGdXU40rZt8agrMNE";
    $imagenmapa = file_get_contents($url);
    file_put_contents('MostrarPDF/mapa.png', $imagenmapa);


    $dbHost = '185.212.71.204';
    $dbUsername = 'u571892443_risk_hunter';
    $dbPassword = '#6mL0I[Jd7ZW';
    $dbName = 'u571892443_risk_hunter';


    $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // GRAFICA #1
    $resultgrafica = $db->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion = $identificador ORDER BY riesgo ASC");
    $grafica_data = [];
    $riesgo = [];
    $cr = [];
    $color_ncr = [];
    if ($resultgrafica->num_rows > 0) {
        while ($row = $resultgrafica->fetch_assoc()) {
            $riesgo[] = utf8_encode($row['riesgo']);
            $cr[] = $row['cr'];
            $color_cr[] = $row['color_cr'];
        }
        $grafica_data[] = [
            'label' => $riesgo,
            'data' => $cr,
            'backgroundColor' => $color_cr
        ];
    } else {
        $grafica_data[] = [
            'label' => 'SIN DATOS',
            'data' => [0],
            'backgroundColor' => '#000000'
        ];
    }

    $grafica_options = [
        'title' => 'Nivel de riesgos',
        'width' => 250,
        'height' => 250,
        'legend' => [
            'display' => false
        ],
        'scales' => [
            'yAxes' => [
                [
                    'ticks' => [
                        'beginAtZero' => false,
                        'max' => 100
                    ]
                ]
            ],
            'xAxes' => [
                [
                    'ticks' => [
                        'autoSkip' => false
                    ]
                ]
            ]
        ]
    ];

    $chartUrl = 'https://quickchart.io/chart?' . http_build_query([
        'c' => json_encode([
            'type' => 'bar',
            'data' => [
                'labels' => $riesgo,
                'datasets' => $grafica_data
            ],
            'options' => $grafica_options,
        ])
    ]);

    // Obtener la imagen en formato PNG desde la URL de QuickChart
    $Imagen_Grafica = base64_encode(file_get_contents($chartUrl));
    file_put_contents('MostrarPDF/Imagen_Grafica.png', file_get_contents($chartUrl));

    // GRAFICA #2
    $resultgrafica2 = $db->query("SELECT * FROM v_matriz_riesgos_x_inspeccion WHERE id_inspeccion = $identificador ORDER BY riesgo");
    $grafica_data2 = [];
    $riesgo2 = [];
    $nr = [];
    $color_nr = [];
    if ($resultgrafica2->num_rows > 0) {
        while ($row = $resultgrafica2->fetch_assoc()) {
            $riesgo2[] = utf8_encode($row['riesgo']);
            $nr[] = $row['nr'];
            $color_nr[] = $row['color_nr'];
        }
        $grafica_data2[] = [
            'label' => $riesgo2,
            'data' => $nr,
            'backgroundColor' => $color_nr
        ];
    } else {
        $grafica_data2[] = [
            'label' => 'SIN DATOS',
            'data' => [0],
            'backgroundColor' => '#000000'
        ];
    }

    $grafica_options2 = [
        'title' => 'Nivel de riesgos',
        'width' => 250,
        'height' => 250,
        'legend' => [
            'display' => false
        ],
        'scales' => [
            'yAxes' => [
                [
                    'ticks' => [
                        'beginAtZero' => false,
                        'max' => 100
                    ]
                ]
            ],
            'xAxes' => [
                [
                    'ticks' => [
                        'autoSkip' => false
                    ]
                ]
            ]
        ]
    ];

    $chartUrl2 = 'https://quickchart.io/chart?' . http_build_query([
        'c' => json_encode([
            'type' => 'bar',
            'data' => [
                'labels' => $riesgo2,
                'datasets' => $grafica_data2
            ],
            'options' => $grafica_options2,
        ])
    ]);


    // Obtener la imagen en formato PNG desde la URL de QuickChart
    $Imagen_Grafica2 = base64_encode(file_get_contents($chartUrl2));
    file_put_contents('MostrarPDF/Imagen_Grafica2.png', file_get_contents($chartUrl2));

    //////////////////////////// TAMAÑO DE LA MATRIZ  ////////////////////////////////////////////
    $consultalabelshorizontales = $mysqli->query("SELECT * FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
    $consultamatriz = $mysqli->query("SELECT f_dimension_matriz() AS Matriz");
    $extraerDatos = $consultamatriz->fetch_array(MYSQLI_ASSOC);
    $tamano_matriz = $extraerDatos['Matriz'];

    $filas = $tamano_matriz;
    $columnas = $tamano_matriz;
    $textoF = strval($filas + 1);
    $textoC = strval($filas + 3);
    $numero = 1;
    //////////////////////////// END TAMAÑO DE LA MATRIZ  ////////////////////////////////////////////
    /////////////////////////// PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////
    $tabla = "<table border='1' width='80%' height='60%'>";
    $color_actual = ' ';
    $tabla .= "<th colspan='4' style='background-color:#00E0FF'><h2><h2></th>";
    $tabla .= "<th colspan='$textoF+$columnas' style='background-color:#00E0FF'><h3>Impacto o Intensidad<h3></th>";
    $tabla .= "<tr>";
    $tabla .= "";
    /////////////////////////// END PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////
    $consultaFilas = $mysqli->query("SELECT D.nombre,D.identificador ,COUNT(D.identificador) AS Cantidad FROM mat_filas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY `D`.`identificador` DESC");
    $tabla .= "   <td class='verticalText' style='background-color:#00E0FF' colspan='3' rowspan='$textoC'>
                <h3>
                    <center>Probabilidad(%)</center>
                </h3>
            </td>
            <td rowspan='$textoC' bgcolor='#00E0FF'>
                <table>";
    $consultalabelshorizontales = $mysqli->query("SELECT id_alfanumerico FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
    $consultarangos = $mysqli->query("SELECT DISTINCT nombre ,COUNT(nombre) Cantidad FROM mat_filas  C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador DESC");
    $colores = array();
    $num = 0;
    while ($extraerColores = $consultalabelshorizontales->fetch_array()) {
        $colores[] = $extraerColores['id_alfanumerico'];
    }
    while ($extraermatcolumnas = $consultarangos->fetch_array()) {
        $num++;
        $extraermatcolumnas['Cantidad'] . '-' . $extraermatcolumnas['nombre'];
        $ancho = $extraermatcolumnas['Cantidad'] . "%";
        $color = $colores[$num - 1];
        $tabla .= "<td colspan='6' class='verticalTextB' style='background-color: $color;height: $ancho;border: 1px solid black;'><b>" . $extraermatcolumnas['nombre'] . "<b></td><tr>";
    }

    $tabla .= "</tr>";

    $tabla .= "</table>
            </td>";

    $consultalabelshorizontales = $mysqli->query("SELECT id_alfanumerico FROM cg_valores_dominio WHERE id_dominio=34 ORDER BY cg_valores_dominio.identificador DESC;");
    $consultaColumnas = $mysqli->query("SELECT D.identificador ,COUNT(D.identificador) AS Cantidad,D.nombre FROM mat_columnas C ,cg_valores_dominio D WHERE C.vdom_calificacion = D.identificador GROUP BY D.identificador ORDER BY D.identificador DESC");
    $colores = array();
    $num = 0;
    while ($extraerColores = $consultalabelshorizontales->fetch_array()) {
        $colores[] = $extraerColores['id_alfanumerico'];
    }
    while ($extraerlongitudes = $consultaColumnas->fetch_array()) {
        $num++;
        $color = $colores[$num - 1];
        $tabla .= "<td colspan='" . $extraerlongitudes['Cantidad'] . "' style='background-color: $color;'><b><center>" . $extraerlongitudes['nombre'] . "</center><b></td>";
    }

    $tabla .= "<tr>";

    $numeracion = $filas;

    for ($i = 1; $i <= $filas; $i++) {

        $tabla .= "<tr>";

        for ($j = 1; $j <= $columnas; $j++) {

            $hay_color = $mysqli->query("SELECT MC.codigo,COUNT(1) AS Cantidad 
                                                                        FROM par_pintar_matriz PM,mat_colores MC
                                                                        WHERE fila='$i' 
                                                                        AND col_inicio_color = '$j'
                                                                        AND MC.identificador = PM.color
                                                                        GROUP BY MC.codigo;");
            $datocolor = $hay_color->fetch_array(MYSQLI_ASSOC);
            $colorCantidad = $datocolor['Cantidad'];
            $color = $datocolor['codigo'];
            if ($colorCantidad > 0) {
                $color_actual = $color;
            }
            $texto_celdas = $mysqli->query("SELECT f_texto_matriz($i,$j,$identificador) AS texto_matriz");
            $extraerDatosCelda = $texto_celdas->fetch_array(MYSQLI_ASSOC);
            $datoceldas = $extraerDatosCelda['texto_matriz'];

            $tabla .= "<td border='0' valign='top' style='background:$color_actual;font-size:10px' > " . $datoceldas . ' ' . "</td>";
            $numero++;
        }

        $tabla .= "</tr>";
    }
    $tabla .= "</table>";
}

/////////////////////////// END PINTA LOS TITULOS MAS EXTERNOS DE LA MATRIZ ARRIBA /////////////////////////

// LIBRERIA DE DOMPDF

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set([
    'isPhpEnabled' => true,
    'isHtml5ParserEnabled' => false,
    'isRemoteEnabled' => true,
    'isJavascriptEnabled' => true,
    'isFontSubsettingEnabled' => true,
    'enable_css_float' => true,
    'enable_html5_parser' => true,
    'enable_remote' => true,
    'enable_javascript' => true,
    'images' => true,
    'enable_fontsubsetting' => true,
    'enable_php' => true
]);

// Creamos una instancia de Dompdf y cargamos el HTML a convertir a PDF

$dompdf = new Dompdf($options);

ob_start();

include 'MostrarPDF/index.php';

$html = ob_get_clean();

$html = str_replace('%inspeccion%', $inspeccion, $html);
$html = str_replace('%identificador%', $identificador, $html);
$html = str_replace('%firmainspectora%', $firmainspectora, $html);
$html = str_replace('%identificacion%', $identificacion, $html);
$html = str_replace('%tipodocumentosolicitante%', $tipodocumentosolicitante, $html);
$html = str_replace('%nombrepersonaatiende%', $nombrepersonaatiende, $html);
$html = str_replace('%fecha_elaboracion%', $fecha_elaboracion, $html);
$html = str_replace('%contactofirma%', $contactofirma, $html);
$html = str_replace('%pais%', $pais, $html);
$html = str_replace('%ciudad%', $ciudad, $html);
$html = str_replace('%direccion%', $direccion, $html);
$html = str_replace('%nombreedificacion%', $nombreedificacion, $html);
$html = str_replace('%nombrepersonaatiende%', $nombrepersonaatiende, $html);
$html = str_replace('%contactopersonaatiende%', $contactopersonaatiende, $html);
$html = str_replace('%inspectorasignado%', $inspectorasignado, $html);
$html = str_replace('%longitud%', $longitud, $html);
$html = str_replace('%latitud%', $latitud, $html);
$html = str_replace('%espaciogeografico%', $espaciogeografico, $html);
$html = str_replace('%estrato%', $estrato, $html);
$html = str_replace('%bloque_inspeccion%', $bloque_inspeccion, $html);
$html = str_replace('%fecha_terminacion%', $fecha_terminacion, $html);
$html = str_replace('%fecha_actualizacion%', $fecha_actualizacion, $html);
$html = str_replace('%textofinlalinderos%', $textofinlalinderos, $html);
$html = str_replace('%texto_informe%', $texto_informe, $html);
$html = str_replace('%rutaImagen%', $rutaImagen, $html);
$html = str_replace('%result%', $result, $html);
$html = str_replace('%Grafica%', $chartUrl, $html);
$html = str_replace('%Grafica_two%', $Imagen_Grafica2, $html);
$html = str_replace('%resultcalificacionesriesgos%', $resultcalificacionesriesgos2, $html);
$html = str_replace('%convensiones%', $convensiones, $html);
$html = str_replace('%iframe%', 'MostrarPDF/mapa.png', $html);
$html = str_replace('%imagen%', $imagen, $html);
$html = str_replace('%pie_de_pagina%', $pie_de_pagina, $html);
$html = str_replace('%tabla%', $tabla, $html);
$html = str_replace('%ColorRiesgo%', $ColorRiesgo, $html);
$html = str_replace('%ColorRiesgo2%', $ColorRiesgo2, $html);
$html = str_replace('%fci%', $f_ci, $html);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('ejemplo.pdf', array("Attachment" => false));

unlink('MostrarPDF/Imagen_Grafica.png');
unlink('MostrarPDF/Imagen_Grafica2.png');
unlink('MostrarPDF/mapa.png');
/**/