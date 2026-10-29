# FoodieExpress - Online Food Ordering and Delivery System

## Setup (XAMPP / WAMP)
1. Copy the `food-delivery` folder to `C:/xampp/htdocs/`.
2. Start Apache and MySQL. Open phpMyAdmin -> Import -> `database.sql`.
3. Open http://localhost/food-delivery/
4. Register an account, then make it admin in phpMyAdmin:
   `UPDATE users SET role='admin' WHERE email='your@email.com';`
5. Log in again to access the Admin dashboard.
(If your MySQL root has a password, edit `config.php`.)
