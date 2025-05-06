const user = {
    name: "Luckey Yadav",
    email: "luckey@example.com",
    skill: "Full Stack Developer",
    joined: "March 2025"
  };
  
  window.addEventListener("DOMContentLoaded", () => {
    document.querySelector(".avatar").textContent = user.name[0];
    document.querySelector(".profile-info").innerHTML = `
      <p><strong>Name:</strong> ${user.name}</p>
      <p><strong>Email:</strong> ${user.email}</p>
      <p><strong>Skill:</strong> ${user.skill}</p>
      <p><strong>Joined:</strong> ${user.joined}</p>
    `;
  });