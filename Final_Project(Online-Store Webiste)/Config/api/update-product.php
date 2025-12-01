<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $productsFile = '../data/products.json';
    
    $productsData = file_get_contents($productsFile);
    $data = json_decode($productsData, true);
    
    foreach ($data['products'] as &$product) {
        if ($product['id'] == $input['id']) {
            $product = array_merge($product, $input);
            break;
        }
    }
    
    if (file_put_contents($productsFile, json_encode($data, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'message' => 'Product updated']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed']);
    }
}
?>
