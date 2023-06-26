<?php  include 'sec_login.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de inspectores</title>
    <link rel="stylesheet" href="css/regiones.css">
    <link rel="stylesheet" href="css/totproyectos.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <link href="css/styledynam2.css" rel="stylesheet">
      <link rel="shortcut icon" href="favicon.ico">
    
   
    <script>
        $(document).ready(function(){
            $("#idpais").on('change', function () {
                $("#idpais option:selected").each(function () {
                    elegido=$(this).val();
                    $.post("ajaxlistdep.php", { elegido: elegido }, function(data){
                    $("#iddep").html(data);           
                });			
            });
        });
        $("#iddep").on('change', function () {
            $("#iddep option:selected").each(function () {
                var eldep=$(this).val();
                var elpais = $("#idpais").val();
                var parametros = { 
                    "eldep": eldep,
                    "elpais": elpais
               };
                $.post("ajaxlistciudad.php", { eldep: eldep , elpais: elpais }, function(data){
                    $("#idciudad").html(data);
                        });			
                });
            }); 
        });        
    </script>
    
    <script>
function AgregarMasrol() {
    var id = $(".lista-rol").length + 1;
    var idant = id - 1;
    var nom = $("#nombrerol-1").val();
    $("<div>").load("InputDinamicorolxusuario.php", function() {
            var html = $(this).html();
            html = html.replace('nombrerol-1', 'nombrerol-' + id);
            html = html.replace('item-1', 'item-' + id);
	        html = html.replace('itemru-1', 'itemru-' + id);    
            $("#listroles").append(html);
            buscarInfoRoles();
            
	});
}

function BorrarRegistrorol() {
 
	$('div.lista-rol').each(function(index, item){
	    var idval = index + 1;
	    var idvalant = index;
	    
	 	jQuery(':checkbox', this).each(function () {
		       if ($("#item-" + idval).is(':checked')) {
                       $(item).remove();
                 }
                 if ($("#itemru-" + idval).is(':checked')) {
                       $(item).remove();
                 }
        });
	});
}


</script>

   <script>
function AgregarMascliente() {
    var id = $(".lista-cliente").length + 1;
    var idant = id - 1;
    $("<div>").load("InputDinamicoclientexusuario.php", function() {
            var html = $(this).html();
            html = html.replace('nombrecliente-1', 'nombrecliente-' + id);
            $("#listclientes").append(html);
	});
}

</script>
    
<script>

function buscarInfoRoles(){
    $('[id^=nombrerol-').on('keyup', function() {
        var key = $(this).val();
        var dataString = 'key='+key;
        var rowId = $(this).attr('id').split('-')[1];

	$.ajax({
            type: "POST",
            url: "funciones/obtienesearchrol.php",
            data: dataString,
            success: function(data) {
                //Escribimos las sugerencias que nos manda la consulta
                $('#sugerencia2').fadeIn(1000).html(data);
                //Al hacer click en algua de las sugerencias
                $('.sugerencia2-element').on('click', function(){

                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        var nomrolcomp =  $('#'+id).attr('data') + ":" + id;
                        //Editamos el valor del input con data de la sugerencia pulsada
                         $('#nombrerol-'+rowId).val(nomrolcomp);
					    //Hacemos desaparecer el resto de sugerencias
                        $('#sugerencia2').fadeOut(1000);
                        alert('Has seleccionado el '+id+' '+$('#'+id).attr('data'));
                        return false;
                });
            }
        });
    });
    }
    
    $(document).ready(function() {
    buscarInfoRoles();
    });
    
   
</script>
    
</head>
<?php

/* Defino funcion para enviar email de usuario creado correctamente */

