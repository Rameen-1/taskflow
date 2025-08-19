<?php include 'db.php'; session_start(); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $category = $_POST['category'];
    $reward = $_POST['reward'];
    $deadline = $_POST['deadline'];
    $requester_id = $_SESSION['user_id'];
 
    $stmt = $conn->prepare("INSERT INTO tasks (requester_id, title, description, category, reward, deadline) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssds", $requester_id, $title, $desc, $category, $reward, $deadline);
    $stmt->execute();
 
    $msg = "Task posted successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Create Task</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Post a New Task</h2>
    <?php if (isset($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
    <form method="post">
        <input type="text" name="title" placeholder="Task Title" required><br>
        <textarea name="description" placeholder="Task Description" required></textarea><br>
        <input type="text" name="category" placeholder="Category (e.g., Survey, Data Entry)" required><br>
        <input type="number" name="reward" placeholder="Reward ($)" step="0.01" required><br>
        <input type="date" name="deadline" required><br>
        <button type="submit">Create Task</button>
    </form>
</div>
</body>
</html>
 
