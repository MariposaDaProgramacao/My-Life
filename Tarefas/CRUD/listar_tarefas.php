<?php include '../db.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas - My Life</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>📋 Lista de Tarefas</h1>
        
        <!-- Filtros -->
        <form method="GET" action="" class="filtros">
            <div class="filtro-group">
                <label>Filtrar por status:</label>
                <select name="filtro_status">
                    <option value="">Todos</option>
                    <option value="pendente" <?php echo (isset($_GET['filtro_status']) && $_GET['filtro_status'] == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                    <option value="em_andamento" <?php echo (isset($_GET['filtro_status']) && $_GET['filtro_status'] == 'em_andamento') ? 'selected' : ''; ?>>Em Andamento</option>
                    <option value="concluida" <?php echo (isset($_GET['filtro_status']) && $_GET['filtro_status'] == 'concluida') ? 'selected' : ''; ?>>Concluída</option>
                </select>
            </div>
            
            <div class="filtro-group">
                <label>Categoria:</label>
                <select name="filtro_categoria">
                    <option value="">Todas</option>
                    <option value="Trabalho" <?php echo (isset($_GET['filtro_categoria']) && $_GET['filtro_categoria'] == 'Trabalho') ? 'selected' : ''; ?>>Trabalho</option>
                    <option value="Estudo" <?php echo (isset($_GET['filtro_categoria']) && $_GET['filtro_categoria'] == 'Estudo') ? 'selected' : ''; ?>>Estudo</option>
                    <option value="Casa" <?php echo (isset($_GET['filtro_categoria']) && $_GET['filtro_categoria'] == 'Casa') ? 'selected' : ''; ?>>Casa</option>
                    <option value="Lazer" <?php echo (isset($_GET['filtro_categoria']) && $_GET['filtro_categoria'] == 'Lazer') ? 'selected' : ''; ?>>Lazer</option>
                </select>
            </div>
            
            <div class="filtro-group">
                <input type="submit" value="🔍 Filtrar">
            </div>
        </form>
        
        <a href="adicionar_tarefa.php" class="btn-adicionar">➕ Adicionar Nova Tarefa</a>
        
        <?php
        // Construindo a consulta com filtros
        $sql = "SELECT * FROM tarefas WHERE 1=1";
        
        if(isset($_GET['filtro_status']) && $_GET['filtro_status'] != '') {
            $status = $conn->real_escape_string($_GET['filtro_status']);
            $sql .= " AND status_tarefa = '$status'";
        }
        
        if(isset($_GET['filtro_categoria']) && $_GET['filtro_categoria'] != '') {
            $categoria = $conn->real_escape_string($_GET['filtro_categoria']);
            $sql .= " AND categoria_tarefa = '$categoria'";
        }
        
        $sql .= " ORDER BY data_inclusao DESC";
        
        $result = $conn->query($sql);
        
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Define a classe do status
                $status_class = '';
                $status_text = '';
                switch($row['status_tarefa']) {
                    case 'pendente':
                        $status_class = 'status-pendente';
                        $status_text = '⏳ Pendente';
                        break;
                    case 'em_andamento':
                        $status_class = 'status-em_andamento';
                        $status_text = '🔄 Em Andamento';
                        break;
                    case 'concluida':
                        $status_class = 'status-concluida';
                        $status_text = '✅ Concluída';
                        break;
                }
                ?>
                
                <div class="card">
                    <h3>📌 <?php echo htmlspecialchars($row['nome_tarefa']); ?></h3>
                    <p><strong>📝 Descrição:</strong> <?php echo htmlspecialchars($row['descricao_tarefa'] ?? 'Sem descrição'); ?></p>
                    <p><strong>🏷️ Categoria:</strong> <?php echo htmlspecialchars($row['categoria_tarefa']); ?></p>
                    <p><strong>📅 Data de inclusão:</strong> <?php echo date('d/m/Y H:i', strtotime($row['data_inclusao'])); ?></p>
                    
                    <?php if($row['data_conclusao']): ?>
                        <p><strong>🎯 Data de conclusão:</strong> <?php echo date('d/m/Y', strtotime($row['data_conclusao'])); ?></p>
                    <?php endif; ?>
                    
                    <div class="status <?php echo $status_class; ?>"><?php echo $status_text; ?></div>
                    
                    <div class="acoes">
                        <a href="editar_tarefa.php?id=<?php echo $row['id']; ?>">✏️ Editar</a>
                        <a href="remover_tarefa.php?id=<?php echo $row['id']; ?>" onclick='return confirm("Tem certeza que deseja remover esta tarefa?")'>🗑️ Remover</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='nenhuma-tarefa'>📭 Nenhuma tarefa encontrada<br><small>Que tal adicionar uma nova tarefa? 🎯</small></div>";
        }
        
        $conn->close();
        ?>
        
        <a href="../index.php" class="link-voltar">🏠 Voltar para o início</a>
    </div>
</body>
</html>