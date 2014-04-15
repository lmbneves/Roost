<?php
	
	//mysqli_connect("Hostname", "Username", "Password", "Database Name")
	$connection = mysqli_connect("server74.web-hosting.com:2083","urooxldw_lneves","house77","urooxldw_roost");

	//Check for connection
	if(mysqli_connect_errno()){
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	//Escape variables for security
	$firstname = mysqli_real_escape_string($_POST['firstname']);
	

	$sql = "INSERT INTO l (fname, lname, properties, phone, email, state, city, zipcode)
			VALUES ($firstname, $lastname, $known_properties, $phone, $email, $state, $city, $zipcode)";

	if(!mysql_query($connection, $sql)){
		die('Error: ' . mysql_error($con));
	}

	echo "Added New Landlord!";

	mysqli_close($con);		
?>