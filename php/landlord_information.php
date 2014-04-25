<?php
	
	$id = $_GET["id"];

	// connects to MySQL server
	$connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
		or die (mysql_error());

	// selects the database to use
	$db = mysqli_select_db($connect, 'urooxldw_roost')
		or die(mysql_error());

	$landlord_query = sprintf("SELECT * FROM landlord where id='%s'",
								mysqli_real_escape_string($connect,$id));
	$landlord=mysqli_query($connect,$landlord_query);
	if(!$landlord){
		echo 'Query failed! '.mysql_error();
	}
	$row = mysqli_fetch_array($landlord);

	//Storing all the information from landlords in variables
	$fname = $row['fname'];
	$lname = $row['lname'];
	$active = $row['active'];
	$company = $row['company'];
	$phone = $row['phone'];
	$email = $row['email'];
	$city = $row['city'];
	$state = $row['state'];
	$zipcode = $row['zipcode'];
	$img = $row['img_path'];

	$img_path = '<div><img src="landlord-profile-images/'.$img.'"/></div>';

	mysqli_close($connect);
?>