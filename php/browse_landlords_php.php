<?php
	// connects to MySQL server
	$connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
		or die (mysql_error());

	// selects the database to use
	$db = mysqli_select_db($connect, 'urooxldw_roost')
		or die(mysql_error());

	// gets data from landlord table
	$landlord_data = mysqli_query($connect,"SELECT * FROM landlord");

	while($row = mysqli_fetch_array($landlord_data)) {

		//Find out how many houses the landlord has
		$landlord_house_query = sprintf("SELECT * FROM house WHERE landlord_id='%s'",
										mysqli_real_escape_string($connect, $row['id']));
		$landlord_house = mysqli_query($connect, $landlord_house_query);
		if(!$landlord_house){
			echo 'WHAT THE FUCK!!!!'. mysql_error();
		}

		$count = mysqli_num_rows($landlord_house);
				
		$landlord_insert_query = sprintf("UPDATE landlord SET properties='%s' WHERE id='%s';",
										mysqli_real_escape_string($connect, $count),
										mysqli_real_escape_string($connect, $row['id']));
		$landlord_insert = mysqli_query($connect, $landlord_insert_query);

		if(!$landlord_insert){
			echo 'WHY ISNT THIS WORKING!!!'. mysql_error();
		}

	  	echo '<div class="result">';
	  	echo '<div class="browse-landlord-img"><img src="landlord-profile-images/'.$row['img_path'].'"/></div>';
	  	echo '<div class="result-info"><div class="result-title"><h3><a href="http://www.uroost.org/landlord_profile.php?id='.$row['id'].'">'.ucfirst($row['fname']).' '.ucfirst($row['lname']).'</a></h3></div>';
	  	echo  '<div>Properties: '.$row['properties'].'</br>Company: '.ucfirst($row['company']).'</br></br>Phone: '.$row['phone'].'</br>Email: '.$row['email'];
	  	echo '</div></div></div>';
	  }



	mysqli_close($connect);
?>