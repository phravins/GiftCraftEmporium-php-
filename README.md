GiftCraft Emporium - Professional Gift Shop
-------------------------------------------
A responsive, professional e-commerce gift shop website built with native PHP and SQLite. Features a vibrant, modern UI using Tailwind CSS.

Features :
----------
Customer Side
-------------
Professional Hero Banner and Category Navigation
Curated Product Catalog (Soft Toys, Hampers, Home Decor, Wellness)
Product Details with user reviews and ratings
Shopping Cart with dynamic updates
User Authentication (Login/Register)
Order Management and tracking status

Admin Side
----------
Admin Dashboard
Metrics Overview (Orders, Revenue)
Order Management (Dispatch items)

Tech Stack
----------

Backend: Native PHP (8.0+)
Database: SQLite 3
Frontend: CSS3, Tailwind CSS (via CDN)
Server: Built-in PHP development server

Prerequisites
-------------
PHP 8.0 or higher installed and added to PATH
SQLite3 extension enabled in php.ini

Installation and Setup
----------------------
1. Initialize the Database
   Open your terminal in the project directory and run:
   php setup.php

   This will create the giftshop.db file and seed it with the default catalog.

2. Start the Server
   You can use the provided batch file or run the command manually:
   
   Option A: Double-click run_app.bat
   
   Option B: Run command
   php -S 127.0.0.1:8000

3. Access the Application
   Open your browser to: http://127.0.0.1:8000

Admin Credentials
-----------------
Username: admin
Password: admin123

Project Structure
-----------------
/
├── actions/               # PHP Action scripts (Login, Add to Cart, etc.)
├── assets/                # Images and CSS
│   └── img/               # Product and Category images
├── includes/              # Database connection and helpers
├── views/                 # View Templates (Home, Product, Cart)
├── setup.php              # Database initialization script
├── index.php              # Main Router
├── run_app.bat            # Quick start script (Windows)
├── README.md              # Documentation
└── giftshop.db           # SQLite Database file

Database Schema
---------------
Users: Customer accounts
Admins: Admin credentials
Categories: Product categories
Products: Inventory with image paths
Carts: Persistent shopping cart data
Orders: Order records with status
OrderItems: Line items for orders
Reviews: User product reviews

License
-------
This project is for educational purposes.
