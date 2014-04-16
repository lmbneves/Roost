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

    <?php
	
		//Connect to mysql server
		$connect = mysql_connect('localhost', 'urooxldw_lneves', 'houses77')
		or die('Cannot connect to MySQL server');	


		//Select which database we should use
		$db = mysql_select_db('urooxldw_roost')
		or die(mysql_error());

		//Escape variables for security
		$firstname = mysql_real_escape_string($_POST['firstname']);
		$lastname = mysql_real_escape_string($_POST['lastname']);
		$known_properties = mysql_real_escape_string($_POST['known_properties']);
		$phone = mysql_real_escape_string($_POST['phone']);
		$email = mysql_real_escape_string($_POST['email']);
		$state = mysql_real_escape_string($_POST['state']);
		$city = mysql_real_escape_string($_POST['city']);
		$zipcode = mysql_real_escape_string($_POST['zipcode']);
		$review = mysql_real_escape_string($_POST['review']);
		$rating = mysql_real_escape_string($_POST['rating']);
		$id = uniqid(rand(), true);

		$sql = "INSERT INTO landlord (fname, lname, properties, phone, email, state, city, zipcode, id)
				VALUES ('$firstname', '$lastname', '$known_properties', '$phone', '$email', '$state', '$city', '$zipcode', '$id')";

		if(!mysql_query($sql, $connect)){
			die('Error: ' . mysql_error($connect));
		}

		echo "Added New Landlord!";

		mysql_close($connect);
	?>


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