<?php 
include 'sec_login.php'; 
include 'clases/gabriel.class.php';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Carga</title>
        <link rel='stylesheet' href='../pages/css/estilosSebastian.css'>
        <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/regiones.css">
    </head>
    <body>
        <?php include 'header-rh.php';?>
        <div class="titulo_p"><i class="fa-solid fa-chart-simple"></i></i>&nbsp;CARGA</div>
        <div class="link_int">
            <div class="titulo2"><a></a></div>
        </div>
        <div class="contenedor_titulos">
            <div class="titulo">Carga</div>
        </div>
        <div class="contenedor">
            <div class="inputs_r">
                <form class="registro" action="importacion/importardatos.php" method="POST" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <label>Cargar Archivo: </label>
                    <input class="inputs_r" id="file-input" type="file" name="dataCliente" accept=".csv" required>
                    <label style="color:red;font-size:10px">* Para cargar los archivos hacerlo en formato .csv</label>
                    <script>
                        $('input[name="file"]').on('change', function(){
                        var ext = $( this ).val().split('.').pop();
                        if ($( this ).val() != '') {
                            if(ext = "csv"){
                            }else{
                                $( this ).val('');
                                //alert("Extensi贸n no permitida: " + ext);
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                            
                                Toast.fire({
                                    type: 'warning',
                                    title: ` Extensi贸n no permitida`
                                })
                            }
                        }
                        });
                    </script>
                    <button type="submit" name="subir" class="btn_azul"><a class="" href="#"><font color="white">Importar</font></a></button>
                </form>  
            </div>
        </div>
        <div class="cont_fin"></div>
      <?php include 'footer.php';?>
    </body>
</html>