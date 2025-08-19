<?php
include 'db.php';
session_start();
 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'worker') {
    header("Location: login.php");
    exit();
}
 
$worker_id = $_SESSION['user_id'];
?>
 
<!DOCTYPE html>
<html>
<head>
  <title>Worker Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
 
<h2 style="text-align:center;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (Worker)</h2>
 
<div class="form-container" style="text-align:center;">
    <a href="logout.php" class="btn secondary">Logout</a>
</div>
 
<!-- Accepted Tasks Section -->
<div class="task-list">
  <h3>Your Accepted Tasks</h3>
  <?php
  $res = $conn->query("SELECT a.id AS app_id, t.title, a.status 
                       FROM task_applications a 
                       JOIN tasks t ON a.task_id = t.id 
                       WHERE a.worker_id = $worker_id");
 
  if ($res->num_rows > 0) {
      while ($row = $res->fetch_assoc()) {
          echo "<div class='task-card'>";
          echo "<p><strong>" . htmlspecialchars($row['title']) . "</strong></p>";
          echo "<p>Status: " . htmlspecialchars($row['status']) . "</p>";
 
          if ($row['status'] === 'pending' || $row['status'] === 'accepted') {
              echo "<form action='complete_task.php' method='post'>";
              echo "<input type='hidden' name='application_id' value='" . $row['app_id'] . "'>";
              echo "<button type='submit'>Mark as Completed</button>";
              echo "</form>";
          }
 
          echo "</div>";
      }
  } else {
      echo "<p style='text-align:center;'>You haven't accepted any tasks yet.</p>";
  }
  ?>
</div>
 
<!-- Available Tasks Section -->
<div class="task-list">
  <h3>Available Tasks</h3>
  <?php
  $available = $conn->query("
    SELECT t.* 
    FROM tasks t 
    WHERE t.status = 'open' 
    AND t.id NOT IN (
      SELECT task_id FROM task_applications WHERE worker_id = $worker_id
    )
    ORDER BY t.created_at DESC
  ");
 
  if ($available->num_rows > 0) {
      while ($row = $available->fetch_assoc()) {
          echo "<div class='task-card'>";
          echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
          echo "<p>" . htmlspecialchars($row['description']) . "</p>";
          echo "<p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>";
          echo "<p><strong>Reward:</strong> $" . $row['reward'] . "</p>";
          echo "<p><strong>Deadline:</strong> " . $row['deadline'] . "</p>";
          echo "<form action='apply_task.php' method='post'>";
          echo "<input type='hidden' name='task_id' value='" . $row['id'] . "'>";
          echo "<button type='submit'>Accept Task</button>";
          echo "</form>";
          echo "</div>";
      }
  } else {
      echo "<p style='text-align:center;'>No available tasks at the moment. Check back later!</p>";
  }
  ?>
</div>
 
</body>
</html>
 
 
