<?php

    class Produto{
        private $id;
        private $nome;
        private $foto_url;
        private $foto;
        private $quantidade;
        private $preco;

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

        public function getFoto_url(){
            return $this->foto_url;
        }

        public function setFoto_url($foto_url){
            $this->foto_url = $foto_url;
        }

        public function getFoto(){
           return $this->foto;
        }

        public function setFoto($foto){
            $this->foto = $foto;
        }

        public function getQuantidade(){
            return $this->quantidade;
        }

        public function setQuantidade($quantidade){
            $this->quantidade = $quantidade;
        }

        public function getPreco(){
            return $this->preco;
        }

        public function setPreco($preco){
            $this->preco = $preco;
        }
    }

?>