<?php 
if (isset($_SESSION['user_email'])) {
?>
<ul class="mainmenu">
	<li class="<?php if ($placeholder == "index") {echo "active"; } ?>"><a href="index.php">Fare Query</a></li>
	<li class="<?php if ($placeholder == "routelist") {echo "active"; } ?>"><a href="routelist.php">Launch Route</a></li>
	<li class="<?php if ($placeholder == "purchaseticket") {echo "active"; } ?>"><a href="purchaseticket.php">Purchase Ticket</a></li>
	<li class="<?php if ($placeholder == "dashboard") {echo "active"; } ?>"><a href="dashboard.php">Dashboard</a></li>
    <li class="<?php if ($placeholder == "logout") {echo "active"; } ?>"><a href="logout.php">Logout</a></li>
</ul>

<?php  }else{?>

<ul class="mainmenu">
	<li class="<?php if ($placeholder == "index") {echo "active"; } ?>"><a href="index.php">Fare Query</a></li>
	<li class="<?php if ($placeholder == "routelist") {echo "active"; } ?>"><a href="routelist.php">Launch Route</a></li>
	<li class="<?php if ($placeholder == "purchaseticket") {echo "active"; } ?>"><a href="purchaseticket.php">Purchase Ticket</a></li>
	<li class="<?php if ($placeholder == "login") {echo "active"; } ?>"><a href="login.php">Login</a></li>
</ul>

<?php } ?> 