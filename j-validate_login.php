<?php
session_start(); // Start session at the beginning of the script

$email = $_POST['email'];
$password = $_POST['password'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'laundry');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Define the timeout period (in seconds)
$timeout_period = 20; // Set the timeout period in seconds

$stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch user details
    $user = $result->fetch_assoc();

    // Verify the entered password against the hashed password from the database
    if (md5($password) === $user['password']) {
        // Passwords match, proceed with login
        // Start session and store user details
        $_SESSION['customerName'] = $user['firstName'] . ' ' . $user['lastName'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['contactnumber'] = $user['number'];

        // Reset failed attempts counter
        unset($_SESSION['login_attempts']);

        // Redirect to the booking form
        header("Location: FINAL-laundryservices.html");
        exit(); // Exit after redirection
    } else {
        // Increment failed login attempts
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 1;
            $_SESSION['last_login_attempt_time'] = time();
        } else {
            $_SESSION['login_attempts']++;
        }

        // Check if maximum attempts reached within the timeout period
        if ($_SESSION['login_attempts'] > 2) {
            // Check if timeout period has expired
            if (time() - $_SESSION['last_login_attempt_time'] <= $timeout_period) {
                // Display alert and exit
                echo "<script>alert('Maximum login attempts reached. Please try again later (20 seconds).')</script>";
                exit();
            } else {
                // Reset login attempts counter and last login attempt time
                $_SESSION['login_attempts'] = 1;
                $_SESSION['last_login_attempt_time'] = time();
            }
        }

        // Redirect back to login page
        header("Location: a-login.html?error=1");
        exit(); // Exit after redirection
    }
} else {
    // Invalid email or user not found, redirect to login page
    header("Location: a-login.html?error=1");
    exit(); // Exit after redirection
}
?>
