<?php
	
	//mysqli_connect("Hostname", "Username", "Password", "Database Name")
	$connection = mysqli_connect(localhost,"urooxldw_lneves","house77","urooxldw_roost");

	//Check for connection
	if(mysqli_connect_errno()){
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	//Escape variables for security
	$firstname = mysqli_real_escape_string($_POST['firstname']);
	$lastname = mysqli_real_escape_string($_POST['lastname']);
	$known_properties = mysqli_real_escape_string($_POST['known_properties']);
	$phone = mysqli_real_escape_string($_POST['phone']);
	$email = mysqli_real_escape_string($_POST['email']);
	$state = mysqli_real_escape_string($_POST['state']);
	$city = mysqli_real_escape_string($_POST['city']);
	$zipcode = mysqli_real_escape_string($_POST['zipcode']);
	$review = mysqli_real_escape_string($_POST['review']);
	$rating = mysqli_real_escape_string($_POST['rating']);

	$sql = "INSERT INTO landlord (fname, lname, properties, phone, email, state, city, zipcode)
			VALUES ($firstname, $lastname, $known_properties, $phone, $email, $state, $city, $zipcode)";

	if(!mysql_query($connection, $sql)){
		die('Error: ' . mysql_error($con));
	}

	echo "Added New Landlord!";

	mysqli_close($con);		
?>