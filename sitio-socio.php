<?php 
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
	
  $logoutGoTo = "index.php";
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
$MM_authorizedUsers = "socio";
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

$MM_restrictGoTo = "index.php";
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
$id_usuario = $row_consulta1['id'];
$db = new mysql;

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Socio Villa Niza</title>
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,400,300,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="css/style-niza.css">
</head>

<body>
<div class="contenedor-grande sesion">
  <header>
    <nav>
      <ul>
        <li><a href="index.php" title="Inicio">INICIO </a>
          <p>Comenzar </p>
        </li>
        <li><a href="villaniza.php" title="Villa Niza">VILLA NIZA </a>
          <p>Conoce Villa Niza</p>
        </li>
        <li><a href="proyectos.php" title="Proyectos">PROYECTOS</a>
          <p>Proyectos para Villa Niza</p>
        </li>
        <li><a href="galeria.php" title="Galería">GALERÍA</a>
          <p>Vive Villa Niza</p>
        </li>
        <li class="ultimo-elemento"><a href="contacto.php"  title="Contacto">CONTACTO</a>
          <p>Contáctese con nosotros</p>
        </li>
      </ul>
    </nav>
  </header>
  <div class="wrap">
    <div class="tabla"> </div>
    <div class="tabla"> </div>
    <aside> </aside>
    <div class="banner">
      <div class="foto"></div>
      <div class="login datos-sesion">
      <div class="bg-top"></div>
      <p class="bienvenido">BIENVENIDO A VILLA NIZA</p> 
      
        <table border="1">
  <tr>
    <th class="th">NOMBRE:</th>
    <td><?php echo $row_consulta1['nombre']; ?> <?php echo $row_consulta1['apellido']; ?></td>
  </tr>
  <tr>
    <th class="th">RUT:</th>
    <td><?php echo $row_consulta1['rut']; ?></td>
  </tr>
  <tr>
    <th class="th">N° de SITIO:</th>
    <td><?php echo $row_consulta1['numero_sitio']; ?></td>
  </tr>
  <?php /*?><tr>
    <th class="th">DIRECCIÓN:</th>
    <td><?php echo $row_consulta1['direccion']; ?></td>
  </tr>
  <tr>
    <th class="th">TELÉFONO:</th>
    <td><?php echo $row_consulta1['telefono']; ?></td>
  </tr>*
  <tr>
    <th class="th">E-MAIL:</th>
    <td ><?php echo $row_consulta1['email']; ?></td>
  </tr><?php */?>
</table>

        <div class="links-login">
       <!-- <a class="links" href="cambiar-contrasena.php?id=<?php //echo $id_usuario ?>" title="Modificar Contraseña">MODIFICAR CONTRASEÑA</a>-->
        <form action="" method="get" name="form-sesion">
          <a class="links" href="<?php echo $logoutAction ?>" title="Cerrar Sesión">CERRAR SESIÓN</a>
        </form>
           </div>
      </div>
    </div>
    <div class="contenido-azul info-gastos">
      <h1>INFORMACIÓN DE GASTOS Y MOROSIDAD</h1>
      <p>ESTADO DE CUENTA DE ENERO DE 2016</p>
      
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
           
             
            $query = "SELECT ultimo_pago , saldo , descripcion , fecha FROM cuentas as cu left join usuarios as us on id_usuario = us.id left join mes as mes on id_mes = mes.id where id_mes = ".$Mes." and ano = ".$Ano." and id_usuario = ".$id_usuario."";
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
                            $query = "SELECT ultimo_pago , saldo , descripcion , fecha FROM cuentas as cu left join usuarios as us on id_usuario = us.id left join mes as mes on id_mes = mes.id where id_mes = ".$Mes." and ano = ".$Ano." and id_usuario = ".$id_usuario."";
                			$rs = $db->query($query);
                            $contador = count($rs);
                                }   
                    }
             
            
			     $NMes     		    = isset($rs[0]['descripcion'])      		&& $rs[0]['descripcion']!=''         			? $rs[0]['descripcion'] 		: '';  
				  
				 
				 
				    		        
				 $ultimo_pago    	= isset($rs[0]['ultimo_pago'])      && $rs[0]['ultimo_pago']!=''         	? $rs[0]['ultimo_pago'] : '';
				 
				 
				 
				 
				 $saldo     		= isset($rs[0]['saldo'])      		&& $rs[0]['saldo']!=''         			? $rs[0]['saldo'] 		: '';
				 
				 
				 
				  $fecha    		= isset($rs[0]['fecha'])      		&& $rs[0]['fecha']!=''         			? $rs[0]['fecha'] 		: '';
				 
			     
	      ?>
          
          
    
          
          
          
	<table>
    
			
			<tr class="thead">
				<td class="td">Ultimo Pago Registrado</td>
                <td class="td">Fecha</td>
                <td class="td">Saldo</td>						
			</tr>
			<tr class="td-bottom">
				<td class="td">$ <?php echo $ultimo_pago ?></td>
                <td class="td"><?php echo $fecha ?></td>	
                <td class="td">$ <?php echo $saldo ?></td>	
                			
			</tr>
	</table>      

    </div>
    <div class="dudas-consultas">
      <h1>DUDAS O CONSULTAS</h1>
      <div class="formulario-socios">
        <form action="enviar-acontador.php" method="post" >
          <div class="form-izquierdo">
            <label>NOMBRE</label>
            <input name="nombre" type="text" value="<?php echo $row_consulta1['nombre']; ?> <?php echo $row_consulta1['apellido']; ?>" required>
            <label>E-MAIL</label>
            <input name="email" type="text" value="<?php echo $row_consulta1['email']; ?>" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" required>
            <label>ASUNTO</label>
            <input name="asunto" type="text" value="" required>
          </div>
          <div class="form-derecho">
            <label>COMENTARIO</label>
            <textarea name="comentario" cols="" rows="" required></textarea>
            <input name="enviar" type="submit" value="ENVIAR">
          </div>
          <div class="datos">
            <p>Claudio Ramírez</p>
              <p><span>Contador</span></p>
            <p class="email">claudioramírez@crnchile.cl</p>
            <p>Teléfono: 25228054 </p>
          </div>
        </form>
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
