<?php
include 'db.php';
session_start();
 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['application_id'])) {
    $application_id = intval($_POST['application_id']);
    $worker_id = $_SESSION['user_id'];
 
    // Verify that this application belongs to this worker
    $stmt = $conn->prepare("SELECT id FROM task_applications WHERE id = ? AND worker_id = ?");
    $stmt->bind_param("ii", $application_id, $worker_id);
    $stmt->execute();
    $stmt->store_result();
 
    if ($stmt->num_rows === 1) {
        // Update status to completed
        $update = $conn->prepare("UPDATE task_applications SET status = 'completed' WHERE id = ?");
        $update->bind_param("i", $application_id);
        $update->execute();
    }
 
    header("Location: worker_dashboard.php");
    exit();
}
?>
 
