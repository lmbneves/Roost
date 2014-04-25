<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
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
     <link rel="icon" href="images/icons/logo.gif">

    <!-- =============== fonts =============== -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100,500' rel='stylesheet' type='text/css'>

    <!-- =============== Javascript =============== -->
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script>

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

    <!-- page content -->
    <div class="container-form">
      <div class="panel panel-default top_margin">
        <div class="panel-heading"><h2 class="panel-title">Login</h2></div>
        <div class="panel-body">
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Incorrect Username/Password!</p>';
        }
        ?>
        <?php echo $loginErr?>

          <form action="includes/process_login.php" method="post" name="login_form">
            <div class="form-group">
              <label class="control-label">Email: </label>
              <input type="text" class="form-control" name="email">
            </div>
            <div class="form-group">
              <label class="control-label">Password: </label>
              <input type="password" class="form-control" name="password">                      
            </div>
            <input type="button" class="btn btn-default" 
                     value="Login" 
                     onclick="formhash(this.form, this.form.password);" /> 
          </form>
          <p class="no-account">Don't have an account? <a href="signup.php">Register Now</a></p>
        </div>
      </div>
    </div>

    <!-- footer -->
    <footer class="super-container footer navbar-fixed-bottom fixed">
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
