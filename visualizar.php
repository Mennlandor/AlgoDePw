<?php
session_start();
require 'config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = ?');
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    $_SESSION['mensagem'] = 'Produto não encontrado.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: index.php');
    exit;
}

require 'views/header.php';
?>

<h2 class="mb-4">Detalhes do Produto</h2>

<div class="card-produto bg-white p-4">
    <?php if (!empty($produto['imagem'])): ?>
        <img src="uploads/<?= htmlspecialchars($produto['imagem']) ?>" class="foto-produto-grande mb-3" alt="Foto do produto">
    <?php else: ?>
        <div class="sem-foto mb-3" style="width:120px; height:120px;">sem foto</div>
    <?php endif; ?>
    <p><strong>ID:</strong> <?= htmlspecialchars($produto['id']) ?></p>
    <p><strong>Nome:</strong> <?= htmlspecialchars($produto['nome']) ?></p>
    <p><strong>Descrição:</strong> <?= nl2br(htmlspecialchars($produto['descricao'] ?? '')) ?></p>
    <p><strong>Data de Validade:</strong> <?= htmlspecialchars($produto['data_validade']) ?></p>
    <p><strong>Quantidade em Estoque:</strong> <?= htmlspecialchars($produto['quantidade_estoque']) ?></p>
    <p><strong>Cadastrado em:</strong> <?= htmlspecialchars($produto['criado_em']) ?></p>

    <div class="d-flex flex-column flex-sm-row gap-2 mt-3">
        <a href="editar.php?id=<?= (int)$produto['id'] ?>" class="btn btn-warning">Editar</a>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<?php require 'views/footer.php'; ?>
