<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $db_host = "localhost";
  $db_user = "root";
  $db_password = "";
  $db_name = "data";

  // Create connection
  $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Check if email already exists
  $email = $_POST['email'];
  $check_email_query = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($check_email_query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    echo "<script> window.alert('Email Already Exists');
          setTimeout(function() {window.location.href = 'index1.php';},1000);</script>";
    exit;
  }

  $sql = "INSERT INTO `users` (`full_name`, `username`, `email`, `password`, `gender`, `phone`, `age`, `address`)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssis", $_POST['full_name'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['gender'], $_POST['phone'], $_POST['age'], $_POST['address']);

  if ($stmt->execute()) {
    header('Location: login1.php');
    exit;
  } else {
    echo "<script> window.alert('Registration failed');
          setTimeout(function() {window.location.href = 'index.php';},1000);</script>";
    exit;
  }

  $stmt->close();
  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        #video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            object-fit: cover;
        }
    </style>
    <script>
    function validateForm() {
      const email = document.getElementById("email").value;
      const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      if (!email.match(emailPattern)) {
        alert("Please enter a valid email address.");
      return false;
      }
      function validateForm() {
      const phoneNumber = document.getElementById("phone").value;
      const phonePattern = /^[0-9]{10}$/;
      if (!phonePattern.test(phoneNumber)) {
      alert("Please enter a valid 10-digit phone number.");
      return false;
      }
  
  // Rest of your validation logic here
  
  return true; // Allow form submission if all validations pass
}

      const age = parseInt(document.getElementById("age").value);

      if (isNaN(age) || age < 1 || age > 100) {
        alert("Please enter a valid age between 1 and 100.");
        return false;
      }
    }
  </script>
  </head>
  <body>
  <video id="video-background" autoplay muted loop>
        <source src="video2.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="container" style="margin:auto;">
      <div class="title">Registration</div>
      <div class="content">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="user-details">
            <div class="input-box">
              <span class="details">Full_Name</span>
              <input type="text" name="full_name" placeholder="Enter your name" required onsubmit="return validateForm()">
            </div>
            <div class="input-box">
              <span class="details">Username</span>
              <input type="text" name="username" placeholder="Enter your username" required>
            </div>
            <div class="input-box">
              <span class="details">Email</span>
              <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-box">
              <span class="details">Phone Number</span>
              <input type="tel" name="phone" placeholder="Enter your number" required>
            </div>
            <div class="input-box">
              <span class="details">Password</span>
              <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="input-box">
              <span class="details">Confirm Password</span>
              <input type="password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            <div class="input-box">
              <span class="details">Address</span>
              <input type="text" name="address" placeholder="Enter your address" required>
            </div>
            <div class="input-box">
              <span class="details">Age</span>
              <input type="number" name="age" placeholder="Enter your age" min="1" max="100" required>
            </div>
          </div>
          <div class="gender-details">
            <input type="radio" name="gender" id="dot-1" value="Male">
            <input type="radio" name="gender" id="dot-2" value="Female">
            <input type="radio" name="gender" id="dot-3" value="Prefer not to say">
            <span class="gender-title">Gender</span>
            <div class="category">
              <label for="dot-1">
                <span class="dot one"></span>
                <span class="gender">Male</span>
              </label>
              <label for="dot-2">
                <span class="dot two"></span>
                <span class="gender">Female</span>
              </label>
              <label for="dot-3">
                <span class="dot three"></span>
                <span class="gender">Prefer not to say</span>
              </label>
            </div>
          </div>
          <div class="button">
            <input type="submit" value="Register">
          </div>
        </form>
        <a style="color: black" href="login1.php">Already registered? Log in</a> 
      </div>
    </div>
  </body>
</html>
