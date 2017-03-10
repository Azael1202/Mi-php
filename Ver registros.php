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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO producto (producto, descripcion, existencia, precio_compra, precio_venta) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['producto'], "text"),
                       GetSQLValueString($_POST['descripcion'], "text"),
                       GetSQLValueString($_POST['existencia'], "int"),
                       GetSQLValueString($_POST['precio_compra'], "double"),
                       GetSQLValueString($_POST['precio_venta'], "double"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($insertSQL, $Conexion) or die(mysql_error());
}

if ((isset($_GET['id_producto'])) && ($_GET['id_producto'] != "")) {
  $deleteSQL = sprintf("DELETE FROM producto WHERE id_producto=%s",
                       GetSQLValueString($_GET['id_producto'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($deleteSQL, $Conexion) or die(mysql_error());
}

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_Conexion, $Conexion);
$query_Recordset1 = "SELECT * FROM producto ORDER BY id_producto ASC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $Conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html>
<html class='no-js' lang='en'><!-- InstanceBegin template="/Templates/BackendDashboard.dwt" codeOutsideHTMLIsLocked="false" -->
  <head>
    <meta charset='utf-8'>
    <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
    <!-- InstanceBeginEditable name="doctitle" -->
    <title>Dashboard</title>
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
        <i class='icon-align-justify icon-large' id='toggle'></i><!-- InstanceBeginEditable name="Menu" -->
        <ul id='dock'>
          <li class=' launcher'> <i class='icon-dashboard'></i> <a href="Ver productos.php">Lista Productos</a> </li>
          <li class='active launcher'> <i class='icon-file-text-alt'></i> <a href="Ver registros.php">Agregar</a> </li>
          <li class='launcher'> <i class='icon-table'></i> <a href="Borrar.php">Editar Borrar</a> </li>
  

        </ul>
        <!-- InstanceEndEditable -->
        <div data-toggle='tooltip' id='beaker' title='Made by lab2023'></div>
  </section>
      <!-- Tools -->
      <section id='tools'><!-- InstanceBeginEditable name="BreadCrub" -->
              <ul class='breadcrumb' id='breadcrumb'>
         
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
        <div class="panel-heading">
        	<i class="glyphicon-edit icon-large"></i>
            Agregar Productos
         </div>
<div class="panel-body">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">

<fieldset>
    <div class="form-group">
    	<label class="control-label">Producto</label>
		<input class="form-control" type="text" name="producto" value="" size="32">
        </div>
</fieldset>

<fieldset>
	<div class="form-group">
        <label class="control-label">Descripcion</label>
      <textarea class="form-control" name="descripcion" id="descripcion" cols="100" rows="5">
      </textarea>
      </div>
</fieldset>
<fieldset>
	<div class="form-group">
      <label class="control-label">Existencias</label>
      <input class="form-control" type="text" name="existencia" value="" size="32">
      </div>
</fieldset>
<fieldset>
	<div class="form-group">
    	<label class="control-label">Precio de Compra</label>
   		<input class="form-control" type="text" name="precio_compra" value="" size="32">
        </div>
</fieldset>
<fieldset>
	<div class="form-group">
    	<label class="control-label">Pecio de Venta</label>   
    	<input class="form-control" type="text" name="precio_venta" value="" size="32">
        </div>
</fieldset>
<fieldset>
	<div class="form-group">
   		<input class="btn btn-success" type="submit" value="Insertar registro">
        </div>
</fieldset>
    
  <input type="hidden" name="MM_insert" value="form1" />
</form>	
</div>




  

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
