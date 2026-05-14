<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard — Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg: #0a0a0f; --bg2: #111118; --surface: #16161f;
      --border: #2a2a38; --accent: #00ff88; --text: #e8e8f0;
      --muted: #6b6b80; --red: #ff4757;
    }
    body { font-family: 'Space Mono', monospace; background: var(--bg); color: var(--text); min-height: 100vh; }

    /* LAYOUT */
    .layout { display: grid; grid-template-columns: 220px 1fr; min-height: 100vh; }

    /* SIDEBAR */
    .sidebar {
      background: var(--surface);
      border-right: 1px solid var(--border);
      padding: 2rem 1.5rem;
      display: flex; flex-direction: column; gap: 0.5rem;
    }
    .sidebar-logo { font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 800; color: var(--text); margin-bottom: 2rem; }
    .sidebar-logo span { color: var(--accent); }
    .nav-item {
      display: flex; align-items: center; gap: 0.75rem;
      padding: 0.7rem 1rem; border-radius: 8px;
      font-size: 0.8rem; color: var(--muted);
      cursor: pointer; transition: all 0.2s; border: none; background: none; width: 100%; text-align: left;
    }
    .nav-item:hover, .nav-item.active { background: rgba(0,255,136,0.08); color: var(--accent); }
    .sidebar-spacer { flex: 1; }
    .logout-btn {
      display: block; text-align: left; width: 100%;
      padding: 0.7rem 1rem; border-radius: 8px;
      font-family: 'Space Mono', monospace; font-size: 0.8rem;
      color: var(--red); cursor: pointer; border: 1px solid transparent;
      background: none; transition: all 0.2s;
    }
    .logout-btn:hover { border-color: var(--red); background: rgba(255,71,87,0.08); }

    /* MAIN */
    .main { padding: 2.5rem; overflow-y: auto; }
    .page { display: none; }
    .page.active { display: block; }

    h1 { font-family: 'Syne', sans-serif; font-size: 1.8rem; font-weight: 800; margin-bottom: 0.5rem; }
    .page-sub { font-size: 0.8rem; color: var(--muted); margin-bottom: 2rem; }

    /* STATS */
    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2.5rem; }
    .stat-card {
      background: var(--surface); border: 1px solid var(--border);
      border-radius: 12px; padding: 1.5rem;
    }
    .stat-card .num { font-family: 'Syne', sans-serif; font-size: 2.5rem; font-weight: 800; color: var(--accent); }
    .stat-card .lbl { font-size: 0.72rem; color: var(--muted); letter-spacing: 0.1em; text-transform: uppercase; }

    /* TABLE */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
    th { text-align: left; padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); color: var(--muted); font-size: 0.72rem; letter-spacing: 0.1em; text-transform: uppercase; font-weight: 400; }
    td { padding: 0.85rem 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
    tr:hover td { background: rgba(0,255,136,0.03); }

    .badge { display: inline-flex; align-items: center; padding: 0.2rem 0.7rem; border-radius: 20px; font-size: 0.68rem; letter-spacing: 0.05em; text-transform: uppercase; }
    .badge-web      { background: rgba(0,102,255,0.15); color: #82aaff; border: 1px solid rgba(0,102,255,0.3); }
    .badge-fullstack{ background: rgba(0,255,136,0.1);  color: var(--accent); border: 1px solid rgba(0,255,136,0.3); }
    .badge-backend  { background: rgba(200,150,0,0.15); color: #ffd700; border: 1px solid rgba(200,150,0,0.3); }

    /* FORM */
    .card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 2rem; margin-bottom: 2rem; }
    .card h2 { font-family: 'Syne', sans-serif; font-size: 1.2rem; font-weight: 800; margin-bottom: 1.5rem; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
    .form-group.full { grid-column: 1 / -1; }
    label { font-size: 0.72rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); }
    input, select, textarea {
      background: var(--bg); border: 1px solid var(--border); border-radius: 8px;
      padding: 0.7rem 0.9rem; font-family: 'Space Mono', monospace; font-size: 0.82rem;
      color: var(--text); outline: none; transition: border-color 0.2s;
    }
    input:focus, select:focus, textarea:focus { border-color: var(--accent); }
    select option { background: var(--bg2); }
    .form-actions { margin-top: 1rem; display: flex; gap: 0.75rem; grid-column: 1 / -1; }
    .btn-primary { padding: 0.7rem 1.5rem; background: var(--accent); color: #0a0a0f; font-family: 'Space Mono', monospace; font-size: 0.8rem; font-weight: 700; border: none; border-radius: 8px; cursor: pointer; transition: transform 0.2s; }
    .btn-primary:hover { transform: translateY(-1px); }
    .btn-danger  { padding: 0.5rem 0.9rem; background: transparent; color: var(--red); font-family: 'Space Mono', monospace; font-size: 0.75rem; border: 1px solid var(--red); border-radius: 6px; cursor: pointer; transition: background 0.2s; }
    .btn-danger:hover  { background: rgba(255,71,87,0.1); }

    .alert { padding: 0.8rem 1rem; border-radius: 8px; font-size: 0.8rem; margin-bottom: 1rem; display: none; }
    .alert.success { background: rgba(0,255,136,0.1); border: 1px solid rgba(0,255,136,0.3); color: var(--accent); display: block; }
    .alert.error   { background: rgba(255,71,87,0.1);  border: 1px solid rgba(255,71,87,0.3);  color: var(--red);    display: block; }

    @media (max-width: 768px) {
      .layout { grid-template-columns: 1fr; }
      .sidebar { display: none; }
      .stats-row { grid-template-columns: 1fr; }
      .form-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Session timeout: 2 hours
if (isset($_SESSION['login_time']) && time() - $_SESSION['login_time'] > 7200) {
    session_destroy();
    header('Location: login.php?timeout=1');
    exit;
}

require_once '../php/db.php';

// Handle project actions
$msg = '';
$msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_project') {
        $title       = trim(htmlspecialchars($_POST['title'] ?? ''));
        $description = trim(htmlspecialchars($_POST['description'] ?? ''));
        $tags        = trim(htmlspecialchars($_POST['tags'] ?? ''));
        $category    = trim($_POST['category'] ?? 'web');
        $emoji       = trim(htmlspecialchars($_POST['emoji'] ?? '💻'));
        $github_url  = trim($_POST['github_url'] ?? '');
        $live_url    = trim($_POST['live_url'] ?? '');
        $featured    = isset($_POST['featured']) ? 1 : 0;

        if ($title && $description) {
            $pdo = getDB();
            $stmt = $pdo->prepare(
                'INSERT INTO projects (title, description, tags, category, emoji, github_url, live_url, featured, created_at)
                 VALUES (:title, :description, :tags, :category, :emoji, :github_url, :live_url, :featured, NOW())'
            );
            $stmt->execute(compact('title','description','tags','category','emoji','github_url','live_url','featured'));
            $msg = 'Project added successfully!';
            $msgType = 'success';
        } else {
            $msg = 'Title and description are required.';
            $msgType = 'error';
        }
    }

    if ($action === 'delete_project') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $pdo = getDB();
            $pdo->prepare('DELETE FROM projects WHERE id = :id')->execute([':id' => $id]);
            $msg = 'Project deleted.';
            $msgType = 'success';
        }
    }
}

