<?php
if (isset($_GET['room_id'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "siquijordb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $room_id = $_GET['room_id'];
    $sql = "SELECT * FROM rooms WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo json_encode($row);

    $stmt->close();
    $conn->close();
}
?>
