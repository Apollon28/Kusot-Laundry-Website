<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUSOT LAUNDRY</title>
    <link rel="icon" type="image/x-icon" href="favicon-32x32.png">
    <link rel="stylesheet" href="order.css">
</head>

<body>
    <style>
        body,
        html {
            overflow: hidden;
        }
    </style>
<script>
        function addOrder() {
            window.location.href = 'FINAL-laundryservices.html';
        }
        function deleteOrder(id) {
            if (confirm("Are you sure you want to delete this order?")) {
                // Redirect to delete script with order ID
                window.location.href = 'delete_order.php?id=' + id;
            }
        }
    </script>
    <div class="main">

        <!-- Navbar -->
        <div class="navbar">
            <div class="lg-about">
                <a href="FINAL-laundryservices.html">
                    <img src="logo.png" height="80" width="80">
                </a>
            </div>

            <input type="checkbox" id="menu-toggle">
            <label for="menu-toggle" class="menu-icon">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </label>
            <div id="menu-options" class="menu-options">
            <a href="FINAL-laundryservices.html">Services</a>
                <a href="FINAL-about.html">About</a>
                <a href="FINAL-faqs.html">FAQs</a>
                <a href="profile.php">Account</a>
                <a href="order.php">Orders</a>
                <a href="index.html">Logout</a>
            </div>
        </div>
        <div class="head">
            <h3 class="lanser">Orders</h3>
        </div>
    
    <h1><br></h1>
    <table id="order-history">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Date of Pickup</th>
                <th>Date of Delivery</th>
                <th>Laundry Weight</th>
                <th>Clothes Type</th>
                <th>Laundromat</th>
                <th>Laundry Service</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'laundry');
        if ($conn->connect_error) {
            echo "$conn->connect_error";
            die("Connection Failed: " . $conn->connect_error);
        }

        // Retrieve and display customer orders
        if (isset($_SESSION['orderDetails'])) {
            $customerName = $_SESSION['orderDetails']['customerName'];

            $result = $conn->query("SELECT * FROM customerdetails WHERE customerName = '$customerName'");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['customerName'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['contactnumber'] . "</td>";
                    echo "<td>" . $row['dateofpickup'] . "</td>";
                    echo "<td>" . $row['dateofdelivery'] . "</td>";
                    echo "<td>" . $row['laundryWeight'] . "</td>";
                    if ($row['clothesType'] == "Regular"){
                        echo "<td>" . $row['clothesType'] . "</td>";
                    }
                    else{
                        echo "<td>" . $row['clothesType'] . " </td>";
                    }
                    if ($row['laundromat'] == "1"){
                        echo "<td>" . $row['laundromat'] . "</td>";
                    }
                    else{
                        echo "<td>" . $row['laundromat'] . " </td>";
                    }
                    if ($row['laundryService'] == "Dry Clean"){
                        echo "<td>" . $row['laundryService'] . "</td>";
                    }
                     else if ($row['laundryService'] == "Self-Service"){
                        echo "<td>" . $row['laundryService'] . "</td>";
                    }
                    else{
                        echo "<td>" . $row['laundryService'] . " </td>";
                    }
                    
                    echo "<td>PHP " . $row['totalprice'] . "</td>";
                    echo "<td>";
                    echo "<input type = 'button' class = 'delete' value='Delete' onclick='deleteOrder(" . $row['orderID'] . ")'>";
                    echo "</td>";
                    echo "</tr>";

                }
            } else {
                echo "<p>No orders found for this customer.</p>";
            }
        } else {
            echo "<p>No recent orders found.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
        </tbody>
    </table>
    <div class="add-order-container">
    <button onclick="addOrder()">Add Order</button>
</div>
</body>
</html>
