<?php include "sec_login.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
    <link rel="stylesheet" href="css/regiones.css">
    <script src="https://kit.fontawesome.com/ba54e2cec4.js" crossorigin="anonymous"></script>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
</head>
<?php
include "clases/Json.class.php";

if (isset($_POST["nombre_corto"]))
    $nombre_corto = $_POST["nombre_corto"];
else
    $nombre_corto = "";
if (isset($_POST["descripcion"]))
    $descripcion = $_POST["descripcion"];
else
    $descripcion = "";
    $correcto="";

if ((isset($_POST['enviar'])) && ($_POST['enviar'] == "Enviar"))
{
    include_once  "clases/Json.class.php";
    /* capturo datos del post e inicializar variables */   
    $nombre_corto = $_POST['nombre_corto'];
    $descripcion = $_POST['descripcion'];
    $xidrol = $_POST['selrol'];
    /* llamo clase para insertar datos del rol */
    $Json     = new Json;
    $Json->iniciarVariables();   
    if ($xidrol == 0)
    {
        $xsequencia = $Json->buscarsequenrol();
        $ultimocodigo = $Json->obtener_fila($xsequencia);
        if (!isset($ultimocodigo["maximo"]))
            $maxid=0;
        else
             $maxid = $ultimocodigo["maximo"];
        $xidrol = $maxid + 1;
        $rol[0] = $xidrol;
        $rol[1] = $nombre_corto;
        $rol[2] = $descripcion;
        $xinsertrol = $Json->insertarol($rol);

        if((!isset($xinsertrol)) or ($xinsertrol == FALSE)) {
             $correcto = "false";
             $disp .= "Se ha presentado un error en la creacion del rol... ".$xinsertrol;
        }
        else
        {
            $correcto = "true";
            $disp .= "Se ha creado el Rol correctamente";
        }
    }
    $objetos = $_POST['objetos']; /* para insertar debe hacer un for objetos es un arreglo */
      /* voy a buscar todos los permisos selecccinados para insertar */
        for ($i=0;$i <count($objetos); $i++)
        {
            $xidselect = $objetos[$i];
            $idrol = $xidrol;
            list($idclase,$idobjeto) = explode("-",$xidselect);
            $rol[0] = $idrol;
            $rol[1] = $idclase;
            $rol[2] = $idobjeto;
            $xinsertp = $Json->insertarolxobjeto($rol);
            if((!isset($xinsertp)) or ($xinsertp == FALSE)) {
                $correcto = "false";
            }
            else
                $correcto = "true";
        }
        if ($correcto == "false")
            $disp .= " Se ha presento error en la creacion de los permisos de los roles... ".$xinsertp;
        else
            $disp .= " Permisos de los roles creados correctamente. "; 
}
?>
<body>  
    <?php
    include 'header-rh.php';
                 echo '   
                        <div class="titulo_p"><i class="fa-solid fa-user"> </i>&nbsp;<div>Registro único de Roles</div></div>
                       
                        <div class="link_int">
                            <div class="titulo2"><i class="fa-solid fa-user"></i> Nuevo Rol</div>
                            <div class="titulo3"><i class="fa-solid fa-user"></i><a href="listaroles.php"> volver a roles</a></div>
                        </div>
                        <div class="contenedor_titulos ">
                        <div class="campos titulo">Nuevo Rol</div>
                        </div>';
    echo ' <div class="contenedor"><form class="registro" action="roles.php" method="post"> ';  
                 /* Llamo a la clase */
                $Json     = new Json;
                $Json->iniciarVariables();
                /* Voy a buscar roles existentes */
                /* Hago el select de roles */
                $xcomprol = $Json->selrol();
                $xrowrol = array();
                $xi=0;
                echo '<div class="inputs">
               <legend>Roles</legend>';
                echo '<SELECT name= "selrol" size=6 id="iseldrol" >';
                echo  '<option value="0" selected> No quiero seleccionar un Rol. Deseo crear uno nuevo</option>';
                while ($xrowrol = $Json->obtener_fila($xcomprol)) {
                    $nombrer[$xi] = utf8_encode($xrowrol['nombre_corto']) ;
                    $identificadorr[$xi] = $xrowrol['identificador'];
                    echo  '<option value="'.$identificadorr[$xi].'">'.$nombrer[$xi].'</option>';
                    $xi++;
                }
                echo '</select>';
                echo "</div>";
                /* ingreso campos del formulario */
                echo '<div class="inputs">';
                echo '<div><legend>Nombre: </legend><input name="nombre_corto" type="text" value="'.$nombre_corto.'"  > </div>';
                echo '<div><legend>Descripcion: </legend><input name="descripcion" type="text" value="'.$descripcion.'"  > </div></div>';
                /* Hago la busqueda de objetos para agregar permisos */
                $xcompobj = $Json->buscaobjetos();
                $xrowrobj = array();
                $xi=0;
                echo '<div class="inputs">
               <legend>Permisos</legend>';
                echo '<SELECT name= "objetos[]" multiple="multiple" size=10 id="idselobj" >';

                while ($xrowrobj = $Json->obtener_fila($xcompobj)) {
                    $nombreobjeto[$xi] = utf8_encode($xrowrobj['nom_objeto']) ;
                    $nombreclase[$xi] = utf8_encode($xrowrobj['nom_clase']) ;
                    $idclase[$xi] = $xrowrobj['id_clase'];
                    $idobjeto[$xi] = $xrowrobj['id_objeto'];
                    echo  '<option value="'.$idclase[$xi]."-".$idobjeto[$xi].'">'.$nombreclase[$xi]."---".$nombreobjeto[$xi].'</option>';
                    $xi++;
                }
                echo '</select>';
                echo "</div>";
                echo '
                <div class="inputs"><input class="btn_gris campos" type="reset" name="limpiar" value="limpiar">   ';
              echo '<input class="btn_azul" type="submit" name="enviar" value="Enviar" ></div>';
              echo "<br><!-- Rol -->
                    </form>
                    </div>
                    <div class=\"registro registro-b\">";
/* Publico mensajes del resultado de la insercion de usuarios */
       if ($correcto == "true")
           echo ' <div class="msj_verde"><span>'.$disp.'</span></div>';  
       elseif ($correcto == "false")
           echo ' <div class="msj_rojo"><span>'.$disp.'</span></div>';
       echo '</div>';
include 'footer.php'; ?>
</body>
</html>