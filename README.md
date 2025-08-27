# WebECom – E-Commerce Website  

## 📌 Description  

**WebECom** is a simple e-commerce web application developed to practice **web development course**.  
It demonstrates the core features of an online store, including product browsing, cart management, and session handling.  

The project focuses on building a **functional backend** and combining it with a **clean, responsive frontend**.  

---

## ✨ Features  

- 🛍️ **Product Listings** with titles, images, and prices  
- 🛒 **Shopping Cart** with add, remove, and update functionality  
- 🔑 **Session Management** for cart persistence  

---

## 🛠️ Technologies Used  

- **Frontend:**  
  - HTML5  
  - CSS3  
  - JavaScript (no frameworks)  

- **Backend:**  
  - PHP  
  - MySQL (via PDO for database access)  

- **Other:**  
  - Sessions & Cookies for cart and user state  

---

## 🎨 Design Principles  

- **Usability:** Simple navigation and intuitive shopping flow  
- **Accessibility:** High contrast text and keyboard-friendly navigation  
- **Maintainability:** Modular PHP structure with reusable components  

---

## ⚙️ Setup Instructions  

Follow these steps to set up the project on your local machine using **XAMPP**:  

---

### 1. Install XAMPP  
- Download and install **XAMPP** from [Apache Friends](https://www.apachefriends.org/).  
- Open the **XAMPP Control Panel**.  
- Start the following services:  
  - ✅ Apache  
  - ✅ MySQL  

---

### 2. Clone the Repository into `htdocs`  

Navigate to your **XAMPP installation folder** and clone the project into the `htdocs` directory:  

```bash
cd C:\xampp\htdocs
git clone https://github.com/Grit-in/WebECom
cd WebECom
```

### 3. Database Setup  

1. Open **phpMyAdmin** in your browser.
2. Select new data base and import the init.sql file. ( It will have users and passwords that is just for testing )

### 4. Create `config.ini` File  

Inside the **root of the project**, create a file named **`config.ini`** with the following content:  

```ini
[database]
host = localhost
database = users_db ( can be a name of any database but you`ll need to rewamp the whole project due to names)
user = root
password =
```
### 5. Run the project
1. Open http://localhost/WebECom/public/index.php
