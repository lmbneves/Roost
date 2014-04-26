<?php
	// connects to MySQL server
	$connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
		or die (mysql_error());

	// selects the database to use
	$db = mysqli_select_db($connect, 'urooxldw_roost')
		or die(mysql_error());

	// gets data from house table and sets a counter
	$house_data = mysqli_query($connect,"SELECT * FROM house");
        $i = 0;
	while(($row = mysqli_fetch_array($house_data)))
	  {
                
	  	echo '<div class="result">';
	  	echo '<div class="img" id="img"'.$i.'"></div>';
	  	echo '<div class="result-info"><div class="result-title"><a href="http://www.uroost.org/house_profile.php?id='.$row['id'].'"><h3 class="address">'.$row['number'].' '.ucfirst($row['name']).' '.ucfirst($row['suffix']).'</h3></a></div>';
	  	echo '<div>Landlord: <a href="http://www.uroost.org/landlord_profile.php?id='.$row['landlord_id'].'">'.ucfirst($row['landlord_fname']).' '.ucfirst($row['landlord_lname']).'</a></br>Bedrooms: '.$row['bedroom'].'</br>Bathrooms: '.ucfirst($row['bathroom']).'</br>Furnished: '.ucfirst($row['furnished']).'</br>Parking: '.ucfirst($row['parking']).'</br>Rent: '.ucfirst($row['price']);
	  	echo '</div></div></div>';
	  }



	mysqli_close($connect);
?>