<?php
echo "Hello";
$date=strtotime($_POST['country']);
$D=date("l F j, Y",$date);
echo "<br/>".$D;
header( "refresh:5;url=http://localhost/neticketing/dashboard.php" ); 
echo 'You\'ll be redirected in about 5 secs. ';
echo 'If not, click <a href="localhost/neticketing/dashboard.php">here</a>.';
 ?>