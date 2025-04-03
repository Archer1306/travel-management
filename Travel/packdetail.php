<?php
include 'config.php';

// Get the package ID from the URL
$packageId = $_GET['package_id'];

$sql = "SELECT * FROM package WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $packageId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p>Package not found.</p>";
    exit;
}

$row = $result->fetch_assoc();

// Convert places string to array and clean each item
$placesArray = array_filter(array_map('trim', explode(',', $row['places'])), 'strlen');
// Convert details string to array and clean each item
$detailsArray = array_filter(array_map('trim', explode(',', $row['details'])), 'strlen');
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Package Details | Travel</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <style>
      :root {
          --primary-color: #6c5ce7;
          --secondary-color: #a29bfe;
          --accent-color: #fd79a8;
          --dark-color: #2d3436;
          --light-color: #f5f6fa;
          --success-color: #00b894;
      }
      
      * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
      }
      
      body {
          font-family: 'Poppins', sans-serif;
          background-color: #f9f9f9;
          color: #333;
          line-height: 1.6;
      }
      
      .header {
          background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
          color: white;
          padding: 2rem 0;
          text-align: center;
          box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      }
      
      .header h1 {
          font-size: 2.5rem;
          font-weight: 600;
          margin-bottom: 0.5rem;
      }
      
      .container {
          max-width: 1200px;
          margin: 2rem auto;
          padding: 0 1rem;
      }
      
      .package-card {
          background: white;
          border-radius: 12px;
          overflow: hidden;
          box-shadow: 0 10px 30px rgba(0,0,0,0.08);
          margin-bottom: 3rem;
      }
      
      .package-image {
          height: 400px;
          overflow: hidden;
      }
      
      .package-image img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.5s ease;
      }
      
      .package-image:hover img {
          transform: scale(1.05);
      }
      
      .package-content {
          padding: 2.5rem;
      }
      
      .package-title {
          font-size: 2rem;
          color: var(--dark-color);
          margin-bottom: 1rem;
          font-weight: 600;
      }
      
      .package-meta {
          display: flex;
          flex-wrap: wrap;
          gap: 1.5rem;
          margin-bottom: 1.5rem;
      }
      
      .meta-item {
          display: flex;
          align-items: center;
          color: #666;
      }
      
      .meta-item i {
          margin-right: 0.5rem;
          color: var(--primary-color);
      }
      
      .package-description {
          margin-bottom: 2rem;
          color: #555;
      }
      
      .section-title {
          font-size: 1.5rem;
          color: var(--dark-color);
          margin: 2rem 0 1rem;
          position: relative;
          padding-bottom: 0.5rem;
      }
      
      .section-title::after {
          content: '';
          position: absolute;
          bottom: 0;
          left: 0;
          width: 60px;
          height: 3px;
          background: var(--primary-color);
      }
      
      .highlights {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
          gap: 1.5rem;
          margin-bottom: 2rem;
      }
      
      .highlight-item {
          background: var(--light-color);
          padding: 1.5rem;
          border-radius: 8px;
          display: flex;
          align-items: center;
      }
      
      .highlight-icon {
          font-size: 1.5rem;
          color: var(--primary-color);
          margin-right: 1rem;
      }
      
      .details-list {
          margin: 1.5rem 0;
          padding-left: 1.5rem;
      }
      
      .details-list li {
          margin-bottom: 0.8rem;
          position: relative;
          list-style-type: none;
      }
      
      .details-list li::before {
          content: '\f192';
          font-family: 'Font Awesome 5 Free';
          font-weight: 900;
          color: var(--primary-color);
          position: absolute;
          left: -1.5rem;
      }
      
      .booking-form {
          background: #f8f9fa;
          padding: 2.5rem;
          border-radius: 12px;
          margin-top: 2rem;
      }
      
      .form-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
          gap: 1.5rem;
          margin-bottom: 1.5rem;
      }
      
      .form-group {
          margin-bottom: 1.5rem;
      }
      
      .form-group label {
          display: block;
          margin-bottom: 0.5rem;
          font-weight: 500;
          color: var(--dark-color);
      }
      
      .form-control {
          width: 100%;
          padding: 0.8rem 1rem;
          border: 1px solid #ddd;
          border-radius: 6px;
          font-family: 'Poppins', sans-serif;
          font-size: 1rem;
          transition: all 0.3s ease;
      }
      
      .form-control:focus {
          outline: none;
          border-color: var(--primary-color);
          box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
      }
      
      select.form-control {
          appearance: none;
          background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
          background-repeat: no-repeat;
          background-position: right 1rem center;
          background-size: 1em;
      }
      
      .price-display {
          background: white;
          padding: 1.5rem;
          border-radius: 8px;
          margin: 2rem 0;
          text-align: center;
          box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      }
      
      .price-label {
          font-size: 1rem;
          color: #666;
          margin-bottom: 0.5rem;
      }
      
      .final-price {
          font-size: 2.5rem;
          font-weight: 700;
          color: var(--primary-color);
      }
      
      .btn {
          display: inline-block;
          background: var(--primary-color);
          color: white;
          padding: 1rem 2rem;
          font-size: 1rem;
          font-weight: 500;
          border: none;
          border-radius: 6px;
          cursor: pointer;
          transition: all 0.3s ease;
          text-align: center;
          text-decoration: none;
          width: 100%;
      }
      
      .btn:hover {
          background: #5649d1;
          transform: translateY(-2px);
          box-shadow: 0 4px 12px rgba(108, 92, 231, 0.3);
      }
      
      .footer {
          background: var(--dark-color);
          color: white;
          text-align: center;
          padding: 2rem 0;
          margin-top: 3rem;
      }
      
      .footer p {
          margin-bottom: 0;
      }
      
      @media (max-width: 768px) {
          .package-image {
              height: 300px;
          }
          
          .package-content {
              padding: 1.5rem;
          }
          
          .booking-form {
              padding: 1.5rem;
          }
      }
      
      /* New styles for person count */
      .person-count {
          display: flex;
          align-items: center;
          justify-content: center;
          margin-top: 1rem;
      }
      
      .person-count button {
          background: var(--primary-color);
          color: white;
          border: none;
          width: 30px;
          height: 30px;
          border-radius: 50%;
          font-size: 1rem;
          cursor: pointer;
          display: flex;
          align-items: center;
          justify-content: center;
      }
      
      .person-count input {
          width: 50px;
          text-align: center;
          margin: 0 10px;
          padding: 0.3rem;
          border: 1px solid #ddd;
          border-radius: 4px;
      }
      
      .price-per-person {
          font-size: 1rem;
          color: #666;
          margin-top: 0.5rem;
      }
      
      .total-price-display {
          background: white;
          padding: 1.5rem;
          border-radius: 8px;
          margin: 1rem 0;
          text-align: center;
          box-shadow: 0 4px 12px rgba(0,0,0,0.05);
          border: 2px solid var(--primary-color);
      }
      
      .total-price-label {
          font-size: 1.2rem;
          color: var(--dark-color);
          margin-bottom: 0.5rem;
          font-weight: 600;
      }
      
      .total-price {
          font-size: 2rem;
          font-weight: 700;
          color: var(--success-color);
      }
   </style>
