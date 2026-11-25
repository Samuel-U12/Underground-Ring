<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['funcionario'])) {
    header('Location: autenticarFuncionario.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Funcionário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo ao sistema da Underground Ring</h1>
    </header>
    <main>
        <section>
            <button><a href="cadastrarProduto.html">Cadastrar Produto</a></button>
            <br><br>
            <button><a href="../controladores/rota.php?acao=buscarProduto">Ver produtos</a></button>
            <button><a href="perfilFuncionarios.html">Perfil</a></button>
            <button><a href="verTodosClientes.php">Ver Todos os clientes</a></button>
        </section>
    </main>
</body>
</html>