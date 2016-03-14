<?php
error_reporting(1);
ini_set("display_errors", 1);
?>
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
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_localhost, $localhost);
  	
  $LoginRS__query=sprintf("SELECT id,usuario, contrasena, privilegios FROM usuarios WHERE usuario=%s AND contrasena=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'privilegios');
    $id_Usuario  = mysql_result($LoginRS,0,'id');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
    $_SESSION['User'] = $id_Usuario;	      

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
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,400,300,700' rel='stylesheet' type='text/css'>
<title>Inicio Villa Niza</title>
<link rel="stylesheet" type="text/css" href="css/style-niza.css">
</head>

<body>
<div class="contenedor-grande">
<div class="top-login-admin"><p><a href="index-administrador.php">ACCESO ADMINISTRADOR </a></p> </div>

 </div>
	<div class="contenedor-grande index">
    	<header>
        	<nav> 
            	<ul> 
                	<li><a href="index.php" title="Inicio">INICIO </a> <p>Comenzar </p></li>
                    <li><a href="villaniza.php" title="Villa Niza">VILLA NIZA </a><p>Conoce Villa Niza</p></li>
                    <li><a href="proyectos.php" title="Proyectos">PROYECTOS</a><p>Proyectos para Villa Niza</p></li>
                    <li><a href="galeria.php" title="Galería">GALERÍA</a><p>Vive Villa Niza</p></li>
                    <li class="ultimo-elemento"><a href="contacto.php"  title="Contacto">CONTACTO</a><p>Contáctese con nosotros</p></li>
                </ul>
            </nav>
        </header>
    	<div class="wrap">
        	<div class="banner"> 
            	<div class="foto"></div>
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
            </div>
            <div class="contenido-azul index"> 
            	<div class="reseña-villa"> 
                	<h1><a href="villaniza.php" title="¡Conoce Villa Niza!">VILLA NIZA</a></h1>
                    <div class="foto"> </div>
                    <p>Villa Niza es un condominio que se encuentra ubicado a metros del centro en la comuna de Algarrobo...
</p><a href="villaniza.php" class="leer-mas" title="Leer más">Leer Más</a>
                
                </div>
                <div class="galeria-villa"> 
                	<h1><a href="galeria.php" title="¡Visita nuestra galería!">VISITA NUESTRA GALERÍA</a></h1>
                    <a href="galeria.php" title="Galería"><div class="foto"> </div></a>
                   
                </div>
                <div class="mapa"> 
                	<h1><a href="contacto.php" title="¡Visítanos!">VISÍTANOS</a></h1>
                   <iframe src="https://www.google.com/maps/embed?pb=!1m25!1m12!1m3!1d3331.610980674862!2d-71.65639613145632!3d-33.381220870528544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m10!1i0!3e2!4m3!3m2!1d-33.3839622!2d-71.65507649999999!4m3!3m2!1d-33.3783898!2d-71.6581771!5e0!3m2!1ses!2scl!4v1400371285630" width="244" height="166" frameborder="0" style="border:0"></iframe><br />
                    
                    
                </div>
                <div class="clear"> </div>
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
