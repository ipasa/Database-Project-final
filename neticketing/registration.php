<?php require_once('Connections/neticketing.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "signupForm")) {
  $insertSQL = sprintf("INSERT INTO user_info (user_name, user_email, user_phone, user_address, user_password) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['inputName'], "text"),
                       GetSQLValueString($_POST['inputEmail'], "text"),
                       GetSQLValueString($_POST['inputPhone'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['inputPassword'], "text"));

  mysql_select_db($database_neticketing, $neticketing);
  $Result1 = mysql_query($insertSQL, $neticketing) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_neticketing, $neticketing);
$query_insert_record = "SELECT * FROM user_info";
$insert_record = mysql_query($query_insert_record, $neticketing) or die(mysql_error());
$row_insert_record = mysql_fetch_assoc($insert_record);
$totalRows_insert_record = mysql_num_rows($insert_record);
?>
<!DOCTYPE html>
<html>
<head>
<title>Sign Up page</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="css/main_style.css" media="screen" rel="stylesheet"
	type="text/css">
<link href="images/favicon.ico" rel="icon" type="image/icon" />
</head>
<body>
	<!-------------------HEADER START-------------------->
	<?php include('include/header.php');?>
	<!-------------------HEADER END---------------------->

	<!-------------------BODY START---------------------->
	<div id="signup_body" class="account_body" style="padding-top: 0px;">
		<div id="tabs">
			<!--main menu-->
			<?php 
			$placeholder = "login";
			include('include/navigation.php');?>
			<!--main menu-->

			<!-- DIV start for Dashboard -->
			<div id="trainroute" style="margin-top: 30px;">
				<div id="train_route_div">
				  <form method="POST" action="<?php echo $editFormAction; ?>" name="signupForm" class="form-horizontal">
						<fieldset>
							<legend>Registration Form</legend>

							<div class="control-group">
								<label class="control-label" for="inputName">Name</label>
								<div class="controls">
									<input type="text" name="inputName" id="inputName" placeholder="Your Name"
										required>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="inputEmail">Email</label>
								<div class="controls">
									<input type="email" name="inputEmail" id="inputEmail" placeholder="Email"
										required>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="inputPassword">Password</label>
								<div class="controls">
									<input type="password" id="inputPassword" name="inputPassword"
										placeholder="Password" required>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label" for="inputAddress">Address</label>
								<div class="controls">
								  <textarea name="address" rows="3"></textarea>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="inputPhone">Phone Number</label>
								<div class="controls">
									<input type="text" id="inputPhone" name="inputPhone"
										placeholder="CellPhone Number" required>
								</div>
							</div>

							<div class="control-group">
								<div class="controls">
									<input type="submit" class="btn"></button>
								</div>
							</div>
				<!-- </div> -->
				</fieldset>
						<input type="hidden" name="MM_insert" value="signupForm">
			      </form>
			</div>
		</div>
		<!-- DIV end for Dashboard -->
	</div>
</div>

	<!-------------------FOOTER START---------------------->
	<div style="height: 10px;"></div>
	<div id="footer_woh">
		<div id="float_left">
			<footer id="copyright">
				<a class="personal_info">&COPY;</a> <a
					href="http://www.csejnu02.wodrpress.com" target="_blank">Pasha
					&amp; Abir</a> <a> 2012-2013</a>
			</footer>
		</div>
	</div>
	<!-------------------FOOTER END---------------------->
</body>
</html>
<?php
mysql_free_result($insert_record);
?>
