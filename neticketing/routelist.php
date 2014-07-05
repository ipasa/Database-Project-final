<?php require_once('Connections/neticketing.php'); ?>
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
$query_routelist = "SELECT distinct source FROM launch_info";
$routelist = mysql_query($query_routelist, $neticketing) or die(mysql_error());
$row_routelist = mysql_fetch_assoc($routelist);
$totalRows_routelist = mysql_num_rows($routelist);
?>

<!-------------------Banner START---------------------->
<?php 
$placeholder = "routelist";
include('include/banner.php');?>
<!-------------------Banner END----------------------> 

<script>
function get_stn_to(str)
{
  if (str=="")
  {
    document.getElementById("stn_to_list").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
  else
  {// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function()
  {
    if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      document.getElementById("stn_to_list").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","routelist/getStationTo.php?q="+str,true);
  xmlhttp.send();
}
</script>
</head>
<body>
  <!-------------------HEADER START---------------------->
  <?php include('include/header.php');?>
  <!-------------------HEADER END----------------------> 

  <!-------------------BODY START---------------------->
  <div id="signup_body" class="account_body" style="padding-top: 0px;">
    <div id="tabs"> 
      <!--main menu-->
      <?php include('include/navigation.php');?>
      <!--main menu--> 

      <!-- DIV start for Dashboard -->
      <div id="trainroute" style="margin-top: 30px;">
        <div id="train_route_div">
          <fieldset class="signup_fieldset">
            <legend id="legend">&nbsp;Launch ROUTE &nbsp;</legend>
            <form class="box login" id='train_route' action='routelist/routelistResult.php'
            method='post' accept-charset='UTF-8'>
            <table width="80%" id="" style="margin: auto; font-size: 16px;">
              <tr>
                <td colspan="2" id="label" width="130px"><label
                  for='journey_date'>Journey Date :</label></td>
                  <td><div id="select">
                    <select class="input_train_info" name="journey_date"
                    id="journey_date" required>
                    <option value="0">===SELECT JOURNEY DATE===</option>
                    <?php for($i=1;$i<=7;$i++){ 
                     $bookingTime = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
                     ?>
                     <option value="<?php echo date("d-m-Y", $bookingTime);?>"> <?php echo date("d-m-Y", $bookingTime);?> </option>
                     <?php }?>
                   </select>
                 </div></td>
               </tr>
               <tr>
                <td colspan="2" id="label"><label for='station_from'>Station From :</label></td>
                <td>
                  <div id="select">
                    <select name="station_from" id="station_from" class="input_train_info" 
                    tabindex="2" onchange="get_stn_to(this.value)">
                    <option value="0" label="===SELECT STATION==="> ===SELECT STATION===</option>
                    <?php
                    do { ?>
                    <option value="<?php echo $row_routelist['source']?>"<?php if (!(strcmp($row_routelist['source'], $row_routelist['source'])))?>> <?php echo $row_routelist['source']?> </option>
                    <?php } while ($row_routelist = mysql_fetch_assoc($routelist));
                    $rows = mysql_num_rows($routelist);
                    if($rows > 0) {
                      mysql_data_seek($routelist, 0);
                      $row_routelist = mysql_fetch_assoc($routelist);
                    }
                    ?>
                  </select>
                </div></td>
              </tr>
              <tr>
                <td colspan="2" id="label"><label for='station_to'>Station To :</label></td>
                <td>
                  <div id="select"> 
                    <font id="stn_to_list">
                      <select id="input_train_info" class="input_train_info" name="stn_to_list">
                        <option value="0" />===NONE===</option>
                      </select>
                    </font> 
                  </div>
                </td>
              </tr>
            </table>
            <div align="center">
              <input type="submit" name="train_route" value="Show Route"
              id="button1" tabindex="5" />
            </div>
          </form>
        </fieldset>
      </div>
    </div>
    <!-- DIV end for Dashboard --> 
  </div>
</div>

<!-------------------FOOTER START---------------------->
<div style="height: 10px;"></div>
<div id="footer_woh">
  <div id="float_left">
    <footer id="copyright"> <a class="personal_info">&COPY;</a> <a
     href="http://www.csejnu02.wodrpress.com" target="_blank">Pasha &
     Abir</a> <a> 2012-2013</a> </footer>
     <?php
     mysql_free_result($routelist);
     ?>
   </div>
 </div>
 <!-------------------FOOTER END---------------------->
</body>
</html>
