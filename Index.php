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

$maxRows_FrontEnd = 10;
$pageNum_FrontEnd = 0;
if (isset($_GET['pageNum_FrontEnd'])) {
  $pageNum_FrontEnd = $_GET['pageNum_FrontEnd'];
}
$startRow_FrontEnd = $pageNum_FrontEnd * $maxRows_FrontEnd;

mysql_select_db($database_Conexion, $Conexion);
$query_FrontEnd = "SELECT * FROM producto";
$query_limit_FrontEnd = sprintf("%s LIMIT %d, %d", $query_FrontEnd, $startRow_FrontEnd, $maxRows_FrontEnd);
$FrontEnd = mysql_query($query_limit_FrontEnd, $Conexion) or die(mysql_error());
$row_FrontEnd = mysql_fetch_assoc($FrontEnd);

if (isset($_GET['totalRows_FrontEnd'])) {
  $totalRows_FrontEnd = $_GET['totalRows_FrontEnd'];
} else {
  $all_FrontEnd = mysql_query($query_FrontEnd);
  $totalRows_FrontEnd = mysql_num_rows($all_FrontEnd);
}
$totalPages_FrontEnd = ceil($totalRows_FrontEnd/$maxRows_FrontEnd)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<table border="1">
  <?php do { ?>
    <tr>
      <td><p>ID <?php echo $row_FrontEnd['id_producto']; ?></p>
        <p>Nombre: <?php echo $row_FrontEnd['producto']; ?></p>
        <p>Descripcion: <?php echo $row_FrontEnd['descripcion']; ?></p>
        <p>Existencias: <?php echo $row_FrontEnd['existencia']; ?></p>
        <p>Precio de compra:  <?php echo $row_FrontEnd['precio_compra']; ?></p>
        <p>Precio de venta: <?php echo $row_FrontEnd['precio_venta']; ?></p></td>
    </tr>
    <?php } while ($row_FrontEnd = mysql_fetch_assoc($FrontEnd)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($FrontEnd);
?>
