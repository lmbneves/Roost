<?php
	// connects to MySQL server
	$connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
		or die (mysql_error());

	// selects the database to use
	$db = mysqli_select_db($connect, 'urooxldw_roost')
		or die(mysql_error());

	// gets data from house table
	$house_data = mysqli_query($connect,"SELECT * FROM house");

	$i = 0;

	while(($row = mysqli_fetch_array($house_data)) && $i<=2)
	  {
	  	echo '<div id="house'.($i+1).'" class="recent-house col-xs-4">';
	  	echo '<div class="map"></div>';
        echo '<div class="recent-house-info">';
        echo '<h3>'.$row['number']." ".ucfirst($row['name'])." ".ucfirst($row['suffix']).'</h3>';
        echo '<div><p>Landlord: '.$row['landlord_fname']." ".$row['landlord_lname'].'</br>Bedrooms: '.$row['bedroom'].'</br>Bathrooms: '.$row['bathroom'].'</br>Approx. Rent: $'.$row['price'].'/month';
        echo '</p>'.'</div>'.'</div>'.'</div>';

        $i++;
	  }



	mysqli_close($connect);
?>