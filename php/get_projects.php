<?php
// =============================================
// get_projects.php — Returns projects as JSON
// =============================================

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'db.php';

$filter = trim($_GET['filter'] ?? 'all');
$allowed = ['all', 'web', 'backend', 'fullstack'];
if (!in_array($filter, $allowed, true)) $filter = 'all';

try {
    $pdo = getDB();

    if ($filter === 'all') {
        $stmt = $pdo->query('SELECT * FROM projects ORDER BY featured DESC, created_at DESC');
    } else {
        $stmt = $pdo->prepare(
            'SELECT * FROM projects WHERE category = :cat ORDER BY featured DESC, created_at DESC'
        );
        $stmt->execute([':cat' => $filter]);
    }

    $projects = $stmt->fetchAll();
    echo json_encode($projects);

} catch (Exception $e) {
    // Return empty so JS fallback takes over gracefully
    echo json_encode([]);
}
