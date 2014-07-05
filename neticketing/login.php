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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['inputEmail'])) {
  $loginUsername=$_POST['inputEmail'];
  $password=$_POST['inputPassword'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "dashboard.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_neticketing, $neticketing);
  
  $LoginRS__query=sprintf("SELECT user_email, user_password, user_id FROM user_info WHERE user_email=%s AND user_password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $neticketing) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $forUserId = mysql_fetch_assoc($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	   
	  $_SESSION['user_email'] = $_POST['inputEmail']; 
    $_SESSION['user_id'] = $forUserId['user_id'];

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['inputEmail'])) {
  $loginUsername=$_POST['inputEmail'];
  $password=$_POST['inputPassword'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "dashboard.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_neticketing, $neticketing);
  
  $LoginRS__query=sprintf("SELECT user_email, user_password FROM user_info WHERE user_email=%s AND user_password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $neticketing) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login page</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="css/main_style.css" media="screen" rel="stylesheet"
	type="text/css">
<link href="images/favicon.ico" rel="icon" type="image/icon" />
</head>
<body>
<!-------------------HEADER START---------------------->
<?php 
$placeholder = "login";
include('include/header.php');?>
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
					<form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" name="myLoginForm" class="form-horizontal">
						<fieldset>
							<legend>Login Form</legend>
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
									<input type="password" name="inputPassword" id="inputPassword"
										placeholder="Password" required>
								</div>
							</div>
							<div class="control-group">
								<div class="controls">					
								  <input type="submit" class="btn"></button><p></P>
									<p>Don't Have an Account?<a href="registration.php"> Sign Up Here</a></p>  
							  </div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
			<!-- DIV end for Dashboard -->
		</div>
	</div>

<!-------------------FOOTER START---------------------->
<?php include('include/footer.php');?>
<!-------------------FOOTER END---------------------->
</body>
</html>