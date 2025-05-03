
# 🌈 Weekly Goals Tracker

A PHP web app designed with two unique vibes — girly & masculine — to help users set, manage, and crush their weekly goals. Whether you're feeling pastel and pink or sleek and bold, this app adapts to your style.

---

## 🧠 Features

- ✍️ Add, edit, and delete weekly goals  
- ✅ Mark goals as done  
- 🔐 Login & signup system  
- 💅 Light girly theme and bold male theme  
- 🗃️ MySQL backend with organized goal tracking  
- 📦 Clean modular structure with reusable components  

---

## 📁 Project Structure

```bash
/weekly-goals-tracker
├── girly/                # Girly theme UI
│   ├── index.php         # Landing/Login
│   ├── dashboard.php     # Main app
│   └── assets/css        # Girly styles
│   └── includes/         # DB + functions
├── male/                 # Masculine theme UI
│   ├── index.php
│   ├── dashboard.php
│   └── assets/css        # Masculine styles
│   └── includes/         # DB + functions
├── weekly_goals.sql      # 📊 Database file
└── README.md             # This file!
```

---

## 💻 Installation Guide

### 🔧 Step 1: Clone the Repo

```bash
git clone https://github.com/fatimazahra-max/weekly-goals-tracker.git
cd weekly-goals-tracker
```

### 🚀 Step 2: Setup Localhost (XAMPP/WAMP)

1. Move the project folder to `htdocs` (if using XAMPP)
2. Start **Apache** and **MySQL** via your local server

### 🧠 Step 3: Create the Database

1. Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Create a new database called `weekly_goals`
3. Import the file `weekly_goals.sql`

### 🌍 Step 4: Run the App

Open your browser and go to:

- `http://localhost/weekly-goals-tracker/girly/` for the girly version  
- `http://localhost/weekly-goals-tracker/male/` for the masculine version  

---

## 🗃️ Database Table: `goals`

| Field       | Type         | Description         |
|-------------|--------------|---------------------|
| id          | INT          | Auto-incremented ID |
| user_id     | INT          | User reference      |
| title       | VARCHAR(255) | Goal text           |
| completed   | TINYINT(1)   | 0 or 1 (done?)      |
| created_at  | TIMESTAMP    | Auto timestamp      |

---

## ✨ Credits

**Developed by:** Fatima Zahra Elkasmi  
🧠 Full Stack Developer | 🌸 UI Lover 

---

## 📖 License

This project is open source. You can remix, rebuild, and make it your own ✨

---

### ✨ Happy goal tracking!

# weekly-goals-tracker
