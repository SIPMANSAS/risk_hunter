<?php
include '../conexion/conexion.php';

if (isset($_POST["Tipo"])) {
    $tipo = $_POST["Tipo"];

    switch ($tipo) {
        case '1':
            $InformeTipo = $tipo;
            $Cliente = $_POST["ClaseACliente"];
            $Inspeccion = $_POST["ClaseAInspeccion"];
            break;

        default:
            $InformeTipo = $tipo;
            $Cliente = $_POST["ClaseBCliente"];
            $fechaInicio = $_POST["ClaseBFInicio"];
            $fechaFin = $_POST["ClaseBFTermino"];
            break;
    }

    $response = $mysqli->query("SELECT nombre, precio, porcentaje_Iva, porcentaje_descuento FROM fc_servicios WHERE identificador='$InformeTipo'");

    if ($row = $response->fetch_assoc()) {
        $Nombre = $row["nombre"];
        $precio = $row["precio"];
        $porcentajeIVA = $row["porcentaje_Iva"];
        $porcentajeDescuento = $row["porcentaje_descuento"];
    }

    $descuento = $precio * ($porcentajeDescuento / 100);
    $montoConDescuento = $precio - $descuento;
    $iva = $montoConDescuento * ($porcentajeIVA / 100);
    $valorNeto = $montoConDescuento + $iva;

    if ($tipo === '1') {
        $mysqli->query("INSERT INTO fc_facturacion (cliente_id, InformeTipo, id_servicio, inspecciones, valor_total, valor_descuento, valor_iva, valor_neto)
            VALUES ('$Cliente', '" . ucfirst($Nombre) . "', '$InformeTipo', $Inspeccion, '$precio', '$descuento', '$iva', '$valorNeto')");
    } else {
        $mysqli->query("INSERT INTO fc_facturacion (cliente_id, InformeTipo, id_servicio, fecha_inicio, fecha_fin, valor_total, valor_descuento, valor_iva, valor_neto)
            VALUES ('$Cliente', '" . ucfirst($Nombre) . "', '$InformeTipo', '$fechaInicio', '$fechaFin', '$precio', '$descuento', '$iva', '$valorNeto')");
    }

    header("Location: ../PanelControlFacturacion.php");
    exit;
}

if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $Tipo = $_POST["Tipo"];
    $FInicio = $_POST["FInicio"];
    $FTermino = $_POST["FTermino"];
    $inspecciones = $_POST["inspecciones"];
    $InsCliente = $_POST["InsCliente"];

    $mysqli->query("UPDATE fc_facturacion SET 
        InformeTipo = '$Tipo',
        fecha_inicio = '$FInicio',
        fecha_fin = '$FTermino',
        inspecciones = '$inspecciones',
        inspecciones_cliente = '$InsCliente'
      WHERE 
        id = '$id';");

    header("Location: ../PanelControlFacturacion.php");
    exit;
}

if (isset($_POST["service"])) {
    $nombre = $_POST["servicio"];
    $fecha_vingencia = $_POST["vigencia"];
    $fecha_creacion = date("Y-m-d");
    $precio = $_POST["precio"];
    $porcentaje_Iva = $_POST["iva"];
    $porcentaje_descuento = $_POST["descuento"];
    $clase_usuario_dom = $_POST["clase_usuario_dom"];
    $meses = $_POST["meses"];

    $mysqli->query("INSERT INTO fc_servicios ( nombre, fecha_vigencia, fecha_creacion, precio, porcentaje_Iva, porcentaje_descuento, clase_usuario_dom, meses)
        VALUES ('$nombre', '" . $fecha_vingencia . "', '" . $fecha_creacion . "', '$precio', '$porcentaje_Iva', '$porcentaje_descuento', '$clase_usuario_dom', '$meses')");

    header("Location: ../PanelControlFacturacionServicios.php");
    exit;
}

if (isset($_POST["Updateservice"])) {
    $ID = $_POST["Updateservice"];
    $nombre = $_POST["servicio"];
    $fecha_vingencia = $_POST["vigencia"];
    $fecha_creacion = date("Y-m-d");
    $precio = $_POST["precio"];
    $porcentaje_Iva = $_POST["iva"];
    $porcentaje_descuento = $_POST["descuento"];
    $clase_usuario_dom = $_POST["clase_usuario_dom"];
    $meses = $_POST["meses"];


    $mysqli->query("UPDATE fc_servicios SET nombre = '$nombre',fecha_vigencia = '" . $fecha_vingencia . "',fecha_creacion = '" . $fecha_creacion . "',precio = '$precio',porcentaje_Iva = '$porcentaje_Iva',porcentaje_descuento = '$porcentaje_descuento',clase_usuario_dom = '$clase_usuario_dom',meses = '$meses' WHERE 
    identificador = '$ID';");

    header("Location: ../PanelControlFacturacionServicios.php");
    exit;
}

if (isset($_POST["filtro"])) {
    $filtro = $_POST["filtro"];

    $response = $mysqli->query("SELECT meses FROM fc_servicios WHERE identificador='$filtro'");

    while ($row = $response->fetch_assoc()) {
        echo $row["meses"];
    }
}
