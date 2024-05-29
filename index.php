<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="logo icon" type="logo" href="img/new logo.png">
  <link rel="stylesheet" href="css/booking.css">
  <link rel="stylesheet" href="css/draft.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer">
  <title>VILLASTAR</title>
  <style>
    .sticky {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }
    .navbar {
      background-color: #f4eeed;
      height: 70px;
      display: flex;
      align-items: center;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
      padding: 0 40px;
    }
    .company-name {
      flex: 1;
      color: #74775a;
      font-size: 18px;
      font-weight: bold;
    }
    .border {
      height: 1px;
      width: 100%;
      margin: 0 auto;
      display: block;
      background-color: #999b84;
      top: 1;
    }
    .main-container {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
      height: 100%;
      margin-top: 120px;
    }
    .container2 {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      min-height: 100vh;
      padding: 20px;
    }
    .left-tabs {
      display: flex;
      flex-wrap: wrap;
      margin-top: 20px;
    }
    .tabs_radio {
      display: none;
    }
    .tabs_label {
      padding: 10px 16px;
      cursor: pointer;
      color: #74775A;
    }
    .tabs_content {
      color: #74775A;
      margin-top: 10px;
      order: 1;
      width: 100%;
      line-height: 1.5;
      font-size: 0.9em;
      display: none;
    }
    .card {
      display: flex;
      margin-bottom: 20px;
      border: 1px solid #74775A;
      border-radius: 5px;
      overflow: hidden;
      background-color: #fff;
      color: #74775A;
      font-size: 16px;
      position: relative;
    }
    .card-img {
      width: 400px;
      height: 300px;
      object-fit: cover;
    }
    .card-text {
      padding: 5px 0px 0 15px;
    }
    .pname {
      margin: 5px 0;
      color: #74775A;
    }
    .price {
      margin: 5px 0;
      color: #74775A;
    }
    .column-right1 {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .book-button {
      background-color: #74775A;
      color: #fff;
      border: none;
      padding: 8px 15px;
      border-radius: 20px;
      cursor: pointer;
      margin-top: 10px;
    }
    .book-button:hover {
      background-color: #b0b67a;
    }
  </style>
</head>
<body>  

<div class="sticky">
  <div class="navbar">
    <div class="company-name"><a href="index.php"><img id="logo" src="img/logo1.png"></a></div>
  </div>
  <div class="border"></div>
</div>

<div class="main-container">
  <section class="container2">
    <header id="title">White Villas Resort</header>
    <p class="desc1">Search for a room that fits your needs!</p>

    <form action="index.php" method="GET" class="form">
      <div class="column center-align">
        <div class="input-box program">
          <div class="select-box">
            <select id="select1" name="room_type" required>
              <option hidden>Room Type</option>
              <option value="Single Room">Single Room</option>
              <option value="Twin Room">Twin Room</option>
              <option value="Beachside Room">Beachside Room</option>
              <option value="Deluxe Room">Deluxe Room</option>
              <option value="Villa">Villa</option>
            </select>
          </div>
        </div>
      </div>
      <div class="column center-align">
        <input class="buttons search-button" type="submit" value="Search for Rooms"/>
      </div>
    </form>

    <div class="border"></div>

    <div class="left-tabs">
      <input type="radio" class="tabs_radio" name="tabs-example" id="tab1" checked>
      <label for="tab1" class="tabs_label">Room choices</label>
      <div class="tabs_content">
      <?php include 'read.php'; ?>
      </div>
    </div>
  </section>
</div>
</body>
</html>
