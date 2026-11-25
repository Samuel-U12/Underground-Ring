<?php
    session_start();
    if(!isset($_SESSION['cliente'])){
        header('Location:autenticarCliente.html');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo ao sistema da Underground Ring</h1>
    </header>
    <main>
        <section>
        <button><a href="../controladores/rota.php?acao=buscarProduto">Ver produtos</a></button>
        <button><a href="editarCliente.html">Editar Perfil</a></button>
        <button><a href="../controladores/rota.php?acao=excluirCliente">Excluir Perfil</a></button>
        </section>
    </main>
</body>
</html>