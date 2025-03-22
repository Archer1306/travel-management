<!-- Add this modal HTML at the bottom of book.php (before footer) -->
<div class="custom-alert-modal">
    <div class="alert-content">
        <span class="close-alert">&times;</span>
        <div class="alert-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3 class="alert-title">Booking Successful!</h3>
        <p class="alert-message"></p>
    </div>
</div>

<style>
/* Custom Alert Modal Styles */
.custom-alert-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.alert-content {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    width: 90%;
    max-width: 500px;
    text-align: center;
    position: relative;
    animation: slideIn 0.3s ease;
}

.close-alert {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 24px;
    cursor: pointer;
    color: #666;
}

.alert-icon {
    font-size: 50px;
    color: #4CAF50;
    margin-bottom: 15px;
}

.alert-title {
    color: #333;
    margin-bottom: 15px;
}

.alert-message {
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

@keyframes slideIn {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>

<script>
// Custom Alert Functions
function showSuccessAlert(contactId) {
    const modal = document.querySelector('.custom-alert-modal');
    const message = document.querySelector('.alert-message');

    message.innerHTML = `Thank you for booking with us! Your Booking ID is: <strong>${contactId}</strong>.`;

    modal.style.display = 'flex';

    // Automatically redirect to book.php after 30 seconds if no action is taken
    const autoRedirect = setTimeout(() => {
        modal.style.display = 'none';
        window.location.href = 'book.php';
    }, 30000);

    // Close modal handlers
    document.querySelector('.close-alert').onclick = () => {
        clearTimeout(autoRedirect);
        modal.style.display = 'none';
        window.location.href = 'book.php';
    };

    window.onclick = (e) => {
        if (e.target === modal) {
            clearTimeout(autoRedirect);
            modal.style.display = 'none';
            window.location.href = 'book.php';
        }
    };
}

function showErrorAlert(message) {
    const modal = document.querySelector('.custom-alert-modal');
    const content = document.querySelector('.alert-content');
    const icon = document.querySelector('.alert-icon');
    const title = document.querySelector('.alert-title');

    icon.innerHTML = '<i class="fas fa-times-circle"></i>';
    icon.style.color = '#ff4444';
    title.textContent = 'Booking Failed!';
    document.querySelector('.alert-message').textContent = message;

    modal.style.display = 'flex';

    // Automatically redirect to book.php after 30 seconds if no action is taken
    const autoRedirect = setTimeout(() => {
        modal.style.display = 'none';
        window.location.href = 'book.php';
    }, 30000);

    // Close modal handlers
    document.querySelector('.close-alert').onclick = () => {
        clearTimeout(autoRedirect);
        modal.style.display = 'none';
        window.location.href = 'book.php';
    };

    window.onclick = (e) => {
        if (e.target === modal) {
            clearTimeout(autoRedirect);
            modal.style.display = 'none';
            window.location.href = 'book.php';
        }
    };
}
</script>

<?php
// Updated book_form.php
$connection = mysqli_connect('localhost','root','','book_db');

if(isset($_POST['send'])){
    // Sanitize inputs (recommended)
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $location = mysqli_real_escape_string($connection, $_POST['location']);
    $guests = mysqli_real_escape_string($connection, $_POST['guests']);
    $arrivals = mysqli_real_escape_string($connection, $_POST['arrivals']);
    $leaving = mysqli_real_escape_string($connection, $_POST['leaving']);

    $request = "INSERT INTO book_form(name, email, phone, address, location, guests, arrivals, leaving) 
                VALUES('$name','$email','$phone','$address','$location','$guests','$arrivals','$leaving')";
    
    if(mysqli_query($connection, $request)){
        $contact_id = mysqli_insert_id($connection);
        echo "<script>
                showSuccessAlert('$contact_id');
              </script>";
    } else {
        echo "<script>
                showErrorAlert('Failed to process booking. Please try again.');
              </script>";
    }
} else {
    echo "<script>
            showErrorAlert('Invalid request method.');
          </script>";
}
?>
