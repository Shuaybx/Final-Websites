<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: Sealife Login Form.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sealife Contact</title>
    <link rel="stylesheet" type="text/css" href="Sealife.css">
    <link rel="icon" href="Icon Image.png" type="image/x-icon">
    
    <style>

        body {
            font-family: 'Roboto';
            background-color: #222;
            color: white;
            text-align: center;
        }

        p {
            color: peachpuff;
            font-weight: bold; 
            font-size: 24px;
            text-align: right;
            font-family: 'Franklin Gothic Medium', Arial, sans-serif;
        }

        h4 {
            font-weight:bold;
            font-size:28px
        }

        .container {
            padding: 12px 24px;
            margin: 48px auto; 
            background: #927a11;
            border-radius: 4px;
            width: 100%;
            max-width: 600px; 
            text-align: left;
        }
        label {
            font-size: 0.85em;
            color: aquamarine;
            margin-left: 12px;
            display: block;
        }
        input[type="text"], input[type="email"], textarea {
            width: 80%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 6px;
            margin-bottom: 16px;
            resize: vertical;
        }
        input:focus, textarea:focus {
            border: 1px solid green;
        }
        input[type="submit"] {
            background: #3af1b4;
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
            background: #43effc;
        }

        .thank-you-message {
            background-color: black;
            color: white;
            padding: 20px;
            border-radius: 5px;
            display: none;
            margin: 20px auto;
            text-align: center;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .thank-you-message h1 {
            font-size: 2.5em;
        }
        .thank-you-message p {
            font-size: 1.2em;
        }

        .LOGO {

border: 2px solid silver;
height:150px;
width:150px

}

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
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: black;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            min-width: 100px;
            border-radius: 5px;
            transform: translateX(-20px);
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
        }

        .dropdown-content a:hover {
            background-color: white;
            color: black;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: gray;
        }

    </style>
</head>
<body>

    <div class="dropdown">
        <button class="dropbtn">Menu</button>
        <div class="dropdown-content">
            <a href="Sealife Login Page.php">Login Page</a>
            <a href="Creature Presentation Slideshow.html">Creature Presentation Slideshow</a>
            <a href="Sealife Contact Us.php">Contact Us</a>
        </div>
    </div>

    <img src="Seallife Express.jpg" class="LOGO" alt="Sealife Logo">

    <div class="container">
        <h4>Contact Me </h4>
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

    <div id="thankYouMessage" class="thank-you-message">
        <h1>Thank You!</h1>
        <p>Your message has been successfully sent. We appreciate your feedback and will get back to you shortly.</p>
    </div>

    <script>

        function showThankYouMessage(event) {
            event.preventDefault();
            document.querySelector('.container').style.display = 'none';
            document.getElementById('thankYouMessage').style.display = 'block';
        }
    
        
    </script>

</body>
</html>
