# 🚗 AutoFix Garage

<div align="center">

**A full-featured Garage Management System built with PHP & MySQL**

[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-UI-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![GitHub Stars](https://img.shields.io/github/stars/bahasalah255/AutoFix-Garage?style=for-the-badge)](https://github.com/bahasalah255/AutoFix-Garage/stargazers)

<!-- Add a screenshot here once available -->
<!-- ![AutoFix Garage Preview](./images/preview.png) -->

</div>

---

## 📖 About

**AutoFix Garage** is a complete web-based garage management system designed to streamline day-to-day operations of an auto repair shop. It provides three role-based dashboards — **Admin**, **User**, and **Client** — each with dedicated tools for managing clients, vehicles, repairs, invoices, and appointments.

---

## ✨ Features

### 🔐 Authentication
- Secure login / logout system
- Role-based access control (Admin / User / Client)
- Sign up for new accounts

### 📊 Admin Dashboard
- Overview statistics: total users, clients, vehicles, and repairs
- Full control over all system entities

### 👤 User Management
- Add, view, and manage system users
- Role assignment and access control

### 🧑‍💼 Client Management
- Register and track client profiles
- Link clients to their vehicles

### 🚘 Vehicle Management
- Add and manage vehicles per client
- Full vehicle history tracking

### 🔧 Repair Management
- Log and track repairs (in progress / completed)
- Assign repairs to clients and vehicles

### 🧾 Invoice Management
- Generate and view invoices per repair
- Full billing history

### 📅 Appointments
- Schedule and manage rendez-vous
- Client-side appointment booking

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP |
| Database | MySQL |
| Frontend | HTML5 / CSS3 / JavaScript |
| UI Framework | Bootstrap |

---

## 📂 Project Structure

```
AutoFix-Garage/
│
├── Front-end/              # Frontend assets
├── assets/                 # Stylesheets & scripts
├── contents/               # Content files
├── images/                 # Image assets
│
├── login.php               # Login page
├── signup.php              # Registration
├── logout.php              # Session logout
│
├── admindashbord.php       # Admin dashboard
├── userdashbord.php        # User dashboard
├── Clientdashbord.php      # Client dashboard
│
├── add_client.php          # Add client
├── list_clients.php        # Manage clients
│
├── add_vehicule.php        # Add vehicle
├── list_vehicules.php      # Manage vehicles
│
├── add_reparation.php      # Add repair
├── list_reparation.php     # Manage repairs
│
├── list_factures.php       # Invoice list
├── show_facture.php        # Invoice detail
│
├── rendez-vous.php         # Appointments
├── informations.php        # System info
│
├── add_user.php            # Add user
├── list_users.php          # Manage users
│
└── .gitignore
```

---

## 🚀 Getting Started

### Prerequisites

- PHP 7.4+
- MySQL / MariaDB
- Apache or Nginx (XAMPP / WAMP recommended)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/bahasalah255/AutoFix-Garage.git
   ```

2. **Move to your server's web root**
   ```bash
   # For XAMPP:
   mv AutoFix-Garage /xampp/htdocs/AutoFix-Garage
   ```

3. **Create the database**
   - Open phpMyAdmin
   - Create a new database (e.g., `autofix_db`)
   - Import the SQL file from the `contents/` folder

4. **Configure the database connection**
   - Open the DB config file and update your credentials:
   ```php
   $host = "localhost";
   $dbname = "autofix_db";
   $username = "root";
   $password = "";
   ```

5. **Run the app**
   ```
   http://localhost/AutoFix-Garage/login.php
   ```


---

## 📌 Roadmap

- [ ] PDF invoice export
- [ ] Email notifications for appointments
- [ ] Mobile-responsive improvements
- [ ] Search & filter across all lists
- [ ] Dark mode

---

## 👨‍💻 Author

**Salah Baha**
🔗 GitHub: [@bahasalah255](https://github.com/bahasalah255)

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

---

<div align="center">

⭐ If you find this project useful, please give it a star!

</div>
