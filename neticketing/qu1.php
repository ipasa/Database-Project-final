<?php require_once('Connections/neticketing.php'); 
mysql_select_db($database_neticketing, $neticketing);

$sql = "SELECT launch_id
from launch_info";
$launch_na = mysql_query($sql, $neticketing) or die(mysql_error());
$row = mysql_fetch_array($launch_na);

while ($row = mysql_fetch_array($launch_na)) {
	$up =  "UPDATE launch_info
	SET amount=800
	WHERE source='BARISAL'
	AND destination = 'DHAKA'";
	mysql_query($up, $neticketing) or die(mysql_error());
}
//$route = mysql_query($query, $neticketing) or die(mysql_error());
?>
