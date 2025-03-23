<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phoneNo = $_POST['phoneNo'];
    $name = $_POST['name'];

    // Check if phone number length is valid
    if (strlen($phoneNo) < 10 || strlen($phoneNo) > 14) {
        $message = "<p class='error'>Error: Phone number must be between 10 and 14 characters.</p>";
    } else {
        // Check if phone number already exists
        $checkQuery = "SELECT * FROM customer WHERE phoneNo = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $phoneNo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If phone number exists, show error message
            $message = "<p class='error'>Error: Duplicate entry! This phone number is already registered. <a href='login.php'>Login here</a></p>";
        } else {
            // Insert new customer
            $insertQuery = "INSERT INTO customer (phoneNo, name) VALUES (?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ss", $phoneNo, $name);

            if ($stmt->execute()) {
                $message = "<p class='success'>Sign-up successful! <a href='login.php'>Login here</a></p>";
            } else {
                $message = "<p class='error'>Error: " . $conn->error . "</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('image/bg.jpg');
            background-size: cover; /* Makes sure the image covers the entire viewport */
            background-position: center center; /* Centers the image */
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            font-family : "Times New Roman";
            width: 90%;
            max-width: 400px;
            margin: 50px auto;
            background: #F5F5DC;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            position: relative;
            top: 60px;  /* Moves 20px down from its normal position */
            left: 5px; /* Moves 30px right from its normal position */
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

        button {
            width: 30%;
            padding: 10px;
            background:rgba(207, 212, 193, 0.98);
            color: black;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
          
        }

        button:hover {
            background: rgb(109, 139, 173);
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            input[type="text"], button {
                font-size: 14px;
            }
        }
    </style>
    <script>
        function validatePhoneNumber() {
            let phoneInput = document.getElementById("phoneNo");
            let phoneValue = phoneInput.value.trim();

            // Ensure input is only numbers and within valid length
            if (!/^\d{10,14}$/.test(phoneValue)) {
                alert("Phone number must be between 10 and 14 digits and contain only numbers.");
                return false; // Prevent form submission
            }
            return true; // Allow submission
        }
    </script>
</head>
<body>

<div class="container">
<img  src="image/Maktab (2).png" alt="description">
<h1>Sabah  College's Court Reservation Website</h1>
    <h2><u>Sign Up</u></h2>

    <?= $message ?? '' ?> <!-- Display success/error message -->

    <form method="post" onsubmit="return validatePhoneNumber();">
    <label for="name">Your name:</label><br>
        <input type="text" name="name" placeholder="Full Name" required>
        <br>
        <br>
        <label for="no">Your Phone Number:</label><br>
        <input type="text" id="phoneNo" name="phoneNo" placeholder="Phone Number" required minlength="10" maxlength="14" pattern="\d{10,14}" title="Phone number must be 10-14 digits.">
        <br>
        <br>
        <button type="submit">confirm</button>
    </form>
</div>

</body>
</html>

