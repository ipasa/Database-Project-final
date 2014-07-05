<?php require_once('../Connections/neticketing.php'); ?>
<?php
$q=$_GET['launch_name'];

mysql_select_db($database_neticketing, $neticketing);

$sql="SELECT catagory_name 
		FROM seat_catagory 
		WHERE launch_name = '".$q."'";

$result = mysql_query($sql);
?>
<select id="class_name" name="station_to" onchange="get_numberOfcabin()">
	<option value="0">===SELECT CATAGORY===</option>
<?php
while ($row = mysql_fetch_array($result)) {
?>
	<option value="<?php echo $row['catagory_name']; ?>"><?php echo $row['catagory_name']; ?></option>
<?php } ?>
</select>