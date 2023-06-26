<?php

/*********** INCLUIR LA CONEXION *************/
$mysqli = new mysqli('localhost','risk_hunter','Kaliman01*','sipman_risk_hunter');
/*********** DECLARACION DE VARIABLES *************/
if (isset($_POST['registrarCliente'])) {

   echo $firmaInspectora = $_POST['nombreFirma'];
   echo $direccion = $_POST['direccion'];
   echo $tipoDocumento = $_POST['tipoDoc'];
   echo $numeroIdentificacion = $_POST['numeroIdentificacion'];
   echo $numeroContacto = $_POST['telefono'];
   echo $correoElectronico = $_POST['correoElectronico'];
   echo $paises_id = $_POST['paises_id'];
   echo $departamento_id = $_POST['departamento_id'];
   echo $ciudad_id = $_POST['ciudad_id'];
   echo $tipoEstado = 20;
   echo $tipoTercer = 772;
  
   $insertaRegistro = $mysqli->query("INSERT INTO ter_terceros(vdom_tipo_identificacion,nombres,vdom_tipo_tercero,tipo_estado,estado,numero_identificacion,pais,departamento,ciudad,direccion,correo_electronico,telefono,tipoCliente)
   VALUES('$tipoDocumento','$firmaInspectora','$tipoTercer','$tipoEstado','1','$numeroIdentificacion','$paises_id','$departamento_id','$ciudad_id','$direccion','$correoElectronico','$numeroContacto','1')");
   
  
    
  echo '<script language="javascript">alert("Se ha registrado el cliente ' . strtoupper($firmaInspectora) . ' correctamente.");
        window.location.href="../registroClientes.php"</script>';
}

if (isset($_POST['editar'])) {
    
   $id = $_POST['id'];        
   $firmaInspectora = $_POST['nombreFirma'];
   $direccion = $_POST['direccion'];
   $tipoDocumento = $_POST['tipoDocumento'];
   $numeroIdentificacion = $_POST['numeroIdentificacion'];
   $numeroContacto = $_POST['telefono'];
   $correoElectronico = $_POST['correoElectronico'];
   $paises_id = $_POST['paises_id'];
   $departamento_id = $_POST['departamento_id'];
   $ciudad_id = $_POST['ciudad_id'];
   $tipoEstado = 20;
   $tipoTercer = 772;
    
   $editarRegistro = $mysqli->query("UPDATE ter_terceros SET nombres = '$firmaInspectora',vdom_tipo_identificacion = '$tipoDocumento',tipo_estado='$tipoEstado',numero_identificacion='$numeroIdentificacion',pais = '$paises_id',departamento='$departamento_id',ciudad='$ciudad_id',direccion='$direccion',correo_electronico='$correoElectronico',telefono='$numeroContacto' WHERE identificacion = '$id'");
    
     echo '<script language="javascript">alert("Se ha actualizado el registro");
        window.location.href="../registroClientes.php"</script>';
}

if (isset($_POST['desactivar'])) {
    'BLOQUEAR';
    
     /*
   Tipos Cliente(variables estado BD)
   
        1 => Cliente Nuevo
        2 => Cliente Desactivado
   
   */
    $idFirma= $_POST['id'];
    
    $actualizaEstado = $mysqli->query("UPDATE ter_terceros SET estado='0' WHERE identificacion='$idFirma'");
    
     /*********** ALERTA DE REDIRECCIONAMIENTO *************/
  echo '<script language="javascript">alert("Se ha desactivado el cliente");
        window.location.href="../listarClientesDesactivados.php"</script>';
}


if (isset($_POST['activar'])) {
    'ACTIVAR';
    $idFirma= $_POST['id'];
    
    $actualizaEstado = $mysqli->query("UPDATE ter_terceros SET estado='1' WHERE identificacion='$idFirma'");
    
     /*********** ALERTA DE REDIRECCIONAMIENTO *************/
  echo '<script language="javascript">alert("Se ha activado el cliente");
        window.location.href="../listaClientes.php"</script>';
}

if (isset($_POST['editar'])) {
     $idFirma= $_POST['id'];
     $firmaInspectora = $_POST['nombreFirma'];
     $tipoDocumento = $_POST['tipoDocumento'];
     $numeroIdentificacion = $_POST['numeroIdentificacion'];
     $direccion = $_POST['direccion'];
     $numeroContacto = $_POST['telefono'];
     $correoElectronico = $_POST['correoElectronico'];
     $paises_id = $_POST['paises_id'];
     $departamento_id = $_POST['departamento_id'];
     $ciudad_id = $_POST['ciudad_id'];
     $tipoTercer = 772;
  
    $actualizaClientes= $mysqli->query("UPDATE ter_terceros SET nombres = '$firmaInspectora' ,vdom_tipo_identificacion='$tipoDocumento',numero_identificacion='$numeroIdentificacion',pais='$paises_id',ciudad = '$ciudad_id', departamento='$departamento_id',correo_electronico='$correoElectronico',telefono = '$numeroContacto' WHERE identificacion='$idFirma'");
    echo '<script language="javascript">alert("Cliente Actualizado");
        window.location.href="../listaClientes.php"</script>';
}











