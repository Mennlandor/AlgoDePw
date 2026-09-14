<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$data_validade = $_POST['data_validade'] ?? '';
$quantidade_estoque = (int)($_POST['quantidade_estoque'] ?? 0);
$nomeImagem = $_POST['imagem_atual'] ?? null;

// Se uma nova imagem foi enviada, substitui a antiga
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
    $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

    if (in_array($extensao, $extensoesPermitidas)) {
        $novoNome = uniqid('produto_') . '.' . $extensao;
        $destino = __DIR__ . '/../uploads/' . $novoNome;
        move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);

        // Remove a imagem antiga, se existir
        if (!empty($nomeImagem) && file_exists(__DIR__ . '/../uploads/' . $nomeImagem)) {
            unlink(__DIR__ . '/../uploads/' . $nomeImagem);
        }

        $nomeImagem = $novoNome;
    }
}

if ($id <= 0 || $nome === '' || $data_validade === '' || $quantidade_estoque <= 0) {
    $_SESSION['mensagem'] = 'Preencha corretamente todos os campos obrigatórios (quantidade deve ser maior que zero).';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../editar.php?id=' . $id);
    exit;
}

$stmt = $pdo->prepare(
    'UPDATE produtos SET nome = ?, descricao = ?, data_validade = ?, quantidade_estoque = ?, imagem = ? WHERE id = ?'
);
$stmt->execute([$nome, $descricao, $data_validade, $quantidade_estoque, $nomeImagem, $id]);

$_SESSION['mensagem'] = 'Produto atualizado com sucesso!';
$_SESSION['tipo_mensagem'] = 'success';
header('Location: ../index.php');
exit;
