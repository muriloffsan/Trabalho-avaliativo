<?php
require_once 'config.php';
function getTasks($conn) {
    $sql = "SELECT t.*, u.name as user_name FROM tasks t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC";
    $result = $conn->query($sql);
    $tasks = [];
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }
    return $tasks;
}

$all_tasks = getTasks($conn);
$tasks_by_status = [
    'a fazer' => [],
    'fazendo' => [],
    'concluído' => []
];

foreach ($all_tasks as $task) {
    if (isset($tasks_by_status[$task['status']])) {
        $tasks_by_status[$task['status']][] = $task;
    }
}

if ($conn && method_exists($conn, 'ping') && $conn->ping()) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GERENCIADOR DE TAREFAS - TASKSYNC</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="header-content">
            <img src="./Imagens/TaskSyncLogo.png" alt="TaskSync Logo" class="logo">
            <h1>GERENCIADOR DE TAREFAS - TASKSYNC</h1>
        </div>

        <div class="page-actions">
            <a href="add_task_page.php" class="button">Cadastrar Nova Tarefa</a>
            <a href="add_user_page.php" class="button">Cadastrar Novo Usuário</a>
        </div>
        <div class="task-board">
            <div class="status-column">
                <h2>A Fazer</h2>
                <?php if (empty($tasks_by_status['a fazer'])): ?>
                    <p>Nenhuma tarefa nesta coluna.</p>
                <?php else: ?>
                    <?php foreach ($tasks_by_status['a fazer'] as $task): ?>
                        <div class="task-card">
                            <h3><?php echo htmlspecialchars($task['description']); ?></h3>
                            <p><strong>Responsável:</strong> <?php echo htmlspecialchars($task['user_name']); ?></p>
                            <p><strong>Setor:</strong> <?php echo htmlspecialchars($task['sector']); ?></p>
                            <p><strong>Prioridade:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>
                            <p><strong>Criado em:</strong> <?php echo date('d/m/Y H:i', strtotime($task['created_at'])); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($task['status'])); ?></p>
                            <div class="task-actions">
    <button class="btn edit" onclick="window.location.href='edit_task.php?id=<?php echo $task['id']; ?>'"> Editar</button>
    <button class="btn delete" onclick="confirmDelete(<?php echo $task['id']; ?>)"> Excluir</button>
    <div class="status-change-options" style="margin-top: 10px;">
        <span> Mudar Status:</span><br>
        <?php
        $possible_statuses = ['a fazer', 'fazendo', 'concluído'];
        foreach ($possible_statuses as $status_option) {
            if ($task['status'] !== $status_option) {
                echo "<button class='btn status' onclick=\"confirmStatusChange({$task['id']}, '" . $status_option . "')\">" . ucfirst($status_option) . "</button> ";
            }
        }
        ?>
    </div>
</div>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="status-column">
                <h2>Fazendo</h2>
                 <?php if (empty($tasks_by_status['fazendo'])): ?>
                    <p>Nenhuma tarefa nesta coluna.</p>
                <?php else: ?>
                    <?php foreach ($tasks_by_status['fazendo'] as $task): ?>
                        <div class="task-card">
                            <h3><?php echo htmlspecialchars($task['description']); ?></h3>
                            <p><strong>Responsável:</strong> <?php echo htmlspecialchars($task['user_name']); ?></p>
                            <p><strong>Setor:</strong> <?php echo htmlspecialchars($task['sector']); ?></p>
                            <p><strong>Prioridade:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>
                            <p><strong>Criado em:</strong> <?php echo date('d/m/Y H:i', strtotime($task['created_at'])); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($task['status'])); ?></p>
                             <div class="task-actions">
    <button class="btn edit" onclick="window.location.href='edit_task.php?id=<?php echo $task['id']; ?>'">Editar</button>
    <button class="btn delete" onclick="confirmDelete(<?php echo $task['id']; ?>)"> Excluir</button>
    <div class="status-change-options" style="margin-top: 10px;">
        <span> Mudar Status:</span><br>
        <?php
        $possible_statuses = ['a fazer', 'fazendo', 'concluído'];
        foreach ($possible_statuses as $status_option) {
            if ($task['status'] !== $status_option) {
                echo "<button class='btn status' onclick=\"confirmStatusChange({$task['id']}, '" . $status_option . "')\">" . ucfirst($status_option) . "</button> ";
            }
        }
        ?>
    </div>
</div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="status-column">
                <h2>Concluído</h2>
                 <?php if (empty($tasks_by_status['concluído'])): ?>
                    <p>Nenhuma tarefa nesta coluna.</p>
                <?php else: ?>
                    <?php foreach ($tasks_by_status['concluído'] as $task): ?>
                        <div class="task-card">
                            <h3><?php echo htmlspecialchars($task['description']); ?></h3>
                            <p><strong>Responsável:</strong> <?php echo htmlspecialchars($task['user_name']); ?></p>
                            <p><strong>Setor:</strong> <?php echo htmlspecialchars($task['sector']); ?></p>
                            <p><strong>Prioridade:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>
                            <p><strong>Criado em:</strong> <?php echo date('d/m/Y H:i', strtotime($task['created_at'])); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($task['status'])); ?></p>
                             <div class="task-actions">
    <button class="btn edit" onclick="window.location.href='edit_task.php?id=<?php echo $task['id']; ?>'">Editar</button>
    <button class="btn delete" onclick="confirmDelete(<?php echo $task['id']; ?>)">Excluir</button>
    <div class="status-change-options" style="margin-top: 10px;">
        <span> Mudar Status:</span><br>
        <?php
        $possible_statuses = ['a fazer', 'fazendo', 'concluído'];
        foreach ($possible_statuses as $status_option) {
            if ($task['status'] !== $status_option) {
                echo "<button class='btn status' onclick=\"confirmStatusChange({$task['id']}, '" . $status_option . "')\">" . ucfirst($status_option) . "</button> ";
            }
        }
        ?>
    </div>
</div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Essa ação não pode ser desfeita!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Sim, excluir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `delete_task.php?id=${id}`;
        }
    });
}

function confirmStatusChange(id, status) {
    Swal.fire({
        title: 'Alterar status?',
        text: `Deseja mover esta tarefa para "${status}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#28a745'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `change_status.php?id=${id}&status=${encodeURIComponent(status)}`;
        }
    });
}
</script>

</body>
</html>
