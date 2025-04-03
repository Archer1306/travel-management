<?php 
include 'config.php'; // Database connection

// Initialize variables for messages
$message = '';
$message_type = '';

// Handle delete action
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    
    $sqlDelete = "DELETE FROM package WHERE id=?";
    $stmt = $conn->prepare($sqlDelete);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Package deleted successfully!";
            $message_type = "success";
        } else {
            $message = "Error deleting package: " . $stmt->error;
            $message_type = "error";
        }
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
        $message_type = "error";
    }
}

// Handle update action
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $details = $_POST['details'];
    $price = $_POST['price'];
    $places = $_POST['places'];
    $days = $_POST['days'];

    // Update query
    $sqlUpdate = "UPDATE package SET type=?, location=?, details=?, price=?, places=?, days=? WHERE id=?";
    $stmt = $conn->prepare($sqlUpdate);

    if ($stmt) {
        $stmt->bind_param("ssssssi", $type, $location, $details, $price, $places, $days, $id);
        if ($stmt->execute()) {
            $message = "Package updated successfully!";
            $message_type = "success";
        } else {
            $message = "Error updating package: " . $stmt->error;
            $message_type = "error";
        }
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
        $message_type = "error";
    }
}

// Fetch packages
$sql = "SELECT * FROM package ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Packages</title>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 95%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #8e44ad;
            margin-bottom: 20px;
        }
        .table-container {
            max-height: 600px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #8e44ad;
            color: white;
            position: sticky;
            top: 0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            width: 100px;
            height: 70px;
            border-radius: 5px;
            object-fit: cover;
        }
        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .actions button, .actions input[type="submit"] {
            background: #8e44ad;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        .actions button:hover, .actions input[type="submit"]:hover {
            background: #732d91;
        }
        .view-desc-btn {
            background: #3498db;
        }
        .view-desc-btn:hover {
            background: #2980b9;
        }
        .popup, .overlay {
            display: none;
        }
        .popup.active, .overlay.active {
            display: block;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .popup {
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
            max-height: 90vh;
            overflow-y: auto;
        }
        .popup h3 {
            margin-top: 0;
            color: #8e44ad;
            text-align: center;
        }
        .popup form, .popup .content {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .popup form label {
            font-weight: bold;
            margin-bottom: -10px;
        }
        .popup form input, .popup form textarea, .popup form button, .popup form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }
        .popup form textarea {
            min-height: 100px;
            resize: vertical;
        }
        .popup form button {
            background-color: #8e44ad;
            color: white;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        .popup form button:hover {
            background-color: #732d91;
        }
        .popup .button-group {
            display: flex;
            gap: 10px;
        }
        .popup .button-group button {
            flex: 1;
        }
        .popup .button-group button.cancel {
            background-color: #e74c3c;
        }
        .popup .button-group button.cancel:hover {
            background-color: #c0392b;
        }
        .message {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .desc-popup {
            max-width: 800px;
        }
        .desc-content {
            white-space: pre-wrap;
            line-height: 1.6;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        /* Scrollbar styling */
        .table-container::-webkit-scrollbar {
            width: 10px;
        }
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background: #8e44ad;
            border-radius: 5px;
        }
        .table-container::-webkit-scrollbar-thumb:hover {
            background: #732d91;
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

    <?php if (!empty($message)): ?>
        <div class="message <?php echo $message_type; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Places</th>
                    <th>Days</th>
                    <th>Price (₹)</th>
                    <th>Created At</th>
                    <th>Description</th>
                    <th>Details</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = !empty($row['image_path']) ? $row['image_path'] : 'image/default.png';
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id'], ENT_QUOTES) . "</td>";
                        echo "<td><img src='{$imagePath}' alt='Package Image'></td>";
                        echo "<td>" . htmlspecialchars($row['type'], ENT_QUOTES) . " Tour</td>";
                        echo "<td>" . htmlspecialchars($row['location'], ENT_QUOTES) . "</td>";
                        echo "<td>" . htmlspecialchars($row['places'], ENT_QUOTES) . "</td>";
                        echo "<td>" . htmlspecialchars($row['days'], ENT_QUOTES) . "</td>";
                        echo "<td>₹" . number_format($row['price'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at'], ENT_QUOTES) . "</td>";
                        echo "<td>" . (strlen($row['description']) > 50 ? substr(htmlspecialchars($row['description'], ENT_QUOTES), 0, 50) . '...' : htmlspecialchars($row['description'], ENT_QUOTES)) . "</td>";
                        echo "<td><button class='view-desc-btn' data-details='" . htmlspecialchars($row['details'], ENT_QUOTES) . "' data-description='" . htmlspecialchars($row['description'], ENT_QUOTES) . "'>View</button></td>";
                        echo "<td class='actions'>";
                        echo "<button class='edit-btn' 
                                data-id='{$row['id']}' 
                                data-type='{$row['type']}' 
                                data-location='{$row['location']}' 
                                data-places='{$row['places']}' 
                                data-days='{$row['days']}' 
                                data-price='{$row['price']}' 
                                data-details='{$row['details']}'
                                data-description='{$row['description']}'>Edit</button>";
                        echo "<form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this package?\");'>";
                        echo "<input type='hidden' name='id' value='{$row['id']}'>";
                        echo "<input type='submit' name='delete' value='Delete'>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No packages available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Package Popup -->
<div class="overlay" id="editOverlay"></div>
<div class="popup" id="editPopup">
    <div class="content">
        <h3>Edit Package</h3>
        <form method="POST">
            <input type="hidden" name="id" id="editId">
            <label>Type:</label>
            <input type="text" name="type" id="editType" required>
            
            <label>Location:</label>
            <input type="text" name="location" id="editLocation" required>
            
            <label>Places (comma separated):</label>
            <input type="text" name="places" id="editPlaces" required>
            
            <label>Days:</label>
            <input type="number" name="days" id="editDays" required min="1">
            
            <label>Price (₹):</label>
            <input type="number" name="price" id="editPrice" required step="0.01" min="0">
            
            <label>Description:</label>
            <textarea name="description" id="editDescription" required></textarea>
            
            <label>Details:</label>
            <textarea name="details" id="editDetails" required></textarea>
            
            <div class="button-group">
                <button type="submit" name="update">Update</button>
                <button type="button" class="cancel" onclick="hideEditPopup()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- View Description Popup -->
<div class="overlay" id="descOverlay"></div>
<div class="popup desc-popup" id="descPopup">
    <div class="content">
        <h3>Package Details</h3>
        <div class="desc-content" id="descDetails"></div>
        <div class="button-group">
            <button type="button" onclick="hideDescPopup()">Close</button>
        </div>
    </div>
</div>

<script>
    // Edit functionality
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('editId').value = this.getAttribute('data-id');
            document.getElementById('editType').value = this.getAttribute('data-type');
            document.getElementById('editLocation').value = this.getAttribute('data-location');
            document.getElementById('editPlaces').value = this.getAttribute('data-places');
            document.getElementById('editDays').value = this.getAttribute('data-days');
            document.getElementById('editPrice').value = this.getAttribute('data-price');
            document.getElementById('editDescription').value = this.getAttribute('data-description');
            document.getElementById('editDetails').value = this.getAttribute('data-details');

            document.getElementById('editOverlay').classList.add('active');
            document.getElementById('editPopup').classList.add('active');
        });
    });

    // View description functionality
    document.querySelectorAll('.view-desc-btn').forEach(button => {
        button.addEventListener('click', function() {
            const details = this.getAttribute('data-details');
            const description = this.getAttribute('data-description');
            
            let content = `<strong>Description:</strong><br>${description.replace(/\n/g, '<br>')}`;
            content += `<br><br><strong>Full Details:</strong><br>${details.replace(/\n/g, '<br>')}`;
            
            document.getElementById('descDetails').innerHTML = content;
            document.getElementById('descOverlay').classList.add('active');
            document.getElementById('descPopup').classList.add('active');
        });
    });

    function hideEditPopup() {
        document.getElementById('editOverlay').classList.remove('active');
        document.getElementById('editPopup').classList.remove('active');
    }

    function hideDescPopup() {
        document.getElementById('descOverlay').classList.remove('active');
        document.getElementById('descPopup').classList.remove('active');
    }

    // Close popups when clicking on overlay
    document.getElementById('editOverlay').addEventListener('click', hideEditPopup);
    document.getElementById('descOverlay').addEventListener('click', hideDescPopup);
</script>

</body>
</html>

<?php $conn->close(); ?>