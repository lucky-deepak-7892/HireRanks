<?php
 
 
 include("main.php");
 
 if ($_SERVER['REQUEST_METHOD'] == "POST") {
     $user_name = $_POST['user_name'];
     $user_id = $_POST['user_id'];
     $password = $_POST['password'];
     $confirmPassword = $_POST['confirmPassword'];
 
     // Check if passwords match
     if ($password !== $confirmPassword) {
         echo "Passwords do not match!";
         die;
     }
 
     // Hash the password
     $hashed_password = password_hash($password, PASSWORD_DEFAULT);
 
     // Check if the email already exists
     $check_query = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
     $stmt = mysqli_prepare($con, $check_query);
     mysqli_stmt_bind_param($stmt, "s", $user_id);
     mysqli_stmt_execute($stmt);
     $check_result = mysqli_stmt_get_result($stmt);
 
     if (mysqli_num_rows($check_result) > 0) {
         echo "Email already exists. Please login or use another email.";
         die;
     } 
 
     // Insert user data securely
     if (!empty($user_name) && !empty($user_id) && !empty($hashed_password) && !is_numeric($user_name)) {
         $query = "INSERT INTO users (user_id, user_name, password) VALUES (?, ?, ?)";
         $stmt = mysqli_prepare($con, $query);
         mysqli_stmt_bind_param($stmt, "sss", $user_id, $user_name, $hashed_password);
         mysqli_stmt_execute($stmt);
 
 // storing user id in  seesion 
         $_SESSION['user_id'] = $user_id;
 
         // Redirect to login page after successful signup
         header("Location: login.php");
         die;
     } else {
         echo "Please enter valid information!";
     }
 }
 ?>
 
 
 
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Signup - HireRank</title>
     <link rel="stylesheet" href="singin.css">
 </head>
 <body>
     <div class="signup-container">
         <h1>Create your <span>HireRank</span> account</h1>
         <form method="POST" action="">
             <label for="name">Full Name</label>
             <input type="text" id="name" name="user_name" placeholder="John Doe" required />
 
             <label for="email">Email</label>
             <input type="email" name="user_id" id="email" placeholder="you@example.com" required />
 
             <label for="password">Password</label>
             <input type="password" id="password" name="password" placeholder="Create a password" required />
 
             <label for="confirmPassword">Confirm Password</label>
             <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter password" required />
 
             <button type="submit">Sign Up</button>
         </form>
         <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
     </div>
 </body>
 </html>