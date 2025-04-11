<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: Store Login Form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <img src="Logo Hardware .JPG" class="LOGOZ" alt="Hardware Logo">

    <title> Contact</title>
    <link rel="stylesheet" type="text/css" href="Hardware.css">
    <link rel="icon" href="Hardware Icon.jpg" type="image/x-icon">

</head>


    <style>

        /* General Styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            color: #f1f1f1;
            text-align: center;
        }

        .LOGOZ {
        
            height: 15vh;
            width: 10vw;

        }

        p {
            color: #ff6b6b;
            font-weight: bold; 
            font-size: 24px;
            text-align: right;
            font-family: 'Franklin Gothic Medium', Arial, sans-serif;
        }

        h4 {
            font-weight: bold;
            font-size: 28px;
            color: #e63946;
        }

        /* Contact Form */
        .container {
            padding: 12px 24px;
            margin: 48px auto; 
            background: #1e1e1e;
            border: 1px solid #555;
            border-radius: 6px;
            width: 100%;
            max-width: 600px; 
            text-align: left;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.2);
        }

        label {
            font-size: 0.85em;
            color: #f94144;
            margin-left: 12px;
            display: block;
        }

        input[type="text"], input[type="email"], textarea {
            width: 90%;
            padding: 12px;
            border: 1px solid #666;
            border-radius: 4px;
            margin-top: 6px;
            margin-bottom: 16px;
            background-color: #2c2c2c;
            color: white;
        }

        input:focus, textarea:focus {
            border: 1px solid #e63946;
            outline: none;
        }

        input[type="submit"] {
            background: #d90429;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            display: block;
            width: 100%;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background: #ef233c;
        }

        /* Thank You Message */
        .thank-you-message {
            background-color: #1a1a1a;
            color: white;
            padding: 20px;
            border-radius: 6px;
            display: none;
            margin: 20px auto;
            text-align: center;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(255, 0, 0, 0.2);
        }

        .thank-you-message h1 {
            font-size: 2.5em;
            color: #ff4d4d;
        }

        .thank-you-message p {
            font-size: 1.2em;
            color: #ccc;
        }

        .LOGO {
            border: 2px solid #777;
            height: 150px;
            width: 150px;
            margin-top: 20px;
        }

        /* Dropdown Menu */
        .dropdown {
            position: absolute;
            top: 20px;
            right: 8px;
            display: inline-block;
        }

        .dropbtn {
            background-color: #000;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: 1px solid #444;
            cursor: pointer;
            border-radius: 5px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #1e1e1e;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
            z-index: 1;
            min-width: 140px;
            border-radius: 5px;
            transform: translateX(-20px);
        }

        .dropdown-content a {
            color: #ddd;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: background 0.3s, color 0.3s;
        }

        .dropdown-content a:hover {
            background-color: #ff4d4d;
            color: black;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #333;
        }

    </style>
</head>
<body>


    <!-- Navigation -->
    <div class="dropdown">
        <button class="dropbtn">Menu</button>
        <div class="dropdown-content">
            <a href="Store Login Form.php">Login Page</a>
            <a href="Hardware Home Page.html">Home Area</a>
            <a href="Store Main Page.html">Hardware Store</a>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="container">
        <h4>Contact Me</h4>
        <form name="contact_form" onsubmit="showThankYouMessage(event)">
            <label for="first_name">Username</label>
            <input name="first_name" type="text" required placeholder="Enter Name">
            
            <label for="last_name">Phone Number</label>
            <input name="last_name" type="text" required placeholder="Dial Personal Number">
            
            <label for="email">Email</label>
            <input name="email" type="email" required placeholder="you@gmail/hotmail.com">
            
            <label for="message">Message</label>
            <textarea name="message" cols="30" rows="10" placeholder="Enter your query message here ..." required></textarea>
            
            <input type="submit" value="Submit">
        </form>
    </div>


    <!-- Thank You Message -->
    <div id="thankYouMessage" class="thank-you-message">
        <h1>Thank You!</h1>
        <p>Your message has been successfully sent. We appreciate your feedback and will get back to you shortly.</p>
    </div>

    <script>
        // Show Thank You Message and Hide Form
        function showThankYouMessage(event) {
            event.preventDefault();
            document.querySelector('.container').style.display = 'none';
            document.getElementById('thankYouMessage').style.display = 'block';
        }
    </script>

</body>
</html>