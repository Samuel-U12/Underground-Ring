<?php
    require_once "../DAOs/ProdutoDAO.php";
    require_once "../conexao/conexao.php";
    require_once "../modelos/Produto.php";
    require_once "ImagemServico.php";
    class ProdutoServico{

        public function salvar($produto){
            try{
                $conn = Conexao::criar();
                $produtoDAO = new ProdutoDAO();
                $salvar = new imagemServico;
                $imagem = $salvar->salvarImagem($produto->getfoto());
                $produto->setFoto_url($imagem);
                $produtoDAO->salvar($produto, $conn);
            }catch(PDOException $erro) {
                throw $erro;
            }catch(Exception $erro) {
                throw $erro;
            }
        }
        public function buscar(){
            $conn = Conexao::criar();
            $produtoDAO = new ProdutoDAO();
            $produtos = $produtoDAO->buscar($conn);
            return $produtos;
        }
        public function excluir($id){
            try{
                $conn = Conexao::criar();
                $produtoDAO = new ProdutoDAO();
                $produto = $produtoDAO->buscarPeloId($id,$conn);
                $imagemServico = new imagemServico();
                $imagemServico->excluirImagem($produto);
                $produtoDAO->excluir($id,$conn);
            }catch(PDOException $erro) {
                    throw $erro;
            }catch(Exception $erro) {
                throw $erro;
            }
        }
        public function buscarPeloId($id){
            $conn = Conexao::criar();
            $produtoDAO = new ProdutoDAO();
            $produto = $produtoDAO->buscarPeloId($id,$conn);
            return $produto;
        }
        public function alterar($produto){
            $conn = Conexao::criar();
            $produtoDAO = new ProdutoDAO();
            $produtoDAO->alterar($produto, $conn);
        }
    }

?>