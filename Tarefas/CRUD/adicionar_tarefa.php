<?php include '../db.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Tarefa - My Life</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>➕ Adicionar Nova Tarefa</h1>
        
        <?php if(isset($_GET['erro'])): ?>
            <div class="mensagem-erro">❌ <?php echo htmlspecialchars($_GET['erro']); ?></div>
        <?php endif; ?>
        
        <form action="" method="post" class="form-adicionar">
            <div class="form-group">
                <label>📌 Nome da tarefa *</label>
                <input type="text" name="nome_tarefa" required placeholder="Digite o nome da tarefa">
            </div>
            
            <div class="form-group">
                <label>📝 Descrição</label>
                <textarea name="descricao_tarefa" rows="4" placeholder="Descreva sua tarefa em detalhes..."></textarea>
                <small>Descreva sua tarefa em detalhes (opcional)</small>
            </div>
            
            <div class="form-group">
                <label>🏷️ Categoria *</label>
                <select name="categoria_tarefa" required>
                    <option value="Trabalho">💼 Trabalho</option>
                    <option value="Estudo">📚 Estudo</option>
                    <option value="Casa">🏠 Casa</option>
                    <option value="Lazer">🎮 Lazer</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>⚡ Status</label>
                <select name="status_tarefa">
                    <option value="pendente">⏳ Pendente</option>
                    <option value="em_andamento">🔄 Em Andamento</option>
                    <option value="concluida">✅ Concluída</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>🎯 Data de conclusão</label>
                <input type="date" name="data_conclusao">
                <small>Quando a tarefa será concluída (opcional)</small>
            </div>
            
            <div class="botoes-form">
                <input type="submit" name="submit" value="💾 Salvar Tarefa" class="btn-submit">
                <a href="listar_tarefas.php" class="btn-cancelar">❌ Cancelar</a>
            </div>
        </form>
        
        <div style="margin-top: 20px; text-align: center;">
            <a href="listar_tarefas.php" class="link-voltar">🏠 Voltar para lista de tarefas</a>
        </div>
    </div>
</body>
</html>

<?php
// Processar o formulário
if(isset($_POST['submit'])) {
    $nome_tarefa = $_POST['nome_tarefa'];
    $descricao_tarefa = $_POST['descricao_tarefa'] ?? '';
    $categoria_tarefa = $_POST['categoria_tarefa'];
    $status_tarefa = $_POST['status_tarefa'];
    $data_conclusao = !empty($_POST['data_conclusao']) ? $_POST['data_conclusao'] : NULL;
    
    if(empty($nome_tarefa)) {
        header("Location: adicionar_tarefa.php?erro=Nome da tarefa é obrigatório");
        exit();
    }
    
    $sql = "INSERT INTO tarefas (nome_tarefa, descricao_tarefa, status_tarefa, categoria_tarefa, data_conclusao) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome_tarefa, $descricao_tarefa, $status_tarefa, $categoria_tarefa, $data_conclusao);
    
    if($stmt->execute()) {
        header("Location: listar_tarefas.php?sucesso=Tarefa adicionada com sucesso! 🎉");
    } else {
        header("Location: adicionar_tarefa.php?erro=Erro ao adicionar: " . $conn->error);
    }
    
    $stmt->close();
    $conn->close();
}
?>