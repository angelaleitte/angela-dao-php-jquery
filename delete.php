<?php
require 'conexao.php';
require 'dao/UsuarioDaoMysql.php';

$usuarioDao = new UsuarioDaoMysql($pdo);

$id = $_POST['id'];

//$id = filter_input(INPUT_GET, 'id');

if($id) {
   $usuarioDao->deleteUsuario($id);
   $retorno["sucesso"] = true;
   $retorno["mensagem"] = "Excluído";
   echo json_encode($retorno);
}

