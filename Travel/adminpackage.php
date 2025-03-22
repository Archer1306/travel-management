<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'package_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize messages
$message = $messageType = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $conn->real_escape_string($_POST['type']);
    $location = $conn->real_escape_string($_POST['location']);
    $price = $conn->real_escape_string($_POST['price']);
    $details = $conn->real_escape_string($_POST['details']);

    // File upload handling
    $targetDir = "uploads/";
    
    // Ensure the uploads directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
    }

    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . uniqid() . '_' . $fileName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        $stmt = $conn->prepare("INSERT INTO package (type, location, price, details, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $type, $location, $price, $details, $targetFilePath);

        if ($stmt->execute()) {
            $message = "Package added successfully!";
            $messageType = "success";
        } else {
            $message = "Error saving data: " . $stmt->error;
            $messageType = "error";
        }
    } else {
        $message = "Failed to upload image. Please try again.";
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Package - Travel</title>

   <!-- SweetAlert -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- Swiper CSS -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <style>
      /* Add your existing styles here */
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

      :root {
         --main-color: #8e44ad;
         --black: #222;
         --white: #fff;
         --light-black: #777;
         --light-white: #fff9;
         --light-bg: #eee;
         --border: 0.1rem solid var(--black);
         --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
      }

      * {
         font-family: 'Poppins', sans-serif;
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         text-decoration: none;
      }

      html {
         font-size: 62.5%;
         overflow-x: hidden;
      }

      .header {
         position: sticky;
         top: 0;
         z-index: 1000;
         background: var(--white);
         display: flex;
         justify-content: space-between;
         align-items: center;
         padding: 2rem 10%;
         box-shadow: var(--box-shadow);
      }

      .header .logo {
         font-size: 2.5rem;
         color: var(--black);
      }

      .header .navbar a {
         font-size: 1.8rem;
         margin-left: 2rem;
         color: var(--black);
      }

      .admin-container {
         max-width: 600px;
         margin: 2rem auto;
         padding: 2rem;
      }

      .admin-form {
         background: var(--white);
         padding: 2rem;
         border-radius: 0.5rem;
         box-shadow: var(--box-shadow);
         border: var(--border);
      }

      .admin-form h1 {
         font-size: 2.5rem;
         text-align: center;
         margin-bottom: 2rem;
         text-transform: uppercase;
      }

      .form-group {
         margin-bottom: 1.5rem;
      }

      .form-group label {
         display: block;
         font-size: 1.6rem;
         margin-bottom: 0.5rem;
      }

      .form-group input,
      .form-group select,
      .form-group textarea {
         width: 100%;
         padding: 1rem;
         border: var(--border);
         border-radius: 0.5rem;
         font-size: 1.6rem;
         background: var(--light-bg);
      }

      .form-group textarea {
         height: 10rem;
         resize: none;
      }

      .btn {
         display: block;
         width: 100%;
         background: var(--black);
         color: var(--white);
         font-size: 1.8rem;
         padding: 1rem;
         border-radius: 0.5rem;
         text-align: center;
         cursor: pointer;
      }

      .btn:hover {
         background: var(--main-color);
      }

      .footer {
         background: #222;
         padding: 4rem 10%;
         color: #fff;
         text-align: center;
      }
   </style>
</head>
<body>
<?php if (!empty($message)): ?>
<script>
   document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
         title: "<?php echo $messageType === 'success' ? 'Success!' : 'Error!'; ?>",
         text: "<?php echo $message; ?>",
         icon: "<?php echo $messageType; ?>",
         confirmButtonText: "OK"
      });
   });
</script>
<?php endif; ?>

<section class="header">
   <a href="home.php" class="logo">Travel</a>
   <nav class="navbar">
      <a href="admin.php">Home</a>
        <a href="adminpackage.php">package</a>
        <a href="customerreview.php">traveller Review</a>
        <a href="PackageDetail.php">Package Details</a>

   </nav>
</section>


<main class="admin-container">
   <div class="admin-form">
   <br><br>
      <h1>Add New Package</h1>

      <form method="POST" enctype="multipart/form-data">
         <div class="form-group">
            <label>Package Type</label>
            <select name="type" required>
               <option value="Adventure">Adventure</option>
               <option value="Luxury">Luxury</option>
               <option value="Family">Family</option>
            </select>
         </div>

         <div class="form-group">
            <label>Destination</label>
            <input type="text" name="location" required>
         </div>

         <div class="form-group">
            <label>Price (₹)</label>
            <input type="number" name="price" required>
         </div>

         <div class="form-group">
            <label>Package Details</label>
            <textarea name="details" required></textarea>
         </div>

         <div class="form-group">
            <label>Package Image</label>
            <input type="file" name="image" accept="image/*" required>
         </div>

         <button type="submit" class="btn">Add Package</button>
      </form>
   </div>
</main>

<section class="footer">
   <div class="credit">Created by <span>Aswin S</span> | All Rights Reserved!</div>
</section>
</body>
</html>

