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
        <div class="panel-heading"><h2 class="panel-title">Sign Up</h2></div>
        <div class="panel-body">

        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>

          <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" role="form" name="registration_form">
            <div class="form-group">
              <label class="control-label">Username: </label>
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
              <input type="button" class="btn btn-default" onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);">Sign Up</button>
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