<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "<script> window.alert('User is not logged in!');
    setTimeout(function() {window.location.href = 'HomePage.html';},1000);</script>";
    exit;
}
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "data";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email = $_SESSION['email'];

// Retrieve booking history and count bookings in each month
$booking_history_query = "SELECT DATE_FORMAT(Start_time, '%Y-%m') AS month, COUNT(*) AS num_bookings
                          FROM booking_details
                          WHERE email = '$email'
                          GROUP BY DATE_FORMAT(Start_time, '%Y-%m')
                          ORDER BY month DESC";

$booking_history_result = $conn->query($booking_history_query);
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <title>EV Charging Station Finder</title>
    <style>
        body {
            background-repeat: no-repeat;
            background-size: cover;
            background-image: url("images/evimg2.jpg");
        }

        .booking-history-table {
            margin: 20px auto;
            max-width: 600px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
<div style="display: flex;">
    <div style="width:50%;height:10vh;border:none;margin:10px;padding:15px;text-align: center;font-size: 30px;font-weight: 600;">Previous Bookings</div>
    <div style="width:50%;height:10vh;border:none;margin:10px;padding:15px;text-align: center;font-size: 30px;font-weight: 600;">Upcoming Bookings</div>
</div>
<div style="display: flex;">
    <div style="width:50%;height:65vh;border:none;margin:10px;overflow-y: auto;overflow-x: hidden;">
        <?php
        $sql = "SELECT `name`, `address`, Start_time, End_time FROM booking_details JOIN charging_station ON booking_details.Station_Id = charging_station.Station_Id WHERE email='$_SESSION[email]' AND `Start_time` < NOW()";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $booking = "<div style=\"height:100px;align-self: center;border:none;text-align: left;display: flex;overflow-y: auto;margin: 15px;background-color: rgb(248, 134, 114);border-radius: 10px;\">
            <img src=\"./images/electric_station_icon.png\" alt=\"icon\" style=\"height:80%;margin:6px;margin-left: 10px;border-radius: 100px;\">
            <div style=\"flex-grow: 8;height: 100%;font-size: 15px;line-height: 1.18;padding-top: 3px;font-weight: 400;position: relative;\">
            <span style=\"font-size: 17px;font-weight: 500;\">Station name:" . $row["name"] . "</span><br>
            Address:" . $row["address"] . "<br>
            Time Slot: " . $row["Start_time"] . " to " . $row["End_time"] . "<br>
            Amount to be Paid: Rs 500 &emsp;&emsp;
            </div>
          </div>";
                echo $booking;
            }
        }
        ?>
    </div>
    <div style="width:50%;height:65vh;border:none;margin:10px;overflow-y: auto;overflow-x: hidden;">
        <?php
        $sql = "SELECT `name`, `address`, Start_time, End_time FROM booking_details JOIN charging_station ON booking_details.Station_Id = charging_station.Station_Id WHERE email='$_SESSION[email]' AND `Start_time` >= NOW()";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $booking = "<div style=\"height:100px;align-self: center;border:none;text-align: left;display: flex;overflow-y: auto;margin: 15px;background-color: rgb(137, 216, 137);border-radius: 10px;\">
            <img src=\"./images/electric_station_icon.png\" alt=\"icon\" style=\"height:80%;margin:6px;margin-left: 10px;border-radius: 100px;\">
            <div style=\"flex-grow: 8;height: 100%;font-size: 15px;line-height: 1.18;padding-top: 3px;font-weight: 400;position: relative;\">
            <span style=\"font-size: 17px;font-weight: 500;\">Station name:" . $row["name"] . "</span><br>
            Address:" . $row["address"] . "<br>
            Time Slot: " . $row["Start_time"] . " to " . $row["End_time"] . "<br>
            Amount to be Paid: Rs 500 &emsp;&emsp;
            </div>
          </div>";
                echo $booking;
            }
        }
        ?>
    </div>
</div>
<div class="booking-history-table">
    <h1 style="font-size: 24px; margin-bottom: 10px;">Monthly Booking History</h1>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #ccc;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px; text-align: left;">Month</th>
                <th style="padding: 10px; text-align: center;">Number of Bookings</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $booking_history_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='padding: 10px;'>" . $row['month'] . "</td>";
                echo "<td style='padding: 10px; text-align: center;'>" . $row['num_bookings'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <div style="text-align: center; margin-top: 10px;">
        <a href="HomePage.html" style="text-decoration: none; color: #333; font-weight: bold;">Back to Home</a>
    </div>
</div>

</body>
</html>
