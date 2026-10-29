<?php require_once '../config.php'; require_admin();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['status'])) {
    $s = $conn->prepare("UPDATE orders SET status=? WHERE id=?"); $s->bind_param("si", $_POST['status'], $_POST['oid']); $s->execute();
  } elseif (isset($_POST['name'])) {
    $s = $conn->prepare("INSERT INTO menu_items(name,category,price,emoji,description) VALUES(?,?,?,?,?)");
    $s->bind_param("ssdss", $_POST['name'], $_POST['category'], $_POST['price'], $_POST['emoji'], $_POST['description']); $s->execute();
  }
  header("Location: index.php"); exit;
}
$statuses = ['Placed','Preparing','Out for Delivery','Delivered']; $counts = [];
foreach ($statuses as $st) { $counts[] = (int)$conn->query("SELECT COUNT(*) c FROM orders WHERE status='$st'")->fetch_assoc()['c']; }
$orders = $conn->query("SELECT o.*,u.name uname,u.phone FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.id DESC");
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Admin - FoodieExpress</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link rel="stylesheet" href="../css/style.css"></head>
<body><div class="container my-4">
<div class="d-flex justify-content-between"><h2>Admin Dashboard</h2><a href="../index.php" class="btn btn-outline-danger">Back to site</a></div>
<h5>Orders by status</h5><canvas id="statusChart" width="400" height="230"></canvas>
<h5 class="mt-4">All Orders</h5>
<table class="table table-bordered bg-white"><tr class="table-danger"><th>#</th><th>Customer</th><th>Total</th><th>Address</th><th>Status</th></tr>
<?php while ($o = $orders->fetch_assoc()): ?>
<tr><td><?= $o['id'] ?></td><td><?= e($o['uname']) ?><br><small><?= e($o['phone']) ?></small></td><td>₹<?= $o['total'] ?></td><td><?= e($o['address']) ?></td>
<td><form method="post" class="d-flex"><input type="hidden" name="oid" value="<?= $o['id'] ?>">
<select name="status" class="form-select form-select-sm"><?php foreach ($statuses as $s) echo "<option" . ($s==$o['status']?' selected':'') . ">$s</option>"; ?></select>
<button class="btn btn-sm btn-success ms-1">Save</button></form></td></tr>
<?php endwhile; ?></table>
<fieldset><legend>Add Menu Item</legend>
<form method="post" class="row g-2">
<div class="col-md-3"><input name="name" class="form-control" placeholder="Name" required></div>
<div class="col-md-2"><input name="category" class="form-control" placeholder="Category" required></div>
<div class="col-md-2"><input name="price" type="number" step="0.01" class="form-control" placeholder="Price" required></div>
<div class="col-md-1"><input name="emoji" class="form-control" placeholder="🍕" required></div>
<div class="col-md-3"><input name="description" class="form-control" placeholder="Description"></div>
<div class="col-md-1"><button class="btn btn-danger w-100">Add</button></div></form></fieldset>
</div>
<script src="../js/app.js"></script>
<script>drawChart(<?= json_encode($statuses) ?>, <?= json_encode($counts) ?>);</script>
</body></html>
