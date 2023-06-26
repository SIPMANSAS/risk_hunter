<?php
require 'libreria/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 587;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'tls';
  $mail->Username = 'movipsas2@gmail.com';
  $mail->Password = 'movipsasco222';

  $mail->setFrom('juanrinconaxl926@gmail.com');
  $mail->addAddress('juanrinconaxl926@gmail.com');
  //$mail->addReplyTo($_POST['email_lead']);
  $mail->addReplyTo('juanrinconaxl926@gmail.com');

  $mail->isHTML(true);
  $mail->Subject = 'Registro Sistema Nuevo Usuario';
  $mail->Body = '<h3 align=center>BIENVENIDO A MOVIP S.A.S <br><br> Usted ha sido registrado como cliente en nuestro sistema CRM mediante el cual podra realizar el seguimiento de las facturas y las reuniones de los proyectos que usted desee desarrollar con nosotros,por este medio recibira los enlaces para las reuniones que se programen en el transcurso de la realizacion de sus proyectos.<br><br>Pronto nos contactaremos a sus numeros de domicilio para asignar las credenciales las cuales le permitan acceder y llevar un mejor seguimiento de sus proyectos y facturas <br><br> Gracias por contactarnos </h3>';

  if (!$mail->send()) {
    echo "ERROR";
  } else {
    echo "<script> alert('Confirmacion Enviada');
  window.location.href= 'gestionarclientes';
  </script>";
  }


?>