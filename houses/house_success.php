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
            <li><a href="../signup.php">Sign Up</a></li>
            <li> <a href="../login.php">Sign In</a></li>
           <?php endif; ?>  
          </ul>
        </div>
      </nav>
    </div><!-- top navigation bar, super-container -->

    <!-- page content -->
    <div class="container">
      <div class="panel panel-default success_panel top_margin">
        <div class="panel-heading"><h2 class="panel-title">Added New House!</h2></div>
        <div class="panel-body">
          <h2>Congratulations!</h2>
          <h4>You have successfully added a new house!</h4>

          <div class="success_buttons_row">
            <input type="submit" class="btn btn-default" value="Return Home" onclick="window.location='http://www.uroost.org/index.php';" />
            <input type="submit" class="btn btn-default" value="Add Another House" onclick="window.location='http://www.uroost.org/houses/new-house.php';" />
          </div>
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
