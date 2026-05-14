-- =============================================
-- portfolio_db.sql
-- Mustafa Adam — Portfolio Database
-- Import via: MAMP > phpMyAdmin > Import
-- =============================================

CREATE DATABASE IF NOT EXISTS portfolio_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE portfolio_db;

-- ─────────────────────────────────────────────
-- TABLE: projects
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS projects (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(255)  NOT NULL,
  description TEXT          NOT NULL,
  tags        VARCHAR(255)  DEFAULT '',
  category    ENUM('web','backend','fullstack') DEFAULT 'web',
  emoji       VARCHAR(10)   DEFAULT '💻',
  github_url  VARCHAR(500)  DEFAULT '',
  live_url    VARCHAR(500)  DEFAULT '',
  featured    TINYINT(1)    DEFAULT 0,
  created_at  DATETIME      DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────
-- TABLE: messages
-- ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS messages (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(150) NOT NULL,
  email      VARCHAR(255) NOT NULL,
  subject    VARCHAR(255) NOT NULL,
  message    TEXT         NOT NULL,
  created_at DATETIME     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ─────────────────────────────────────────────
-- SEED DATA: demo projects
-- ─────────────────────────────────────────────
INSERT INTO projects (title, description, tags, category, emoji, github_url, live_url, featured) VALUES
('DevConnect Platform',    'A full-stack social platform for developers to share projects and collaborate in real-time.',         'PHP, MySQL, JavaScript, AJAX',  'fullstack', '🚀', 'https://github.com', 'https://example.com', 1),
('TaskFlow App',           'A Kanban-style task manager with drag-and-drop functionality and team collaboration features.',       'JavaScript, CSS Grid, AJAX',    'web',       '📋', 'https://github.com', 'https://example.com', 1),
('ShopEase E-Commerce',    'A complete online store with cart, checkout, admin dashboard, and MySQL inventory management.',      'PHP, MySQL, HTML, CSS',         'fullstack', '🛒', 'https://github.com', 'https://example.com', 0),
('REST API Server',        'A RESTful API built in PHP with JWT authentication, rate limiting, and full CRUD operations.',       'PHP, MySQL, JSON',              'backend',   '⚙️', 'https://github.com', '',                    0),
('Weather Dashboard',      'Real-time weather app using Fetch API, geolocation, and dynamic chart rendering with Chart.js.',    'JavaScript, CSS, Fetch API',    'web',       '🌤', 'https://github.com', 'https://example.com', 0),
('Blog CMS',               'A content management system with WYSIWYG editor, categories, tags, and admin authentication.',      'PHP, MySQL, JavaScript',        'backend',   '✍️', 'https://github.com', '',                    0);
