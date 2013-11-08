<?php
include('dbfunc.php');
include("header.php");
if(isset($_GET['username'])){
	$username=$_GET['username'];

	confirmUser($username);
	$_SESSION['confirmed']=1;
	echo "Thanks for confirming ". $username;

}

include("footer.php");
?>