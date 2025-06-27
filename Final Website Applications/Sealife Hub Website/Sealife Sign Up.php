<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
    $conn = new mysqli("localhost", "root", "", "sealife_hub_site");
    if ($conn->connect_error) {
        die("Connection failed.");
    }

    $username = $_POST["username"];
    $new_email = $_POST["email"];
    $new_password = $_POST["password"];

    $stmt = $conn->prepare("UPDATE userdetails SET email = ?, password = ? WHERE name = ?");
    $stmt->bind_param("sss", $new_email, $new_password, $username);

    if ($stmt->execute()) {
        echo "User updated!";
    } else {
        echo "Update failed.";
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
session_start();

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "sealife_hub_site";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (
        empty($username) || empty($password) || empty($email) ||
        !preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        $error_message = "Error, unacceptable data has been entered for this form to register in.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM userdetails WHERE name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Username already taken.";
        } else {
            $stmt = $conn->prepare("INSERT INTO userdetails (name, password, email) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $password, $email);

            if ($stmt->execute()) {
                header("Location: Sealife Login Page.php");
                exit();
            } else {
                $error_message = "Error storing data. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Sealife.css">
    <link rel="icon" href="Icon Image.jpg" type="image/x-icon">
    <title>Sea Life Sign In</title>

    <style>
        input[type=text], input[type=password], select {
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

.form-error {
    border: 3px solid red !important;
}


        h2 {
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
        }

        form {
            border: 3px solid #f1f1f1;
            width: 50%;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .LOGO {
            border: 2px solid silver;
            height: 150px;
            width: 150px;
            margin: 20px;
        }

        button {
            background-color:rgb(235, 52, 24);
            color: white;
            padding: 14px 24px;
            margin-top: 12px;
            border: none;
            border-radius: 8px;
            width: 60%;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color:rgb(16, 20, 20);
            transform: scale(1.03);
        }

        label {
            font-style: oblique;
            display: block;
            font-family:Georgia, 'Times New Roman', Times, serif;
            font-style:bold;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .dropdown {
            position: absolute;
            top: 20px;
            right: 15px;
            display: inline-block;
            z-index: 999;
        }

        .dropbtn {
            background-color: black;
            color: white;
            padding: 16px 50px;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            outline: none;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: black;
            min-width: 160px;
            border-radius: 6px;
            overflow: hidden;
            padding: 0;
            margin: 0;
            border: none;
            box-shadow: none;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            display: block;
            font-size: 15px;
            background-color: black;
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: #333;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #222;
        }
    </style>
</head>

<body>

    <img src="Seallife Express.jpg" class="LOGO">

    <div class="dropdown">
        <button class="dropbtn"> Menu </button>
        <div class="dropdown-content">
            <a href="Sealife Login Page.php">Login Page</a>
            <a href="Creature Presentation Slideshow.html">Creature Presentation Slideshow</a>
            <a href="Sealife Contact Us.php">Contact Us</a>
        </div>
    </div>

    <?php if (!empty($error_message)): ?>
        <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <div style="display: flex; justify-content: center; align-items: flex-start; gap: 50px; flex-wrap: wrap; margin-top: 30px;">
        
        <!-- Sign-Up Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
              class="<?php echo !empty($error_message) ? 'form-error' : ''; ?>" 
              style="flex: 1; min-width: 350px; max-width: 500px;">
            <h2>Sealife Account Sign Up</h2>

            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Email Address:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Register</button>
        </form>

        <!-- Update Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
              style="flex: 1; min-width: 350px; max-width: 500px;">
            <input type="hidden" name="update" value="1">
            <h2 style="margin-bottom: 25px;">Update Account</h2>

            <label>Username:</label>
            <input type="text" name="username" required>

            <label>New Email:</label>
            <input type="email" name="email" required>

            <label>New Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Update</button>
        </form>
    </div>

<script>
function validateForm() {
    const form = document.querySelector("form");
    const name = form.name.value.trim();
    const email = form.email.value.trim();
    const message = form.message.value.trim();
    let isValid = true;

    form.querySelectorAll(".form-control").forEach(input => {
        input.classList.remove("is-invalid");
    });

    if (name === "") {
        form.name.classList.add("is-invalid");
        isValid = false;
    }

    if (email === "" || !/\S+@\S+\.\S+/.test(email)) {
        form.email.classList.add("is-invalid");
        isValid = false;
    }

    if (message === "") {
        form.message.classList.add("is-invalid");
        isValid = false;
    }

    return isValid;
}

</script>
</form>


</body>
</html>
