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
    <link href="css/grid.css" type="text/css" rel="stylesheet">
    <link href="css/layout.css" type="text/css" rel="stylesheet">

    <!-- stylesheet for this site -->
    <link href="css/base.css" type="text/css" rel="stylesheet">

    <!-- stylesheet for this page -->
    <link href="css/new.css" type="text/css" rel="stylesheet">

    <!-- ============= favicons ============= -->
     <link rel="icon" href="images/icons/logo.gif">

    <!-- =============== fonts =============== -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300,100,500' rel='stylesheet' type='text/css'>

    <!-- =============== Javascript =============== -->
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script>

  </head>

  <body>

    <!-- top navbar -->
    <div class="super-container navbar" role="navigation">
      <a href="index.html"><img src="images/icons/logo.svg"></a>
        <ul id="nav">
          <li><a href="index.html">Home</a></li>
          <li><a href="BrowseSection.html">Browse</a></li>
        </ul>
        <ul id="register">
          <li><a href="login.html">Sign in</a></li>
          <li>|</li>
          <li><a href="signup.html">Sign up</a></li>
        </ul>
    </div>

    <!-- page content -->
    <div class="container">
      <div class="panel panel-default">
        <div class="panel-heading"><h2 class="panel-title">Login</h2></div>
        <div class="panel-body">
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?>

          <form action="includes/process_login.php" method="post" role="form" name="login_form">
            <div class="form-group">
              <label class="control-label">Email: </label>
              <input type="text" class="form-control" name="email">
            </div>
            <div class="form-group">
              <label class="control-label">Password: </label>
              <input type="password" class="form-control" name="password">
            </div>

            <div class="input-group">
              <input type="button" value="Login" onclick="formhash(this.form, this.form.password);" />
            </div>  
          </form>
           <p>If you don't have a login, please <a href="register.php">register</a></p>
            <p>If you are done, please <a href="includes/logout.php">log out</a>.</p>
          <p>You are currently logged <?php echo $logged ?>.</p>
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
