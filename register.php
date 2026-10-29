<?php include 'header.php'; $msg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO users(name,email,phone,password) VALUES(?,?,?,?)");
  $stmt->bind_param("ssss", $_POST['name'], $_POST['email'], $_POST['phone'], $hash);
  if ($stmt->execute()) { header("Location: login.php?registered=1"); exit; } else $msg = "Email already registered.";
}
?>
<div class="col-md-5 mx-auto"><h2>Create Account</h2>
<?php if ($msg) echo "<div class='alert alert-danger'>$msg</div>"; ?>
<form name="regForm" method="post" onsubmit="return validateRegister()">
 <input name="name" class="form-control mb-2" placeholder="Full name" required>
 <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
 <input name="phone" class="form-control mb-2" placeholder="Phone (10 digits)" required>
 <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
 <button class="btn btn-danger w-100">Register</button>
</form></div>
<?php include 'footer.php'; ?>
