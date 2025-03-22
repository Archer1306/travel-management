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

    $update_query = "UPDATE book_form SET 
        name='$name', email='$email', phone='$phone', 
        address='$address', location='$location', 
        guests='$guests', arrivals='$arrivals', leaving='$leaving' 
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
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your main CSS file -->
    <style>
        /* Additional styles specific to bookinghistory.php */
        .booking-history {
            padding: 5rem 10%;
        }

        .booking-history h1 {
            text-align: center;
            font-size: 4rem;
            color: var(--black);
            margin-bottom: 3rem;
        }

        .booking-history table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .booking-history th,
        .booking-history td {
            border: var(--border);
            padding: 1.5rem;
            text-align: left;
            font-size: 1.6rem;
        }

        .booking-history th {
            background: var(--main-color);
            color: var(--white);
        }

        .booking-history tr:hover {
            background: var(--light-bg);
        }

        .booking-history .action-icons i {
            cursor: pointer;
            margin: 0 5px;
            font-size: 2rem;
        }

        .booking-history .delete {
            color: var(--main-color);
        }

        .booking-history .update {
            color: var(--black);
        }

        .booking-history .save {
            color: var(--main-color);
        }

        .booking-history .message {
            text-align: center;
            padding: 1rem;
            margin-bottom: 2rem;
            font-size: 1.8rem;
            color: var(--white);
            border-radius: 0.5rem;
        }

        .booking-history .success {
            background: var(--main-color);
        }

        .booking-history .error {
            background: var(--black);
        }

        .booking-history input[type="text"],
        .booking-history input[type="email"],
        .booking-history input[type="number"],
        .booking-history input[type="date"] {
            width: 100%;
            padding: 0.8rem;
            border: var(--border);
            border-radius: 0.5rem;
            font-size: 1.6rem;
        }

        .booking-history button {
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Header Section -->
<section class="header">
    <a href="home.php" class="logo">Travel</a>
    <nav class="navbar">
        <a href="home.php">home</a>
        <a href="adminpackage.php">package</a>
        <a href="customerreview.php">traveller Review</a>
        <a href="PackageDetail.php">Package Details</a>

       
        

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

    <!-- Booking Table -->
    <table>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr id="row-<?php echo $row['id']; ?>">
                        <form method="post" id="form-<?php echo $row['id']; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><input type="text" name="name" value="<?php echo $row['name']; ?>" disabled></td>
                            <td><input type="email" name="email" value="<?php echo $row['email']; ?>" disabled></td>
                            <td><input type="text" name="phone" value="<?php echo $row['phone']; ?>" disabled></td>
                            <td><input type="text" name="address" value="<?php echo $row['address']; ?>" disabled></td>
                            <td><input type="text" name="location" value="<?php echo $row['location']; ?>" disabled></td>
                            <td><input type="number" name="guests" value="<?php echo $row['guests']; ?>" disabled></td>
                            <td><input type="date" name="arrivals" value="<?php echo $row['arrivals']; ?>" disabled></td>
                            <td><input type="date" name="leaving" value="<?php echo $row['leaving']; ?>" disabled></td>
                            <td class="action-icons">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="button" onclick="enableEditing(<?php echo $row['id']; ?>)" class="update">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="submit" name="save" class="save" style="display: none;">
                                    <i class="fas fa-save"></i>
                                </button>
                                <a href="admin.php?delete=<?php echo $row['id']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this record?')">
                                    <i class="fas fa-trash delete"></i>
                                </a>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="10">No bookings found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
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
    const saveButton = row.querySelector('.save');
    const updateButton = row.querySelector('.update');

    inputs.forEach(input => input.disabled = false);
    saveButton.style.display = 'inline';
    updateButton.style.display = 'none';
}
</script>

</body>
</html>