<?php
    require_once "../modelos/funcionario.php";

    class FuncionarioDAO{

        public function salvar($funcionario,$conn){
            try{
                $sql = "INSERT INTO funcionarios(nome,email,senha) VALUES 
                    (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1,$funcionario->getEmail());
                $stmt->bindValue(2,$funcionario->getNome());
                $stmt->bindValue(3,password_hash($funcionario->getSenha(),PASSWORD_DEFAULT));
                $stmt->execute();
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }

        public function buscarPeloEmail($funcionario,$conn){
            $sql = "SELECT * FROM funcionarios WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,$funcionario->getEmail());
            $stmt->execute();
            $funcionarioBase = $stmt->fetch(PDO::FETCH_OBJ);
            if($funcionarioBase){
                //converter esse objeto para o modelo
                $funcionarioModelo = new funcionario();
                $funcionarioModelo->setId($funcionarioBase->id);
                $funcionarioModelo->setEmail($funcionarioBase->email);
                $funcionarioModelo->setSenha($funcionarioBase->senha);
                return $funcionarioModelo;
            }else{
                return null;
            }            
        }
        public function buscarTodos($conn){
            try{
                $sql = "SELECT * FROM funcionarios";
                $stmt = $conn->prepare($sql);
                $stmt->execute();     
                $funcionarios = $stmt->fetchAll(PDO::FETCH_OBJ);
                $funcionariosModelo = [];
                foreach($funcionarios as $funcionario){
                    $funcionarioModelo = new funcionario();
                    $funcionarioModelo->setId($funcionario->id);
                    $funcionarioModelo->setNome($funcionario->nome);
                    $funcionarioModelo->setEmail($funcionario->foto_url);
                    $funcionarioModelo->setSenha($funcionario->quantidade);
                    $funcionarioModelo->setEndereco($funcionario->preco);
                    array_push($funcionariosModelo,$funcionarioModelo);
                }
                return $funcionariosModelo;
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function buscarPeloId($funcionario, $conn){
            $sql = "SELECT * FROM funcionarios WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,$funcionario->getId()); 
            $stmt->execute();
            $funcionario = $stmt->fetchAll(PDO::FETCH_OBJ);
            $funcionarioModelo = new funcionario();
            $funcionarioModelo->setId($funcionario[0]->id);
            $funcionarioModelo->setNome($funcionario[0]->nome);
            $funcionarioModelo->setEmail($funcionario[0]->email);
            $funcionarioModelo->setSenha($funcionario[0]->senha);
            return $funcionarioModelo;
        }
        public function alterar($funcionario, $conn){
            try{
                $sql = "UPDATE funcionarios
                        SET nome = ?, email = ?, senha = ?
                        WHERE id = ?";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1, $funcionario->getNome());
                $stmt->bindValue(2, $funcionario->getEmail());
                $stmt->bindValue(3, $funcionario->getSenha());
                $stmt->bindValue(4, $funcionario->getId(), PDO::PARAM_INT);
                $stmt->execute();
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function excluir($funcionario, $conn){
            $sql = "DELETE FROM funcionarios WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,$funcionario->getId()); 
            $stmt->execute();
        }
    }

?>