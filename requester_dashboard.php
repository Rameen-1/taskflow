<?php
// Debug mode to show PHP errors (optional)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
include 'db.php';
session_start();
 
// Access control
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'requester') {
    header("Location: login.php");
    exit();
}
 
$requester_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM tasks WHERE requester_id = $requester_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Requester Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2 style="text-align:center;">Welcome, <?php echo $_SESSION['user_name']; ?> (Requester)</h2>
 
    <div class="form-container" style="text-align:center;">
        <a href="create_task.php" class="btn">Post New Task</a>
        <a href="logout.php" class="btn secondary">Logout</a>
    </div>
 
    <div class="task-list">
        <h3 style="text-align:center;">Your Posted Tasks</h3>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="task-card">
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <p><?= htmlspecialchars($row['description']) ?></p>
                <p><strong>Category:</strong> <?= $row['category'] ?></p>
                <p><strong>Reward:</strong> $<?= $row['reward'] ?></p>
                <p><strong>Deadline:</strong> <?= $row['deadline'] ?></p>
                <p><strong>Status:</strong> <?= $row['status'] ?></p>
                <?php
                    $task_id = $row['id'];
                    $apply_res = $conn->query("SELECT COUNT(*) AS total FROM task_applications WHERE task_id = $task_id");
                    $apply_data = $apply_res->fetch_assoc();
                ?>
                <p><strong>Applicants:</strong> <?= $apply_data['total'] ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
 
