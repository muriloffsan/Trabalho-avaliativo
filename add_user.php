<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_name']) && !empty(trim($_POST['user_name']))) {
        $user_name = trim($_POST['user_name']);
        $sql = "INSERT INTO users (name) VALUES (?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_name);

            $param_name = $user_name;
            if ($stmt->execute()) {
                header("location: index.php");
                exit();
            } else {
                echo "Ocorreu um erro. Por favor, tente novamente mais tarde.";
            }

            $stmt->close();
        }
    } else {
        echo "Por favor, preencha o nome do usuário.";
    }
} else {
    header("location: index.php");
    exit();
}

$conn->close();
?>