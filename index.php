<?php
 $host = 'localhost';
 $user = 'root';
 $pass = '';
 $dbname = 'hirerank_result';
 
 $conn = new mysqli($host, $user, $pass, $dbname);
 
 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
 ?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <title>HireRank Landing Page</title>
   <link rel="stylesheet" href="style.css"/>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
   <script src="script.js"></script>
 
 </head>
 <body>
   <header>
     <h1>HireRank</h1>
     <div class="menu">
       <a href="#features">Features</a>
       <a href="#testimonials">Testimonials</a>
       <a href="#leaderboard">Leaderboard</a>
       <a href="login.php">Join</a>
     </div>
   </header>
   <section id="tests">
     <h2>Available Tests</h2>
     <div class="test-cards">
       <div class="test-card">
         <h3>Full Stack Development</h3>
         <p>Assess your full stack skills across frontend, backend, and database.</p>
         <button> <a href="exam.php" style="color: black; "> Take Test</a></button>
       </div>
       <div class="test-card">
         <h3>Data Science</h3>
         <p>Test your skills in Python, ML, and data analysis.</p>
         <button><a href="exam.php" style="color: black;">Take Test</a></button>
       </div>
       <div class="test-card">
         <h3>Frontend Development</h3>
         <p>HTML, CSS, JS and modern frontend frameworks challenge.</p>
         <button ><a href="exam.php" style="color: black;">Take Test</a></button>
       </div>
     </div>
   </section>
   
 
   <section id="hero">
     <h1>Skill. Rank. Get Hired.</h1>
     <p>
       The ultimate bridge between top talent and companies. Showcase your skills,
       rise through ranks, and unlock career-defining opportunities.
     </p>
     <div class="cta-buttons">
       <button id="studentBtn">Join as Student</button>
      
     </div>
     <div class="arrow-icon">
       <span>&#8595;</span>
     </div>
   </section>
 
   <section id="leaderboard">
     <h2>Live Leaderboard</h2>
     <select id="skillFilter">
       <option value="All">All Skills</option>
       <option value="Full Stack">Full Stack</option>
       <option value="Data Science">Data Science</option>
       <option value="Frontend">Frontend</option>
       <option value="Backend">Backend</option>
     </select>
 
     <div class="leaderboard-table">
       <table>
         <thead>
           <tr>
             <th>Rank</th>
             <th>Student Name</th>
             <th>Skill</th>
             <th>Score</th>
            
           </tr>
         </thead>
         <section id="leaderboard">
     <h2>Live Leaderboard</h2>
 
   
   <!-- php code for feachimnmg data from the apptitude_test -->
 
 
 
 
   <?php
 $sql = "SELECT at.*
 FROM apptitude_test at
 JOIN (
     SELECT user_id, MAX(score) AS highest_score
     FROM apptitude_test
     GROUP BY user_id
 ) max_scores
 ON at.user_id = max_scores.user_id AND at.score = max_scores.highest_score";
 
 
 $result = $conn->query($sql);
 
 if ($result->num_rows > 0) {
     echo "<table border='1'>
             <tr>
                 <th>Score</th>
                 <th>User ID</th>
                 
           
             </tr>";
     while($row = $result->fetch_assoc()) {
         echo "<tr>
 
                <td>" . $row["score"] . "</td>
                 <td>" . $row["user_id"] . "</td>
                
                 
               </tr>";
     }
     echo "</table>";
 } else {
     echo "No results found.";
 }
 
 ?>
 
 
 <!-- php code for DSA data is here -->
 <hr>
 <h3>DSA topper </h3>
 
 
 <?php
 $sql = "SELECT at.*
 FROM dsa_test at
 JOIN (
     SELECT user_id, MAX(score) AS highest_score
     FROM dsa_test
     GROUP BY user_id
 ) max_scores
 ON at.user_id = max_scores.user_id AND at.score = max_scores.highest_score";
 
 
 $result = $conn->query($sql);
 
 if ($result->num_rows > 0) {
     echo "<table border='1'>
             <tr>
                 <th>Score</th>
                 <th>User ID</th>
                 
           
             </tr>";
     while($row = $result->fetch_assoc()) {
         echo "<tr>
 
                <td>" . $row["score"] . "</td>
                 <td>" . $row["user_id"] . "</td>
                
                 
               </tr>";
     }
     echo "</table>";
 } else {
     echo "No results found.";
 }
 $conn->close();
 ?>
 
 
             </tbody>
         </table>
     </div>
 </section>
 
   <section id="cta">
     <h2>Join 14,000+ students & land your dream job today</h2>
     <p>Take the first step toward your tech career. Companies are hiring every day.</p>
     <button ><a href="login.php"> Get Started</a></button>
   </section>
 
   <script src="script.js"></script>
 </body>
 </html>