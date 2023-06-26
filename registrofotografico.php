<?php include 'sec_login.php'; ?>
<!DOCTYPE html>
<html lang="es">
<?php

include  "clases/bloques.class.php";
$bloques = new bloques;
$consulta = $bloques->iniciarVariables();

$id_inspeccion = $_GET['id_inspeccion'];
$numero_inspeccion = $_GET['numero_inspeccion'];
$countries = array();
?>

<head>
    <title>Captura Registro Fotografico</title>
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/dropzone.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="almacenamientoMultiple/js/dropzone.js"></script>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="css/regiones.css">

</head>

<body>
    <?php include 'header-rh.php'; ?>

    <div class="container"></div>
    </div>

    <div class="titulo_p"><i class="fa-solid fa-file-image"></i>&nbsp; REGISTRO FOTOGRAFICO </div>
    <div class="link_int">
    </div>
    <br>
    <button id="addRow" type="button" class="btn_azul">+ Agregar Fotos</button>


    <div class="contenedor_titulos">
        <div class=" titulo">Imagen</div>
        <div class=" titulo">Pie de Pagina</div>
        <div class=" titulo">Acciones</div>
    </div>

    <form action="controller/controllerpreguntas.php" method="POST" enctype="multipart/form-data">
        <div class="contenedor">
            <div>

                <div id="inputFormRow">
                    <br>
                    <div>
                        <?php
                        for ($i = 1; $i <= $cantidad; $i++) {
                            $input = "?><input type='text' name='imagen[]' class='form-control m-input'  placeholder='Ingrese <?php echo $nombre?>' autocomplete='off' multiple required><?php " ?>
                            
                        <?php
                        }
                        ?>
                        <div id="newRow"></div>
                        <div id="preview"></div>
                    </div>
                </div>
                <br>
                <center>
                    <button type="submit" class="btn_verde" name="guardarregistrofotos">Guardar</button>
                </center>
            </div>
        </div>

    </form>
    <div class="cont_fin">
        <style>
            #preview {
                display: flex;
                flex-wrap: wrap;
            }

            .image-preview {
                width: 150px;
                height: 150px;
                margin: 10px;
            }

            .image-preview img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        </style>
    </div>
    <a href="javascript:close_tab();" class="btn_azul">CERRAR</a>
    <script>
        function target_popup(form) {
            window.open('', 'formpopup', 'width=1200,height=600,resizeable,scrollbars');
            form.target = 'formpopup';
        }
    </script>
    <script>
        function close_tab() {
            window.close();
        }
    </script>
    <script type="text/javascript">
        // agregar registro
        // se cambia name del type file, "file_pie_pagina[]"
        $("#addRow").click(function() {
            var html = '';
            html += '<div class="" id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += ' <input type="" value="<?php echo $numero_inspeccion ?>" name="numero_inspeccion[]">';
            html += ' <input type="hidden" value="<?php echo $id_inspeccion ?>" name="inspeccion[]">';
            html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" multiple name="foto[]" accept=".gif,.jpg,.jpeg,.png" class="form-control m-input">';

            html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<textarea rows="4" cols="45" type="text" name="texto_pie[]" class="form-control m-input"   autocomplete="off" required></textarea>';

            html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="removeRow" type="button" class="btn_rojo">Borrar</button>';
            html += '<div class="campos_f">';

            html += '</div>';

            html += '</div>';

            $('#newRow').append(html);
        });

        // borrar registro
        $(document).on('click', '#removeRow', function() {
            $(this).closest('#inputFormRow').remove();


        });

        $('input[type=file]').on('change', function(event) {
            var files = event.target.files;

            $('#preview').empty(); // Limpiar las vistas previas anteriores

            $.each(files, function(index, file) {
                // Verificar si el archivo es una imagen
                if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                    var reader = new FileReader();

                    reader.addEventListener('load', function() {
                        var image = $('<img>').attr({
                            'title': file.name,
                            'src': this.result
                        });

                        var previewContainer = $('<div>').addClass('image-preview');
                        previewContainer.append(image);

                        $('#preview').append(previewContainer);
                    }, false);

                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    <?php include 'footer.php'; ?>
</body>

</html>