<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>FoodieExpress - Online Food Ordering</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css">
</head><body>
<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top">
 <div class="container">
  <a class="navbar-brand fw-bold" href="index.php">🍴 FoodieExpress</a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="nav">
   <ul class="navbar-nav ms-auto">
    <li class="nav-item"><a class="nav-link" href="index.php">Menu</a></li>
    <li class="nav-item"><a class="nav-link" href="cart.php">Cart <span class="badge bg-light text-dark"><?= cart_count() ?></span></a></li>
    <li class="nav-item"><a class="nav-link" href="orders.php">My Orders</a></li>
    <li class="nav-item"><a class="nav-link" href="react/index.html#track">Live Tracker (React)</a></li>
    <?php if (isset($_SESSION['user'])): ?>
      <?php if ($_SESSION['user']['role']=='admin'): ?><li class="nav-item"><a class="nav-link" href="admin/index.php">Admin</a></li><?php endif; ?>
      <li class="nav-item"><a class="nav-link" href="logout.php">Logout (<?= e($_SESSION['user']['name']) ?>)</a></li>
    <?php else: ?>
      <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
      <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
    <?php endif; ?>
   </ul>
  </div>
 </div>
</nav>
</header>
<main class="container my-4">
