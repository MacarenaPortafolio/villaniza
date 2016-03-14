<?php

require_once('class.phpmailer.php');



    $DeEmail                      = isset($_REQUEST['DeEmail'])               && $_REQUEST['DeEmail']!=''              ? $_REQUEST['DeEmail']         : '';

    $DeNombre                     = isset($_REQUEST['DeNombre'])              && $_REQUEST['DeNombre']!=''             ? $_REQUEST['DeNombre']        : '';

    $asunto                       = isset($_REQUEST['asunto'])                && $_REQUEST['asunto']!=''               ? $_REQUEST['asunto']          : '';

    $telefono                     = isset($_REQUEST['telefono'])              && $_REQUEST['telefono']!=''             ? $_REQUEST['telefono']        : '';

    $mensaje                      = isset($_REQUEST['mensaje'])               && $_REQUEST['mensaje']!=''              ? $_REQUEST['mensaje']         : '';

    $destinatario                 = isset($_REQUEST['destinatario'])          && $_REQUEST['destinatario']!=''         ? $_REQUEST['destinatario']    : '';

   // $adjunto                      = isset($_REQUEST[])               && $_REQUEST[]              ? $_REQUEST[]         : '';





$mail = new PHPMailer();



$mail->IsHTML(true);

$mail->Host = "localhost";

$mail->From = $DeEmail;

$mail->FromName = $DeNombre; 

$mail->addAddress($destinatario);

$mail->Subject = $asunto ;

$mail->AltBody = '';

$mail->Body = $mensaje;

$mail->CharSet = 'UTF-8';

$archivo = $adjunto;

$mail->AddAttachment($archivo,$archivo);



if (!$mail->send()) {

    echo "Mailer Error: " . $mail->ErrorInfo;

   }



?> 