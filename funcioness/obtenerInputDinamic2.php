
<?php
/*error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
include '../clases/consultasbd.class.php';
if (isset($_REQUEST['Consecutivo'], $_REQUEST['identificador'], $_REQUEST['idrestpt'], $_REQUEST['id_inspeccion'])) {
    $p_pregunta_actual = $_REQUEST['identificador'];
    $id_respuesta = $_REQUEST['idrestpt'];
    $id_inspeccion = $_REQUEST['id_inspeccion'];
    $id_bloque_inspeccion = $_REQUEST['bloque_inspeccion'];
    GetConsecutivo($p_pregunta_actual, $id_respuesta, $id_inspeccion, $id_bloque_inspeccion);
}

if (isset($_REQUEST['id'], $_REQUEST['inspeccion'], $_REQUEST['bloque_inspeccion'], $_REQUEST['valor'])) {
    AjaxSelect($_REQUEST['valor'], $_REQUEST['id'], $_REQUEST['valor'], $_REQUEST['bloque_inspeccion']);
}


$p_codigo = $_REQUEST['codigo'];
$p_respuesta = str_replace('"', '', $_REQUEST['respuesta']);
$p_pregunta_actual = $_REQUEST['identificador'];
$id_respuesta = $_REQUEST['idrestpt'];
$id_inspeccion = $_REQUEST['id_inspeccion'];
$id_bloque_inspeccion = $_REQUEST['id_bloque_inspeccion'];

$p_archivos_tmp_name = ($_FILES['fileinput']["tmp_name"]) ? $_FILES['fileinput']["tmp_name"] : null;
$p_archivos = ($_FILES['fileinput']["name"]) ? $_FILES['fileinput']["name"] : null;

if (mkdir("../archivos/" . $id_inspeccion, 0777, true)) {
    echo "<script>console.log('Se creo la carpeta');</script>";
}
if ($p_archivos) {
    $extension = pathinfo($p_archivos, PATHINFO_EXTENSION);
    $p_archivo = "../archivos/" . $id_inspeccion . "/" . uniqid() . "." . $extension;
    move_uploaded_file($p_archivos_tmp_name, $p_archivo);
}


if ($_REQUEST['estado'] && $p_codigo) {
    CondicionalQuery($p_codigo);
} else {

    Consulta($p_codigo, $p_respuesta, $p_pregunta_actual, $id_inspeccion, $id_bloque_inspeccion);

    $consultasbdconsecutivo = new consultasbd;
    $consultasbdconsecutivo->iniciarVariables();
    $responseData = null;
    $response = $consultasbdconsecutivo->buscarExistsRegedit($id_inspeccion, $p_pregunta_actual, $id_respuesta);
    while ($row = $response->fetch_assoc()) {
        $responseData = $row['inspeccion'];
    }
    if ($responseData) {
        Update($id_inspeccion, $id_bloque_inspeccion, $p_respuesta, $p_pregunta_actual, $id_respuesta, $p_archivo);
    } else {
        Insert($id_inspeccion, $id_bloque_inspeccion, $p_respuesta, $p_pregunta_actual, $id_respuesta, $p_archivo);
    }
}


function Consulta($p_codigo, $p_respuesta, $p_pregunta_actual, $id_inspeccion, $id_bloque_inspeccion)
{
    foreach ($p_respuesta as $key => $value) {
        if ($key > 0) {
            $p_respuesta = $p_respuesta;
        } else {
            $p_respuesta = $value[$key];
        }
    }


    $consultasbd = new consultasbd;
    $consultasbd->iniciarVariables();
    $response = $consultasbd->buscarProcedimiento($p_codigo, $p_respuesta, $p_pregunta_actual, $id_inspeccion, $id_bloque_inspeccion);
    $result = null;
    $html = null;
    if ($response) {
        while ($row = $response->fetch_assoc()) {
            $result = $row['resultado'];
        }
        if ($result) {
            $responseData = $consultasbd->buscarProcedimientoResponse($result);
            while ($row = $responseData->fetch_assoc()) {
                switch ($row["tipo"]) {
                    case 'text':
                        $html .= '<form id="formulary" method="post" onsubmit="return false" enctype="multipart/form-data">';
                        $html .= '<div class="contenedor">';
                        $html .= '<div class="campos-p pregunta">';

                        $html .= '<label>' . $row["pregunta"] . '</label>';
                        if (isset($row["ayuda"])) {
                            $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                        }
                        $html .= '</div>';

                        $html .= '<div class="campos-p">';
                        $html .= '<b><p class="h7">Escriba la respuesta y pulse enter para continuar</p></b>';
                        $html .= '<input type="text" id="result1" name="respuesta" onkeypress="if (event.keyCode === 13) { if (this.value.trim() !== ``) { submitForm(); } else { alert(`El valor está vacío.`); } }" required>';
                        $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                        $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                        $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo">';
                        $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador">';
                        $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                        $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" id="fileinput">';
                        $consultasbd->iniciarVariables();
                        $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
                        while ($RESULTS = $PedirDetalleBienes->fetch_assoc()) {
                            if ($RESULTS["result"] > 0) {
                                $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                                $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                            }
                        }
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</form>';
                        break;
                    case 'date':
                        $html .= '<form id="formulary" method="post" onsubmit="return false" enctype="multipart/form-data">';
                        $html .= '<div class="contenedor">';
                        $html .= '<div class="campos-p pregunta">';

                        $html .= '<label>' . $row["pregunta"] . '</label>';
                        if (isset($row["ayuda"])) {
                            $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                        }
                        $html .= '</div>';
                        $html .= '<b><p class="h7">Escriba la respuesta y pulse enter para continuar</p></b>';
                        $html .= '<div class="campos-p">';
                        $html .= '<input type="date" id="result1" name="respuesta" onkeypress="if (event.keyCode === 13) { if (this.value.trim() !== ``) { submitForm(); } else { alert(`El valor está vacío.`); } }" required>';
                        $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                        $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                        $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo">';
                        $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador">';
                        $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                        $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" id="fileinput">';
                        $consultasbd->iniciarVariables();
                        $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
                        while ($RESULTS = $PedirDetalleBienes->fetch_assoc()) {
                            if ($RESULTS["result"] > 0) {
                                $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                                $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                            }
                        }
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</form>';
                        break;

                    case 'number':
                        $html .= '<form id="formulary" method="post" onsubmit="return false" enctype="multipart/form-data">';
                        $html .= '<div class="contenedor">';
                        $html .= '<div class="campos-p pregunta">';

                        $html .= '<label>' . $row["pregunta"] . '</label>';
                        if (isset($row["ayuda"])) {
                            $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                        }
                        $html .= '</div>';
                        $html .= '<b><p class="h7">Escriba la respuesta y pulse enter para continuar</p></b>';
                        $html .= '<div class="campos-p">';
                        $html .= '<input type="number" min="0" pattern="[0-9]" step="0.01" name="respuesta" onkeypress="if (event.keyCode === 13) { if (this.value.trim() !== ``) { submitForm(); } else { alert(`El valor está vacío.`); } }" required>';
                        $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                        $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                        $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo">';
                        $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador">';
                        $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                        $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" id="fileinput">';
                        $consultasbd->iniciarVariables();
                        $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
                        while ($RESULTS = $PedirDetalleBienes->fetch_assoc()) {
                            if ($RESULTS["result"] > 0) {
                                $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                                $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                            }
                        }
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</form>';
                        break;

                    case 'check':
                        $html .= '<form id="formulary" method="post" onsubmit="return false" enctype="multipart/form-data">';
                        $html .= '<div class="contenedor">';
                        $html .= '<div class="campos-p pregunta">';
                        $html .= '<label>' . $row["pregunta"] . '</label>';
                        if (isset($row["ayuda"])) {
                            $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                        }
                        $html .= '</div>';
                        $html .= '<div class="campos-p">';
                        $html .= '<select name="respuesta" id="check_primary" multiple>';
                        $consultasbd->iniciarVariables();
                        $responseDataSelect = $consultasbd->buscarProcedimientoResponseSelect($result);
                        while ($rows = $responseDataSelect->fetch_assoc()) {
                            $html .= '<option value="' . $rows["valor_alfa_numerico"] . '" >' . str_replace('"', '', $rows["valor_alfa_numerico"]) . '</option>';
                        }
                        $html .= '</select>';
                        $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                        $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                        $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" required>';
                        $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador">';
                        $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                        $html .= '<input type="button" id="Verificar" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;" />';
                        $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" id="fileinput">';
                        $consultasbd->iniciarVariables();
                        $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
                        while ($RESULTS = $PedirDetalleBienes->fetch_assoc()) {
                            if ($RESULTS["result"] > 0) {
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
                        $consultasbd->iniciarVariables();
                        $responseDataSelect = $consultasbd->buscarProcedimientoResponseSelect($result);
                        while ($rows = $responseDataSelect->fetch_assoc()) {
                            $html .= "<label><input type='radio' name='respuesta' onclick='submitForm();' value=" . $rows["valor_alfa_numerico"] . ">" . $rows["valor_alfa_numerico"] . "</label>";
                        }

                        $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                        $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                        $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                        $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                        $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                        $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                        $consultasbd->iniciarVariables();
                        $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
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
                        $html .= '<form id="formulary" method="post" onsubmit="return false" enctype="multipart/form-data">';
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
                        $responseDataSelect = $consultasbd->buscarProcedimientoResponseSelect($result);
                        while ($rows = $responseDataSelect->fetch_assoc()) {
                            $html .= '<option value="' . $rows["valor_alfa_numerico"] . '">' . $rows["valor_alfa_numerico"] . '</option>';
                        }
                        $html .= '</select>';
                        $html .= '<input type="hidden" value="' . $id_inspeccion . '" name="id_inspeccion" id="id_inspeccion">';
                        $html .= '<input type="hidden" value="' . $id_bloque_inspeccion . '" name="id_bloque_inspeccion" id="id_bloque_inspeccion">';
                        $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo">';
                        $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador">';
                        $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                        $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" id="fileinput">';
                        $consultasbd->iniciarVariables();
                        $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
                        while ($RESULTS = $PedirDetalleBienes->fetch_assoc()) {
                            if ($RESULTS["result"] > 0) {
                                $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                                $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                            }
                        }
                        $html .= '</div>';
                        $html .= '</div>';
                        $html .= '</form>';
                        break;

                    default:
                        $html .= '<div style="text-align: center;">';
                        $html .= '<input value="Enviar" style="background-color: #008CBA;color: white;width: 10%;">';
                        $html .= '</div>';
                        break;
                }
                echo $html;
            }
        } else {
            $html .= '<div style="text-align: center;">';
            $html .= '<h2>Pulse el botón Terminar</h2>';
            $html .= '</div>';
            echo $html;
        }
    }
}

function Update($id_inspeccion, $id_bloque_inspeccion, $p_respuesta, $p_pregunta_actual, $id_respuesta, $p_archivo)
{

    $consultasbdconsecutivo = new consultasbd;
    $consultasbdconsecutivo->iniciarVariables();
    $Consecutivo = null;
    $response = $consultasbdconsecutivo->buscarConsecutivoExists($id_inspeccion, $p_pregunta_actual, $id_respuesta);
    while ($row = $response->fetch_assoc()) {
        $Consecutivo = $row['consecutivo'];
    }

    $consultasbdconsecutivo = new consultasbd;
    $consultasbdconsecutivo->iniciarVariables();
    $id_valor_respuesta = null;
    $llave_foranea = null;
    $response = $consultasbdconsecutivo->SeachTextToNumber($p_pregunta_actual, $p_respuesta);
    while ($row = $response->fetch_assoc()) {
        $id_valor_respuesta = $row['id_valores'];
        $llave_foranea = $id_valor_respuesta;
    }

    $consultasbd = new consultasbd;
    $consultasbd->iniciarVariables();
    $consultasbd->UpdateAutoSave($id_inspeccion, $Consecutivo, $id_bloque_inspeccion, $p_respuesta, $p_pregunta_actual, $id_respuesta, $p_archivo, $id_valor_respuesta);
}

function Insert($id_inspeccion, $id_bloque_inspeccion, $p_respuesta, $p_pregunta_actual, $id_respuesta, $p_archivo)
{
    $consultasbdconsecutivo = new consultasbd;
    $consultasbdconsecutivo->iniciarVariables();
    $Consecutivo = null;
    $response = $consultasbdconsecutivo->buscarConsecutivo($id_inspeccion, $id_bloque_inspeccion);
    while ($row = $response->fetch_assoc()) {
        $Consecutivo = $row['resultado'];
    }

    $consultasbdconsecutivo = new consultasbd;
    $consultasbdconsecutivo->iniciarVariables();
    $id_valor_respuesta = null;
    $response = $consultasbdconsecutivo->SeachTextToNumber($p_pregunta_actual, $p_respuesta);
    while ($row = $response->fetch_assoc()) {
        $id_valor_respuesta = $row['id_valores'];
    }

    $consultasbd = new consultasbd;
    $consultasbd->iniciarVariables();
    $consultasbd->InsertAutoSave($id_inspeccion, $Consecutivo, $id_bloque_inspeccion, $p_respuesta, $p_pregunta_actual, $id_respuesta, $p_archivo, $id_valor_respuesta);
}

function CondicionalQuery($p_codigo)
{
    $consultasbd = new consultasbd;
    $consultasbd->iniciarVariables();
    $response = $consultasbd->CondicionalQuery($p_codigo);
    $html = "";
    while ($row = $response->fetch_assoc()) {
        switch ($row["tipo"]) {
            case 'text':
                $html .= '<form id="formulary">';
                $html .= '<div class="contenedor">';
                $html .= '<div class="campos-p pregunta">';
                $html .= '<label>' . $row["pregunta"] . '</label>';
                if (isset($row["ayuda"])) {
                    $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                }
                $html .= '</div>';
                $html .= '<div class="campos-p">';
                $html .= '<input type="text" id="result1" name="respuesta" required>';
                $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo">';
                $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador">';
                $html .= '<input type="hidden" value="' . $row["bloque_preguntas"] . '" name="bloque_preguntas">';
                $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                $html .= '<input type="button" value="Adicionar" onclick="submitForm()">';
                $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" id="fileinput">';
                $consultasbd->iniciarVariables();
                $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
                while ($RESULTS = $PedirDetalleBienes->fetch_assoc()) {
                    if ($RESULTS["result"] > 0) {
                        $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                        $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                    }
                }
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</form>';

                break;

            case 'date':
                $html .= '<form id="formulary">';
                $html .= '<div class="contenedor">';
                $html .= '<div class="campos-p pregunta">';
                $html .= '<label>' . $row["pregunta"] . '</label>';
                if (isset($row["ayuda"])) {
                    $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                }
                $html .= '</div>';
                $html .= '<div class="campos-p">';
                $html .= '<input type="date" id="result1" name="respuesta" required>';
                $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo">';
                $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador">';
                $html .= '<input type="hidden" value="' . $row["bloque_preguntas"] . '" name="bloque_preguntas">';
                $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                $html .= '<input type="button" value="Adicionar" onclick="submitForm()">';
                $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" id="fileinput">';
                $consultasbd->iniciarVariables();
                $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
                while ($RESULTS = $PedirDetalleBienes->fetch_assoc()) {
                    if ($RESULTS["result"] > 0) {
                        $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                        $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                    }
                }
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</form>';

                break;

            case 'number':
                $html .= '<form id="formulary">';
                $html .= '<div class="contenedor">';
                $html .= '<div class="campos-p pregunta">';
                $html .= '<label>' . $row["pregunta"] . '</label>';
                if (isset($row["ayuda"])) {
                    $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                }
                $html .= '</div>';
                $html .= '<div class="campos-p">';
                $html .= '<input type="number" min="0" step="0.01" pattern="[0-9]" name="respuesta" required>';
                $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo">';
                $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador">';
                $html .= '<input type="hidden" value="' . $row["bloque_preguntas"] . '" name="bloque_preguntas">';
                $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                $html .= '<input type="button" value="Adicionar" onclick="submitForm()">';
                $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" id="fileinput">';
                $consultasbd->iniciarVariables();
                $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
                while ($RESULTS = $PedirDetalleBienes->fetch_assoc()) {
                    if ($RESULTS["result"] > 0) {
                        $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                        $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                    }
                }
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</form>';

                break;

            case 'check':
                $html .= '<form id="formulary">';
                $html .= '<div class="contenedor">';
                $html .= '<div class="campos-p pregunta">';
                $html .= '<label>' . $row["pregunta"] . '</label>';
                if (isset($row["ayuda"])) {
                    $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                }
                $html .= '</div>';
                $html .= '<div class="campos-p">';
                $html .= '<select name="respuesta" id="select" multiple>';
                $consultasbd->iniciarVariables();
                $responseDataSelect = $consultasbd->buscarProcedimientoResponseSelect($row["identificador"]);
                while ($rows = $responseDataSelect->fetch_assoc()) {
                    $html .= "<option value=" . $rows["valor_alfa_numerico"] . "" . (($rows["valor_alfa_numerico"] == $row["respuesta_texto"]) ? ' selected="selected"' : '') . ">" . $rows["valor_alfa_numerico"] . "</option>";
                }
                $html .= '</select>';
                $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" required>';
                $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador">';
                $html .= '<input type="hidden" value="' . $row["bloque_preguntas"] . '" name="bloque_preguntas">';
                $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                $html .= '<input type="button" value="Adicionar" onclick="submitForm()">';
                $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" id="fileinput">';
                $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
                while ($RESULTS = $PedirDetalleBienes->fetch_assoc()) {
                    if ($RESULTS["result"] > 0) {
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
                $consultasbd->iniciarVariables();
                $responseDataSelect = $consultasbd->buscarProcedimientoResponseSelect($row["identificador"]);
                while ($rows = $responseDataSelect->fetch_assoc()) {
                    $html .= "<label><input type='radio' name='respuesta' onclick='submitForm();' value=" . $rows["valor_alfa_numerico"] . ">" . $rows["valor_alfa_numerico"] . "</label>";
                }

                $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador" id="identificador">';
                $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo" id="codigo">';
                $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" >';
                $consultasbd->iniciarVariables();
                $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
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
                $html .= '<form id="formulary">';
                $html .= '<div class="contenedor">';
                $html .= '<div class="campos-p pregunta">';
                $html .= '<label>' . $row["pregunta"] . '</label>';
                if (isset($row["ayuda"])) {
                    $html .= '<abbr title="' . $row["ayuda"] . '"><i class="fa-solid fa-question" style="color:red"></i></abbr>';
                }
                $html .= '</div>';
                $html .= '<div class="campos-p">';
                $html .= '<select name="respuesta" required>';
                $html .= '<option selected disabled>Seleccione una opcion</option>';
                $consultasbd->iniciarVariables();
                $responseDataSelect = $consultasbd->buscarProcedimientoResponseSelect($row["identificador"]);
                while ($rows = $responseDataSelect->fetch_assoc()) {
                    $html .= '<option value="' . $rows["id_valores"] . '">' . $rows["valor_alfa_numerico"] . '</option>';
                }
                $html .= '</select>';
                $html .= '<input type="hidden" value="' . $row["codigo"] . '" name="codigo">';
                $html .= '<input type="hidden" value="' . $row["identificador"] . '" name="identificador">';
                $html .= '<input type="hidden" value="' . $row["bloque_preguntas"] . '" name="bloque_preguntas">';
                $html .= '<input type="hidden" value="' . $row["id_respuesta"] . '" name="idrestpt">';
                $html .= '<input type="button" value="Adicionar" onclick="submitForm()">';
                $html .= '<input type="file" name="fileinput" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" id="fileinput">';
                $PedirDetalleBienes = $consultasbd->buscarDetallesBienes($row["identificador"]);
                while ($RESULTS = $PedirDetalleBienes->fetch_assoc()) {
                    if ($RESULTS["result"] > 0) {
                        $html .= '<input type="button" value="Carga Manual de Bienes " onclick="PassPage()" style="background-color: #008CBA;color: white;">';
                        $html .= '<input type="button" value="Continuar" onclick="submitForm()" style="background-color: #008CBA;color: white;">';
                    }
                }
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</form>';

                break;
        }
    }
    echo $html;
}

function GetConsecutivo($p_pregunta_actual, $id_respuesta, $id_inspeccion, $id_bloque_inspeccion)
{

    $consultasbdconsecutivo = new consultasbd;
    $consultasbdconsecutivo->iniciarVariables();
    $Consecutivo = null;
    $response = $consultasbdconsecutivo->buscarConsecutivoExists($id_inspeccion, $p_pregunta_actual, $id_respuesta);
    while ($row = $response->fetch_assoc()) {
        $Consecutivo = $row['consecutivo'];
    }
    if (isset($Consecutivo)) {
        echo str_replace(" ", "", $Consecutivo);
    } else {

        $consultasbd = new consultasbd;
        $consultasbd->iniciarVariables();
        $response = $consultasbd->buscarConsecutivo($id_inspeccion, $id_bloque_inspeccion);
        while ($row = $response->fetch_assoc()) {
            $Consecutivo = $row['resultado'];
        }
        echo str_replace(" ", "", $Consecutivo);
    }
}

function AjaxSelect($valor_respuesta_ant, $identificador, $id_inspeccion, $id_bloque_inspeccion)
{
    $html = null;
    /*if ($valor_respuesta_ant == 0) {
        $connect = new consultasbd;
        $connect->iniciarVariables();
        $responseDataSelect = $connect->buscarProcedimientoResponseSelect($identificador);
        while ($rows = $responseDataSelect->fetch_assoc()) {
            $html .= "<option value=" . $rows["valor_alfa_numerico"] . " >" . $rows["valor_alfa_numerico"] . "</option>";
        }
        echo $valor_respuesta_ant;
    } else {}*/

    $connect = new consultasbd;
    $connect->iniciarVariables();
    $responseDataSelect = $connect->buscarProcedimientoResponseSelectAjax($identificador, $id_inspeccion, $id_bloque_inspeccion, $valor_respuesta_ant);
    while ($rows = $responseDataSelect->fetch_assoc()) {
        $html .= "<option value=" . $rows["valor_alfa_numerico"] . " >" . $rows["valor_alfa_numerico"] . "</option>";
    }
    echo $valor_respuesta_ant;
}
