
<?php

require_once __DIR__ . '/../DTO/ClienteDTO.php';

class Cliente
{
    private int $id;
    private string $nome;
    private string $email;
    private string $senha;
    private string $endereco;

   public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function getEndereco(){
        return $this->endereco;
    }

    public function setendereco($endereco){
        $this->endereco = $endereco;
    }
}
