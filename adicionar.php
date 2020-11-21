<?php
require 'conexao.php';
require 'dao/UsuarioDaoMysql.php';

$usuarioDao = new UsuarioDaoMysql($pdo);

$nome = filter_input(INPUT_POST, 'nome');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if($nome && $email){

    $retorno = [];

    if($usuarioDao->findEmail($email) === false) {
        $novoUsuario = new Usuario();
        $novoUsuario->setNome($nome);
        $novoUsuario->setEmail($email);

        $usuarioDao->addUsuario($novoUsuario);

        $retorno["sucesso"] = true;
        $retorno["mensagem"] = "Inserida com sucesso!";

        
    } else {
        $retorno["sucesso"] = true;
        $retorno["mensagem"] = "Este e-mail já existe!";;
    }
    
} else {
    $retorno["sucesso"] = true;
    $retorno["mensagem"] = "Existem campos em branco";;
    //header("Location: index.php");
    
}

echo json_encode($retorno);