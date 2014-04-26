<?php

	// connects to MySQL server
	$connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
		or die (mysql_error());

	// selects the database to use
	$db = mysqli_select_db($connect, 'urooxldw_roost')
		or die(mysql_error());

	//Searches for landlord's current houses
	$house_query = 'SELECT * FROM house WHERE landlord_id="'.$id.'"';
	$houses = mysqli_query($connect, $house_query);
	if(!$houses){
		echo 'Query failed! '.mysql_error();
	}

	$i=0;

	while(($row = mysqli_fetch_array($houses)) &&  $i<=2){
		echo '<div id="house'.($i+1).'" class="col-xs-4 landlord-house">';
	  	echo '<div class="map"></div>';
        echo '<div class="recent-house-info">';
        echo '<h3><a href="http://www.uroost.org/house_profile.php?id='.$row['id']. '">'.$row['number']." ".ucfirst($row['name'])." ".ucfirst($row['suffix']).'</a></h3>';
        echo '<div><p>Bedrooms: '.$row['bedroom'].'</br>Bathrooms: '.$row['bathroom'].'</br>Total Rent: $'.$row['price'].'/month';
        echo '</p>'.'</div>'.'</div>'.'</div>';

        $i++;
	}

	mysqli_close($connect);

?>