
const registerBtn = document.getElementById("showRegisterBtn");
const loginBtn = document.getElementById("showLoginBtn");

if (registerBtn) {
    registerBtn.addEventListener("click", function () {
        window.location.href = "register.php";
    });
}

if (loginBtn) {
    loginBtn.addEventListener("click", function () {
        window.location.href = "login.php";
    });
}


/* ================================
   PASSWORD STRENGTH METER (FIXED)
================================ */
const passwordInput = document.getElementById("reginPassword");

function updateStrength(password) {

    const errorDiv = document.getElementById("reginError");

    const lengthOK = password.length >= 12;
    const hasLower = /[a-z]/.test(password);
    const hasUpper = /[A-Z]/.test(password);
    const hasNumber = /\d/.test(password);
    const hasSymbol = /[\W_]/.test(password);

    let score = 0;

    if (lengthOK) score++;
    if (hasLower) score++;
    if (hasUpper) score++;
    if (hasNumber) score++;
    if (hasSymbol) score++;

    let strength = "";

    if (!lengthOK || score <= 2) {
        strength = "Weak";
    }
    else if (score === 3 || score === 4) {
        strength = "Medium";
    }
    else {
        strength = "Strong";
    }

    if (errorDiv) {

        // Remove previous styling
        errorDiv.classList.remove("form-error", "form-success");

        // Show text
        errorDiv.textContent = "Password Strength: " + strength;

        // Apply CSS-based styling
        if (strength === "Strong") {
            errorDiv.classList.add("form-success");
        } else {
            errorDiv.classList.add("form-error");
        }
    }
}


/* LIVE PASSWORD LISTENER */
if (passwordInput) {
    passwordInput.addEventListener("input", function () {
        updateStrength(passwordInput.value);
    });
}


/* ================================
   FORM VALIDATION (SECURE RULES)
================================ */
const form = document.getElementById("reginForm");

if (form) {
    form.addEventListener("submit", function (e) {

        const password = document.getElementById("reginPassword").value;
        const errorDiv = document.getElementById("reginError");

        const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/;

        if (!pattern.test(password)) {
            e.preventDefault();

            errorDiv.classList.remove("form-success");
            errorDiv.classList.add("form-error");

            errorDiv.textContent =
                "Password must be at least 12 chars + uppercase + lowercase + number + symbol.";
        } else {
            errorDiv.textContent = "";
        }
    });
}


/* ================================
   CLEAR MESSAGES ON FOCUS
================================ */
document.querySelectorAll('#reginForm input').forEach(input => {
    input.addEventListener('focus', () => {

        const errorDiv = document.getElementById('reginError');
        const successDiv = document.getElementById('reginSuccess');

        if (errorDiv) {
            errorDiv.textContent = '';
            errorDiv.classList.remove("form-error", "form-success");
        }

        if (successDiv) {
            successDiv.textContent = '';
        }
    });
});