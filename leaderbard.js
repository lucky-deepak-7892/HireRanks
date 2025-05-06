const leaderboardData = [
    { name: "Luckey", },
    { name: "Ravi",  },
    { name: "Sneha", },
    { name: "Aryan",  },
    { name: "Pooja",  }
  ];
  
  function renderLeaderboard(data) {
    const tbody = document.getElementById("leaderboardBody");
    tbody.innerHTML = "";
  
    data.forEach((entry, index) => {
      const row = `<tr>
        <td>#${index + 1}</td>
        <td>${entry.name}</td>
      
        
      </tr>`;
      tbody.innerHTML += row;
    });
  }
  
  function filterLeaderboard() {
    const selectedSkill = document.getElementById("skillFilter").value;
    if (selectedSkill === "All") {
      renderLeaderboard(leaderboardData);
    } else {
      const filtered = leaderboardData.filter(item => item.skill === selectedSkill);
      renderLeaderboard(filtered);
    }
  }
  
  // Initialize
  window.onload = () => renderLeaderboard(leaderboardData);