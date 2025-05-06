<?php
 include("main.php");
 
 
 $user_data = check_login($con); // Get user data using the check_login function
 $user_name = $user_data['user_name']; // get the name
 ?>
 
 
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <title>Student Dashboard | HireRank</title>
   <link rel="stylesheet" href="dashboard.css">
 </head>
 <body>
 
   <header>
     <h1>HireRank Dashboard</h1>
     <nav>
       <a href="#">Leaderboard</a>
       <a href="exam.php">Tests</a>
       <a href="#">Profile</a>
       <a href="logout.php">Logout</a>
     </nav>
   </header>
 
   <main class="container">
     <section class="card">
       <h2>Welcome,<?php
 if (isset($user_name)) {
     echo htmlspecialchars($user_name);
 } else {
     echo 'User name not found';
 }
 ?>
 
 
  👋</h2>
       <p>Your current rank: <strong>#12</strong></p>
       <p>Skills: Full Stack, React, Node.js</p>
     </section>
 
     <section class="card">
       <h2>Available Tests</h2>
       <div class="test-item">
         <span>Full Stack Challenge - April</span>
         <a href="#" class="button" style="margin-left: 1rem;">Take Test</a>
       </div>
       <div class="test-item">
         <span>DSA</span>
         <a href="exam2.php" class="button" style="margin-left: 1rem;">Take Test</a>
       </div>
     </section>
 
     <section class="card">
       <h2>Leaderboard Overview</h2>
       <p>See where you stand among 14,000+ students.</p>
       <a href="#" class="button">View Leaderboard</a>
     </section>
   </main>
 
   <footer>
     © 2025 HireRank. All rights reserved.
   </footer>
 
   <script src="script.js"></script>
 </body>
 </html>