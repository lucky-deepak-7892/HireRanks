function startTest() {
    const skill = document.getElementById("skillSelect").value;
  
    if (!skill) {
      alert("Please select a skill before starting the test.");
      return;
    }
  
    // Redirect to a new page or test interface (you can change this link)
    window.location.href = `test-${skill.toLowerCase().replace(" ", "-")}.html`;
  }
  