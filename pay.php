<?php
if (isset($_POST['submit1'])) {
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $conn = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $receiver = $_POST['user'];
    $amount = $_POST['amount'];
    $sender = $_SESSION['username'];

    // Check if the sender is trying to send money to themselves
    if ($sender === $receiver) {
        $_SESSION['error1'] = 'You cannot send money to yourself.';
        header("Location: payment.php");
        exit();
    }

    // Check if the receiver exists in the user_details table
    $q1 = "SELECT uname FROM user_details WHERE uname = '$receiver'";
    $res = mysqli_query($conn, $q1);

    if (mysqli_num_rows($res) == 0) {
        // If receiver does not exist, redirect back with an error
        $_SESSION['error'] = 'Enter a valid username.';
        header("Location: payment.php");
        exit();
    }

    // Fetch the sender's current wallet balance
    $balance_query = "SELECT wallet_balance FROM user_details WHERE uname = '$sender'";
    $balance_result = mysqli_query($conn, $balance_query);

    if ($balance_result) {
        $balance = mysqli_fetch_assoc($balance_result)['wallet_balance'];

        // Check if the sender has enough balance to make the payment
        if ($balance >= $amount) {
            // Insert transaction into the transactions table
            $sql = "INSERT INTO transactions (sender, receiver, amount) VALUES ('$sender', '$receiver', '$amount')";
            if (mysqli_query($conn, $sql)) {
                // Update the wallet balances for both sender and receiver
                $update_balance1 = "UPDATE user_details SET wallet_balance = wallet_balance - '$amount' WHERE uname = '$sender'";
                $update_balance2 = "UPDATE user_details SET wallet_balance = wallet_balance + '$amount' WHERE uname = '$receiver'";
                $update_result1 = mysqli_query($conn, $update_balance1);
                $update_result2 = mysqli_query($conn, $update_balance2);

                if ($update_result1 && $update_result2) {
                    echo "Payment successful.";
                } else {
                    echo "Failed to update wallet balances: " . mysqli_error($conn);
                }
            } else {
                echo "Payment failed, query execution error: " . mysqli_error($conn);
            }
        } else {
            echo "Insufficient balance.";
        }
    } else {
        echo "Failed to fetch wallet balance: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
