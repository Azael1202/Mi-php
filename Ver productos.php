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

$maxRows_backend = 10;
$pageNum_backend = 0;
if (isset($_GET['pageNum_backend'])) {
  $pageNum_backend = $_GET['pageNum_backend'];
}
$startRow_backend = $pageNum_backend * $maxRows_backend;

mysql_select_db($database_Conexion, $Conexion);
$query_backend = "SELECT * FROM producto";
$query_limit_backend = sprintf("%s LIMIT %d, %d", $query_backend, $startRow_backend, $maxRows_backend);
$backend = mysql_query($query_limit_backend, $Conexion) or die(mysql_error());
$row_backend = mysql_fetch_assoc($backend);

if (isset($_GET['totalRows_backend'])) {
  $totalRows_backend = $_GET['totalRows_backend'];
} else {
  $all_backend = mysql_query($query_backend);
  $totalRows_backend = mysql_num_rows($all_backend);
}
$totalPages_backend = ceil($totalRows_backend/$maxRows_backend)-1;
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
          <li class='launcher'> <i class='icon-dashboard'></i> <a href="Ver productos.php"">Lista Productos</a> </li>
          <li class=' launcher'> <i class='icon-file-text-alt'></i> <a href="Ver registros.php">Agregar</a> </li>
          <li class='active launcher'> <i class='icon-table'></i> <a href="Borrar.php">Editar Borrar</a> </li>
          
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
        <div class="page-heading">
        	<label class="control-label">Lista de Productos</label>
        	
        </div>
<table class="table">
<thead>
  <tr>
    <td> </td>
    <td>Producto</td>
    <td>Descripcion</td>
    <td>Existencia</td>
    <td>Precio de compra</td>
    <td>Precio de venta</td>
  </tr>
  </thead>
  <?php do { ?>
    <tr>
      <td><?php echo $row_backend['id_producto']; ?></td>
      <td><?php echo $row_backend['producto']; ?></td>
      <td><?php echo $row_backend['descripcion']; ?></td>
      <td><?php echo $row_backend['existencia']; ?></td>
      <td><?php echo $row_backend['precio_compra']; ?></td>
      <td><?php echo $row_backend['precio_venta']; ?></td>
    </tr>
    <?php } while ($row_backend = mysql_fetch_assoc($backend)); ?>
</table>
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
mysql_free_result($backend);
?>
