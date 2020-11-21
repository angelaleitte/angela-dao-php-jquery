<?php
        require_once "conexao.php";
        require_once "dao/UsuarioDaoMysql.php";

        $usuarioDao = new UsuarioDaoMysql($pdo);

        $id = $_POST['id'];
        $name = $_POST['nome'];
        $email = $_POST['email'];


        $retorno = array();


        if($id && $name && $email) {
            $usuario = new Usuario();
            $usuario->setId($id);
            $usuario->setNome($name);
            $usuario->setEmail($email);
        
            $usuarioDao->updateUsuario($usuario);

             

          
                $retorno["sucesso"] = true;
                $retorno["mensagem"] = "Alterado com sucesso!";
                echo json_encode($retorno);

     
            
        } else {
            $retorno["sucesso"] = false;
            $retorno["mensagem"] = "Existem campos em branco.";
            echo json_encode($retorno);
        }

        


        
       
 
?>