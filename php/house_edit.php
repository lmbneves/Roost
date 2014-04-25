<?php
	
	$id = $_GET["id"];

	// connects to MySQL server
	$connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
		or die (mysql_error());

	// selects the database to use
	$db = mysqli_select_db($connect, 'urooxldw_roost')
		or die(mysql_error());

	$house_query = sprintf("SELECT * FROM house where id='%s'",
								mysqli_real_escape_string($connect,$id));
	$house=mysqli_query($connect,$house_query);
	if(!$house){
		echo 'Query failed! '.mysql_error();
	}
	$row = mysqli_fetch_array($house);

	//Storing all the information from landlords in variables
	$number_edit = $row['number'];
	$name_edit = $row['name'];
	$suffix_edit = $row['suffix'];
	$address_edit = $number_edit . ' ' . $name_edit . ' ' . $suffix_edit;
	$city_edit = $row['city'];
	$state_edit = $row['state'];
	$zipcode_edit = $row['zipcode'];
	$fname_edit = $row['landlord_fname'];
	$lname_edit= $row['landlord_lname'];
	$size_edit = $row['size'];
	$bedroom_edit = $row['bedroom'];
	$bathroom_edit = $row['bathroom'];
	$furnished_edit = $row['furnished'];
	$parking_edit = $row['parking'];
	$pets_edit = $row['pets'];
	$price_edit = $row['price'];
	$age_edit = $row['age'];
	$renovation_edit = $row['renovation'];
	$size_edit = $row['size'];

	//$img = $row['img_path'];

	//$img_path = '<div><img src="landlord-profile-images/'.$img.'"/></div>';

	mysqli_close($connect);
?>