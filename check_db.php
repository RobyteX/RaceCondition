<?php
$servername = "localhost";
$username = "root";
$password = "StrongP@ssw0rd!";
$dbname = "bank";
$socket = "/var/run/mysqld/mysqld.sock";

$conn = new mysqli($servername, $username, $password, $dbname, null, $socket);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, balance FROM accounts";
$result = $conn->query($sql);

echo '<style>
body{font-size:32px;font-family:Arial,sans-serif;}table{width:100%;border-collapse:collapse;}table,th,td{border:1px solid black;}th,td{padding:20px;text-align:left;}th{background-color:#f2f2f2;}
</style><table><tr><th>ID</th><th>Balance</th></tr>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['id']}</td><td>{$row['balance']}</td></tr>";
    }
} else {
    echo '<tr><td colspan="2">0 results</td></tr>';
}
echo '</table>';

$conn->close();
?>

