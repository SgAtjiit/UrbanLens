<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    echo "<script>
    alert('$error_message');
    </script>";
    unset($_SESSION['error']); 
}
if (isset($_SESSION['error1'])) {
    $error_message = $_SESSION['error1'];
    echo "<script>
    alert('$error_message');
    </script>";
    unset($_SESSION['error1']); 
}


$conn = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Payments</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Helvetica Neue', Arial, sans-serif;
}
body {
    background-color: #f4f7f9;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}


.container {
    display: flex;
    justify-content: space-between;
    width: 100%;
    max-width: 600px;
    background-color: #ffffff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.container div {
    font-size: 1.2em;
    font-weight: 600;
}

#wallet-balance {
    color: #28a745;
    font-weight: bold;
}


.transactions {
    width: 100%;
    max-width: 600px;
    margin-top: 20px;
}

h2 {
    font-size: 1.5em;
    margin-bottom: 10px;
    color: #555;
}

.transaction-items {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.08);
    display: flex;
    
    justify-content: space-between;
    
    transition: transform 0.2s;
    font-size: 1em;
    font-weight: 500;
}


.transaction-items:hover {
    transform: scale(1.02); 
}

.transaction-item {
    margin-bottom: 5px; 
    color: #333;
    
}
.header {
    contain-intrinsic-block-size: auto 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background-color: #f4f7f9;
    color: black;
    border-radius: 8px;
    box-shadow: 0px;
    margin-bottom: 20px;
    width: 47%;
}

.header .logo {
    display: flex;
    align-items: center;
    font-size: 24px;
    font-weight: bold;
}

.header .logo i {
    font-size: 30px; 
    margin-right: 15px;
    color: black;
}

.header .logo span {
    font-size: 22px;
    color: black;
}

.header .nav {
    display: flex;
    gap: 15px;
}

.header .nav a {
    text-decoration: none;
}

.header .nav button {
    background-color:#141516; 
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease; 
}

.header .nav button:hover {
    background-color: #141516bf; 
    transform: translateY(-3px);
}

.header .nav button:active {
    transform: translateY(1px); 
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px; 
    width: 100%;
    max-width: 600px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

input[type="text"], input[type="number"] {
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1em;
    outline: none;
    transition: border-color 0.2s;
}

input[type="text"]:focus, input[type="number"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
}

input[type="submit"] {
    padding: 12px;
    background-color: #141516;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s;
    width: 100%;
}

input[type="submit"]:hover {
    background-color:#141516bf ;
}
.navbar {
    display: flex;
    justify-content: flex-start; 
    gap: 10px;
    margin-bottom: 20px;
    align-items: center;
    padding: 10px;
}

.bNav{
    padding:10px;
    margin:10px;
    background-color:#007bff;
    color:white;
    border:0px;
    border-radius:6px;
}

    </style>
</head>
<body>
    <div class="header">
            <div class="logo">
                <i class="fas fa-home"></i>
                <span>UrbanLens</span>
            </div>
            <div class="nav">
                <a href= "index2.html"><button>Home</button></a>
                <a href="profile.php"><button>Profile</button></a>
                <a href="logout.php"><button>Logout</button></a>
                
                
            </div>
    </div>
    
    <div class="container">
        <div>Payments</div>
        <div>Wallet Balance: <span id="wallet-balance">Loading...</span></div>
    </div>

    

    <form action="pay.php" method="post">
        <label>Receiver Username:</label>
        <input type="text" name="user" required>
        <label>Amount:</label>
        <input type="number" name="amount" required>
        <input type="submit" name="submit1">
    </form>
    <div class="transactions">
        <h2>Transaction History</h2>
        <div id="transaction-list">
            
           
        </div>
    </div>
    
    <?php 
        $uname = $_SESSION['username'];
        $sql = "SELECT wallet_balance FROM user_details WHERE uname = '$uname'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        
        echo "<script>
                document.getElementById('wallet-balance').innerHTML = '$user[wallet_balance]';
            </script>";
        $_SESSION['username'] = $uname;
        
        $sql2 = "SELECT * FROM transactions WHERE sender = '$uname' OR receiver = '$uname' order by date desc";
        $transactions_result = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($transactions_result) > 0) {
            while ($row = mysqli_fetch_assoc($transactions_result)) {
                $type = "";
                if($row['sender']==$uname){
                    $type = "You sent";
                    echo "<script>
              
                    document.getElementById('transaction-list').innerHTML += '<div class=\"transaction-items\"> $type \<div class=\"transaction-item\">  {$row['amount']}</div> to <div class=\"transaction-item\">{$row['receiver']}</div>on <div class=\"transaction-item\">{$row['date']}</div></div>';
                    
                    </script>";
                }
                if($row['receiver']==$uname){
                    $type = "You received";
                    echo "<script>
              
                    document.getElementById('transaction-list').innerHTML += '<div class=\"transaction-items\"> $type \<div class=\"transaction-item\">  {$row['amount']}</div> from <div class=\"transaction-item\">{$row['sender']}</div> on <div class=\"transaction-item\">{$row['date']}</div></div>';
                    
                    </script>";
                }
                
                
             
            }
        } else {
            echo "<p>No transactions found.</p>";
        }
        mysqli_close($conn);
    ?>
</body>
</html>
