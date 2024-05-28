<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$msg = "";

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

// Initialize variables
$room_id = "";
$room_type = "";
$room_capacity = "";
$room_available = "";
$room_amenities = "";
$room_rate = "";
$room_image = "";

$error_message = "";
$success_message = "";

// Retrieving form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_id = $_POST['room_id'];
    $room_type = $_POST['roomType'];
    $room_capacity = $_POST['roomCapacity'];
    $room_available = $_POST['roomAvailable'];
    $room_rate = $_POST['roomRate'];

    // Check if roomAmenities is set and not empty
    if (isset($_POST['roomAmenities']) && !empty($_POST['roomAmenities'])) {
        $room_amenities = implode(",", $_POST['roomAmenities']); // Convert array to string
    } else {
        $room_amenities = ''; // If no amenities are selected, set as an empty string
    }

    // Validate negative values
    if ($room_id < 0 || $room_capacity <= 0 || $room_rate <= 0) {
        if ($room_id < 0) {
            $error_message .= "Room ID cannot be negative.<br>";
        }
        if ($room_capacity <= 0) {
            $error_message .= "Room Capacity cannot be negative or equal to 0.<br>";
        }
        if ($room_rate <= 0) {
            $error_message .= "Room Rate cannot be negative or equal to 0.<br>";
        }
    } else {
        // Check if the room ID already exists
        $check_sql = "SELECT room_id FROM rooms WHERE room_id = '$room_id'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            $error_message = "Error: Room ID already exists. Please choose a different Room ID.";
        } else {
            if (isset($_FILES['roomImage']) && $_FILES['roomImage']['error'] === UPLOAD_ERR_OK) {
                $filename = $_FILES["roomImage"]["name"];
                $tempname = $_FILES["roomImage"]["tmp_name"];
                $filesize = $_FILES["roomImage"]["size"];
                $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $folder = "./uploads/" . $filename;

                // Check file type
                $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
                if (!in_array($filetype, $allowed_types)) {
                    $error_message = "Error: Only JPG, JPEG, PNG, and WEBP files are allowed.";
                } elseif ($filesize > 2.5 * 1024 * 1024) {
                    // Check file size (2.5MB)
                    $error_message = "Error: File size should not exceed 2.5MB.";
                } else {
                    // Move the uploaded image into the folder: uploads
                    if (move_uploaded_file($tempname, $folder)) {
                        $room_image = $folder; // Store the image file path in the database
                    } else {
                        $error_message = "Failed to upload image!";
                    }
                }
            } else {
                $error_message = "Error: Image upload is required.";
            }

            if (empty($error_message)) {
                // Prepare SQL statement
                $sql = "INSERT INTO rooms (room_id, room_type, room_capacity, room_available, room_amenities, room_rate, room_image) 
                        VALUES ('$room_id', '$room_type', '$room_capacity', '$room_available', '$room_amenities', '$room_rate', '$room_image')";

                if ($conn->query($sql) === TRUE) {
                    $success_message = "New record created successfully";
                } else {
                    $error_message = "Error: " . $sql . "<br>" . $conn->error;
                }
            }
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
            color: #000;
            display: flex;
            justify-content: center;
            padding-top: -5px;
            margin: 0;
        }
        .container {
            width: 80%;
            max-width: 800px;
            padding: 20px;
            text-align: center;
        }
        .success-message, .error-message {
            color: black;
            font-weight: bold;
            font-size: 28px;
            padding: 20px;
            text-align: center;
        }
        .success-message {
            border: 2px solid green;
        }
        .error-message {
            border: 2px solid red;
        }
        .new {
            font-size: 26px;
            color: #000;
            margin-bottom: -10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            color: #000;
            font-family: 'NTR';
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        .first-row {
            background-color: #f2f2f2;
        }
        ul {
            padding-left: 20px;
            margin: 0;
        }
        li {
            margin-bottom: -10px; /* Adjust this value to control spacing */
            padding: 0;
        }
        a {
            text-decoration: none;
            color: inherit; /* This preserves the default text color */
        }
        .new-btn {
            margin-top: -10px;
        }
        .new-btn button {
            padding: 5px 20px;
            border-radius: 10px;
            border: none;
            font-family: 'NTR';
            background-color: #737B4C;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
        }
        .new-btn button:hover {
            background-color: #283100;
        }
        #see-dashboard-btn{
            background-color: #6C757D;
        }
        .room-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php elseif (!empty($success_message)): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
            <p class="new">New Room Added</p>
            <table>
                <tr class="first-row">
                    <td>Room ID</td>
                    <td>Room Type</td>
                    <td>Room Capacity</td>
                    <td>Room Available</td>
                    <td>Room Amenities</td>
                    <td>Room Rate</td>
                    <td>Room Image</td>
                </tr>
                <tr>
                    <td><?php echo htmlspecialchars($room_id); ?></td>
                    <td><?php echo htmlspecialchars($room_type); ?></td>
                    <td><?php echo htmlspecialchars($room_capacity); ?></td>
                    <td><?php echo htmlspecialchars($room_available); ?></td>
                    <td>
                        <ul>
                            <?php
                            // Split the room amenities string and display each amenity as a list item
                            $amenities_array = explode(",", $room_amenities);
                            foreach ($amenities_array as $amenity) {
                                echo "<li>" . htmlspecialchars(trim($amenity)) . "</li>";
                            }
                            ?>
                        </ul>
                    </td>
                    <td><?php echo htmlspecialchars($room_rate); ?></td>
                    <!-- Display the image -->
                    <td>
                    <img class="room-image" src="<?php echo htmlspecialchars($room_image); ?>" alt="Room Image">
                    </td>
                </tr>
            </table>
        <?php endif; ?>
        <br>
        <div class="new-btn">
            <a href="create.html">
                <button type="submit" id="more-btn">Create New Room</button>
            </a>
            <a href="dashboard.html">
                <button type="button" id="see-dashboard-btn">See Dashboard</button>
            </a>
        </div>

        
    </div>
</body>
</html>