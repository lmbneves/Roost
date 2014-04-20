<?php
	// connects to MySQL server
	$connect = mysql_connect('localhost', 'urooxldw_lneves', 'houses77')
		or die (mysql_error());

	// selects the database to use
	$db = mysql_select_db('urooxldw_roost')
		or die(mysql_error());


	$result = mysqli_query($connect,"SELECT * FROM house");


	while($row = mysqli_fetch_array($result))
	  {
	  echo $row['number'] . " " . $row['street'];
	  echo "<br>";
	  }

	mysqli_close($connect);
?>
