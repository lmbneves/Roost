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

    <!-- page content -->
    <div class="container-form">
      <div class="panel panel-default success_panel top_margin">
        <div class="panel-heading"><h2 class="panel-title">Uh Oh!</h2></div>
        <div class="panel-body">
          <h2>Sorry!</h2>
          <h4>It looks like someone else has already added this house!</h4>

          <div class="success_buttons_row">
            <input type="submit" class="btn btn-default" value="Return Home" onclick="window.location='http://www.uroost.org/index.php';" />
            <input type="submit" class="btn btn-default" value="Add Another House" onclick="window.location='http://www.uroost.org/houses/new-house.php';" />
          </div>
        </div>
      </div>
    </div>

     <!-- footer -->
    <footer class="super-container footer navbar-fixed-bottom fixed">
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
