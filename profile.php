<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$conn = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$uname = $_SESSION['username'];
$user_query = "SELECT uname, Name, Email_Id, wallet_balance FROM user_details WHERE uname = '$uname'";
$user_result = mysqli_query($conn, $user_query);
if (!$user_result) {
    die("Error retrieving user data: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($user_result);

$uploaded_query = "SELECT * FROM image WHERE uname = '$uname' ORDER BY upload_date DESC";
$uploaded_result = mysqli_query($conn, $uploaded_query);

if (!$uploaded_result) {
    die("Error retrieving uploaded images: " . mysqli_error($conn));
}

$bought_query = "
    SELECT i.* 
    FROM image i
    JOIN bought b ON i.pic_id = b.pic_id
    WHERE b.buyer = '$uname'
    ";
$bought_result = mysqli_query($conn, $bought_query);

if (!$bought_result) {
    die("Error retrieving bought images: " . mysqli_error($conn));
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2em;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            font-size: 1.5em;
            color: #444;
            margin-bottom: 15px;
        }
        .profile-info p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        .btn {
            display: block;
            margin: 20px auto 0;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #141516;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #141516b3;
        }
        .no-records {
            color: #888;
            font-size: 1em;
            text-align: center;
            margin-top: 10px;
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
                <a href="logout.php"><button>Logout</button></a>
                
                
            </div>
    </div>
    <div class="container">
        <h1>Your Profile</h1>
        <div class="section profile-info">
            <p><strong>Username:</strong> <?php echo $user['uname']; ?></p>
            <p><strong>Full Name:</strong> <?php echo $user['Name']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['Email_Id']; ?></p>
            <p><strong>Wallet Balance:</strong> <?php echo $user['wallet_balance']; ?></p>
        </div>
        
        <div class="section">
            <h2>Uploaded Images</h2>
            <?php if (mysqli_num_rows($uploaded_result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Upload Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($uploaded_result)): ?>
                            <tr>
                                <td><img src="<?php echo $row['file']; ?>" alt="Uploaded Image"></td>
                                <td><?php echo $row['category']; ?></td>
                                <td><?php echo $row['price'] == 0 ? 'Free' : $row['price']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['upload_date']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-records">No uploaded images found.</p>
            <?php endif; ?>
        </div>
        
        <div class="section">
            <h2>Bought Images</h2>
            <?php if (mysqli_num_rows($bought_result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Price</th>
                            
                            <th>Purchase Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($bought_result)): ?>
                            <tr>
                                <td><img src="<?php echo $row['file']; ?>" alt="Bought Image"></td>
                                <td><?php echo $row['category']; ?></td>
                                <td><?php echo $row['price'] == 0 ? 'Free' : $row['price']; ?></td>
                                
                                <td><?php echo $row['upload_date'];  ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-records">No bought images found.</p>
            <?php endif; ?>
        </div>

        <a href="update_profile.php" class="btn">Edit Profile</a>
        <a href="index2.html" class="btn">Go Back</a>
    </div>
</body>
</html>
<?php include("footer.php"); ?>