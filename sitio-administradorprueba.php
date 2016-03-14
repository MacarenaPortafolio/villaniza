<?php require_once('Connections/localhost.php'); ?>
<?php require_once('Connections/localhost.php'); ?>
<?php require_once('Connections/localhost.php');

require_once('Connections/localhost.php');
require_once('Connections/bd.php');

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index-administradorprueba.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "administrador";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index-administradorprueba.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$colname_consulta1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_consulta1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_consulta1 = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_consulta1, "text"));
$consulta1 = mysql_query($query_consulta1, $localhost) or die(mysql_error());
$row_consulta1 = mysql_fetch_assoc($consulta1);
$totalRows_consulta1 = mysql_num_rows($consulta1);

mysql_select_db($database_localhost, $localhost);
$query_consulta2 = "SELECT id, nombre, apellido, email FROM usuarios  WHERE admin = 'si'";
$consulta2 = mysql_query($query_consulta2, $localhost) or die(mysql_error());
$row_consulta2 = mysql_fetch_assoc($consulta2);
$totalRows_consulta2 = mysql_num_rows($consulta2);
$id_usuario = $row_consulta1['id'];
$db = new mysql;
$x= count($row_consulta2);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador Villa Niza</title>
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,400,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/style-niza.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script language="javascript">

$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                       
            });         
        }
    });
    
});

</script>




</head>

<body>
	<div class="contenedor-grande sesion administrador">
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
                <div class="bg-top"></div>
                <p class="bienvenido">ADMINISTRADOR</p>
                	<table border="1">
  <tr>
    <th class="th">NOMBRE:</th>
    <td><?php echo $row_consulta1['nombre']; ?> <?php echo $row_consulta1['apellido']; ?></td>
    <input type="hidden" id="nombre" name="nombre" value="<?php echo $row_consulta1['nombre']; ?> <?php echo $row_consulta1['apellido']; ?>"/>
  </tr>
  <tr>
    <th class="th">RUT:</th>
    <td><?php echo $row_consulta1['rut']; ?></td>
  </tr>
 <?php /*?><tr>
    <th class="th">E-MAIL:</th>
    <td ><?php echo $row_consulta1['email']; ?></td>
    <input type="hidden" id="email" name="email" value="<?php echo $row_consulta1['email']; ?>"/>
  </tr><?php */?>
