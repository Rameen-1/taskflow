<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Browse Tasks</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2 style="text-align:center;">Available Tasks</h2>
<div class="task-list">
<?php
$result = $conn->query("SELECT * FROM tasks WHERE status='open'");
while ($row = $result->fetch_assoc()) {
    echo "<div class='task-card'>";
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p>" . $row['description'] . "</p>";
    echo "<p><strong>Category:</strong> " . $row['category'] . "</p>";
    echo "<p><strong>Reward:</strong> $" . $row['reward'] . "</p>";
    echo "<p><strong>Deadline:</strong> " . $row['deadline'] . "</p>";
    echo "<form action='apply_task.php' method='post'>";
    echo "<input type='hidden' name='task_id' value='" . $row['id'] . "'>";
    echo "<button type='submit'>Accept Task</button>";
    echo "</form>";
    echo "</div>";
}
?>
</div>
</body>
</html>
 
