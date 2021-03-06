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
    <link href="../css/forms.css" type="text/css" rel="stylesheet">

    <!-- stylesheet for this site -->
    <link href="../css/base.css" type="text/css" rel="stylesheet">

    <!-- ============= favicons ============= -->
    <link rel="icon" href="../icons/logo.gif">

    <!-- =============== fonts =============== -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100,500' rel='stylesheet' type='text/css'>

  </head>

  <body>

    <!-- top navigation bar -->
    <div class="super-container navbar-wrapper">
      <nav class="container">
        <div class="navbar" role="navigation">
          <ul id="nav" class="list-inline list-unstyled">
            <li><a href="http://www.uroost.org"><img src="../icons/logo.gif"></a></li>
            <li><a href="http://www.uroost.org/browse_houses.php">Houses</a></li>
            <li><a href="http://www.uroost.org/browse_landlords.php">Landlords</a></li>
          </ul>
        </div>

         <div class="sign-in-up">

            <ul id="sign" class="list-inline list-unstyled">
            <?php if (login_check($mysqli) == true) : ?>
              <li><p><?php echo '<a href="http://www.uroost.org/user_profile.php?id='.$_SESSION['user_id'].'">'
                              .htmlentities($_SESSION['username']).'</a>'; ?></p></li>
              <li><a href="../includes/logout.php">Logout</a></li>
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

      else{
        return TRUE;
      }

    }

    function checkSet(){
      return isset($_POST['firstname'], $_POST['lastname'], $_POST['phone'], $_POST['email'], 
                  $_POST['state'], $_POST['city'], $_POST['zipcode']);
    }

    function checkZip($zip){
      if($zip > 0 && strlen($zip) == 5){
        return TRUE;
      }
      else return FALSE;
    }

    function checkEmail($email){
      return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
    }

      //Checks if all the variables are set
      if(checkSet() != FALSE && $_SERVER["REQUEST_METHOD"] == "POST"){

        //Ensuring that all forms are filled out correctly

        if(empty($_POST['firstname']) == FALSE && typeCheck($_POST['firstname'], 'string') != FALSE){
          $firstname = $_POST['firstname'];
          $firstname_complete = TRUE;
        }
        else{
          $firstnameErr = "Please enter the landlord's first name!";
          $firstname_complete = FALSE;
        }

        if(empty($_POST['lastname']) == FALSE && typeCheck($_POST['lastname'], 'string') != FALSE){
          $lastname = $_POST['lastname'];
          $lastname_complete = TRUE;
        }
        else{
          $lastnameErr = "Please enter the landlord's last name!";
          $lastname_complete = FALSE;
        }

        if(empty($_POST['phone']) == FALSE && typeCheck($_POST['phone'], 'string') != FALSE){
          $phone = $_POST['phone'];
          $phone_complete = TRUE;
        }
        else{
          $phoneErr = "Please enter the landlord's phone number!";
          $phone_complete = FALSE;
        }

        if(empty($_POST['email']) == FALSE && typeCheck($_POST['email'], 'string') != FALSE && checkEmail($_POST['email']) != FALSE){
          $email = $_POST['email'];
          $email_complete = TRUE;
        }
        else{
          $emailErr = "Please enter in the landlord's email!";
          $email_complete = FALSE;
        }

        if(empty($_POST['state']) == FALSE && typeCheck($_POST['state'], 'string') != FALSE){
          $state = $_POST['state'];
          $state_complete = TRUE;
        }
        else{
          $stateErr = "Please enter the state in which this landlord operates!";
          $state_complete = FALSE;
        }

        if(empty($_POST['city']) == FALSE && typeCheck($_POST['city'], 'string') != FALSE){
          $city = $_POST['city'];
          $city_complete = TRUE;
        }
        else{
          $cityErr = "Please enter the city in which this landlord operates!";
          $city_complete = FALSE;
        }

        if(empty($_POST['zipcode']) == FALSE && typeCheck($_POST['zipcode'], 'numeric') != FALSE && 
          checkZip($_POST['zipcode']) != FALSE){
          $zipcode = $_POST['zipcode'];
          $zipcode_complete = TRUE;
        }
        else{
          //$zipcodeErr = "Please enter in the zipcode in which this landlord operates!";
          $zipcode_complete = FALSE;
        }

        $id = uniqid(rand(), true);

        if($firstname_complete and $lastname_complete and $phone_complete and $email_complete and $state_complete and $city_complete){ 

          //Connect to mysql server
          $connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
          or die(mysql_error()); 


          //Select which database we should use
          $db = mysqli_select_db($connect, 'urooxldw_roost')
          or die(mysql_error());


          //Check if the landlord already exists
          $check_landlord_query = sprintf("SELECT * FROM landlord WHERE fname='%s' and lname='%s' and city='%s' and state='%s'",
                                          mysqli_real_escape_string($connect, $firstname),
                                          mysqli_real_escape_string($connect, $lastname),
                                          mysqli_real_escape_string($connect, $city),
                                          mysqli_real_escape_string($connect, $state));
          $check_landlord = mysqli_query($connect, $check_landlord_query);

          if(!$check_landlord){
            echo 'Query failed '.mysql_error();
          }

          //If the landlord does not exist in the database, go ahead and insert the landlord
          if(mysqli_num_rows($check_landlord) == 0){
            //Build query and check each variable with mysql_real_escape_string()
            $query = sprintf("INSERT INTO landlord (fname, lname, phone, email, state, city, zipcode, id)
                              VALUES('%s','%s','%s','%s','%s','%s','%s','%s')",
                              mysqli_real_escape_string($connect, $firstname),
                              mysqli_real_escape_string($connect, $lastname),
                              mysqli_real_escape_string($connect, $phone),
                              mysqli_real_escape_string($connect, $email),
                              mysqli_real_escape_string($connect, $state),
                              mysqli_real_escape_string($connect, $city),
                              mysqli_real_escape_string($connect, $zipcode),
                              mysqli_real_escape_string($connect, $id));

            //Run the query
            if(!mysqli_query($connect,$query)){
              echo 'Query failed '.mysql_error();
              exit();
            }
            else{
              echo "<script>window.location = 'http://www.uroost.org/landlords/landlord_success.php'</script>";
            }
          }

          //If the landlord exists already, redirect to landlord_exists.php (Error page)
          else{
            echo "<script>window.location = 'http://www.uroost.org/landlords/landlord_exists.php'</script>";
          }
        }
      }
      
      else{
        //echo "<script>window.location = 'http://www.uroost.org/landlords/landlord_success.php'</script>";
      }
      
    ?>

    <!-- page content -->
    <div class="container">
      <div class="panel panel-default top_margin">
        <div class="panel-heading"><h2 class="panel-title">Add New Landlord</h2></div>
        <div class="panel-body">

          <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" role="form">
            <div class="form-group">
              <p>Fields marked with * are required</p>
              <label class="control-label">First Name: </label>
              *<p class="error"><?php echo $firstnameErr;?></p>
              <input type="text" class="form-control" name="firstname">
            </div>
            <div class="form-group">
              <label class="control-label">Last Name: </label>
              *<p class="error"><?php echo $lastnameErr;?></p>
              <input type="text" class="form-control" name="lastname">
            </div>
            <div class="form-group">
              <label class="control-label">Phone Number: </label>
              *<p class="error"><?php echo $phoneErr;?></p>
              <input type="text" class="form-control" name="phone">
            </div>
            <div class="form-group">
              <label class="control-label">Email: </label>
              *<p class="error"><?php echo $emailErr;?></p>
              <input type="text" class="form-control" name="email">
            </div>
            <div class="form-group">
              <label class="control-label">State: </label>
              *<p class="error"><?php echo $stateErr;?></p>
              <select class="form-control" name="state">
                <option selected="selected" value="select">Select the state</option>
                <option value="AL">AL</option>
                <option value="AK">AK</option>
                <option value="AZ">AZ</option>
                <option value="AR">AR</option>
                <option value="CA">CA</option>
                <option value="CO">CO</option>
                <option value="CT">CT</option>
                <option value="DE">DE</option>
                <option value="FL">FL</option>
                <option value="GA">GA</option>

                <option value="HI">HI</option>
                <option value="ID">ID</option>
                <option value="IL">IL</option>
                <option value="IN">IN</option>
                <option value="IA">IA</option>
                <option value="KS">KS</option>
                <option value="KY">KY</option>
                <option value="LA">LA</option>
                <option value="ME">ME</option>
                <option value="MD">MD</option>

                <option value="MA">MA</option>
                <option value="MI">MI</option>
                <option value="MN">MN</option>
                <option value="MS">MS</option>
                <option value="MO">MO</option>
                <option value="MT">MT</option>
                <option value="NE">NE</option>
                <option value="NV">NV</option>
                <option value="NH">NH</option>
                <option value="NJ">NJ</option>

                <option value="NM">NM</option>
                <option value="NY">NY</option>
                <option value="NC">NC</option>
                <option value="ND">ND</option>
                <option value="OH">OH</option>
                <option value="OK">OK</option>
                <option value="OR">OR</option>
                <option value="PA">PA</option>
                <option value="RI">RI</option>
                <option value="SC">SC</option>

                <option value="SD">SD</option>
                <option value="TN">TN</option>
                <option value="TX">TX</option>
                <option value="UT">UT</option>
                <option value="VT">VT</option>
                <option value="VA">VA</option>
                <option value="WA">WA</option>
                <option value="WV">WV</option>
                <option value="WI">WI</option>
                <option value="WY">WY</option>
              </select>
            </div>
            <div class="form-group">
              <label class="control-label">City: </label>
              *<p class="error"><?php echo $cityErr;?></p>
              <input type="text" class="form-control" name="city">
            </div>
            <div class="form-group">
              <label class="control-label">Zip Code: </label>
              <input type="text" class="form-control" name="zipcode">
            </div>
            <div class="form-group">
              <label class="control-label">Company: </label>
              <input type="text" class="form-control" name="company">
            </div>
            <div class="form-group">
              <label class="control-label">Active Since: </label>
              <input type="text" class="form-control" name="active">
            </div>


            <!--         
            <div class="form-group">
              <label class="control-label">Known Properties: </label>
              <input type="text" class="form-control" name="known_properties">
            </div> -->


            <!-- Removing reviews for now until we figure out what we're doing about it -->

            <!--
            <div class="form-group">
              <label class="control-label">Review this Landlord: </label>
              <textarea class="form-control" name="review">Scribble your comments about this landlord
              </textarea>
            </div>
            <div class="form-group">
              <label class="control-label">Overall rating: </label>
              <select class="form-control" name="rating">
                <option>Stellar Landlord</option>
                <option selected="selected">Good Landlord</option>
                <option>Mediocre Landlord</option>
                <option>Bad Landlord</option>
                <option>Evil Landlord</option>
              </select>
            </div>
            -->

            <div class="input-group">
              <span><button id="landlord-add-button" class="btn btn-default" type="submit">Add</button></span>
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
