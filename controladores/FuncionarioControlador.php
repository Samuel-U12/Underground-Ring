<?php
    require_once "../DTOs/FuncionarioDTO.php";
    require_once "../modelos/Funcionario.php";
    require_once "../servicos/FuncionarioServico.php";
    class FuncionarioControlador{
        public function salvarFuncionario($funcionarioDTO){
            $funcionario = new Funcionario();
            $funcionario->setNome($funcionarioDTO->nome);
            $funcionario->setEmail($funcionarioDTO->email);
            $funcionario->setSenha($funcionarioDTO->senha);

            $funcionarioServico = new FuncionarioServico();
            try{
                $funcionarioServico->salvar($funcionario);
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function autenticarFuncionario($funcionarioDTO){
            //converter para modelo
            $funcionario = new funcionario();
            $funcionario->setEmail($funcionarioDTO->email);
            $funcionario->setSenha($funcionarioDTO->senha);
            $funcionarioServico = new funcionarioServico();
            try{
                $funcionario = $funcionarioServico->autenticar($funcionario);
                return $funcionario;              
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function buscarPeloIdfuncionario($funcionario){
            try {
                $funcionarioServico = new funcionarioServico();
                $funcionario = $funcionarioServico->buscarPeloId($funcionario);
                return $funcionario;
            }catch(PDOException $erro) {
                throw $erro;
            }
            catch(Exception $erro) {
                throw $erro;
            }
        }
        public function alterarfuncionario($funcionarioDTO){
            $funcionario = new funcionario();
            $funcionario->setId((int) $funcionarioDTO->id);
            $funcionario->setNome($funcionarioDTO->nome);
            $funcionario->setEmail($funcionarioDTO->email);

            $funcionarioServico = new funcionarioServico();
            try{
                $funcionarioServico->alterar($funcionario);
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
        public function excluirfuncionario($funcionarioDTO){
            $funcionario = new funcionario();
            $funcionario->setId($funcionarioDTO->id);
            
            $funcionarioServico = new funcionarioServico();
            try{
                $funcionarioServico->excluir($funcionario);
            }catch(PDOException $erro){
                throw $erro;
            }catch(Exception $erro){
                throw $erro;
            }
        }
    }
?>