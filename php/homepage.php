<?php
	// connects to MySQL server
	$connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
		or die (mysql_error());

	// selects the database to use
	$db = mysqli_select_db($connect, 'urooxldw_roost')
		or die(mysql_error());

	// gets data from house table
	$house_data = mysqli_query($connect,"SELECT * FROM house");

/*
	$landlord_id = mysqli_query($connect,"SELECT landlord_id FROM house");
	$landlord_id_row = mysqli_fetch_array($landlord_id);

	$i = 0;
*/
/*
	while(($landlord_id_row = mysqli_fetch_array($landlord_id, MYSQLI_NUM)) && $i <=2){
		$landlord[$i] = sprintf("SELECT * FROM landlord  WHERE id='%s'",
								mysql_real_escape_string($landlord_id_row[$i]));
		$i++;
	}

*/

	$i = 0;

	while(($row = mysqli_fetch_array($house_data)) && $i<=2)
	  {
	  	echo '<div id="house'.($i+1).'" class="recent-house col-xs-4">';
	  	echo '<div class="map"></div>';
        echo '<div class="recent-house-info">';
        echo '<h3><a href="http://www.uroost.org/house_profile.php?id='.$row['id'].'">'.$row['number']." ".ucfirst($row['name'])." ".ucfirst($row['suffix']).'</a></h3>';
        echo '<div><p>Landlord: <a href="http://www.uroost.org/landlord_profile.php?id='.$row['landlord_id']. '">'.$row['landlord_fname']." ".$row['landlord_lname'].'</a></br>Bedrooms: '.$row['bedroom'].'</br>Bathrooms: '.$row['bathroom'].'</br>Furnished: '.$row['furnished'].'</br>Total Rent: $'.$row['price'].'/month';
        echo '</p></div></div></div>';

        $i++;
	  }



	mysqli_close($connect);
?>