<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login — Mustafa Adam</title>
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Space Mono', monospace;
      background: #0a0a0f;
      color: #e8e8f0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-image:
        linear-gradient(rgba(0,255,136,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,255,136,0.03) 1px, transparent 1px);
      background-size: 60px 60px;
    }
    .login-box {
      background: #16161f;
      border: 1px solid #2a2a38;
      border-radius: 16px;
      padding: 3rem;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 24px 64px rgba(0,0,0,0.5);
    }
    .login-logo {
      font-family: 'Syne', sans-serif;
      font-size: 2rem;
      font-weight: 800;
      color: #e8e8f0;
      margin-bottom: 0.25rem;
    }
    .login-logo span { color: #00ff88; }
    .login-subtitle {
      font-size: 0.75rem;
      color: #6b6b80;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      margin-bottom: 2.5rem;
    }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; margin-bottom: 1.2rem; }
    label { font-size: 0.72rem; letter-spacing: 0.1em; text-transform: uppercase; color: #6b6b80; }
    input {
      background: #0a0a0f;
      border: 1px solid #2a2a38;
      border-radius: 8px;
      padding: 0.9rem 1rem;
      font-family: 'Space Mono', monospace;
      font-size: 0.85rem;
      color: #e8e8f0;
      outline: none;
      transition: border-color 0.3s;
    }
    input:focus { border-color: #00ff88; box-shadow: 0 0 0 3px rgba(0,255,136,0.08); }
    .btn {
      width: 100%;
      padding: 0.9rem;
      background: #00ff88;
      color: #0a0a0f;
      font-family: 'Space Mono', monospace;
      font-size: 0.85rem;
      font-weight: 700;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      letter-spacing: 0.05em;
      margin-top: 0.5rem;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,255,136,0.3); }
    .error-msg {
      background: rgba(255,71,87,0.1);
      border: 1px solid rgba(255,71,87,0.3);
      color: #ff4757;
      padding: 0.8rem 1rem;
      border-radius: 8px;
      font-size: 0.8rem;
      margin-bottom: 1rem;
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.75rem;
      color: #6b6b80;
      text-decoration: none;
      transition: color 0.3s;
    }
    .back-link:hover { color: #00ff88; }
  </style>
</head>
<body>
<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // ⚠ Change these credentials! In production use password_hash/password_verify
    $ADMIN_USER = 'mustafa';
    $ADMIN_PASS = 'Admin@1234';   // Change this!

    if ($username === $ADMIN_USER && $password === $ADMIN_PASS) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user']      = $username;
        $_SESSION['login_time']      = time();

        // Set a cookie as well (7 days)
        setcookie('admin_remember', base64_encode($username), time() + 7 * 86400, '/', '', false, true);

        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password. Please try again.';
    }
}
?>
  <div class="login-box">
    <div class="login-logo">MA<span>.</span></div>
    <p class="login-subtitle">Admin Dashboard</p>

    <?php if ($error): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" autocomplete="username" required/>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required/>
      </div>
      <button type="submit" class="btn">Login →</button>
    </form>
    <a href="../index.html" class="back-link">← Back to Portfolio</a>
  </div>
</body>
</html>
