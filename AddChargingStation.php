<?php
$servername = "localhost";
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

// Validate and sanitize user inputs
$name = mysqli_real_escape_string($conn, $_POST['name']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$state = mysqli_real_escape_string($conn, $_POST['State']);
$city = mysqli_real_escape_string($conn, $_POST['City']);
$charger_type = mysqli_real_escape_string($conn, $_POST['Charger_type']);
$no_of_4wheeler_ports = intval($_POST['No_of_4wheeler_ports']);
$no_of_2wheeler_ports = intval($_POST['No_of_2wheeler_ports']);
$rate = floatval($_POST['rate']);

// Basic input validation
if (empty($name) || empty($address) || empty($state) || empty($city) || empty($charger_type) || $no_of_4wheeler_ports <= 0 || $no_of_2wheeler_ports <= 0 || $rate <= 0) {
    echo "<script> window.alert('Invalid or missing data! Please provide valid inputs.');
          setTimeout(function() {window.location.href = 'Admin.html';},1000);  </script>";
    $conn->close();
    exit;
}

// Construct and execute the SQL query
$sql = "INSERT INTO charging_station(`name`, `address`, `State`, City, Charger_type, No_of_4wheeler_ports, No_of_2wheeler_ports, Rate)
        VALUES('$name', '$address', '$state', '$city', '$charger_type', $no_of_4wheeler_ports, $no_of_2wheeler_ports, $rate)";

if ($conn->query($sql) === TRUE) {
    echo "<script> window.alert('New Charging Station Added Successfully!');
          setTimeout(function() {window.location.href = 'Admin.html';},1000);  </script>";
} else {
    echo "<script> window.alert('Error! Please Try Again');
          setTimeout(function() {window.location.href = 'Admin.html';},1000);  </script>";
}

$conn->close();
exit;
?>
