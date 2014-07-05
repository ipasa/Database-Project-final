<?php require_once('../Connections/neticketing.php'); ?>
<?php
$q=$_GET['destination'];
$r=$_GET['date'];
$s = $_GET['source'];
$t = $_GET['time'];

mysql_select_db($database_neticketing, $neticketing);

$sql="SELECT distinct launch_name 
		FROM launch_info,schedule_info 
		WHERE launch_info.launch_id=schedule_info.launch_id
		AND dept_date = '".$r."'
		AND source = '".$s."'
		AND destination = '".$q."'
		AND dept_time = '".$t."'";

$result = mysql_query($sql);
?>
<select id="la_name" name="station_to" onclick="get_class()">
	<option value="0">===SELECT LAUNCH===</option>
<?php
while ($row = mysql_fetch_array($result)) {
?>
	<option value="<?php echo $row['launch_name']; ?>"><?php echo $row['launch_name']; ?></option>
<?php } ?>
</select>