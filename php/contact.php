<?php
// =============================================
// contact.php — Handles contact form submission
// =============================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Sanitise inputs
$name    = trim(htmlspecialchars($_POST['name']    ?? '', ENT_QUOTES, 'UTF-8'));
$email   = trim(filter_var($_POST['email']  ?? '', FILTER_SANITIZE_EMAIL));
$subject = trim(htmlspecialchars($_POST['subject']  ?? '', ENT_QUOTES, 'UTF-8'));
$message = trim(htmlspecialchars($_POST['message']  ?? '', ENT_QUOTES, 'UTF-8'));

// Server-side validation (mirrors JS validation)
$errors = [];

if (strlen($name) < 2)            $errors[] = 'Name must be at least 2 characters.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email address.';
if (strlen($subject) < 3)         $errors[] = 'Subject must be at least 3 characters.';
if (strlen($message) < 10)        $errors[] = 'Message must be at least 10 characters.';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// Save to database
try {
    $pdo  = getDB();
    $stmt = $pdo->prepare(
        'INSERT INTO messages (name, email, subject, message, created_at)
         VALUES (:name, :email, :subject, :message, NOW())'
    );
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':subject' => $subject,
        ':message' => $message,
    ]);

    echo json_encode(['success' => true, 'message' => 'Message saved successfully.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to save message. Please try again.']);
}
