<?php require_once('Connections/neticketing.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
$query_routelist = "SELECT distinct source FROM launch_info";
$routelist = mysql_query($query_routelist, $neticketing) or die(mysql_error());
$row_routelist = mysql_fetch_assoc($routelist);
$totalRows_routelist = mysql_num_rows($routelist);
?>

<!-------------------Banner START---------------------->
<?php 
$placeholder = "purchaseticket";
include('include/banner.php');
?>
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
xmlhttp.open("GET","routelist/getStationTo_1.php?q="+str,true);
xmlhttp.send();
}

function get_time()
{
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
    document.getElementById("train_list1").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","routelist/getTime.php?date="+document.getElementById("journey_date").value+
                                    "&source="+document.getElementById("station_from").value+
                                    "&destination="+document.getElementById("sta_destination").value,true);
xmlhttp.send();
}


//Receiving Information for Launch Name
function get_launch()
{
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
    document.getElementById("train_list").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","routelist/getStation_2.php?date="+document.getElementById("journey_date").value+
                                    "&source="+document.getElementById("station_from").value+
                                    "&destination="+document.getElementById("sta_destination").value+
                                    "&time="+document.getElementById("sta_time").value,true);
xmlhttp.send();
}

//Receiving Information for Seat Catagory
function get_class()
{
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
    document.getElementById("class_list").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","routelist/getClass.php?launch_name="+document.getElementById("la_name").value,true);
xmlhttp.send();
}

//Get Number Of Cabin
function get_numberOfcabin()
{
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
    document.getElementById("amount_list").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","routelist/getnumofcabin.php?date="+document.getElementById("journey_date").value+
  "&source="+document.getElementById("station_from").value+
  "&destination="+document.getElementById("sta_destination").value+
  "&launch_name="+document.getElementById("la_name").value+
  "&seat_catagory="+document.getElementById("class_name").value,true);
xmlhttp.send();
}

function get_result()
{
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
    document.getElementById("fare_info").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","routelist/resultForPerchuse.php?date="+document.getElementById("journey_date").value+
                                "&source="+document.getElementById("station_from").value+
                                "&destination="+document.getElementById("sta_destination").value+
                                "&launch_name="+document.getElementById("la_name").value+
                                "&seat_catagory="+document.getElementById("class_name").value+
                                "&cabin="+document.getElementById("no_amount").value+
                                "&time="+document.getElementById("sta_time").value,true);
xmlhttp.send();
}
</script>
</head>

<body>
<!-------------------HEADER START---------------------->
<?php include('include/header.php');?>
<!-------------------HEADER END----------------------> 

<!--BODY START-->
<div id="signup_body" class="account_body" style="padding-top: 0px;">
  <div id="tabs"> 
<!--main menu-->
<?php include('include/navigation.php');?>
<!--main menu-->

        <div id="fare_query">
          <div style="height: 360px;">
            <div id="fare_querydiv">
              <form id='form_fare_query' accept-charset='UTF-8'>
                <fieldset class="signup_fieldset">
                  <legend id="legend">&nbsp;Purchase - Ticket &nbsp;</legend>
                  <table width="100%" id="">
                    <tr>
                      <td colspan="2" id="label"><label for='journey_date'>Journey Date :</label></td>
                        <td>
                          <div id="select">
                          <select class="input_train_info" name="journey_date" id="journey_date">
                              <option value="0">===SELECT JOURNEY DATE===</option>
                              <?php for($i=1;$i<=7;$i++){ 
                                $bookingTime = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
                                ?>
                              <option value="<?php echo date("d-m-Y", $bookingTime);?>">
                                <?php echo date("d-m-Y", $bookingTime);?>
                              </option>
                              <?php }?>
                        </select>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" id="label"><label for='station_from'>Station From :</label></td>
                        <td>
                          <div id="select">
                            <select name="station_from" id="station_from" class="input_train_info" 
                                    tabindex="2" required="required" onChange="get_stn_to(this.value)">
                                <option value="0" label="===SELECT STATION==="> ===SELECT STATION===</option>
                      <?php
                      do { ?>
                        <option value="<?php echo $row_routelist['source']?>"<?php if (!(strcmp($row_routelist['source'], $row_routelist['source'])))?>>
                          <?php echo $row_routelist['source']?>
                        </option>

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
                      <td colspan="2" id="label"><label for='station_to'>Station To:</label></td>
                        <td>
                          <div id="select">
                            <font id="stn_to_list"> 
                            <select id="input_train_info" class="input_train_info" name="stn_to_list">
                              <option value="0">===NONE===</option>
                            </select>
                            </font>
                          </div>
                        </td>
                      </tr>

                  <!-- Showing Time of Launch -->
                  <tr>
                    <td colspan="2" id="label"><label for='class'>Deperture Time:</label></td>
                    <td>
                      <div id="select"> 
                        <font id="train_list1">
                          <select id="de_time" class="input_train_info" name="dep_time">
                            <option value="0">===NONE===</option>
                            <option value="0">===1===</option>
                            <option value="0">===2===</option>
                          </select>
                        </font> 
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2" id="label"><label for='train_name'>Launch Name:</label></td>
                      <td>
                        <div id="select"> 
                          <font id="train_list">
                            <select class="input_train_info" name="train_list">
                                <option value="0">===NONE===</option>
                            </select>
                          </font> 
                        </div>
                    </td>
                  </tr>

                  <tr>
                    <td colspan="2" id="label"><label for='class'>Travel Class:</label></td>
                    <td>
                      <div id="select"> 
                        <font id="class_list">
                          <select id="no_cabin" class="input_train_info" name="class_list">
                            <option value="0">===NONE===</option>
                          </select>
                        </font> 
                      </div>
                    </td>
                  </tr>
                  
                  <!-- Showing Number of cabin -->
                  <tr>
                    <td colspan="2" id="label"><label for='class'>Amount:</label></td>
                    <td>
                      <div id="select"> 
                        <font id="amount_list">
                          <select id="no_amount" class="input_train_info" name="amount_list">
                            <option value="0">===NONE===</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                          </select>
                        </font> 
                      </div>
                    </td>
                  </tr>
            </table>
            <div align="center"> 
              <input type="button" name="show_fare" value="Show Fare"
              		 id="button1" tabindex="4" onClick="get_result()" />
            </div>
          </fieldset>
        </form>
      </div>

      <form id="fare_query_result" action="ticketConfermation.php" method="post">
        <fieldset class="signup_fieldset">
          <legend id="legend">Purchase - Ticket RESULT</legend>
          <div id="fare_info">
            Give All Information About Your Journey
          </div>
        </fieldset>
      </form>
    </div>
    </div>
    <!-- DIV end for Fare Query --> 
    
  </div>
</div>
<!-------------------BODY End----------------------> 

<!-------------------FOOTER START---------------------->
<?php include('include/footer.php');?>
<!-------------------FOOTER END---------------------->
</body>
</html>
