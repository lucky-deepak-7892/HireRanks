<?php
 session_start();
 include("main.php");
 
 // Check if user is logged in
 if (!isset($_SESSION['user_id'])) {
     header("Location: login.php");
     exit();
 }
 
 // error checking
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
 
 // Database configuration
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $dbname = "hirerank_result";
 
 // Create database connection
 $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
 if (!$con) {
     die("Database connection failed: " . mysqli_connect_error());
 }
 
 // Define all quiz questions with answers
 $questions = [
     [
         'question' => "A snail is at the bottom of a 20-foot well. Each day, it climbs up 3 feet, but at night, it slips back 2 feet. How many days will it take for the snail to reach the top of the well?",
         'options' => ["18 days", "20 days", "22 days", "28 days"],
         'answer' => "20 days"
     ],
     [
         'question' => "A bat and a ball together cost $1.10. The bat costs $1.00 more than the ball. How much does the ball cost?",
         'options' => ["$0.05", "$0.10", "$0.15", "$0.20"],
         'answer' => "$0.05"
     ],
     [
         'question' => "If Sally's father is John's son, what is the relationship between Sally and John?",
         'options' => ["Mother", "Daughter", "Sister", "Granddaughter"],
         'answer' => "Daughter"
     ],
     [
         'question' => "A bakery sells 250 loaves of bread per day. If each loaf costs $2, how much money does the bakery make in a day?",
         'options' => ["$400", "$450", "$500", "$550"],
         'answer' => "$500"
     ],
     [
         'question' => "If it takes 5 machines 5 minutes to make 5 widgets, how long would it take 100 machines to make 100 widgets?",
         'options' => ["5 minutes", "10 minutes", "50 minutes", "100 minutes"],
         'answer' => "5 minutes"
     ],
     [
         'question' => "A car travels from city A to city B at an average speed of 60 km/h. If the distance between the two cities is 240 km, how long does the trip take?",
         'options' => ["2 hours", "4 hours", "6 hours", "8 hours"],
         'answer' => "4 hours"
     ],
     [
         'question' => "If a bakery sells 150 cakes per day, and each cake costs $3, how much money does the bakery make in a day?",
         'options' => ["$300", "$350", "$400", "$450"],
         'answer' => "$450"
     ],
     [
         'question' => "A person has $1000 in a savings account that earns 5% interest per year. How much interest will they earn in a year?",
         'options' => ["$40", "$50", "$60", "$70"],
         'answer' => "$50"
     ],
     [
         'question' => "If a person can paint a room in 4 hours, and another person can paint the same room in 6 hours, how long will it take them to paint the room together?",
         'options' => ["2 hours", "2.4 hours", "3 hours", "4 hours"],
         'answer' => "2.4 hours"
     ],
     [
         'question' => "A book costs $15. If a 10% discount is applied, how much will the book cost after the discount?",
         'options' => ["$13.50", "$14.00", "$14.50", "$15.00"],
         'answer' => "$13.50"
     ]
 ];
 
 // Process quiz submission
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $correct = 0; // Initialize score counter
     
     // Calculate score
     foreach ($_POST as $key => $value) {
         if (strpos($key, 'q') === 0) { // If it's a question field
             $qIndex = substr($key, 1);
             if (isset($questions[$qIndex]) && $value === $questions[$qIndex]['answer']) {
                 $correct++; // Increment for each correct answer
             }
         }
     }
 
     // Option 1: If your table has auto-increment ID (recommended)
     $query = "INSERT INTO apptitude_test (score, user_id, time) VALUES (?, ?, NOW())";
     $stmt = mysqli_prepare($con, $query);
     
     if ($stmt) {
         mysqli_stmt_bind_param($stmt, "is", $correct, $_SESSION['user_id']);
         
         if (mysqli_stmt_execute($stmt)) {
             header("Location: " . $_SERVER['PHP_SELF'] . "?result=" . $correct);
             exit();
         } else {
             // Enhanced error reporting
             $error = "Failed to save results. Please try again.";
             error_log("Database error: " . mysqli_stmt_error($stmt));
         }
         mysqli_stmt_close($stmt);
     } else {
         $error = "System error. Please try again later.";
         error_log("Prepare error: " . mysqli_error($con));
     }
 }
 ?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Aptitude Quiz</title>
     <style>
         body {
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
             line-height: 1.6;
             color: #333;
             max-width: 800px;
             margin: 0 auto;
             padding: 20px;
             background-color: #f5f5f5;
         }
         h1 {
             color: #2c3e50;
             text-align: center;
             margin-bottom: 30px;
         }
         .question {
             background-color: white;
             border-radius: 8px;
             padding: 20px;
             margin-bottom: 20px;
             box-shadow: 0 2px 4px rgba(0,0,0,0.1);
         }
         .question h3 {
             margin-top: 0;
             color: #3498db;
         }
         label {
             display: block;
             padding: 8px 0;
             cursor: pointer;
         }
         label:hover {
             background-color: #f0f8ff;
         }
         input[type="radio"] {
             margin-right: 10px;
         }
         button {
             background-color: #3498db;
             color: white;
             border: none;
             padding: 12px 24px;
             font-size: 16px;
             border-radius: 4px;
             cursor: pointer;
             display: block;
             margin: 30px auto;
             transition: background-color 0.3s;
         }
         button:hover {
             background-color: #2980b9;
         }
         .result-message {
             text-align: center;
             padding: 15px;
             margin: 20px 0;
             border-radius: 4px;
             font-weight: bold;
         }
         .success {
             background-color: #d4edda;
             color: #155724;
             border: 1px solid #c3e6cb;
         }
         .error {
             background-color: #f8d7da;
             color: #721c24;
             border: 1px solid #f5c6cb;
         }
         .score-display {
             font-size: 24px;
             margin: 20px 0;
             text-align: center;
             color: #2c3e50;
         }
     </style>
 </head>
 <body>
     <h1>Aptitude Quiz</h1>
     
     <?php if (isset($_GET['result'])): ?>
         <div class="result-message success">
             Your quiz has been submitted successfully!
         </div>
         <div class="score-display">
             You scored <?php echo htmlspecialchars($_GET['result']); ?> out of <?php echo count($questions); ?>
         </div>
     <?php endif; ?>
     
     <?php if (isset($error)): ?>
         <div class="result-message error">
             <?php echo htmlspecialchars($error); ?>
         </div>
     <?php endif; ?>
 
     <form method="post">
         <?php foreach ($questions as $i => $q): ?>
             <div class="question">
                 <h3>Question <?php echo $i+1; ?></h3>
                 <p><?php echo htmlspecialchars($q['question']); ?></p>
                 
                 <?php foreach ($q['options'] as $option): ?>
                     <label>
                         <input type="radio" name="q<?php echo $i; ?>" value="<?php echo htmlspecialchars($option); ?>" required>
                         <?php echo htmlspecialchars($option); ?>
                     </label>
                 <?php endforeach; ?>
             </div>
         <?php endforeach; ?>
         
         <button type="submit">Submit Quiz</button>
     </form>
 </body>
 </html>