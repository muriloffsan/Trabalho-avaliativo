<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_POST['user_id'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $sector = trim($_POST['sector'] ?? '');
    $priority = $_POST['priority'] ?? '';

    if (!empty($user_id) && !empty($description) && !empty($sector) && !empty($priority)) {

        $sql = "INSERT INTO tasks (user_id, description, sector, priority) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("isss", $param_user_id, $param_description, $param_sector, $param_priority);

            $param_user_id = $user_id;
            $param_description = $description;
            $param_sector = $sector;
            $param_priority = $priority;

            if ($stmt->execute()) {
                header("location: index.php");
                exit();
            } else {
                echo "Ocorreu um erro ao adicionar a tarefa. Por favor, tente novamente mais tarde.";
            }

            $stmt->close();
        }
    } else {
        echo "Por favor, preencha todos os campos obrigatórios.";
    }
} else {
    header("location: index.php");
    exit();
}
$conn->close();
?>