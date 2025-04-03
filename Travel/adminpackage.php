<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'package_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize messages
$message = $messageType = "";
$isEditMode = false;
$packageData = null;

// Check if we're editing an existing package
if (isset($_GET['edit'])) {
    $packageId = (int)$_GET['edit'];
    $isEditMode = true;
    
    $stmt = $conn->prepare("SELECT * FROM package WHERE id = ?");
    $stmt->bind_param("i", $packageId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $packageData = $result->fetch_assoc();
        // Decode the JSON fields
        $packageData['places'] = json_decode($packageData['places'], true);
        $packageData['details'] = json_decode($packageData['details'], true);
    } else {
        $message = "Package not found!";
        $messageType = "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $conn->real_escape_string($_POST['type']);
    $location = $conn->real_escape_string($_POST['location']);
    $price = $conn->real_escape_string($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);
    $numPlaces = (int)$_POST['num_places'];

    $places = [];
    for ($i = 1; $i <= $numPlaces; $i++) {
        if (isset($_POST['place_' . $i])) {
            $places[] = $_POST['place_' . $i]; // Remove real_escape_string
        }
    }
    $placesSerialized = json_encode($places);

    $days = (int)$_POST['days'];
    
    // Collect day-wise details
    $dayDetails = [];
    for ($i = 1; $i <= $days; $i++) {
        if (isset($_POST['day_' . $i . '_details'])) {
            $dayDetails[] = $_POST['day_' . $i . '_details']; // Remove real_escape_string
        }
    }
    $dayDetailsSerialized = json_encode($dayDetails);

    // File upload handling
    $targetDir = "image/";
    $imageUpdated = false;
    $targetFilePath = '';

    // Ensure the uploads directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if ($isEditMode) {
        $packageId = (int)$_POST['package_id'];
        
        // Check if a new image was uploaded
        if (!empty($_FILES["image"]["name"])) {
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . uniqid() . '_' . $fileName;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $imageUpdated = true;
                // Delete old image if it exists
                if (!empty($packageData['image_path']) && file_exists($packageData['image_path'])) {
                    unlink($packageData['image_path']);
                }
            } else {
                $message = "Failed to upload image. Please try again.";
                $messageType = "error";
            }
        }
        
        // Prepare the SQL query based on whether image was updated
        if ($imageUpdated) {
            $stmt = $conn->prepare("UPDATE package SET type=?, location=?, price=?, description=?, places=?, days=?, details=?, image_path=? WHERE id=?");
            $stmt->bind_param("ssisssssi", $type, $location, $price, $description, $placesSerialized, $days, $dayDetailsSerialized, $targetFilePath, $packageId);
        } else {
            $stmt = $conn->prepare("UPDATE package SET type=?, location=?, price=?, description=?, places=?, days=?, details=? WHERE id=?");
            $stmt->bind_param("ssissssi", $type, $location, $price, $description, $placesSerialized, $days, $dayDetailsSerialized, $packageId);
        }
        
        if ($stmt->execute()) {
            $message = "Package updated successfully!";
            $messageType = "success";
        } else {
            $message = "Error updating package: " . $stmt->error;
            $messageType = "error";
        }
    } else {
        // Add new package
        if (!empty($_FILES["image"]["name"])) {
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . uniqid() . '_' . $fileName;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $stmt = $conn->prepare("INSERT INTO package (type, location, price, description, places, days, details, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssisssss", $type, $location, $price, $description, $placesSerialized, $days, $dayDetailsSerialized, $targetFilePath);

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
        } else {
            $message = "Please upload an image for the package.";
            $messageType = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title><?php echo $isEditMode ? 'Edit' : 'Add'; ?> Package - Travel</title>

   <!-- SweetAlert -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- Swiper CSS -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <style>
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

      .image-preview {
         max-width: 200px;
         max-height: 200px;
         margin: 1rem 0;
         display: <?php echo ($isEditMode && !empty($packageData['image_path'])) ? 'block' : 'none'; ?>;
      }
      
      .current-image-label {
         font-size: 1.4rem;
         color: var(--light-black);
         margin-bottom: 0.5rem;
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
      }).then((result) => {
         if (result.isConfirmed && "<?php echo $messageType; ?>" === "success") {
            window.location.href = "adminpackage.php";
         }
      });
   });
</script>
<?php endif; ?>

<section class="header">
   <a href="home.php" class="logo">Travel</a>
   <nav class="navbar">
      <a href="admin.php">Home</a>
      <a href="adminpackage.php">Package</a>
      <a href="customerreview.php">Traveller Review</a>
      <a href="PackageDetail.php">Package Details</a>
      
   </nav>
</section>

