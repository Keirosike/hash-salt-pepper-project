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

    const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/;

    if (!pattern.test(password)) {
        e.preventDefault();
        errorDiv.textContent = "Password must be at least 12 characters and include uppercase, lowercase, number, and special character.";
        errorDiv.style.color = "red";
    } else {
        errorDiv.textContent = "";
    }
});

/* CLEAR MESSAGES ON FOCUS */
document.querySelectorAll('#reginForm input').forEach(input => {
    input.addEventListener('focus', () => {
        const errorDiv = document.getElementById('reginError');
        const successDiv = document.getElementById('reginSuccess');

        if (errorDiv) errorDiv.textContent = '';
        if (successDiv) successDiv.textContent = '';
    });
});
