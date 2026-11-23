<?php
    require_once "../DAOs/ClienteDAO.php";
    require_once "../conexao/Conexao.php";
    class ClienteServico{

        public function salvar($cliente){
            try{
                $conn = Conexao::criar();
                $clienteDAO = new ClienteDAO();
                $clienteDAO->salvar($cliente,$conn);
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }

        public function autenticar($cliente){
            try{
                $conn = Conexao::criar();
                $clienteDAO = new ClienteDAO();
                $clienteAutenticado = 
                    $clienteDAO->buscarPeloEmail($cliente,$conn);
                if($clienteAutenticado != null){
                    if(password_verify($cliente->getSenha(),
                        $clienteAutenticado->getSenha())){
                        return $clienteAutenticado;
                    } 
                } 
                throw new Exception("E-mail ou senha não conferem");                
            }catch(PDOException $erro){
                throw $erro;
            }
        }
    }

?>