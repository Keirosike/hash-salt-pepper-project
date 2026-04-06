<?php
require "./database/conn.php";

try{

define('PEPPER', 'k9!dP$3xZq7&vW');

if($_SERVER['REQUEST_METHOD'] == "POST"){
$user = $_POST['username'];
$password = $_POST['password'];

$salt = bin2hex(random_bytes(16));

$password_hash = password_hash($password. $salt. PEPPER, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (username, password_hash, salt) VALUES (:username, :password, :salt)";
$stmt = $conn->prepare($sql);

$stmt->bindParam(':username', $user);
$stmt->bindParam(':password', $password_hash);
$stmt->bindParam(':salt', $salt);
$stmt->execute();

echo "<script>alert('Register Successfully!');</script>";

}



}catch(PDOException $e){
   $msg = addslashes($e->getMessage()); // escape quotes
    echo "<script>alert('Error: $msg');</script>";

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Register</title>
  <!-- External CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Google Fonts (Inter) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="auth-container">
    <div class="auth-card" id="authCard">
      
      <!-- REGISTER FORM -->
       
      <div id="regFormContainer" class="form-container active">
        <div class="form-header">
          <h2>Create an account</h2>
          <p class="subtitle">Welcome our new user!</p>
        </div>
        
        <form id="reginForm" method="POST">
          <div class="input-group">
            <label for="reginUsername">Username</label>
            <input type="text" id="reginUsername" name="username" placeholder="Username" autocomplete="username">
          </div>
          
          <div class="input-group">
            <label for="reginPassword">Password</label>
            <input type="password" id="reginPassword" name="password" placeholder="••••••••" autocomplete="current-password">
          </div>
          
          <button type="submit" class="auth-btn">Register</button>
          <div id="reginError" class="form-error"></div>
        </form>
        
        <div class="toggle-prompt">
          <span>Do you have an account?</span>
          <button type="button" id="showLoginBtn" class="toggle-link">Sign in</button>
        </div>
      </div>
      
     
      
    </div>
  </div>
  
  <!-- External JavaScript -->
  <script src="js/script.js"></script>
</body>
</html>