<main class="admin-container">
   <div class="admin-form">
      <h1><?php echo $isEditMode ? 'Edit Package' : 'Add New Package'; ?></h1>

      <form method="POST" enctype="multipart/form-data" id="packageForm">
         <?php if ($isEditMode): ?>
            <input type="hidden" name="package_id" value="<?php echo $packageId; ?>">
         <?php endif; ?>

         <div class="form-group">
            <label>Package Type</label>
            <input type="text" name="type" value="<?php echo $isEditMode ? htmlspecialchars($packageData['type']) : ''; ?>" required>
         </div>

         <div class="form-group">
            <label>Destination</label>
            <input type="text" name="location" value="<?php echo $isEditMode ? htmlspecialchars($packageData['location']) : ''; ?>" required>
         </div>

         <div class="form-group">
            <label>Price (₹)</label>
            <input type="number" name="price" value="<?php echo $isEditMode ? htmlspecialchars($packageData['price']) : ''; ?>" required>
         </div>

         <div class="form-group">
            <label>Package Description</label>
            <textarea name="description" required><?php echo $isEditMode ? htmlspecialchars($packageData['description']) : ''; ?></textarea>
         </div>

         <div class="form-group">
            <label>Number of Places to Visit</label>
            <input type="number" name="num_places" id="numPlaces" min="1" max="10" 
                   value="<?php echo $isEditMode ? count($packageData['places']) : '1'; ?>" required>
         </div>

         <div id="placesContainer">
            <?php if ($isEditMode): ?>
               <?php foreach ($packageData['places'] as $index => $place): ?>
                  <div class="form-group">
                     <label>Place <?php echo $index + 1; ?></label>
                     <input type="text" name="place_<?php echo $index + 1; ?>" value="<?php echo htmlspecialchars($place); ?>" required>
                  </div>
               <?php endforeach; ?>
            <?php endif; ?>
         </div>

         <div class="form-group">
            <label>Number of Days</label>
            <input type="number" name="days" id="numDays" min="1" max="15" 
                   value="<?php echo $isEditMode ? $packageData['days'] : '1'; ?>" required>
         </div>

         <div id="dayDetailsContainer">
            <?php if ($isEditMode): ?>
               <?php foreach ($packageData['details'] as $index => $detail): ?>
                  <div class="form-group">
                     <label>Day <?php echo $index + 1; ?> Details</label>
                     <textarea name="day_<?php echo $index + 1; ?>_details" required><?php echo htmlspecialchars($detail); ?></textarea>
                  </div>
               <?php endforeach; ?>
            <?php endif; ?>
         </div>

         <div class="form-group">
            <label>Package Image</label>
            <input type="file" name="image" accept="image/*" <?php echo $isEditMode ? '' : 'required'; ?>>
            
            <?php if ($isEditMode && !empty($packageData['image_path'])): ?>
               <p class="current-image-label">Current Image:</p>
               <img src="<?php echo $packageData['image_path']; ?>" alt="Current Package Image" class="image-preview" id="imagePreview">
               <p>Leave blank to keep current image</p>
            <?php endif; ?>
         </div>

         <button type="submit" class="btn"><?php echo $isEditMode ? 'Update Package' : 'Add Package'; ?></button>
         
         <?php if ($isEditMode): ?>
            <a href="adminpackage.php" class="btn" style="background: #777; margin-top: 1rem;">Cancel</a>
         <?php endif; ?>
      </form>
   </div>
</main>

<section class="footer">
   <div class="credit">Created by <span>Aswin S</span> | All Rights Reserved!</div>
</section>

<script>
   // Handle places input
   document.getElementById('numPlaces').addEventListener('change', function () {
      const numPlaces = parseInt(this.value) || 0;
      const placesContainer = document.getElementById('placesContainer');
      placesContainer.innerHTML = '';

      for (let i = 1; i <= numPlaces; i++) {
         const placeInput = document.createElement('div');
         placeInput.className = 'form-group';
         placeInput.innerHTML = `
            <label>Place ${i}</label>
            <input type="text" name="place_${i}" required>
         `;
         placesContainer.appendChild(placeInput);
      }
   });

   // Handle day details input
   document.getElementById('numDays').addEventListener('change', function () {
      const numDays = parseInt(this.value) || 0;
      const dayDetailsContainer = document.getElementById('dayDetailsContainer');
      dayDetailsContainer.innerHTML = '';

      for (let i = 1; i <= numDays; i++) {
         const dayInput = document.createElement('div');
         dayInput.className = 'form-group';
         dayInput.innerHTML = `
            <label>Day ${i} Details</label>
            <textarea name="day_${i}_details" required></textarea>
         `;
         dayDetailsContainer.appendChild(dayInput);
      }
   });

   // Show image preview when a new image is selected
   document.querySelector('input[name="image"]').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
         const reader = new FileReader();
         reader.onload = function(event) {
            const preview = document.getElementById('imagePreview');
            if (!preview) {
               const img = document.createElement('img');
               img.id = 'imagePreview';
               img.className = 'image-preview';
               img.src = event.target.result;
               this.parentNode.insertBefore(img, this.nextSibling);
            } else {
               preview.src = event.target.result;
               preview.style.display = 'block';
            }
         };
         reader.readAsDataURL(file);
      }
   });

   // Initialize the form with the correct number of places and days when in edit mode
   document.addEventListener('DOMContentLoaded', function() {
      <?php if ($isEditMode): ?>
         // Trigger change events to populate the form
         document.getElementById('numPlaces').dispatchEvent(new Event('change'));
         document.getElementById('numDays').dispatchEvent(new Event('change'));
      <?php endif; ?>
   });
</script>
</body>
</html>