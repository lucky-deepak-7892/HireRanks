const questions = [
    {
      question: "Which data structure uses LIFO?",
      options: ["Queue", "Stack", "Array", "Tree"],
      correct: "Stack"
    },
    {
      question: "What does 'Big O' notation describe?",
      options: [
        "Data size",
        "Memory usage",
        "Algorithm complexity",
        "File format"
      ],
      correct: "Algorithm complexity"
    },
    {
      question: "Which sorting algorithm is fastest on average?",
      options: ["Bubble Sort", "Selection Sort", "Merge Sort", "Quick Sort"],
      correct: "Quick Sort"
    }
    // You can add more questions here
  ];
  
  let currentQuestion = 0;
  let score = 0;
  
  const startBtn = document.getElementById("start-btn");
  const nextBtn = document.getElementById("next-btn");
  const questionText = document.getElementById("question-text");
  const optionsList = document.getElementById("options-list");
  const testContainer = document.getElementById("test-container");
  const resultContainer = document.getElementById("result-container");
  const scoreDisplay = document.getElementById("score-display");
  
  startBtn.addEventListener("click", () => {
    document.getElementById("start-container").classList.add("hidden");
    testContainer.classList.remove("hidden");
    loadQuestion();
  });
  
  nextBtn.addEventListener("click", () => {
    currentQuestion++;
    if (currentQuestion < questions.length) {
      loadQuestion();
    } else {
      showResult();
    }
  });
  
  function loadQuestion() {
    const current = questions[currentQuestion];
    questionText.textContent = current.question;
    optionsList.innerHTML = "";
  
    current.options.forEach(option => {
      const li = document.createElement("li");
      li.textContent = option;
      li.onclick = () => {
        if (option === current.correct) {
          score++;
        }
        nextBtn.click();
      };
      optionsList.appendChild(li);
    });
  }
  
  function showResult() {
    testContainer.classList.add("hidden");
    resultContainer.classList.remove("hidden");
    scoreDisplay.textContent = `You scored ${score} out of ${questions.length}`;
  }
  