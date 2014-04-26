<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
//include 'php/user_information.php';
 
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

    <title>Roost | Homepage</title>

    <!-- ========== CSS stylesheets ========== -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link href="css/base.css" type="text/css" rel="stylesheet">
    <link href="css/forms.css" type="text/css" rel="stylesheet">

    <!-- stylesheet for this page -->
    <link href="css/homepage.css" type="text/css" rel="stylesheet">
    <link href="css/landlord_profile.css" type="text/css" rel="stylesheet">


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
            <li><a href="index.php"><img src="icons/logo.gif"></a></li>
            <li><a href="browse_houses.php">Houses</a></li>
            <li><a href="browse_landlords.php">Landlords</a></li>
          </ul>
        </div>
        <!-- Don't remove this! -->
        <!--
        <div class="sign-in-up">

          <ul id="sign" class="list-inline list-unstyled">
          <?php if (login_check($mysqli) == true) : ?>
            
             
            <?php include 'php/user_information.php' ?>

            <li><p>Welcome  <?php echo htmlentities($_SESSION['username']);?>!</p></li>
            <li><a href="includes/logout.php">Logout</a></li>
          <?php else : ?>
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="login.php">Sign In</a></li>
           <?php endif; ?>  
          </ul>
        </div>
        -->
         <div class="sign-in-up">

            <ul id="sign" class="list-inline list-unstyled">
            <?php if (login_check($mysqli) == true) : ?>
              <li><p><?php echo '<a href="http://www.uroost.org/user_profile.php?id='.$_SESSION['user_id'].'">'
                              .htmlentities($_SESSION['username']).'</a>'; ?></p></li>
              <li><a href="includes/logout.php">Logout</a></li>
            <?php else : ?>
              <li><a href="signup.php">Sign Up</a></li>
              <li> <a href="login.php">Sign In</a></li>
             <?php endif; ?>  
            </ul>
          </div>
      </nav>
    </div><!-- top navigation bar, super-container -->

  <?php if (login_check($mysqli) == true) : ?>

   <!-- page content -->
    <div class="container">
      <div class="panel panel-default top_margin">
        <div class="panel-body">
          <div class="landlord_primary">
            <img src="images/noprofile.gif" alt="profile_pic"/>
              <div class="landlord_primary_text">
                <ul class="list-unstyled">
                  <li><h1><?php echo $username ?></h1></li>
                  <li><h3>Email: </h3><p><?php echo $email?></p></li>
                </ul>
              </div>
          </div>
        </div>
      </div> 
    </div>

  <?php else :  ?>
    <!-- page content -->
    <div class="container">
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
          <h3>What is Roost?</h3>
          <p>Roost is a house listing and rating service for students looking to live off-campus. Here, students can search for houses, get to know landlords, and share their off-campus housing experiences with other students.</p>
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
