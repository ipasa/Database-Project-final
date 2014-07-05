<?php
for ($i=1; $i <= 7; $i++) { 
	$tomorrow = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
	echo "date is ".date("d/m/Y", $tomorrow)."<br/>";
}
?>