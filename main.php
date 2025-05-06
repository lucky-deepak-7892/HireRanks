<?php
 session_start();
 
 //  creating database connection
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $dbname = "hirerank_loginsystem";
 
 if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
     die("Failed to connect!");
 }
 
 // Login check function
 function check_login($con)
 {
     if (isset($_SESSION['user_id'])) {
         $id = $_SESSION['user_id'];
 
         // securely reciving user data using prepared statement 
         $query = "SELECT * FROM users WHERE user_id ='$id' LIMIT 1";
 
         $result = mysqli_query($con, $query);
         if ($result && mysqli_num_rows($result) > 0)
          {
             $user_data = mysqli_fetch_assoc($result);
             return $user_data;
         }
     }
     // Redirecting if not logged in
     header("Location: login.php");
     die;
 }
 ?>