<?php
// Establishing connection to the database
$servername = "localhost"; // Assuming your database is hosted locally
$username = ""; // Replace with your MySQL username if applicable
$password = ""; // Replace with your MySQL password if applicable
$dbname = "siquijordb"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$room_id = "";
$room_type = "";
$room_capacity = "";
$room_available = "";
$room_amenities = "";
$room_rate = "";
$error_message = "";

// Retrieving form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = $_POST['room_id'];
    $room_type = $_POST['roomType'];
    $room_capacity = $_POST['roomCapacity'];
    $room_available = $_POST['roomAvailable'];
    $room_rate = $_POST['roomRate'];

    // Check if roomAmenities is set and not empty
    if (isset($_POST['roomAmenities']) && !empty($_POST['roomAmenities'])) {
        $room_amenities = implode(',', $_POST['roomAmenities']); // Convert array to string
    } else {
        $room_amenities = ''; // If no amenities are selected, set as an empty string
    }

    // Check if the room ID already exists
    $check_sql = "SELECT room_id FROM rooms WHERE room_id = '$room_id'";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        $error_message = "Error: Room ID already exists. Please choose a different Room ID.";
    } else {
        // Prepare SQL statement
        $sql = "INSERT INTO rooms (room_id, room_type, room_capacity, room_available, room_amenities, room_rate) 
                VALUES ('$room_id', '$room_type', '$room_capacity', '$room_available', '$room_amenities', '$room_rate')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "New record created successfully";
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Room</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=NTR&display=swap');
        body {
            font-family: 'NTR';
            background-color: #f4eeed;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            line-height: 1.0;
            color: #000;
        }
        .success-message {
            color: black;
            font-weight: bold;
            font-size: 28px;
            border: 2px solid green;
            padding: 20px;
            text-align: center;
        }
        .error-message {
            color: black;
            font-weight: bold;
            font-size: 28px;
            border: 2px solid red;
            padding: 20px;
            text-align: center;
        }
        .new {
            font-size: 26px;
            color: #000;
            margin-bottom: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            color: #000;
            font-family: 'NTR';
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        .first-row {
            background-color: #f2f2f2;
        }
        #more-btn {
            padding: 10px 10px; /* Adjust padding for smaller height */
            border-radius: 10px;
            border: none;
            font-family: 'NTR';
            line-height: 1; /* Set line height to 1 for normal spacing */
            background-color: #737B4C;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            margin-top: 5px;
        }
        #more-btn:hover {
            background-color: #283100;
        }
    </style>
</head>
<body>
    <div>
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php elseif (!empty($success_message)): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
            <p class="new">New Room Created</p>
            <table>
                <tr class="first-row">
                    <td>Room ID</td>
                    <td>Room Type</td>
                    <td>Room Capacity</td>
                    <td>Room Available</td>
                    <td>Room Amenities</td>
                    <td>Room Rate</td>
                </tr>
                <tr>
                    <td><?php echo $room_id; ?></td>
                    <td><?php echo $room_type; ?></td>
                    <td><?php echo $room_capacity; ?></td>
                    <td><?php echo $room_available; ?></td>
                    <td><?php echo $room_amenities; ?></td>
                    <td><?php echo $room_rate; ?></td>
                </tr>
            </table>
        <?php endif; ?>

        <a href="create.html">
        <button type="button" id="more-btn">Create New Room</button>
        </a>
    </div>
</body>
</html>