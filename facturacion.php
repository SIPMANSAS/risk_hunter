<?php 
    include "sec_login.php"; 
    include 'conexion/conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
      <link rel="shortcut icon" href="favicon.ico">
</head>
<body>
   <?php include'header-rh.php';?>
   <div class="titulo_p"><i class="fa fa-credit-card"></i>&nbsp;Facturación </div>
   
   <div class="contenedor_titulos">
       <div class="titulo">Facturación</div>
       
   </div>
   
   <div class="contenedor_front">
        <center>
            <?php
            if(isset($_POST['facturacion'])){
                $id_inspeccion = $_POST['id_inspeccion'];
            
                $consultaexistenciafacturacion = $mysqli->query("SELECT * FROM enc_inspeccion WHERE identificador = '$id_inspeccion'");
                $exraerdatosinspeccion = $consultaexistenciafacturacion->fetch_array(MYSQLI_ASSOC);
                $fecha_facturacion = $exraerdatosinspeccion['fecha_facturacion'];
                if($fecha_facturacion == NULL || $fecha_facturacion == 0){
                    'AQUI REGISTRA FECHA';
                    $fecha_nueva = date('Y-m-d');
                    $actualizaestado = $mysqli->query("UPDATE enc_inspeccion SET fecha_facturacion='$fecha_nueva' WHERE identificador ='$id_inspeccion'");
                    
                    echo '<form action="facturapdf.php" method="POST">
                            <input type="hidden" value="'.$id_inspeccion.'" name="id_inspeccion">
                            <button class="btn_verde">Generar Factura</button>
                         </form>';
                }else{
                    echo '<form action="facturapdf.php" method="POST">
                        <input type="hidden" value="'.$id_inspeccion.'" name="id_inspeccion">
                        <button class="btn_azul">Descargar Factura</button>
                    </form>';
                }
            }
            
            /*
            if($fecha_facturacion == NULL || $fecha_facturacion == 0){
                echo 'ENTRA';
                echo $fecha_nueva = date('Y-m-d');
                echo "UPDATE enc_inspeccion SET fecha_facturacion='$fecha_nueva' WHERE identificador ='$id_inspeccion'";
                $actualizaestado = $mysqli->query("UPDATE enc_inspeccion SET fecha_facturacion='$fecha_nueva' WHERE identificador ='$id_inspeccion'" or die(mysqli_error));
            ?>
                <form>
                   <input type="hidden" value="<?php echo $id_inspeccion?>" name="id_inspeccion">
                    <button class="btn_azul">Generar Factura</button>
                </form>
            <?php
            }else{
            ?>
                <form>
                   <input type="hidden" value="<?php echo $id_inspeccion ?>" name="id_inspeccion">
                   <button class="btn_verde">Imprimir Factura</button>
                </form>
            <?php
            }
            */
            ?>
            
       </center>
       
       <center>
           
        </center>   
    </div>
    
    <div class="menu_secundario" style="display:none;">        
            
    </div>
   </div>
   <div class="cont_fin"></div>
    <?php include'footer.php';    ?>
</body>
</html>   