</head>
<body>

<header class="header">
   <h1><?php echo htmlspecialchars($row['type']); ?> Tour Package</h1>
   <p>Explore the beauty of <?php echo htmlspecialchars($row['location']); ?></p>
</header>

<div class="container">
    <div class="package-card">
        <div class="package-image">
            <img src="<?php echo !empty($row['image_path']) ? htmlspecialchars($row['image_path']) : 'image/default.png'; ?>" alt="<?php echo htmlspecialchars($row['type']); ?> Tour">
        </div>
        
        <div class="package-content">
            <h1 class="package-title"><?php echo htmlspecialchars($row['type']); ?> Tour to <?php echo htmlspecialchars($row['location']); ?></h1>
            
            <div class="package-meta">
                <div class="meta-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?php echo htmlspecialchars($row['location']); ?></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="package-days"><?php echo htmlspecialchars($row['days']); ?> Days</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-tag"></i>
                    <span>Price: ₹<?php echo number_format($row['price'], 2); ?> per person</span>
                </div>
            </div>
            
            <h2 class="section-title">Places You'll Visit</h2>
            <ul class="details-list">
                <?php foreach ($placesArray as $place): ?>
                    <li><?php echo htmlspecialchars(str_replace(['"', '[', ']'], '', $place)); ?></li>
                <?php endforeach; ?>
            </ul>
            
            <h2 class="section-title">Package Highlight</h2>
            <ul class="details-list">
                <?php foreach ($detailsArray as $detail): ?>
                    <li><?php echo htmlspecialchars(str_replace(['"', '[', ']'], '', $detail)); ?></li>
                <?php endforeach; ?>
            </ul>
            
            <div class="highlights">
                <div class="highlight-item">
                    <div class="highlight-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div>
                        <h3>Meals Included</h3>
                        <p>Breakfast, Lunch & Dinner</p>
                    </div>
                </div>
                <div class="highlight-item">
                    <div class="highlight-icon">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <div>
                        <h3>Accommodation</h3>
                        <p>Luxury Hotels</p>
                    </div>
                </div>
                <div class="highlight-item">
                    <div class="highlight-icon">
                        <i class="fas fa-bus"></i>
                    </div>
                    <div>
                        <h3>Transport</h3>
                        <p>Comfortable Vehicles</p>
                    </div>
                </div>
                <div class="highlight-item">
                    <div class="highlight-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div>
                        <h3>Sightseeing</h3>
                        <p>All Major Attractions</p>
                    </div>
                </div>
            </div>
            
            <div class="booking-form">
                <h2 class="section-title">Book Your Package</h2>
                
                <form action="book.php" method="get">
                    <input type="hidden" name="package_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="type" value="<?php echo urlencode($row['type']); ?>">
                    <input type="hidden" name="base_price" id="base_price" value="<?php echo $row['price']; ?>">
                    <input type="hidden" name="location" value="<?php echo urlencode($row['location']); ?>">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="vehicle">Vehicle Type</label>
                            <select name="vehicle" id="vehicle" class="form-control" required>
                                <option value="Car" data-price="0">Car (No extra charge)</option>
                                <option value="Van" data-price="1000">Van (+₹1000 per person)</option>
                                <option value="Bus" data-price="500">Bus (+₹500 per person)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="hotel">Hotel Class</label>
                            <select name="hotel" id="hotel" class="form-control" required>
                                <option value="3 Star" data-price="0">3 Star (No extra charge)</option>
                                <option value="4 Star" data-price="1500">4 Star (+₹1500 per person)</option>
                                <option value="5 Star" data-price="3000">5 Star (+₹3000 per person)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="menu">Menu Type</label>
                            <select name="menu" id="menu" class="form-control" required>
                                <option value="Veg" data-price="0">Vegetarian (No extra charge)</option>
                                <option value="Non-Veg" data-price="800">Non-Vegetarian (+₹800 per person)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="persons">Number of Persons</label>
                            <div class="person-count">
                                <button type="button" id="decrement-person">-</button>
                                <input type="number" name="persons" id="persons" class="form-control" min="1" value="1" required>
                                <button type="button" id="increment-person">+</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="price-display">
                        <div class="price-label">Base Price Per Person</div>
                        <div class="final-price">₹<span id="base-price-display"><?php echo number_format($row['price'], 2); ?></span></div>
                        <div class="price-per-person" id="price-breakdown"></div>
                    </div>
                    
                    <div class="total-price-display">
                        <div class="total-price-label">Total Package Price</div>
                        <div class="total-price">₹<span id="total-price"><?php echo number_format($row['price'], 2); ?></span></div>
                    </div>
                    
                    <button type="submit" class="btn">
                        <i class="fas fa-paper-plane"></i> Book Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
   <p>&copy; <?php echo date('Y'); ?> Travel Explorer. All rights reserved.</p>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const daysMeta = document.getElementById('package-days');
    const basePrice = parseFloat(document.getElementById('base_price').value);
    const personsInput = document.getElementById('persons');
    const incrementBtn = document.getElementById('increment-person');
    const decrementBtn = document.getElementById('decrement-person');
    const vehicleSelect = document.getElementById('vehicle');
    const hotelSelect = document.getElementById('hotel');
    const menuSelect = document.getElementById('menu');
    const basePriceDisplay = document.getElementById('base-price-display');
    const priceBreakdown = document.getElementById('price-breakdown');
    const totalPriceDisplay = document.getElementById('total-price');
    
    // Extract the number of days from the text (e.g., "5 Days" -> 5)
    const packageDays = parseInt(daysMeta.textContent.trim());
    
    // Set minimum date for start date (today)
    const today = new Date();
    const minDate = today.toISOString().split('T')[0];
    startDateInput.setAttribute('min', minDate);
    
    // Update end date when start date changes
    startDateInput.addEventListener('change', function() {
        if (this.value) {
            const startDate = new Date(this.value);
            const endDate = new Date(startDate);
            
            // Add the package days minus 1 (since start day counts as day 1)
            endDate.setDate(endDate.getDate() + (packageDays - 1));
            
            // Format the date as YYYY-MM-DD for the input
            const formattedDate = endDate.toISOString().split('T')[0];
            endDateInput.value = formattedDate;
        } else {
            endDateInput.value = '';
        }
    });
    
    // Person count controls
    incrementBtn.addEventListener('click', function() {
        personsInput.value = parseInt(personsInput.value) + 1;
        calculateTotalPrice();
    });
    
    decrementBtn.addEventListener('click', function() {
        if (parseInt(personsInput.value) > 1) {
            personsInput.value = parseInt(personsInput.value) - 1;
            calculateTotalPrice();
        }
    });
    
    personsInput.addEventListener('change', function() {
        if (parseInt(this.value) < 1) this.value = 1;
        calculateTotalPrice();
    });
    
    // Add event listeners for all select elements
    vehicleSelect.addEventListener('change', calculateTotalPrice);
    hotelSelect.addEventListener('change', calculateTotalPrice);
    menuSelect.addEventListener('change', calculateTotalPrice);
    
    // Function to calculate total price
    function calculateTotalPrice() {
        const persons = parseInt(personsInput.value);
        const vehiclePrice = parseFloat(vehicleSelect.options[vehicleSelect.selectedIndex].dataset.price);
        const hotelPrice = parseFloat(hotelSelect.options[hotelSelect.selectedIndex].dataset.price);
        const menuPrice = parseFloat(menuSelect.options[menuSelect.selectedIndex].dataset.price);
        
        // Calculate price per person
        const pricePerPerson = basePrice + vehiclePrice + hotelPrice + menuPrice;
        
        // Calculate total price
        const totalPrice = pricePerPerson * persons;
        
        // Update displays
        basePriceDisplay.textContent = basePrice.toFixed(2);
        totalPriceDisplay.textContent = totalPrice.toFixed(2);
        
        // Update price breakdown
        let breakdownText = `Base: ₹${basePrice.toFixed(2)}`;
        if (vehiclePrice > 0) breakdownText += ` + Vehicle: ₹${vehiclePrice.toFixed(2)}`;
        if (hotelPrice > 0) breakdownText += ` + Hotel: ₹${hotelPrice.toFixed(2)}`;
        if (menuPrice > 0) breakdownText += ` + Menu: ₹${menuPrice.toFixed(2)}`;
        breakdownText += ` = ₹${pricePerPerson.toFixed(2)} per person`;
        
        priceBreakdown.textContent = breakdownText;
    }
    
    // Initial calculation
    calculateTotalPrice();
});
</script>

</body>
</html>