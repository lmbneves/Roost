<?php 
	$id = $_GET["id"];
	// connects to MySQL server
	$connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
	or die (mysql_error());

	// selects the database to use
	$db = mysqli_select_db($connect, 'urooxldw_roost')
	or die(mysql_error());

	//Finds the user information in the database from the id
	$user_query = sprintf("SELECT * FROM members WHERE id = '%s'",
	          mysqli_real_escape_string($connect, $id));

	$user = mysqli_query($connect, $user_query);

	if(!$user){
	echo 'Query Failed! ' .mysql_error();
	}

	$row = mysqli_fetch_array($user);

	$username = $row['username'];
	$email = $row['email'];
?>