<?php
  include_once 'includes/signup.inc.php';
  include_once 'includes/functions.php';
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

    <!-- page content -->
    <div class="container">
      <div class="panel panel-default">
        <div class="panel-heading"><h2 class="panel-title">Sign Up</h2></div>
        <div class="panel-body">

        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>

          <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" role="form" name="registration_form">
            <div class="form-group">
              <label class="control-label">Name: </label>
              <input type="text" class="form-control" name="username">
            </div>
            <div class="form-group">
              <label class="control-label">Password: </label>
              <input type="password" class="form-control" name="password">
            </div>
            <div class="form-group">
              <label class="control-label">Confirm Password: </label>
              <input type="password" class="form-control" name="confirm_password">
            </div>
            <div class="form-group">
              <label class="control-label">Email: </label>
              <input type="text" class="form-control" name="email">
            </div>

            <div class="input-group">
              <input type="button" value="Sign Up" class="btn btn-default" onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirm_password);">
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
