<?php

    class ProdutoDAO{

        public function salvar($produto, $conn){
            try {
                $sql = "INSERT INTO 
                Produtos(nome,foto_url,quantidade,preco) 
                VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1,$produto->getNome());
                $stmt->bindValue(2,$produto->getFoto_url());
                $stmt->bindValue(3,$produto->getQuantidade());
                $stmt->bindValue(4,$produto->getPreco());
                $stmt->execute();
            }catch (PDOException $erro) {
                throw $erro;
            }catch (Exception $erro) {
                throw $erro;
            }
        }

        public function excluir($id,$conn){
            $sql = "DELETE FROM Produtos WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$id); 
            $stmt->execute();
        }

        public function buscar($conn){
            $sql = "SELECT * FROM Produtos";
            $stmt = $conn->prepare($sql);
            $stmt->execute();     
            $produtos = $stmt->fetchAll(PDO::FETCH_OBJ);
            $produtosModelo = [];
            foreach($produtos as $produto){
                $produtoModelo = new Produto();
                $produtoModelo->setId($produto->id);
                $produtoModelo->setNome($produto->nome);
                $produtoModelo->setFoto_url($produto->foto_url);
                $produtoModelo->setQuantidade($produto->quantidade);
                $produtoModelo->setPreco($produto->preco);
                array_push($produtosModelo,$produtoModelo);
            }
            return $produtosModelo;
        }
        
        public function buscarPeloId($id,$conn){
            $sql = "SELECT * FROM Produtos WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$id); 
            $stmt->execute();
            $produto = $stmt->fetchAll(PDO::FETCH_OBJ);
            $produtoModelo = new Produto();
            $produtoModelo->setId($produto[0]->id);
            $produtoModelo->setNome($produto[0]->nome);
            $produtoModelo->setFoto_url($produto[0]->foto_url);
            $produtoModelo->setQuantidade($produto[0]->quantidade);
            $produtoModelo->setPreco($produto[0]->preco);
            return $produtoModelo;
        }
        public function alterar($produto, $conn){
            $sql = "UPDATE Produtos
                SET nome = ?, quantidade = ?, preco = ?
                WHERE id = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$produto->getNome());
            $stmt->bindParam(2,$produto->getQuantidade());
            $stmt->bindParam(3,$produto->getPreco());
            $stmt->bindParam(4,$produto->getId());
            $stmt->execute();
        }
    }

?>