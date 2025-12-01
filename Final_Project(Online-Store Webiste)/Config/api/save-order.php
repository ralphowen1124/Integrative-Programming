<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['customer_info']) || !isset($input['items']) || empty($input['items'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid order data']);
        exit;
    }
    
    $orderId = 'ORD-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    
    $subtotal = 0;
    foreach ($input['items'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
    
    $shipping = $subtotal > 99 ? 0 : 9.99;
    $tax = $subtotal * 0.08; // 8% tax
    $total = $subtotal + $shipping + $tax;
    
    $orderData = [
        'order_id' => $orderId,
        'customer_info' => $input['customer_info'],
        'items' => $input['items'],
        'order_total' => $subtotal,
        'shipping_cost' => $shipping,
        'tax_amount' => $tax,
        'final_total' => $total,
        'payment_method' => $input['payment_method'] ?? 'credit_card',
        'payment_status' => 'completed',
        'order_status' => 'processing',
        'order_date' => date('Y-m-d H:i:s'),
        'delivery_date' => null,
        'tracking_number' => null,
        'notes' => $input['notes'] ?? ''
    ];
    
    $ordersFile = '../data/orders.json';
    $orders = [];
    
    if (file_exists($ordersFile)) {
        $ordersData = file_get_contents($ordersFile);
        $orders = json_decode($ordersData, true) ?? [];
    }
    
    $orders[] = $orderData;
    
    if (file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT))) {
        echo json_encode([
            'success' => true,
            'order_id' => $orderId,
            'message' => 'Order placed successfully',
            'order_total' => $total
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save order']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
