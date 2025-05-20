<?php
require_once 'config.php';

$task_id = $_GET['id'] ?? null;
$new_status = $_GET['status'] ?? null;

if (!$conn) {
    header("location: index.php?error=db_connection_failed");
    exit();
}
if (empty($task_id) || !is_numeric($task_id) || empty($new_status)) {
    if ($conn) $conn->close();
    header("location: index.php?error=missing_params");
    exit();
}
$allowed_statuses = ['a fazer', 'fazendo', 'concluído'];
if (!in_array($new_status, $allowed_statuses)) {
    if ($conn) $conn->close();
    header("location: index.php?error=invalid_status");
    exit();
}

$sql = "UPDATE tasks SET status = ? WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("si", $new_status, $task_id);

    if ($stmt->execute()) {
    } else {
        $stmt->close();
        $conn->close();
        header("location: index.php?error=update_failed&id=" . $task_id); 
        exit();
    }
    $stmt->close();
    $conn->close();
    header("location: index.php?success=status_updated");
    exit();
} else {
    $conn->close();
    header("location: index.php?error=prepare_failed");
    exit();
}
?>
