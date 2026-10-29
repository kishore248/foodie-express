<?php include 'header.php'; require_login();
if (empty($_SESSION['cart'])) { header("Location: cart.php"); exit; }
$total = 0;
foreach ($_SESSION['cart'] as $id => $q) { $total += $conn->query("SELECT price FROM menu_items WHERE id=" . (int)$id)->fetch_assoc()['price'] * $q; }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $uid = $_SESSION['user']['id'];
  $stmt = $conn->prepare("INSERT INTO orders(user_id,total,address,area,payment) VALUES(?,?,?,?,?)");
  $stmt->bind_param("idsss", $uid, $total, $_POST['address'], $_POST['area'], $_POST['payment']);
  $stmt->execute(); $oid = $conn->insert_id;
  foreach ($_SESSION['cart'] as $id => $q) {
    $p = $conn->query("SELECT price FROM menu_items WHERE id=" . (int)$id)->fetch_assoc()['price'];
    $s2 = $conn->prepare("INSERT INTO order_items(order_id,item_id,qty,price) VALUES(?,?,?,?)");
    $s2->bind_param("iiid", $oid, $id, $q, $p); $s2->execute();
  }
  unset($_SESSION['cart']);
  header("Location: orders.php?placed=$oid"); exit;
}
?>
<h2>Checkout</h2>
<form name="checkoutForm" method="post" onsubmit="return validateCheckout()">
 <fieldset><legend>Delivery Details</legend>
  <label>Delivery Area</label>
  <select name="area" class="form-select mb-2"><option>Sriperumbudur</option><option>Sunguvarchatram</option><option>Oragadam</option><option>Mannur</option></select>
  <label>Address</label><textarea name="address" rows="3" class="form-control" placeholder="House no, street, landmark"></textarea>
 </fieldset>
 <fieldset><legend>Payment Method</legend>
  <div class="form-check"><input type="radio" class="form-check-input" name="payment" value="COD" checked onchange="payChange(this)"> <label>Cash on Delivery</label></div>
  <div class="form-check"><input type="radio" class="form-check-input" name="payment" value="UPI" onchange="payChange(this)"> <label>UPI</label></div>
  <div id="upiBox" style="display:none" class="mt-2"><input class="form-control" placeholder="Enter UPI ID (demo only)"></div>
 </fieldset>
 <div class="form-check mb-3"><input type="checkbox" name="terms" class="form-check-input"> <label>I accept the terms and conditions</label></div>
 <h4>Amount payable: ₹<?= $total ?></h4>
 <button class="btn btn-danger">Place Order</button>
</form>
<?php include 'footer.php'; ?>
