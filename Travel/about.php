<?php
include 'config.php'; // Include your database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $rating = intval($_POST['rating']); // Convert rating to integer

    // Insert the review into the database
    $sql = "INSERT INTO reviews (name, comment, rating, created_at) VALUES ('$name', '$comment', '$rating', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit; // Prevents form resubmission
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch latest 3 reviews from the database
$sql = "SELECT * FROM reviews ORDER BY created_at DESC LIMIT 3";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
       .modal {
           display: none;
           position: fixed;
           top: 0;
           left: 0;
           width: 100%;
           height: 100%;
           background: rgba(0, 0, 0, 0.5);
           justify-content: center;
           align-items: center;
           z-index: 1000;
       }

       .modal-content {
           background: white;
           padding: 30px;
           border-radius: 10px;
           width: 500px;
           text-align: center;
           position: relative;
           box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
           border-top: 5px solid #8e44ad; /* Adds a purple accent on top */
       }

       .close {
           position: absolute;
           top: 10px;
           right: 15px;
           cursor: pointer;
           font-size: 24px;
           color: #8e44ad;
       }

       .review-form {
           display: flex;
           flex-direction: column;
           gap: 15px;
       }

       .inputBox {
           text-align: left;
       }

       .inputBox span {
           font-size: 14px;
           font-weight: bold;
           display: block;
           margin-bottom: 5px;
           color: #8e44ad; /* Purple text for labels */
       }

       .inputBox input,
       .inputBox textarea,
       .inputBox select {
           width: 100%;
           padding: 10px;
           border: 1px solid #8e44ad;
           border-radius: 5px;
           font-size: 14px;
       }

       .inputBox input:focus,
       .inputBox textarea:focus,
       .inputBox select:focus {
           outline: none;
           border-color: #6d318c; /* Darker purple on focus */
           box-shadow: 0px 0px 5px rgba(142, 68, 173, 0.5);
       }

       .btn {
           background-color: #8e44ad;
           color: white;
           padding: 12px 20px;
           border: none;
           cursor: pointer;
           border-radius: 5px;
           font-size: 16px;
           transition: 0.3s;
       }

       .btn:hover {
           background-color: #6d318c; /* Darker purple on hover */
       }

       .review-container {
           display: flex;
           flex-direction: column;
           gap: 15px;
       }

       .review-box {
           display: flex;
           flex-direction: column;
           background-color: #fff;
           padding: 15px;
           border-radius: 5px;
           box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
       }

       .review-box h3 {
           margin: 0;
           font-size: 18px;
           color: #6d318c;
       }

       .review-box p {
           margin: 5px 0;
           font-size: 14px;
       }

       .review-box .rating {
           font-size: 16px;
           color: gold;
       }
   </style>
</head>
<body>

<!-- header section starts  -->
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
<!-- header section ends -->

<div class="heading" style="background:url(images/header-bg-1.png) no-repeat">
   <h1>about us</h1>
</div>

<!-- about section starts  -->
<section class="about">
   <div class="image">
      <img src="images/about-img.jpg" alt="">
   </div>

   <div class="content">
      <h3>why choose us?</h3>
      <p>We offer unforgettable travel experiences to the world's most stunning destinations. Our affordable pricing ensures you can explore without breaking the bank. With seamless planning and expert guidance, your journey will be stress-free and enjoyable. Our 24/7 customer support is always available to assist you. Book with us today and create memories that last a lifetime!</p>
      <div class="icons-container">
         <div class="icons">
            <i class="fas fa-map"></i>
            <span>top destinations</span>
         </div>
         <div class="icons">
            <i class="fas fa-hand-holding-usd"></i>
            <span>affordable price</span>
         </div>
         <div class="icons">
            <i class="fas fa-headset"></i>
            <span>24/7 guide service</span>
         </div>
      </div>
   </div>
</section>
<!-- about section ends -->

<!-- Add Review Button -->
<button class="btn" onclick="openModal()">Add Review</button>

<!-- Review Popup Modal -->
<div id="reviewModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h1 class="heading-title">Share Your Experience!</h1>

        <form action="" method="post" class="review-form">
            <div class="inputBox">
                <span>Name:</span>
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="inputBox">
                <span>Comment:</span>
                <textarea name="comment" placeholder="Write your review..." required></textarea>
            </div>
            <div class="inputBox">
                <span>Rating:</span>
                <select name="rating" required>
                    <option value="5">⭐⭐⭐⭐⭐ - Excellent</option>
                    <option value="4">⭐⭐⭐⭐ - Very Good</option>
                    <option value="3">⭐⭐⭐ - Good</option>
                    <option value="2">⭐⭐ - Fair</option>
                    <option value="1">⭐ - Poor</option>
                </select>
            </div>
            <input type="submit" value="Submit Review" class="btn">
        </form>
    </div>
</div>

<!-- Traveler Reviews Section -->
<section class="user-reviews">
    <h1 class="heading-title">Traveler Reviews</h1>

    <div class="review-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="review-box">';
            echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
            echo '<p>"' . htmlspecialchars($row['comment']) . '"</p>';
            echo '<p class="rating">' . str_repeat("⭐", $row['rating']) . '</p>';
            echo '</div>';
        }
    } else {
        echo "<p>No reviews yet. Be the first to review!</p>";
    }
    ?>
    </div>
</section>

<?php
$conn->close(); // Close the connection to the database
?>

<script>
    function openModal() {
        document.getElementById("reviewModal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("reviewModal").style.display = "none";
    }
</script>

</body>
</html>
