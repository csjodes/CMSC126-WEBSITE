<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .room-image {
        width: 80px;
        height: 80px;
        display: block;
        margin: 0 auto;
    }

    .success-message {
        background-color: lightgreen;
        color: green;
        padding: 10px;
        text-align: center;
    }

    button.edit {
        padding: 1px 10px;
        border-radius: 5px;
        background-color: lightblue;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        margin-right: 5px;
    }

    button.edit:hover {
        background-color: blue;
        color: lightblue;
    }

    button.delete {
        padding: 1px 10px;
        border-radius: 5px;
        background-color: lightcoral;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    button.delete:hover {
        background-color: red;
        color: white;
    }

    .room-amenities ul {
        padding-left: 20px;
    }
  </style>
</head>
<body>
  <?php
    if (isset($_GET['success']) && $_GET['success'] === 'deleted') {
        echo "<div class='success-message'>Room deleted successfully.</div>";
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "siquijordb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM rooms";
    $result = $conn->query($sql);

    echo "<table>";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['room_id'] . "</td>";
            echo "<td>" . $row['room_Type'] . "</td>";
            echo "<td>" . $row['room_Capacity'] . "</td>";
            echo "<td>" . $row['room_Available'] . "</td>";
            echo "<td class='room-amenities'><ul>";
            $amenities_array = explode(",", $row['room_Amenities']);
            foreach ($amenities_array as $amenity) {
                echo "<li>" . trim($amenity) . "</li>";
            }
            echo "</ul></td>";
            echo "<td>" . $row['room_Rate'] . "</td>";
            echo "<td><img class='room-image' src='" . $row['room_Image'] . "' alt='Room Image'></td>";
            echo "<td>
                    <button class='edit' onclick='editRoom(" . $row['room_id'] . ")'>Edit</button>
                    <form action='delete.php' method='POST' style='display:inline-block;'>
                        <input type='hidden' name='room_id' value='" . $row['room_id'] . "'>
                        <button type='submit' class='delete' name='delete-btn'>Delete</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>0 results</td></tr>";
    }

    echo "</table>";

    $conn->close();
  ?>

  <script>
    function editRoom(roomId) {
        window.location.href = 'edit.html?room_id=' + roomId;
    }
  </script>
</body>
</html>
