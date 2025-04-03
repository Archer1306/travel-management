<?php
$connection = mysqli_connect('localhost', 'root', '', 'book_db');

// Start the session
session_start();

// Fetch the logged-in customer's name (assuming session contains 'customer_name')
$customer_name = isset($_SESSION['customer_name']) ? $_SESSION['customer_name'] : 'Guest';

// Handle Delete Request
$message = '';
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM book_form WHERE id = $id";
    if (mysqli_query($connection, $delete_query)) {
        $message = "Record deleted successfully.";
    } else {
        $message = "Failed to delete record.";
    }
}

// Handle Update Request
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $location = $_POST['location'];
    $guests = $_POST['guests'];
    $arrivals = $_POST['arrivals'];
    $leaving = $_POST['leaving'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $vehicle = $_POST['vehicle'];
    $hotel = $_POST['hotel'];
    $menu = $_POST['menu'];

    $update_query = "UPDATE book_form SET 
        name='$name', email='$email', phone='$phone', 
        address='$address', location='$location', 
        guests='$guests', arrivals='$arrivals', leaving='$leaving',
        type='$type', price='$price', vehicle='$vehicle',
        hotel='$hotel', menu='$menu'
        WHERE id = $id";

    if (mysqli_query($connection, $update_query)) {
        $message = "Record updated successfully.";
    } else {
        $message = "Failed to update record.";
    }
}

