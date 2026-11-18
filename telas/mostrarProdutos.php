<link rel="stylesheet" href="../css/style.css">
<table style='border:1px solid'>
    <tr >
        <th>Foto</th>
        <th>Nome</th>
        <th>Quantidade</th>
        <th>Preço</th>
    </tr>
<?php
    require_once "../modelos/Produto.php";
    session_start();
    $produtos = $_SESSION['produtos'];
    foreach($produtos as $produto){
        echo "<tr>";
        echo "<td><img heigth = 100px width = 100px src='".$produto->getFoto_url()."'></td>";
        echo "<td>".$produto->getNome()."</td>" ;
        echo "<td>".$produto->getQuantidade()."</td>";
        echo "<td>".$produto->getPreco()."</td>";
        echo "<td><a href='../controladores/rota.php?acao=excluirProduto&id=".$produto->getId()."'>Excluir</a></td>";
        echo "<td><a href='../controladores/rota.php?acao=buscarProdutoPorId&id=".$produto->getId()."'>Alterar</a></td>";
        echo "</tr>";
    }       
?>
 </table>
 <button><a href='../index.html'>Pagina Inicial</a></button>