<?php
session_start();
$connection = mysqli_connect('localhost', 'root', '', 'book_db');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['customer_id'])) {
    $customerId = mysqli_real_escape_string($connection, $_POST['customer_id']);

    $query = "SELECT * FROM book_form WHERE id = '$customerId'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Save table load timestamp in the session
        $_SESSION['table_timestamp'] = time();

        $output = '<table id="booking-table" class="styled-table">';
        $output .= '<thead>
                        <tr>
                            <th>Customer ID</th>
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
                            <th>Status</th>
                        </tr>
                    </thead><tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            $currentTime = strtotime('now');
            $arrivalTime = strtotime($row['arrivals']);
            $leavingTime = strtotime($row['leaving']);

            if ($currentTime > $leavingTime) {
                $status = "<span class='status red'>Trip End</span>";
            } elseif ($currentTime >= $arrivalTime && $currentTime <= $leavingTime) {
                $status = "<span class='status orange'>Ongoing</span>";
            } else {
                $status = "<span class='status green'>Not Started</span>";
            }

            $output .= '<tr>
                            <td>' . htmlspecialchars($row['id']) . '</td>
                            <td>' . htmlspecialchars($row['name']) . '</td>
                            <td>' . htmlspecialchars($row['email']) . '</td>
                            <td>' . htmlspecialchars($row['phone']) . '</td>
                            <td>' . htmlspecialchars($row['address']) . '</td>
                            <td>' . htmlspecialchars($row['location']) . '</td>
                            <td>' . htmlspecialchars($row['guests']) . '</td>
                            <td>' . htmlspecialchars($row['arrivals']) . '</td>
                            <td>' . htmlspecialchars($row['leaving']) . '</td>
                            <td>' . htmlspecialchars($row['type']) . '</td>
                            <td>' . htmlspecialchars($row['price']) . '</td>
                            <td>' . $status . '</td>
                        </tr>';
        }
        $output .= '</tbody></table>';
    } else {
        $output = '<div class="message-box error">No records found for the entered Customer ID.</div>';
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $output = '<div class="message-box error">Please enter a valid Customer ID.</div>';
} else {
    $output = '';
}

$timestamp = isset($_SESSION['table_timestamp']) ? $_SESSION['table_timestamp'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer Bookings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Additional styles */
        .booking-section {
            padding: 5rem 10%;
            background: var(--light-bg);
            min-height: 100vh;
        }

        .booking-container {
            background: var(--white);
            border: var(--border);
            box-shadow: var(--box-shadow);
            padding: 3rem;
            border-radius: .5rem;
            max-width: 100%;
            margin: 0 auto;
        }

        .booking-container h2 {
            font-size: 2.5rem;
            color: var(--black);
            text-align: center;
            margin-bottom: 2rem;
        }

        .search-form {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .search-form input[type="text"] {
            width: 50%;
            padding: 1rem;
            border: var(--border);
            border-radius: .5rem;
            font-size: 1.6rem;
        }

        .search-form button {
            padding: 1rem 2rem;
            background: var(--black);
            color: var(--white);
            border: none;
            border-radius: .5rem;
            font-size: 1.6rem;
            cursor: pointer;
        }

        .search-form button:hover {
            background: var(--main-color);
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            font-size: 1.6rem;
        }

        .styled-table th,
        .styled-table td {
            border: var(--border);
            padding: 1.5rem;
            text-align: left;
        }

        .styled-table th {
            background: var(--main-color);
            color: var(--white);
        }

        .styled-table tr:nth-child(even) {
            background: var(--light-bg);
        }

        .styled-table tr:hover {
            background: var(--light-white);
        }

        .message-box {
            padding: 1.5rem;
            border-radius: .5rem;
            font-size: 1.6rem;
            text-align: center;
            margin: 2rem 0;
        }

        .message-box.error {
            background: var(--black);
            color: var(--white);
        }

        .status {
            font-weight: bold;
        }

        .status.red {
            color: #ff4d4d;
        }

        .status.orange {
            color: #ffa64d;
        }

        .status.green {
            color: #4dff4d;
        }

        .fade-out {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
    </style>
</head>
<body>

<!-- Header Section -->
<section class="header">
   <a href="home.php" class="logo">Travel</a>
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

<!-- Booking Section -->
<section class="booking-section">
    <div class="booking-container">
        <h2>Search Customer Bookings</h2>
        <form class="search-form" method="POST">
            <input type="text" id="customer_id" name="customer_id" placeholder="Enter Customer ID" required>
            <button type="submit">Search</button>
        </form>
        <?= $output; ?>
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

<script>
    // Fade out the table after 30 seconds (30000 ms)
    const tableTimestamp = <?= json_encode($timestamp); ?>;
    const table = document.getElementById('booking-table');

    if (table && tableTimestamp) {
        const now = Math.floor(Date.now() / 1000);
        const elapsed = now - tableTimestamp;

        if (elapsed >= 30) {
            table.classList.add('fade-out');
            setTimeout(() => window.close(), 300);
        } else {
            const remainingTime = (30 - elapsed) * 1000;
            setTimeout(() => {
                table.classList.add('fade-out');
                setTimeout(() => window.close(), 300);
            }, remainingTime);
        }
    }
</script>

</body>
</html>
