<?php require_once('../Connections/neticketing.php'); ?>
<style>
b{
  color: red;
}
</style>
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

mysql_select_db($database_neticketing, $neticketing);
$date=$_GET['date'];
$source=$_GET['source'];
$destination=$_GET['destination'];
$launch_name=$_GET['launch_name'];
$seat_catagory=$_GET['seat_catagory'];
$cabin=$_GET['cabin'];

$query_result_details = "SELECT price 
            FROM seat_catagory
            WHERE launch_name = '".$launch_name."'
            AND catagory_name = '".$seat_catagory."'";
$result_details = mysql_query($query_result_details, $neticketing) or die(mysql_error());
$row_result_details = mysql_fetch_assoc($result_details);
$totalRows_result_details = mysql_num_rows($result_details);
$cost = $row_result_details['price']*$cabin;
mysql_free_result($result_details);
?>

<P>Net Fare Including VAT & Service Charge BDT <b><?php echo $cost; ?></b></P>
