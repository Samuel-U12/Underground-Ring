<?php
    require_once "../DTOs/clienteDTO.php";
    require_once "../modelos/cliente.php";
    require_once "../servicos/clienteServico.php";
    class ClienteControlador{
        public function salvarCliente($clienteDTO){
            $cliente = new Cliente();
            $cliente->setNome($clienteDTO->nome);
            $cliente->setEmail($clienteDTO->email);
            $cliente->setSenha($clienteDTO->senha);
            $cliente->setEndereco($clienteDTO->endereco);

            $clienteServico = new clienteServico();
            try{
                $clienteServico->salvar($cliente);
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function autenticarCliente($clienteDTO){
            //converter para modelo
            $cliente = new Cliente();
            $cliente->setEmail($clienteDTO->email);
            $cliente->setSenha($clienteDTO->senha);
            $clienteServico = new clienteServico();
            try{
                $cliente = $clienteServico->autenticar($cliente);
                return $cliente;              
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function buscarPeloIdCliente($cliente){
            try {
                $clienteServico = new clienteServico();
                $cliente = $clienteServico->buscarPeloId($cliente);
                return $cliente;
            }catch(PDOException $erro) {
                throw $erro;
            }
            catch(Exception $erro) {
                throw $erro;
            }
        }
        public function alterarCliente($clienteDTO){
            $cliente = new Cliente();
            $cliente->setId((int) $clienteDTO->id);
            $cliente->setNome($clienteDTO->nome);
            $cliente->setEmail($clienteDTO->email);
            $cliente->setSenha($clienteDTO->senha);
            $cliente->setEndereco($clienteDTO->endereco);

            $clienteServico = new clienteServico();
            try{
                $clienteServico->alterar($cliente);
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function excluirCliente($cliente){
            try{
                $clienteServico = new clienteServico();
                $clienteServico->excluir($cliente);
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
    }
?>