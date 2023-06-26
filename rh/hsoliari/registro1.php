<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>

<script language="javascript">
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
    
    
</head>
<?php


$usuario="";
$password="";

include "clases/Json.class.php";

if ((isset($_POST['enviar'])) && ($_POST['enviar'] == "Enviar"))
{
    include_once  "clases/Json.class.php";
    
    $nombre = $_POST['nombre'];
    echo "nombre es $nombre";
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $tipoident = $_POST['tipoident'];
    $numident = $_POST['numident'];
    $idpais = $_POST["idpais"];
    $iddep = $_POST["iddep"];
    $idciudad = $_POST["idciudad"];
    $roles = $_POST["rol"]; /* para insertar debe hacer un for roles es un arreglo */
    $clientes = $_POST["clientes"]; /* para insertar debe hacer un for clientes es un arreglo */
    $prapellidos = explode(" ", $apellidos);
    $nombreorig = explode(" ", $nombre);
    $dosdigitos = substr($numident, -2);
    $user = $prapellidos[0].".".$nombreorig[0].$dosdigitos;
    $password = $user;
    $direccion = "";
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
    
    $disp = "";
  //  echo "voy a abrir json para insertar";
  //  echo "usuario es $usuario[0], $usuario[1], $usuario[3] ,$usuario[4] ";
    $Json     = new Json;
    $Json->iniciarVariables();
  /*  $XSEQUENCIA = "sg_usuarios";
        $filtro = "1";
    $parametro = "identificador";
    $sequsuario =   FncBuscarseq($XSEQUENCIA,$parametro,$filtro);
    */
  //   echo "ultimo registro es $sequsuario";
 //   $usuario[0] = $sequsuario+1;
    $xinsertu = $Json->insertausuario($usuario);
    echo "sali de insertar";
    if((!isset($xinsertu)) or ($xinsertu == FALSE)) {
        $correcto = "false";
        $disp .= "Se ha presentado un error en la creación del usuario... ".$xinsertu;
    }
    else
    {
      $disp = "Usuario creado correctamente. Se le asigno el siguiente nombre de usuario y password : ". $user ." el usuario debe ingresar a la plataforma y cambie su password.";
     
      /* voy a insertar rol luego de insertar el usuario */
      for ($i=0;$i <=count($roles); $i++)
      {
          $xrol = $roles[$i];
          $idusuario = $usuario[0];
          $fecha = date('Y-m-d H:i:s');
          $usuarxrol[0] = $xrol;
          $usuarxrol[1] = $idusuario;
          $usuarxrol[2] = $fecha;
          $xinsertu = $Json->insertarolxusuario($usuarxrol);
          if((!isset($xinsertu)) or ($xinsertu == FALSE)) {
              $correcto = "false";
              $disp .= " Se ha presento error en la creación del rol del usuario... ".$xinsertu;
          }
          else
                $disp .= " Rol del Usuario creado correctamente. ";
              
      }
      
    }
      
    
    echo '<script language="javascript">alert("';
    echo $disp;
    echo '");</script>';
    
    echo '     <div class="contenedor">
     <div id="result" > ';
    echo $disp;
    echo '     <a href=""> Regresar</a>';
   
    echo '    </div>';
   
}

