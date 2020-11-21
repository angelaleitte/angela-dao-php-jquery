<?php

class Usuario{
    private $id;
    private $nome;
    private $email;

    function getId(){
        return $this->id;
    }

    function setId($id){
         $this->id = $id;
    }

    function getNome(){
        return $this->nome;
    }

    function setNome($n){
        $this->nome = $n;
    }

    function getEmail(){
        return $this->email;
    }

    function setEmail($e){
        $this->email = $e;
    }

}

interface UsuarioDao{
     public function addUsuario(Usuario $u);
     public function findAll();
     public function findEmail($email);
     public function findId($id);
     public function updateUsuario(Usuario $u);
     public function deleteUsuario($id);
}