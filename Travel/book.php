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

</head>
<body>
   
<section class="header">
   <a href="home.php" class="logo">travel.</a>
   <nav class="navbar">
      <a href="home.php">home</a>
      <a href="about.php">about</a>
      <a href="package.php">package</a>
      <a href="book.php">book</a>
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
            <input type="text" id="location" name="location" required>
         </div>
         <div class="inputBox">
            <span>How Many:</span>
            <input type="number" placeholder="Number of guests" name="guests" required>
         </div>
         <div class="inputBox">
            <span>Arrivals:</span>
            <input type="date" id="arrivals" name="arrivals" required>
         </div>
         <div class="inputBox">
            <span>Leaving:</span>
            <input type="date" id="leaving" name="leaving" required oninput="validateDates()">
            <span id="dateError" style="color: red; font-size: 0.9rem;"></span>
         </div>
         <div class="inputBox">
            <span>Type:</span>
            <input type="text" id="type" name="type" required>
         </div>
         <div class="inputBox">
            <span>Price:</span>
            <input type="number" id="price" name="price" required>
         </div>
      </div>
      <input type="hidden" name="package_id" id="package_id">
      <input type="submit" value="Submit" class="btn" name="send">
   </form>
</section>

<script>
// ✅ JavaScript to Auto-Fill Fields from URL
window.onload = function() {
    let urlParams = new URLSearchParams(window.location.search);
    let packageId = urlParams.get("package_id");
    let type = urlParams.get("type");
    let price = urlParams.get("price");
    let location = urlParams.get("location");

    if (packageId) document.getElementById("package_id").value = packageId;
    if (type) document.getElementById("type").value = decodeURIComponent(type);
    if (price) document.getElementById("price").value = price;
    if (location) document.getElementById("location").value = decodeURIComponent(location);
};

// ✅ Validate Dates (Prevent Past Dates & Invalid Leaving Date)
function validateDates() {
    let arrival = document.getElementById("arrivals").value;
    let leaving = document.getElementById("leaving").value;
    let errorSpan = document.getElementById("dateError");

    if (arrival && leaving && leaving < arrival) {
        errorSpan.innerText = "Leaving date must be after arrival date.";
        document.getElementById("leaving").value = "";
    } else {
        errorSpan.innerText = "";
    }
}

// ✅ Prevent past dates for arrival
document.getElementById("arrivals").setAttribute("min", new Date().toISOString().split("T")[0]);
</script>

<script>
   function validateDates() {
      const arrivalDate = document.getElementById("arrivals").value;
      const leavingDate = document.getElementById("leaving").value;
      const errorSpan = document.getElementById("dateError");

      if (arrivalDate && leavingDate && new Date(leavingDate) <= new Date(arrivalDate)) {
         errorSpan.textContent = "Leaving date must be later than the arrival date.";
      } else {
         errorSpan.textContent = "";
      }
   }
</script>

</body>
</html>