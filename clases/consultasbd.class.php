<?php


include 'utidatos.class.php';

class consultasbd extends utidatos
{

    function cerrar()
    {
        $this->con->destruir();
    }


    function pasarelaInsert($key, $currency, $tax_base, $tax, $country, $lang, $external, $confirmation, $response)
    {
        if ($this->con->conectar() == true) {
            $consulta = "INSERT INTO PaymentGateway (gateway_key, currency, tax_base, tax, country, lang, external, confirmation, response)
            VALUES ('$key', '$currency', '$tax_base', '$tax', '$country', '$lang', '$external', '$confirmation', '$response')";
            return $this->con->consulta($consulta);
        }
    }

    function pasarelaUpdate($id, $key)
    {
        if ($this->con->conectar() == true) {
            $consulta = "UPDATE PaymentGateway SET gateway_key = '$key' WHERE id = '$id'";
            return $this->con->consulta($consulta);
        }
    }

    function buscarConsecutivo($id_inspeccion, $id_bloque_inspeccion)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT IFNULL(MAX(consecutivo),0)+1 AS resultado FROM enc_detalles_inspeccion D WHERE D.id_inspeccion = '" . $id_inspeccion . "' AND D.bloque_inspeccion= '" . $id_bloque_inspeccion . "'";
            return $this->con->consulta($consulta);
        }
    }

    function SeachTextToNumber($identificador, $p_respuesta)
    {
        if ($this->con->conectar() == true) {
            $p_respuesta = str_replace(',', "','", $p_respuesta);
            $consulta = "SELECT Min(enc_lista_valores.identificador) as id_valores FROM enc_preguntas,enc_respuestas,enc_lista_valores,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.identificador = enc_lista_valores.id_respuesta AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.identificador ='" . $identificador . "' AND enc_lista_valores.valor_alfa_numerico in ('$p_respuesta')";
            return $this->con->consulta($consulta);
        }
    }

    function buscarConsecutivoExists($id_inspeccion, $p_pregunta_actual, $id_respuesta)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT consecutivo FROM enc_detalles_inspeccion WHERE id_inspeccion = '" . $id_inspeccion . "' AND id_pregunta = '" . $p_pregunta_actual . "' AND id_respuesta='" . $id_respuesta . "'";
            return $this->con->consulta($consulta);
        }
    }

    function buscarExistsRegedit($id_inspeccion, $p_pregunta_actual, $id_respuesta)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT id_inspeccion as inspeccion FROM enc_detalles_inspeccion WHERE id_inspeccion = '" . $id_inspeccion . "' AND id_pregunta = '" . $p_pregunta_actual . "' AND id_respuesta='" . $id_respuesta . "'";
            return $this->con->consulta($consulta);
        }
    }

    function buscarDetallesBienes($identificado)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT f_pedir_detalle_bienes(" . $identificado . ") as result";
            return $this->con->consulta($consulta);
        }
    }

    function buscarProcedimiento($p_codigo, $p_respuesta, $p_pregunta_actual, $id_inspeccion, $id_bloque_inspeccion)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT f_pintar_siguiente_pregunta('" . $p_codigo . "','" . $p_respuesta . "','" . $p_pregunta_actual . "'," . $id_inspeccion . "," . $id_bloque_inspeccion . ") AS resultado";
            return $this->con->consulta($consulta);
        }
    }

    function CondicionalQuery($p_codigo)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT enc_preguntas.identificador,enc_preguntas.nombre pregunta,enc_preguntas.id_respuesta,cg_valores_dominio.id_alfanumerico tipo,enc_preguntas.codigo,enc_preguntas.id_bloque_preguntas bloque_preguntas,enc_preguntas.ayuda FROM enc_preguntas,enc_respuestas,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.codigo LIKE '" . $p_codigo . ".%' ";
            return $this->con->consulta($consulta);
        }
    }

    function InsertAutoSave($id_inspeccion, $Consecutivo, $id_bloque_inspeccion, $p_respuesta, $p_pregunta_actual, $id_respuesta, $p_archivo, $id_valor_respuesta)
    {
        if ($this->con->conectar() == true) {
            $consulta = "INSERT INTO enc_detalles_inspeccion 
           (id_inspeccion, consecutivo, id_pregunta, id_respuesta,respuesta_texto,tipo_estado,estado,archivos,bloque_inspeccion,id_respuesta_concat,id_valor_respuesta) VALUES 
           ('" . $id_inspeccion . "','" . $Consecutivo . "','" . $p_pregunta_actual . "','" . $id_respuesta . "','" . $p_respuesta . "',23,1,'" . $p_archivo . "','" . $id_bloque_inspeccion . "',0,'" . $id_valor_respuesta . "')";
            return $this->con->consulta($consulta);
        }
    }

    function UpdateAutoSave($id_inspeccion, $Consecutivo, $id_bloque_inspeccion, $p_respuesta, $p_pregunta_actual, $id_respuesta, $p_archivo, $id_valor_respuesta)
    {
        if ($this->con->conectar() == true) {
            $consulta = "UPDATE enc_detalles_inspeccion SET id_inspeccion='" . $id_inspeccion . "',consecutivo='" . $Consecutivo . "'
            ,id_pregunta='" . $p_pregunta_actual . "',id_respuesta='" . $id_respuesta . "',respuesta_texto='" . $p_respuesta . "'
            ,bloque_inspeccion='" . $id_bloque_inspeccion . "',id_valor_respuesta='" . $id_valor_respuesta . "'
            WHERE id_inspeccion = '" . $id_inspeccion . "' AND id_pregunta = '" . $p_pregunta_actual . "' AND consecutivo='" . $Consecutivo . "'";
            return $this->con->consulta($consulta);
        }
    }
    function buscarProcedimientoResponse($codigo)
    {
        if ($this->con->conectar() == true) {
            $consulta = "select enc_preguntas.identificador,enc_preguntas.nombre pregunta,cg_valores_dominio.id_alfanumerico tipo,cg_valores_dominio.descripcion icono,enc_preguntas.codigo codigo,enc_preguntas.ayuda ayuda,enc_preguntas.id_respuesta id_respuesta from enc_preguntas,enc_respuestas,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.identificador ='" . $codigo . "'";
            return $this->con->consulta($consulta);
        }
    }

    function buscarProcedimientoResponseSelect($codigo)
    {
        if ($this->con->conectar() == true) {
            $consulta = "select enc_lista_valores.identificador as id_valores,enc_lista_valores.valor_alfa_numerico from enc_preguntas,enc_respuestas,enc_lista_valores,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.identificador = enc_lista_valores.id_respuesta AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.identificador ='" . $codigo . "'";
            return $this->con->consulta($consulta);
        }
    }

    function buscarProcedimientoResponseSelectAjax($identificador, $id_inspeccion, $id_bloque_inspeccion, $valor_respuesta_ant)
    {
        if ($this->con->conectar() == true) {
            $consulta = "select enc_lista_valores.identificador as id_valores,enc_lista_valores.valor_alfa_numerico from enc_preguntas,enc_respuestas,enc_lista_valores,cg_valores_dominio WHERE enc_preguntas.id_respuesta = enc_respuestas.identificador AND enc_respuestas.identificador = enc_lista_valores.id_respuesta AND enc_respuestas.vdom_tipo_dato = cg_valores_dominio.identificador AND enc_preguntas.identificador ='" . $identificador . "' AND llave_foranea = (SELECT d.id_valor_respuesta llave_foranea FROM enc_detalles_inspeccion d WHERE d.id_inspeccion = $id_inspeccion AND d.bloque_inspeccion = $id_bloque_inspeccion AND d.id_pregunta = $valor_respuesta_ant) ";
            return $this->con->consulta($consulta);
        }
    }


    function buscapais($filtro)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT * FROM rg_paises";
            return $this->con->consulta($consulta);
        }
    }

    function buscafirmas($filtro)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT * FROM ter_terceros WHERE vdom_tipo_tercero = '774' AND $filtro AND estado = 1";
            return $this->con->consulta($consulta);
        }
    }


    function buscarclienteusuario($filtro)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT * FROM ter_terceros WHERE $filtro";
            return $this->con->consulta($consulta);
        }
    }

    function buscafirmass($filtro)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT * FROM ter_terceros WHERE vdom_tipo_tercero = '772' AND $filtro AND estado = 1";
            return $this->con->consulta($consulta);
        }
    }

    function pintarformulario()
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT * FROM v_pinta_formulario";
            return $this->con->consulta($consulta);
        }
    }

    function buscaenccompanias($filtro)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT * FROM  v_parrilla_cias_seguros WHERE $filtro";
            return $this->con->consulta($consulta);
        }
    }

    function buscaencfirmas($filtro)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT * FROM  v_parrilla_firma_inspectora WHERE $filtro";
            return $this->con->consulta($consulta);
        }
    }

    function buscainspectoresindependientes($filtro)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT * FROM  v_parrilla_inspectores WHERE $filtro";
            return $this->con->consulta($consulta);
        }
    }

    function buscapreguntasB()
    {
        if ($this->con->conectar() == TRUE) {
            $consulta = "SELECT * FROM enc_preguntas";
            return $this->con->consulta($consulta);
        }
    }

    function buscainmuebles($filtro)
    {
        if ($this->con->conectar() == TRUE) {
            $consulta = "SELECT * FROM enc_inmuebles WHERE $filtro";
            return $this->con->consulta($consulta);
        }
    }

    function buscasabana($filtro)
    {
        if ($this->con->conectar() == true) {
            $consulta = "SELECT * FROM v_sabana WHERE $filtro";
            return $this->con->consulta($consulta);
        }
    }
}
