
<?php
session_start();

if(!isset($_SESSION['username'])==null){
echo '<div id="log-div">
	<span>Logged in as '.$_SESSION['username'].'.</span>
	<a href="../php/logout.php"><button id="logout-btn">Logout</button></a>
   </div>';


} 
?>