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
    }

?>