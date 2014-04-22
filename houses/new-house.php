<?php
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
 
sec_session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Roost</title>

    <!-- ========== CSS stylesheets ========== -->
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <link href="../css/grid.css" type="text/css" rel="stylesheet">
    <link href="../css/layout.css" type="text/css" rel="stylesheet">
    <link href="../css/forms.css" type="text/css" rel="stylesheet">

    <!-- stylesheet for this site -->
    <link href="../css/base.css" type="text/css" rel="stylesheet">

    <!-- stylesheet for this page -->
    <link href="../css/new.css" type="text/css" rel="stylesheet">

    <!-- ============= favicons ============= -->

    <!-- =============== fonts =============== -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100,500' rel='stylesheet' type='text/css'>

  </head>

  <body>

    <!-- top navigation bar -->
    <div class="super-container navbar-wrapper">
      <nav class="container">
        <div class="navbar" role="navigation">
          <ul id="nav" class="list-inline list-unstyled">
            <li><a href=""><img src="../icons/logo.gif"></a></li>
            <li><a href="">Houses</a></li>
            <li><a href="">Landlords</a></li>
          </ul>
        </div>

        <div class="sign-in-up">

          <ul id="sign" class="list-inline list-unstyled">
          <?php if (login_check($mysqli) == true) : ?>
            <li><p>Welcome  <?php echo htmlentities($_SESSION['username']); ?>!</p></li>
            <li><a href="includes/logout.php">Logout</a></li>
          <?php else : ?>
            <li><a href="signup.php">Sign Up</a></li>
            <li> <a href="login.php">Sign In</a></li>
           <?php endif; ?>  
          </ul>
        </div>
      </nav>
    </div><!-- top navigation bar, super-container -->
        <!-- PHP Code -->

    <?php

     function typeCheck($string, $type){

      //Assign type 
      $type = 'is_'.$type;

      //Checks if string is correct type
      if(!$type($string)){
        return FALSE;
      }

      //Checks if string is empty
      elseif(empty($string)){
        return FALSE;
      }
      else return TRUE;
    }

    function checkZip($zip){
      if($zip > 0 && strlen($zip) == 5){
        return TRUE;
      }
      else return FALSE;
    }

    //Checks if all variables are set
    function checkSet(){
      return isset($_POST['address'], $_POST['city'], $_POST['state'], $_POST['zipcode'], 
                  $_POST['landlord_fname'], $_POST['landlord_lname'], $_POST['bedrooms'], $_POST['bathrooms'], $_POST['parking'], 
                  $_POST['pets'], $_POST['rent']);
    }

     function checkAddress($address){
      $check = explode(" ", $address);

      //Ensures that address has 3 parts
      if(sizeof($check) != 3){
        return FALSE;
      }

      //Makes sure first entry of the address is the house number
      if(typeCheck($check[0], 'numeric') == FALSE){
        return FALSE;
      }

      //Makes sure second entry of the address is the street name
      if(typeCheck($check[1], 'string') == FALSE){
        return FALSE;
      }

      //Makes sure that third entry of the address is the street suffix
      if(typeCheck($check[2], 'string') == FALSE){
        return FALSE;
      }

      else return TRUE;

    }

    function checkName($name){
      $check = explode(" ", $name);

      //Ensures that name has 2 parts
      if(sizeof($check) != 2){
        return FALSE;
      }

      else return TRUE;
    }

    //Ensures rent number is greater than 0
    function checkRent($rent){
      if($rent >= 0){
        return TRUE;
      }
      else return FALSE;
    }

    function formComplete(){
      if(($address_complete and $city_complete and $state_complete and $zipcode_complete and $landlord_fname_complete and $landlord_lname_complete and
          $bedrooms_complete and $bathrooms_complete and $parking_complete and $pets_complete and $rent_complete) == TRUE){
          return TRUE;
      }
      else return FALSE;
    }

    if(checkSet() != FALSE && $_SERVER["REQUEST_METHOD"] == "POST") {
      if(empty($_POST['address']) == FALSE && typeCheck($_POST['address'], 'string') != FALSE && 
          checkAddress($_POST['address']) != FALSE){
            $address = explode(" ", $_POST['address']);
            $house_number = $address[0];
            $street_name = $address[1];
            $suffix = $address[2];
            $address_complete = TRUE;
        }
      else{
          $addressErr = "Please enter a valid address!";
          $address_complete = FALSE;
      }

      if(empty($_POST['city']) == FALSE && typeCheck($_POST['city'], 'string') != FALSE){
          $city = $_POST['city'];
          $city_complete = TRUE;
        }
      else{
        $cityErr = "City is not set!";
        $city_complete = FALSE;

      }

      if(empty($_POST['state']) == FALSE && typeCheck($_POST['state'], 'string') != FALSE){
        $state = $_POST['state'];
        $state_complete = TRUE;
      }
      else{
        $stateErr = "State is not set!";
        $state_complete = FALSE;
      }

      if(empty($_POST['zipcode']) == FALSE && typeCheck($_POST['zipcode'], 'numeric') != FALSE && 
          checkZip($_POST['zipcode']) != FALSE){
          $zipcode = $_POST['zipcode'];
          $zipcode_complete = TRUE;
        }
        else{
          $zipcodeErr = "Invalid Zipcode Supplied!";
          $zipcode_complete = FALSE;
        }

        if(empty($_POST['landlord_fname']) == FALSE && typeCheck($_POST['landlord_fname'], 'string') != FALSE){
            $landlord_fname = $_POST['landlord_fname'];
            $landlord_fname_complete = TRUE;
        }
        else{
          $landlord_fnameErr = "Please enter a first name and a last name!";
          $landlord_fname_complete = FALSE;
        }

        if(empty($_POST['landlord_lname']) == FALSE && typeCheck($_POST['landlord_lname'], 'string') != FALSE){
            $landlord_lname = $_POST['landlord_lname'];
            $landlord_lname_complete = TRUE;
        }
        else{
          $landlord_lnameErr = "Please enter a first name and a last name!";
          $landlord_lname_complete = FALSE;
        }

        if($_POST['bedrooms'] != "select"){
          $bedrooms = $_POST['bedrooms'];
          $bedrooms_complete = TRUE;
        }
        else{
          $bedroomsErr = "Please specify a value for number of bedrooms!";
          $bedrooms_complete = FALSE;
        }

        if($_POST['bathrooms'] != "select"){
          $bathrooms = $_POST['bathrooms'];
          $bathrooms_complete = TRUE;
        }
        else{
          $bathroomsErr = "Please select a value for the number of bathrooms!";
          $bathrooms_complete = FALSE;
        }

        if($_POST['parking'] != "select"){
          $parking = $_POST['parking'];
          $parking_complete = TRUE;
        }
        else{
          $parkingErr = "Please specify if offstreet parking is available!";
          $parking_complete = FALSE;
        }

        if($_POST['pets'] != "select"){
          $pets = $_POST['pets'];
          $pets_complete = TRUE;
        }
        else{

          $petsErr = "Please specify if pets are allowed in the house!";
          $pets_complete = FALSE;
        }

        if(empty($_POST['rent']) == FALSE && checkRent($_POST['rent']) != FALSE) {
          $rent = $_POST['rent'];
          $rent_complete = TRUE;
        }
        else{
          $rentErr = "Please enter a valid number for rent!";
          $rent_complete = FALSE;
        }

        $id = uniqid(rand(), true);

        if($address_complete and $city_complete and $state_complete and $zipcode_complete and $landlord_fname_complete and $landlord_lname_complete and
          $bedrooms_complete and $bathrooms_complete and $parking_complete and $pets_complete and $rent_complete){

            //Connect to mysql server
            $connect = mysql_connect('localhost', 'urooxldw_lneves', 'houses77')
            or die(mysql_error());

            //Select which database we should use
            $db = mysql_select_db('urooxldw_roost')
            or die(mysql_error()); 

            //echo 'Firstname: '.$landlord_fname;
            //echo ' Lastname: '.$landlord_lname;

            $landlord_id_query = sprintf("SELECT id FROM landlord WHERE fname='%s' and lname = '%s'", 
                              mysql_real_escape_string($landlord_fname),
                              mysql_real_escape_string($landlord_lname));

            $result = mysql_query($landlord_id_query);

            if(!$result){
              echo 'Query failed'.mysql_error();
              $landlord_fnameErr = "Landlord does not exist!";
              $landlord_lnameErr = "Landlord does not exist!";
            }
            else{
            $row = mysql_fetch_row($result);
            $landlord_id = $row[0];

            $query = sprintf("INSERT INTO house (number, name, suffix, city, state, zipcode, landlord_fname, landlord_lname,
                              bedroom, bathroom, parking, pets, price, landlord_id, id)
                              VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
                              mysql_real_escape_string($house_number),
                              mysql_real_escape_string($street_name),
                              mysql_real_escape_string($suffix),
                              mysql_real_escape_string($city),
                              mysql_real_escape_string($state),
                              mysql_real_escape_string($zipcode),
                              mysql_real_escape_string($landlord_fname),
                              mysql_real_escape_string($landlord_lname),
                              mysql_real_escape_string($bedrooms),
                              mysql_real_escape_string($bathrooms),
                              mysql_real_escape_string($parking),
                              mysql_real_escape_string($pets),
                              mysql_real_escape_string($rent),
                              mysql_real_escape_string($landlord_id),
                              mysql_real_escape_string($id));

            if(!mysql_query($query)){
              echo 'Query failed '.mysql_error();
              exit();
            }
            else{
              echo "<script>window.location = 'http://www.uroost.org/houses/house_success.php'</script>";
            }
          }
        }  
    }    
    else {
      //echo 'form not complete!';
    }                               

    ?>

    <!-- page content -->
    <div class="container">
      <div class="panel panel-default top_margin">
        <div class="panel-heading"><h2 class="panel-title">Add New House</h2></div>
        <div class="panel-body">

          <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" role="form">
            <div class="form-group">
              <label class="control-label">Address: </label>
              <?php echo $addressErr;?>
              <input type="text" class="form-control" name="address">
            </div>
            <div class="form-group">
              <label class="control-label">City: </label>
              <span class="has-error"><?php echo $cityErr;?></span>
              <input type="text" class="form-control" name="city">
            </div>
            <div class="form-group">
              <label class="control-label">State: </label>
              <span class="has-error"><?php echo $stateErr;?></span>
              <input type="text" class="form-control" name="state">
            </div>
            <div class="form-group">
              <label class="control-label">Zipcode: </label>
              <span class="has-error"><?php echo $zipcodeErr;?></span>
              <input type="text" class="form-control" name="zipcode">
            </div>
            <div class="form-group">
              <label class="control-label">Landlord's First Name: </label>
              <span class="has-error"><?php echo $landlord_fnameErr;?></span>
              <input type="text" class="form-control" name="landlord_fname">
            </div>
            <div class="form-group">
              <label class="control-label">Landlord's Last Name: </label>
              <span class="has-error"><?php echo $landlord_lnameErr;?></span>
              <input type="text" class="form-control" name="landlord_lname">
            </div>
            <div class="form-group">
              <label class="control-label">Number of bedrooms </label>
              <span class="has-error"><?php echo $bedroomsErr;?></span>
              <select class="form-control" name="bedrooms">
                <option selected="selected" value="select">Select a value</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="10+">10+</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Number of bathrooms </label>
              <span class="has-error"><?php echo $bathroomsErr;?></span>
              <select class="form-control" name="bathrooms">
                <option selected="selected" value="select">Select a value</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="10+">10+</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Offstreet Parking? </label>
              <span class="has-error"><?php echo $parkingErr;?></span>
              <select class="form-control" name="parking">
                <option selected="selected" value="select">Select a value</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Pets? </label>
              <span class="has-error"><?php echo $petsErr;?></span>
              <select class="form-control" name="pets">
                <option selected="selected" value="select">Select a value</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Total Rent per Month: </label>
              <span class="has-error"><?php echo $rentErr;?></span>
              <input type="text" class="form-control" name="rent">
            </div>

            <!-- Taking this out until we figure out what to do with it -->
            <!--   
            <div class="form-group">
              <label class="control-label">Known properties: </label>
              <input type="text" class="form-control" id="House-kp">
            </div>
            
            <div class="form-group">
              <label class="control-label">Review this House: </label>
              <textarea class="form-control" name="review">Scribble your comments about this House
              </textarea>
            </div>
            
            <div class="form-group">
              <label class="control-label">Overall rating: </label>
              <select class="form-control" name="rating">
                <option selected="selected" value="select">Select a value</option>
                <option value="stellar">Stellar House</option>
                <option value="good">Good House</option>
                <option value="mediocre">Mediocre House</option>
                <option value="bad">Bad House</option>
                <option value="abysmal">Abysmal House</option>
              </select>
            </div>
            -->

            <div class="input-group">
              <span><button id="House-add-button" class="btn btn-default" type="submit">Add House</button></span>
            </div>
          </form>

        </div>
      </div>
    </div>

    <!-- footer -->
    <div class="footer">
      <div class="container">
        <p>&copy Roost 2014</p>
      </div>
    </div>

    <!-- ============ javascript ============ -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/homepage.js"></script>
  </body>
</html>
