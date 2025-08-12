<?php
session_start();

// Retrieve form data
$totalprice = isset($_POST['totalprice']) ? $_POST['totalprice'] : null;
$customerName = isset($_POST['customerName']) ? $_POST['customerName'] : null;
$address = isset($_POST['address']) ? $_POST['address'] : null;
$contactnumber = isset($_POST['contactnumber']) ? $_POST['contactnumber'] : null;
$dateofpickup = isset($_POST['dateofpickup']) ? $_POST['dateofpickup'] : null;
$dateofdelivery = isset($_POST['dateofdelivery']) ? $_POST['dateofdelivery'] : null; // Changed variable name to dateofdelivery
$laundryWeight = isset($_POST['laundryWeight']) ? $_POST['laundryWeight'] : null;
// $clothesType = isset($_POST['clothesType']) ? $_POST['clothesType'] : null;
$clothesType = "Regular"; // New column
$laundromat = "1";
$laundryService = isset($_POST['laundryService']) ? $_POST['laundryService'] : null;

// Validate that required fields are not null
if ($totalprice !== null && $customerName !== null && $address !== null && $contactnumber !== null && $dateofpickup !== null && $dateofdelivery !== null && $laundryWeight !== null && $clothesType !== null && $laundromat !== null && $laundryService !== null) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'laundry');
    if ($conn->connect_error) {
        echo "Connection Failed: " . $conn->connect_error;
        exit;
    }

    // Insert the new booking
    $stmt = $conn->prepare("INSERT INTO customerdetails (customerName, `address`, contactnumber, dateofpickup, dateofdelivery, laundryWeight, clothesType, laundromat, laundryService, totalprice) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?, ?)");
    $stmt->bind_param("sssssssssd", $customerName, $address, $contactnumber, $dateofpickup, $dateofdelivery, $laundryWeight, $clothesType, $laundromat, $laundryService,  $totalprice); // Changed variable name to dateofdelivery
    $execval = $stmt->execute();

    if (!$execval) {
        echo "Error: " . $stmt->error;
    } else {
        // Update the total profit
        $updateStmt = $conn->prepare("UPDATE profit SET amount = amount + ?");
        $updateStmt->bind_param("d", $totalprice);
        $updateExecVal = $updateStmt->execute();

        if ($updateExecVal) {
            // Store order details in session
            $_SESSION['orderDetails'] = array(
                'customerName' => $customerName,
                'address' => $address,
                'contactnumber' => $contactnumber,
                'dateofpickup' => $dateofpickup,
                'dateofdelivery' => $dateofdelivery, // Changed variable name to dateofdelivery
                'laundryWeight' => $laundryWeight,
                'clothesType' => $clothesType, // Include new column in session data
                'laundromat' => $laundromat,
                'laundryService' => $laundryService,
                'totalprice' => $totalprice
            );

            // Redirect to the order history page
            header("Location: order.php");
            exit();
        } else {
            echo "Error updating profit: " . $updateStmt->error;
        }

        $updateStmt->close();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Error: Required fields are null. Fields: totalprice=$totalprice, customerName=$customerName, address=$address, contactnumber=$contactnumber, dateofpickup=$dateofpickup, dateofdelivery=$dateofdelivery, laundryWeight=$laundryWeight, clothesType=$clothesType, laundryService=$laundryService";
}
?>
