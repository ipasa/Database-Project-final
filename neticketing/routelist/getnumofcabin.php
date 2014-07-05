<?php require_once('../Connections/neticketing.php'); ?>
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
$EditedDate = strtotime($_GET['date']);
$journey_date = date("Y-m-d",$EditedDate );
$source=$_GET['source'];
$destination=$_GET['destination'];
$launch_name=$_GET['launch_name'];
$seat_catagory=$_GET['seat_catagory'];

$query_result_details = "SELECT sum(amount) 
FROM purchase_info
WHERE journey_date = '".$journey_date."'
AND launch_name = '".$launch_name."'
AND source = '".$source."'
AND destination = '".$destination."'
AND catagory = '".$seat_catagory."'";

//Query For Getting information About the number of existing ticket
$result_details = mysql_query($query_result_details, $neticketing) or die(mysql_error());
$row_result_details = mysql_fetch_assoc($result_details);
$totalRows_result_details = mysql_num_rows($result_details);
$sellamount = $row_result_details['sum(amount)'];
/*$cost = $row_result_details['price']*$cabin;*/

//Calculation :
$query_forTotalTicket =  "SELECT capacity_amount
FROM seat_catagory
WHERE launch_name = '".$launch_name."'
AND catagory_name = '".$seat_catagory."'"; 
$result_forTotalTicket = mysql_query($query_forTotalTicket, $neticketing) or die(mysql_error());
$result_forTotalTicket_details = mysql_fetch_assoc($result_forTotalTicket);
$seatAmount = $result_forTotalTicket_details['capacity_amount'];
$remain_ticket = $seatAmount-$sellamount;


mysql_free_result($result_details);
?>
<div class="allamount">
  <?php
  if ($seatAmount>$sellamount) {
   echo "<P>Total Number of Ticket are Available <b>".$remain_ticket; 
   ?>
 </b></P>
 <select id="no_amount" class="input_train_info" name="amount_list">
  <option value="0">===NONE===</option>
  <?php
  if ($remain_ticket > 3) {
    $showInloop = 3;
  }
  else
    $showInloop = $remain_ticket;
  for ($i=1; $i <= $showInloop; $i++) {
    ?>
    <option value="<?php echo $i ?>"><?php echo $i ?></option>";
    <?php } ?>
  </select>

  <?php }
  elseif ($seatAmount==$sellamount) { 
    echo "<div style='color:#dc0a09;'>"."Sorry, No Seat's are available of this launch.".'</div>'; 
  }
  else
    echo "string";
  ?>
</div>