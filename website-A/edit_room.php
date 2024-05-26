<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "siquijordb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    $sql = "SELECT * FROM rooms WHERE room_id = '$room_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No room found with the given ID.";
        exit;
    }
} else {
    echo "Room ID is required.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="logo icon" type="logo" href="img/new logo.png">
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="css/create.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <title>Edit Room</title>
</head>
<body>
  <header>
    <img id="logo" src="img/logo1.png" alt="Company Logo">
    <div class="border"></header>
  </div>
  <nav>
    <ul>
      <li>
        <a class="logo">
          <img src="img/new logo.png" alt="">
          <span class="nav-item">VillaStar</span>
        </a>
      </li>
      <li>
        <a href="dashboard.php">
          <i class="fas fa-chart-bar"></i>
          <span class="nav-item">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="create.html">
          <i class="fas fa-plus"></i>
          <span class="nav-item">Add Room</span>
        </a>
      </li>
    </ul>
  </nav>

  <div class="create-container">
    <form id="edit-room-form" action="update.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" id="room_id" name="room_id" value="<?php echo htmlspecialchars($row['room_id']); ?>" required>

      <label for="roomType">Room Type:</label>
      <select id="roomType" name="roomType" required>
        <option value="Single Room" <?php echo ($row['room_Type'] == 'Single Room') ? 'selected' : ''; ?>>Single Room</option>
        <option value="Twin Room" <?php echo ($row['room_Type'] == 'Twin Room') ? 'selected' : ''; ?>>Twin Room</option>
        <option value="Beachside Room" <?php echo ($row['room_Type'] == 'Beachside Room') ? 'selected' : ''; ?>>Beachside Room</option>
        <option value="Deluxe Room" <?php echo ($row['room_Type'] == 'Deluxe Room') ? 'selected' : ''; ?>>Deluxe Room</option>
        <option value="Villa" <?php echo ($row['room_Type'] == 'Villa') ? 'selected' : ''; ?>>Villa</option>
      </select>

      <label for="roomCapacity">Room Capacity:</label>
      <input type="number" id="roomCapacity" name="roomCapacity" value="<?php echo htmlspecialchars($row['room_Capacity']); ?>" required>

      <label for="roomAvailable">Room Available:</label>
      <select id="roomAvailable" name="roomAvailable" required>
        <option value="AVAILABLE" <?php echo ($row['room_Available'] == 'AVAILABLE') ? 'selected' : ''; ?>>Available</option>
        <option value="RESERVED" <?php echo ($row['room_Available'] == 'RESERVED') ? 'selected' : ''; ?>>Reserved</option>
      </select>

      <div class="choice-box">
        <label for="roomAmenities">Amenities (Check all that apply):</label>
        <div class="amenities">
          <?php
          $amenities = explode(',', $row['room_Amenities']);
          $allAmenities = ['Air Conditioning', 'Free WiFi', 'TV', 'Mini Bar', 'Coffee Maker'];
          foreach ($allAmenities as $amenity) {
              $checked = in_array($amenity, $amenities) ? 'checked' : '';
              echo "<div><input type='checkbox' id='amenities' name='amenities[]' value='$amenity' $checked>$amenity</div>";
          }
          ?>
        </div>
      </div>

      <label for="roomRate">Room Rate:</label>
      <input type="number" id="roomRate" name="roomRate" value="<?php echo htmlspecialchars($row['room_Rate']); ?>" required>

      <label for="roomImage">Room Image:</label>
      <input type="file" id="roomImage" name="roomImage">

      <button type="submit" class="save">Save Changes</button>
    </form>
  </div>

  <script>
    document.getElementById('edit-room-form').addEventListener('submit', function(event) {
        var amenities = document.getElementsByName('amenities[]');
        var checked = false;
        for (var i = 0; i < amenities.length; i++) {
            if (amenities[i].checked) {
                checked = true;
                break;
            }
        }
        if (!checked) {
            alert('Please select at least one amenity.');
            event.preventDefault();
        }
    });
  </script>
</body>
</html>
