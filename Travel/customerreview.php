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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
     <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #8e44ad;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #8e44ad;
            color: white;
        }

        tr:hover {
            background-color: #f1e1f5;
        }

        .rating {
            color: gold;
            font-size: 18px;
        }
    </style>
</head>
<body>
<section class="header">

<a href="home.php" class="logo">Travel</a>

<nav class="navbar">
<a href="admin.php">Home</a>
        <a href="adminpackage.php">package</a>
        <a href="customerreview.php">traveller Review</a>
        <a href="PackageDetail.php">Package Details</a>

</nav>




<!-- header section ends -->



<div id="menu-btn" class="fas fa-bars"></div>

</section>

<br><br>
<h1>Traveler Reviews</h1>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Comment</th>
            <th>Role</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Include database connection
        

        $sql = "SELECT name, comment, rating FROM reviews ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
                echo "<td>Traveler</td>";
                echo "<td class='rating'>" . str_repeat("⭐", $row['rating']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center;'>No reviews yet.</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>
</table>

</body>
</html>