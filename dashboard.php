<?php
// Establishing connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "siquijordb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the rooms table
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);
$rooms_data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rooms_data[] = $row;
    }
}

// Close connection
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($rooms_data);
?>
