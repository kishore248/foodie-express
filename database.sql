CREATE DATABASE IF NOT EXISTS food_delivery;
USE food_delivery;
CREATE TABLE users(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(80),email VARCHAR(100) UNIQUE,phone VARCHAR(15),password VARCHAR(255),role ENUM('customer','admin') DEFAULT 'customer');
CREATE TABLE menu_items(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(100),category VARCHAR(50),price DECIMAL(8,2),emoji VARCHAR(10),description VARCHAR(200));
CREATE TABLE orders(id INT AUTO_INCREMENT PRIMARY KEY,user_id INT,total DECIMAL(10,2),address TEXT,area VARCHAR(50),payment VARCHAR(20),status ENUM('Placed','Preparing','Out for Delivery','Delivered') DEFAULT 'Placed',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(user_id) REFERENCES users(id));
CREATE TABLE order_items(id INT AUTO_INCREMENT PRIMARY KEY,order_id INT,item_id INT,qty INT,price DECIMAL(8,2),FOREIGN KEY(order_id) REFERENCES orders(id),FOREIGN KEY(item_id) REFERENCES menu_items(id));
INSERT INTO menu_items(name,category,price,emoji,description) VALUES
('Margherita Pizza','Pizza',199,'🍕','Classic cheese and tomato'),
('Veg Burger','Burger',99,'🍔','Crispy patty with fresh veggies'),
('Chicken Biryani','Rice',179,'🍛','Aromatic basmati with spiced chicken'),
('Paneer Butter Masala','Curry',159,'🥘','Creamy tomato gravy with paneer'),
('Masala Dosa','Tiffin',70,'🥞','Crispy dosa with potato masala'),
('French Fries','Snacks',79,'🍟','Salted golden fries'),
('Chocolate Shake','Drinks',89,'🥤','Thick chocolate milkshake'),
('Gulab Jamun','Dessert',60,'🍮','Soft sweet dumplings in syrup');
