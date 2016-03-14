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
  $MM_redirectLoginFailed = "villaniza.php";
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
<title>Conoce Villa Niza</title>
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,400,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/style-niza.css">
<!--Galería-->

<link rel="stylesheet" type="text/css" href="css/base.css">
<script type="text/javascript" src=" https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="js/jquery.jcarousel.min.js"></script>
<script src="js/jquery.pikachoose.min.js"></script>
<script language="javascript">
			$(document).ready(
				function (){
					$("#pikame").PikaChoose();
				});
		</script>
<!--Galería-->

</head>

<body>
<div class="contenedor-grande">
<div class="top-login-admin"><p><a href="index-administrador.php">ACCESO ADMINISTRADOR </a></p> </div>

 </div>
	<div class="contenedor-grande villa-niza">
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
            <div class="visita">
               		<h2>PLANO DE LOTEO VILLA NIZA</h2>
                    <a href="#" title="Descargar Plano de Loteo">DESCARGAR PLANO</a>
               
                </div>
                  
            </aside>
    	<div class="wrap">
        
        	<div class="foto-grande"> 
            <div class="pikachoose">
	<ul id="pikame" >
		<li><a href="#"><img src="img/villagrande1.jpg"></a></li>
		<li><a href="#"><img src="img/villagrande2.jpg"></a></li>
		<li><a href="#"><img src="img/villagrande3.jpg"></a></li>
        <li class="ultimo-elemento"><a href="#"><img src="img/villagrande4.jpg"></a></li>
		
	</ul>
</div>
            </div>
            
            <div class="clear"> </div>
            <div class="contenido-azul"> 
            <h1>CONOCE VILLA NIZA</h1>
            	<div class="reseña"> 
                    <div class="foto"> </div>
                    <p>Villa Niza es un condominio que se encuentra ubicado a metros del centro en la comuna de Algarrobo, en el sector El Litre, el cual ha sido construido con el esfuerzo de sus socios durante los años, logrando aprovechar al máximo su belleza natural. Bosques nativos, quebradas y diversa fauna rodean la comunidad, convirtiéndolo en un excelente lugar para descansar y disfrutar de la naturaleza.</p>
                    <p>EL condominio cuenta con 52 sitios con electricidad, agua potable y alcantarillado particular. Además la calidad de la construcción de sus casas demuestra el esfuerzo y preocupación que cada propietario ha puesto en ello. Agradables senderos, hermosos árboles pueden ser recorridos tranquilamente.  </p>
                   
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
