<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$category = isset($_GET['category']) ? $_GET['category'] : 'all';

$productsData = file_get_contents('../data/products.json');
$data = json_decode($productsData, true);

if ($category !== 'all') {
    $data['products'] = array_filter($data['products'], function($product) use ($category) {
        return $product['category'] === $category;
    });
}

echo json_encode($data);
?>
