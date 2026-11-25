<?php
    require_once "../modelos/funcionario.php";

    class FuncionarioDAO{

        public function salvar($funcionario,$conn){
            try{
                $sql = "INSERT INTO funcionarios(nome,email,senha) VALUES 
                    (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1,$funcionario->getNome());
                $stmt->bindValue(2,$funcionario->getEmail());
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
                $funcionarioModelo = new Funcionario();
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
                    $funcionarioModelo = new Funcionario();
                    $funcionarioModelo->setId($funcionario->id);
                    $funcionarioModelo->setNome($funcionario->nome);
                    $funcionarioModelo->setEmail($funcionario->email);
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
            $stmt->bindValue(1,$funcionario->getId(), PDO::PARAM_INT); 
            $stmt->execute();
            $funcionarioBase = $stmt->fetch(PDO::FETCH_OBJ);
            if ($funcionarioBase) {
                $funcionarioModelo = new Funcionario();
                $funcionarioModelo->setId($funcionarioBase->id);
                $funcionarioModelo->setNome($funcionarioBase->nome);
                $funcionarioModelo->setEmail($funcionarioBase->email);
                $funcionarioModelo->setSenha($funcionarioBase->senha);
                return $funcionarioModelo;
            }
            return null;
        }

        public function alterar($funcionario, $conn){
            try {
                $senhaDigitada = $funcionario->getSenha();

                if (!empty($senhaDigitada)) {
                    $sql = "UPDATE funcionarios
                            SET nome = ?, email = ?, senha = ?
                            WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(1, $funcionario->getNome());
                    $stmt->bindValue(2, $funcionario->getEmail());
                    $stmt->bindValue(3, password_hash($senhaDigitada, PASSWORD_DEFAULT));
                    $stmt->bindValue(4, $funcionario->getId(), PDO::PARAM_INT);
                } else {
                    $sql = "UPDATE funcionarios
                            SET nome = ?, email = ?
                            WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(1, $funcionario->getNome());
                    $stmt->bindValue(2, $funcionario->getEmail());
                    $stmt->bindValue(3, $funcionario->getId(), PDO::PARAM_INT);
                }

                $stmt->execute();
            } catch (PDOException $erro) {
                throw $erro;
            } catch (Exception $erro) {
                throw $erro;
            }
        }

        public function excluir($funcionario, $conn){
            $sql = "DELETE FROM funcionarios WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,$funcionario->getId(), PDO::PARAM_INT); 
            $stmt->execute();
        }
    }
?>