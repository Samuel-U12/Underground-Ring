<?php
    require_once "../DTOs/ProdutoDTO.php";
    require_once "../modelos/Produto.php";
    require_once "../servicos/ProdutoServico.php";
    class ProdutoControlador{
        public function salvar($produtoDTO){
            $produto = new Produto();
            $produto->setNome($produtoDTO->nome);
            $produto->setFoto($produtoDTO->foto);
            $produto->setQuantidade($produtoDTO->quantidade);
            $produto->setPreco($produtoDTO->preco);

            $produtoServico = new ProdutoServico();
            try {
                $produtoServico->salvar($produto);
            }catch(PDOException $erro) {
                throw $erro;
            }
            catch(Exception $erro) {
                throw $erro;
            }
        }
        public function buscar(){
            try{
                $produtoServico = new ProdutoServico();
                $produtos = $produtoServico->buscar();
                session_start();
                $_SESSION['produtos'] = $produtos; 
                
            }catch(PDOException $erro){
                echo $erro->getMessage();
            }
        }
        public function excluir($id){
            try {
                $produtoServico = new ProdutoServico();
                $produtoServico->excluir($id); 
            }catch(PDOException $erro) {
                throw $erro;
            }
            catch(Exception $erro) {
                throw $erro;
            }
        }
        public function buscarPeloId($id){
            try {
                $produtoServico = new ProdutoServico();
                $produto = $produtoServico->buscarPeloId($id);
                session_start();
                $_SESSION['produto'] = $produto;
            }catch(PDOException $erro) {
                throw $erro;
            }
            catch(Exception $erro) {
                throw $erro;
            }
        }
        public function alterar($produtoDTO){
            $produto = new Produto();
            $produto->setId($produtoDTO->id);
            $produto->setNome($produtoDTO->nome);
            $produto->setQuantidade($produtoDTO->quantidade);
            $produto->setPreco($produtoDTO->preco);

            $produtoServico = new ProdutoServico();
            try {
                $produtoServico->alterar($produto);
            }catch(PDOException $erro) {
                throw $erro;
            }
            catch(Exception $erro) {
                throw $erro;
            }
        }
    }
?>