?>
<body>  
    <header>
        <div class="logo">
            <a href=""><i class="fa-solid fa-globe"></i> logo</a>
        </div>
        <div class="usuario">
            <a href=""><i class="fa-solid fa-user"></i></a>
        </div>
    </header>
 
           
                <?php
       if (!isset($_POST["enviar"]))
                {
                    
                 echo '   
                         <div class="titulo_p"><i class="fa-solid fa-user"> </i>&nbsp;<div>Registro Ãºnico de usuario</div></div>
                        <div class="titulo2"><i class="fa-solid fa-user"></i><a href=""> Nuevo Usuario</a></div>
                        <div class="contenedor_titulos ">
                        <div class="campos titulo">Nuevo usuario</div>
                        </div>
                         <div class="contenedor">
        <form class="registro" action="registro1.php" method="post">    
        
        <div>     '; 
                
         if (isset($_POST["nombre"]))
                   echo '<input name="nombre" type="text" value="'.$_POST["nombre"].'  required>';
                else
                   echo '<input name="nombre" type="text" placeholder="nombre completo"  required> ';
                if (isset($_POST["apellidos"]))
                    echo '<input name="apellidos" type="text" value="'.$_POST["apellidos"].'  required>';
                else    
                    echo '<input name="apellidos" type="text" placeholder="apellidos" required> ';
                if (isset($_POST["email"]))
                        echo '<input name="email" type="text" value="'.$_POST["email"].'  required>';
                else          
                        echo '<input name="email" type="text" placeholder="correo electronico" required>';
                if (isset($_POST["telefono"]))
                       echo '<input name="telefono" type="text" value="'.$_POST["telefono"].'  required>';
                else
                       echo '<input name="telefono" type="number" placeholder="Telefono">';            
            
              
                    
                    if(isset($_POST["tipoident"]))
                       $xtipoidentidad = $_POST["tipoident"];
                   else 
                       $xtipoidentidad = "";
                    
                            $Json     = new Json;
                            $Json->iniciarVariables();
                            $xcompdominios = $Json->seltipoident();
                            $xrowdominios = array();
                            $xi=0;
                            echo '<SELECT name="tipoident">';
                            while ($xrowdominios = $Json->obtener_fila($xcompdominios)) {
                                $nombre[$xi] = utf8_encode($xrowdominios['nombre']) ;
                                $identificador[$xi] = $xrowdominios['identificador'];
                                  if($identificador[$xi] == $xtipoidentidad)
                                    echo '<option selected="selected" value="'.$identificador[$xi].'">'.$nombre[$xi].'</option>';
                                 else
                                        echo  '<option value="'.$identificador[$xi].'">'.$nombre[$xi].'</option>';
                                 $xi++;
                                        
                            }
                            echo '</select>';
                if (isset($_POST["numident"]))
                         echo '<input name="numident" type="text" value="'.$_POST["numident"].'  required>';
                else
                         echo " <input name=\"numident\" type=\"text\" placeholder=\"Numero de identificacion\" required>";
               echo "</div><div>";
                             
                  
                            if(isset($_POST["idpais"]))
                                $xidpaispr = $_POST["idpais"];
                                else
                                    $xidpaispr = "1";
                                    
                 $xcomppais = $Json->selpais();
                 $xrowpais = array();
                 $xi=0;
                 if(isset($_POST["idpais"]))
                     $xidpais = $_POST["idpais"];
                  else
                         $xidpais = "1";
                 echo '<SELECT name="idpais" id="idpais" >';
                 while ($xrowpais = $Json->obtener_fila($xcomppais)) {
                     $nombrep[$xi] = utf8_encode($xrowpais['nombre']) ;
                     $identificadorp[$xi] = $xrowpais['codigo'];
                     if($identificadorp[$xi] == $xidpais)
                         echo '<option selected="selected" value="'.$identificadorp[$xi].'">'.$nombrep[$xi].'</option>';
                         else
                             echo  '<option value="'.$identificadorp[$xi].'">'.$nombrep[$xi].'</option>';
                             $xi++;
                             
                 }
                 echo '</select>';
                 
                 
                   
                 
                 $filtro="1";
                 
                 $xcomppais = $Json->seldep($filtro);
                 $xrowpais = array();
                 $xi=0;
                
                    if(isset($_POST["iddep"]))
                     $xiddep = $_POST["iddep"];
                    else
                     $xiddep = "1";
                    
                  echo '<SELECT name="iddep" id="iddep" >';
                 while ($xrowpais = $Json->obtener_fila($xcomppais)) {
                             $nombred[$xi] = utf8_encode($xrowpais['nombre']) ;
                             $identificadord[$xi] = $xrowpais['codigo'];
                             if($identificadord[$xi] == $xiddep)
                                 echo '<option selected="selected" value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
                                 else
                                     echo  '<option value="'.$identificadord[$xi].'">'.$nombred[$xi].'</option>';
                                     $xi++;
                                     
                }
                echo '</select>';
                         
                
               $filtro="codigo_pais = 1 and codigo_departamento = 1";
               
               $xcomppais = $Json->selciudad($filtro);
               $xrowpais = array();
               $xi=0;
               
               if(isset($_POST["idciudad"]))
                   $xidciudad = $_POST["idciudad"];
                   else
                       $xidciudad = "1";
                       
                      echo '<SELECT name="idciudad" id="idciudad" >';
                       while ($xrowpais = $Json->obtener_fila($xcomppais)) {
                           $nombrec[$xi] = utf8_encode($xrowpais['nombre']) ;
                           $identificadorc[$xi] = $xrowpais['codigo'];
                        if($identificadorc[$xi] == $xidciudad)
                               echo '<option selected="selected" value="'.$identificadorc[$xi].'">'.$nombrec[$xi].'</option>';
                               else
                                   echo  '<option value="'.$identificadorc[$xi].'">'.$nombrec[$xi].'</option>';
                                     $xi++;
                                   
                       }
                      echo '</select></div>';
                   
                      $xcomprol = $Json->selrol();
                      $xnumfilas = $Json->numero_filas($xcomprol);
                      $xrowrol = array();
                      $xi=0;
                      echo '<div class="roles">
                      <legend>Rol de usuario</legend>';
                      
                      echo '<SELECT name= "rol[]" multiple="multiple" size=5 id="idrol" >';
                      while ($xrowrol = $Json->obtener_fila($xcomprol)) {
                          $nombrer[$xi] = utf8_encode($xrowrol['nombre_corto']) ;
                          $identificadorr[$xi] = $xrowrol['identificador'];
                          echo  '<option value="'.$identificadorr[$xi].'">'.$nombrer[$xi].'</option>';
                                  $xi++;
                                  
                      }
                      echo '</select>';
                      echo "</div>";
                      
                      echo '<div class="roles">
                      <legend>Cliente</legend>';
                      
                      echo '<SELECT name= "cliente[]" multiple="multiple" size=5 id="idrol" >';
                      while ($xrowrol = $Json->obtener_fila($xcomprol)) {
                          $nombrer[$xi] = utf8_encode($xrowrol['nombre_corto']) ;
                          $identificadorr[$xi] = $xrowrol['identificador'];
                          echo  '<option value="'.$identificadorr[$xi].'">'.$nombrer[$xi].'</option>';
                          $xi++;
                          
                      }
                      echo '</select>';
                      echo "</div>";
                      
                
               echo '
                <div><input class="btn_gris campos" type="reset" name="limpiar" value="limpiar">              
            <input class="btn_verde campos" type="submit" name="enviar" value="Enviar"></div>
            <br><!-- Usuario Asignado -->
           
        </form>
    </div>
<div class="cont_fin">
    
</div>';
     }
     
?>

    
</body>
</html>