GiftCraft Emporium
=================

GiftCraft Emporium is a professional, responsive e-commerce gift shop application
built using native PHP and SQLite. It features a modern UI powered by Tailwind CSS
and supports complete customer and admin workflows.

Quick Start
-----------

* Initialize database: `php setup.php`
* Start server: `php -S 127.0.0.1:8000`
* Open application: http://127.0.0.1:8000
* Admin login: `admin / admin123`

Features
--------

Customer Side
-------------

* Professional hero banner with category navigation
* Curated product catalog  
  (Soft Toys, Hampers, Home Decor, Wellness)
* Product details with reviews and ratings
* Dynamic shopping cart
* User authentication (login/register)
* Order tracking and history

Admin Side
----------

* Admin dashboard
* Metrics overview (orders, revenue)
* Order dispatch and management

Tech Stack
----------

* Backend: Native PHP (8.0+)
* Database: SQLite 3
* Frontend: CSS3, Tailwind CSS (CDN)
* Server: PHP built-in development server

Prerequisites
-------------

* PHP 8.0 or higher installed and added to PATH
* SQLite3 extension enabled in `php.ini`

Installation and Setup
----------------------

1. Initialize the Database

This will create the `giftshop.db` file and seed default data.

2. Start the Server

Option A: Double-click `run_app.bat` (Windows)

Option B: Run manually : php -S 127.0.0.1:8000

3. Access the Application : http://127.0.0.1:8000

Admin Credentials
-----------------
Username: `admin`  
Password: `admin123`

Database Schema
---------------

* Users – customer accounts
* Admins – admin credentials
* Categories – product categories
* Products – inventory data
* Carts – shopping cart storage
* Orders – order records
* OrderItems – order line items
* Reviews – product reviews

License
-------

This project is intended for educational purposes only.
         
