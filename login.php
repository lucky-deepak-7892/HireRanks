<?php
 include("main.php");
 
 
 if ($_SERVER['REQUEST_METHOD'] == "POST") {
     $user_id = $_POST['user_id'];
     $password = $_POST['password'];
 
     if (!empty($user_id) && !empty($password)) {
         // Securely retrieve user data using prepared statement
         $query = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
         $stmt = mysqli_prepare($con, $query);
         mysqli_stmt_bind_param($stmt, "s", $user_id);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
 
         if ($result && mysqli_num_rows($result) > 0) {
             $user_data = mysqli_fetch_assoc($result);
 
             // Check if the password is correct
             if (password_verify($password, $user_data['password'])) {
                 $_SESSION['user_id'] = $user_data['user_id'];
                 header("Location: dashboard.php");
                 die;
             }
         }
         echo "Wrong Email or Password";
     } else {
         echo "Please enter valid login info";
     }
 }
 ?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Login - HireRank</title>
     <link rel="stylesheet" href="login.css">
 </head>
 <body>
     <div class="login-container">
         <h1>Login to <span>HireRank</span></h1>
         <form method="POST" action="">
             <label for="email">Email</label>
             <input type="email" id="email" name="user_id" placeholder="you@example.com" required />
 
             <label for="password">Password</label>
             <input type="password" id="password" name="password" placeholder="••••••••" required />
 
             <button type="submit">Login</button>
         </form>
         <p class="signup-link">Don't have an account? <a href="singin.php">Sign up</a></p>
     </div>
 </body>
 </html>