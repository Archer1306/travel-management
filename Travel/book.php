<?php
// Start the session
session_start();

// Include your database configuration
include 'config.php';

// Get package details from URL parameters
$packageId = isset($_GET['package_id']) ? $_GET['package_id'] : '';
$type = isset($_GET['type']) ? urldecode($_GET['type']) : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$location = isset($_GET['location']) ? urldecode($_GET['location']) : '';
$vehicle = isset($_GET['vehicle']) ? urldecode($_GET['vehicle']) : '';
$hotel = isset($_GET['hotel']) ? urldecode($_GET['hotel']) : '';
$menu = isset($_GET['menu']) ? urldecode($_GET['menu']) : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// If coming from form submission, get from POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $packageId = isset($_POST['package_id']) ? $_POST['package_id'] : $packageId;
    $type = isset($_POST['type']) ? $_POST['type'] : $type;
    $price = isset($_POST['price']) ? $_POST['price'] : $price;
    $location = isset($_POST['location']) ? $_POST['location'] : $location;
    $vehicle = isset($_POST['vehicle']) ? $_POST['vehicle'] : $vehicle;
    $hotel = isset($_POST['hotel']) ? $_POST['hotel'] : $hotel;
    $menu = isset($_POST['menu']) ? $_POST['menu'] : $menu;
    $startDate = isset($_POST['arrivals']) ? $_POST['arrivals'] : $startDate;
    $endDate = isset($_POST['leaving']) ? $_POST['leaving'] : $endDate;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Book Your Trip</title>

   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .booking {
         max-width: 1200px;
         margin: 0 auto;
         padding: 2rem;
      }
      
      .book-form {
         background: #f9f9f9;
         padding: 2rem;
         border-radius: 10px;
         box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }
      
      .flex {
         display: flex;
         flex-wrap: wrap;
         gap: 1.5rem;
      }
      
      .inputBox {
         flex: 1 1 40rem;
      }
      
      .inputBox span {
         display: block;
         margin-bottom: 0.5rem;
         font-size: 1.1rem;
         color: #333;
      }
      
      .inputBox input, .inputBox select {
         width: 100%;
         padding: 1rem;
         font-size: 1rem;
         border: 1px solid #ddd;
         border-radius: 5px;
         margin-bottom: 1rem;
      }
      
      .inputBox input[readonly] {
         background-color: #f0f0f0;
         cursor: not-allowed;
      }
      
      .btn {
         display: inline-block;
         background: #6c5ce7;
         color: white;
         padding: 1rem 2rem;
         font-size: 1.1rem;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         margin-top: 1rem;
         transition: all 0.3s ease;
      }
      
      .btn:hover {
         background: #5649d1;
      }
      
      .heading-title {
         text-align: center;
         margin-bottom: 2rem;
         font-size: 2.5rem;
         color: #333;
      }
   </style>
</head>
<body>
   
<section class="header">
   <a href="home.php" class="logo">travel.</a>
   <nav class="navbar">
      <a href="home.php">home</a>
      <a href="about.php">about</a>
      <a href="package.php">package</a>
      <a href="bookinghistory.php">Booking History</a>
      <a href="login.php"><i class="fas fa-user"></i></a>
   </nav>
   <div id="menu-btn" class="fas fa-bars"></div>
</section>

<div class="heading" style="background:url(images/header-bg-3.png) no-repeat">
   <h1>book now</h1>
</div>

<section class="booking">
   <h1 class="heading-title">Book Your Trip!</h1>
   <form action="book_form.php" method="post" class="book-form">
      <div class="flex">
         <div class="inputBox">
            <span>Name:</span>
            <input type="text" placeholder="Enter your name" name="name" required>
         </div>
         <div class="inputBox">
            <span>Email:</span>
            <input type="email" placeholder="Enter your email" name="email" required>
         </div>
         <div class="inputBox">
            <span>Phone:</span>
            <input type="number" placeholder="Enter your number" name="phone" required>
         </div>
         <div class="inputBox">
            <span>Address:</span>
            <input type="text" placeholder="Enter your address" name="address" required>
         </div>
         <div class="inputBox">
            <span>Where To:</span>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>" readonly required>
         </div>
         <div class="inputBox">
            <span>How Many:</span>
            <input type="number" placeholder="Number of guests" name="guests" required>
         </div>
         <div class="inputBox">
            <span>Arrivals:</span>
            <input type="date" id="arrivals" name="arrivals" value="<?php echo htmlspecialchars($startDate); ?>" readonly required>
         </div>
         <div class="inputBox">
            <span>Leaving:</span>
            <input type="date" id="leaving" name="leaving" value="<?php echo htmlspecialchars($endDate); ?>" readonly required>
         </div>
         <div class="inputBox">
            <span>Type:</span>
            <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($type); ?>" readonly required>
         </div>
         <div class="inputBox">
            <span>Price:</span>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" readonly required>
         </div>
         <div class="inputBox">
            <span>Vehicle Type:</span>
            <input type="text" id="vehicle" name="vehicle" value="<?php echo htmlspecialchars($vehicle); ?>" readonly required>
         </div>
         <div class="inputBox">
            <span>Hotel Class:</span>
            <input type="text" id="hotel" name="hotel" value="<?php echo htmlspecialchars($hotel); ?>" readonly required>
         </div>
         <div class="inputBox">
            <span>Menu Type:</span>
            <input type="text" id="menu" name="menu" value="<?php echo htmlspecialchars($menu); ?>" readonly required>
         </div>
      </div>
      
      <input type="hidden" name="package_id" id="package_id" value="<?php echo htmlspecialchars($packageId); ?>">
      <input type="submit" value="Submit" class="btn" name="send">
   </form>
</section>

<script>
// JavaScript to Auto-Fill Fields from URL if not already set by PHP
window.onload = function() {
    let urlParams = new URLSearchParams(window.location.search);
    
    // Only set values if they're not already set by PHP
    if (!document.getElementById("location").value) {
        document.getElementById("location").value = decodeURIComponent(urlParams.get("location") || '');
    }
    if (!document.getElementById("type").value) {
        document.getElementById("type").value = decodeURIComponent(urlParams.get("type") || '');
    }
    if (!document.getElementById("price").value) {
        document.getElementById("price").value = urlParams.get("price") || '';
    }
    if (!document.getElementById("vehicle").value) {
        document.getElementById("vehicle").value = decodeURIComponent(urlParams.get("vehicle") || '');
    }
    if (!document.getElementById("hotel").value) {
        document.getElementById("hotel").value = decodeURIComponent(urlParams.get("hotel") || '');
    }
    if (!document.getElementById("menu").value) {
        document.getElementById("menu").value = decodeURIComponent(urlParams.get("menu") || '');
    }
    if (!document.getElementById("arrivals").value) {
        document.getElementById("arrivals").value = urlParams.get("start_date") || '';
    }
    if (!document.getElementById("leaving").value) {
        document.getElementById("leaving").value = urlParams.get("end_date") || '';
    }
    if (!document.getElementById("package_id").value) {
        document.getElementById("package_id").value = urlParams.get("package_id") || '';
    }
    
    // Make all readonly fields non-editable
    document.querySelectorAll('input[readonly]').forEach(input => {
        input.style.backgroundColor = '#f0f0f0';
        input.style.cursor = 'not-allowed';
    });
};
</script>

</body>
</html>