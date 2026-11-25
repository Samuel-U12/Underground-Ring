<?php
    require_once "../DAOs/FuncionarioDAO.php";
    require_once "../conexao/Conexao.php";
    class funcionarioServico{

        public function salvar($funcionario){
            try{
                $conn = Conexao::criar();
                $funcionarioDAO = new FuncionarioDAO();
                $funcionarioDAO->salvar($funcionario,$conn);
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }

        public function autenticar($funcionario){
            try{
                $conn = Conexao::criar();
                $funcionarioDAO = new FuncionarioDAO();
                $funcionarioAutenticado = 
                    $funcionarioDAO->buscarPeloEmail($funcionario,$conn);
                if($funcionarioAutenticado != null){
                    if(password_verify($funcionario->getSenha(),
                        $funcionarioAutenticado->getSenha())){
                        return $funcionarioAutenticado;
                    } 
                } 
                throw new Exception("E-mail ou senha não conferem");                
            }catch(PDOException $erro){
                throw $erro;
            }
        }
       public function buscarPeloId($funcionario){
            try{
                $conn = Conexao::criar();
                $funcionarioDAO = new funcionarioDAO();
                $funcionarioBuscado = $funcionarioDAO->buscarPeloId($funcionario,$conn);
                return $funcionarioBuscado;
            }catch (PDOException $erro) {
                throw $erro;
            } catch (Exception $erro) {
                throw $erro;
            }
        }
        public function buscarTodos(){
            try{
                $conn = Conexao::criar();
                $funcionarioDAO = new funcionarioDAO();
                $funcionarios = $funcionarioDAO->buscar($conn);
                return $funcionarios;
            }catch (PDOException $erro) {
                throw $erro;
            } catch (Exception $erro) {
                throw $erro;
            }
        }
        public function excluir($funcionario){
            try{
                $conn = Conexao::criar();
                $funcionarioDAO = new funcionarioDAO();
                $funcionarioDAO->excluir($funcionario,$conn);
            }catch(PDOException $erro) {
                    throw $erro;
            }catch(Exception $erro) {
                throw $erro;
            }
        }
        public function alterar($funcionario){
            try{
                $conn = Conexao::criar();
                $funcionarioDAO = new funcionarioDAO();
                $funcionarioDAO->alterar($funcionario, $conn);
            } catch (PDOException $erro) {
                throw $erro;
            } catch (Exception $erro) {
                throw $erro;
            }
        }
    }

?>