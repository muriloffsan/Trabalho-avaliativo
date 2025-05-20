<?php
require_once 'config.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Usuário - TaskSync</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar Novo Usuário</h1>
        <div class="form-section">
            <form action="add_user.php" method="POST">
            <label for="user_name">Nome do Usuário:</label>
            <input type="text" id="user_name" name="user_name" required>
            <button type="submit">Adicionar Usuário</button>
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
