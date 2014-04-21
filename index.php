<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
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

    <!-- stylesheet for this page -->
    <link href="css/homepage.css" type="text/css" rel="stylesheet">

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
            <li><a href=""><img src="icons/logo.gif"></a></li>
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

    <!-- search bar section -->
    <section class="super-container search-area">
      <div class="search-bar container" role="search">
        <div class="panel">
          <div class="panel-body">
            <form id="main-search" class="navbar-form" role="search">
              <div class="form-group">
                <input id="main-search-bar" type="text" class="form-control" placeholder="Search">
              </div>
              <button id="main-search-submit" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- recent houses display -->
    <section class="super-container recent">
      <?php include "php/homepage.php"; ?>
      <div id="recent-title"><h2>New Houses:</h2></div>
      <div class="recent-content">
        <div id="house1" class="recent-house">
          <div class="map"></div>
          <div class="recent-house-info">
            <h3>237 Barton Street</h3>
          </div>
        </div>
        <div id="house2" class="recent-house">
          <div class="map"></div>
          <div class="recent-house-info">
            <h3>44 Congress Avenue</h3> 
          </div>
        </div>
        <div id="house3" class="recent-house">
          <div class="map"></div>
          <div class="recent-house-info">
            <h3>100 Custer Street</h3>
          </div>
        </div>
      </div>
      <div class="push"></div>
    </section>

    <!-- footer -->
    <footer class="footer navbar-fixed-bottom super-container">
      <div class="mini-container">
        <div id="blurb">
          <h3>Roost?</h3>
        </div>
        <div id="contact">
          <ul class="list-unstyled">
            <li><h3>Contact</h3></li>
            <li>Phone: </li>
            <li>Email: </li>
            <li>Facebook</li>
            <li>Twitter</li>
          </ul>
        </div>
      </div>
    </footer>

    <!-- ============ javascript ============ -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/homepage.js"></script>
  </body>
</html>
