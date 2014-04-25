<?php
	echo '<nav class="container">';
    echo    '<div class="navbar" role="navigation">';
    echo      '<ul id="nav" class="list-inline list-unstyled">';
    echo        '<li><a href=""><img src="icons/logo.gif"></a></li>';
    echo        '<li><a href="browse_houses.php">Houses</a></li>';
    echo        '<li><a href="browse_landlords.php">Landlords</a></li>';
    echo      '</ul>';
    echo    '</div>';

    echo    '<div class="sign-in-up">';
    echo      '<ul id="sign" class="list-inline list-unstyled">';
    echo      '<?php if (login_check($mysqli) == true) : ?>';
    echo        '<li><p>Welcome  <?php echo htmlentities($_SESSION['username']);?>!</p></li>';
    echo        '<li><a href="includes/logout.php">Logout</a></li>';
    echo      '<?php else : ?>';
    echo        '<li><a href="signup.php">Sign Up</a></li>';
    echo        '<li> <a href="login.php">Sign In</a></li>';
    echo       '<?php endif; ?> '; 
    echo      '</ul>';
    echo    '</div>';
    echo  '</nav>';
?>
