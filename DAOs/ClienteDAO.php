<?php
    require_once "../modelos/cliente.php";

    class ClienteDAO{

        public function salvar($cliente,$conn){
            try{
                $sql = "INSERT INTO clientes(nome,email,senha,endereco) VALUES 
                    (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1,$cliente->getNome());
                $stmt->bindValue(2,$cliente->getEmail());
                $stmt->bindValue(3,password_hash($cliente->getSenha(),PASSWORD_DEFAULT));
                $stmt->bindValue(4,$cliente->getEndereco());
                $stmt->execute();
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }

        public function buscarPeloEmail($cliente,$conn){
            $sql = "SELECT * FROM clientes WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,$cliente->getEmail());
            $stmt->execute();
            $clienteBase = $stmt->fetch(PDO::FETCH_OBJ);
            if($clienteBase){
                //converter esse objeto para o modelo
                $clienteModelo = new cliente();
                $clienteModelo->setId($clienteBase->id);
                $clienteModelo->setEmail($clienteBase->email);
                $clienteModelo->setSenha($clienteBase->senha);
                return $clienteModelo;
            }else{
                return null;
            }            
        }
    }

?>