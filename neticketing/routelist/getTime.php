<?php require_once('../Connections/neticketing.php'); ?>
<?php
$q=$_GET['destination'];
$r=$_GET['date'];
$s = $_GET['source'];

mysql_select_db($database_neticketing, $neticketing);

$sql="SELECT distinct dept_time 
FROM launch_info,schedule_info 
WHERE launch_info.launch_id=schedule_info.launch_id
AND dept_date = '".$r."'
AND source = '".$s."'
AND destination = '".$q."'";
$result = mysql_query($sql);
?>
<select id="sta_time" name="station_time" onchange="get_launch()">
	<option value="0">===SELECT TIME===</option>
<?php
while ($row = mysql_fetch_array($result)) {
?>
	<option value="<?php echo $row['dept_time']; ?>"><?php echo $row['dept_time']; ?></option>
<?php } ?>
</select>