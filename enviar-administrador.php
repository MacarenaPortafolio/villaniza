<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mensaje Enviado</title>
</head>

<body>

 <?php 
	  
	  if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $numero=$_POST["numero"];
    $count = count($numero);
    for ($i = 0; $i < $count; $i++) {
        echo $numero[$i];
    }
}
	  
	  ?>

            <?php
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$asunto = $_POST['asunto'];
$mensaje= $_POST['mensaje'];

$header = "From: " . $nombre . " \r\n";
$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
$header .= "Mime-Version: 1.0 \r\n";
$header .= "Content-Type: text/plain";

$mensaje = "Este mensaje fue enviado por " . $nombre . " \r\n";
$mensaje .= "Su e-mail es: " . $email . " \r\n";
$mensaje .= "Mensaje: " . $_POST['mensaje'] . " \r\n";
$mensaje .= "Enviado el " . date('d/m/Y', time());

$para = 'maky.oviedo@gmail.com' ;
$asunto = 'Contacto Villa Niza';

mail($para, $asunto, utf8_decode($mensaje), $header);

echo "Mensaje enviado";
?>
           
</body>
</html>