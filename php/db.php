<?php
// =============================================
// db.php — Database configuration
// Update these values to match your MAMP setup
// =============================================

define('DB_HOST', 'localhost');
define('DB_PORT', '8889');          // MAMP default MySQL port
define('DB_USER', 'root');
define('DB_PASS', 'root');          // MAMP default password
define('DB_NAME', 'portfolio_db');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;

    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT
         . ';dbname=' . DB_NAME . ';charset=utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit;
    }

    return $pdo;
}
