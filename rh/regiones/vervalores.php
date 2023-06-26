<?php

include 'conexion/conexion.php';
include 'sec_login.php';
include  "clases/bloques.class.php";

?>

<html lang="es">
    
   <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Preguntas</title>
        <link rel="stylesheet" href="css/regiones.css">
        <link rel="stylesheet" href="css/totproyectos.css">
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        
        <script>
function prcadicionarriesgo(idres, idbloque, cons){
  window.open("creapreguntabloqueriesgo.php?idres="+idres+"&idbloque="+idbloque+"&consulta="+cons, "", "toolbar=0,location=0,status=0,resizable=0,width=550, height=550, top=30, left=300, scrollbars=NO");
}
</script> 
    </head>
     <?php include 'header-rh.php'; ?>
    <body>
         <div class="titulo_p">
            <center><i class="fa-solid fa-user"></i> LISTA DE VALORES DE RESPUESTA</center>
        </div>
        <?php
        $idrespuesta = $_POST['idrespuesta'];
        ?>
        <div class="contenedor_titulos">
            <div class=" titulo">Identificador</div>
            <div class=" titulo">Valor</div>
            <div class=" titulo">Estado</div>
        </div>
        <?php 
        //$consultavaloresrespuesta=$mysqli->query("SELECT * FROM enc_lista_valores JOIN sg_estados ON enc_lista_valores.estado = sg_estados.identificador WHERE enc_lista_valores.id_respuesta='$idrespuesta' GROUP BY enc_lista_valores.identificador");
        $filtro = $idrespuesta;
        $bloques    = new bloques;
        $consulta = $bloques->iniciarVariables();
        $consultavaloresrespuesta = $bloques->consultavaloresrespuesta($filtro);
        
        while($extraerData = $bloques->obtener_fila($consultavaloresrespuesta)){
            $identificador = $extraerData['identificador'];
            $valorRespuesta = utf8_encode($extraerData['valor_alfa_numerico']);
            $estado = $extraerData['nombre'];
        ?>    
        <div class="contenedor">
            <div class="campos_f">
                <?php echo $identificador ?>
            </div>
            <div class="campos_f">
                <?php echo $valorRespuesta ?>
            </div>
            <div class="campos_f">
                <?php echo $estado ?>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="cont_fin"><a href="javascript:close_tab();" class="btn_azul">CERRAR</a>
            <script>
                function close_tab(){
                    window.close();
                }
            </script>
        </div>
          <?php include 'footer.php'; ?>
    </body>
</html>