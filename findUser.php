<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET"){
   // Connect to your database (replace with your database credentials)
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
        
        $sql = "SELECT email FROM `users` WHERE email=\"$_GET[name]\"";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0){
            $row = $result->fetch_assoc();
            session_start();
            $_SESSION["email"] = $row["email"];
            echo "True";
        }
        else{
            echo "False";
        }
    }
?>