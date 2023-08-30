<?php

include '../clases/consultasbd.class.php';

if (isset($_REQUEST['cliente_id'])) {
    $num = $_REQUEST['cliente_id'];
    $date = date('YYYY-mm-dd');
    Consutla($num, $date);
}

function Consutla($num, $date)
{

    $consultasbd = new consultasbd;
    $consultasbd->iniciarVariables();
    $response = $consultasbd->ValidaInformacionInspecciones($num, $date);
    while ($row = $response->fetch_assoc()) {
        $result = $row['Resultado'];
    }
    if ($result == "inspecciones valido") {
        Insertar($num);
    } elseif ($result == "Fecha valida") {
        Insertar($num);
    } else {
        # code...
    }
}

function Insertar($num)
{

    $consultasbd = new consultasbd;
    $consultasbd->iniciarVariables();
    $consultasbd->Contador($num);
}
