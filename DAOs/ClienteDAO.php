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
        public function alterar($cliente, $conn){
            try{
                $sql = "UPDATE clientes
                    SET nome = ?, email = ?, senha = ?, endereco = ?
                    WHERE id = ?";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1,$cliente->getNome());
                $stmt->bindParam(2,$cliente->getEmail());
                $stmt->bindParam(3,$cliente->getSenha());
                $stmt->bindParam(4,$cliente->getEndereco());
                $stmt->bindParam(5,$cliente->getId());
                $stmt->execute();
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function excluir($cliente, $conn){
            $sql = "DELETE FROM clientes WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1,$cliente->getEmail()); 
            $stmt->execute();
        }

    }

?>