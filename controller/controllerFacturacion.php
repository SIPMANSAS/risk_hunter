<?php
include '../conexion/conexion.php';

switch ($_POST["Tipo"]) {
    case '1':
        $InformeTipo = $_POST["Tipo"];
        $Cliente = $_POST["ClaseACliente"];
        $Inspeccion = $_POST["ClaseAInspeccion"];

        $response = $mysqli->query("SELECT precio,porcentaje_Iva,porcentaje_descuento FROM fc_servicios WHERE identificador='1'");

        while ($row = $response->fetch_assoc()) {
            $precio = $row["precio"];
            $porcentajeIVA = $row["porcentaje_Iva"];
            $porcentajeDescuento = $row["porcentaje_descuento"];
        }

        $descuento = $precio * ($porcentajeDescuento / 100);

        $montoConDescuento = $precio - $descuento;

        $iva = $montoConDescuento * ($porcentajeIVA / 100);

        $valorNeto = $montoConDescuento + $iva;

        $mysqli->query("INSERT INTO fc_facturacion (cliente_id,InformeTipo,id_servicio,inspecciones,valor_total,valor_descuento,valor_iva,valor_neto) values('" . $Cliente . "','Uno A Uno','" . $InformeTipo . "',$Inspeccion,'" . $precio . "','" . $descuento . "','" . $iva . "','" . $valorNeto . "')");

        echo '<script language="javascript">    
        window.location.href="../PanelControlFacturacion.php"</script>';
        break;
    case "2":
        $InformeTipo = $_POST["Tipo"];
        $Cliente = $_POST["ClaseBCliente"];
        $fechaInicio = $_POST["ClaseBFInicio"];
        $fechaFin = $_POST["ClaseBFTermino"];

        $response = $mysqli->query("SELECT precio,porcentaje_Iva,porcentaje_descuento FROM fc_servicios WHERE identificador='2'");

        while ($row = $response->fetch_assoc()) {
            $precio = $row["precio"];
            $porcentajeIVA = $row["porcentaje_Iva"];
            $porcentajeDescuento = $row["porcentaje_descuento"];
        }

        $descuento = $precio * ($porcentajeDescuento / 100);

        $montoConDescuento = $precio - $descuento;

        $iva = $montoConDescuento * ($porcentajeIVA / 100);

        $valorNeto = $montoConDescuento + $iva;

        $mysqli->query("INSERT INTO fc_facturacion (cliente_id,InformeTipo,id_servicio,fecha_inicio,fecha_fin,valor_total,valor_descuento,valor_iva,valor_neto) values('" . $Cliente . "','Mensual','" . $InformeTipo . "','" . $fechaInicio . "','" . $fechaFin . "','" . $precio . "','" . $descuento . "','" . $iva . "','" . $valorNeto . "')");

        echo '<script language="javascript">    
        window.location.href="../PanelControlFacturacion.php"</script>';
        break;

    case "3":
        $InformeTipo = $_POST["Tipo"];
        $Cliente = $_POST["ClaseBCliente"];
        $fechaInicio = $_POST["ClaseBFInicio"];
        $fechaFin = $_POST["ClaseBFTermino"];

        $response = $mysqli->query("SELECT precio,porcentaje_Iva,porcentaje_descuento FROM fc_servicios WHERE identificador='2'");

        while ($row = $response->fetch_assoc()) {
            $precio = $row["precio"];
            $porcentajeIVA = $row["porcentaje_Iva"];
            $porcentajeDescuento = $row["porcentaje_descuento"];
        }

        $descuento = $precio * ($porcentajeDescuento / 100);

        $montoConDescuento = $precio - $descuento;

        $iva = $montoConDescuento * ($porcentajeIVA / 100);

        $valorNeto = $montoConDescuento + $iva;

        $mysqli->query("INSERT INTO fc_facturacion (cliente_id,InformeTipo,id_servicio,fecha_inicio,fecha_fin,valor_total,valor_descuento,valor_iva,valor_neto) values('" . $Cliente . "','Trimestral','" . $InformeTipo . "','" . $fechaInicio . "','" . $fechaFin . "','" . $precio . "','" . $descuento . "','" . $iva . "','" . $valorNeto . "')");

        echo '<script language="javascript">window.location.href="../PanelControlFacturacion.php"</script>';
        break;
    case "4":
        $InformeTipo = $_POST["Tipo"];
        $Cliente = $_POST["ClaseBCliente"];
        $fechaInicio = $_POST["ClaseBFInicio"];
        $fechaFin = $_POST["ClaseBFTermino"];

        $response = $mysqli->query("SELECT precio,porcentaje_Iva,porcentaje_descuento FROM fc_servicios WHERE identificador='2'");

        while ($row = $response->fetch_assoc()) {
            $precio = $row["precio"];
            $porcentajeIVA = $row["porcentaje_Iva"];
            $porcentajeDescuento = $row["porcentaje_descuento"];
        }

        $descuento = $precio * ($porcentajeDescuento / 100);

        $montoConDescuento = $precio - $descuento;

        $iva = $montoConDescuento * ($porcentajeIVA / 100);

        $valorNeto = $montoConDescuento + $iva;

        $mysqli->query("INSERT INTO fc_facturacion (cliente_id,InformeTipo,id_servicio,fecha_inicio,fecha_fin,valor_total,valor_descuento,valor_iva,valor_neto) values('" . $Cliente . "','Semestral','" . $InformeTipo . "','" . $fechaInicio . "','" . $fechaFin . "','" . $precio . "','" . $descuento . "','" . $iva . "','" . $valorNeto . "')");

        echo '<script language="javascript">window.location.href="../PanelControlFacturacion.php"</script>';
        break;

    case '5':
        $InformeTipo = $_POST["Tipo"];
        $Cliente = $_POST["ClaseBCliente"];
        $fechaInicio = $_POST["ClaseBFInicio"];
        $fechaFin = $_POST["ClaseBFTermino"];

        $response = $mysqli->query("SELECT precio,porcentaje_Iva,porcentaje_descuento FROM fc_servicios WHERE identificador='5'");

        while ($row = $response->fetch_assoc()) {
            $precio = $row["precio"];
            $porcentajeIVA = $row["porcentaje_Iva"];
            $porcentajeDescuento = $row["porcentaje_descuento"];
        }

        $descuento = $precio * ($porcentajeDescuento / 100);

        $montoConDescuento = $precio - $descuento;

        $iva = $montoConDescuento * ($porcentajeIVA / 100);

        $valorNeto = $montoConDescuento + $iva;

        $mysqli->query("INSERT INTO fc_facturacion (cliente_id,InformeTipo,id_servicio,fecha_inicio,fecha_fin,valor_total,valor_descuento,valor_iva,valor_neto) values('" . $Cliente . "','Anual','" . $InformeTipo . "','" . $fechaInicio . "','" . $fechaFin . "','" . $precio . "','" . $descuento . "','" . $iva . "','" . $valorNeto . "')");

        echo '<script language="javascript">window.location.href="../PanelControlFacturacion.php"</script>';

        break;
    default:
        # code...
        break;
}