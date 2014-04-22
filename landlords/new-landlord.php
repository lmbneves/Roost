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
          $zipcodeErr = "Please enter in the zipcode in which this landlord operates!";
          $zipcode_complete = FALSE;
        }

        $id = uniqid(rand(), true);

        if($firstname_complete and $lastname_complete and $phone_complete and $email_complete and $state_complete and $city_complete and $zipcode_complete){ 

          //Connect to mysql server
          $connect = mysql_connect('localhost', 'urooxldw_lneves', 'houses77')
          or die(mysql_error()); 


          //Select which database we should use
          $db = mysql_select_db('urooxldw_roost')
          or die(mysql_error());

          //Build query and check each variable with mysql_real_escape_string()
          $query = sprintf("INSERT INTO landlord (fname, lname, phone, email, state, city, zipcode, id)
                            VALUES('%s','%s','%s','%s','%s','%s','%s','%s')",
                            mysql_real_escape_string($firstname),
                            mysql_real_escape_string($lastname),
                            mysql_real_escape_string($phone),
                            mysql_real_escape_string($email),
                            mysql_real_escape_string($state),
                            mysql_real_escape_string($city),
                            mysql_real_escape_string($zipcode),
                            mysql_real_escape_string($id));

          //Run the query
          if(!mysql_query($query)){
            echo 'Query failed '.mysql_error();
            exit();
          }
          else{
            echo "<script>window.location = 'http://www.uroost.org/landlords/landlord_success.php'</script>";
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
              <label class="control-label">First Name: </label>
              <span class="has-error"><?php echo $firstnameErr;?>
              <input type="text" class="form-control" name="firstname">
            </div>
            <div class="form-group">
              <label class="control-label">Last Name: </label>
              <span class="has-error"><?php echo $lastnameErr;?>
              <input type="text" class="form-control" name="lastname">
            </div>
            <div class="form-group">
              <label class="control-label">Phone Number: </label>
              <span class="has-error"><?php echo $phoneErr;?>
              <input type="text" class="form-control" name="phone">
            </div>
            <div class="form-group">
              <label class="control-label">Email: </label>
              <span class="has-error"><?php echo $emailErr;?>
              <input type="text" class="form-control" name="email">
            </div>

            <!-- Eventually change this to drop down menus based on state/city -->
            <div class="form-group">
              <label class="control-label">State: </label>
              <span class="has-error"><?php echo $stateErr;?>
              <input type="text" class="form-control" name="state">
            </div>
            <div class="form-group">
              <label class="control-label">City: </label>
              <span class="has-error"><?php echo $cityErr;?>
              <input type="text" class="form-control" name="city">
            </div>
            <div class="form-group">
              <label class="control-label">Zip Code: </label>
              <span class="has-error"><?php echo $zipcodeErr;?>
              <input type="text" class="form-control" name="zipcode">
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
