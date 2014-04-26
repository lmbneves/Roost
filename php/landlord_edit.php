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
	$fname_edit = $row['fname'];
	$lname_edit = $row['lname'];
	$active_edit = $row['active'];
	$company_edit = $row['company'];
	$phone_edit = $row['phone'];
	$email_edit = $row['email'];
	$city_edit = $row['city'];
	$state_edit= $row['state'];
	$zipcode_edit = $row['zipcode'];
	$img = $row['img_path'];

	$img_path = '<div><img src="landlord-profile-images/'.$img.'"/></div>';

	mysqli_close($connect);
?>