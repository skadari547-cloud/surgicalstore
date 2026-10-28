CREATE DATABASE IF NOT EXISTS surgicalstore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE surgicalstore;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS order_items, orders, wishlist, reviews, contact_messages, newsletter_subscribers, delivery_services, suppliers, coupons, products, categories, register, site_settings;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE register (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  mobile VARCHAR(15) NOT NULL,
  password VARCHAR(255) NOT NULL,
  address VARCHAR(255) DEFAULT '',
  city VARCHAR(80) DEFAULT '',
  pincode VARCHAR(10) DEFAULT '',
  role ENUM('user','admin') NOT NULL DEFAULT 'user',
  status ENUM('active','inactive','blocked') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(100) NOT NULL UNIQUE,
  description VARCHAR(255) DEFAULT '',
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE products (
  product_id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NULL,
  product_name VARCHAR(150) NOT NULL,
  description TEXT,
  brand VARCHAR(100) DEFAULT '',
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  stock_quantity INT NOT NULL DEFAULT 0,
  image VARCHAR(255) DEFAULT '',
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE coupons (
  coupon_id INT AUTO_INCREMENT PRIMARY KEY,
  coupon_code VARCHAR(30) NOT NULL UNIQUE,
  discount_type ENUM('percentage','fixed') NOT NULL DEFAULT 'percentage',
  discount_value DECIMAL(10,2) NOT NULL DEFAULT 0,
  min_order_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  start_date DATETIME NULL,
  expiry_date DATETIME NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE suppliers (
  supplier_id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_name VARCHAR(150) NOT NULL,
  contact_person VARCHAR(100) DEFAULT '',
  phone VARCHAR(20) DEFAULT '',
  email VARCHAR(150) DEFAULT '',
  address VARCHAR(255) DEFAULT '',
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE delivery_services (
  service_id INT AUTO_INCREMENT PRIMARY KEY,
  service_name VARCHAR(100) NOT NULL,
  service_type VARCHAR(50) DEFAULT '',
  description VARCHAR(255) DEFAULT '',
  fee DECIMAL(10,2) NOT NULL DEFAULT 0,
  free_above DECIMAL(10,2) DEFAULT NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE site_settings (
  setting_id INT AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(100) NOT NULL UNIQUE,
  setting_value TEXT NOT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  order_number VARCHAR(30) NOT NULL UNIQUE,
  user_id INT NOT NULL,
  customer_name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  mobile VARCHAR(15) NOT NULL,
  address VARCHAR(255) NOT NULL,
  city VARCHAR(80) NOT NULL,
  pincode VARCHAR(10) NOT NULL,
  coupon_code VARCHAR(30) DEFAULT '',
  delivery_service_id INT NULL,
  payment_method VARCHAR(50) NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL DEFAULT 0,
  delivery_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  discount_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  total_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
  order_status ENUM('pending','confirmed','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES register(id) ON DELETE CASCADE,
  FOREIGN KEY (delivery_service_id) REFERENCES delivery_services(service_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE order_items (
  item_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NULL,
  product_name VARCHAR(150) NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE wishlist (
  wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY user_product (user_id, product_id),
  FOREIGN KEY (user_id) REFERENCES register(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE reviews (
  review_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  rating INT NOT NULL DEFAULT 5,
  review_text VARCHAR(500) NOT NULL,
  status ENUM('pending','approved','hidden') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES register(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
  message_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  subject VARCHAR(100) NOT NULL,
  message VARCHAR(500) NOT NULL,
  status ENUM('new','read','replied') NOT NULL DEFAULT 'new',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE newsletter_subscribers (
  subscriber_id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(150) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO register(fullname,email,mobile,password,address,city,pincode,role,status) VALUES
('Administrator','admin@example.com','9876543210','admin123','Rajkot, Gujarat, India','Rajkot','360001','admin','active'),
('Demo Customer','user@example.com','9876543210','User@1234','Rajkot, Gujarat, India','Rajkot','360001','user','active');

INSERT INTO categories(category_name,description) VALUES
('Medical Equipment','Monitors and essential medical devices.'),
('Protection','Gloves, masks and safety essentials.'),
('First Aid','Everyday emergency and wound-care essentials.'),
('Monitoring','Temperature and vital monitoring products.');

INSERT INTO products(category_id,product_name,description,brand,price,stock_quantity,image) VALUES
(1,'Digital Blood Pressure Monitor','Easy-to-use digital blood pressure monitor.','HealthCare',1499,25,'bp-monitor.jpg'),
(1,'Stethoscope','Lightweight stethoscope for routine examination.','MedPlus',799,40,'stethoscope.jpg'),
(2,'Surgical Gloves','Disposable sterile surgical gloves.','SafeMed',250,100,'surgical-gloves.jpg'),
(2,'Face Mask Pack','Protective disposable face masks.','SafeMed',120,150,'Face_Mask_Pack.jpg'),
(3,'First Aid Kit','Compact first aid kit for home and clinic use.','CareKit',650,30,'first-aid-kit.jpg'),
(3,'Gauze Pads','Sterile gauze pads for wound care.','CareKit',180,80,'Gauze Pads.jpg'),
(4,'Digital Thermometer','Fast digital temperature measurement.','HealthCare',299,70,'thermometer.png'),
(4,'Pulse Oximeter','Compact pulse and oxygen monitoring device.','MedPlus',899,35,'pulse-oximeter.jpg');

INSERT INTO coupons(coupon_code,discount_type,discount_value,min_order_amount,start_date,expiry_date,status) VALUES
('FIRST10','percentage',10,200,NOW(),'2026-12-31 23:59:59','active'),
('SAVE100','fixed',100,1000,NOW(),'2026-12-31 23:59:59','active');

INSERT INTO suppliers(supplier_name,contact_person,phone,email,address) VALUES
('MedSupply India','Rahul Shah','9876543210','medsupply@example.com','Ahmedabad, Gujarat'),
('HealthCare Distributors','Neha Patel','9876501234','healthcare@example.com','Rajkot, Gujarat');

INSERT INTO delivery_services(service_name,service_type,description,fee,free_above,status) VALUES
('Home Delivery','standard','Regular doorstep delivery for everyday orders.',50,999,'active'),
('Urgent Delivery','urgent','Priority handling for time-sensitive healthcare needs.',149,NULL,'active'),
('Bulk / Clinic Supply','bulk','Recurring or bulk orders for clinics and healthcare teams.',0,NULL,'active');

INSERT INTO site_settings(setting_key,setting_value) VALUES
('store_name','Surgical Store'),
('announcement_one','Trusted medical & surgical essentials'),
('announcement_two','Free delivery above ₹999'),
('announcement_three','Support: +91 98765 43210'),
('urgent_text','Urgent delivery service available'),
('hero_image','stethoscope.jpg'),
('phone','+91 98765 43210'),
('email','support@surgicalstore.com'),
('address','Rajkot, Gujarat, India'),
('hero_eyebrow','SURGICAL • MEDICAL • HEALTHCARE'),
('hero_title','Healthcare essentials, simplified.'),
('hero_description','Discover dependable surgical and medical products with a clean, convenient shopping experience designed for homes, clinics and healthcare teams.'),
('about_title','Built around a simpler healthcare shopping experience'),
('about_description','Surgical Store brings medical equipment, protection products, first aid and monitoring essentials into one organized shopping experience.'),
('contact_title','We Are Here to Help'),
('contact_description','Looking for healthcare essentials or need product information? Contact our team for assistance.'),
('free_delivery_above','999');
