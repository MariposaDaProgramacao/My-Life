<?php include '../db.php';

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: listar_tarefas.php?erro=ID da tarefa não informado");
    exit();
}

$id = $_GET['id'];

// Remover a tarefa
$sql = "DELETE FROM tarefas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if($stmt->execute()) {
    header("Location: listar_tarefas.php?sucesso=Tarefa removida com sucesso! 🗑️");
} else {
    header("Location: listar_tarefas.php?erro=Erro ao remover tarefa");
}

$stmt->close();
$conn->close();
?>