<?php
session_start();
require '../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Busca o nome da imagem antes de excluir o registro
    $busca = $pdo->prepare('SELECT imagem FROM produtos WHERE id = ?');
    $busca->execute([$id]);
    $imagem = $busca->fetchColumn();

    $stmt = $pdo->prepare('DELETE FROM produtos WHERE id = ?');
    $stmt->execute([$id]);

    if (!empty($imagem) && file_exists(__DIR__ . '/../uploads/' . $imagem)) {
        unlink(__DIR__ . '/../uploads/' . $imagem);
    }

    $_SESSION['mensagem'] = 'Produto excluído com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'ID inválido para exclusão.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../index.php');
exit;
