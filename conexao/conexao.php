<?php
    class Conexao{

        static public function criar(){
            $conn = new PDO("mysql:host=localhost;dbname=undergroundring",
                "root","");
            $conn->setAttribute(PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION);
            
                return $conn;
        }
    }
?>