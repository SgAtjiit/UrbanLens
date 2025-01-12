<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
            background-color: #eaeff1;
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
            color: #555;
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1em;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #5e72e4;
            outline: none;
        }
        input[type = "submit"]{
            margin: 11px;
    width: 80%;
    background-color: black;
    border-radius: 19px;
    color: white;
    padding: 8px;
        }
        button {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            color: #fff;
            background-color: #5e72e4;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4a5bbd;
        }

        .message {
            font-size: 0.9em;
            color: #888;
            margin-top: 15px;
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
            padding-top: 2%;
        }
        

        .show-password input[type="checkbox"] {
            margin-right: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Signup</h2>
    <form action="signup.php" method="post">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="uname" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="pass" required>

        <div class="show-password">
            <input type="checkbox" id="show-password">
            <label for="show-password">Show Password</label>
        </div>

        <input type="submit" value="Sign up" name="submit1">
        <br>
        <span id = "Output"></span>
    </form>

<div class="signup">
            <p>Have an account?
            <a href="login.php">Login</a></p>
        </div>
        </div>
<?php
if (isset($_POST['submit1'])) {
    $conn = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo "Connection made<br>";

    $name = $_POST['name'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $sql2 = "Select* from user_details where uname = '$uname';";
    $result = mysqli_query($conn,$sql2);
    if ($result && mysqli_num_rows($result) > 0) {
        
            echo "<script type='text/javascript'>
                     document.getElementById('Output').innerHTML = 'This usename already exits login';
            </script>";
    
           
            exit();
        
        }
     
    $sql = "INSERT INTO user_details (uname, password, Name, Email_Id) VALUES ('$uname', '$pass', '$name', '$email')";

    if (mysqli_query($conn, $sql)) {
        echo "<script type='text/javascript'>
                document.getElementById('Output').innerHTML = 'Signup succesfull';
                </script>";
        header("Location: login.php");
        exit();
    }
    // } else {
    //     echo "Error adding record: " . mysqli_error($conn);
    // }

    mysqli_close($conn);
}
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