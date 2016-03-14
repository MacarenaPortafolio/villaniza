<?php require_once('Connections/localhost.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_localhost, $localhost);
$query_consulta1 = "SELECT * FROM usuarios";
$consulta1 = mysql_query($query_consulta1, $localhost) or die(mysql_error());
$row_consulta1 = mysql_fetch_assoc($consulta1);
$totalRows_consulta1 = mysql_num_rows($consulta1);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['contrasena'];
  $MM_fldUserAuthorization = "privilegios";
  $MM_redirectLoginSuccess = "sitio-socio.php";
  $MM_redirectLoginFailed = "contacto.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_localhost, $localhost);
  	
  $LoginRS__query=sprintf("SELECT usuario, contrasena, privilegios FROM usuarios WHERE usuario=%s AND contrasena=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'privilegios');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Contacto Villa Niza</title>
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,400,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/style-niza.css">


</head>

<body>
	<div class="contenedor-grande contacto">
    	<header>
        	<nav> 
            	<ul> 
                	<li><a href="index.php" title="Inicio">INICIO </a> <p>Comenzar </p></li>
                    <li><a href="villaniza.php" title="Villa Niza">VILLA NIZA </a><p>Conoce Villa Niza</p></li>
                    <li><a href="proyectos.php" title="Proyectos">PROYECTOS</a><p>Proyectos para Villa Niza</p></li>
                    <li><a href="galeria.php" title="Galería">GALERÍA</a><p>Vive Villa Niza</p></li>
                    <li class="ultimo-elemento"><a href="contacto.html"  title="Contacto">CONTACTO</a><p>Contáctese con nosotros</p></li>
                </ul>
            </nav>
        </header>
    	<div class="wrap">
            <aside>
            	<div class="login">
                	
                	<p class="ingresa">INGRESA A TU CUENTA</p>
                    <p class="letra-celeste">Villa Niza</p>
                    <form action="<?php echo $loginFormAction; ?>" method="POST" name="ingresousuarios">
                    <label>Usuario</label>
                    <input name="usuario" type="text" value="" id="usuario">
                    <label>Contraseña</label>
                    <input name="contrasena" type="password" value="" id="contrasena">
                    <input title="Ingresar" name="ingresar" type="submit" value="INGRESAR">
                    
                    </form>
                </div>
             <!--   <div class="visita">
               		<h2>VISITA</h2>
                    <a href="index.php" title="Comenzar">INICIO</a>
                    <a href="villaniza.php" title="Conoce Villa Niza">VILLA NIZA</a>
                
                </div>-->
                    
            </aside>
            <div class="enviar">
        
            <?php
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$asunto = $_POST['asunto'];
$comentario= $_POST['comentario'];

$header = "From: " . $nombre . " \r\n";
$header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
$header .= "Mime-Version: 1.0 \r\n";
$header .= "Content-Type: text/plain";

$mensaje = "Este mensaje fue enviado por " . $email . " \r\n";
$mensaje .= "Su e-mail es: " . $email . " \r\n";
$mensaje .= "Mensaje: " . $_POST['comentario'] . " \r\n";
$mensaje .= "Enviado el " . date('d/m/Y', time());

$para = 'presidente@villaniza.cl; secretario@villaniza.cl; tesorero@villaniza.cl; info@villaniza.cl' ;
$asunto = 'Contacto Villa Niza';

mail($para, $asunto, utf8_decode($mensaje), $header);

echo '';
?>
            
              <p>¡MENSAJE ENVIADO CON ÉXITO!<p>
            </div>
            <div class="contenido-azul"> 
            	<h1>CONTACTO</h1>
            	<div class="mapa"> 
                	<h1><a href="#" title="¡Visítanos!">VISÍTANOS</a></h1>
                    <iframe width="244" height="166" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" class="foto" src="https://maps.google.cl/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=santa+rosa+5090&amp;aq=&amp;sll=-33.668298,-70.363372&amp;sspn=1.636675,3.348083&amp;ie=UTF8&amp;hq=&amp;hnear=Santa+Rosa+5090,+San+Joaqu%C3%ADn,+Santiago,+Regi%C3%B3n+Metropolitana&amp;t=m&amp;z=14&amp;ll=-33.503938,-70.638876&amp;output=embed"></iframe><br /><small><a href="https://maps.google.cl/maps?f=q&amp;source=embed&amp;hl=es&amp;geocode=&amp;q=santa+rosa+5090&amp;aq=&amp;sll=-33.668298,-70.363372&amp;sspn=1.636675,3.348083&amp;ie=UTF8&amp;hq=&amp;hnear=Santa+Rosa+5090,+San+Joaqu%C3%ADn,+Santiago,+Regi%C3%B3n+Metropolitana&amp;t=m&amp;z=14&amp;ll=-33.503938,-70.638876" style="color:#0000FF;text-align:left" title="Ver mapa más grande">Ver mapa más grande</a></small>
                   
                </div>
                <div class="datos">
                	<p>Algarrobo,Sector El Litre, Villa Niza.</br> Hijuela del Aserradero, lotes 3A y 3B </p>
            		<p>info@villaniza.cl</p>
            		<p>25521503</p>
                   
                </div>
                    
                   
                </div>
            </div>
      
        <div class="div-separador"> </div>
     <footer>
        	
          <div class="datos-footer">
            	<p>Algarrobo,Sector El Litre, Villa Niza. Hijuela del Aserradero, lotes 3A y 3B.</p>
            	<p>E-mail: info@villaniza.cl - Teléfono: 25521503</p>
            
        	</div>
        </footer>
    </div>
</body>
</html>
<?php
mysql_free_result($consulta1);
?>