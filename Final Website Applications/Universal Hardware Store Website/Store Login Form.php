<?php
session_start();

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "product_search";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$error_message = "";
$input_error = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');


    if (empty($username) || empty($password) ||
        !preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $error_message = "Please enter a valid username and password.";
        $input_error = true;

    } else {
        $stmt = $conn->prepare("SELECT * FROM  logdetails WHERE name = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $_SESSION['user'] = $username;
            session_regenerate_id(true); 
            header("Location: Universal Supply Contact Us.php");
            exit();
        } else {
            $error_message = "Incorrect username or password.";
            $input_error = true;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Universal Software Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Hardware.css">
    <link rel="icon" href="Hardware Icon.jpg" type="image/x-icon">
    <style>
        body {
            background-color: #222;
            color: white;
            font-family: 'Roboto', sans-serif;
        }

        .LOGO {
            display: block;
            margin: 0 auto;
            border: 2px solid silver;
            height: 150px;
            width: 200px;
        }

        h2 {
            text-align: center;
            color: red;
            font-size: 32px;
            background-color: lightblue;
            padding: 10px;
            border: 1px solid red;
            outline: 5px dotted green;
        }

        form {
            width: 50%;
            margin: 30px auto;
            padding: 20px;
            background: #444;
            border-radius: 10px;
            box-shadow: 0 0 10px black;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input.input-error {
            border: 2px solid red;
            background-color: #ffe6e6;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #b85129;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 18px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-box {
            background-color: red;
            color: white;
            padding: 12px;
            margin: 20px auto;
            width: 50%;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0 0 10px darkred;
        }

        footer {
            text-align: center;
            color: #ccc;
            padding: 10px;
            background-color: #111;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .dropdown {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .dropbtn {
            background-color: #000;
            color: white;
            padding: 16px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #222;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            border-radius: 5px;
            min-width: 160px;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ff4d4d;
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

    <img src="Logo Hardware .JPG" alt="Hardware Logo" class="LOGO">

    <div class="dropdown">
        <button class="dropbtn">Menu</button>
        <div class="dropdown-content">
            <a href="Hardware Home Page.html">Home Page</a>
            <a href="Universal Supply Contact Us.php">Contact Us</a>
            <a href="Store Main Page.html">Hardware Store</a>
        </div>
    </div>

    <h2>Login to Universal Hardware Store Site!</h2>

    <?php if (!empty($error_message)) : ?>
        <div class="error-box"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" class="<?= $input_error ? 'input-error' : '' ?>" required>

        <label for="password">Password:</label>
        <input type="password" name="password" class="<?= $input_error ? 'input-error' : '' ?>" required>

        <button type="submit">Login</button>
    </form>

    <footer>
        <p>&copy; Shuayb Mohammed 120529 — Universal Hardware Store</p>
    </footer>

</body>
</html>
