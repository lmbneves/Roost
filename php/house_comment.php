<?php
  //Connect to mysql server
  $connect = mysqli_connect('localhost', 'urooxldw_lneves', 'houses77')
  or die(mysql_error()); 


  //Select which database we should use
  $db = mysqli_select_db($connect, 'urooxldw_roost')
  or die(mysql_error());

  $message = $_POST['message'];
  $timestamp = "timestamp";
  $member_id = "member_id";
  $house_id = $_GET['id'];
  $house_comment_id = uniqid(rand(), true);

   $query = sprintf("INSERT INTO house_comment (message, timestamp, member_id, house_id, house_comment_id)
                              VALUES('%s','%s','%s','%s','%s')",
                              mysqli_real_escape_string($connect, $message),
                              mysqli_real_escape_string($connect, $timestamp),
                              mysqli_real_escape_string($connect, $member_id),
                              mysqli_real_escape_string($connect, $house_id),
                              mysqli_real_escape_string($connect, $house_comment_id));

            //Run the query
            if(!mysqli_query($connect, $query)){
              echo 'Query failed '.mysql_error();
              exit();
            }
            else{
              echo "swag";
            }

    mysqli_close($connect);
?>