function enviaremail($email,$asunto,$texto,$textof,$nombres,$apellidos,$usuario,$remite,$cc,$link)
{
    $destinatario = $email;
    $asunto = $asunto;
    $datossaludo = "<html>
        <head>
   <title>Creacion de Usuario Inspector en RH+</title>
    </head>
    <body>
    <h1>Senor(a) ". $nombres." ".$apellidos."</h1><br>";
    $datosusuario = "<br><h2>Usuario Asignado: ". $usuario."</h2><br>";
    $mensajedelink = "<br> Ingrese a la plataforma por este link: ";
    $link = " http://rh.deshida.com.co/rh/regiones/log.php  <br>";
    $cuerpo = $datossaludo.$texto.$datosusuario.$mensajedelink.$link.$textof."</body></html>";
    
    //para el env�o en formato HTML
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    
    //direcci�n del remitente
    $headers .= "From: Administracion de Gestion de Riesgos Risk Hunter <". $remite.">\r\n";
    
    //direcci�n de respuesta, si queremos que sea distinta que la del remitente
    $headers .= "Reply-To: ".$remite."\r\n";
    
    //direcciones que recibi�n copia
    $headers .= "Cc: ".$cc."\r\n";
    
    mail($destinatario,$asunto,$cuerpo,$headers) ;
}



/* Incluyo la clase Json.class que contine todos los llamados a la base de datos Querys, Insert y Update */

include "clases/Json.class.php";

/* Inicializo variables */

$usuario="";
$password="";
$disp="";
$correcto="";



    $nombre="";
    $apellidos="";
    $email="";
    $telefono="";
    $xtipoidentidad = ""; 
    $numident = "";
    $direccion = "";

if (isset($_GET["id"]) or (isset($_POST["id"])))
{
            $Json     = new Json;
            $Json->iniciarVariables();
            if (isset($_GET["id"]))
                $id = $_GET["id"];
            else 
                $id = $_POST["id"];
            $filtro = "identificador = '$id'";
            $result = $Json->buscarusuarios($filtro);
            $xinfouser = $Json->obtener_fila($result);
            $email = $xinfouser["email"];
            $nombre = utf8_encode($xinfouser["nombre"]);
            $apellidos = utf8_encode($xinfouser["apellidos"]);
            $numident = utf8_encode($xinfouser["identificacion"]);
            $telefono = $xinfouser["numero_telefono"];
            $ciudad = utf8_encode($xinfouser["ciudad"]);
            $usuario =  $xinfouser["usuario"];
            $direccion = $xinfouser["direccion"];
     
}
/* valida si lleno los datos en el formulario y procedo a insertar el usuario */

