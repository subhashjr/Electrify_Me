<?php
 $db_host = "localhost";
 $db_user = "root";
 $db_password = "";
 $db_name = "data";

$city = $_GET['c'];
// Create connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM charging_station WHERE City='" . $city . "';";
$result = $conn->query($sql);
if ($result->num_rows > 0){
  while($row = $result->fetch_assoc()) {
    echo "<div style=\"height:100px;width:95%;align-self: center;margin:15px;border:2px solid black;font-size: 15px;text-align: left;display: flex;\">
    <img src=\"./images/electric_station_icon.png\" alt=\"icon\" style=\"height:90%;margin:6px;margin-left: 10px;\"><div style=\"flex-grow: 8;height: 100%;\">Name: ". $row["name"]. "<br>\nAddress: ". $row["address"]. "<br>\nNo of 4 wheeler ports: " .$row["No_of_4wheeler_ports"]
    . " &emsp;&emsp;&emsp; No of 2 wheeler ports: ". $row["No_of_2wheeler_ports"].	"<br>Charger type: ". $row["Charger_type"] . " &emsp;&emsp;&emsp; Rate: " .$row["Rate"] . "\n</div>
    </div>";
  }
}
else {
  echo "0 results";
}

$conn->close();
?>