<?php
$conn = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$pic_id = $_GET['pic_id'];
$amount = $_GET['amount'];
$author = $_GET['author'];
$uname = $_SESSION['username'];
$sql = "SELECT wallet_balance FROM user_details WHERE uname = '$uname'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
$wb = $user['wallet_balance'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Payments</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background-color: #f0f2f5;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            width: 100%;
            max-width: 800px;
            padding: 15px;
            margin-bottom: 30px;
            background-color: #007bff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .navbar a {
            text-decoration: none;
        }

        .bNav {
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .bNav:hover {
            background-color: #004085;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 25px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }

        .container div {
            font-size: 1.1em;
            font-weight: 600;
            margin-bottom: 15px;
        }

        #wallet-balance {
            color: #28a745;
            font-weight: bold;
        }
        .payment-details {
    width: 44%;
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.05);
    text-align: center; 
    margin: 0 auto; 
}

        .payment-details div {
            font-size: 1.1em;
            margin-bottom: 10px;
        }
        .buy-button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4f4c4c;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .buy-button:hover {
            background-color: #343a40;
        }
    </style>
</head>
<body>
   
    
    <div class="container">
        <div>Payments</div>
        <div>Wallet Balance: <span id="wallet-balance"><?php echo $wb; ?></span></div>
    </div>
    
    <div class="payment-details">
        <div>Paying to: <?php echo $author; ?></div>
        <div>Amount: ₹<?php echo $amount; ?></div>
        <a href="pay2.php?amount=<?php echo $amount; ?>&author=<?php echo $author;?>&pic_id=<?php echo $pic_id; ?>" class="buy-button">Buy</a>
    </div>
</body>
</html>
