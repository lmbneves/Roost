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

    <!-- stylesheet for this site -->
    <link href="../css/base.css" type="text/css" rel="stylesheet">

    <!-- stylesheet for this page -->
    <link href="../css/new.css" type="text/css" rel="stylesheet">

    <!-- ============= favicons ============= -->

    <!-- =============== fonts =============== -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100,500' rel='stylesheet' type='text/css'>

  </head>

  <body>

    <!-- top navbar -->
    <div class="super-container navbar" role="navigation">
        <ul id="nav">
          <li><a href="index.html">Roost</a></li>
          <li><a href="">Home</a></li>
          <li><a href="">Browse</a></li>
        </ul>
        <ul id="register">
          <li><a href="">Sign in</a></li>
          <li>|</li>
          <li><a href="">Sign up</a></li>
        </ul>
    </div>

    <!-- page content -->
    <div class="container">
      <div class="panel panel-default">
        <div class="panel-heading"><h2 class="panel-title">Add New Landlord</h2></div>
        <div class="panel-body">

          <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" role="form">
            <div class="form-group">
              <label class="control-label">First Name: </label>
              <input type="text" class="form-control" name="firstname">
            </div>
            <div class="form-group">
              <label class="control-label">Last Name: </label>
              <input type="text" class="form-control" name="lastname">
            </div>
            <div class="form-group">
              <label class="control-label">Phone Number: </label>
              <input type="text" class="form-control" name="phone">
            </div>
            <div class="form-group">
              <label class="control-label">Email: </label>
              <input type="text" class="form-control" name="email">
            </div>

            <!-- Eventually change this to drop down menus based on state/city -->
            <div class="form-group">
              <label class="control-label">State: </label>
              <input type="text" class="form-control" name="state">
            </div>
            <div class="form-group">
              <label class="control-label">City: </label>
              <input type="text" class="form-control" name="city">
            </div>
            <div class="form-group">
              <label class="control-label">Zip Code: </label>
              <input type="text" class="form-control" name="zipcode">
            </div>         
            <div class="form-group">
              <label class="control-label">Known Properties: </label>
              <input type="text" class="form-control" name="known_properties">
            </div>


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
                  $_POST['state'], $_POST['city'], $_POST['zipcode'], $_POST['known_properties']);
    }

    function checkZip($zip){
      if($zip > 0 && strlen($zip) == 5){
        return TRUE;
      }
    }

    function checkEmail($email){
      return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
    }

      //Checks if all the variables are set
      if(checkSet() != FALSE){

        //Ensuring that all forms are filled out correctly

        if(empty($_POST['firstname']) == FALSE && typeCheck($_POST['firstname'], 'string') != FALSE){
          $firstname = $_POST['firstname'];
        }
        else{
          echo 'First Name is not set!';
          exit();
        }

        if(empty($_POST['lastname']) == FALSE && typeCheck($_POST['lastname'], 'string') != FALSE){
          $lastname = $_POST['lastname'];
        }
        else{
          echo 'Last Name is not set!';
          exit();
        }

        if(empty($_POST['phone']) == FALSE && typeCheck($_POST['phone'], 'string') != FALSE){
          $phone = $_POST['phone'];
        }
        else{
          echo 'Phone Number is not set!';
          exit();
        }

        if(empty($_POST['email']) == FALSE && typeCheck($_POST['email'], 'string') != FALSE && checkEmail($_POST['email']) != FALSE){
          $email = $_POST['email'];
        }
        else{
          echo 'Invalid Email Address Supplied';
          exit();
        }

        if(empty($_POST['state']) == FALSE && typeCheck($_POST['state'], 'string') != FALSE){
          $state = $_POST['state'];
        }
        else{
          echo 'State is not set!';
          exit();
        }

        if(empty($_POST['city']) == FALSE && typeCheck($_POST['city'], 'string') != FALSE){
          $city = $_POST['city'];
        }
        else{
          echo 'City is not set!';
          exit();
        }

        if(empty($_POST['zipcode']) == FALSE && typeCheck($_POST['zipcode'], 'numeric') != FALSE && 
          checkZip($_POST['zipcode']) != FALSE){
          $zipcode = $_POST['zipcode'];
        }
        else{
          echo 'Invalid Zipcode Supplied';
          exit();
        }

        $id = uniqid(rand(), true); 

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
          echo 'New Landlord added to the database!';
        }
        
      }

    ?>

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
