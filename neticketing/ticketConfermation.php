<?php require_once('Connections/neticketing.php'); ?>
<?php
if (!isset($_SESSION)) {
	session_start();
}
$usresEmail = $_SESSION['user_email'];

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
$query_userForpur = "SELECT user_name, user_email, user_phone 
FROM user_info
where user_email = '".$usresEmail."'";
$userForpur = mysql_query($query_userForpur, $neticketing) or die(mysql_error());
$row_userForpur = mysql_fetch_assoc($userForpur);
$totalRows_userForpur = mysql_num_rows($userForpur);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Bangladesh Inland Water Transport Authority(BIWTA), E-ticketing service</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/main_style.css" media="screen" rel="stylesheet" type="text/css">
	<link href="css/onboard.css" media="screen" rel="stylesheet" type="text/css">
	<link href="images/favicon.ico" rel="icon" type="image/icon" />
</head>
<body>
	<!-------------------HEADER START---------------------->
	<?php
	$placeholder = "purchaseticket"; 
	include('include/header.php');
	?>
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
					<!-- Start Main Body Onboard -->
					<div class="onboard">
						<img src="images/paper_plane.png" />
						<p>Outbound : <?php echo $_POST['source']; ?> to <?php echo $_POST['destination']; ?> / 
							<?php $mydate=strtotime($_POST['date']);
							$d = date("l F j, Y",$mydate); 
							echo $d.", ".$_POST['time']; ?>
						</p>
					</div>
					<div class="launch_info">
						<div class="single_info myfloat fix">
							<h5>Launch</h5>
							<p><?php echo $_POST['launch_name']; ?></p>
						</div>
						<div class="single_info myfloat fix">
							<h5>Source</h5>
							<p><?php echo $_POST['source']; ?></p>
						</div>
						<div class="single_info myfloat fix">
							<h5>Destination</h5>
							<p><?php echo $_POST['destination']; ?></p>
						</div>
						<div class="single_info myfloat fix">
							<h5>Seat Catagory</h5>
							<p><?php echo $_POST['seat_catagory']; ?></p>
						</div>
					</div>

					<div class="passengers_info">
						<div class="contact">
							<p>Contact Information</p>
						</div>
						<div class="info lefty">
							<h5>Name</h5>
							<p><?php echo $row_userForpur['user_name']; ?></p>
						</div>
						<div class="info lefty">
							<h5>E-mail</h5>
							<p><?php echo $row_userForpur['user_email']; ?></p>
						</div>
						<div class="info lefty">
							<h5>Contact Number</h5>
							<p><?php echo $row_userForpur['user_phone']; ?></p>
						</div>
					</div>

					<div class="passengers_info">
						<div class="contact">
							<p>Payment</p>
						</div>
						<div class="mytable">
							<table class="table table-striped">
								<thead>
									<tr class="item">
										<th>Item</th>
										<th>Amount</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Price per person</td>
										<td><?php echo $_POST['eachPrice']; ?></td>
									</tr>
									<tr>
										<td>Pessengers</td>
										<td><?php echo $_POST['cabin']; ?></td>
									</tr>
									<tr>
										<td>Fare Price</td>
										<td><?php echo $_POST['eachPrice']."*".$_POST['cabin']."=".$_POST['cost']; ?></td>
									</tr>
									<tr>
										<td>Taxes and Crrier-imposed Fees</td>
										<td>100 BDT</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="totalprice">
							<p>
								Total price to be paid : 
								<span>
									<?php
									$totalCost = ($_POST['eachPrice']*$_POST['cabin'])+100;
									echo $totalCost; 
									?>
								</span>
							</p>
						</div>
						<img src="images/payment.png" width="802px">
					</div>
					
					<form action="printing/index.php" method="post">
						<fieldset>
							<legend>Fare Rules</legend>
							<label class="checkbox">
								<input type="checkbox"> 
								I have read and agree to the <u><b>Terms &amp; Conditions</b></u>, 
								the <u><b>Fare Rules</b></u> and <u><b>general conditions of carriages</b></u>
								applicable to my departure(s) and accepts that my card will be debited
								immediately.
							</label>
							<input type="hidden" name="date" value="<?php echo $d; ?>">
							<input type="hidden" name="source" value="<?php echo $_POST['source']; ?>">
							<input type="hidden" name="destination" value="<?php echo $_POST['destination']; ?>">
							<input type="hidden" name="launch_name" value="<?php echo $_POST['launch_name']; ?>">
							<input type="hidden" name="time" value="<?php echo $_POST['time']; ?>">
							<input type="hidden" name="seat_catagory" value="<?php echo $_POST['seat_catagory']; ?>">
							<input type="hidden" name="cabin" value="<?php echo $_POST['cabin']; ?>">
							<input type="hidden" name="cost" value="<?php echo $totalCost; ?>">
							<input type="submit" class="btn btn-success"></input>
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
<?php
mysql_free_result($userForpur);
?>
