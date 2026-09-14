<?php require 'views/header.php'; ?>

<h2 class="mb-4">Cadastrar Produto</h2>

<form action="actions/cadastrar_action.php" method="POST" enctype="multipart/form-data" class="card-produto bg-white p-4">

    <div class="mb-3">
        <label class="form-label">Nome *</label>
        <input type="text" name="nome" class="form-control" required maxlength="150">
    </div>

    <div class="mb-3">
        <label class="form-label">Foto do Produto</label>
        <input type="file" name="imagem" class="form-control" accept="image/png, image/jpeg, image/webp">
        <div class="form-text">Opcional. Formatos aceitos: JPG, PNG ou WEBP.</div>
    </div>

    <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea name="descricao" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Data de Validade *</label>
        <input type="date" name="data_validade" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Quantidade em Estoque *</label>
        <input type="number" name="quantidade_estoque" class="form-control" min="1" required>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>

</form>

<?php require 'views/footer.php'; ?>
