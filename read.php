<?php
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

// Fetch room type from GET request and sanitize it
$room_type = isset($_GET['room_type']) ? $conn->real_escape_string($_GET['room_type']) : '';

// Prepare SQL query with room availability filter
$sql = "SELECT * FROM rooms WHERE room_Available = 'AVAILABLE'";
if (!empty($room_type)) {
    $sql .= " AND room_Type LIKE '%$room_type%'";
}

// Execute query and get results
$result = $conn->query($sql);

// Check if results were found and display them
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="card">';
        echo '<img src="' . $row['room_Image'] . '" alt="' . $row['room_Type'] . '" class="card-img">';
        echo '<div class="card-text">';
        echo '<h3 class="pname">' . $row['room_Type'] . '</h3>';
        echo '<h3 class="price">₱ ' . $row['room_Rate'] . ' per night</h3>';
        echo '<table>';
        echo '<tr>';
        echo '<td>Amenities</td>';
        echo '<td>' . $row['room_Amenities'] . '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>Room Capacity</td>';
        echo '<td>' . $row['room_Capacity'] . ' PAX</td>';
        echo '</tr>';
        echo '</table>';
        echo '<button class="book-button">Select Room</button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "<p>No available rooms found</p>";
}

// Close database connection
$conn->close();
?>
