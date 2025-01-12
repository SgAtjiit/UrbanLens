<?php
$con = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if (isset($_GET['pic_id'])) {
    $pic_id = mysqli_real_escape_string($con, $_GET['pic_id']);
    $query = "SELECT * FROM image WHERE pic_id = '$pic_id'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $image_url = $row['file'];
        $user_id = $row['uname'];
        $description = $row['description'];
        $price = $row['price'];
        $category = $row['category'];
        $quantity = $row['quantity'];
        $sales_query = "SELECT COUNT(*) as sales_count FROM bought WHERE pic_id = '$pic_id'";
        $sales_result = mysqli_query($con, $sales_query);
        $sales_count = mysqli_fetch_assoc($sales_result)['sales_count'];
        $remaining_quantity = $quantity - $sales_count;
    } else {
        echo "<p>No image found for this ID.</p>";
        exit;
    }
} else {
    echo "<p>Invalid or missing pic_id.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Description</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            font-size: 32px;
        }
        .image-details {
            display: flex;
            align-items: flex-start;
            margin-top: 20px;
        }
        .image-details img {
            border: 2px solid #ddd;
            max-width: 45%;
            border-radius: 8px;
        }
        .info {
            margin-left: 10%;
            max-width: 45%;
        }
        .info h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        .info p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
        }
        .details-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .details-row div {
            font-size: 18px;
            color: #555;
        }
        .buy-button, .sold-out, .chat-button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
        }
        .buy-button {
            background-color: #4f4c4c;
            color: white;
            cursor: pointer;
        }
        .buy-button:hover {
            background-color: black;
        }
        .sold-out {
            background-color: #9e9e9e;
            color: white;
        }
        .chat-button {
            background-color: #367fff;
            color: white;
            cursor: pointer;
        }
        .chat-button:hover {
            background-color: #2863c7;
        }
        .header {
    contain-intrinsic-block-size: auto 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background-color: #fff;
    color: black;
    border-radius: 8px;
    box-shadow: 0px;
    margin-bottom: 20px;
    width: 61%;
    margin-left: 209px;
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
                <a href="display.php"><button>Shop</button></a>
                
                
            </div>
    </div>
    <div class="container">
        <h1>Image Details</h1>

        <div class="image-details">
            <img src="<?php echo $image_url; ?>" alt="Image" />
            <div class="info">
                <h2>Description</h2>
                <hr>
                <p><?php echo $description; ?></p>
            </div>
        </div>

        <div class="details-row">
            <div><strong>Uploaded By:</strong> <?php echo $user_id; ?></div>
            <div><strong>Category:</strong> <?php echo $category; ?></div>
            <div><strong>Price:</strong> $<?php echo number_format($price, 2); ?></div>
            <div><strong>Available Quantity:</strong> <?php echo $remaining_quantity; ?></div>

            <div class="chat-button-container">
                <a href="chat.php?id=<?php echo $user_id; ?>" class="chat-button">Chat</a>
            </div>

            <?php if ($remaining_quantity > 0): ?>
                <div class="buy-button-container">
                    <a href="payment2.php?amount=<?php echo $price; ?>&author=<?php echo $user_id; ?>&pic_id=<?php echo $pic_id; ?>" class="buy-button">Buy</a>
                </div>
            <?php else: ?>
                <div class="sold-out">Sold Out</div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
