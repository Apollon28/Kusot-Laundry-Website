<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dry cleaning</title>
    <link rel="icon" type="image/x-icon" href="favicon-32x32.png">
    <link rel="stylesheet" href="FINAL-customer.css">
</head>

<body>
    <div class="logo">
        <img src="FINAL-logo.png" alt="Washing Machine">
    </div>
    <button onclick="goBack()" class="back-button">Back</button>
    <div class="container">
    <form action="dryorderprocess.php" method="post">
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
                <label for="laundry-weight">Number of Piece/s:</label>
                <select id="laundry-weight" name="laundryWeight">
                    <option value="1-3 pcs">1-3 pieces</option>
                    <option value="4-6 pcs">4-6 pieces</option>
                </select>
                <label for="laundry-service">Clothes Type:</label>
                <select id="laundry-service" name="clothesType">
                    <option value="Barong Jusi">Barong Jusi</option>
                    <option value="Barong Pina">Barong Pina</option>
                    <option value="Suit (Top)">Suit (Top)</option>
                    <option value="Suit (Trousers)">Suit (Trousers)</option>
                    <option value="Gown">Gown</option>
                    <option value="Wedding Gown">Wedding Gown</option>
                    
                </select>
                <button type="button" onclick="confirmBooking()" class="submit">Check Price</button>
                <p>Note: Price details will be calculated automatically.</p>
            </div>
            <div class="price-breakdown">
                <h2>Price Breakdown</h2>
                <p id="pieces">Number of Piece/s: -</p>
                <p id="type">Clothes Type: -</p>
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
        '1-3 pcs': { 'Barong Jusi': 130, 'Barong Pina': 150, 'Suit (Top)': 250 , 'Suit (Trousers)':300 , 'Gown':500,'Wedding Gown':700},
        '4-6 pcs': { 'Barong Jusi': 160, 'Barong Pina': 180, 'Suit (Top)': 280 , 'Suit (Trousers)':330 , 'Gown':530,'Wedding Gown':730}
    };

    // Calculate price based on selected weight and service
    var price = prices[selectedWeight][selectedService];

    // Display price in the price breakdown section
    document.getElementById("pieces").textContent = "Number of Piece/s: " + selectedWeight;
    document.getElementById("type").textContent = "Clothes Type: " + selectedService;
    document.getElementById("total-price").textContent = "Total Price: PHP" + price;

    // Set the value of the totalprice input field
    document.getElementById("total-price-input").value = price;
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