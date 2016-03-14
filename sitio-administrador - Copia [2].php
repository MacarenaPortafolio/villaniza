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
	
  $logoutGoTo = "index-administrador.php";
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

$MM_restrictGoTo = "index-administrador.php";
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
<script src="js/js.js"></script>
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
            
            <form name='formulario' id='formulario' method='post'  target='_self' enctype="multipart/form-data"> 
            
<div class="contenedor-lista-usuarios">
	SELECCIONE USUARIO <br><input name="todos" id="todos" type="checkbox" value="todos" class="check" onchange="Cambio()"/> Seleccionar todos los usuarios.
	<div class="lista-usuarios">    
    <?php
        $i = 1; 
        do { ?>        
      <input name="checkbox-<?php echo $i; ?>" id="checkbox-<?php echo $i; ?>" type="checkbox" value="<?php echo $row_consulta2['email']; ?>" /> 
      <?php echo $row_consulta2['id']; ?> <?php echo $row_consulta2['nombre']; ?> <?php echo $row_consulta2['apellido']; ?><br />
      <?php $i++;} while ($row_consulta2 = mysql_fetch_assoc($consulta2)); ?>
      <input name="cantidad" id="cantidad" type="hidden" value="<?php echo $i ?>" />
      
	</div>
  
</div>   
<div class="contenedor-form-admin">
<div class="form-izquierdo">
<br/>NOMBRE:<br/> <input type='text' name='nombre' id='nombre' value="<?php echo $row_consulta1['nombre']; ?> <?php echo $row_consulta1['apellido']; ?>" required>
<br/>TELEFONO:<br/><input type='text' name='telefono' id='telefono' value="" />
<br/>ASUNTO: <br/><input type='text' name='asunto' id='asunto' required />
<br/>
ADJUNTAR ARCHIVO <input  type='file' name='file' id='file' onchange="Archivo()" />
</div>
<div class="form-derecho">
MENSAJE:<br/>
<textarea name="mensaje" id="mensaje" cols="35" rows="10"></textarea><br/>
<input  id='boton-enviar' type='button' value='ENVIAR' onclick="Enviar()"/> 
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
mysql_free_result($consulta1);

mysql_free_result($consulta2);
?>
