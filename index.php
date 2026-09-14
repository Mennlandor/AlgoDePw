<?php
session_start();
require 'config/db.php';

$stmt = $pdo->query('SELECT * FROM produtos ORDER BY id DESC');
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'views/header.php';
?>

<h2 class="mb-4">Produtos em Estoque</h2>

<?php if (isset($_SESSION['mensagem'])): ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['tipo_mensagem']) ?>">
        <?= htmlspecialchars($_SESSION['mensagem']) ?>
    </div>
    <?php unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']); ?>
<?php endif; ?>

<a href="cadastrar.php" class="btn btn-warning text-white mb-3 w-100 w-sm-auto">+ Novo Produto</a>

<?php if (count($produtos) === 0): ?>

    <div class="alert alert-info">Nenhum produto cadastrado ainda.</div>

<?php else: ?>

    <div class="row g-4">
        <?php foreach ($produtos as $produto):
            $diasParaVencer = (strtotime($produto['data_validade']) - strtotime(date('Y-m-d'))) / 86400;

            if ($diasParaVencer < 0) {
                $corBadge = 'bg-danger';
                $textoBadge = 'Vencido';
            } elseif ($diasParaVencer <= 7) {
                $corBadge = 'bg-warning text-dark';
                $textoBadge = 'Vence em breve';
            } else {
                $corBadge = 'bg-success';
                $textoBadge = 'Em dia';
            }
        ?>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card card-produto h-100">

                    <?php if (!empty($produto['imagem'])): ?>
                        <img src="uploads/<?= htmlspecialchars($produto['imagem']) ?>" class="card-img-top foto-produto-card" alt="Foto do produto">
                    <?php else: ?>
                        <div class="sem-foto-card">sem foto</div>
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                            <h5 class="card-title mb-0"><?= htmlspecialchars($produto['nome']) ?></h5>
                            <span class="badge <?= $corBadge ?>"><?= $textoBadge ?></span>
                        </div>

                        <p class="text-muted small mb-1">Validade: <?= htmlspecialchars($produto['data_validade']) ?></p>
                        <p class="mb-3">
                            <span class="badge bg-light text-dark border">
                                 <?= htmlspecialchars($produto['quantidade_estoque']) ?> em estoque
                            </span>
                        </p>

                        <div class="mt-auto d-flex flex-column flex-sm-row gap-2">
                            <a href="visualizar.php?id=<?= (int)$produto['id'] ?>" class="btn btn-sm btn-primary flex-fill">Ver</a>
                            <a href="editar.php?id=<?= (int)$produto['id'] ?>" class="btn btn-sm btn-success flex-fill">Editar</a>
                            <a href="actions/excluir.php?id=<?= (int)$produto['id'] ?>"
                               class="btn btn-sm btn-danger flex-fill"
                               onclick="return confirm('Tem certeza que deseja excluir este produto?');">Excluir</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php endif; ?>

<?php require 'views/footer.php'; ?>