if ((isset($_POST['enviar'])) && ($_POST['enviar'] == "Enviar"))
{
    include_once  "clases/Json.class.php";
    
    
    
    
    /* capturo datos del post e inicializar variables */
    
    $nombre = utf8_encode($_POST["nombre"]);
    $apellidos = utf8_encode($_POST["apellidos"]);
    $telefono = $_POST["telefono"];
    $idpais = $_POST["idpais"];
    $iddep = $_POST["iddep"];
    $idciudad = $_POST["idciudad"];
    $direccion = utf8_encode($_POST["direccion"]);
    
    
    if (isset($_POST["id"]) && ($_POST["id"] <> "") )
    {
         /* llamo clase para actualizar datos del usuario */
        
        $id = $_POST["id"];
        $filtro = "identificador = '$id'";
        $Json     = new Json;
        $Json->iniciarVariables();
        $cadena = "nombre = '$nombre', apellidos = '$apellidos', numero_telefono = '$telefono' , direccion = '$direccion', 
                    id_pais = '$idpais', id_departamento = '$iddep', id_ciudad = '$idciudad' ";
        $xactualizau = $Json->actualizausuario($filtro, $cadena);
        if((!isset($xactualizau)) or ($xactualizau == FALSE)) {
            $correcto = "false";
            $disp .= "Se ha presentado un error en la actualizacion del usuario... ".$xactualizau;
        }
        else
        {
            
            /* se actualizo correctamente el usuario en tabla de usuarios y procedo a insertar roles y clientes */
            $correcto = "true";
            $disp = "- Usuario atualizado correctamente. ";
        }
    }
    else 
    {
    $email = $_POST['email'];
    $tipoident = $_POST['tipoident'];
    $numident = $_POST['numident']; 
    $prapellidos = explode(" ", $apellidos);
    $nombreorig = explode(" ", $nombre);
    $dosdigitos = substr($numident, -2);
    $user = $prapellidos[0]."_".$nombreorig[0].$dosdigitos;
    $password = $user;
    $id_oficina = 1;
    $usuario = array();
    $usuario[1] = $email;
    $usuario[2] = $nombreorig[0];
    $usuario[3] = $nombre;
    $usuario[4] = $apellidos;
    $usuario[5] = $tipoident;
    $usuario[6] = $telefono;
    $usuario[7] = $idpais;
    $usuario[8] = $iddep;
    $usuario[9] = $idciudad;
    $usuario[10] = $direccion;
    $usuario[11] = $id_oficina;
    $usuario[12] = $numident;
    $usuario[13] = $user;
    $usuario[14] = $password;
    
    $disp = "";
    
    /* llamo clase para insertar datos del usuario */
    
    $Json     = new Json;

    $Json->iniciarVariables();
    $xinsertu = $Json->insertausuario($usuario);
    if((!isset($xinsertu)) or ($xinsertu == FALSE)) {
        $correcto = "false";
        $disp .= "Se ha presentado un error en la creación del usuario... ".$xinsertu;
    }
    else
    {
        
        /* se inserto correctamente el usuario en tabla de usuarios y procedo a insertar roles y clientes */
        
      $disp = "- Se ha creado correctamente el Inspector $nombre $apellidos <br><br> - Se le asigno el siguiente nombre de usuario y password : ". $user ." <br><br> - El usuario debe ingresar a la plataforma y cambiar su password. <br><br>";
      $filtro = "1";
      $xsequencia = $Json->buscarsequenciausuario();
      $ultimocodigo = $Json->obtener_fila($xsequencia);
      if (!isset($ultimocodigo["maximo"]))
          $maxid=1;
      else
          $maxid = $ultimocodigo["maximo"];
      
     
     
            $xrol = "9"; //////Aqui va el campo rol para el inspector el cual tiene asignado el id 11
            $idusuario = $maxid;
            $fecha = date('Y-m-d H:i:s');
            $usuarxrol[0] = $xrol;
            $usuarxrol[1] = $idusuario;
            $usuarxrol[2] = $fecha;
            $xinsertu = $Json->insertarolxusuario($usuarxrol);
            if((!isset($xinsertu)) or ($xinsertu == FALSE)) {
                $correcto = "false";
            }
            else
                $correcto = "true";
        }
        if ($correcto == "false")
            $disp .= " Se ha presento error en la actualizacion de los roles del usuario... ".$xinsertu;
        else
            $disp .= " Roles actualizados correctamente. <br><br>";
            
            $idcomunicaciones = "1";
            $xinfoemail = $Json->infoemail($idcomunicaciones);
            $inforcomunicaciones = $Json->obtener_fila($xinfoemail);
            $asunto = $inforcomunicaciones["asunto"];
            $texto = $inforcomunicaciones["texto"];
            $textof = $inforcomunicaciones["textof"];
            $remite = $inforcomunicaciones["remitente"];
            $cc = $inforcomunicaciones["cc"];
            $link = " http://rh.deshida.com.co/rh/regiones/log.php  <br>";
                 
            $envioemail = enviaremail($email,$asunto,$texto,$textof,$nombre,$apellidos,$user,$remite,$cc,$link);
    
            $nombre="";
            $apellidos="";
            $numident="";
            $telefono="";
            $email="";
            $direccion=""; 
    }
    
}

/* Inicia el Encabezado del formulario */

