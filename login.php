<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Login</title>
  <!-- External CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Google Fonts (Inter) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="auth-container">
    <div class="auth-card" id="authCard">
      
      <!-- LOGIN FORM -->
      <div id="loginFormContainer" class="form-container active">
        <div class="form-header">
          <h2>Welcome back</h2>
          <p class="subtitle">Sign in to your account</p>
        </div>
        
        <form id="loginForm">
          <div class="input-group">
            <label for="loginUsername">Username</label>
            <input type="text" id="loginUsername" name="username" placeholder="Username" autocomplete="username">
          </div>
          
          <div class="input-group">
            <label for="loginPassword">Password</label>
            <input type="password" id="loginPassword" name="password" placeholder="••••••••" autocomplete="current-password">
          </div>
          
          <div class="options-row">
            <label class="checkbox-label">
              <input type="checkbox" id="rememberMe"> Remember me
            </label>
            <a href="#" id="forgotLink" class="forgot-link">Forgot password?</a>
          </div>
          
          <button type="submit" class="auth-btn">Log in</button>
          <div id="loginError" class="form-error"></div>
        </form>
        
        <div class="toggle-prompt">
          <span>Don't have an account?</span>
          <button type="button" id="showRegisterBtn" class="toggle-link">Sign up</button>
        </div>
      </div>
      
     
      
    </div>
  </div>
  
  <!-- External JavaScript -->
  <script src="js/script.js"></script>
</body>
</html>