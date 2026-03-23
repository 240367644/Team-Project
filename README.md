# Accom4U (Team 49)
Accom4U is an e-commerce website designed to provide an easy way for students to search for and purchase essentials for their accommodations.

## Features
- Landing Page
- About Us
- Products Display
- Contact Form
- Functional Log In/Register
- Basket and Dummy Checkout
- Admin Panel: order processing, customer management, inventory system and report
- Wishlist
- Reviews
- Profile
- My orders

## Deployed Website
Link: https://cs2team49.cs2410-web01pvm.aston.ac.uk/index.html

## How to Deploy Website
### 1. Download Project
- Go to repository
- Download ZIP
- Extract the folder
### 2. Create Virtual Server
- Log into Virtualmin
- Go to Create Virtual Server
- Enter domain name and password, press Create Server
### 3. Upload Files
- Go to File Manager in Virtualmin
- Upload project files into public_html/
### 4. Create Database
- Go to Edit Databases
- Create a database (cs2team_db, etc)
### 5. Import Database
- Open phpMyAdmin
- Select database and press import
- Upload given .sql file
### 6. Configure Database Connection
- Update PHP configuration
  $db_host = "localhost";
  $db_name = "your_database_name";
  $db_user = "your_database_user";
  $db_pass = "your_database_password";
### 7. Access your Website
- In a browser go to yourdomain.com

## Built With
- HTML
- CSS
- JavaScript
- MySQL
- PHP
- VirtualMin

## Team Members
- Ateeq Ali - 240118253
- Lamin Bayo Bah - 240377012
- Muhammad Faid - 240170996
- Nabiha Islam - 240082840
- Kyle Lieu - 240367644
- Rahima Osman - 240235435
- Sohail Shinwari - 230090088
- Ming Hay Wu - 240072047

