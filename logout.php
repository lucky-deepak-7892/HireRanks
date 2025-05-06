<?php
 session_start();
 session_unset();    // removes all session variables
 session_destroy();  // ends the session
 header("Location: index.php"); // redirect to login
 exit();
 ?>