</table>
                <div class="links-login">
      <!-- <a class="links" href="cambiar-contrasena.php?id=<?php echo $row_consulta1['id']; ?>" title="Cambiar Contraseña">MODIFICAR CONTRASEÑA</a>-->
        <!--<a class="links" href="modificar-datos.php" title="Modificar Datos">MODIFICAR DATOS</a>-->
        <form action="" method="get" name="form-sesion">
          <a class="links" href="<?php echo $logoutAction ?>" title="Cerrar Sesión">CERRAR SESIÓN</a>
        </form>
           </div>
                
                </div>
            </div>
            
          <div class="contenido-azul info-gastos">
            
     <?php 
	       	 $MesActual = date("m");
		     $AnoActual = date("Y");		    
		     
		     if($MesActual==1){
		     
			     $Ano = $AnoActual-1;
			     $Mes = 12;			     
		     }else{		     
			     $Mes = $MesActual-1;
			     $Ano = $AnoActual;			     
		     }
		     $query = "SELECT descripcion FROM mes where id = ".$Mes."";
			     $rs = $db->query($query);
			     $NMes     		= isset($rs[0]['descripcion'])      		&& $rs[0]['descripcion']!=''         			? $rs[0]['descripcion'] 		: '';
       ?>     
      
      <h1>INFORMACIÓN DE GASTOS Y MOROSIDAD</h1>
      
      <div class="contenedor-tabla-pagos">
      <table>
			<p>ESTADO DE CUENTA DE MARZO DE 2015</p>
			<tr class="thead">
				<td class="td">Id</td>	
				<td class="td">Nombre</td>
				<td class="td">Ultimo Pago Registrado</td>
                <td class="td">Fecha Ultimo Pago</td>	
				<td class="td">Saldo</td>	
                						
			</tr>
            
      <?php 
		  	/*Listar */
		    $query = "SELECT ultimo_pago , saldo , fecha , us.id as id,us.nombre as nombre,us.apellido as apellido FROM cuentas as cu left join usuarios as us on id_usuario = us.id where us.estado = 1 and id_mes = ".$Mes." and ano = ".$Ano."";
            $rs = $db->query($query);
            $contador = count($rs);
             while ($contador<1){                               
                             if(count($rs)==0){
                                
                                        if($Mes==1){
                    		     
                    			             $Ano = $AnoActual-1;
                    			             $Mes = 12;			     
                            		     }else{            		     
                            			     $Mes = $Mes-1;
                            			     $Ano = $AnoActual;
                            		     }			        
                            $query = "SELECT ultimo_pago , saldo , fecha , us.id as id,us.nombre as nombre,us.apellido as apellido FROM cuentas as cu left join usuarios as us on id_usuario = us.id where us.estado = 1 and id_mes = ".$Mes." and ano = ".$Ano."";
                			$rs = $db->query($query);
                            $contador = count($rs);
                                }   
                    }
			if(is_array($rs) && count($rs)>0){            
            foreach($rs as $row){
		            $id    			= isset($row['id'])    			&& $row['id']!=''         			? $row['id'] 			: '';
		            $nombre    		= isset($row['nombre'])    		&& $row['nombre']!=''         		? $row['nombre'] 		: '';
		            $apellido    	= isset($row['apellido'])   	&& $row['apellido']!=''         	? $row['apellido'] 		: '';
		            $ultimo_pago    = isset($row['ultimo_pago'])    && $row['ultimo_pago']!=''         	? $row['ultimo_pago'] 	: '';
					$saldo     		= isset($row['saldo'])			&& $row['saldo']!=''         		? $row['saldo'] 		: '';
					$fecha     		= isset($row['fecha'])			&& $row['fecha']!=''         		? $row['fecha'] 		: '';
					?>
					<tr class="td-bottom">
						<td class="td"><?php echo $id ?></td>
						<td class="td"><?php echo $nombre." ".$apellido ?></td>
						<td class="td">$ <?php echo $ultimo_pago ?></td>
                        <td class="td"> <?php echo $fecha ?></td>
                        <td class="td">$ <?php echo $saldo ?></td>				
					</tr>
					<?php
                
				}
			}
	      ?>
	</table>
    </div>      

    </div>
          <div class="formulario-contacto">
            
            <form action="sitio-administradorprueba.php" method="post" enctype="multipart/form-data"> 
            
<div class="contenedor-lista-usuarios">
	SELECCIONE USUARIO <br>
    <input type="checkbox" id="selecctall"/> Seleccionar todos los usuarios.
	<div class="lista-usuarios">  
      
    <?php
        $i = 1; 
        do { ?>        
      <input name="emailsocio[]" class="checkbox1" type="checkbox" value="<?php echo $row_consulta2['email']; ?>," />
       
      <?php echo $row_consulta2['id']; ?> 
	  <?php echo $row_consulta2['nombre']; ?> 
	  <?php echo $row_consulta2['apellido']; ?><br />
      <?php $i++;} while ($row_consulta2 = mysql_fetch_assoc($consulta2)); ?>
      
      <input name="cantidad" id="cantidad" type="hidden" value="<?php echo $i ?>" />
      
     <?php /*?> <input type="checkbox" name="emailsocio[]" value="maky.oviedo@gmail.com,">Maky1
        <input type="checkbox" name="emailsocio[]" value="maky.oviedo@gmail.com,">Maky2
        <input type="checkbox" name="emailsocio[]" value="macarena@hostingdedicado.net,">Alejandra<?php */?>
	</div>
  
</div> 


