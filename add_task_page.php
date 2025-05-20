<?php
require_once 'config.php'; 
function getUsers($conn) {
    $sql = "SELECT id, name FROM users ORDER BY name ASC";
    $result = $conn->query($sql);
    $users_list = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users_list[] = $row;
        }
    }
    return $users_list;
}

$users_for_form = getUsers($conn);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Tarefa - TaskSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Nova Tarefa</h1>
        <div class="form-section">
            <form action="add_task.php" method="POST">
            <label for="user_id">Responsável:</label>
            <select id="user_id" name="user_id" required>
                <option value="">Selecione um usuário</option>
                <?php foreach ($users_for_form as $user): ?>
                    <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['name']); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="description">Descrição:</label>
            <textarea id="description" name="description" rows="3" required></textarea>

            <label for="sector">Setor:</label>
            <input type="text" id="sector" name="sector" required>

            <label for="priority">Prioridade:</label>
            <select id="priority" name="priority" required>
                <option value="baixa">Baixa</option>
                <option value="média">Média</option>
                <option value="alta">Alta</option>
            </select>

            <button type="submit">Adicionar Tarefa</button>
            </form>
        </div>
        <p><a href="index.php">Voltar para o Quadro de Tarefas</a></p>
    </div>
</body>
</html>
<?php
if ($conn && method_exists($conn, 'ping') && $conn->ping()) {
    $conn->close();
}
?>
