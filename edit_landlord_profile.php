<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include 'php/landlord_edit.php';
 
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

      else{
        return TRUE;
      }

    }

    function checkSet(){
      return isset($_POST['firstname'], $_POST['lastname'], $_POST['phone'], $_POST['email'], 
                  $_POST['state'], $_POST['city']);
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

        $company = $_POST['company'];
        $id = $_POST['id'];

        if($firstname_complete and $lastname_complete and $phone_complete and $email_complete and $state_complete and $city_complete){ 

          //Connect to mysql server
          $connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
          or die(mysql_error()); 


          //Select which database we should use
          $db = mysqli_select_db($connect, 'urooxldw_roost')
          or die(mysql_error());

          //Update Landlord information
          $query = sprintf("UPDATE landlord SET fname='%s', lname='%s', phone='%s', email='%s', state='%s', city='%s', zipcode='%s', company='%s' WHERE               id='%s'",
                          mysqli_real_escape_string($connect, $firstname),
                          mysqli_real_escape_string($connect, $lastname),
                          mysqli_real_escape_string($connect, $phone),
                          mysqli_real_escape_string($connect, $email),
                          mysqli_real_escape_string($connect, $state),
                          mysqli_real_escape_string($connect, $city),
                          mysqli_real_escape_string($connect, $zipcode),
                          mysqli_real_escape_string($connect, $company),
                          mysqli_real_escape_string($connect, $id));

          $update_landlord = mysqli_query($connect, $query);

          //Run the query
          if(!$update_landlord){
            echo 'Query failed '.mysql_error();
            exit();
          }

          else{
              echo '<script>window.location = "http://www.uroost.org/landlord_profile.php?id='.$id.'"</script>';
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
        <div class="panel-heading"><h2 class="panel-title">Edit Landlord</h2></div>
        <div class="panel-body">

          <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" role="form">
            <div class="form-group">
              <p>Fields marked with * are required</p>
              <label class="control-label">First Name: </label>
              *<p class="error"><?php echo $firstnameErr;?></p>
              <input type="text" class="form-control" name="firstname" value=<?php echo '"'.$fname_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">Last Name: </label>
              *<p class="error"><?php echo $lastnameErr;?></p>
              <input type="text" class="form-control" name="lastname" value=<?php echo '"'.$lname_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">Phone Number: </label>
              *<p class="error"><?php echo $phoneErr;?></p>
              <input type="text" class="form-control" name="phone" value=<?php echo '"'.$phone_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">Email: </label>
              *<p class="error"><?php echo $emailErr;?></p>
              <input type="text" class="form-control" name="email" value=<?php echo '"'.$email_edit.'"'?>>
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
              <label class="control-label">City: </label>
              *<p class="error"><?php echo $cityErr;?></p>
              <input type="text" class="form-control" name="city" value=<?php echo '"'.$city_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">Zip Code: </label>
              <input type="text" class="form-control" name="zipcode" value=<?php echo '"'.$zipcode_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">Company: </label>
              <input type="text" class="form-control" name="company" value=<?php echo '"'.$company_edit.'"'?>>
            </div>
            <div class="form-group">
              <label class="control-label">Active Since: </label>
              <input type="text" class="form-control" name="active-since" value=<?php echo '"'.$active_edit.'"'?>>
            </div>

            <input type="hidden" name="id" value=<?php echo '"'.$id.'"'?>>

            <div class="input-group">
              <span><button id="landlord-add-button" class="btn btn-default" type="submit">Done</button></span>
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
