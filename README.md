# 🛍️ Online Store CRUD System (PHP)

A simple inventory management system for online items with image support - Perfect for learning PHP/MySQL!

![CRUD Screenshot](https://drive.google.com/uc?export=view&id=1M42--sOe1eY-GvR-ihmltEnDStKQKaRw)  
*CRUD Interface Preview*

## 🌟 Features

✅ **Full CRUD Operations**  
- Create new items with images  
- Read item list in beautiful table  
- Update existing items  
- Delete items with confirmation  

🖼️ **Image Management**  
- Upload product images  
- Preview images with hover zoom  
- Replace/remove existing images  

🛡️ **Security First**  
- SQL injection protection  
- File type validation  
- Safe file uploads  

📱 **Responsive Design**  
- Works on all screen sizes  
- Clean Bootstrap 5 interface  

## 🛠️ Technology Stack

- **Frontend**: Bootstrap 5, HTML5, CSS3  
- **Backend**: PHP  
- **Database**: MySQL  
- **Server**: XAMPP  

## 🚀 Installation Guide

### Prerequisites
- XAMPP installed ([Download](https://www.apachefriends.org/))
- Basic PHP/MySQL knowledge

### Step-by-Step Setup

1. **Start Services**  
   - Open XAMPP Control Panel  
   - Start Apache and MySQL  

2. **Create Database**  
   ```sql
   CREATE DATABASE online_store;
   USE online_store;
   
   CREATE TABLE items (
       id INT PRIMARY KEY AUTO_INCREMENT,
       name VARCHAR(255) NOT NULL,
       description TEXT,
       image VARCHAR(255),
       price DECIMAL(10,2) NOT NULL,
       quantity INT NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