<div class="contenedor-form-admin">
<div class="form-izquierdo">
<br/>NOMBRE:<br/> <input type='text' name='nombre' id='nombre' value="<?php echo $row_consulta1['nombre']; ?> <?php echo $row_consulta1['apellido']; ?>" required />
<br/>EMAIL:<br/><input type='text' name='emailadmin' id='emailadmin' value="<?php echo $row_consulta1['email']; ?>" />
<input type="hidden" name='asunto' id='asunto' value="Contacto" />
<br/>ASUNTO: <br/><input type='text' name='asunto2' id='asunto2' required />
<br/>
ADJUNTAR ARCHIVO <input id="archivo" name="archivo" type="file">
</div>
<div class="form-derecho">
MENSAJE:<br/>
<textarea name="mensaje" id="mensaje" cols="35" rows="10"></textarea><br/>
<input name="enviar" type="submit" value="ENVIAR"> 
</div>
</div>
</form>  


          
                        <!--<form name='formulario' id='formulario' method='post' action='enviar-administrador.php' target='_self' enctype="multipart/form-data">
            			<label>NOMBRE</label>
                    	<input name="de" type="text" value="">
                    	<label>PARA:</label>
                    	<input name="para" type="text" value="">
                    	<label>FECHA</label>
                    	<input name="fecha" type="text" value="">
                        <label>ASUNTO</label>
                    	<input name="asunto" type="text" value="">
                         <label>ADJUNTAR ARCHIVO </label>
                    	<input class="upload" type="file" name="archivo1" cols="" rows=""></input>
                        <label>COMENTARIO </label>
                    	<textarea name="mensaje" cols="" rows=""></textarea>
                    	<input type="submit" value="ENVIAR">
                    
            </form>-->
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


//if ($_SERVER["REQUEST_METHOD"] == "POST") {  
//    $email=$_POST["emails"];
//    $count = count($email);
//    for ($i = 0; $i < $count; $i++) {
//        echo $email[$i];
//    }
//} 



///////Configuración/////
$emails = array();
foreach($_POST['emailsocio'] as $email) {
   // Each $email is added as the next array entry, using [] 
   $emails[] = $email; 
}
$mail_destinatario = implode(',', $emails);
///////Fin configuración//

///// Funciones necesarias////
function form_mail($sPara, $sAsunto, $sTexto, $sDe)
{
$bHayFicheros = 0;
$sCabeceraTexto = "";
$sAdjuntos = "";  
//if ($sDe)$sCabeceras = "From:".$sDe."\n";
//else $sCabeceras = "";
$sCabeceras .= "MIME-version: 1.0\n";

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$asunto = $_POST['asunto'];
$mensaje= $_POST['mensaje'];
$emailadmin= $_POST['emailadmin'];



$sCabeceras = "From: "."Villaniza"." \r\n";
$sDe =  $sDe.$_POST['emailadmin'];
$sTexto = $sTexto."Mensaje enviado desde Villaniza"."\n"."\n";
$sTexto = $sTexto."Asunto: ".$_POST['asunto2']."\n";
$sTexto = $sTexto."Comentario: ".$_POST['mensaje']."\n";



foreach ($_FILES as $vAdjunto)
{
if ($bHayFicheros == 0)
{
$bHayFicheros = 1;
$sCabeceras .= "Content-type: multipart/mixed;";
$sCabeceras .= "boundary=\"--_Separador-de-mensajes_--\"\n";
$sCabeceraTexto = "----_Separador-de-mensajes_--\n";
$sCabeceraTexto .= "Content-type: text/plain;charset=iso-8859-1\n";
//$sCabeceraTexto .= "Content-transfer-encoding: 7BIT\n";
$sTexto = $sCabeceraTexto.$sTexto;
}
if ($vAdjunto["size"] > 0)
{
$sAdjuntos .= "\n----_Separador-de-mensajes_--\n";
$sAdjuntos .= "Content-type: ".$vAdjunto["type"].";name=\"".$vAdjunto["name"]."\"\n";;
$sAdjuntos .= "Content-Transfer-Encoding: BASE64\n";
$sAdjuntos .= "Content-disposition: attachment;filename=\"".$vAdjunto["name"]."\"\n\n";
$oFichero = fopen($vAdjunto["tmp_name"], 'r');
$sContenido = fread($oFichero, filesize($vAdjunto["tmp_name"]));
$sAdjuntos .= chunk_split(base64_encode($sContenido));
fclose($oFichero);
}
}
if ($bHayFicheros)
$sTexto .= $sAdjuntos."\n\n----_Separador-de-mensajes_----\n";
return(mail($sPara, $sAsunto, $sTexto, $sCabeceras));
}

if (isset ($_POST['enviar'])) {

if (form_mail ($mail_destinatario, $_POST['asunto']))

 echo "<script type=\"text/javascript\">alert('Mensaje enviado con éxito');</script>"; 

; }


?>


<?php
mysql_free_result($consulta1);

mysql_free_result($consulta2);
?>
