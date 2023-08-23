<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EV Charging Station Finder</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f5f5f5;
            position: relative;
        }
        
        .user-info-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 80px; 
        }
        
        .user-info-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .user-field {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .user-label {
            font-size: 20px;
            font-weight: 500;
            width: 200px; 
            margin-right: 10px;
        }
        
        .user-value {
            font-size: 20px;
            padding: 8px;
            border: none;
            background-color: transparent;
            width: 100%;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['email'])) {
        echo "<script> window.alert('User is not logged in!');
            setTimeout(function() {window.location.href = 'login1.php';},1000);</script>";
        exit;
    }

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
    $sql = "SELECT * FROM users WHERE email='" . $_SESSION['email'] . "'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $full_name = $row['full_name'];
        $email = $row['email'];
        $gender = $row['gender'];
        $mobile_no = $row['phone'];
        $age = $row['age'];
        $address = $row['address'];
    }
    ?>

    <div class="user-info-container">
        <h1>User Information</h1>
        
        <div class="user-field">
            <label class="user-label">Username:</label>
            <span class="user-value"><?php echo $username ?></span>
        </div>
        
        <div class="user-field">
            <label class="user-label">Full Name:</label>
            <span class="user-value"><?php echo $full_name ?></span>
        </div>
        
        <div class="user-field">
            <label class="user-label">Mobile Number:</label>
            <span class="user-value"><?php echo $mobile_no ?></span>
        </div>
        
        <div class="user-field">
            <label class="user-label">Email:</label>
            <span class="user-value"><?php echo $email ?></span>
        </div>
        
        <div class="user-field">
            <label class="user-label">Address:</label>
            <span class="user-value"><?php echo $address ?></span>
        </div>
        
        <div class="user-field">
            <label class="user-label">Age:</label>
            <span class="user-value"><?php echo $age ?></span>
        </div>
        
        <div class="user-field">
            <label class="user-label">Gender:</label>
            <span class="user-value"><?php echo $gender ?></span>
        </div>
    </div>
    
    
</body>
</html>
