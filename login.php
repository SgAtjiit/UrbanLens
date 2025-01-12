<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f3f4f6;
            font-family: 'Roboto', sans-serif;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 1em;
            color: #222; 
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 1em;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fafafa;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #a06345;
            outline: none;
        }

        button,
        input[type="submit"] {
            width: 100%; 
            padding: 10px;
            font-size: 1em;
            color: #fff;
            background-color: #000; 
            border: none;
            border-radius: 30px; 
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover,
        input[type="submit"]:hover {
            background-color: #444;
        }

        .message {
            font-size: 0.9em;
            color: #888;
            margin-top: 15px;
        }

        .container a {
            font-size: 0.9em;
            color: #007BFF; 
            text-decoration: none;
        }

        .container a:hover {
            color: #0056b3;
        }

        .show-password {
            font-size: 0.9em;
            color: #555;
            display: flex;
            align-items: center; 
            justify-content: left;
            margin-bottom: 10px;
        }

        .show-password label {
            margin-left: 5px; 
        }

        .signup {
            margin-top: 15px;
            font-size: 0.9em;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .signup p {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="uname" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <div class="show-password">
                <input type="checkbox" id="show-password">
                <label for="show-password" style="padding-top: 1.5%;">Show Password</label>
            </div>

            <input type="submit" value="Login" name="submit1">
            <br>
            <span id="Output"></span>
        </form>

        <div class="signup">
            <p>Don't have an account?</p>
            <a href="signup.php">Sign Up !!</a>
        </div>
    </div>
    <?php
session_start();
ob_start(); 

if (isset($_POST['submit1'])) {
    $conn = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $pass = $_POST['password'];
    $uname = $_POST['uname'];

    $sql = "SELECT password FROM user_details WHERE uname = '$uname';";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if ($pass == $user['password']) {
            $_SESSION['username'] = $uname;
            header("Location: index2.html"); 
            exit();
        } else {
            $message = 'Invalid password';
        }
    } else {
        $message = 'Username not found';
    }

    mysqli_close($conn);
}
ob_end_flush(); 
?>

    <script>
        document.getElementById('show-password').addEventListener('change', function () {
            const passwordInput = document.getElementById('password');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</body>

</html>