<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- CDN for chosen plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>

    <!-- CDN for CSS of chosen plugin -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .h7 {
            color: #868D92;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <?php
    include 'header-rh.php';
    include 'conexion/Conexion2.php';

    $proceso = $_POST['tipo_proceso'];



    //if($proceso == 'FR'){
    //    echo 'INSPECCION FR';
    //}else{

    'ENC' . $id_inspeccion = $_REQUEST["id_encuesta"];
    'BLOQ' . $id_bloque_inspeccion = $_REQUEST["id_bloque"];
    'PREG' . $ID = $_REQUEST["id_pregunta"];
    $html = null;
    $html2 = null;
    $connect = connect();
    $validar = $connect->query("CALL f_pintar_existentes(" . $id_inspeccion . "," . $id_bloque_inspeccion . ")");

    if ($validar->num_rows) {
        while ($row = $validar->fetch_assoc()) {
            switch ($row["tipo"]) {
                case 'text':
                    $html .= '<form id="formulary" method="post" onsubmit="return false"  enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';

                    $html .= '<b><p class="h7">Escriba la respuesta y pulse enter para continuar</p></b>';
                    $html .= '<input type="text" value="' . $row["respuesta_texto"] . '" name="respuesta" onkeypress="if (event.keyCode === 13) { if (this.value.trim() !== ``) { submitForm(); } else { alert(`El valor está vacío.`); } }" class="inp_med">';
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                    $connect = connect();

                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';
                    break;

                case 'date':
                    $html .= '<form id="formulary" method="post" onsubmit="return false"  enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';

                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';

                    $html .= '<b><p class="h7">Escriba la respuesta y pulse enter para continuar</p></b>';
                    $date = date_create($row["respuesta_texto"]);
                    $html .= '<input type="date" value="' . date_format($date, "Y-m-d") . '" name="respuesta" onkeypress="if (event.keyCode === 13) { if (this.value.trim() !== ``) { submitForm(); } else { alert(`El valor está vacío.`); } }" class="inp_med">';
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                    $connect = connect();
                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';
                    break;

                case 'number':
                    $html .= '<form id="formulary" method="post" onsubmit="return false"  enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';

                    $html .= '<b><p class="h7">Escriba la respuesta y pulse enter para continuar</p></b>';
                    $html .= '<input type="number" step="0.01" value="' . $row["respuesta_texto"] . '" name="respuesta" onkeypress="if (event.keyCode === 13) { if (this.value.trim() !== ``) { submitForm(); } else { alert(`El valor está vacío.`); } }" class="inp_med">';
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                    $connect = connect();
                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';
                    break;

                case 'check':
                    $html .= '<form id="formulary" method="post" onsubmit="return false"  enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';
                    $html .= '<select name="respuesta" id="check_primary" multiple>';
                    $connect = connect();
                    $responseDataSelect = $connect->query("select enc_lista_valores.identificador as id_valores,enc_lista_valores.valor_alfa_numerico from enc_preguntas,enc_respuestas,enc_lista_valores,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.identificador = enc_lista_valores.id_respuesta AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.identificador ='" . $row["identificador"] . "' ORDER BY enc_lista_valores.valor_alfa_numerico ASC");
                    $separada = explode(',', $row["respuesta_texto"]);

                    while ($rows = $responseDataSelect->fetch_assoc()) {
                        $selected = '';
                        for ($i = 0; $i < count($separada); $i++) {
                            if ($separada[$i] == $rows['valor_alfa_numerico']) {
                                $selected = 'selected';
                            }
                        }
                        $html .= '<option value="' . $rows["valor_alfa_numerico"] . '" ' . $selected . '>' . str_replace('"', '', $rows["valor_alfa_numerico"]) . '</option>';
                    }
                    $html .= '</select>';
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="button" id="Verificar" value="Continuar" style="background-color: #008CBA;color: white;" />';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';
                    break;

                case 'radio':
                    $html .= '<form id="formulary" method="post" onsubmit="return false"  enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';
                    $connect = connect();
                    $responseDataSelect = $connect->query("select enc_lista_valores.identificador as id_valores,enc_lista_valores.valor_alfa_numerico from enc_preguntas,enc_respuestas,enc_lista_valores,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.identificador = enc_lista_valores.id_respuesta AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.identificador ='" . $row["identificador"] . "' ORDER BY enc_lista_valores.valor_alfa_numerico ASC");
                    while ($rows = $responseDataSelect->fetch_assoc()) {
                        $html .= "<label><input type='radio' name='respuesta' onclick='submitForm();' value=" . $rows["valor_alfa_numerico"] . "" . (($rows["valor_alfa_numerico"] == $row["respuesta_texto"]) ? ' checked="checked"' : '') . ">" . $rows["valor_alfa_numerico"] . "</label>";
                    }
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';

                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';

                    break;

                case 'select':
                    $html .= '<form id="formulary" method="post" onsubmit="return false"  enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';
                    $html .= '<select name="respuesta" onchange="submitForm()" required>';
                    $html .= '<option selected disabled>Seleccione una opcion</option>';
                    $connect = connect();
                    $responseDataSelect = $connect->query("select enc_lista_valores.identificador as id_valores,enc_lista_valores.valor_alfa_numerico from enc_preguntas,enc_respuestas,enc_lista_valores,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.identificador = enc_lista_valores.id_respuesta AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.identificador ='" . $row["identificador"] . "' ORDER BY enc_lista_valores.valor_alfa_numerico ASC");
                    while ($rows = $responseDataSelect->fetch_assoc()) {
                        $html .= "<option value=" . $rows["valor_alfa_numerico"] . " " . (($rows["valor_alfa_numerico"] == $row["respuesta_texto"]) ? ' selected="selected"' : '') . ">" . $rows["valor_alfa_numerico"] . "</option>";
                    }

                    $html .= '</select>';
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';

                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';

                    break;

                default:
                    echo "<h1>Lo siento no existe datos</h1>";
                    break;
            }
        }
    } else {
        $html = primera_pregunta($ID, $id_inspeccion, $id_bloque_inspeccion, $html);
    }

    function primera_pregunta($ID, $id_inspeccion, $id_bloque_inspeccion, $html)
    {
        $connect = connect();
        $result = $connect->query("CALL f_pintar_primera_pregunta(" . $ID . ")");

        while ($row = $result->fetch_assoc()) {
            switch ($row["tipo"]) {
                case 'text':
                    $html .= '<form id="formulary" method="post" enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';
                    $html .= '<input type="text" class="inp_med" name="respuesta" id="result_primary">';
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                    $connect = connect();
                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';
                    break;

                case 'date':
                    $html .= '<form id="formulary" method="post" enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';
                    $html .= '<input type="date" class="inp_med" name="respuesta" id="result_primary">';
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                    $connect = connect();
                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';
                    break;

                case 'number':
                    $html .= '<form id="formulary" method="post" enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';
                    $html .= '<input type="number" step="0.01" class="inp_med" name="respuesta" id="result_primary">';
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                    $connect = connect();
                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';
                    break;

                case 'check':
                    $html .= '<form id="formulary" method="post" enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';
                    $html .= '<select name="respuesta" id="check_primary" multiple>';
                    $connect = connect();
                    $responseDataSelect = $connect->query("select enc_lista_valores.identificador as id_valores,enc_lista_valores.valor_alfa_numerico from enc_preguntas,enc_respuestas,enc_lista_valores,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.identificador = enc_lista_valores.id_respuesta AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.identificador ='" . $row["identificador"] . "' ORDER BY enc_lista_valores.valor_alfa_numerico ASC");
                    while ($rows = $responseDataSelect->fetch_assoc()) {
                        $html .= '<option value="' . $rows["valor_alfa_numerico"] . '">' . str_replace('"', '', $rows["valor_alfa_numerico"]) . '</option>';
                    }
                    $html .= '</select>';
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="button" id="Verificar" value="Continuar" style="background-color: #008CBA;color: white;" />';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                    $connect = connect();
                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';
                    break;

                case 'radio':
                    $html .= '<form id="formulary" method="post" onsubmit="return false"  enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';
                    $connect = connect();
                    $responseDataSelect = $connect->query("select enc_lista_valores.identificador as id_valores,enc_lista_valores.valor_alfa_numerico from enc_preguntas,enc_respuestas,enc_lista_valores,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.identificador = enc_lista_valores.id_respuesta AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.identificador ='" . $row["identificador"] . "' ORDER BY enc_lista_valores.valor_alfa_numerico ASC");
                    while ($rows = $responseDataSelect->fetch_assoc()) {
                        $html .= "<label><input type='radio' name='respuesta' onclick='submitForm();' value=" . $rows["valor_alfa_numerico"] . ">" . $rows["valor_alfa_numerico"] . "</label>";
                    }
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';

                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';

                    break;

                case 'select':
                    $html .= '<form id="formulary" method="post" enctype="multipart/form-data">';
                    $html .= '<div class="contenedor">';
                    $html .= '<div class="campos-p pregunta">';
                    $html .= '<label>' . $row["pregunta"] . '</label>';
                    if (isset($row["ayuda"])) {
                        $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                    }
                    $html .= '</div>';
                    $html .= '<div class="campos-p">';
                    $html .= '<select name="respuesta" id="result_primary">';
                    $html .= '<option selected disabled>Seleccione una opcion</option>';
                    $connect = connect();
                    $responseDataSelect = $connect->query("select enc_lista_valores.identificador as id_valores,enc_lista_valores.valor_alfa_numerico from enc_preguntas,enc_respuestas,enc_lista_valores,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.identificador = enc_lista_valores.id_respuesta AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.identificador ='" . $row["identificador"] . "' ORDER BY enc_lista_valores.valor_alfa_numerico ASC");
                    while ($rows = $responseDataSelect->fetch_assoc()) {
                        $html .= '<option value="' . $rows["valor_alfa_numerico"] . '">' . $rows["valor_alfa_numerico"] . '</option>';
                    }
                    $html .= '</select>';
                    $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                    $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                    $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                    $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                    $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                    $html .= '<input type="file" name="fileinput" id="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                    $PedirDetalleBienes = $connect->query("SELECT f_pedir_detalle_bienes(" . $row["identificador"] . ") as result");
                    while ($result = $PedirDetalleBienes->fetch_assoc()) {
                        if ($result["result"] > 0) {
                            $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                            $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                        }
                    }
                    $html .= '</div>';
                    $html .= '</div>';
                    $html .= '</form>';

                    break;

                default:
                    echo "<h1>Lo siento no existe datos</h1>";
                    break;
            }
            return $html;
        }
    }

    ?>

    <script>
        $(document).ready(function() {
            $("select").chosen();
            $(document).on('DOMSubtreeModified', 'select', function() {
                $(this).chosen();
            });

            $('input[id=result_primary]').keypress(function(e) {
                if (e.keyCode == 13) {

                    var activeInput = document.activeElement;
                    var formData = $(activeInput).closest('form');
                    var form_data = new FormData();
                    var array = [];

                    form_data.append("fileinput", $(formData[0][6]).prop("files") ? $(formData[0][6]).prop(
                        "files") : null);

                    for (let index = 0; index < formData.serialize().split('&').length; index++) {
                        (formData.serialize().split('&')[index].split("respuesta=")[1]) ? array.push(
                            formData.serialize().split('&')[index].split("respuesta=")[1]): '';
                        (formData.serialize().split('&')[index].split("id_inspeccion=")[1]) ? form_data
                            .append("id_inspeccion", formData.serialize().split('&')[index].split(
                                "id_inspeccion=")[1]): undefined;
                        (formData.serialize().split('&')[index].split("idrestpt=")[1]) ? form_data.append(
                                "idrestpt", formData.serialize().split('&')[index].split("idrestpt=")[1]):
                            undefined;
                        (formData.serialize().split('&')[index].split("id_bloque_inspeccion=")[1]) ?
                        form_data.append("id_bloque_inspeccion", formData.serialize().split('&')[index]
                            .split("id_bloque_inspeccion=")[1]): undefined;
                        (formData.serialize().split('&')[index].split("identificador=")[1]) ? form_data
                            .append("identificador", formData.serialize().split('&')[index].split(
                                "identificador=")[1]): undefined;
                        (formData.serialize().split('&')[index].split("codigo=")[1]) ? form_data.append(
                                "codigo", formData.serialize().split('&')[index].split("codigo=")[1]):
                            undefined;
                    }
                    form_data.append("respuesta", JSON.stringify(decodeURI(array)).replace(/^\w\s/gi, ""));

                    $.ajax({
                        method: "POST",
                        url: "funcioness/obtenerInputDinamic2.php",
                        data: form_data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#ResponseAjax').append(response);
                        },
                        error: function(error) {
                            alert('Internal error: ' + error.responseText);
                            location.reload();
                        }
                    });

                    return false;
                }
            });

            $('select[id=result_primary]').change(function(e) {
                e.preventDefault();

                var activeInput = document.activeElement;
                var formData = $(activeInput).closest('form');
                var form_data = new FormData();
                var array = [];

                form_data.append("fileinput", $(formData[0][6]).prop("files") ? $(formData[0][6]).prop(
                    "files") : null);

                for (let index = 0; index < formData.serialize().split('&').length; index++) {
                    (formData.serialize().split('&')[index].split("respuesta=")[1]) ? array.push(formData
                        .serialize().split('&')[index].split("respuesta=")[1]): '';
                    (formData.serialize().split('&')[index].split("id_inspeccion=")[1]) ? form_data.append(
                        "id_inspeccion", formData.serialize().split('&')[index].split("id_inspeccion=")[
                            1]): undefined;
                    (formData.serialize().split('&')[index].split("idrestpt=")[1]) ? form_data.append(
                            "idrestpt", formData.serialize().split('&')[index].split("idrestpt=")[1]):
                        undefined;
                    (formData.serialize().split('&')[index].split("id_bloque_inspeccion=")[1]) ? form_data
                        .append("id_bloque_inspeccion", formData.serialize().split('&')[index].split(
                            "id_bloque_inspeccion=")[1]): undefined;
                    (formData.serialize().split('&')[index].split("identificador=")[1]) ? form_data.append(
                        "identificador", formData.serialize().split('&')[index].split("identificador=")[
                            1]): undefined;
                    (formData.serialize().split('&')[index].split("codigo=")[1]) ? form_data.append(
                        "codigo", formData.serialize().split('&')[index].split("codigo=")[1]): undefined;
                }
                form_data.append("respuesta", JSON.stringify(decodeURI(array)).replace(/^\w\s/gi, ""));

                $.ajax({
                    method: "POST",
                    url: "funcioness/obtenerInputDinamic2.php",
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#ResponseAjax').append(response);
                    },
                    error: function(error) {
                        alert('Internal error: ' + error.responseText);
                        location.reload();
                    }
                });

            });

            $("input[id=Verificar]").click(function() {

                var activeInput = document.activeElement;
                var formData = $(activeInput).closest('form');
                var form_data = new FormData();
                var array = [];

                form_data.append("fileinput", $(formData[0][6]).prop("files") ? $(formData[0][6]).prop(
                    "files") : null);

                for (let index = 0; index < formData.serialize().split('&').length; index++) {
                    (formData.serialize().split('&')[index].split("respuesta=")[1]) ? array.push(formData
                        .serialize().split('&')[index].split("respuesta=")[1]): '';
                    (formData.serialize().split('&')[index].split("id_inspeccion=")[1]) ? form_data.append(
                        "id_inspeccion", formData.serialize().split('&')[index].split("id_inspeccion=")[
                            1]): undefined;
                    (formData.serialize().split('&')[index].split("idrestpt=")[1]) ? form_data.append(
                            "idrestpt", formData.serialize().split('&')[index].split("idrestpt=")[1]):
                        undefined;
                    (formData.serialize().split('&')[index].split("id_bloque_inspeccion=")[1]) ? form_data
                        .append("id_bloque_inspeccion", formData.serialize().split('&')[index].split(
                            "id_bloque_inspeccion=")[1]): undefined;
                    (formData.serialize().split('&')[index].split("identificador=")[1]) ? form_data.append(
                        "identificador", formData.serialize().split('&')[index].split("identificador=")[
                            1]): undefined;
                    (formData.serialize().split('&')[index].split("codigo=")[1]) ? form_data.append(
                        "codigo", formData.serialize().split('&')[index].split("codigo=")[1]): undefined;
                }
                form_data.append("respuesta", JSON.stringify(decodeURI(array)).replace(/^\w\s/gi, ""));

                $.ajax({
                    method: "POST",
                    url: "funcioness/obtenerInputDinamic2.php",
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#ResponseAjax').append(response);
                    },
                    error: function(error) {
                        alert('Internal error: ' + error.responseText);
                        location.reload();
                    }
                });

            });
        });

        function SelectAjaxResponse(identificador, id_inspeccion, id_bloque_inspeccion, valor_respuesta_ant) {
            console.log(valor_respuesta_ant);
            $.ajax({
                type: "POST",
                url: "funcioness/obtenerInputDinamic2.php",
                data: {
                    "id": identificador,
                    "inspeccion": id_inspeccion,
                    "bloque_inspeccion": id_bloque_inspeccion,
                    "valor": valor_respuesta_ant
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    alert('Internal error: ' + error.responseText);
                    location.reload();
                }
            });

        }

        function submitForm() {

            var activeInput = document.activeElement;
            var formData = $(activeInput).closest('form');
            var form_data = new FormData();
            var array = [];

            form_data.append("fileinput", $(formData[0][6]).prop("files") ? $(formData[0][6]).prop("files") : null);
            for (let index = 0; index < formData.serialize().split('&').length; index++) {

                (formData.serialize().split('&')[index].split("respuesta=")[1]) ? array.push(formData.serialize().split(
                    '&')[index].split("respuesta=")[1]): undefined;
                (formData.serialize().split('&')[index].split("id_inspeccion=")[1]) ? form_data.append("id_inspeccion",
                    formData.serialize().split('&')[index].split("id_inspeccion=")[1]): undefined;
                (formData.serialize().split('&')[index].split("idrestpt=")[1]) ? form_data.append("idrestpt", formData
                    .serialize().split('&')[index].split("idrestpt=")[1]): undefined;
                (formData.serialize().split('&')[index].split("id_bloque_inspeccion=")[1]) ? form_data.append(
                        "id_bloque_inspeccion", formData.serialize().split('&')[index].split("id_bloque_inspeccion=")[1]):
                    undefined;
                (formData.serialize().split('&')[index].split("identificador=")[1]) ? form_data.append("identificador",
                    formData.serialize().split('&')[index].split("identificador=")[1]): undefined;
                (formData.serialize().split('&')[index].split("codigo=")[1]) ? form_data.append("codigo", formData
                    .serialize().split('&')[index].split("codigo=")[1]): undefined;
            }

            form_data.append("respuesta", JSON.stringify(decodeURIComponent(array)).replace(/^\w\s/gi, ""));

            $.ajax({
                method: "POST",
                url: "funcioness/obtenerInputDinamic2.php",
                data: form_data,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#ResponseAjax').append(response);

                    if (JSON.stringify(decodeURIComponent(array)).replace(/^\w\s/gi, "") == "N/A")
                        location.reload();

                },
                error: function(error) {
                    alert('Internal error: ' + error.responseText);
                    location.reload();
                },
            });

            setTimeout(() => {

                var duplicadoForms = [];
                $('#ResponseAjax form#formulary').each(function(index, element) {
                    duplicadoForms.push(element.outerHTML);
                });

                var duplicateForms = duplicadoForms.filter(function(form, index, self) {
                    return self.indexOf(form) !== self.lastIndexOf(form);
                });


                $('#ResponseAjax form#formulary').each(function(index, element) {
                    var outerHTML = element.outerHTML;
                    if (duplicateForms[outerHTML] === undefined) {
                        duplicateForms[outerHTML] = 1;
                    } else {
                        duplicateForms[outerHTML]++;
                    }
                    if (duplicateForms[outerHTML] > 1) {
                        $(element).remove();
                        duplicateForms[outerHTML]--;
                    }
                });


            }, 1200);

            if (formData.serialize().split('&')[0].split('=')[1] == 2) {

                $.ajax({
                    type: "POST",
                    url: "funcioness/obtenerInputDinamic2.php",
                    data: {
                        "estado": 1,
                        "codigo": formData.serialize().split('&')[1].split('=')[1],
                    },
                    success: function(response) {
                        $('#ResponseAjaxCild').append(response).hide();
                    },
                    error: function(error) {
                        alert('Internal error: ' + error.responseText);
                        location.reload();
                    }
                });



                setTimeout(() => {

                    var array1 = [];
                    var array2 = [];

                    $('#ResponseAjax form#formulary').each(function(index, element) {
                        array1.push(element.outerHTML);
                    });
                    $('#ResponseAjaxCild form#formulary').each(function(index, element) {
                        array2.push(element.outerHTML);
                    });

                    var duplicates = $.grep(array1, function(form) {
                        return $.inArray(form, array2) !== -1;
                    });

                    $('#ResponseAjax form#formulary').each(function(index, element) {
                        if ($.inArray(element.outerHTML, duplicates) !== -1) {
                            $(element).remove();
                        }
                    });

                    $('#ResponseAjaxCild form#formulary').each(function(index, element) {
                        $(element).remove();
                    });

                    // $('#ResponseAjax form#formulary').each(function(index, element) {
                    //  $(element).remove();
                    // });


                }, 1400);
            }


        }

        function close_tab() {
            window.close();
        }

        function PassPage() {
            var activeInput = document.activeElement;
            var formData = $(activeInput).closest('form');

            var id_inspeccion = formData.serialize().split('&')[1].split('=')[1];
            var id_bloque_inspeccion = formData.serialize().split('&')[2].split('=')[1];
            var id = formData.serialize().split('&')[4].split('=')[1];
            var idRespuest = formData.serialize().split('&')[3].split('=')[1];
            $.ajax({
                type: "POST",
                url: "funcioness/obtenerInputDinamic2.php",
                data: {
                    Consecutivo: 100,
                    identificador: id,
                    idrestpt: idRespuest,
                    id_inspeccion: id_inspeccion,
                    bloque_inspeccion: id_bloque_inspeccion
                },
                success: function(response) {
                    var consecutivoSQL = response;
                    window.open("detallebienes.php?id_pregunta=" + id + "&id_inspecion=" + id_inspeccion +
                        "&bloque_inspeccion=" + id_bloque_inspeccion + "&idres=" + idRespuest +
                        "&consecutivo=" + consecutivoSQL + "", "", "width=1150,height=700", "resizable=no");

                }
            });

        }
        $('#refreshButton').click(function(e) {
            e.preventDefault();
            // Mostramos una alerta
            alert('Has hecho clic en el botón.');

            // Actualizamos la página
            location.reload();
        });
    </script>
    <style>
        div.box {
            width: 200px;
            margin: 10px 50px;
            padding: 20px;
            background-color: #ffffff;
            color: #000;
        }

        /* Botón flotante */
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007BFF;
            color: #fff;
            padding: 12px 20px;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            text-decoration: none;
            z-index: 999;
            cursor: pointer;
        }

        .floating-button:hover {
            background-color: #0056b3;
        }

        .floating-button:active {
            background-color: #003f80;
        }
    </style>
    <div class="titulo_p">
        <form action="" method="post"></form>
        <div><i class="fa-solid fa-question"></i> Respuestas </div>
    </div>

    <div class="box">
        <h4>Inspeccion N° <?php echo $id_inspeccion; ?></h4>
        <h4> N° Inmueble <?php echo $id_bloque_inspeccion; ?></h4>
        <br>
        <h4> <?php echo $texto_version; ?></h4>
    </div>
    <?php

    if ($proceso == 'FR') {
        $id_inspeccion = $_REQUEST["id_encuesta"];
    ?>
        <div class="link_int">
            <div class="titulo2"> <a href="listarencabezadoencabezadofreemium">+Listar Encabezados Freemium</a></div>
        </div>
    <?php
    }
    ?>

    <div class="contenedor_titulos ">
        <div class="campos titulo">Registro de Respuesta</div>
    </div>


    <a href="#" id="refreshButton" class="floating-button">Refrescar</a>
    <?php echo $html; ?>
    <div id="ResponseAjax"></div>
    <div id="ResponseAjaxCild"></div>
    <div class="cont_fin">

        <?php
        if ($proceso == 'FR') {
            $id_inspeccion = $_REQUEST["id_encuesta"];
        ?>

            <form action="capturarubicacionB.php" target="_blank" method="POST">
                <input type="hidden" name="id_encuesta" value="<?php echo $id_inspeccion ?>">
                <input type="hidden" name="usuario_id" value=<?php echo $id_usuario_ext ?>>
                <input type="hidden" name="tipo_proceso" value="FR">
                <button type="submit" class="btn_azul" onClick="myFunction()" name="capturarubicacionfree">TERMINAR
                    INSPECCIÓN </button>
            </form>

            <script>
                function myFunction() {
                    alert("Por último, bríndanos información del Estrato y el Espacio Geográfico del Inmueble");
                    window.location.href = "menu.php";
                    //setTimeout("window.close('menu.php')", 3000)
                }
            </script>
        <?php
        } else {
        ?>
            <form action="controller/controllerpreguntas.php" method="POST">
                <?php
                $id_inspeccion = $_REQUEST["id_encuesta"];
                ?>
                <input type="hidden" name="id_inspeccion" value="<?php echo $id_inspeccion ?>">
                <input type="hidden" name="bloque_inspeccion" value="<?php echo $id_bloque_inspeccion ?>">
                <input type="hidden" name="id_usuario" value="<?php echo $id_menu_p ?>">

                <button type="submit" class="btn_azul" name="terminar">TERMINAR INSPECCIÓN FREMIUM</button>

            </form>
        <?php
        }
        ?>
    </div>
    <?php
    include 'footer.php';
    // }
    ?>

</body>

</html>