# Mustafa Adam — Full-Stack Portfolio

A professional full-stack web portfolio built with HTML5, CSS3, JavaScript, PHP, and MySQL. Designed and developed as a comprehensive showcase of software engineering skills.

---

## 🚀 Features

| Feature | Implementation |
|---|---|
| Responsive Design | CSS Flexbox + Grid, mobile-first breakpoints |
| Dark / Light Mode | JavaScript toggle + Cookie persistence |
| Animated UI | CSS keyframes, scroll-reveal IntersectionObserver, counter animations |
| Code Slider | JavaScript setInterval cycling hero code block |
| Form Validation | Client-side JS + Server-side PHP double validation |
| AJAX Projects | Fetch API → `php/get_projects.php` → JSON → DOM |
| Contact Form | Fetch API POST → `php/contact.php` → MySQL |
| Admin Login | PHP Sessions + `password_verify`, session timeout |
| Admin Dashboard | Add/delete projects, view messages, stats overview |
| Cookie Usage | Dark mode preference (365 days), admin remember |
| Database | MySQL via PDO with prepared statements |

---

## 🗂 Project Structure

```
portfolio/
├── index.html              # Main portfolio page
├── css/
│   └── style.css           # Full design system & responsive styles
├── js/
│   └── main.js             # All client-side logic (JS/DOM/AJAX)
├── php/
│   ├── db.php              # PDO database connection
│   ├── contact.php         # Contact form handler (POST → DB)
│   └── get_projects.php    # Projects AJAX endpoint (GET → JSON)
├── admin/
│   ├── login.php           # Admin login with session handling
│   ├── dashboard.php       # Admin dashboard (projects + messages)
│   └── logout.php          # Session destroy + cookie clear
├── sql/
│   └── portfolio_db.sql    # Database schema + seed data
└── README.md               # This file
```

---

## ⚙️ Setup Instructions (MAMP)

### 1. Place files
Copy the `portfolio/` folder into your MAMP `htdocs` directory:
```
/Applications/MAMP/htdocs/portfolio/
```

### 2. Import the database
1. Open MAMP and start servers
2. Go to **phpMyAdmin** → `http://localhost:8888/phpMyAdmin/`
3. Click **Import** → select `sql/portfolio_db.sql` → Go

### 3. Configure DB connection
Open `php/db.php` and confirm:
```php
define('DB_HOST', 'localhost');
define('DB_PORT', '8889');   // MAMP MySQL default
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'portfolio_db');
```

### 4. Change admin credentials
In `admin/login.php`, update:
```php
$ADMIN_USER = 'mustafa';
$ADMIN_PASS = 'Admin@1234';  // ← Change this!
```

### 5. Visit the portfolio
- **Portfolio:** `http://localhost:8888/portfolio/`
- **Admin Login:** `http://localhost:8888/portfolio/admin/login.php`

---

## 🛠 Technologies Used

- **HTML5** — Semantic structure, forms, tables
- **CSS3** — Custom properties, Flexbox, Grid, animations, media queries
- **JavaScript (ES6+)** — DOM manipulation, Fetch API, IntersectionObserver, Cookies
- **PHP 8** — Server-side logic, PDO, Sessions, input sanitisation
- **MySQL** — Relational database, prepared statements
- **Google Fonts** — Syne (display) + Space Mono (monospace)

---

## 🔐 Security Features

- PDO prepared statements (SQL injection prevention)
- `htmlspecialchars()` on all output (XSS prevention)
- `session_regenerate_id()` on login
- Session timeout after 2 hours
- Server-side validation mirrors client-side validation
- `HttpOnly` cookie flag on admin remember cookie

---

Built by **Mustafa Adam** — Software Engineering Portfolio
