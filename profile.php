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
    <link rel="stylesheet" href="profile.css">
</head>

<body>
    <style>
        body,
        html {
            overflow: hidden;
        }
    </style>

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
            <h3 class="lanser">Account</h3>
        </div>

        <!--PROFILE ITO -->
        <div class="profile">
            <img src="noprofilepic.png" alt="Profile Picture" class="profile-picture">
            <h1 class="profile-name">Profile</h1>
        </div>
        <ul class="profile-info">
            <li class="prcm"><strong>Customer Name:</strong> <?php echo isset($_SESSION['customerName']) ? $_SESSION['customerName'] : ''; ?></li>
            <li class="prem"><strong>Email:</strong> <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?></li>
            <li class="prcn"><strong>Contact Number:</strong> <?php echo isset($_SESSION['contactnumber']) ? $_SESSION['contactnumber'] : ''; ?></li>
        </ul>
        <!--Hanggang dito-->

       
        </div>

    </div>
</body>

</html>
