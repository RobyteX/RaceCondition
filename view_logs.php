<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "StrongP@ssw0rd!";
$dbname = "bank";
$socket = "/var/run/mysqld/mysqld.sock";

$conn = new mysqli($servername, $username, $password, $dbname, null, $socket);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, action, amount, timestamp FROM logs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<style>
            body {
                font-size: 15px;
                font-family: Arial, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 20px;
                text-align: left;
                font-size: 15px;
            }
            th {
                background-color: #f2f2f2;
            }
          </style>';

    echo '<table>';
    echo '<tr><th>ID</th><th>Action</th><th>Amount</th><th>Timestamp</th></tr>';
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["action"]. "</td><td>" . $row["amount"]. "</td><td>" . $row["timestamp"]. "</td></tr>";
    }
    echo '</table>';
} else {
    echo '<p style="font-size: 15px; font-family: Arial, sans-serif;">0 results</p>';
}
$conn->close();
?>

