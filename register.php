<?php
require "./database/conn.php";

define('PEPPER', 'k9!dP$3xZq7&vW');

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user = trim($_POST['username']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($user) || empty($password)) {
        $error = "Please fill in both username and password.";
    } else {
        try {
            // Generate salt and hash
            $salt = bin2hex(random_bytes(16));
            $password_hash = password_hash($password . $salt . PEPPER, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password_hash, salt) VALUES (:username, :password, :salt)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':salt', $salt);
            $stmt->execute();

            $success = "Account created successfully! You can now log in.";
        } catch (PDOException $e) {
            // Check for duplicate entry (MySQL error code 1062)
            if ($e->errorInfo[1] == 1062) {
                $error = "Username already taken. Please choose another one.";
            } else {
                $error = "Database error: Could not register user.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Register</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="auth-container">
  <div class="auth-card" id="authCard">
    <div id="regFormContainer" class="form-container active">
      <div class="form-header">
        <h2>Create an account</h2>
        <p class="subtitle">Welcome our new user!</p>
      </div>

      <form id="reginForm" method="POST">
        <div class="input-group">
          <label for="reginUsername">Username</label>
          <input type="text" id="reginUsername" name="username" placeholder="Username" value="<?php echo htmlspecialchars($user ?? ''); ?>" autocomplete="username">
        </div>

        <div class="input-group">
          <label for="reginPassword">Password</label>
          <input type="password" id="reginPassword" name="password" placeholder="••••••••" autocomplete="current-password">
        </div>

        <button type="submit" class="auth-btn">Register</button>

        <!-- Message containers (populated by PHP) -->
        <div id="reginError" class="form-error"><?php echo htmlspecialchars($error); ?></div>
        <div id="reginSuccess" class="form-success"><?php echo htmlspecialchars($success); ?></div>
      </form>

      <div class="toggle-prompt">
        <span>Do you have an account?</span>
        <button type="button" id="showLoginBtn" class="toggle-link">Sign in</button>
      </div>
    </div>
  </div>
</div>

<script src="js/script.js"></script>
</body>
</html>