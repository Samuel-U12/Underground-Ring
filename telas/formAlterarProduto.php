<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php
        require_once "../modelos/Produto.php";
        session_start();
        $produto = $_SESSION['produto'];
        echo "<form action='../controladores/rota.php?acao=alterarProduto' method='POST' enctype='multipart/form-data'>";
        echo "<input type='hidden' name='id' value = ".$produto->getId().">";
        echo "<label>Nome:</label>";
        echo "<input type='text' name='nome' value = ".$produto->getNome()."><br>";
        echo "<label>Quantidade:</label>";
        echo "<input type='text' name='quantidade' value = ".$produto->getQuantidade()."><br>";
        echo "<label>Preço:</label>";
        echo "<input type='text' name='preco' value = ".$produto->getPreco()."><br>";
        echo "<button>Salvar</button>";
        echo "</form>";
    ?>
    
</body>
</html>