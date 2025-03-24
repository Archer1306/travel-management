<?php
include 'config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $type = $_POST['type'];
        $location = $_POST['location'];
        $details = $_POST['details'];
        $price = $_POST['price'];
        $places = $_POST['places'];
        $days = $_POST['days'];

        $sqlUpdate = "UPDATE package SET type=?, location=?, details=?, price=?, places=?, days=? WHERE id=?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("ssssisi", $type, $location, $details, $price, $places, $days, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $sqlDelete = "DELETE FROM package WHERE id=?";
        $stmt = $conn->prepare($sqlDelete);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$sql = "SELECT * FROM package ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Packages</title>

    <!-- Swiper CSS link -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom CSS file link -->
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
        .actions {
            display: flex;
            gap: 10px;
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            z-index: 1000;
            width: 95%;
            max-width: 600px;
        }
        .popup.active {
            display: block;
        }
        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .popup-header h3 {
            margin: 0;
            font-size: 20px;
        }
        .close-btn {
            font-size: 25px;
            cursor: pointer;
            background: none;
            border: none;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }
        .overlay.active {
            display: block;
        }
        .popup form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .popup form label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .popup form input,
        .popup form textarea,
        .popup form button,
        .popup form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }
        .popup form textarea {
            resize: none;
            height: 100px;
        }
        .popup form button {
            background-color: #8e44ad;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        .popup form button:hover {
            background-color: #732d91;
        }
    </style>
</head>
<body>

<section class="header">
    <a href="home.php" class="logo">Travel</a>
    <nav class="navbar">
        <a href="admin.php">Home</a>
        <a href="adminpackage.php">Package</a>
        <a href="customerreview.php">Traveller Review</a>
        <a href="PackageDetail.php">Package Details</a>
    </nav>
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
                <th>Places</th>
                <th>Days</th>
                <th>Details</th>
                <th>Price (₹)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagePath = !empty($row['image_path']) ? $row['image_path'] : 'image/default.png';
                    echo "<tr>";
                    echo "<td><img src='{$imagePath}' alt='Package Image' onerror=\"this.onerror=null; this.src='image/default.png';\"></td>";
                    echo "<td>" . htmlspecialchars($row['type']) . " Tour</td>";
                    echo "<td><strong>" . htmlspecialchars($row['location']) . "</strong></td>";
                    echo "<td>" . nl2br(htmlspecialchars($row['places'])) . "</td>";
                    echo "<td>" . htmlspecialchars($row['days']) . "</td>";
                    echo "<td>" . nl2br(htmlspecialchars(wordwrap($row['details'], 100, "\n", true))) . "</td>";
                    echo "<td>₹" . number_format($row['price'], 2) . "</td>";
                    echo "<td class='actions'>";
                    echo "<button onclick=\"showUpdateForm({$row['id']}, '{$row['type']}', '{$row['location']}', '{$row['details']}', {$row['price']}, '{$row['places']}', {$row['days']})\"><i class='fas fa-edit'></i></button>";
                    echo "<form method='POST' style='display: inline;' onsubmit=\"return confirm('Are you sure you want to delete this package?')\">";
                    echo "<input type='hidden' name='id' value='{$row['id']}'>";
                    echo "<button type='submit' name='delete'><i class='fas fa-trash'></i></button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' style='text-align: center; font-weight: bold;'>No packages available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="overlay" id="overlay"></div>
<div class="popup" id="updatePopup">
    <div class="popup-header">
        <h3>Update Package Details</h3>
        <button class="close-btn" onclick="hideUpdateForm()">&times;</button>
    </div>
    <form method="POST">
        <input type="hidden" name="id" id="updateId">
        <label for="updateType">Type:</label>
        <input type="text" name="type" id="updateType" required>
        
        <label for="updateLocation">Location:</label>
        <input type="text" name="location" id="updateLocation" required>
        
        <label for="updatePlaces">Places (comma separated):</label>
        <textarea name="places" id="updatePlaces" required></textarea>
        
        <label for="updateDays">Days:</label>
        <input type="number" name="days" id="updateDays" min="1" required>
        
        <label for="updateDetails">Details:</label>
        <textarea name="details" id="updateDetails" required></textarea>
        
        <label for="updatePrice">Price (₹):</label>
        <input type="number" name="price" id="updatePrice" step="0.01" required>
        
        <button type="submit" name="update">Save Changes</button>
    </form>
</div>

<script>
    function showUpdateForm(id, type, location, details, price, places, days) {
        document.getElementById('overlay').classList.add('active');
        document.getElementById('updatePopup').classList.add('active');
        document.getElementById('updateId').value = id;
        document.getElementById('updateType').value = type;
        document.getElementById('updateLocation').value = location;
        document.getElementById('updateDetails').value = details;
        document.getElementById('updatePrice').value = price;
        document.getElementById('updatePlaces').value = places;
        document.getElementById('updateDays').value = days;
    }

    function hideUpdateForm() {
        document.getElementById('overlay').classList.remove('active');
        document.getElementById('updatePopup').classList.remove('active');
    }
</script>

</body>
</html>

<?php
$conn->close();
?>