<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "siquijordb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $room_id = $_POST['room_id'];
    $room_Type = $_POST['roomType'];
    $room_Capacity = $_POST['roomCapacity'];
    $room_Available = $_POST['roomAvailable'];
    $room_Amenities = isset($_POST['roomAmenities']) ? implode(", ", $_POST['roomAmenities']) : '';
    $room_Rate = $_POST['roomRate'];

    // Handle file upload for room image
    if (isset($_FILES['roomImage']) && $_FILES['roomImage']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES["roomImage"]["name"];
        $tempname = $_FILES["roomImage"]["tmp_name"];
        $folder = "./uploads/" . $filename;

        // Move the uploaded image into the folder: uploads
        if (move_uploaded_file($tempname, $folder)) {
            // If the file upload is successful, update the room image path in the database
            $sql = "UPDATE rooms SET room_Type=?, room_Capacity=?, room_Available=?, room_Amenities=?, room_Rate=?, room_Image=? WHERE room_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sissisi", $room_Type, $room_Capacity, $room_Available, $room_Amenities, $room_Rate, $folder, $room_id);
        } else {
            // If the file upload fails, update other room details without changing the room image path
            $sql = "UPDATE rooms SET room_Type=?, room_Capacity=?, room_Available=?, room_Amenities=?, room_Rate=? WHERE room_id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sissii", $room_Type, $room_Capacity, $room_Available, $room_Amenities, $room_Rate, $room_id);
        }
    } else {
        // If no new image is uploaded, update other room details without changing the room image path
        $sql = "UPDATE rooms SET room_Type=?, room_Capacity=?, room_Available=?, room_Amenities=?, room_Rate=? WHERE room_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissii", $room_Type, $room_Capacity, $room_Available, $room_Amenities, $room_Rate, $room_id);
    }

    if ($stmt->execute()) {
        // Redirect to dashboard.html after successful update
        header("Location: dashboard.html");
        exit(); // Ensure that no further code is executed after redirection
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
