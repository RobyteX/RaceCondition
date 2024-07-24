<?php
$mysqli = new mysqli("localhost", "root", "StrongP@ssw0rd!", "bank");
if ($mysqli->connect_error) die("Connection failed: " . $mysqli->connect_error);

$withdraw_amount = 100.0;
$mysqli->begin_transaction();
try {
    $stmt = $mysqli->prepare("SELECT balance FROM accounts WHERE id = 1 FOR UPDATE");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) throw new Exception("Account not found.");

    $row = $result->fetch_assoc();
    $current_balance = $row['balance'];
    if ($current_balance >= $withdraw_amount) {
        $new_balance = $current_balance - $withdraw_amount;
        $stmt = $mysqli->prepare("UPDATE accounts SET balance = ? WHERE id = 1");
        $stmt->bind_param("d", $new_balance);
        $stmt->execute();
        $stmt = $mysqli->prepare("INSERT INTO logs (action, amount) VALUES ('withdraw', ?)");
        $stmt->bind_param("d", $withdraw_amount);
        $stmt->execute();
        $mysqli->commit();
        echo "Withdrawal successful. New balance: $new_balance";
    } else {
        throw new Exception("Insufficient funds.");
    }
} catch (Exception $e) {
    $mysqli->rollback();
    echo "Transaction failed: " . $e->getMessage();
}
$mysqli->close();
?>
