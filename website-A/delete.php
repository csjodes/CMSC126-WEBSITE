<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the room ID from the POST parameters
    $roomId = $_POST['room_id'];

    // Prepare a DELETE statement
    $sql = "DELETE FROM rooms WHERE room_id = ?";

    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        // Log error if preparation fails
        error_log("Prepare failed: " . $conn->error);
        http_response_code(500);
        echo json_encode(array("message" => "Prepare failed."));
        exit();
    }
    $stmt->bind_param("i", $roomId);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if any row was affected
        if ($stmt->affected_rows > 0) {
            // Return a success message
            http_response_code(200);
            echo json_encode(array("message" => "Row deleted successfully."));
        } else {
            // No row was affected
            http_response_code(404);
            echo json_encode(array("message" => "No rows were deleted."));
        }
    } else {
        // Log error if execution fails
        error_log("Execute failed: " . $stmt->error);
        http_response_code(500);
        echo json_encode(array("message" => "Failed to delete row."));
    }

    // Close the statement
    $stmt->close();
} else {
    // Return an error message if the request method is not POST
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
}

// Close connection
$conn->close();
?>
