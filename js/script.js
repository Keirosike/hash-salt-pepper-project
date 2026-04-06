const registerBtn = document.getElementById("showRegisterBtn");
const loginBtn = document.getElementById("showLoginBtn");

if (registerBtn) {
    registerBtn.addEventListener("click", function() {
        window.location.href = "register.php";
    });
}

if (loginBtn) {
    loginBtn.addEventListener("click", function() {
        window.location.href = "login.php";
    });
}


document.getElementById("reginForm").addEventListener("submit", function(e) {
    const password = document.getElementById("reginPassword").value;
    const errorDiv = document.getElementById("reginError");

    // Regex: at least 8 chars, 1 uppercase, 1 lowercase, 1 number, 1 special char
    const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if (!pattern.test(password)) {
        e.preventDefault(); // Stop form submission
        errorDiv.textContent = "Password must be at least 8 characters and include uppercase, lowercase, number, and special character.";
        errorDiv.style.color = "red";
    } else {
        errorDiv.textContent = ""; // Clear error
    }
});