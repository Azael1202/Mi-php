<?php require_once('Connections/Conexion.php'); ?>
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
  $updateSQL = sprintf("UPDATE producto SET producto=%s, descripcion=%s, existencia=%s, precio_compra=%s, precio_venta=%s WHERE id_producto=%s",
                       GetSQLValueString($_POST['producto'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['existencia'], "int"),
                       GetSQLValueString($_POST['precio_compra'], "double"),
                       GetSQLValueString($_POST['precio_venta'], "double"),
                       GetSQLValueString($_POST['id_producto'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($updateSQL, $Conexion) or die(mysql_error());

  $updateGoTo = "Ver registros.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_GET['id_producto'])) {
  $colname_Recordset1 = $_GET['id_producto'];
}
mysql_select_db($database_Conexion, $Conexion);
$query_Recordset1 = sprintf("SELECT * FROM producto WHERE id_producto = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $Conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
<html class='no-js' lang='en'><!-- InstanceBegin template="/Templates/BackendDashboard.dwt" codeOutsideHTMLIsLocked="false" -->
  <head>
    <meta charset='utf-8'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>MY PHP</title>
    <!-- InstanceEndEditable -->
    <meta content='lab2023' name='author'>
    <meta content='' name='description'>
    <meta content='' name='keywords'>
    <link href="assets/stylesheets/application-a07755f5.css" rel="stylesheet" type="text/css" /><link href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/images/favicon.ico" rel="icon" type="image/ico" />
    <!-- InstanceBeginEditable name="head" -->
    <!-- InstanceEndEditable -->
  </head>
  <body class='main page'>
    <!-- Navbar -->
    <div class='navbar navbar-default' id='navbar'>
      <a class='navbar-brand' href='#'>
        <i class='icon-envelope'></i>
       MY PHP
      </a>
      <ul class='nav navbar-nav pull-right'>
        <li class='dropdown'>
          <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
       
      

         
      
              <a href="/"></a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  <div id='wrapper'>
      <!-- Sidebar -->
      <section id='sidebar'>
   <!-- InstanceBeginEditable name="Menu" -->
        <ul id='dock'>
          <li class='active launcher'> <i class='icon-dashboard'></i> <a href="Ver prodoctos.php">Lista Productos</a> </li>
          <li class='launcher'> <i class='icon-file-text-alt'></i> <a href="Ver registros.php">Agregar</a> </li>
          <li class=' launcher'> <i class='icon-table'></i> <a href="Borrar.php">Editar Borrar</a> </li>
          <li class='launcher'> <i class='icon-bookmark'></i> <a href="EditarDatos.php">Actualizar</a> </li>
       
        </ul>
        <!-- InstanceEndEditable -->
        <div data-toggle='tooltip' id='beaker' title='Made by lab2023'></div>
  </section>
      <!-- Tools -->
      <section id='tools'><!-- InstanceBeginEditable name="BreadCrub" -->
        <ul class='breadcrumb' id='breadcrumb'>
          
          <li></li>
          <li class='active'></li>
        </ul>
      <!-- InstanceEndEditable -->
        <div id='toolbar'>
          <div class='btn-group'>
            <a class='btn' data-toggle='toolbar-tooltip' href='#' title='Building'>
            </a>
            
          </div>
        
        </div>
  </section>
      <!-- Content -->
      <div id='content'>
        <div class='panel panel-default'>
		
		<!-- InstanceBeginEditable name="Contenido" -->
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
 <div class="form-group">
    	<label class="control-label">Producto</label>
      <td><input class="form-control" type="text" name="producto" value="<?php echo htmlentities($row_Recordset1['producto'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </div>
	<div class="form-group">
        <label class="control-label">Descripcion</label>
      <td><input class"form-control" type="text" name="descripcion" value="<?php echo htmlentities($row_Recordset1['descripcion'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </div>
   <div class="form-group">
      <label class="control-label">Existencias</label>
      <td><input class="form-control" type="text" name="existencia" value="<?php echo htmlentities($row_Recordset1['existencia'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </div>
<div class="form-group">
    	<label class="control-label">Precio de Compra</label>
      <td><input class="form-control" type="text" name="precio_compra" value="<?php echo htmlentities($row_Recordset1['precio_compra'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </div>
    <div class="form-group">
    	<label class="control-label">Pecio de Venta</label>   
      <td><input class="form-control" type="text" name="precio_venta" value="<?php echo htmlentities($row_Recordset1['precio_venta'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </div>
<div class="form-group">
      <td><input class="btn btn-success" type="submit" value="Actualizar registro" /></td>
   
 </div>
  <input type="hidden" name="MM_update" value="form1" />

</form>
<p>&nbsp;</p>
<!-- InstanceEndEditable -->

        </div>
    </div>
  <!-- Footer -->
    <!-- Javascripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script><script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js" type="text/javascript"></script><script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js" type="text/javascript"></script><script src="assets/javascripts/application-985b892b.js" type="text/javascript"></script>
    <!-- Google Analytics -->
    <script>
      var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
      (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
      g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
      s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
  </body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Recordset1);
?>
