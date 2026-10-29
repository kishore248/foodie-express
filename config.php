<?php
// Unit III: PHP - variables, functions, database with PHP
session_start();
$conn = new mysqli("localhost", "root", "", "food_delivery");
if ($conn->connect_error) { die("Database error: " . $conn->connect_error); }
$conn->set_charset("utf8mb4");
function e($s) { return htmlspecialchars($s, ENT_QUOTES); }
function require_login() { if (!isset($_SESSION['user'])) { header("Location: login.php"); exit; } }
function require_admin() { if (($_SESSION['user']['role'] ?? '') !== 'admin') { header("Location: ../login.php"); exit; } }
function cart_count() { return array_sum($_SESSION['cart'] ?? []); }
