<?php

	$id = $_GET["id"];

	// connects to MySQL server
	$connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
		or die (mysql_error());

	// selects the database to use
	$db = mysqli_select_db($connect, 'urooxldw_roost')
		or die(mysql_error());

	$house_query = sprintf("SELECT * FROM house WHERE id ='%s'",
							mysqli_real_escape_string($connect, $id));

	$house = mysqli_query($connect,$house_query);

	$row = mysqli_fetch_array($house);

	$number = $row['number'];
	$name = $row['name'];
	$suffix = $row['suffix'];
	$neighborhood = $row['neighborhood'];
	$city = $row['city'];
	$state = $row['state'];
	$zipcode = $row['zipcode'];
	$landlord_fname = $row['landlord_fname'];
	$landlord_lname = $row['landlord_lname'];
	$size = $row['size'];
	$bedroom = $row['bedroom'];
	$bathroom = $row['bathroom'];
	$furnished = $row['furnished'];
	$parking = $row['parking'];
	$pets = $row['pets'];
	$price = $row['price'];
	$age = $row['age'];
	$renovation = $row['renovation'];
	$landlord_id = $row['landlord_id'];
	$house_id = $row['id'];

	if ($age == "0000-00-00")
	{
		$age = "N/A";
	}

	if ($renovation == "0000-00-00")
	{
		$renovation = "N/A";
	}

	mysqli_close($connect);
?>