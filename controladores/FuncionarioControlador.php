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
        public function alterarFuncionario($funcionarioDTO){
            
        }
        public function excluirFuncionario($funcionarioDTO){

        }
    }
?>