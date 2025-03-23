<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            background-color: #f4f4f4;
            padding-top: 50px;
            background-image: url('image/bg.jpg');
            background-size: cover; /* Makes sure the image covers the entire viewport */
            background-position:  center center; /* Centers the image */ 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0;
        }
        .container {
            font-family : "Times New Roman";
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            background: #F5F5DC;
        }
        h2 { color: #333; }
        .btn {
            display: block;
            width: 30%;
            margin: 10px auto;
            padding: 15px;
            font-size: 18px;
            background-color:rgba(0, 123, 255, 0);
            color: black;
            border: 2px solid black;
           
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn:hover { background-color: #0056b3; }
        .logout { background-color: rgba(0, 123, 255, 0); }
        .logout:hover { background-color: darkred; }
    </style>
</head>
<body>
   
    

<div class="container">
    <div class ="logo">
    <img  src="image/Maktab (2).png" alt="description">
</div>
<div class="text">
<h1>Sabah  College's Court Reservation Website</h1>
</div >
<h2>Admin Dashboard</h2>
<a href="view_reservations.php" class="btn">View All Reservations</a>
<a href="logout.php" class="btn logout">Logout</a>
</div>

</body>
</html>

