<?php
session_start(); 
if (!isset($_SESSION['username'])) {
    header("Location: profile.php");
    exit();
}

$conn = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$uname = $_SESSION['username'];
if (isset($_POST['submit1'])) {
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

  
    $sql = "UPDATE user_details SET Name = '$name', Email_Id = '$email' WHERE uname = '$uname'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href = 'profile.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

$sql = "SELECT uname, Name, Email_Id FROM user_details WHERE uname = '$uname'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f7fa;
            color: #333;
        }
        .container {
            max-width: 500px;
            width: 100%;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2em;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 1em;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fafafa;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #6c63ff;
            outline: none;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            color: #fff;
            background-color: #6c63ff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #5751e0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Update Profile</h1>
    <form method="POST" action="update_profile.php">
        <p>Hi <?php echo $user['uname']; ?> here to do something crazy</p>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email_Id']); ?>" required>

        <input type ="submit" value ="Update Profile" name = "submit1">
        <br>
        <a href = "profile.php">Click here to view profile</a>

    </form>
</div>

</body>
</html>