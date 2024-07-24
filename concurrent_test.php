<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$url = "http://localhost/withdraw.php";

$multiCurl = [];
$mh = curl_multi_init();
$responses = [];

for ($i = 0; $i < 50; $i++) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_multi_add_handle($mh, $ch);
    $multiCurl[$i] = $ch;
}

$running = null;
do {
    curl_multi_exec($mh, $running);
    curl_multi_select($mh);
} while ($running > 0);

foreach ($multiCurl as $ch) {
    $response = curl_multi_getcontent($ch);
    if (curl_errno($ch)) {
        $responses[] = 'cURL Error: ' . curl_error($ch);
    } else {
        $responses[] = htmlspecialchars($response);
    }

    curl_multi_remove_handle($mh, $ch);
    curl_close($ch);
}

curl_multi_close($mh);

// Generar la tabla HTML
echo '<style>
        body {
            font-size: 24px;
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
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
      </style>';

echo '<table>';
echo '<tr><th>Request</th><th>Response</th></tr>';
foreach ($responses as $index => $response) {
    echo "<tr><td>Request " . ($index + 1) . "</td><td>" . $response . "</td></tr>";
}
echo '</table>';
?>

