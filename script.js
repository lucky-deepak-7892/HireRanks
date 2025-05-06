// Simple event listeners for buttons
document.getElementById("studentBtn").addEventListener("click", () => {
    alert("Redirecting to Student Signup...");
    // window.location.href = "/signup/student";
  });
  
  document.getElementById("companyBtn").addEventListener("click", () => {
    alert("Redirecting to Company Signup...");
    // window.location.href = "/signup/company";
  });
  
  // Filter logic for skills (can be expanded with dynamic data)
  document.getElementById("skillFilter").addEventListener("change", function () {
    const selectedSkill = this.value;
    const rows = document.querySelectorAll("#leaderboardBody tr");
  
    rows.forEach((row) => {
      const skill = row.children[2].textContent;
      if (selectedSkill === "All" || skill === selectedSkill) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });
  function takeTest(testName) {
    alert(`Redirecting to the ${testName} test page...`);
    // Example: window.location.href = `/tests/${testName.toLowerCase().replace(" ", "-")}`;
  }