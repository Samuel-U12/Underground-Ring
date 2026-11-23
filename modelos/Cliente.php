
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

    public function getNome(){
        return $this->nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function getEndereco(){
        return $this->endereco;
    }
}
