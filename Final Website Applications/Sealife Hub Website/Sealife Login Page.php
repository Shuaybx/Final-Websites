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


if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = trim($data['username'] ?? '');

    if (!isset($_SESSION['user']) || $_SESSION['user'] !== $username) {
        http_response_code(403);
        echo json_encode(["success" => false, "message" => "Unauthorized deletion attempt"]);
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM userdetails WHERE name = ?");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        session_destroy();
        echo json_encode(["success" => true, "message" => "Account deleted successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Execute failed: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}


$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password) || !preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $error_message = "Error, unacceptable data has been entered for this form to register in.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM userdetails WHERE name = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            session_regenerate_id(true);
            $_SESSION['user'] = $username;
            header("Location: Sealife Contact Us.php");
            exit();
        } else {
            $error_message = "Error, unacceptable data has been entered for this form to register in.";
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
    <title>Sea Life Login</title>

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

        h2 {
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
        }

        form {
            border: 3px solid #f1f1f1;
            width: 40%;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .form-error {
            border: 3px solid red !important;
        }

        .LOGO {
            border: 2px solid silver;
            height: 150px;
            width: 150px;
            margin: 20px;
        }

        button {
            background-color:rgb(219, 171, 37);
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
            color: black;
            text-align: center;
            margin-top: 10px;
            font-family:Georgia, 'Times New Roman', Times, serif;
            background: linear-gradient(to bottom right, #e0ffff, #d35151);
            padding: 40px;
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
            <a href="Sealife Home Page.html">Home Page</a>
            <a href="Creature Presentation Slideshow.html">Creature Presentation Slideshow</a>
            <a href="Sealife Sign Up.php">Sign Up</a>
        </div>
    </div>

    <?php if (!empty($error_message)): ?>
        <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
          class="<?php echo !empty($error_message) ? 'form-error' : ''; ?>">
        <h2>Sealife Account Login In!</h2>

        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>


<?php if (isset($_SESSION['user'])): ?>
    <form id="deleteForm" onsubmit="return deleteAccount();">
        <button type="submit" style="background-color: red; margin-top: 20px;">Delete My Account</button>
    </form>
<?php endif; ?>



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

function deleteAccount() {
    if (!confirm("Are you sure you want to delete your account? This cannot be undone.")) {
        return false;
    }

    fetch(location.href, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: 'include', 
        body: JSON.stringify({ username: '<?= $_SESSION["user"] ?? "" ?>' })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            window.location.href = 'Sealife Home Page.html';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Failed to delete account.");
    });

    return false;
}

</script>
</body>
</html>
