<?php
include 'config.php'; // Include your database connection

$sql = "SELECT * FROM package ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Packages</title>
     <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }
        .container {
            width: 90%;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #8e44ad;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #8e44ad;
            color: white;
        }
        img {
            width: 100px;
            height: 70px;
            border-radius: 5px;
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


<div class="container">
    <h2>Available Travel Packages</h2>
    
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Type</th>
                <th>Location</th>
                <th>Details</th>
                <th>Price (₹)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagePath = !empty($row['image_path']) ? $row['image_path'] : 'images/default.png';
                    echo "<tr>";
                    echo "<td><img src='{$imagePath}' alt='Package Image' onerror=\"this.onerror=null; this.src='images/default.png';\"></td>";
                    echo "<td>" . htmlspecialchars($row['type']) . " Tour</td>";
                    echo "<td><strong>" . htmlspecialchars($row['location']) . "</strong></td>";
                    echo "<td>" . nl2br(htmlspecialchars(wordwrap($row['details'], 100, "\n", true))) . "</td>";
                    echo "<td>₹" . number_format($row['price'], 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align: center; font-weight: bold;'>No packages available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>