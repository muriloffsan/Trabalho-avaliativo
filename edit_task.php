<?php
require_once 'config.php';

$task = null;
$users = getUsers($conn); 

function getUsers($conn) {
    $sql = "SELECT id, name FROM users ORDER BY name ASC";
    $result = $conn->query($sql);
    $users = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
        $task_id = trim($_GET['id']);

        $sql = "SELECT * FROM tasks WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $param_id);
            $param_id = $task_id;

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows == 1) {
                    $task = $result->fetch_assoc();
                } else {
                    echo "Tarefa não encontrada.";
                    exit();
                }
            } else {
                echo "Ocorreu um erro ao buscar a tarefa.";
                exit();
            }
            $stmt->close();
        }
    } else {

        header("location: index.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['id'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $sector = trim($_POST['sector'] ?? '');
    $priority = $_POST['priority'] ?? '';
    $status = $_POST['status'] ?? '';

    if (!empty($task_id) && !empty($user_id) && !empty($description) && !empty($sector) && !empty($priority) && !empty($status)) {

        $sql = "UPDATE tasks SET user_id = ?, description = ?, sector = ?, priority = ?, status = ? WHERE id = ?";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("issssi", $param_user_id, $param_description, $param_sector, $param_priority, $param_status, $param_id);

            $param_user_id = $user_id;
            $param_description = $description;
            $param_sector = $sector;
            $param_priority = $priority;
            $param_status = $status;
            $param_id = $task_id;

            if ($stmt->execute()) {
                header("location: index.php");
                exit();
            } else {
                echo "Ocorreu um erro ao atualizar a tarefa. Por favor, tente novamente mais tarde.";
            }

            $stmt->close();
        }
    } else {
        echo "Por favor, preencha todos os campos obrigatórios.";

    }
}

if ($task):
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa - TaskSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Editar Tarefa</h1>
        <form action="edit_task.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">

            <label for="user_id">Responsável:</label>
            <select id="user_id" name="user_id" required>
                <option value="">Selecione um usuário</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user['id']; ?>" <?php echo ($user['id'] == $task['user_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($user['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="description">Descrição:</label>
            <textarea id="description" name="description" rows="3" required><?php echo htmlspecialchars($task['description']); ?></textarea><br><br>

            <label for="sector">Setor:</label>
            <input type="text" id="sector" name="sector" value="<?php echo htmlspecialchars($task['sector']); ?>" required><br><br>

            <label for="priority">Prioridade:</label>
            <select id="priority" name="priority" required>
                <option value="baixa" <?php echo ($task['priority'] == 'baixa') ? 'selected' : ''; ?>>Baixa</option>
                <option value="média" <?php echo ($task['priority'] == 'média') ? 'selected' : ''; ?>>Média</option>
                <option value="alta" <?php echo ($task['priority'] == 'alta') ? 'selected' : ''; ?>>Alta</option>
            </select><br><br>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="a fazer" <?php echo ($task['status'] == 'a fazer') ? 'selected' : ''; ?>>A Fazer</option>
                <option value="fazendo" <?php echo ($task['status'] == 'fazendo') ? 'selected' : ''; ?>>Fazendo</option>
                <option value="concluído" <?php echo ($task['status'] == 'concluído') ? 'selected' : ''; ?>>Concluído</option>
            </select><br><br>

            <button type="submit">Atualizar Tarefa</button>
            <a href="index.php">Cancelar</a>
        </form>
    </div>
</body>
</html>
<?php
endif;

if ($conn && $conn->ping()) {
    $conn->close();
}
?>