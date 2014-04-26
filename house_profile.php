<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include 'php/house_profile_information.php';
 
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
    <link href="css/house-profile.css" type="text/css" rel="stylesheet">

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

    <!-- profile -->
    <section class="super-container profile-wrapper">
      <div class="container profile">
        <div class="house-title">
          <button class="edit-button" onclick=<?php echo ' "window.location=\'http://www.uroost.org/edit_house_profile.php?id='.$_GET['id'].'\'"' ?>>
            <i class="glyphicon glyphicon-pencil"> Edit</i>
          </button>
          <h2><?php echo $number.' '.ucfirst($name).' '.ucfirst($suffix); ?></h2>
          <h4><?php echo ucfirst($city).', '.strtoupper($state).' '.$zipcode; ?></h4>
        </div>
        <div class="profile-info">
          <div class="house-primary-img"><img src="images/house1.jpg"></div>
            <div class="house-reviews">
              <h3>Reviews: </h3>
              <div class="post">
                  <!-- post will be placed here from db -->
              </div>
              <div class="comment-block">
                <!-- comment will be apped here from db-->
              </div>
              <!-- comment form -->
              <form id="form" method="post" action="php/house_comment.php">
                <div class="form-group">
                  <label class="control-label required">Your message: </label>
                  <textarea name="message" id="message" class="form-control" cols="30" rows="10" placeholder="Type your comment here...." required></textarea>                
                </div>
                <input type="submit" id="submit" value="Submit Comment">
              </form>
            </div>
        </div><!-- profile info -->
        <div class="house-info">
          <?php echo 'Landlord: <a href="http://www.uroost.org/landlord_profile.php?id='.$row['landlord_id'].'"><strong>'.$landlord_fname.' '.$landlord_lname.'</strong></a></br>';
                echo 'No. of Bedrooms: <strong>'.$bedroom.'</strong></br>';
                echo 'No. of Bathrooms: <strong>'.$bathroom.'</strong></br>';
                echo 'Furnished: <strong>'.$furnished.'</strong></br>';
                echo 'Approx. Total Rent: <strong>$'.$price.'/month</strong></br>';
                echo 'Driveway: <strong>'.$parking.'</strong></br>';
                echo 'Pets Allowed: <strong>'.$pets.'</strong></br>';
                echo 'House Built: <strong>'.$age.'</strong></br>';
                echo 'Last Renovated: <strong>'.$renovation.'</strong></br>';
          ?>
        </div>
      </div>
    </section>

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
  </body>
</html>
