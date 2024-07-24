<?php
$servername = "localhost";
$username = "root";
$password = "StrongP@ssw0rd!";
$dbname = "bank";
$socket = "/var/run/mysqld/mysqld.sock";
$conn = new mysqli($servername, $username, $password, $dbname, null, $socket);

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "SELECT id, action, amount, timestamp FROM logs";
$result = $conn->query($sql);

echo '<style>body{font-size:15px;font-family:Arial,sans-serif;}table{width:100%;border-collapse:collapse;}table,th,td{border:1px solid black;}th,td{padding:20px;text-align:left;}th{background-color:#f2f2f2;}</style>
<table><tr><th>ID</th><th>Action</th><th>Amount</th><th>Timestamp</th></tr>';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['id']}</td><td>{$row['action']}</td><td>{$row['amount']}</td><td>{$row['timestamp']}</td></tr>";
    }
} else {
    echo '<tr><td colspan="4">0 results</td></tr>';
}
echo '</table>';

$conn->close();
?>
