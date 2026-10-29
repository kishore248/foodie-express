<?php include 'header.php';
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = (int)$_POST['id']; $a = $_POST['action'];
  if ($a == 'add') { $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + (int)$_POST['qty']; }
  elseif ($a == 'update') { $q = (int)$_POST['qty']; if ($q > 0) $_SESSION['cart'][$id] = $q; else unset($_SESSION['cart'][$id]); }
  elseif ($a == 'remove') { unset($_SESSION['cart'][$id]); }
  header("Location: cart.php"); exit;
}
?>
<h2>🛒 Your Cart</h2>
<?php if (empty($_SESSION['cart'])): ?>
  <div class="alert alert-info">Cart is empty. <a href="index.php">Browse menu</a></div>
<?php else: $total = 0; ?>
<table class="table table-bordered bg-white align-middle">
<tr class="table-danger"><th>Item</th><th>Price</th><th>Qty</th><th>Total</th><th></th></tr>
<?php foreach ($_SESSION['cart'] as $id => $qty):
  $r = $conn->query("SELECT * FROM menu_items WHERE id=" . (int)$id)->fetch_assoc();
  $line = $r['price'] * $qty; $total += $line; ?>
<tr>
 <td><?= $r['emoji'] . ' ' . e($r['name']) ?></td><td>₹<?= $r['price'] ?></td>
 <td><form method="post" class="d-flex"><input type="hidden" name="action" value="update"><input type="hidden" name="id" value="<?= $id ?>">
   <input type="number" name="qty" value="<?= $qty ?>" min="0" class="form-control form-control-sm w-50"><button class="btn btn-sm btn-secondary ms-1">Update</button></form></td>
 <td>₹<?= $line ?></td>
 <td><form method="post"><input type="hidden" name="action" value="remove"><input type="hidden" name="id" value="<?= $id ?>"><button class="btn btn-sm btn-outline-danger">Remove</button></form></td>
</tr>
<?php endforeach; ?>
<tr><td colspan="3" class="text-end"><b>Grand Total</b></td><td colspan="2"><b>₹<?= $total ?></b></td></tr>
</table>
<a href="checkout.php" class="btn btn-danger">Proceed to Checkout</a>
<?php endif; include 'footer.php'; ?>
