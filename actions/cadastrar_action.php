<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$data_validade = $_POST['data_validade'] ?? '';
$quantidade_estoque = (int)($_POST['quantidade_estoque'] ?? 0);

// Validação básica no servidor
if ($nome === '' || $data_validade === '' || $quantidade_estoque <= 0) {
    $_SESSION['mensagem'] = 'Preencha corretamente todos os campos obrigatórios (quantidade deve ser maior que zero).';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../cadastrar.php');
    exit;
}

// Upload da imagem (opcional)
$nomeImagem = null;
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
    $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

    if (in_array($extensao, $extensoesPermitidas)) {
        $nomeImagem = uniqid('produto_') . '.' . $extensao;
        $destino = __DIR__ . '/../uploads/' . $nomeImagem;
        move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
    }
}

$stmt = $pdo->prepare(
    'INSERT INTO produtos (nome, descricao, data_validade, quantidade_estoque, imagem) VALUES (?, ?, ?, ?, ?)'
);
$stmt->execute([$nome, $descricao, $data_validade, $quantidade_estoque, $nomeImagem]);

$_SESSION['mensagem'] = 'Produto cadastrado com sucesso!';
$_SESSION['tipo_mensagem'] = 'success';
header('Location: ../index.php');
exit;
