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
  $email = $_POST['Email'];
  $check_email_query = "SELECT * FROM admin WHERE Email = ?";
  $stmt = $conn->prepare($check_email_query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    echo "<script> window.alert('Email Already Exists');
          setTimeout(function() {window.location.href = 'index1.php';},1000);</script>";
    exit;
  }

  $sql = "INSERT INTO `admin` (`Full_Name`, `Email`, `Password`)
          VALUES (?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss",$_POST['Full_Name'],$_POST['Email'],$_POST['Password']);

  if ($stmt->execute()) {
    header('Location: adminlogin1.php');
    exit;
  } else {
    echo "<script> window.alert('Registration failed');
          setTimeout(function() {window.location.href = 'AddNewAdmin.php';},1000);</script>";
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
    <title>Admin Registration Form</title>
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
              <input type="text" name="Full_Name" placeholder="Enter your name" required>
            </div>
            <div class="input-box">
              <span class="details">Email</span>
              <input type="text" name="Email" placeholder="Enter your email" required>
            </div>
            <div class="input-box">
              <span class="details">Password</span>
              <input type="password" name="Password" placeholder="Enter your password" required>
            </div>
            <div class="input-box">
              <span class="details">Confirm Password</span>
              <input type="password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
          </div>
          <div class="button">
            <input type="submit" value="Register">
          </div>
        </form>
        <a style="color: black" href="adminlogin1.php">Already registered? Log in</a> 
      </div>
    </div>
  </body>
</html>
