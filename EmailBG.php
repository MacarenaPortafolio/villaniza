<?

    $DeEmail                        = isset($_REQUEST['DeEmail'])               && $_REQUEST['DeEmail']!=''              ? $_REQUEST['DeEmail']         : '';

    $DeNombre                       = isset($_REQUEST['DeNombre'])              && $_REQUEST['DeNombre']!=''             ? $_REQUEST['DeNombre']        : '';

    $asuntoX                        = isset($_REQUEST['asunto'])                && $_REQUEST['asunto']!=''               ? $_REQUEST['asunto']          : '';

    $telefono                       = isset($_REQUEST['telefono'])              && $_REQUEST['telefono']!=''             ? $_REQUEST['telefono']        : '';

    $mensajeX                       = isset($_REQUEST['mensaje'])               && $_REQUEST['mensaje']!=''              ? $_REQUEST['mensaje']         : '';

    $destinatarioX                  = isset($_REQUEST['destinatario'])          && $_REQUEST['destinatario']!=''         ? $_REQUEST['destinatario']    : '';



	// Variables para manejar el adjunto

	$hay_adjunto = false;

	$adjunto = null;

	$boundary = null;



	if( isset($_REQUEST[$_FILES['adjunto']]) && $_REQUEST[$_FILES['adjunto']['error']] === 0) {

		$hay_adjunto = true;

		$adjunto = $_FILES['adjunto'];

		$boundary = md5(time());

		$cuerpo = "--".$boundary. "\r\n";

		// Y el comienzo del HTML

		$cuerpo .= "Content-Type: text/html; charset=\"utf-8\"\r\n";

		$cuerpo .= "Content-Transfer-Encoding: 8bit\r\n\r\n";

	}





$destinatario = $destinatarioX; 

$asunto = $asuntoX; 

$cuerpo .= ' 

<html> 

<head> 

   <title>'.$asuntoX.'</title> 

</head> 

<body> 

<p>'.$mensajeX.' '.$archivo.' <b></p> 

</body> 

</html> 

'; 



//para el envío en formato HTML 

$headers = "MIME-Version: 1.0\r\n"; 



//dirección del remitente 

$headers .= "From: ".$DeNombre." <".$DeEmail.">\r\n"; 



//dirección de respuesta, si queremos que sea distinta que la del remitente 

$headers .= "Reply-To: ".$DeEmail."\r\n"; 



//ruta del mensaje desde origen a destino 

$headers .= "Return-path: \r\n"; 



//direcciones que recibián copia 

$headers .= "Cc:\r\n"; 



//direcciones que recibirán copia oculta 

$headers .= "Bcc: \r\n"; 





if( $hay_adjunto ) {

			$headers .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"";



			// Si hay archivo

			// También añadimos al cuermo del mensaje un separador 

			$cuerpo .= "\r\n";

			$cuerpo .= "--" . $boundary . "\r\n";

			// Y el archivo con su correspondiende Content-Type (octet-stream para aplicaciones) y nombre

			$cuerpo .= "Content-Type: application/octet-stream; name=\"".$adjunto['name']."\"\r\n";

			$cuerpo .= "Content-Transfer-Encoding: base64\r\n";



			// Indicamos que es un adjunto

			$cuerpo .= "Content-Disposition: attachment\r\n\n\r";



			// Vamos con el adjunto: chunk_split transforma la cadena en base64 en estandar

			$cuerpo .= chunk_split(base64_encode(file_get_contents($adjunto['tmp_name']))) . "\r\n";



			// Acabamos el mensaje

			$cuerpo .= "--" . $boundary . "--";

		} else {

			// Si no lo hay nos bastará con decir que es un mensaje HTML

			$headers .= "Content-type: text/html; charset=utf-8\r\n";

		}











mail($destinatario,$asunto,$cuerpo,$headers) 



?>

