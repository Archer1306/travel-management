<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_form";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database table is empty
$sql = "SELECT COUNT(*) as count FROM login";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$isTableEmpty = ($row['count'] == 0);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    if ($isTableEmpty) {
        // If the table is empty, store the first username and password
        $sql = "INSERT INTO login (username, password) VALUES ('$inputUsername', '$inputPassword')";
        if ($conn->query($sql) === TRUE) {
            header("Location: admin.php?status=register_and_login_success");
            exit();
        } else {
            header("Location: login.php?status=register_error");
            exit();
        }
    } else {
        // If the table is not empty, validate the username and password
        $sql = "SELECT * FROM login WHERE username = '$inputUsername'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User exists, validate password
            $row = $result->fetch_assoc();
            if ($inputPassword === $row['password']) {
                header("Location: admin.php?status=login_success");
                exit();
            } else {
                header("Location: login.php?status=invalid_password");
                exit();
            }
        } else {
            // User doesn't exist, show error
            header("Location: login.php?status=user_not_found");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Additional styles */
    .login-section {
      padding: 5rem 10%;
      background: var(--light-bg);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-container {
      background: var(--white);
      border: var(--border);
      box-shadow: var(--box-shadow);
      padding: 3rem;
      border-radius: .5rem;
      width: 100%;
      max-width: 40rem;
    }

    .login-container h2 {
      font-size: 2.5rem;
      color: var(--black);
      text-align: center;
      margin-bottom: 2rem;
    }

    .login-form .input-group {
      margin-bottom: 2rem;
    }

    .login-form label {
      display: block;
      font-size: 1.6rem;
      color: var(--black);
      margin-bottom: .5rem;
    }

    .login-form input {
      width: 100%;
      padding: 1.2rem;
      border: var(--border);
      border-radius: .5rem;
      font-size: 1.6rem;
      text-transform: none; /* Ensure no text transformation */
      font-variant: normal;
    }

    .password-container {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--light-black);
    }

    .login-btn {
      width: 100%;
      padding: 1.2rem;
      background: var(--black);
      color: var(--white);
      font-size: 1.8rem;
      cursor: pointer;
      border-radius: .5rem;
    }

    .login-btn:hover {
      background: var(--main-color);
    }

    .message-box {
      position: fixed;
      top: 20%;
      left: 50%;
      transform: translateX(-50%);
      padding: 1.5rem 3rem;
      border-radius: .5rem;
      font-size: 1.6rem;
      z-index: 1000;
      animation: fadeInOut 3s;
      opacity: 0;
    }

    .success {
      background: var(--main-color);
      color: var(--white);
    }

    .error {
      background: var(--black);
      color: var(--white);
    }

    @keyframes fadeInOut {
      0% { opacity: 0; transform: translate(-50%, -60%); }
      20%, 80% { opacity: 1; transform: translate(-50%, -50%); }
      100% { opacity: 0; transform: translate(-50%, -40%); }
    }
  </style>
</head>
<body>

<!-- Header Section -->
<section class="header">
   <a href="home.php" class="logo">Travel</a>
   <nav class="navbar">
      <a href="home.php">home</a>
      <a href="about.php">about</a>
      <a href="package.php">package</a>
      <a href="book.php">book</a>
      <a href="bookinghistory.php">Booking History</a>
      <a href="login.php"><i class="fas fa-user"></i></a>
   </nav>
   <div id="menu-btn" class="fas fa-bars"></div>
</section>

<!-- Login Section -->
<section class="login-section">
  <div class="login-container">
    <h2>Admin Login</h2>
    <form class="login-form" action="login.php" method="POST">
      <div class="input-group">
        <label for="login-username">Username</label>
        <input id="login-username" type="text" name="username" required>
      </div>
      <div class="input-group">
        <label for="login-password">Password</label>
        <div class="password-container">
          <input id="login-password" type="password" name="password" required>
          <i class="fas fa-eye toggle-password"></i>
        </div>
      </div>
      <button type="submit" class="login-btn">Login</button>
    </form>
  </div>
</section>

<!-- Message Box -->
<div class="message-box" style="display: none;"></div>

<!-- Footer Section -->
<section class="footer">
   <div class="box-container">
      <div class="box">
         <h3>quick links</h3>
         <a href="home.php"> <i class="fas fa-angle-right"></i> home</a>
         <a href="about.php"> <i class="fas fa-angle-right"></i> about</a>
         <a href="package.php"> <i class="fas fa-angle-right"></i> package</a>
         <a href="book.php"> <i class="fas fa-angle-right"></i> book</a>
      </div>
      <div class="box">
         <h3>extra links</h3>
         <a href="#"> <i class="fas fa-angle-right"></i> ask questions</a>
         <a href="#"> <i class="fas fa-angle-right"></i> about us</a>
         <a href="#"> <i class="fas fa-angle-right"></i> privacy policy</a>
         <a href="#"> <i class="fas fa-angle-right"></i> terms of use</a>
      </div>
      <div class="box">
         <h3>contact info</h3>
         <a href="#"> <i class="fas fa-phone"></i> +123-456-7890 </a>
         <a href="#"> <i class="fas fa-phone"></i> +111-222-3333 </a>
         <a href="#"> <i class="fas fa-envelope"></i> travel@gmail.com </a>
         <a href="#"> <i class="fas fa-map"></i> Chennai, india - 600019 </a>
      </div>
      <div class="box">
         <h3>follow us</h3>
         <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
         <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
         <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
         <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
      </div>
   </div>
   <div class="credit"> created by <span>Aswin S</span> | all rights reserved! </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const messageBox = document.querySelector('.message-box');
  const togglePassword = document.querySelector('.toggle-password');
  const passwordInput = document.getElementById('login-password');

  // Handle status messages
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  
  if(status) {
    let message = '';
    let messageClass = '';
    
    switch(status) {
      case 'login_success':
        message = 'Login successful!';
        messageClass = 'success';
        break;
      case 'register_and_login_success':
        message = 'Registered and logged in successfully!';
        messageClass = 'success';
        break;
      case 'invalid_password':
        message = 'Invalid password!';
        messageClass = 'error';
        break;
      case 'user_not_found':
        message = 'User not found!';
        messageClass = 'error';
        break;
      case 'register_error':
        message = 'Registration failed!';
        messageClass = 'error';
        break;
    }

    if(message) {
      messageBox.textContent = message;
      messageBox.classList.add(messageClass);
      messageBox.style.display = 'block';
      
      setTimeout(() => {
        messageBox.style.display = 'none';
        if(messageClass === 'success') {
          window.location.href = 'admin.php';
        }
      }, 3000);
    }
  }

  // Toggle password visibility
  if(togglePassword) {
    togglePassword.addEventListener('click', () => {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      togglePassword.classList.toggle('fa-eye-slash');
    });
  }
});
</script>

</body>
</html>