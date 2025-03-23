<?php
session_start();
include 'db.php';

if (!isset($_SESSION['phoneNo'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $phoneNo = $_SESSION['phoneNo'];
    $court_id = $_POST['court_id'];
    $day = $_POST['day'];
    $hours = $_POST['hours'] ?? []; // Array of selected hours
    $name = $_POST['name'];

    if (!empty($hours)) {
        foreach ($hours as $hour) {
            $query = "REPLACE INTO reservation (phoneNo, court_id, day, hour, name) VALUES ('$phoneNo', '$court_id', '$day', '$hour', '$name')";
            $conn->query($query);
        }
        echo "<script>alert('Reservation successful!');</script>";
    } else {
        echo "<script>alert('Please select at least one time slot.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Reservation</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center;    background-image: url('image/bg.jpg');
            background-size: cover; /* Makes sure the image covers the entire viewport */
            background-position: center center; /* Centers the image */  font-family : "Times New Roman";}
        .container { width: 50%; margin: 50px auto; background: #F5F5DC; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .checkbox-group { display: flex; flex-wrap: wrap; justify-content: center;  border: 2px solid rgb(7, 10, 13);
            border-radius: 5px; }

        label { margin: 5px;
             display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color:rgb(176, 195, 218);
            color: black;
            border-radius: 15px;
           
            transition: 0.3s ease-in-out; }
        .price { font-weight: bold; margin-top: 10px; color: green; }
        button { margin-top: 20px; padding: 10px; border: none; background: rgb(72, 128, 197); color: white; border-radius: 15px; cursor: pointer; 
            width: 15% ;
             top: 675px;  /* Moves 20px down from its normal position */
        left: 720px; /* Moves 30px right from its normal position */
    position: absolute;}

        button:hover { background: #0056b3; }
        .back-btn { display: block; margin-top: 10px; text-decoration: none; color: white; background: gray; padding: 10px; border-radius: 15px; 
             width: 30%;     top: 670px;  /* Moves 20px down from its normal position */
        left: 320px; /* Moves 30px right from its normal position */
    }
        .back-btn:hover { background: darkgray; }
        input[type="text"] {
            width: 50%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 5px;
            font-size: 16px;
            border-color: black;
            border: 2px solid black;
            background:rgba(245, 245, 220, 0);}

            input[type="date"] {
            width: 50%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 5px;
            font-size: 16px;
            border-color: black;
            border: 2px solid black;
            background:rgba(245, 245, 220, 0);}

            input[type="checkbox"] {
                display: none;}

            input[type="checkbox"]:checked + label {
            display: none;
            width: 50%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 25px;
            font-size: 16px;
            border-color: black;
            border: 2px solid black;
            background:rgba(245, 245, 220, 0);
        }
        label:hover{
            background-color:rgb(72, 128, 197);
            color:black;
        }
        
            select {  width: 54%; 
            padding: 10px; 
            margin: 10px 0; 
            border: 1px solid #ddd; 
            border-radius: 5px;
            font-size: 16px;
            border-color: black;
            border: 2px solid black;
            background:rgba(245, 245, 220, 0);}


    </style>
    <script>
        function updatePrice() {
            let checkboxes = document.querySelectorAll('input[name="hours[]"]:checked');
            let totalPrice = checkboxes.length * 10; // RM10 per hour
            document.getElementById('totalPrice').innerText = "Total Price: RM" + totalPrice;
        }
    </script>
</head>
<body>

<div class="container">
    <h2><u>RESERVATION FORM</u></h2>
    <form method="post">

  <div for="name">Name:</div>
  <input type="text" id="name" name="name" placeholder="Enter your name">
  
<br>
<br>
        <div>Select Court:</div> 
        <select name="court_id">
            <option value="1">Court 1</option>
            <option value="2">Court 2</option>
            <option value="3">Court 3</option>
        </select>
<br>
<br>
        <div>Select Date For Reservation:</div>
        <input type="date" name="day" required>

        <br>
        <br>

        <div >Select Time Slots:</div>
        <div class="checkbox-group">
            <?php
            for ($i = 8; $i <= 23; $i++) {
                $time = sprintf("%02d:00", $i);
                echo "<label class=><input type='checkbox' name='hours[]' value='$time' onclick='updatePrice()'> $time - " . sprintf("%02d:00", $i+1) . "</label>";
            }
            ?>
        </div>

        <p class="price" id="totalPrice">Total Price: RM0</p>

        <button type="submit">CONFIRM</button>
    </form>

    <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>