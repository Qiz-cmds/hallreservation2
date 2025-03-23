<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['phoneNo']) && !isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

$name = ""; // Default name

if (isset($_SESSION['admin'])) {
    $name = "Admin"; // Set name for admin
} elseif (isset($_SESSION['phoneNo'])) {
    $phoneNo = $_SESSION['phoneNo'];

    // Fetch user's name from database
    $query = "SELECT name FROM customer WHERE phoneNo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $phoneNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row['name']; // Set user's name
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center;     background-image: url('image/bg.jpg');
            background-size: cover; /* Makes sure the image covers the entire viewport */
            background-position: center center; /* Centers the image */
         }

        .container {font-family : "Times New Roman"; max-width: 400px; min-height:500px; margin: 100px auto; padding: 20px; background: #F5F5DC; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
.image {max-width:20px; min-height:20px;}
        a { display: block; margin: 10px auto; padding: 15px; background: rgba(207, 212, 193, 0); color: black; text-decoration: none; border-radius: 5px; max-width: 300px; 
            border: 2px solid black;}
        
        a:hover { background: #0056b3; }
       .images{max-width:10%; min-height:10%;

       }
        .text{  top: 160px;  /* Moves 20px down from its normal position */ left: 5px; /* Moves 30px right from its normal position */}
    </style>
</head>
<body>

<div class="container">
<div class = "image" >
 <img  src="image/Maktab (2).png" alt="description">
</div>
<div class="text">
<h1>Sabah  College's Court Reservation Website</h1>
</div>
    <h2>Welcome, <?= htmlspecialchars($name) ?>!</h2>

    <?php if (isset($_SESSION['admin'])): ?>
        <h3><u>Admin Panel</u></h3>
        <a href="admin_dashboard.php">Go to Admin Dashboard</a>
        <a href="logout.php">Logout</a>

    <?php elseif (isset($_SESSION['phoneNo'])): ?>
        <h3><u>Customer Panel</u></h3>
        <a href="reservation.php">Make a Reservation</a>
        <a href="view_reservations.php">View Your Reservations</a>
        <a href="logout.php">Logout</a>

 <div class="collab" >
 <p > in collaboration of </p>
 </div>
 <div class ="images">
 <img  src="image/trigod.png" alt="description">
 </div>

<div class class="contact" >
<p > Cg Sahibil (+60168173211) </p>
</div>
    <?php endif; ?>
</div>

</div>
</body>
</html>
