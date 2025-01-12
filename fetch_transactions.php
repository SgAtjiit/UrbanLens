<?php
session_start();
header('Content-Type: application/json');


$conn = mysqli_connect('127.0.0.1', 'root', 'gupta@home', 'admin');
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$username = 1;
$response = ['balance' => 0, 'transactions' => []];


$balance_query = $conn->prepare("SELECT wallet_balance FROM users WHERE uname = ?");
$balance_query->bind_param("s", $username);
$balance_query->execute();
$balance_result = $balance_query->get_result();
if ($balance_row = $balance_result->fetch_assoc()) {
    $response['balance'] = $balance_row['wallet_balance'];
}


$transaction_query = $conn->prepare("SELECT sender, receiver, amount, date FROM transactions WHERE sender = ? OR receiver = ? ORDER BY date DESC");
$transaction_query->bind_param("ss", $username, $username);
$transaction_query->execute();
$transaction_result = $transaction_query->get_result();
while ($transaction_row = $transaction_result->fetch_assoc()) {
    $response['transactions'][] = $transaction_row;
}

$conn->close();
echo json_encode($response);
?>
