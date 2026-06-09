<?php
require "./database/conn.php";
session_start();

define('PEPPER', 'k9!dP$3xZq7&vW');

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        try {

            $sql = "SELECT password_hash, salt FROM users WHERE username = :username";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            // FIX: avoid rowCount()
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {

                $stored_hash = $row['password_hash'];
                $stored_salt = $row['salt'];

                // rebuild input using salt + pepper (same as registration)
                $input_password = $password . $stored_salt . PEPPER;

                // FIX: correct verification usage
                if (password_verify($input_password, $stored_hash)) {

                    session_regenerate_id(true);
                    $_SESSION['username'] = $username;

                    $success = "Login successful! Redirecting to dashboard...";
                    header("refresh:1;url=dashboard.html");
                    exit;

                } else {
                    $error = "Invalid username or password.";
                }

            } else {
                $error = "Invalid username or password.";
            }

        } catch (PDOException $e) {
            $error = "Database error: Could not log in.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>HatchAILogin</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="icon" href="images/fortitle.webp" type="image/webp" />

</head>
<body>
<div class="auth-container">
  <div class="auth-card" id="authCard">
    <div id="loginFormContainer" class="form-container active">
      <div class="form-header">
        <h2>Welcome back</h2>
        <p class="subtitle">Sign in to your account</p>
      </div>

      <form id="loginForm" method="POST">
        <div class="input-group">
          <label for="loginUsername">Username</label>
          <input type="text" id="loginUsername" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username ?? ''); ?>" autocomplete="username">
        </div>

<div class="input-group">
    <label for="loginPassword">Password</label>

    <div class="password-wrapper">
        <input type="password"
               id="loginPassword"
               name="password"  
               placeholder="••••••••"
               autocomplete="password">

        <i class="fa-solid fa-eye toggle-password"
           data-target="loginPassword"></i>
    </div>
</div>

        <div class="options-row">
          <label class="checkbox-label">
            <input type="checkbox" id="rememberMe"> Remember me
          </label>
          <a href="#" id="forgotLink" class="forgot-link">Forgot password?</a>
        </div>

        <button type="submit" class="auth-btn">Log in</button>

        <!-- Message containers -->
        <div id="loginError" class="form-error"><?php echo htmlspecialchars($error); ?></div>
        <div id="loginSuccess" class="form-success"><?php echo htmlspecialchars($success); ?></div>
      </form>

      <div class="toggle-prompt">
        <span>Don't have an account?</span>
        <button type="button" id="showRegisterBtn" class="toggle-link">Sign up</button>
      </div>
    </div>
  </div>
</div>

<script>
  

  // Clear messages when user starts typing (optional)
  document.querySelectorAll('#loginForm input').forEach(input => {
    input.addEventListener('focus', () => {
      document.getElementById('loginError').textContent = '';
      document.getElementById('loginSuccess').textContent = '';
    });
  });
</script>
<script src="js/script.js"></script>
</body>
</html>