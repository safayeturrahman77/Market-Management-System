# Market Management System

A PHP + MySQL web application for managing market vendors, shops, payments, and reports.

---

## Project Structure

```
market-management-system/
├── assets/
│   ├── css/
│   │   ├── style.css              # Global styles
│   │   ├── admin_dashboard.css    # Dashboard styles
│   │   └── report.css             # Report page styles
│   ├── js/                        # Future JS files
│   └── images/                    # Static images
│
├── config/
│   └── db.php                     # Database connection
│
├── includes/
│   ├── header.php                 # Shared HTML header + navbar
│   ├── footer.php                 # Shared HTML footer
│   └── auth.php                   # Session auth guard
│
├── modules/
│   ├── admin/
│   │   └── dashboard.php
│   ├── vendor/
│   │   ├── add_vendor.php
│   │   ├── edit_vendor.php
│   │   ├── delete_vendor.php
│   │   ├── search_vendor.php
│   │   ├── vendor_dashboard.php
│   │   ├── vendor_profile.php
│   │   └── vendor_report.php
│   ├── shop/
│   │   ├── add_shop.php
│   │   ├── manage_shop.php
│   │   └── delete_shop.php
│   ├── payment/
│   │   ├── add_payment.php
│   │   └── rent_record.php
│   ├── report/
│   │   ├── report.php
│   │   └── pdf_report.php
│   └── backup/
│       └── data_backup.php
│
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
├── public/
│   ├── index.php
│   ├── login.html
│   ├── register.html
│   ├── add_vendor.html
│   ├── add_shop.html
│   └── add_payment.html
│
├── vendor/
│   └── fpdf/
│       └── fpdf.php               # Download from http://www.fpdf.org/
│
├── README.md
└── .gitignore
```

---

## Requirements

- PHP 7.4+
- MySQL 5.7+
- Web server: Apache (with mod_rewrite)
- FPDF library (for PDF reports) — download from http://www.fpdf.org/

---

## Setup Instructions

### 1. Database

Create a MySQL database named `market_db` and run the following SQL:

```sql
CREATE DATABASE IF NOT EXISTS market_db;
USE market_db;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'vendor', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vendors (
    vendor_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    shop_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE shops (
    shop_id INT AUTO_INCREMENT PRIMARY KEY,
    shop_name VARCHAR(100) NOT NULL,
    owner_name VARCHAR(100) NOT NULL,
    location VARCHAR(150) NOT NULL,
    rent DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    vendor_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vendor_id) REFERENCES vendors(vendor_id) ON DELETE CASCADE
);
```

### 2. Configuration

Edit `config/db.php` and update your database credentials:

```php
$host     = "localhost";
$user     = "your_db_user";
$password = "your_db_password";
$db       = "market_db";
```

### 3. PDF Reports (Optional)

Download FPDF from http://www.fpdf.org/ and place `fpdf.php` at:

```
vendor/fpdf/fpdf.php
```

### 4. Web Server

Point your web server document root to the project root directory.
For Apache, ensure `AllowOverride All` is set so absolute paths (`/modules/...`) resolve correctly.



## License

MIT
