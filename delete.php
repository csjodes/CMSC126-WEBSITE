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

// Check if the request method is DELETE
if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Get the room ID from the request parameters
    $roomId = $_GET['id'];

    // Prepare a DELETE statement
    $sql = "DELETE FROM rooms WHERE room_id = ?";

    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId);

    // Execute the statement
    if ($stmt->execute()) {
        // Return a success message
        echo json_encode(array("message" => "Row deleted successfully."));
    } else {
        // Return an error message
        http_response_code(500);
        echo json_encode(array("message" => "Failed to delete row."));
    }

    // Close the statement
    $stmt->close();
} else {
    // Return an error message if the request method is not DELETE
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
}

// Close connection
$conn->close();
?>
