<?php 
session_start();
    $conn = mysqli_connect('localhost','root','gupta@home','admin');
    if(mysqli_error($conn)){
        echo "Error making connection";
    }
    if(isset($_POST['submit1'])){
        
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
        
        $user  = $_SESSION['username'];
        $receiver = $_POST['receiver'];
        $message = $_POST['msg'];
        $chk_receiver_query = "select* from user_details where uname = '$receiver'";
        $res = mysqli_query($conn,$chk_receiver_query);
        if(mysqli_num_rows($res) > 0 && $user!=$receiver){
            $sql = "insert into messages(sender_id,receiver_id,message) values ('$user','$receiver','$message');";
            if (mysqli_query($conn, $sql)) {
                header('Location: chat.php');
                exit();
            } else {
                echo "<script> alert('Data not inserted into database.');</script>";
            }
        }
        else{
            echo "<script> alert('Enter valid receiver name ')</script>";
        }
        
       
        
       
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <title>Chats</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f7f6;
    color: #333;
}

h2 {
    text-align: center;
    color: #333;
    margin-top: 30px;
    font-size: 24px;
}

.send {
    width: 90%;
    max-width: 600px;
    margin: 20px auto;
    background-color: #fff;
    border-radius: 10px;
    padding: 25px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

.send form {
    display: flex;
    flex-direction: column;
}

.send input[type="text"] {
    padding: 12px;
    margin-bottom: 18px;
    border-radius: 6px;
    border: 1px solid #ddd;
    font-size: 16px;
    outline: none;
    transition: border-color 0.3s;
}

.send input[type="text"]:focus {
    border-color: #4CAF50;
}

.send input[type="submit"] {
    padding: 12px 18px;
    background-color: #4CAF50;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.send input[type="submit"]:hover {
    background-color: #45a049;
}

#prev {
    width: 90%;
    max-width: 600px;
    margin: 30px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    height: 300px;
    overflow-y: auto;
    font-size: 14px;
    position: relative;
}

.chat-message {
    margin-bottom: 18px;
    padding: 15px;
    background-color: #f1f1f1;
    border-radius: 8px;
    max-width: 70%;
    word-wrap: break-word;
    position: relative;
}

.sent {
    background-color: #e1ffe1;
    align-self: flex-end;
}

.received {
    background-color: #f9f9f9;
    align-self: flex-start;
}

.timestamp {
    font-size: 12px;
    color: #777;
    margin-top: 5px;
    text-align: right;
}

select {
    padding: 10px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ddd;
    margin-top: 20px;
    width: 100%;
    background-color: #fff;
    transition: border-color 0.3s;
}

select:focus {
    border-color: #4CAF50;
}

option {
    font-size: 16px;
}

form select {
    width: 42%;
    box-sizing: border-box;
    align-items: center;
    margin-left: 400px;
}
form input[type="submit"]{
    width: 100%;
    box-sizing: border-box;
}
.header {
    contain-intrinsic-block-size: auto 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background-color: #f4f4f4;
    color: black;
    border-radius: 8px;
    box-shadow: 0px;
    margin-bottom: 20px;
    width: 61%;
    margin-left: 305px;
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
                <a href="Logout.php"><button>Logout</button></a>
                
                
            </div>
    </div>
<h2>Send message </h2>
    <div class="send">
        <form action="chat.php" method="post" >
            <label for="receiver">Receiver:</label>
            <input type="text" name="receiver" required placeholder="Enter receiver's username"><br>
            <label for="msg">Message:</label>
            <input type="text" name="msg" required placeholder="Enter your message"><br>
            <input type="submit" value="Send" name="submit1">
        </form>
    </div>

   <h2>Chats with </h2>
   <form action="chat.php" method="post">
       
        <select name="chat_user" id="chat_user" onchange="this.form.submit()">
            <option value="" disabled selected>Select a user for chat</option>
            <?php 
            $user  = $_SESSION['username'];
            $users_query = "SELECT uname FROM user_details WHERE uname != '$user'";
            $users_res = mysqli_query($conn, $users_query);
            
            if (mysqli_num_rows($users_res) > 0) {
                while ($row = mysqli_fetch_assoc($users_res)) {
                    $username = $row['uname'];
                    echo "<option value='$username' ".($username == $selected_user ? 'selected' : '').">$username</option>";
                }
            } else {
                echo "<option value=''>No users found</option>";
            }
            ?>
        </select>
     
    </form>
    <div id="prev">
        <?php 
        $user  = $_SESSION['username'];
        
        $selected_user = "";
        if (isset($_POST['chat_user']) && !empty($_POST['chat_user'])) {
            $selected_user = $_POST['chat_user'];
        }
        if ($selected_user) {
            $chats = "SELECT sender_id, receiver_id, message, timestamp FROM messages 
                      WHERE (sender_id = '$user' AND receiver_id = '$selected_user') 
                      OR (receiver_id = '$user' AND sender_id = '$selected_user')
                      ORDER BY timestamp DESC";

            $res2 = mysqli_query($conn, $chats);

            if (mysqli_num_rows($res2) > 0) {
                while ($row = mysqli_fetch_assoc($res2)) {
                    $message = htmlspecialchars($row['message'], ENT_QUOTES);
                    $timestamp = $row['timestamp'];

                    if ($row['sender_id'] == $user) {
                        echo "<div class='chat-message sent'>
                               <small>Sent to {$row['receiver_id']}</small><br><br>
                                <big><b>{$message}</b></big>
                                <div class='timestamp'>{$timestamp}</div>
                              </div>";
                    } else {
                        echo "<div class='chat-message received'>
                                <small>Received from {$row['sender_id']}</small><br><br>
                                <big><b>{$message}</b></big>
                                <div class='timestamp'>{$timestamp}</div>
                              </div>";
                    }
                }
            } else {
                echo "<div class='chat-message'>
                        No chats found with {$selected_user}.
                      </div>";
            }
        }
        ?>
    </div>
    <footer>

    
    </footer>
</body>
</html>

<?php include("footer.php"); ?>