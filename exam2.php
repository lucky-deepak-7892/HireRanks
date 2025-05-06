<?php
 session_start();
 include("main.php");
 
 // Check if user is logged in
 if (!isset($_SESSION['user_id'])) {
     header("Location: login.php");
     exit();
 }
 
 // Error reporting
 error_reporting(E_ALL);
 ini_set('display_errors', 1);
 
 // Database config
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $dbname = "hirerank_result";
 
 $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
 if (!$con) {
     die("Database connection failed: " . mysqli_connect_error());
 }
 
 // Questions structured by difficulty
 $questions = (object) [
    "easy" => [
         (object) [
             "question" => "What is the time complexity of accessing an element in an array by its index?",
             "options" => ["O(1)", "O(n)", "O(log n)", "O(n log n)"],
             "answer" => "O(1)"
         ],
         (object) [
             "question" => "Which data structure follows the Last-In-First-Out (LIFO) principle?",
             "options" => ["Queue", "Stack", "Tree", "Graph"],
             "answer" => "Stack"
         ],
         (object) [
             "question" => "What is the purpose of the 'push' operation in a stack?",
             "options" => ["Remove an element", "Add an element", "Access an element", "Sort elements"],
             "answer" => "Add an element"
         ],
         (object) [
             "question" => "Which algorithm is used to find an element in a sorted array?",
             "options" => ["Linear search", "Binary search", "Depth-first search", "Breadth-first search"],
             "answer" => "Binary search"
         ],
         (object) [
             "question" => "What is the time complexity of inserting an element at the beginning of a linked list?",
             "options" => ["O(1)", "O(n)", "O(log n)", "O(n log n)"],
             "answer" => "O(1)"
         ],
         (object) [
             "question" => "Which data structure is used to implement recursive functions?",
             "options" => ["Stack", "Queue", "Tree", "Graph"],
             "answer" => "Stack"
         ],
         (object) [
             "question" => "What is the purpose of the 'enqueue' operation in a queue?",
             "options" => ["Remove an element", "Add an element", "Access an element", "Sort elements"],
             "answer" => "Add an element"
         ],
         (object) [
             "question" => "Which algorithm is used to sort an array of elements?",
             "options" => ["Binary search", "Linear search", "Bubble sort", "Depth-first search"],
             "answer" => "Bubble sort"
         ],
         (object) [
             "question" => "What is the time complexity of deleting an element from a linked list?",
             "options" => ["O(1)", "O(n)", "O(log n)", "O(n log n)"],
             "answer" => "O(n)"
         ],
         (object) [
             "question" => "Which data structure is used to represent a hierarchical relationship between elements?",
             "options" => ["Tree", "Graph", "Stack", "Queue"],
             "answer" => "Tree"
         ]
     ],
     "medium" => [
         (object) [
             "question" => "What is the time complexity of the merge sort algorithm?",
             "options" => ["O(n log n)", "O(n^2)", "O(n)", "O(log n)"],
             "answer" => "O(n log n)"
         ],
         (object) [
             "question" => "Which data structure is used to implement a priority queue?",
             "options" => ["Heap", "Stack", "Queue", "Tree"],
             "answer" => "Heap"
         ],
         (object) [
             "question" => "What is the purpose of the 'heapify' operation in a heap?",
             "options" => ["Insert an element", "Delete an element", "Maintain the heap property", "Sort elements"],
             "answer" => "Maintain the heap property"
         ],
         (object) [
             "question" => "Which algorithm is used to find the shortest path in a graph?",
             "options" => ["Dijkstra's algorithm", "Bellman-Ford algorithm", "Floyd-Warshall algorithm", "Topological sorting"],
             "answer" => "Dijkstra's algorithm"
         ],
         (object) [
             "question" => "What is the time complexity of the quicksort algorithm?",
             "options" => ["O(n log n)", "O(n^2)", "O(n)", "O(log n)"],
             "answer" => "O(n log n)"
         ],
         (object) [
             "question" => "Which data structure is used to implement a disjoint-set data structure?",
             "options" => ["Tree", "Graph", "Stack", "Union-find data structure"],
             "answer" => "Union-find data structure"
         ],
         (object) [
             "question" => "What is the purpose of the 'union' operation in a disjoint-set data structure?",
             "options" => ["Merge two sets", "Find the root of a set", "Insert an element", "Delete an element"],
             "answer" => "Merge two sets"
         ],
         (object) [
             "question" => "Which algorithm is used to find the minimum spanning tree of a graph?",
             "options" => ["Kruskal's algorithm", "Prim's algorithm", "Dijkstra's algorithm", "Bellman-Ford algorithm"],
             "answer" => "Kruskal's algorithm"
         ],
        
     ],
     "hard" => [
         (object) [
             "question" => "What is the time complexity of the suffix tree construction algorithm?",
             "options" => ["O(n log n)", "O(n^2)", "O(n)", "O(log n)"],
             "answer" => "O(n)"
         ],
         (object) [
             "question" => "Which algorithm is used to find the longest common subsequence between two strings?",
             "options" => ["Dynamic programming", "Greedy algorithm", "Divide and conquer", "Backtracking"],
             "answer" => "Dynamic programming"
         ]
         // You can continue adding more hard questions here...
     ]
 ];
 
 
 // Process quiz submission
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $correct = 0;
     $totalQuestions = 0;
     $flatQuestions = [];
 
     // Flatten questions for easier checking
     foreach ($questions as $level => $qs) {
         foreach ($qs as $index => $q) {
             $flatQuestions["q" . $totalQuestions] = $q;
             $totalQuestions++;
         }
     }
 
     // Evaluate answers
     foreach ($_POST as $key => $value) {
         if (isset($flatQuestions[$key])) {
             if ($value === $flatQuestions[$key]->answer) {
                 $correct++;
             }
         }
     }
 
     // Insert score into DB
     $query = "INSERT INTO dsa_test (score, user_id, time) VALUES (?, ?, NOW())";
     $stmt = mysqli_prepare($con, $query);
     if ($stmt) {
         mysqli_stmt_bind_param($stmt, "is", $correct, $_SESSION['user_id']);
         if (mysqli_stmt_execute($stmt)) {
             header("Location: " . $_SERVER['PHP_SELF'] . "?result=" . $correct);
             exit();
         } else {
             $error = "Failed to save results.";
             error_log("DB execute error: " . mysqli_stmt_error($stmt));
         }
         mysqli_stmt_close($stmt);
     } else {
         $error = "System error.";
         error_log("DB prepare error: " . mysqli_error($con));
     }
 }
 ?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <title>Aptitude Quiz</title>
     <style>
         body { font-family: Arial; background: #f5f5f5; max-width: 800px; margin: auto; padding: 20px; }
         h1 { text-align: center; }
         .question { background: #fff; padding: 15px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
         .question h3 { color: #3498db; }
         label { display: block; margin-bottom: 10px; }
         input[type="radio"] { margin-right: 10px; }
         button { display: block; margin: auto; padding: 10px 20px; font-size: 16px; background: #3498db; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
         .result-message { text-align: center; font-weight: bold; margin-top: 20px; }
         .success { color: green; }
         .error { color: red; }
         .score-display { font-size: 24px; text-align: center; }
     </style>
 </head>
 <body>
 
     <h1>Aptitude Quiz</h1>
 
     <?php if (isset($_GET['result'])): ?>
         <div class="result-message success">
             Your quiz has been submitted successfully!
         </div>
         <div class="score-display">
             You scored <?php echo htmlspecialchars($_GET['result']); ?> out of <?php
                 $count = 0;
                 foreach ($questions as $qList) { $count += count($qList); }
                 echo $count;
             ?>
         </div>
     <?php endif; ?>
 
     <?php if (isset($error)): ?>
         <div class="result-message error"><?php echo htmlspecialchars($error); ?></div>
     <?php endif; ?>
 
     <form method="post">
         <?php
         $qNumber = 0;
         foreach ($questions as $level => $qList):
             foreach ($qList as $q):
         ?>
         <div class="question">
             <h3>Question <?php echo ++$qNumber; ?> (<?php echo ucfirst($level); ?>)</h3>
             <p><?php echo htmlspecialchars($q->question); ?></p>
             <?php foreach ($q->options as $option): ?>
                 <label>
                     <input type="radio" name="q<?php echo $qNumber - 1; ?>" value="<?php echo htmlspecialchars($option); ?>" required>
                     <?php echo htmlspecialchars($option); ?>
                 </label>
             <?php endforeach; ?>
         </div>
         <?php endforeach; endforeach; ?>
 
         <button type="submit">Submit Quiz</button>
     </form>
 
 </body>
 </html>