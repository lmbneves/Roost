<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include 'php/house_edit.php';
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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link href="css/forms.css" type="text/css" rel="stylesheet">

    <!-- stylesheet for this site -->
    <link href="css/base.css" type="text/css" rel="stylesheet">


    <!-- ============= favicons ============= -->
    <link rel="icon" href="icons/logo.gif">

    <!-- =============== fonts =============== -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100,500' rel='stylesheet' type='text/css'>

  </head>

  <body>

    <!-- top navigation bar -->
    <div class="super-container navbar-wrapper">
      <nav class="container">
        <div class="navbar" role="navigation">
          <ul id="nav" class="list-inline list-unstyled">
            <li><a href="http://www.uroost.org"><img src="icons/logo.gif"></a></li>
            <li><a href="http://www.uroost.org/browse_houses.php">Houses</a></li>
            <li><a href="http://www.uroost.org/browse_landlords.php">Landlords</a></li>
          </ul>
        </div>

         <div class="sign-in-up">

            <ul id="sign" class="list-inline list-unstyled">
            <?php if (login_check($mysqli) == true) : ?>
              <li><p><?php echo '<a href="http://www.uroost.org/user_profile.php?id='.$_SESSION['user_id'].'">'
                              .htmlentities($_SESSION['username']).'</a>'; ?></p></li>
              <li><a href="includes/logout.php">Logout</a></li>
            <?php else : ?>
              <li><a href="http://www.uroost.org/signup.php">Sign Up</a></li>
              <li> <a href="http://www.uroost.org/login.php">Sign In</a></li>
             <?php endif; ?>  
            </ul>
          </div>
      </nav>
    </div><!-- top navigation bar, super-container -->
        <!-- PHP Code -->

    <?php if (login_check($mysqli) == true) :?>    

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
      return isset($_POST['address'], $_POST['city'], $_POST['state'], $_POST['landlord_fname'], $_POST['landlord_lname']);
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

    if(checkSet() != FALSE && $_SERVER["REQUEST_METHOD"] == "POST") {
      if(empty($_POST['address']) == FALSE && typeCheck($_POST['address'], 'string') != FALSE){
            $address = explode(" ", $_POST['address']);
            $house_number = $address[0];

            //Address is 3 Seperate Entities
            if(count($address) == 3){
              $street_name = $address[1];
              $suffix = $address[2];
            }

            if(count($address) == 4){
              $street_name = $address[1] .' '. $address[2];
              $suffix = $address[3];
            }

            if(count($address) == 5){
              $street_name = $address[1] .' '.$address[2] .' '.$address[3];
              $suffix = $address[4];
            }

            if(count($address) == 6){
              $street_name = $address[1] .' '.$address[2] .' '.$address[3] .' '.$address[4];
              $suffix = $address[5];
            }

            $address_complete = TRUE;
        }
      else{
          $addressErr = 'Please enter a valid address!';
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
        $state = "";
      }

      if(empty($_POST['zipcode']) == FALSE && typeCheck($_POST['zipcode'], 'numeric') != FALSE && 
          checkZip($_POST['zipcode']) != FALSE){
          $zipcode = $_POST['zipcode'];
          $zipcode_complete = TRUE;
        }
        else{
          //$zipcodeErr = "Invalid Zipcode Supplied!";
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
        }

        if($_POST['bathrooms'] != "select"){
          $bathrooms = $_POST['bathrooms'];
        }

        if($_POST['parking'] != "select"){
          $parking = $_POST['parking'];
        }

        if($_POST['pets'] != "select"){
          $pets = $_POST['pets'];
        }

        if($_POST['furnished'] != "select"){
          $furnished = $_POST['furnished']; 
        }

        $size = $_POST['size'];
        $rent = $_POST['rent'];
        $id = $_POST['id'];

        if($address_complete and $city_complete and $state_complete and $landlord_fname_complete and $landlord_lname_complete) {

            //Connect to mysql server
            $connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
            or die(mysql_error());

            //Select which database we should use
            $db = mysqli_select_db($connect,'urooxldw_roost')
            or die(mysql_error()); 

            //Find out which landlord is attatched to this house
            $landlord_id_query = sprintf("SELECT id FROM landlord WHERE fname='%s' and lname = '%s'", 
                              mysqli_real_escape_string($connect,$landlord_fname),
                              mysqli_real_escape_string($connect,$landlord_lname));

            $result = mysqli_query($connect, $landlord_id_query);

            if(!$result){
              echo 'Query failed'.mysql_error();
              $landlord_fnameErr = "Landlord does not exist!";
              $landlord_lnameErr = "Landlord does not exist!";
            }
            else{
            $row = mysqli_fetch_array($result);
            $landlord_id = $row['id'];
  
            //Update Landlord information
            $query = sprintf("UPDATE house SET number='%s', name='%s', suffix='%s', city='%s', state='%s', zipcode='%s', landlord_fname='%s', 
                              landlord_lname='%s', size='%s', bedroom='%s', bathroom='%s', furnished='%s', parking='%s', pets='%s', price='%s'  
                              WHERE id='%s'",
                            mysqli_real_escape_string($connect, $house_number),
                            mysqli_real_escape_string($connect, $street_name),
                            mysqli_real_escape_string($connect, $suffix),
                            mysqli_real_escape_string($connect, $city),
                            mysqli_real_escape_string($connect, $state),
                            mysqli_real_escape_string($connect, $zipcode),
                            mysqli_real_escape_string($connect, $landlord_fname),
                            mysqli_real_escape_string($connect, $landlord_lname),
                            mysqli_real_escape_string($connect, $size),
                            mysqli_real_escape_string($connect, $bedrooms),
                            mysqli_real_escape_string($connect, $bathrooms),
                            mysqli_real_escape_string($connect, $furnished),
                            mysqli_real_escape_string($connect, $parking),
                            mysqli_real_escape_string($connect, $pets),
                            mysqli_real_escape_string($connect, $rent),
                            mysqli_real_escape_string($connect, $id));

            $update_house = mysqli_query($connect, $query);

            //Run the query
            if(!$update_house){
              echo 'Query failed '.mysql_error();
              exit();
            }

            else{
                echo '<script>window.location = "http://www.uroost.org/house_profile.php?id='.$id.'"</script>';
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
              <p><i>Fields marked with * are required</i></p>
              <label class="control-label">Address: </label>
              *<?php echo $addressErr;?></p>
              <input type="text" class="form-control" name="address" value=<?php echo '"'.$address_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">City: </label>
              *<p class="error"><?php echo $cityErr;?></p>
              <input type="text" class="form-control" name="city" value=<?php echo '"'.$city_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">State: </label>
              *<p class="error"><?php echo $stateErr;?></p>
              <select class="form-control" name="state">
                <option value="select">Select the state</option>
                <option value="AL" <?php if($state_edit == 'AL') echo 'selected="selected"';?>>AL</option>
                <option value="AK" <?php if($state_edit == 'AK') echo 'selected="selected"';?>>AK</option>
                <option value="AZ" <?php if($state_edit == 'AZ') echo 'selected="selected"';?>>AZ</option>
                <option value="AR" <?php if($state_edit == 'AR') echo 'selected="selected"';?>>AR</option>
                <option value="CA" <?php if($state_edit == 'CA') echo 'selected="selected"';?>>CA</option>
                <option value="CO" <?php if($state_edit == 'CO') echo 'selected="selected"';?>>CO</option>
                <option value="CT" <?php if($state_edit == 'CT') echo 'selected="selected"';?>>CT</option>
                <option value="DE" <?php if($state_edit == 'DE') echo 'selected="selected"';?>>DE</option>
                <option value="FL" <?php if($state_edit == 'FL') echo 'selected="selected"';?>>FL</option>
                <option value="GA" <?php if($state_edit == 'GA') echo 'selected="selected"';?>>GA</option>

                <option value="HI" <?php if($state_edit == 'HI') echo 'selected="selected"';?>>HI</option>
                <option value="ID" <?php if($state_edit == 'ID') echo 'selected="selected"';?>>ID</option>
                <option value="IL" <?php if($state_edit == 'IL') echo 'selected="selected"';?>>IL</option>
                <option value="IN" <?php if($state_edit == 'IN') echo 'selected="selected"';?>>IN</option>
                <option value="IA" <?php if($state_edit == 'IA') echo 'selected="selected"';?>>IA</option>
                <option value="KS" <?php if($state_edit == 'KS') echo 'selected="selected"';?>>KS</option>
                <option value="KY" <?php if($state_edit == 'KY') echo 'selected="selected"';?>>KY</option>
                <option value="LA" <?php if($state_edit == 'LA') echo 'selected="selected"';?>>LA</option>
                <option value="ME" <?php if($state_edit == 'ME') echo 'selected="selected"';?>>ME</option>
                <option value="MD" <?php if($state_edit == 'MD') echo 'selected="selected"';?>>MD</option>

                <option value="MA" <?php if($state_edit == 'MA') echo 'selected="selected"';?>>MA</option>
                <option value="MI" <?php if($state_edit == 'MI') echo 'selected="selected"';?>>MI</option>
                <option value="MN" <?php if($state_edit == 'MN') echo 'selected="selected"';?>>MN</option>
                <option value="MS" <?php if($state_edit == 'MS') echo 'selected="selected"';?>>MS</option>
                <option value="MO" <?php if($state_edit == 'MO') echo 'selected="selected"';?>>MO</option>
                <option value="MT" <?php if($state_edit == 'MT') echo 'selected="selected"';?>>MT</option>
                <option value="NE" <?php if($state_edit == 'NE') echo 'selected="selected"';?>>NE</option>
                <option value="NV" <?php if($state_edit == 'NV') echo 'selected="selected"';?>>NV</option>
                <option value="NH" <?php if($state_edit == 'NH') echo 'selected="selected"';?>>NH</option>
                <option value="NJ" <?php if($state_edit == 'NJ') echo 'selected="selected"';?>>NJ</option>

                <option value="NM" <?php if($state_edit == 'NM') echo 'selected="selected"';?>>NM</option>
                <option value="NY" <?php if($state_edit == 'NY') echo 'selected="selected"';?>>NY</option>
                <option value="NC" <?php if($state_edit == 'NC') echo 'selected="selected"';?>>NC</option>
                <option value="ND" <?php if($state_edit == 'ND') echo 'selected="selected"';?>>ND</option>
                <option value="OH" <?php if($state_edit == 'OH') echo 'selected="selected"';?>>OH</option>
                <option value="OK" <?php if($state_edit == 'OK') echo 'selected="selected"';?>>OK</option>
                <option value="OR" <?php if($state_edit == 'OR') echo 'selected="selected"';?>>OR</option>
                <option value="PA" <?php if($state_edit == 'PA') echo 'selected="selected"';?>>PA</option>
                <option value="RI" <?php if($state_edit == 'RI') echo 'selected="selected"';?>>RI</option>
                <option value="SC" <?php if($state_edit == 'SC') echo 'selected="selected"';?>>SC</option>

                <option value="SD" <?php if($state_edit == 'SD') echo 'selected="selected"';?>>SD</option>
                <option value="TN" <?php if($state_edit == 'TN') echo 'selected="selected"';?>>TN</option>
                <option value="TX" <?php if($state_edit == 'TX') echo 'selected="selected"';?>>TX</option>
                <option value="UT" <?php if($state_edit == 'UT') echo 'selected="selected"';?>>UT</option>
                <option value="VT" <?php if($state_edit == 'VT') echo 'selected="selected"';?>>VT</option>
                <option value="VA" <?php if($state_edit == 'VA') echo 'selected="selected"';?>>VA</option>
                <option value="WA" <?php if($state_edit == 'WA') echo 'selected="selected"';?>>WA</option>
                <option value="WV" <?php if($state_edit == 'WV') echo 'selected="selected"';?>>WV</option>
                <option value="WI" <?php if($state_edit == 'WI') echo 'selected="selected"';?>>WI</option>
                <option value="WY" <?php if($state_edit == 'WY') echo 'selected="selected"';?>>WY</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Zipcode: </label>
              <p class="error"><?php echo $zipcodeErr;?></p>
              <input type="text" class="form-control" name="zipcode" value=<?php echo '"'.$zipcode_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">Landlord's First Name: </label>
              *<p class="error"><?php echo $landlord_fnameErr;?></p>
              <input type="text" class="form-control" name="landlord_fname" value=<?php echo '"'.$fname_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">Landlord's Last Name: </label>
              *<p class="error"><?php echo $landlord_lnameErr;?></p>
              <input type="text" class="form-control" name="landlord_lname" value=<?php echo '"'.$lname_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">Number of bedrooms: </label>
              <p class="error"><?php echo $bedroomsErr;?></p>
              <select class="form-control" name="bedrooms">
                <option selected="selected" value="select">How many bedrooms?</option>
                <option value="1" <?php if($bedroom_edit == '1') echo 'selected="selected"';?>>1</option>
                <option value="2" <?php if($bedroom_edit == '2') echo 'selected="selected"';?>>2</option>
                <option value="3" <?php if($bedroom_edit == '3') echo 'selected="selected"';?>>3</option>
                <option value="4" <?php if($bedroom_edit == '4') echo 'selected="selected"';?>>4</option>
                <option value="5" <?php if($bedroom_edit == '5') echo 'selected="selected"';?>>5</option>
                <option value="6" <?php if($bedroom_edit == '6') echo 'selected="selected"';?>>6</option>
                <option value="7" <?php if($bedroom_edit == '7') echo 'selected="selected"';?>>7</option>
                <option value="8" <?php if($bedroom_edit == '8') echo 'selected="selected"';?>>8</option>
                <option value="9" <?php if($bedroom_edit == '9') echo 'selected="selected"';?>>9</option>
                <option value="10" <?php if($bedroom_edit == '10') echo 'selected="selected"';?>>10</option>
                <option value="10+" <?php if($bedroom_edit == '10+') echo 'selected="selected"';?>>10+</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Number of bathrooms: </label>
              <p class="error"><?php echo $bathroomsErr;?></p>
              <select class="form-control" name="bathrooms">
                <option selected="selected" value="select">How many bathrooms?</option>
                 <option value="1" <?php if($bathroom_edit == '1') echo 'selected="selected"';?>>1</option>
                <option value="2" <?php if($bathroom_edit == '2') echo 'selected="selected"';?>>2</option>
                <option value="3" <?php if($bathroom_edit == '3') echo 'selected="selected"';?>>3</option>
                <option value="4" <?php if($bathroom_edit == '4') echo 'selected="selected"';?>>4</option>
                <option value="5" <?php if($bathroom_edit == '5') echo 'selected="selected"';?>>5</option>
                <option value="6" <?php if($bathroom_edit == '6') echo 'selected="selected"';?>>6</option>
                <option value="7" <?php if($bathroom_edit == '7') echo 'selected="selected"';?>>7</option>
                <option value="8" <?php if($bathroom_edit == '8') echo 'selected="selected"';?>>8</option>
                <option value="9" <?php if($bathroom_edit == '9') echo 'selected="selected"';?>>9</option>
                <option value="10" <?php if($bathroom_edit == '10') echo 'selected="selected"';?>>10</option>
                <option value="10+" <?php if($bathroom_edit == '10+') echo 'selected="selected"';?>>10+</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Furnished: </label>
              <p></p>
              <select class="form-control" name="furnished">
                <option selected="selected" value="select">Is the house furnished?</option>
                <option value="Yes" <?php if($furnished_edit == 'Yes') echo 'selected="selected"';?>>Yes</option>
                <option value="No" <?php if($furnished_edit == 'No') echo 'selected="selected"';?>>No</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Driveway: </label>
              <p class="error"><?php echo $parkingErr;?></p>
              <select class="form-control" name="parking">
                <option selected="selected" value="select">Is there a driveway?</option>
                <option value="Yes" <?php if($parking_edit == 'Yes') echo 'selected="selected"';?>>Yes</option>
                <option value="No" <?php if($parking_edit == 'No') echo 'selected="selected"';?>>No</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Pets: </label>
              <p class="error"><?php echo $petsErr;?></p>
              <select class="form-control" name="pets">
                <option selected="selected" value="select">Are pets allowed?</option>
                <option value="Yes" <?php if($pets_edit == 'Yes') echo 'selected="selected"';?>>Yes</option>
                <option value="No" <?php if($pets_edit == 'No') echo 'selected="selected"';?>>No</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">Size (Square Feet): </label>
              <input type="text" class="form-control" name="size" value=<?php echo '"'.$size_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">Total Rent per Month: </label>
              <p class="error"><?php echo $rentErr;?></p>
              <input type="text" class="form-control" name="rent" value=<?php echo '"'.$price_edit.'"'?>>
            </div>

            <input type="hidden" name="id" value=<?php echo '"'.$id.'"'?>>

            <div class="input-group">
              <span><button id="House-add-button" class="btn btn-default" type="submit">Done</button>
            </div>
          </form>

        </div>
      </div>
    </div>

    <?php else :  ?>
    <!-- page content -->
    <div class="container-form">
      <div class="panel panel-default success_panel top_margin">
        <div class="panel-heading"><h2 class="panel-title">Uh oh!</h2></div>
        <div class="panel-body">
          <h2>Sorry!</h2>
          <h4>You need to be logged in to do this!</h4>

          <div class="success_buttons_row">
            <input type="submit" class="btn btn-default" value="Sign Up" onclick="window.location='http://www.uroost.org/signup.php';" />
            <input type="submit" class="btn btn-default" value="Sign In" onclick="window.location='http://www.uroost.org/login.php';" />
          </div>
        </div>
      </div>
    </div>


    <?php endif; ?>

     <!-- footer -->
    <footer class="super-container footer navbar-fixed-bottom">
      <div class="container">
        <div id="blurb">
          <h3>Roost?</h3>
        </div>
        <div id="contact">
          <ul class="list-unstyled">
            <li><h3>Contact</h3></li>
            <li>Phone: </li>
            <li>Email: </li>
            <li>Facebook: </li>
            <li>Twitter: </li>
          </ul>
        </div>
      </div>
    </footer>

    <!-- ============ javascript ============ -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/homepage.js"></script>
  </body>
</html>
