# 🛒 Laravel E-Commerce Project

A fully functional **E-Commerce Web Application** built using Laravel.
This project demonstrates real-world features like product management, cart system, order processing, and admin dashboard.

---

## 🚀 Features

* 🏠 Home page with product listing
* 📂 Category-based product filtering
* 🔍 Live search functionality
* 🛒 Add to cart system
* 💳 Payment GetWay in Razorpay
* 📦 Order placement & tracking
* 👤 User authentication (Login/Register)
* 🛠️ Admin panel for:

  * Product management
  * Category management
  * Order management
  * Stock management
---

## 🛠️ Tech Stack

* **Backend:** Laravel (PHP Framework)
* **Frontend:** Blade, HTML, CSS, Bootstrap, JavaScript
* **Database:** MySQL
* **Tools:** Git, GitHub

---

## 📂 Project Structure

```
app/
├── Http/
├── Models/

resources/
├── views/
│   ├── dashboards/
│   ├── layouts/
│   └── components/

routes/
├── web.php

public/
├── uploads/
```

---

## ⚙️ Installation Guide

Follow these steps to run the project locally:

### 1️⃣ Clone the repository

```bash
git clone https://github.com/Annu-200/ecommerce_laravel.git
```

### 2️⃣ Go to project folder

```bash
cd ecommerce_laravel
```

### 3️⃣ Install dependencies

```bash
composer install
npm install
```

### 4️⃣ Setup environment file

```bash
cp .env.example .env
```

### 5️⃣ Generate application key

```bash
php artisan key:generate
```

### 6️⃣ Configure database

Update `.env` file:

```
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=
```

### 7️⃣ Run migrations

```bash
php artisan migrate
```

### 8️⃣ Start server

```bash
php artisan serve
```

---

## ▶️ Usage

* Visit: `http://127.0.0.1:8000`
* Register/Login as a user
* Browse products and place orders
* Access admin panel to manage data

---

## 📸 Screenshots

(Add your project screenshots here 👇)
 
<img width="1886" height="911" alt="admin" src="https://github.com/user-attachments/assets/3912c943-a76e-4ce5-a6e2-d71f1d73f197" />
<img width="1899" height="970" alt="home" src="https://github.com/user-attachments/assets/7c628e94-cde7-4a5f-b44b-023a67135394" />


/screenshots/admin.png
```

---

## 🎯 Future Improvements

* Product reviews & ratings
* API development (for React frontend)
* Performance optimization

---

## 👤 Author

**Annu Maghwal**

* GitHub: https://github.com/Annu-200

---

## ⭐ Support

If you like this project, give it a ⭐ on GitHub!

---

