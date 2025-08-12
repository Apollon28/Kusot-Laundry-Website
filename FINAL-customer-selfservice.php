<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Service</title>
    <link rel="icon" type="image/x-icon" href="favicon-32x32.png">
    <link rel="stylesheet" href="FINAL-customer.css">
</head>

<body>
    <div class="logo">
        <img src="FINAL-logo.png" alt="Washing Machine">
    </div>
    <button onclick="goBack()" class="back-button">Back</button>
    <div class="container">
    <form action="selfserviceprocess.php" method="post">
        <div class="customer-details">
            <h2>Customer Details</h2>
            <div class="top-left-info">
            <label for="customer-name">Customer Name:</label>
            <input type="text" id="customer-name" name="customerName" value="<?php echo isset($_SESSION['customerName']) ? $_SESSION['customerName'] : ''; ?>">
            <label for="contact-number">Contact Number:</label>
            <input type="text" id="contact-number" name="contactnumber" value="<?php echo isset($_SESSION['contactnumber']) ? $_SESSION['contactnumber'] : ''; ?>">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <label for="date-of-pickup">Date of Pickup:</label>
            <input type="date" id="date-of-pickup" name="dateofpickup" onchange="setDeliveryDate()" required>
            <label for="date-of-delivery">Date of Delivery:</label>
            <input type="date" id="date-of-delivery" name="dateofdelivery" required>
            </div>
            <p>Note: Estimated delivery within 2-3 working days.</p>
        </div>

        <div class="bottom-section">
            <div class="form-container">
                <h2>Laundry Details</h2>
                <label for="laundry-weight">Laundry Weight (in KG):</label>
                <select id="laundry-weight" name="laundryWeight">
                    <option value="8 KG">8 KG</option>
                    <option value="12 KG">12 KG</option>
                </select>
                <label for="laundry-service">Laundromat:</label>
                <select id="laundry-service" name="laundromat">
                    <option value="1">1 Laundromat</option>
                    <option value="2">2 Laundromat</option>
                    <option value="3">3 Laundromat</option>
                </select>
                <button type="button" onclick="confirmBooking()" class="submit">Check Price</button>

                <p>Note: Price details will be calculated automatically.</p>
                <div class="noteoptional"> 
                        <label for="note-optional">Note (Optional): </label>
                        <input type="text" id="note-optional" name="noteoptional">
                    </div>
            </div>

            <div class="price-breakdown">
                <h2>Price Breakdown</h2>
                <p id="weight">Laundry Weight: -</p>
                <p id="service">Laundromat: -</p>
                <p id="bar"></p>
                <p id="total-price">Total Price: -</p>
                
                    <input type="submit" class="submit" value="Confirm Booking" />
                    <!-- Hidden input field for total price -->
                    <input type="hidden" name="totalprice" id="total-price-input" value="" />
                
            </div>
        </div>
    </div>
</form>
    <script>
        function confirmBooking() {
    // Get selected values
    var selectedWeight = document.getElementById("laundry-weight").value;
    var selectedService = document.getElementById("laundry-service").value;

    // Define prices based on weight
    var prices = {
        '8 KG': { '1': 100, '2': 120, '3': 200 },
        '12 KG': { '1': 130, '2': 150, '3': 250 }
    };

    // Calculate price based on selected weight and service
    var price = prices[selectedWeight][selectedService];

    // Set the total price value
    document.getElementById("total-price-input").value = price;

    // Display price in the price breakdown section
    document.getElementById("weight").textContent = "Laundry Weight: " + selectedWeight ;
    document.getElementById("service").textContent = "Laundromat: " + selectedService;
    document.getElementById("total-price").textContent = "Total Price: PHP" + price;
}

        function setDeliveryDate() {
    var pickupDate = new Date(document.getElementById("date-of-pickup").value);
    var deliveryDate = new Date(pickupDate);
    deliveryDate.setDate(pickupDate.getDate() + 2);

    var formattedDeliveryDate = deliveryDate.toISOString().split('T')[0];
    document.getElementById("date-of-delivery").value = formattedDeliveryDate;
}


    </script>
    <script>
            
        let lastScrollTop = 0;
        window.addEventListener("scroll", function() {
            var currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            if (currentScroll > lastScrollTop) {
                // Scroll down
                document.querySelector('.back-button').style.opacity = '0';
            } else {
                // Scroll up
                document.querySelector('.back-button').style.opacity = '1';
            }
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // For Mobile or negative scrolling
        }, false);

        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>