?>
<body>  
    <?php
    /*agreho el header*/
    include 'header-rh.php';
    /* Finaliza el encabezado del formulario incia el form formulario de captura de datos de usuario */
    
                  echo '<div class="titulo_p"><i class="fa-solid fa-user"> </i>&nbsp;<div>Registro único de inspectores</div></div>
                        <div class="link_int">
                            <div class="titulo2"><i class="fa-solid fa-user"></i><a href="crearinspectoresrh.php"> Nuevo Inspector</a></div>
                            <div class="titulo3"><i class="fa-solid fa-user"></i><a href="listausuariosrh.php"> volver a listado</a></div>
                        </div>
                        <div class="contenedor_titulos ">
                        <div class="campos titulo">Nuevo Inspector</div>
                        </div>';
                echo '<div class="contenedor">';

    /* Inicia llamado del form con sus campos de nombre,apellido, email, telefono etc */

                echo '<form class="registro" action="crearinspectoresrh.php" method="post">'; 
                echo    '<div class="inputs_r">
                            <label for="nombre">Nombres</label>
                            <input class="inp_med" name="nombre" type="text" value="'.$nombre.'" required>
                        </div> ';
                echo '  <div class="inputs_r">
                            <label for="apellidos">apellidos</label>
                            <input class="inp_med" name="apellidos" type="text" value="'.$apellidos.'"  required>
                        </div>';

                /* Llamo a la clase */
                
                $Json     = new Json;
                $Json->iniciarVariables();
                
                /* Hago el select de tipo de indentificacion */
                
                $xcompdominios = $Json->seltipoident();
                $xrowdominios = array();
                $xi=0;
                if (isset($id))
                    echo '<div class="inputs_r"><label for="identificacion">Tipo de identificación</label><SELECT name="tipoident" disabled>';
                else 
                    echo '<div class="inputs_r"><label for="identificacion">Tipo de identificación</label><SELECT name="tipoident" >';
                while ($xrowdominios = $Json->obtener_fila($xcompdominios)) {
                      $nombreidentificador[$xi] = utf8_encode($xrowdominios['nombre']) ;
                      $identificador[$xi] = $xrowdominios['identificador'];
                      if($identificador[$xi] == $xtipoidentidad)
                            echo '<option selected="selected" value="'.$identificador[$xi].'">'.$nombreidentificador[$xi].'</option>';
                      else
                            echo  '<option value="'.$identificador[$xi].'">'.$nombreidentificador[$xi].'</option>';
                      $xi++;
                }
                echo '</select></div>';
                if (isset($id))
                    echo '<div class="inputs_r"><label for="">Número de Identificación</label><input class="inp_med" name="numident" type="text" value="'.$numident.'"  disabled></div>';
                else    
                    echo '<div class="inputs_r"><label for="">Número de Identificación</label><input class="inp_med" name="numident" type="text" value="'.$numident.'"  required></div>';


                echo '<div class="inputs_r">
                        <label for="telefono">teléfono</label>
                        <input class="inp_med" name="telefono" type="text" value="'.$telefono.'"  required>
                    </div>';
                echo '  <div class="inputs_r">
                            <label for="email">Correo electrónico</label>';
                if (isset($id))
                    echo '<input class="inp_med" name="email" id="useremail" type="email" value="'.$email.'"  disabled>';
                else
                    echo '<input class="inp_med" name="email" id="useremail" type="email" value="'.$email.'"  required>';
                 echo '</div>';
                
              
                
               
                
                /* Hago el select de Pais */
                
                 $xcomppais = $Json->selpais();
                 $xrowpais = array();
                 $xi=0;
                 if (isset($ciudad))
                 {
                     $region = explode("-",$ciudad);
                     $pais = $region[0];
                     $departamento = $region[1];
                     $otciudad = $region[2];
                 }
                 if(isset($_POST["idpais"]))
                     $xidpais = $_POST["idpais"];
                  elseif (isset($ciudad))
                  {
                      $region = explode("-",$ciudad);
                      $pais = $region[0];
                      $departamento = $region[1];
                      $otciudad = $region[2];
                  }
                  else 
                         $xidpais = "1";
                 echo '<div class="inputs_r"><label for="">País</label><SELECT name="idpais" id="idpais" >';
                 while ($xrowpais = $Json->obtener_fila($xcomppais)) {
                     $nombrep[$xi] = utf8_encode($xrowpais['nombre']) ;
                     $identificadorp[$xi] = $xrowpais['codigo'];
                     if($identificadorp[$xi] == $xidpais)
                         echo '<option selected="selected" value="'.$identificadorp[$xi].'">'.$nombrep[$xi].'</option>';
                     elseif ($nombrep[$xi] == $pais)
                         echo '<option selected="selected" value="'.$identificadorp[$xi].'">'.$nombrep[$xi].'</option>';
                     else        
                         echo  '<option value="'.$identificadorp[$xi].'">'.$nombrep[$xi].'</option>';
                     $xi++;
                 }
                 echo '</select></div>';
                 
                 /* Hago el seelct del departamento */
                 
                 $filtro="1";
                 $xcomppais = $Json->seldep($filtro);
                 $xrowpais = array();
                 $xi=0;
                 $otciudad='';
                 $departamento='';
                 $pais = '';
                 $direccion = '';
                 if(isset($_POST["iddep"]))
                     $xiddep = $_POST["iddep"];
                  elseif (isset($ciudad))
                     {
                         $region = explode("-",$ciudad);
                         $pais = $region[0];
                         $departamento = $region[1];
                         $otciudad = $region[2];
                   }
                    else
                         $xiddep = "1";
                         
                 echo '<div class="inputs_r"><label for="">Departamento</label><SELECT name="iddep" id="iddep" >';
                 while ($xrowpais = $Json->obtener_fila($xcomppais)) {
                             $nombred[$xi] = utf8_encode($xrowpais['nombre']) ;
                             $identificadord[$xi] = $xrowpais['codigo'];
                             if($identificadord[$xi] == $xiddep)
                                 echo '<option selected="selected" value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
                             elseif ($nombred[$xi] == $departamento)
                                    echo '<option selected="selected" value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
                             else
                                 echo  '<option value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
                             $xi++;
                }
                echo '</select></div>';
                
                /* Hago el select de la ciudad */
                
                if (isset($otciudad))
                    $filtro = "nombre = '$otciudad'";
                else
                    $filtro="codigo_pais = '1' and codigo_departamento = '1'";
               $xcompciudad = $Json->selciudad($filtro);
               $xi=0;
              /* if(isset($_POST["idciudad"]))
                   $xidciudad = $_POST["idciudad"];
               else
                   $xidciudad = "1";*/
               echo '<div class="inputs_r"><label for="">Ciudad</label><SELECT name="idciudad" id="idciudad" >';
               while ($xrowciudad = $Json->obtener_fila($xcompciudad)) {
                           $nombrec[$xi] = utf8_encode($xrowciudad['nombre']) ;
                           $identificadorc[$xi] = $xrowciudad['codigo'];
                /*        if ($identificadorc[$xi] == $xidciudad)
                               echo '<option selected="selected" value="'.$identificadorc[$xi].'">'.$nombrec[$xi].'</option>'; */
                        if ($nombrec[$xi] == $otciudad)
                                echo '<option selected="selected" value="'.$identificadorc[$xi].'">'.$nombrec[$xi].'</option>';
                        else 
                               echo  '<option value="'.$identificadorc[$xi].'">'.$nombrec[$xi].'</option>';
                        $xi++;
               }
               echo '</select></div>';
               

               /* Agrego botones del formulario */
               
               echo '<div class="inputs_r"><input class="btn_rojo" type="reset" name="limpiar" value="limpiar">   ';
               
               ?>
            <input class="btn_verde" type="submit" name="enviar" value="Enviar" onclick="return validateEmail()" /></div>
            <br><!-- Usuario Asignado -->
             
        </form>
        <div class="registro-b">
<?php

/* Publico mensajes del resultado de la insercion de usuarios */

       if ($correcto == "true")
           echo ' <div class="msj_verde"><span>'.$disp.'</span></div>';  
       elseif ($correcto == "false")
           echo ' <div class="msj_rojo"><span>'.$disp.'</span></div>';
       ?>    
    
    </div> 
        
      </div> 
       <div class="cont_fin"></div>

<?php include 'footer.php';?>


 <script type="text/javascript">
            function validateEmail(){
                // Define our regular expression.
                var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
                // Using test we can check if the text match the pattern
                if( validEmail.test( jQuery('#useremail').val() ) ){
                    return true;
                }else{
                    alert('Email es invalido, no se puede continuar con el registro');
                    return false;
                }
            }
        </script>
</body>
</html>