<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$ordersFile = '../data/orders.json';
if (file_exists($ordersFile)) {
    $ordersData = file_get_contents($ordersFile);
    echo $ordersData;
} else {
    echo json_encode([]);
}
?>
