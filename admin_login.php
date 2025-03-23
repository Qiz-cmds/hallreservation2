<?php
session_start();
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "hallreserve"); // Make sure DB name is correct

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;  // Store admin session
        header("Location: admin_dashboard.php");  // Redirect after login
        exit();
    } else {
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding-top: 50px;     background-image: url('image/bg.jpg');
            background-size: cover; /* Makes sure the image covers the entire viewport */
            background-position: center center; /* Centers the image */ font-family : "Times New Roman"; }
        .container {background: #F5F5DC; 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.2); 
            width: 100%;
            max-width: 400px; /* Mobile friendly */
            text-align: center;
            position: relative;
            top: 80px;  /* Moves 20px down from its normal position */
            left: 430px; /* Moves 30px right from its normal position */
         }
         input[type="text"] {
            width: 90%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 5px;
            font-size: 16px;
            border-color: black;
            border: 2px solid black;
            background:rgba(245, 245, 220, 0);
        }
        input[type="password"] {
            width: 90%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 5px;
            font-size: 16px;
            border-color: black;
            border: 2px solid black;
            background:rgba(245, 245, 220, 0);
        }
        input, button { width: 30%; padding: 10px; margin: 10px 0;   border-radius: 15px;}
        button { background-color:rgb(109, 139, 173); color: black; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
    <script>
        function showError(message) {
            alert(message);
        }
    </script>
</head>
<body>

<div class="container">
<img  src="image/Maktab (2).png" alt="description">
<h1>Sabah  College's Court Reservation Website</h1>
    <h2><u>Admin Login</u></h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">CONFIRM</button>
    </form>
</div>

<?php
// Show an error popup if login fails
if (!empty($error_message)) {
    echo "<script>showError('$error_message');</script>";
}
?>

</body>
</html>
