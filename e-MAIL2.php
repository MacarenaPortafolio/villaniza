<?php
require_once('class.phpmailer.php');
error_reporting(E_ALL);
ini_set("display_errors", 1);

    $DeEmail                        = isset($_REQUEST['DeEmail'])               && $_REQUEST['DeEmail']!=''              ? $_REQUEST['DeEmail']         : '';
    $DeNombre                       = isset($_REQUEST['DeNombre'])              && $_REQUEST['DeNombre']!=''             ? $_REQUEST['DeNombre']        : '';
    $asunto                        = isset($_REQUEST['asunto'])                && $_REQUEST['asunto']!=''               ? $_REQUEST['asunto']          : '';
    $telefono                       = isset($_REQUEST['telefono'])              && $_REQUEST['telefono']!=''             ? $_REQUEST['telefono']        : '';
    $mensaje                       = isset($_REQUEST['mensaje'])               && $_REQUEST['mensaje']!=''              ? $_REQUEST['mensaje']         : '';
    $destinatario                 = isset($_REQUEST['destinatario'])          && $_REQUEST['destinatario']!=''         ? $_REQUEST['destinatario']    : '';


$mail = new PHPMailer();
//die("Prueba");
$mail->IsHTML(true);
$mail->Host = "localhost";
$mail->setFrom($DeEmail); 
$mail->FromName($DeNombre);
$mail->addAddress($destinatario);
$mail->Subject = ($asunto) ;
$mail->AltBody = '';
$mail->Body = $mensaje;
$mail->CharSet = 'UTF-8';
//$archivo = 'Email.php';
//$mail->AddAttachment($archivo,$archivo);
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
   }

?> 