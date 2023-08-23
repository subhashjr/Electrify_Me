<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    session_start();
    if (!isset($_SESSION['email'])) {
        echo "<script> window.alert('User is not logged in!');
        setTimeout(function() {window.location.href = 'HomePage.html';},1000);  </script>";
        exit;
    }
    $_SESSION['station_id'] = $_SERVER['QUERY_STRING'];
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION['email'])) {
        echo "<script> window.alert('User is not logged in!');
        setTimeout(function() {window.location.href = 'HomePage.html';},1000);  </script>";
        exit;
    }

    // Check if the required POST parameters are set
    if (
        !isset($_POST['regno']) ||
        !isset($_POST['start_time']) ||
        !isset($_POST['end_time']) ||
        !isset($_POST['model']) ||
        !isset($_POST['station_id'])
    ) {
        echo "<script> window.alert('Invalid request');
        setTimeout(function() {window.location.href = 'Bookings.php';},1000);</script>";
        exit;
    }

    $_SESSION['regno'] = $_POST['regno'];
    $_SESSION['start_time'] = $_POST['start_time'];
    $_SESSION['end_time'] = $_POST['end_time'];
    $_SESSION['model'] = $_POST['model'];

    $db_host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "data";

    $conn = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Check connection
    if ($conn->connect_error) {
        exit;
    } else {
        $station_id = (int)$_POST['station_id']; // Use the station_id from the form POST data
        $start_time = date('Y-m-d H:i:s', strtotime($_POST['start_time']));
        $end_time = date('Y-m-d H:i:s', strtotime($_POST['end_time']));

        // Check for overlapping bookings
        $overlapQuery = "SELECT * FROM `booking_details` WHERE `Station_Id` = $station_id
                         AND ('$start_time' BETWEEN `Start_time` AND `End_time`
                         OR '$end_time' BETWEEN `Start_time` AND `End_time`
                         OR `Start_time` BETWEEN '$start_time' AND '$end_time'
                         OR `End_time` BETWEEN '$start_time' AND '$end_time')";

        $overlapResult = $conn->query($overlapQuery);

        if ($overlapResult->num_rows > 0) {
            echo "<script> window.alert('Slot is already booked at this time.');
            setTimeout(function() {window.location.href = 'Bookings.php';},1000);</script>";
            $conn->close();
            exit;
        }

        // Proceed with the booking insertion
        $sql = "INSERT INTO `booking_details`(email, Station_Id, Start_time, End_time, regno, model)
                VALUES ('$_SESSION[email]', $station_id, '$start_time', '$end_time', '$_POST[regno]', '$_POST[model]')";

        if ($conn->query($sql) === TRUE) {
            $conn->close();
            header('Location: UserBookingsHistory.html');
        } else {
            echo "<script> window.alert('Booking failed');
            setTimeout(function() {window.location.href = 'Bookings.php';},1000);</script>";
            $conn->close();
            exit;
        }
    }
}
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url("images/evimg8.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        #navbar {
            background-color: transparent;
            color: #fff;
            padding: 0;
            text-align: center;
        }

        .container {
            margin: auto;
            max-width: 400px;
            padding: 20px;
        }

        .title {
            font-size: 25px;
            font-weight: 500;
            text-align: center;
            margin-bottom: 20px;
        }

        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 10px 0;
        }

        .content {
            margin: auto;
        }

        .input-box {
            margin-bottom: 15px;
        }

        .booking-box {
            background-color:#EAEAEA;
            border-radius: 5px;
            padding: 20px;
        }

       

        input[type="text"],
        input[type="datetime-local"] {
            width: 100%;
            padding: 8px;
            border:none;
            background-color:white;
            color: #392424;
        }

        .button {
            text-align: center;
            margin-top: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #footer {
            background-color: transparent;
            padding: 0;
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#navbar').load("Navbar.html");
            $('#footer').load("Footer.html");
        });
    </script>

    <title>EV Charging Station Finder</title>
</head>

<body>
    <div id="navbar"></div>
    <div class="container">
        <div class="title">Booking Details<hr></div>
        <div class="content">
            <div class="booking-box">
                <form action="Bookings.php" method="post">
                    <input type="hidden" name="station_id" value="<?php echo $_SESSION['station_id']; ?>">
                    <div class="user-details">
                        <div class="input-box">
                            <span class="text-black text-lg font-medium title-font mb-3">Registration no</span>
                            <input type="text" name="regno" required>
                        </div>
                        <div class="input-box">
                            <span class="text-black text-lg font-medium title-font mb-3">Model</span>
                            <input type="text" name="model" required>
                        </div>
                        <div class="input-box">
                            <span class="text-black text-lg font-medium title-font mb-3">Start time</span>
                            <input type="datetime-local" name="start_time" required>
                        </div>
                        <div class="input-box">
                            <span class="text-black text-lg font-medium title-font mb-3">End time</span>
                            <input type="datetime-local" name="end_time" required>
                        </div>
                        <div class="input-box">
                            <span class="text-black text-lg font-medium title-font mb-3">Vehicle Type</span>
                            <select name="vehicle_type" required>
                                <option value="2_wheeler">2 Wheeler</option>
                                <option value="4_wheeler">4 Wheeler</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="text-black text-lg font-medium title-font mb-3">Number of Slots</span>
                            <input type="number" name="num_slots" min="1" required>
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" value="Book">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="footer"></div>
</body>

</html>
