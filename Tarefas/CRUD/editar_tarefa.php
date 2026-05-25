<?php include '../db.php';

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listar_tarefas.php?erro=ID não informado");
    exit();
}

$id = $_GET['id'];

// Processar atualização
if(isset($_POST['submit'])) {
    $nome_tarefa = $_POST['nome_tarefa'];
    $descricao_tarefa = $_POST['descricao_tarefa'];
    $categoria_tarefa = $_POST['categoria_tarefa'];
    $status_tarefa = $_POST['status_tarefa'];
    $data_conclusao = !empty($_POST['data_conclusao']) ? $_POST['data_conclusao'] : NULL;
    
    $sql = "UPDATE tarefas SET nome_tarefa=?, descricao_tarefa=?, categoria_tarefa=?, status_tarefa=?, data_conclusao=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nome_tarefa, $descricao_tarefa, $categoria_tarefa, $status_tarefa, $data_conclusao, $id);
    
    if($stmt->execute()) {
        header("Location: listar_tarefas.php?sucesso=Tarefa atualizada com sucesso!");
    } else {
        header("Location: editar_tarefa.php?id=$id&erro=Erro ao atualizar");
    }
    exit();
}

// Buscar dados da tarefa
$sql = "SELECT * FROM tarefas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$tarefa = $result->fetch_assoc();

if(!$tarefa) {
    header("Location: listar_tarefas.php?erro=Tarefa não encontrada");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa - My Life</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <h1>✏️ Editar Tarefa</h1>
        
        <?php if(isset($_GET['erro'])): ?>
            <div class="mensagem-erro">❌ <?php echo htmlspecialchars($_GET['erro']); ?></div>
        <?php endif; ?>
        
        <form method="POST" class="form-editar">
            <div class="form-group">
                <label>📌 Nome da tarefa *</label>
                <input type="text" name="nome_tarefa" value="<?php echo htmlspecialchars($tarefa['nome_tarefa']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>📝 Descrição</label>
                <textarea name="descricao_tarefa" rows="4"><?php echo htmlspecialchars($tarefa['descricao_tarefa']); ?></textarea>
                <small>Descreva sua tarefa em detalhes (opcional)</small>
            </div>
            
            <div class="form-group">
                <label>🏷️ Categoria *</label>
                <select name="categoria_tarefa" required>
                    <option value="Trabalho" <?php echo $tarefa['categoria_tarefa'] == 'Trabalho' ? 'selected' : ''; ?>>💼 Trabalho</option>
                    <option value="Estudo" <?php echo $tarefa['categoria_tarefa'] == 'Estudo' ? 'selected' : ''; ?>>📚 Estudo</option>
                    <option value="Casa" <?php echo $tarefa['categoria_tarefa'] == 'Casa' ? 'selected' : ''; ?>>🏠 Casa</option>
                    <option value="Lazer" <?php echo $tarefa['categoria_tarefa'] == 'Lazer' ? 'selected' : ''; ?>>🎮 Lazer</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>⚡ Status</label>
                <select name="status_tarefa">
                    <option value="pendente" <?php echo $tarefa['status_tarefa'] == 'pendente' ? 'selected' : ''; ?>>⏳ Pendente</option>
                    <option value="em_andamento" <?php echo $tarefa['status_tarefa'] == 'em_andamento' ? 'selected' : ''; ?>>🔄 Em Andamento</option>
                    <option value="concluida" <?php echo $tarefa['status_tarefa'] == 'concluida' ? 'selected' : ''; ?>>✅ Concluída</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>🎯 Data de conclusão</label>
                <input type="date" name="data_conclusao" value="<?php echo $tarefa['data_conclusao']; ?>">
                <small>Quando a tarefa foi ou será concluída (opcional)</small>
            </div>
            
            <div class="botoes-form">
                <input type="submit" name="submit" value="💾 Salvar Alterações" class="btn-submit">
                <a href="listar_tarefas.php" class="btn-cancelar">❌ Cancelar</a>
            </div>
        </form>
        
        <div style="margin-top: 20px; text-align: center;">
            <a href="listar_tarefas.php" class="link-voltar">🏠 Voltar para lista de tarefas</a>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>