// Fetch data
try {
    $pdo      = getDB();
    $projects = $pdo->query('SELECT * FROM projects ORDER BY created_at DESC')->fetchAll();
    $messages = $pdo->query('SELECT * FROM messages ORDER BY created_at DESC LIMIT 20')->fetchAll();
    $projCount = count($projects);
    $msgCount  = count($messages);
} catch (Exception $e) {
    $projects = []; $messages = []; $projCount = 0; $msgCount = 0;
}
?>
<div class="layout">
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-logo">MA<span>.</span></div>
    <button class="nav-item active" onclick="showPage('overview', this)">📊 Overview</button>
    <button class="nav-item" onclick="showPage('projects', this)">💻 Projects</button>
    <button class="nav-item" onclick="showPage('messages', this)">✉ Messages</button>
    <div class="sidebar-spacer"></div>
    <form method="POST" action="logout.php">
      <button type="submit" class="logout-btn">⏻ Logout</button>
    </form>
  </aside>

  <!-- MAIN -->
  <main class="main">

    <!-- OVERVIEW -->
    <div class="page active" id="page-overview">
      <h1>Dashboard</h1>
      <p class="page-sub">Welcome back, <?= htmlspecialchars($_SESSION['admin_user']) ?> 👋</p>

      <div class="stats-row">
        <div class="stat-card">
          <div class="num"><?= $projCount ?></div>
          <div class="lbl">Total Projects</div>
        </div>
        <div class="stat-card">
          <div class="num"><?= $msgCount ?></div>
          <div class="lbl">Messages</div>
        </div>
        <div class="stat-card">
          <div class="num"><?= date('Y') ?></div>
          <div class="lbl">Active Year</div>
        </div>
      </div>

      <div class="card">
        <h2>Recent Messages</h2>
        <?php if (empty($messages)): ?>
          <p style="color:var(--muted);font-size:.82rem">No messages yet.</p>
        <?php else: ?>
        <div class="table-wrap">
          <table>
            <thead>
              <tr><th>Name</th><th>Email</th><th>Subject</th><th>Date</th></tr>
            </thead>
            <tbody>
              <?php foreach (array_slice($messages, 0, 5) as $m): ?>
              <tr>
                <td><?= htmlspecialchars($m['name']) ?></td>
                <td><?= htmlspecialchars($m['email']) ?></td>
                <td><?= htmlspecialchars($m['subject']) ?></td>
                <td style="color:var(--muted);font-size:.75rem"><?= date('M j, Y', strtotime($m['created_at'])) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- PROJECTS -->
    <div class="page" id="page-projects">
      <h1>Projects</h1>
      <p class="page-sub">Add, edit, and manage your portfolio projects.</p>

      <?php if ($msg): ?>
        <div class="alert <?= $msgType ?>"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <!-- Add Project Form -->
      <div class="card">
        <h2>Add New Project</h2>
        <form method="POST" action="dashboard.php#page-projects">
          <input type="hidden" name="action" value="add_project"/>
          <div class="form-grid">
            <div class="form-group">
              <label>Project Title *</label>
              <input type="text" name="title" placeholder="My Awesome Project" required/>
            </div>
            <div class="form-group">
              <label>Category</label>
              <select name="category">
                <option value="web">Web</option>
                <option value="backend">Backend</option>
                <option value="fullstack">Full Stack</option>
              </select>
            </div>
            <div class="form-group full">
              <label>Description *</label>
              <textarea name="description" rows="3" placeholder="Brief description of the project..."></textarea>
            </div>
            <div class="form-group">
              <label>Tags (comma-separated)</label>
              <input type="text" name="tags" placeholder="PHP, MySQL, JS"/>
            </div>
            <div class="form-group">
              <label>Emoji Icon</label>
              <input type="text" name="emoji" placeholder="💻" maxlength="4"/>
            </div>
            <div class="form-group">
              <label>GitHub URL</label>
              <input type="url" name="github_url" placeholder="https://github.com/..."/>
            </div>
            <div class="form-group">
              <label>Live URL</label>
              <input type="url" name="live_url" placeholder="https://..."/>
            </div>
            <div class="form-group" style="flex-direction:row;align-items:center;gap:.6rem">
              <input type="checkbox" name="featured" id="featured" style="width:16px;height:16px"/>
              <label for="featured" style="text-transform:none;letter-spacing:0">Featured project</label>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn-primary">Add Project</button>
            </div>
          </div>
        </form>
      </div>

      <!-- Projects Table -->
      <div class="card">
        <h2>Existing Projects (<?= $projCount ?>)</h2>
        <?php if (empty($projects)): ?>
          <p style="color:var(--muted);font-size:.82rem">No projects added yet. Add your first one above!</p>
        <?php else: ?>
        <div class="table-wrap">
          <table>
            <thead>
              <tr><th>Emoji</th><th>Title</th><th>Category</th><th>Tags</th><th>Date</th><th>Action</th></tr>
            </thead>
            <tbody>
              <?php foreach ($projects as $p): ?>
              <tr>
                <td><?= htmlspecialchars($p['emoji']) ?></td>
                <td><?= htmlspecialchars($p['title']) ?></td>
                <td><span class="badge badge-<?= htmlspecialchars($p['category']) ?>"><?= htmlspecialchars($p['category']) ?></span></td>
                <td style="color:var(--muted);font-size:.75rem"><?= htmlspecialchars($p['tags']) ?></td>
                <td style="color:var(--muted);font-size:.75rem"><?= date('M j, Y', strtotime($p['created_at'])) ?></td>
                <td>
                  <form method="POST" onsubmit="return confirm('Delete this project?')">
                    <input type="hidden" name="action" value="delete_project"/>
                    <input type="hidden" name="id" value="<?= (int)$p['id'] ?>"/>
                    <button type="submit" class="btn-danger">Delete</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- MESSAGES -->
    <div class="page" id="page-messages">
      <h1>Messages</h1>
      <p class="page-sub">Contact form submissions from your portfolio.</p>
      <div class="card">
        <?php if (empty($messages)): ?>
          <p style="color:var(--muted);font-size:.82rem">No messages yet.</p>
        <?php else: ?>
        <div class="table-wrap">
          <table>
            <thead>
              <tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Date</th></tr>
            </thead>
            <tbody>
              <?php foreach ($messages as $m): ?>
              <tr>
                <td><?= htmlspecialchars($m['name']) ?></td>
                <td><?= htmlspecialchars($m['email']) ?></td>
                <td><?= htmlspecialchars($m['subject']) ?></td>
                <td style="color:var(--muted);font-size:.78rem;max-width:300px"><?= htmlspecialchars(substr($m['message'], 0, 80)) . (strlen($m['message']) > 80 ? '...' : '') ?></td>
                <td style="color:var(--muted);font-size:.75rem"><?= date('M j, Y', strtotime($m['created_at'])) ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>

  </main>
</div>

<script>
function showPage(name, el) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  document.getElementById('page-' + name).classList.add('active');
  el.classList.add('active');
}
</script>
</body>
</html>
