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
            try{
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
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function buscarTodos($conn){
            try{
                $sql = "SELECT * FROM clientes";
                $stmt = $conn->prepare($sql);
                $stmt->execute();     
                $clientes = $stmt->fetchAll(PDO::FETCH_OBJ);
                $clientesModelo = [];
                foreach($clientes as $cliente){
                    $clienteModelo = new Cliente();
                    $clienteModelo->setId($cliente->id);
                    $clienteModelo->setNome($cliente->nome);
                    $clienteModelo->setEmail($cliente->foto_url);
                    $clienteModelo->setSenha($cliente->quantidade);
                    $clienteModelo->setEndereco($cliente->preco);
                    array_push($clientesModelo,$clienteModelo);
                }
                return $clientesModelo;
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function buscarPeloId($cliente, $conn){
            $sql = "SELECT * FROM clientes WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,$cliente->getId()); 
            $stmt->execute();
            $cliente = $stmt->fetchAll(PDO::FETCH_OBJ);
            $clienteModelo = new cliente();
            $clienteModelo->setId($cliente[0]->id);
            $clienteModelo->setNome($cliente[0]->nome);
            $clienteModelo->setEmail($cliente[0]->email);
            $clienteModelo->setSenha($cliente[0]->senha);
            $clienteModelo->setEndereco($cliente[0]->endereco);
            return $clienteModelo;
        }
        public function alterar($cliente, $conn){
            try{
                $sql = "UPDATE clientes
                        SET nome = ?, email = ?, endereco = ?
                        WHERE id = ?";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(1, $cliente->getNome());
                $stmt->bindValue(2, $cliente->getEmail());
                $stmt->bindValue(3, $cliente->getEndereco());
                $stmt->bindValue(4, $cliente->getId(), PDO::PARAM_INT);
                $stmt->execute();
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function excluir($cliente, $conn){
            $sql = "DELETE FROM clientes WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1,$cliente->getId()); 
            $stmt->execute();
        }

    }

?>