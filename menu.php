<?php require_once '../config.php'; header('Content-Type: application/json');
$rows = []; $r = $conn->query("SELECT id,name,category,price,emoji,description FROM menu_items");
while ($x = $r->fetch_assoc()) $rows[] = $x;
echo json_encode($rows);
