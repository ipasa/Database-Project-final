<?php require_once('../Connections/neticketing.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}

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
$query_route_list_details = "SELECT launch_name,dept_time
							FROM launch_info,schedule_info 
              WHERE launch_info.launch_id=schedule_info.launch_id
              AND dept_date = '$_POST[journey_date]'
							AND source='$_POST[station_from]'
							AND destination = '$_POST[station_to]'
              ORDER BY dept_time";
$route_list_details = mysql_query($query_route_list_details, $neticketing) or die(mysql_error());
$row_route_list_details = mysql_fetch_assoc($route_list_details);
$totalRows_route_list_details = mysql_num_rows($route_list_details);
?>
<!DOCTYPE html>
<html>
<head>
    <link href="../css/main_style.css" media="screen" rel="stylesheet" type="text/css" >
    <link id="page_favicon" href="../images/favicon.ico" rel="icon" type="image/icon" />
    <title>Bangladesh Railway</title>
</head>

<body>
<!-------------------HEADER START-------------------->
<div id="header">
    <div id="header1"><img src="../images/ministryOfNevel.gif" height="100" /></div>
    <div id="header_tab2">
      <div id="header2"><img src="../images/bangladesh.gif" height="100" /></div>
    </div>
</div>
<!-------------------HEADER END----------------------> 

<!-------------------BODY START---------------------->
<style type="text/css">
.account_body{font-size:14px;}
.table td{padding-left: 7px;}
th {text-align:left;padding-left: 5px; }
.table .home{background:#fff; }
</style>
<div id="signup_body" class="account_body" style="padding-top:  0px;">
  <div id="tabs"> 
<!--main menu-->
<?php 
$placeholder = "routelist";
if (isset($_SESSION['MM_Username'])) {
?>
  <ul class="mainmenu">
    <li><a href="../index.php">Fare Query</a></li>
    <li class="<?php if ($placeholder == "routelist") { echo "active";} ?>"><a href="../routelist.php">Launch Route</a></li>
    <li><a href="../purchaseticket.php">Purchase Ticket</a></li>
    <li><a href="../dashboard.php">Dashboard</a></li>
    <li><a href="../logout.php">Logout</a></li>
  </ul>
<?php }else{ ?>

  <ul class="mainmenu">
    <li><a href="../index.php">Fare Query</a></li>
    <li><a href="../routelist.php">Launch Route</a></li>
    <li><a href="../purchaseticket.php">Purchase Ticket</a></li>
    <li><a href="../login.php">Login</a></li>
  </ul>
<?php } ?>
<!--main menu--> 

</div>
<!-- DIV start for Dashboard -->
<div id="trainroute" style="margin-top: 20px; ">
    <div id="legend_s">&nbsp;&nbsp;Launch Route Showing For :: <?php echo $_POST['station_from']?> to <?php echo $_POST['station_to']?> :: <?php echo $_POST['journey_date']?> &nbsp;&nbsp;</div>

    <div id="train_route_div_b" style="box-shadow:0px 0px 16px #000000; width: 80%">

        <table style="font-size: 12px; " width="100%" border="0" cellspacing="4" cellpadding="4">
            <tbody>
              <tr style="font-weight: bold;text-align: center; background: #6c1d4c; color: #ffffff">
                <td width="15%">Serial </td>
                <td width="40%">Launch Name</td>
                <td width="15%">Departure Time </td>
              </tr>

<?php if ($totalRows_route_list_details>0){ ?>
<?php 
$i = 1; 
do { ?>
<tr style="text-align: center; background: #EAFFD5">
  <td>
    <?php
      echo $i;
      $i++;
    ?>
  </td>
  <td style="text-align: center;"><?php echo $row_route_list_details['launch_name']; ?></td>
  <td><?php echo $row_route_list_details['dept_time']; ?></td>
</tr>
<?php } while ($row_route_list_details = mysql_fetch_assoc($route_list_details)); ?>

<?php } else{
  echo "Sorry no Launch is available on That day";
} ?>
        </tbody>
    </table>
</div>
</div>
<br>
<!-- DIV end for Dashboard -->
</div>
<!-------------------BODY START----------------------> 

<!-------------------FOOTER START---------------------->
<div style="height:10px;"></div>
<div id="footer_woh">
  <div id="float_left">
    <footer id="copyright">
      <a class="personal_info">&COPY;</a> 
      <a href="http://www.csejnu02.wodrpress.com" target="_blank">Pasha & Abir</a>
      <a> 2012-2013</a>
  </footer>
</div>
</div>
<!-------------------FOOTER END---------------------->
</body>
</html>
<?php
mysql_free_result($route_list_details);
?>
