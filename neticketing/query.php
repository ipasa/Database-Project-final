<?php require_once('Connections/neticketing.php'); 
mysql_select_db($database_neticketing, $neticketing);
for ($i=1; $i<= 31 ; $i=$i+2) { 
	$query = "INSERT INTO schedule_info
			values ('MVCD-6',$i, 10)";
	$route = mysql_query($query, $neticketing) or die(mysql_error());
	echo "ok";
}
?>
