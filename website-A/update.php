<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "siquijordb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_id = $_POST['room_id'];
    $roomType = $_POST['roomType'];
    $roomCapacity = $_POST['roomCapacity'];
    $roomAvailable = $_POST['roomAvailable'];
    $amenities = implode(',', $_POST['amenities']);
    $roomRate = $_POST['roomRate'];
    
    $sql = "UPDATE rooms SET room_Type=?, room_Capacity=?, room_Available=?, room_Amenities=?, room_Rate=? WHERE room_id=?";
    
    if ($_FILES['roomImage']['error'] == UPLOAD_ERR_OK) {
        $roomImage = 'uploads/' . basename($_FILES['roomImage']['name']);
        move_uploaded_file($_FILES['roomImage']['tmp_name'], $roomImage);
        $sql = "UPDATE rooms SET room_Type=?, room_Capacity=?, room_Available=?, room_Amenities=?, room_Rate=?, room_Image=? WHERE room_id=?";
    }

    $stmt = $conn->prepare($sql);

    if (isset($roomImage)) {
        $stmt->bind_param("sissdsi", $roomType, $roomCapacity, $roomAvailable, $amenities, $roomRate, $roomImage, $room_id);
    } else {
        $stmt->bind_param("sissdi", $roomType, $roomCapacity, $roomAvailable, $amenities, $roomRate, $room_id);
    }

    if ($stmt->execute()) {
        echo "Room details updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
u