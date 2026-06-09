<?php
require "./database/conn.php";

define('PEPPER', 'k9!dP$3xZq7&vW');

$error = "";
$success = "";

/* PASSWORD STRENGTH FUNCTION */
function getStrength($password) {
    $length = strlen($password);

    $lower = preg_match('/[a-z]/', $password);
    $upper = preg_match('/[A-Z]/', $password);
    $digit = preg_match('/\d/', $password);
    $symbol = preg_match('/[\W_]/', $password);

    if ($length < 12) return "Weak";

    $score = $lower + $upper + $digit + $symbol;

    if ($score == 4) return "Strong";
    if ($score >= 2) return "Medium";
    return "Weak";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $user = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    /* 1. EMPTY CHECK */
    if (empty($user) || empty($password) || empty($confirmPassword)) {
        $error = "Please fill in all fields.";
    }

    /* 2. PASSWORD MATCH CHECK */
    elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    }

    else {

        /* 3. STRENGTH CHECK */
        $strength = getStrength($password);

        if ($strength === "Weak") {
            $error = "Password too weak (must be 12+ chars with uppercase, lowercase, number, symbol).";
        }

        else {
            try {

                /* 4. SALT GENERATION */
                $salt = bin2hex(random_bytes(16));

                /* 5. HASHING (PASSWORD + SALT + PEPPER) */
                $password_hash = password_hash($password . $salt . PEPPER, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, password_hash, salt)
                        VALUES (:username, :password, :salt)";

                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $user);
                $stmt->bindParam(':password', $password_hash);
                $stmt->bindParam(':salt', $salt);
                $stmt->execute();

                $success = "Account created successfully!";

            } catch (PDOException $e) {

                if ($e->errorInfo[1] == 1062) {
                    $error = "Username already exists.";
                } else {
                    $error = "Database error occurred.";
                }
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
  <title>HatchAI Register</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="icon" href="images/fortitle.webp" type="image/webp" />

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

      <div class="password-wrapper">
        <input type="password"
               id="reginPassword"
               name="password"
               placeholder="••••••••">

        <i class="fa-solid fa-eye toggle-password"
           data-target="reginPassword"></i>
      </div>
    </div>

<div class="input-group">
    <label for="confirmPassword">Confirm Password</label>

    <div class="password-wrapper">
        <input type="password"
               id="confirmPassword"
               name="confirmPassword"
               placeholder="••••••••">

        <i class="fa-solid fa-eye toggle-password"
           data-target="confirmPassword"></i>
    </div>
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