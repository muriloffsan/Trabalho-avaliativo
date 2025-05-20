<?php
require_once 'config.php';

if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $task_id = trim($_GET['id']);

    $sql = "DELETE FROM tasks WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $param_id);

        $param_id = $task_id;

        if ($stmt->execute()) {
            header("location: index.php");
            exit();
        } else {
            echo "Ocorreu um erro ao excluir a tarefa. Por favor, tente novamente mais tarde.";
        }
        $stmt->close();
    }
} else {
    header("location: index.php");
    exit();
}
$conn->close();
?>