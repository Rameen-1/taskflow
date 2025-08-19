<?php include 'db.php'; session_start(); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['task_id'];
    $worker_id = $_SESSION['user_id'];
 
    $stmt = $conn->prepare("INSERT INTO task_applications (task_id, worker_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $task_id, $worker_id);
    $stmt->execute();
 
    header("Location: worker_dashboard.php");
}
?>
 
