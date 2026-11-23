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
            try {
                $conn = Conexao::criar();
                $clienteDAO = new ClienteDAO();
                $clienteAutenticado = $clienteDAO->buscarPeloEmail($cliente, $conn);

                if (
                    !$clienteAutenticado ||
                    !password_verify($cliente->getSenha(), $clienteAutenticado->getSenha())
                ) {
                    throw new Exception("E-mail ou senha não conferem");
                }

                return $clienteAutenticado;
            } catch (PDOException $erro) {
                throw $erro;
            } catch (Exception $erro) {
                throw $erro;
            }
        }
    }

?>