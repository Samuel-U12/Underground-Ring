<?php
require_once "../modelos/Produto.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$produtos = $_SESSION['produtos'] ?? [];
$ehFuncionario = isset($_SESSION['funcionario']);
$paginaInicial = $ehFuncionario ? 'homeF.php' : 'homeC.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <table style="border:1px solid">
        <tr>
            <th>Foto</th>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Preço</th>
            <?php if ($ehFuncionario): ?>
                <th>Excluir</th>
                <th>Alterar</th>
            <?php endif; ?>
        </tr>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><img height="100px" width="100px" src="<?= htmlspecialchars($produto->getFoto_url()) ?>"></td>
                <td><?= htmlspecialchars($produto->getNome()) ?></td>
                <td><?= htmlspecialchars($produto->getQuantidade()) ?></td>
                <td><?= htmlspecialchars($produto->getPreco()) ?></td>
                <?php if ($ehFuncionario): ?>
                    <td><a href="../controladores/rota.php?acao=excluirProduto&id=<?= $produto->getId() ?>">Excluir</a></td>
                    <td><a href="../controladores/rota.php?acao=buscarProdutoPorId&id=<?= $produto->getId() ?>">Alterar</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <button><a href="<?= $paginaInicial ?>">Página Inicial</a></button>
</body>
</html>