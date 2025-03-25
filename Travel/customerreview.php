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

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql = "DELETE FROM reviews WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit; // Prevents form resubmission
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
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

        .delete-icon {
            color: red;
            cursor: pointer;
            text-decoration: none;
        }

        /* Modal Styles */
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
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 300px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .modal-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-confirm {
            background: #8e44ad;
            color: white;
        }

        .btn-cancel {
            background: #ddd;
            color: black;
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
            <th>Action</th> <!-- New column for delete action -->
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT id, name, comment, rating FROM reviews ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
                echo "<td>Traveler</td>";
                echo "<td class='rating'>" . str_repeat("⭐", $row['rating']) . "</td>";
                echo "<td><button class='delete-icon' onclick='showModal(" . $row['id'] . ")'>🗑️</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No reviews yet.</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>
</table>

<!-- Modal -->
<div class="modal" id="deleteModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirm Delete</h3>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <p>Are you sure you want to delete this review?</p>
        <div class="modal-buttons">
            <button class="btn btn-confirm" id="confirmDelete">Yes, Delete</button>
            <button class="btn btn-cancel" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
    let deleteId = null;

    function showModal(id) {
        deleteId = id;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeModal() {
        deleteId = null;
        document.getElementById('deleteModal').style.display = 'none';
    }

    document.getElementById('confirmDelete').addEventListener('click', function () {
        if (deleteId !== null) {
            window.location.href = `?delete_id=${deleteId}`;
        }
    });
</script>

</body>
</html>
