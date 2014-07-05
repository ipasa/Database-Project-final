<?php
require_once('../Connections/neticketing.php');
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}
$user_id = $_SESSION['user_id']; 
$date = $_POST['date'];
$EditedDate = strtotime($_POST['date']);
$journey_date = date("Y-m-d",$EditedDate );
$purchase_date = date("Y-m-d");
$departure_time = $_POST['time'];
$source = $_POST['source'];
$destination = $_POST['destination'];
$launch_name = $_POST['launch_name'];
$seat_catagory = $_POST['seat_catagory'];
$cabin = $_POST['cabin'];
$cost = $_POST['cost'];
$tnr = rand(1000,1000000);

mysql_select_db($database_neticketing, $neticketing);
$query_insertData = "INSERT into purchase_info (user_id, purchase_date, journey_date, dept_time, source, destination, launch_name, catagory, amount, tnr)
VALUES ('$user_id', '$purchase_date', '$journey_date', '$departure_time', '$source', '$destination', '$launch_name', '$seat_catagory', '$cabin', '$tnr')";
$success_insertData = mysql_query($query_insertData, $neticketing) or die(mysql_error());
?>

<!DOCTYPE html>
<html>
<head>
<script src="jquery-1.9.0.js" type="text/JavaScript"
	language="javascript"></script>
<script src="jquery.PrintArea.js" type="text/JavaScript"
	language="javascript"></script>

<link type="text/css" rel="stylesheet" href="PrintArea.css" />
<link type="text/css" rel="" href="empty.css" />
<link type="text/css" rel="noPrint" href="noPrint.css" />
<link href="../css/main_style.css" media="screen" rel="stylesheet"
	type="text/css">
<link id="page_favicon" href="../images/favicon.ico" rel="icon"
	type="image/icon" />
<title>Bangladesh Inland Water Transport Authority(BIWTA), E-ticketing service</title>
</head>

<!-------------------HEADER START---------------------->
<div id="header">
	<div id="header1">
		<img src="../images/ministryOfNevel.gif" height="100" />
	</div>
	<div id="header_tab2">
		<div id="header2">
			<img src="../images/bangladesh.gif" height="100" />
		</div>
	</div>
</div>
<!-------------------HEADER END---------------------->

<!-------------------BODY START---------------------->
<body>
	<div id="signup_body" class="account_body" style="padding-top: 0px;">
		<div id="tabs">

			<!--------------------main menu---------------------->
			<?php include('navigation.php');?>
			<!--------------------main menu---------------------->

			<div id="trainroute" style="margin-top: 30px;">
				<div id="train_route_div">
					<fieldset class="signup_fieldset">
						<legend id="legend">&nbsp;PURCHASE TICKET&nbsp;</legend>
						<div class="PrintArea p1">
							<p>
								<span>About Purchase Info</span> :
							</P>
							<P>User Id: <?php echo $user_id; ?></P>
							<P>Ticket No: <?php echo $tnr; ?></P>
							<P>Station To: <?php echo $source; ?></P>
							<P>Station From: <?php echo $destination; ?></P>
							<P>Launce Name: <?php echo $launch_name; ?></P>
							<P>Catagory: <?php echo $seat_catagory; ?></P>
							<P>Date: <?php echo $date; ?></P>
							<p>Time: <?php echo $departure_time; ?></p>
							<P>No of <?php echo $seat_catagory; ?>: <?php echo $cabin; ?></P>
							<P>Cost: <?php echo $cost; ?></P>
							</p>
						</div>
						<div class="button b1">Print</div>

						<script>
				$(document).ready(function(){
					$("div.b1").click(function(){

						var mode = $("input[name='mode']:checked").val();
						var close = mode == "popup" && $("input#closePop").is(":checked")

						var options = { mode : mode, popClose : close };

						$("div.PrintArea.p1").printArea( options );
					});

					$("input[name='mode']").click(function(){
						if ( $(this).val() == "iframe" ) $("#closePop").attr( "checked", false );
					});
				});

				</script>
					</fieldset>
				</div>
			</div>

		</div>
	</div>
</body>

<!-------------------BODY END---------------------->

<!-------------------FOOTER START---------------------->
<?php include('../include/footer.php');?>
<!-------------------FOOTER END---------------------->

</html>
