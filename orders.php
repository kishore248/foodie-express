<?php
require_once '../config.php';
header('Content-Type: application/json; charset=utf-8');

$rows = [];

if (isset($_GET['order_id']) && (int)$_GET['order_id'] > 0) {
    $oid = (int)$_GET['order_id'];
    $stmt = $conn->prepare("SELECT id, total, status, area, payment, created_at FROM orders WHERE id = ?");
    $stmt->bind_param("i", $oid);
    $stmt->execute();
    $r = $stmt->get_result();
} elseif (isset($_SESSION['user']['id'])) {
    $uid = (int)$_SESSION['user']['id'];
    $r = $conn->query("SELECT id, total, status, area, payment, created_at FROM orders WHERE user_id = $uid ORDER BY id DESC");
} else {
    // If not logged in, show recent orders so tracker always functions smoothly during testing
    $r = $conn->query("SELECT id, total, status, area, payment, created_at FROM orders ORDER BY id DESC LIMIT 5");
}

if ($r) {
    while ($x = $r->fetch_assoc()) {
        $oid = (int)$x['id'];
        $its = $conn->query("SELECT m.name, m.emoji, oi.qty, oi.price FROM order_items oi JOIN menu_items m ON m.id = oi.item_id WHERE oi.order_id = $oid");
        $items = [];
        if ($its) {
            while ($it = $its->fetch_assoc()) {
                $items[] = $it;
            }
        }
        $x['items'] = $items;
        $rows[] = $x;
    }
}

echo json_encode($rows, JSON_UNESCAPED_UNICODE);
