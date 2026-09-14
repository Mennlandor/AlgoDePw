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

<h2 class="mb-4">Editar Produto</h2>

<form action="actions/editar_action.php" method="POST" enctype="multipart/form-data" class="card-produto bg-white p-4">

    <input type="hidden" name="id" value="<?= (int)$produto['id'] ?>">
    <input type="hidden" name="imagem_atual" value="<?= htmlspecialchars($produto['imagem'] ?? '') ?>">

    <div class="mb-3">
        <label class="form-label">Nome *</label>
        <input type="text" name="nome" class="form-control" required maxlength="150"
               value="<?= htmlspecialchars($produto['nome']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Foto do Produto</label><br>
        <?php if (!empty($produto['imagem'])): ?>
            <img src="uploads/<?= htmlspecialchars($produto['imagem']) ?>" class="foto-produto-grande mb-2 d-block" alt="Foto atual">
        <?php endif; ?>
        <input type="file" name="imagem" class="form-control" accept="image/png, image/jpeg, image/webp">
        <div class="form-text">Deixe em branco para manter a foto atual.</div>
    </div>

    <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea name="descricao" class="form-control" rows="3"><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Data de Validade *</label>
        <input type="date" name="data_validade" class="form-control" required
               value="<?= htmlspecialchars($produto['data_validade']) ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Quantidade em Estoque *</label>
        <input type="number" name="quantidade_estoque" class="form-control" min="1" required
               value="<?= htmlspecialchars($produto['quantidade_estoque']) ?>">
    </div>

    <button type="submit" class="btn btn-success">Atualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>

</form>

<?php require 'views/footer.php'; ?>
