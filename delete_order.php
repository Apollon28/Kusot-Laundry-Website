<?php
session_start();

// Check if order ID is provided in the URL
if (isset($_GET['id'])) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'laundry');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Escape special characters to prevent SQL injection
    $orderId = $conn->real_escape_string($_GET['id']);

    // Delete the order from the database
    $sql = "DELETE FROM customerdetails WHERE orderID = '$orderId'";
    if ($conn->query($sql) === TRUE) {
        // Order deleted successfully
        $_SESSION['delete_success'] = true;
    } else {
        // Error occurred while deleting the order
        $_SESSION['delete_error'] = true;
    }

    // Close the database connection
    $conn->close();
}

// Redirect back to order.php
header("Location: order.php");
exit();
?>