// Fetch All Records
$query = "SELECT * FROM book_form";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Additional styles specific to bookinghistory.php */
        .booking-history {
            padding: 3rem 2%;
            overflow: hidden;
        }

        .booking-history h1 {
            text-align: center;
            font-size: 3rem;
            color: var(--black);
            margin-bottom: 2rem;
            padding: 0 1rem;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            background: white;
            padding: 1rem;
        }

        .booking-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 1400px; /* Increased minimum width */
        }

        .booking-table thead th {
            position: sticky;
            top: 0;
            background: var(--main-color);
            color: white;
            font-weight: 600;
            z-index: 10;
        }

        .booking-table th,
        .booking-table td {
            padding: 1.2rem 1.5rem;
            text-align: left;
            font-size: 1.5rem;
            white-space: nowrap;
            border-bottom: 1px solid #e0e0e0;
            min-width: 150px; /* Minimum column width */
        }

        .booking-table td {
            background: white;
            vertical-align: middle;
        }

        .booking-table tr:hover td {
            background-color: #f5f5f5;
        }

        /* Column-specific widths */
        .booking-table th:nth-child(1), 
        .booking-table td:nth-child(1) { width: 80px; } /* ID */
        .booking-table th:nth-child(2), 
        .booking-table td:nth-child(2) { width: 180px; } /* Name */
        .booking-table th:nth-child(3), 
        .booking-table td:nth-child(3) { width: 220px; } /* Email */
        .booking-table th:nth-child(4), 
        .booking-table td:nth-child(4) { width: 150px; } /* Phone */
        .booking-table th:nth-child(5), 
        .booking-table td:nth-child(5) { width: 200px; } /* Address */
        .booking-table th:nth-child(6), 
        .booking-table td:nth-child(6) { width: 150px; } /* Location */
        .booking-table th:nth-child(7), 
        .booking-table td:nth-child(7) { width: 100px; } /* Guests */
        .booking-table th:nth-child(8), 
        .booking-table td:nth-child(8) { width: 120px; } /* Arrivals */
        .booking-table th:nth-child(9), 
        .booking-table td:nth-child(9) { width: 120px; } /* Leaving */
        .booking-table th:nth-child(10), 
        .booking-table td:nth-child(10) { width: 120px; } /* Type */
        .booking-table th:nth-child(11), 
        .booking-table td:nth-child(11) { width: 100px; } /* Price */
        .booking-table th:nth-child(12), 
        .booking-table td:nth-child(12) { width: 120px; } /* Vehicle */
        .booking-table th:nth-child(13), 
        .booking-table td:nth-child(13) { width: 120px; } /* Hotel */
        .booking-table th:nth-child(14), 
        .booking-table td:nth-child(14) { width: 120px; } /* Menu */
        .booking-table th:nth-child(15), 
        .booking-table td:nth-child(15) { width: 150px; } /* Actions */

        .action-icons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .action-icons i {
            cursor: pointer;
            font-size: 1.8rem;
            transition: all 0.3s ease;
        }

        .action-icons i:hover {
            transform: scale(1.1);
        }

        .fa-edit { color: #4CAF50; }
        .fa-save { color: #2196F3; }
        .fa-trash { color: #f44336; }

        .message {
            text-align: center;
            padding: 1.2rem;
            margin: 1rem auto 2rem;
            font-size: 1.6rem;
            color: white;
            border-radius: 0.5rem;
            max-width: 800px;
        }

        .success { background: #4CAF50; }
        .error { background: #f44336; }

        .booking-table input[type="text"],
        .booking-table input[type="email"],
        .booking-table input[type="number"],
        .booking-table input[type="date"],
        .booking-table select {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 0.4rem;
            font-size: 1.4rem;
            background: white;
            box-sizing: border-box;
        }

        .booking-table select {
            padding: 0.8rem 0.6rem;
        }

        .booking-table button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        /* Custom scrollbar */
        .table-wrapper::-webkit-scrollbar {
            height: 12px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 6px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: var(--main-color);
            border-radius: 6px;
            border: 2px solid #f1f1f1;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .booking-history {
                padding: 2rem 1%;
            }
            
            .booking-history h1 {
                font-size: 2.4rem;
            }
            
            .table-wrapper {
                padding: 0.5rem;
            }
            
            .booking-table th,
            .booking-table td {
                padding: 1rem;
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>

<!-- Header Section -->
<section class="header">
    <a href="home.php" class="logo">Travel</a>
    <nav class="navbar">
        <a href="adminpackage.php">package</a>
        <a href="customerreview.php">traveller Review</a>
        <a href="PackageDetail.php">Package Details</a>
        <a href="home.php">BACK TO HOME</a>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
</section>

<!-- Booking History Section -->
<section class="booking-history">
    <h1>Booking History</h1>

    <!-- Display Message -->
    <?php if ($message): ?>
        <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Scrollable Table Container -->
    <div class="table-wrapper">
        <table class="booking-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Location</th>
                    <th>Guests</th>
                    <th>Arrivals</th>
                    <th>Leaving</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Vehicle</th>
                    <th>Hotel</th>
                    <th>Menu</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr id="row-<?php echo $row['id']; ?>">
                            <form method="post" id="form-<?php echo $row['id']; ?>">
                                <td><?php echo $row['id']; ?></td>
                                <td><input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" disabled></td>
                                <td><input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" disabled></td>
                                <td><input type="text" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" disabled></td>
                                <td><input type="text" name="address" value="<?php echo htmlspecialchars($row['address']); ?>" disabled></td>
                                <td><input type="text" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" disabled></td>
                                <td><input type="number" name="guests" value="<?php echo htmlspecialchars($row['guests']); ?>" disabled></td>
                                <td><input type="date" name="arrivals" value="<?php echo htmlspecialchars($row['arrivals']); ?>" disabled></td>
                                <td><input type="date" name="leaving" value="<?php echo htmlspecialchars($row['leaving']); ?>" disabled></td>
                                <td><input type="text" name="type" value="<?php echo htmlspecialchars($row['type']); ?>" disabled></td>
                                <td><input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" disabled></td>
                                <td>
                                    <select name="vehicle" disabled>
                                        <option value="Economy" <?php echo $row['vehicle'] == 'Economy' ? 'selected' : ''; ?>>Economy</option>
                                        <option value="Comfort" <?php echo $row['vehicle'] == 'Comfort' ? 'selected' : ''; ?>>Comfort</option>
                                        <option value="Luxury" <?php echo $row['vehicle'] == 'Luxury' ? 'selected' : ''; ?>>Luxury</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="hotel" disabled>
                                        <option value="3 Star" <?php echo $row['hotel'] == '3 Star' ? 'selected' : ''; ?>>3 Star</option>
                                        <option value="4 Star" <?php echo $row['hotel'] == '4 Star' ? 'selected' : ''; ?>>4 Star</option>
                                        <option value="5 Star" <?php echo $row['hotel'] == '5 Star' ? 'selected' : ''; ?>>5 Star</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="menu" disabled>
                                        <option value="Basic" <?php echo $row['menu'] == 'Basic' ? 'selected' : ''; ?>>Basic</option>
                                        <option value="Standard" <?php echo $row['menu'] == 'Standard' ? 'selected' : ''; ?>>Standard</option>
                                        <option value="Premium" <?php echo $row['menu'] == 'Premium' ? 'selected' : ''; ?>>Premium</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="action-icons">
                                        <button type="button" onclick="enableEditing(<?php echo $row['id']; ?>)" class="update">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="submit" name="save" class="save" style="display: none;">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <a href="admin.php?delete=<?php echo $row['id']; ?>" 
                                           onclick="return confirm('Are you sure you want to delete this record?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="15" style="text-align: center; padding: 2rem;">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Footer Section -->
<section class="footer">
    <div class="box-container">
        <div class="box">
            <h3>quick links</h3>
            <a href="home.php"> <i class="fas fa-angle-right"></i> home</a>
            <a href="about.php"> <i class="fas fa-angle-right"></i> about</a>
            <a href="package.php"> <i class="fas fa-angle-right"></i> package</a>
            <a href="book.php"> <i class="fas fa-angle-right"></i> book</a>
        </div>
        <div class="box">
            <h3>extra links</h3>
            <a href="#"> <i class="fas fa-angle-right"></i> ask questions</a>
            <a href="#"> <i class="fas fa-angle-right"></i> about us</a>
            <a href="#"> <i class="fas fa-angle-right"></i> privacy policy</a>
            <a href="#"> <i class="fas fa-angle-right"></i> terms of use</a>
        </div>
        <div class="box">
            <h3>contact info</h3>
            <a href="#"> <i class="fas fa-phone"></i> +123-456-7890 </a>
            <a href="#"> <i class="fas fa-phone"></i> +111-222-3333 </a>
            <a href="#"> <i class="fas fa-envelope"></i> travel@gmail.com </a>
            <a href="#"> <i class="fas fa-map"></i> Chennai, india - 600019 </a>
        </div>
        <div class="box">
            <h3>follow us</h3>
            <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
            <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
            <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
            <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
        </div>
    </div>
    <div class="credit"> created by <span>Aswin S</span> | all rights reserved! </div>
</section>

<!-- JavaScript for Enabling Editing -->
<script>
function enableEditing(id) {
    const row = document.getElementById(`row-${id}`);
    const inputs = row.querySelectorAll('input');
    const selects = row.querySelectorAll('select');
    const saveButton = row.querySelector('.save');
    const updateButton = row.querySelector('.update');

    inputs.forEach(input => {
        input.disabled = false;
        input.style.backgroundColor = '#fff9c4'; // Highlight editable fields
    });
    selects.forEach(select => {
        select.disabled = false;
        select.style.backgroundColor = '#fff9c4'; // Highlight editable fields
    });
    saveButton.style.display = 'inline-block';
    updateButton.style.display = 'none';
    
    // Scroll to the row being edited
    row.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
}
</script>

</body>
</html>