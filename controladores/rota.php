<?php
    require_once "../DTOs/ProdutoDTO.php";
    require_once "ProdutoControlador.php";

    $acao = $_GET['acao'];
    switch ($acao) {
        case 'salvarProduto':
        $produtoDTO = new ProdutoDTO();
        $produtoDTO->nome = $_POST['nome'] ?? '';
        $produtoDTO->quantidade = $_POST['quantidade'] ?? 0;
        $produtoDTO->preco = $_POST['preco'] ?? 0.0;
        
        // Passa o arquivo $_FILES['foto'] inteiro para o DTO
        $produtoDTO->foto = $_FILES['foto'] ?? null;

        $produtoControlador = new produtoControlador();
        try {
            $produtoControlador->salvar($produtoDTO);
        } catch(PDOException $erro) {
            echo "Erro na base de dados " . $erro->getMessage();
            exit;
        } catch(Exception $erro) {
            echo "Erro inesperado: " . $erro->getMessage();
            exit;
        }
        
        header("Location: ../telas/cadastrarProduto.html");
        break;
        case 'buscarProduto':
            $produtoControlador = new produtoControlador();
            try {
                $produtoControlador->buscar();
            }catch(PDOException $erro) {
                echo "Erro na base de dados " . $erro->getMessage();
            }
            catch(Exception $erro) {
                echo "Erro inesperado";
            }
            header('Location:../telas/mostrarProdutos.php');
            break;
        case 'excluirProduto':
            $id = $_GET['id'];
            $produtoControlador = new ProdutoControlador();
            try{
                $produtoControlador->excluir($id);
            }catch(Exception $erro){
                //redirecionar usuário página de erro
                //mostrar o erro
                echo "Erro: " . $erro->getMessage();
            }
            header('Location:rota.php?acao=buscarProduto');
            break;
        case 'buscarProdutoPorId':
            $id = $_GET['id'];
            try{
                $produtoControlador = new produtoControlador();
                $produtoControlador = $produtoControlador->buscarPeloId($id);
                header('Location:../telas/formAlterarProduto.php');
            }catch(PDOException $erro){
                echo $erro->getMessage();
            }
            break;
        case 'alterarProduto':
            $produtoDTO = new ProdutoDTO();
            $produtoDTO->id = $_POST['id'];
            $produtoDTO->nome = $_POST['nome'];
            $produtoDTO->quantidade = $_POST['quantidade'];
            $produtoDTO->preco = $_POST['preco'];
            $produtoControlador = new produtoControlador();
            try {
                $produtoControlador->alterar($produtoDTO);
                header('Location:rota.php?acao=buscarProduto');
            }catch(PDOException $erro) {
                echo "Erro na base de dados " . $erro->getMessage();
            }
            catch(Exception $erro) {
                echo "Erro inesperado";
            }
        
    }
?>