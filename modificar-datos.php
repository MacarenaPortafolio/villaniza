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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios SET id=%s, contrasena=%s, nombre=%s, apellido=%s, rut=%s, telefono=%s, celular=%s, numero_sitio=%s, direccion=%s, email=%s, privilegios=%s WHERE usuario=%s",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['contrasena'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['rut'], "text"),
                       GetSQLValueString($_POST['telefono'], "int"),
                       GetSQLValueString($_POST['celular'], "int"),
                       GetSQLValueString($_POST['numero_sitio'], "text"),
                       GetSQLValueString($_POST['direccion'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['privilegios'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "sitio-socio.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_editar = "-1";
if (isset($_GET['id'])) {
  $colname_editar = $_GET['id'];
}
mysql_select_db($database_localhost, $localhost);
$query_editar = sprintf("SELECT * FROM usuarios WHERE id = %s", GetSQLValueString($colname_editar, "int"));
$editar = mysql_query($query_editar, $localhost) or die(mysql_error());
$row_editar = mysql_fetch_assoc($editar);
$totalRows_editar = mysql_num_rows($editar);
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
	<div class="contenedor-grande login-administrador modificar">
    	
    	<div class="wrap">
        	<div class="banner"> 
            	<div class="foto"></div>
                <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                  <table align="center">
                    <tr valign="baseline">
                      <td nowrap align="right">Id:</td>
                      <td><?php echo htmlentities($row_editar['id'], ENT_COMPAT, 'utf-8'); ?></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Usuario:</td>
                      <td><input type="text" name="contrasena" value="<?php echo htmlentities($row_editar['usuario'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Contraseña:</td>
                      <td><input type="text" name="contrasena" value="<?php echo htmlentities($row_editar['contrasena'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Nombre:</td>
                      <td><input type="text" name="nombre" value="<?php echo htmlentities($row_editar['nombre'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Apellido:</td>
                      <td><input type="text" name="apellido" value="<?php echo htmlentities($row_editar['apellido'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Rut:</td>
                      <td><input type="text" name="rut" value="<?php echo htmlentities($row_editar['rut'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Teléfono:</td>
                      <td><input type="text" name="telefono" value="<?php echo htmlentities($row_editar['telefono'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Celular:</td>
                      <td><input type="text" name="celular" value="<?php echo htmlentities($row_editar['celular'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Número de Sitio:</td>
                      <td><input type="text" name="numero_sitio" value="<?php echo htmlentities($row_editar['numero_sitio'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Dirección:</td>
                      <td><input type="text" name="direccion" value="<?php echo htmlentities($row_editar['direccion'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Email:</td>
                      <td><input type="text" name="email" value="<?php echo htmlentities($row_editar['email'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">Privilegios:</td>
                      <td><input type="text" name="privilegios" value="<?php echo htmlentities($row_editar['privilegios'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap align="right">&nbsp;</td>
                      <td><input type="submit" value="Actualizar registro"></td>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_update" value="form1">
                  <input type="hidden" name="usuario" value="<?php echo $row_editar['usuario']; ?>">
                </form>
                <p>&nbsp;</p>
<p>&nbsp;</p>
<h1>MODIFICAR DATOS USUARIO</h1>
            </div>
            
      </div>
        
        
    </div>
</body>
</html>
<?php
mysql_free_result($editar);
?>
