
<?php
session_start();
$conn = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');

if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$receiver = mysqli_real_escape_string($conn, $_GET['author']);
$amount = $_GET['amount'];
$sender = $_SESSION['username'];
$pic_id = $_GET['pic_id'];

function showAlertAndRedirect($message, $redirectPage) {
    echo "<script>alert('$message'); window.location.href = '$redirectPage';</script>";
    exit();
}


if ($sender == $receiver) {
    showAlertAndRedirect('You cannot send money to yourself', 'display.php');
}


$query = "SELECT uname FROM user_details WHERE uname = '$receiver'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {

    $balance_query = "SELECT wallet_balance FROM user_details WHERE uname = '$sender'";
    $balance_result = mysqli_query($conn, $balance_query);

    if ($balance_result) {
        $balance = mysqli_fetch_assoc($balance_result)['wallet_balance'];


        if ($balance >= $amount) {

            $update_balance_query = "UPDATE user_details SET wallet_balance = wallet_balance - $amount WHERE uname = '$sender'";
            if (!mysqli_query($conn, $update_balance_query)) {
                showAlertAndRedirect("Failed to update sender's wallet balance: " . mysqli_error($conn), 'payment.php');
            }


            $transaction_query = "INSERT INTO transactions (sender, receiver, amount) VALUES ('$sender', '$receiver', '$amount')";
            if (!mysqli_query($conn, $transaction_query)) {

                $revert_balance_query = "UPDATE user_details SET wallet_balance = wallet_balance + $amount WHERE uname = '$sender'";
                mysqli_query($conn, $revert_balance_query);
                showAlertAndRedirect("Payment failed, transaction query execution error: " . mysqli_error($conn), 'payment.php');
            }


            $bought_query = "Insert into bought(pic_id,buyer,seller) value('$pic_id','$sender','$receiver')";
            $result = mysqli_query($conn,$bought_query);

                showAlertAndRedirect("Payment successful.", "profile.php");
        
            

        } else {
            showAlertAndRedirect("Insufficient balance.", "payment.php");
        }
    } else {
        showAlertAndRedirect("Failed to fetch wallet balance.", "payment.php");
    }
} else {
   
    showAlertAndRedirect('Enter a valid username', 'payment.php');
}


mysqli_close($conn);
?>
