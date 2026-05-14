# My Portfolio Website
### Mustafa Adam — Software Engineering

This is my portfolio project for the Web Development course. I built it using HTML, CSS, JavaScript, PHP and MySQL. The goal was to create a full-stack website that shows my projects and lets people contact me.

---

## What I built

A personal portfolio website with:
- A homepage with my info, skills and projects
- A contact form that saves messages to a database
- Projects that load from a database (not hardcoded)
- A dark/light mode that remembers your preference
- An admin page where I can log in and add/delete projects

---

## Technologies I used

- **HTML5** for the structure and layout
- **CSS3** for the design, animations and making it responsive on mobile
- **JavaScript** for the interactive parts like form validation and loading projects without refreshing the page
- **PHP** for the backend — handling form submissions and connecting to the database
- **MySQL** for storing projects and contact messages
- **MAMP** for running the server locally on my Mac

---

## How to run it

1. Install MAMP and start the servers
2. Copy the portfolio folder into /Applications/MAMP/htdocs/
3. Open phpMyAdmin at http://localhost:8888/phpMyAdmin/
4. Create a database called portfolio_db and import the sql/portfolio_db.sql file
5. Open http://localhost:8888/portfolio/ in your browser

For the admin panel go to http://localhost:8888/portfolio/admin/login.php
- Username: mustafa
- Password: Admin@1234

---

## File structure

portfolio/
├── index.html        # main page
├── css/style.css     # all the styling
├── js/main.js        # javascript logic
├── php/
│   ├── db.php        # database connection
│   ├── contact.php   # handles contact form
│   └── get_projects.php  # returns projects as JSON
├── admin/
│   ├── login.php     # admin login
│   ├── dashboard.php # manage projects and view messages
│   └── logout.php
├── sql/
│   └── portfolio_db.sql  # database tables and sample data
└── README.md

---

## Challenges I faced

Getting the AJAX to work properly with PHP took me a while because I kept getting CORS errors. Also setting up the sessions for the admin login was tricky at first but I figured it out.

The responsive design on mobile also needed a lot of tweaking especially the hero section.

---

Built by Mustafa Adam