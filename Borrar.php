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

if ((isset($_GET['id_producto'])) && ($_GET['id_producto'] != "")) {
  $deleteSQL = sprintf("DELETE FROM producto WHERE id_producto=%s",
                       GetSQLValueString($_GET['id_producto'], "int"));

  mysql_select_db($database_Conexion, $Conexion);
  $Result1 = mysql_query($deleteSQL, $Conexion) or die(mysql_error());
}

$maxRows_Borrar = 10;
$pageNum_Borrar = 0;
if (isset($_GET['pageNum_Borrar'])) {
  $pageNum_Borrar = $_GET['pageNum_Borrar'];
}
$startRow_Borrar = $pageNum_Borrar * $maxRows_Borrar;

mysql_select_db($database_Conexion, $Conexion);
$query_Borrar = "SELECT * FROM producto";
$query_limit_Borrar = sprintf("%s LIMIT %d, %d", $query_Borrar, $startRow_Borrar, $maxRows_Borrar);
$Borrar = mysql_query($query_limit_Borrar, $Conexion) or die(mysql_error());
$row_Borrar = mysql_fetch_assoc($Borrar);

if (isset($_GET['totalRows_Borrar'])) {
  $totalRows_Borrar = $_GET['totalRows_Borrar'];
} else {
  $all_Borrar = mysql_query($query_Borrar);
  $totalRows_Borrar = mysql_num_rows($all_Borrar);
}
$totalPages_Borrar = ceil($totalRows_Borrar/$maxRows_Borrar)-1;

$queryString_Borrar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Borrar") == false && 
        stristr($param, "totalRows_Borrar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Borrar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Borrar = sprintf("&totalRows_Borrar=%d%s", $totalRows_Borrar, $queryString_Borrar);
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
          <li class=' launcher'> <i class='icon-dashboard'></i> <a href="Ver prodoctos.php">Lista Productos</a> </li>
          <li class='launcher'> <i class='icon-file-text-alt'></i> <a href="Ver registros.php">Agregar</a> </li>
          <li class=' launcher'> <i class='icon-table'></i> <a href="Borrar.php">Editar Borrar</a> </li>
          <li class='active launcher'> <i class='icon-bookmark'></i> <a href="EditarDatos.php">Actualizar</a> </li>
       
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
<p>&nbsp;</p>
<table border="1" align="center" class="table">

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>ID</td>
    <td>Producto</td>
    <td>Descripcion</td>
    <td>Existencia</td>
    <td>Precio de compra</td>
    <td>Precio de venta</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="Borrar.php?id_producto=<?php echo $row_Borrar['id_producto']; ?>">Eliminar</a></td>
      <td><a href="EditarDatos.php?id_producto=<?php echo $row_Borrar['id_producto']; ?>">Editar</a></td>
      <td><?php echo $row_Borrar['id_producto']; ?></td>
      <td><?php echo $row_Borrar['producto']; ?></td>
      <td><?php echo $row_Borrar['descripcion']; ?></td>
      <td><?php echo $row_Borrar['existencia']; ?></td>
      <td><?php echo $row_Borrar['precio_compra']; ?></td>
      <td><?php echo $row_Borrar['precio_venta']; ?></td>
    </tr>
    <?php } while ($row_Borrar = mysql_fetch_assoc($Borrar)); ?>
</table>
<p>&nbsp;
 Registros <?php echo ($startRow_Borrar + 1) ?> al <?php echo min($startRow_Borrar + $maxRows_Borrar, $totalRows_Borrar) ?> de <?php echo $totalRows_Borrar ?>
<table border="0" align="center">
  <tr>
    <td><?php if ($pageNum_Borrar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Borrar=%d%s", $currentPage, 0, $queryString_Borrar); ?>"><img src="First.gif" /></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Borrar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_Borrar=%d%s", $currentPage, max(0, $pageNum_Borrar - 1), $queryString_Borrar); ?>"><img src="Previous.gif" /></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_Borrar < $totalPages_Borrar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Borrar=%d%s", $currentPage, min($totalPages_Borrar, $pageNum_Borrar + 1), $queryString_Borrar); ?>"><img src="Next.gif" /></a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_Borrar < $totalPages_Borrar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_Borrar=%d%s", $currentPage, $totalPages_Borrar, $queryString_Borrar); ?>"><img src="Last.gif" /></a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
</p>
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
mysql_free_result($Borrar);
?>
